<?php
	if ( ! class_exists( 'r4w_background_process' ) ) {
		/**
		 * R4W Processus d'arrière-plan
		 */
		abstract class r4w_background_process extends r4w_async_request {

			protected $start_time = 0;
			protected $cron_hook_identifier;
			protected $cron_interval_identifier;

			/**
			 * Lancer un nouveau processus d'arrière-plan
			 */
			public function __construct() {
				parent::__construct();

				$this->cron_hook_identifier     = $this->identifier . '_cron';
				$this->cron_interval_identifier = $this->identifier . '_cron_interval';

				add_action( $this->cron_hook_identifier, array( $this, 'handle_cron_healthcheck' ) );
				add_filter( 'cron_schedules', array( $this, 'schedule_cron_healthcheck' ) );
			}

			/**
			 * Envoi
			 */
			public function dispatch() {
				// Planifiez le bilan de santé cron.
				$this->schedule_event();
				// Effectuer un post à distance.
				return parent::dispatch();
			}

			/**
			 * Envoie la file d'attente
			 */
			public function push_to_queue( $data ) {
				$this->data[] = $data;

				return $this;
			}

			/**
			 * Enregistrer la file d'attente
			 */
			public function save() {
				$key = $this->generate_key();

				if ( ! empty( $this->data ) ) {
					update_site_option( $key, $this->data );
				}

				return $this;
			}

			/**
			 * Mise à jour de la file d'attente
			 */
			public function update( $key, $data ) {
				if ( ! empty( $data ) ) {
					update_site_option( $key, $data );
				}

				return $this;
			}

			/**
			 * Supprimer la file d'attente
			 */
			public function delete( $key ) {
				delete_site_option( $key );

				return $this;
			}

			/**
			 * Génère une clé unique basée sur microtime. 
			 * Les éléments de file d'attente reçoivent une clé unique,
			 * afin de pouvoir être fusionnés lors de l'enregistrement.
			 */
			protected function generate_key( $length = 64 ) {
				$unique  = md5( microtime() . rand() );
				$prepend = $this->identifier . '_batch_';

				return substr( $prepend . $unique, 0, $length );
			}

			/**
			 * Traiter la file d'attente ?!
			 * Vérifie si des données existent dans la file d'attente et que
			 * le processus n'est pas déjà en cours d'exécution.
			 */
			public function maybe_handle() {
				// Ne verrouillez pas d'autres demandes pendant le traitement
				session_write_close();

				if ( $this->is_process_running() ) {
					// Background process already running.
					wp_die();
				}

				if ( $this->is_queue_empty() ) {
					// Aucune donnée à traiter.
					wp_die();
				}

				check_ajax_referer( $this->identifier, 'nonce' );

				$this->handle();

				wp_die();
			}

			/**
			 * La file d'attente est-elle vide
			 */
			protected function is_queue_empty() {
				global $wpdb;

				$table  = $wpdb->options;
				$column = 'option_name';

				if ( is_multisite() ) {
					$table  = $wpdb->sitemeta;
					$column = 'meta_key';
				}

				$key = $wpdb->esc_like( $this->identifier . '_batch_' ) . '%';

				$count = $wpdb->get_var( $wpdb->prepare( "
				SELECT COUNT(*)
				FROM {$table}
				WHERE {$column} LIKE %s
			", $key ) );

				return ( $count > 0 ) ? false : true;
			}

			/**
			 * Le processus est en cours d'exécution
			 * Vérifier si le processus en cours est déjà en cours d'exécution
			 * dans un processus d'arrière-plan.
			 */
			protected function is_process_running() {
				if ( get_site_transient( $this->identifier . '_process_lock' ) ) {
					// Processus déjà en cours d'exécution.
					return true;
				}

				return false;
			}

			/**
			 * Processus de verrouillage
			 * Verrouillez le processus afin que plusieurs instances ne puissent pas s'exécuter simultanément.
			 * Remplacez le cas échéant, mais la durée doit être supérieure à celle définie dans la méthode time_exceeded ().
			 */
			protected function lock_process() {
				$this->start_time = time(); // Définir l'heure de début du processus en cours.

				$lock_duration = ( property_exists( $this, 'queue_lock_time' ) ) ? $this->queue_lock_time : 60; // 1 minute
				$lock_duration = apply_filters( $this->identifier . '_queue_lock_time', $lock_duration );

				set_site_transient( $this->identifier . '_process_lock', microtime(), $lock_duration );
			}

			/**
			 * Débloquer le processus
			 * Déverrouillez le processus afin que d'autres instances puissent apparaître.
			 */
			protected function unlock_process() {
				delete_site_transient( $this->identifier . '_process_lock' );

				return $this;
			}

			/**
			 * Obtenir le lot
			 */
			protected function get_batch() {
				global $wpdb;

				$table        = $wpdb->options;
				$column       = 'option_name';
				$key_column   = 'option_id';
				$value_column = 'option_value';

				if ( is_multisite() ) {
					$table        = $wpdb->sitemeta;
					$column       = 'meta_key';
					$key_column   = 'meta_id';
					$value_column = 'meta_value';
				}

				$key = $wpdb->esc_like( $this->identifier . '_batch_' ) . '%';

				$query = $wpdb->get_row( $wpdb->prepare( "
				SELECT *
				FROM {$table}
				WHERE {$column} LIKE %s
				ORDER BY {$key_column} ASC
				LIMIT 1
			", $key ) );

				$batch       = new stdClass();
				$batch->key  = $query->$column;
				$batch->data = maybe_unserialize( $query->$value_column );

				return $batch;
			}

			/**
			 * Manipuler ?!
			 * Transférez chaque élément de la file d'attente au gestionnaire de tâches 
			 * tout en respectant les contraintes de mémoire et de temps du serveur.
			 */
			protected function handle() {
				$this->lock_process();

				do {
					$batch = $this->get_batch();

					foreach ( $batch->data as $key => $value ) {
						$task = $this->task( $value );

						if ( false !== $task ) {
							$batch->data[ $key ] = $task;
						} else {
							unset( $batch->data[ $key ] );
						}

						if ( $this->time_exceeded() || $this->memory_exceeded() ) {
							// Limites de lot atteintes.
							break;
						}
					}

					// Mettre à jour ou supprimer le lot actuel.
					if ( ! empty( $batch->data ) ) {
						$this->update( $batch->key, $batch->data );
					} else {
						$this->delete( $batch->key );
					}
				} while ( ! $this->time_exceeded() && ! $this->memory_exceeded() && ! $this->is_queue_empty() );

				$this->unlock_process();

				// Commencer le prochain lot ou terminer le processus.
				if ( ! $this->is_queue_empty() ) {
					$this->dispatch();
				} else {
					$this->complete();
				}

				wp_die();
			}

			/**
			 * Mémoire dépassée
			 * Assure que le traitement par lots ne dépasse jamais 90%
			 * de la mémoire maximale de WordPress.
			 */
			protected function memory_exceeded() {
				$memory_limit   = $this->get_memory_limit() * 0.9; // 90% of max memory
				$current_memory = memory_get_usage( true );
				$return         = false;

				if ( $current_memory >= $memory_limit ) {
					$return = true;
				}

				return apply_filters( $this->identifier . '_memory_exceeded', $return );
			}

			/**
			 * Obtenir la limite de mémoire
			 */
			protected function get_memory_limit() {
				if ( function_exists( 'ini_get' ) ) {
					$memory_limit = ini_get( 'memory_limit' );
				} else {
					// Sensible default.
					$memory_limit = '128M';
				}

				if ( ! $memory_limit || -1 === intval( $memory_limit ) ) {
					// Unlimited, set to 32GB.
					$memory_limit = '32000M';
				}

				return intval( $memory_limit ) * 1024 * 1024;
			}

			/**
			 * Temps écoulé.
			 * Assure que le lot ne dépasse jamais une limite de temps raisonnable.
			 */
			protected function time_exceeded() {
				$finish = $this->start_time + apply_filters( $this->identifier . '_default_time_limit', 20 ); // 20 seconds
				$return = false;

				if ( time() >= $finish ) {
					$return = true;
				}

				return apply_filters( $this->identifier . '_time_exceeded', $return );
			}

			/**
			 * Achevée.
			 * Remplacez le cas échéant, mais assurez-vous que les actions ci-dessous sont
			 * effectué, ou appelez parent::complete().
			 */
			protected function complete() {
				// Annuler la planification du bilan de santé cron.
				$this->clear_scheduled_event();
			}

			/**
			 * Programme de contrôle de santé cron
			 */
			public function schedule_cron_healthcheck( $schedules ) {
				$interval = apply_filters( $this->identifier . '_cron_interval', 5 );

				if ( property_exists( $this, 'cron_interval' ) ) {
					$interval = apply_filters( $this->identifier . '_cron_interval', $this->cron_interval );
				}

				// Ajoute toutes les 5 minutes aux horaires existants.
				$schedules[ $this->identifier . '_cron_interval' ] = array(
					'interval' => MINUTE_IN_SECONDS * $interval,
					'display'  => sprintf( __( 'Every %d Minutes' ), $interval ),
				);

				return $schedules;
			}

			/**
			 * Gérer le bilan de santé cron
			 * Redémarrez le processus en arrière-plan s'il n'est pas déjà en cours d'exécution et que des données existent dans la file d'attente.
			 */
			public function handle_cron_healthcheck() {
				if ( $this->is_process_running() ) {
					// Le processus d'arrière-plan est déjà en cours d'exécution.
					exit;
				}

				if ( $this->is_queue_empty() ) {
					// Aucune donnée à traiter.
					$this->clear_scheduled_event();
					exit;
				}

				$this->handle();

				exit;
			}

			/**
			 * Calendrier de l'événement
			 */
			protected function schedule_event() {
				if ( ! wp_next_scheduled( $this->cron_hook_identifier ) ) {
					wp_schedule_event( time(), $this->cron_interval_identifier, $this->cron_hook_identifier );
				}
			}

			/**
			 * Effacer l'événement programmé
			 */
			protected function clear_scheduled_event() {
				$timestamp = wp_next_scheduled( $this->cron_hook_identifier );

				if ( $timestamp ) {
					wp_unschedule_event( $timestamp, $this->cron_hook_identifier );
				}
			}

			/**
			 * Annuler le processus
			 * Arrêtez le traitement des éléments de la file d'attente, effacez le travail cron et supprimez le lot.
			 */
			public function cancel_process() {
				if ( ! $this->is_queue_empty() ) {
					$batch = $this->get_batch();
					$this->delete( $batch->key );
					wp_clear_scheduled_hook( $this->cron_hook_identifier );
				}

			}

			/**
			 * Tâche
			 * Remplacez cette méthode pour effectuer les actions requises sur chaque élément de la file d'attente. 
			 * Renvoie l'élément modifié pour un traitement ultérieur lors du passage suivant. 
			 * Ou retournez false pour supprimer l'élément de la file d'attente.
			 */
			abstract protected function task( $item );

		}
	}