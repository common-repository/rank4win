<?php
	/**
	 * Verification de santé du plugin
	 */
		function r4w_health_check(){
			global $wpdb;

			// Verifie que les base de donnés existe
			$missing_database = false;
			$missing_insert = false;

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			if($wpdb->get_var("show tables like '{$wp_table_app}'") != $wp_table_app)
			{
				$missing_database = true;
				$missing_insert = true;
			}else{
				$wp_select = "SELECT * from ".$wp_table_app;
				$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
				if(empty($r4w_app['wizard'])){
					r4w_delect_base();
					r4w_create_base();
					r4w_insert_table();
					wp_redirect(get_admin_url('','admin.php?page=r4w_wizard'));
					exit;
				}
			}

			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			if($wpdb->get_var("show tables like '{$wp_table_document}'") != $wp_table_document)
			{
				$missing_database = true;
			}

			$wp_table_taxonomy = $wpdb->prefix.r4w_bdd_table_taxonomy;
			if($wpdb->get_var("show tables like '{$wp_table_taxonomy}'") != $wp_table_taxonomy)
			{
				$missing_database = true;
			}

			$wp_table_process = $wpdb->prefix.r4w_bdd_table_process;
			if($wpdb->get_var("show tables like '{$wp_table_process}'") != $wp_table_process)
			{
				$missing_database = true;
			}

			if($missing_database){
				r4w_create_base();
			}

			if($missing_insert){
				r4w_insert_table();
			}

			/**
			 * Vérification et création de colonnes manquante
			 * Mise à jour > 0.9.7
			 */
			$wp_column_deploy = 'deploy';
			if( !in_array( $wp_column_deploy, $wpdb->get_col( "DESC " . $wp_table_document, 0 ) ) ){
				$result= $wpdb->query(
					"ALTER TABLE $wp_table_document ADD $wp_column_deploy VARCHAR(255) CHARACTER SET utf8 AFTER overallscore"
				);
			}

			/**
			 * Vérification et création de colonnes manquante
			 * Mise à jour > 1.0.2
			 */
			 $wp_column_deploy_data = 'deploy_data';
			 if( !in_array( $wp_column_deploy_data, $wpdb->get_col( "DESC " . $wp_table_document, 0 ) ) ){
				 $result= $wpdb->query(
					 "ALTER TABLE $wp_table_document ADD $wp_column_deploy_data LONGTEXT CHARACTER SET utf8 AFTER deploy"
				 );
			 }
			 $wp_column_keywords = 'keywords';
			 if(  in_array( $wp_column_keywords, $wpdb->get_col( "DESC " . $wp_table_document, 0 ) ) ){
				 $result= $wpdb->query(
					 "ALTER TABLE $wp_table_document DROP $wp_column_keywords"
				 );
			 }
		}
		add_filter( 'init', 'r4w_health_check' );

		/**
		 * Message de d'avertissement lors d'un déploiement en cours
		 */
		function r4w_warning_deploy(){
			global $wpdb,$pagenow;
			$wp_table_process = $wpdb->prefix.r4w_bdd_table_process;
			if ( $pagenow == 'edit.php' OR $pagenow == 'post.php') {
				$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_process} WHERE request = %s",'deploy');
				$r4w_process_progress = $wpdb->get_row($wp_select,ARRAY_A);
				if(!empty($r4w_process_progress)){
					echo '<div id="r4w_warning_deploy"><div class="css-fde540fe5rtg"><div class="css-fv505rhujik"><span class="css-f5g0r5grghrh">'.r4w_assets_svg_code('rank4win_bar').'</span>'.__('Your structure is being deployed, please wait until the end of the deployment before modifying your pages', 'app_rank4win').'.</div><div class="css-fd6ed6fefegf"><svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0"  viewBox="0 0 128 128" xml:space="preserve"><g transform="rotate(190.153 64 64)"><path d="M109.25 55.5h-36l12-12a29.54 29.54 0 0 0-49.53 12H18.75A46.04 46.04 0 0 1 96.9 31.84l12.35-12.34v36zm-90.5 17h36l-12 12a29.54 29.54 0 0 0 49.53-12h16.97A46.04 46.04 0 0 1 31.1 96.16L18.74 108.5v-36z"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1200ms" repeatCount="indefinite"/></g></svg></div></div></div><script type="text/javascript">r4w_process_deploy();</script>';
				}
			}
		}
		add_action('admin_notices', 'r4w_warning_deploy');

		/**
		 * Message de d'avertissement lors d'un déploiement en cours
		 */
		 function r4w_warning_subscription(){
			global $wpdb,$pagenow;
			$display = false;
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/account",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl_feature = r4w_curl_request($curl_data);
			if($curl_feature['info']['http_code'] == 200){
				if($curl_feature['resp']['success']['account']['subscription'] == true AND $curl_feature['resp']['success']['account']['sync_subscription'] == false){
					$display = true;
				}
			}
			
			if (!empty($_GET['page'])){
				if(!empty($_GET['tab'])){
					if($_GET['page'] == 'r4w_account' AND $_GET['tab'] == 'wordpress'){
						$display = false;
					}
				}
				if($_GET['page'] == 'r4w_auth_login'){
					$display = false;
				}
				if($_GET['page'] == 'r4w_wizard'){
					$display = false;
				}
			}
			if($display){
				echo '<div id="r4w_warning_subscription"><div class="css-fde540fe5rtg"><div class="css-fv505rhujik"><span class="css-f5g0r5grghrh">'.r4w_assets_svg_code('rank4win_bar').'</span><div class="css-392756e6a92">'.__('This WordPress is not associated with your subscription! To take advantage of all the options and benefits of your subscription', 'app_rank4win').'.</div></div><a class="css-4506c5f99ecd" href="'.get_admin_url('','admin.php?page=r4w_account&tab=wordpress').'">'.__('please, click here', 'app_rank4win').'</a></div></div>';
			}
		}
		add_action('admin_notices', 'r4w_warning_subscription');

	/**
	  * Chargement des defines
	  */
		add_filter( 'init', 'r4w_define' );
		$r4w_define = r4w_define();
		global $r4w_define;

	/**
	 * Récupération de la version du plugin
	 */
		function r4w_get_version() {
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			if ( function_exists( 'get_plugin_data' ) ) {
		  	$plugin_data = get_plugin_data( r4w_plugin_file  );
		  	$plugin_version = $plugin_data['Version'];
			}
			if(!empty($plugin_version)){
				$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET version = %s WHERE id = %d", $plugin_version, 1));
				return $plugin_version;
			}else{
				$wp_select = "SELECT * from ".$wp_table_app;
				$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
				return $r4w_app['version'];
			}
		}

	/**
	 * Récupération des scripts, fonctions, librairies est feuilles de styles
	 */
		function r4w_hook_enqueue( $hook ) {
			global $wpdb;

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

		    	$wp_select = "SELECT * from ".$wp_table_app;
		    	$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

		    	if(!empty($r4w_app['settings']) AND ctype_xdigit($r4w_app['settings'])){
				$wp_setting = json_decode(hex2bin($r4w_app['settings']),true);
			}
			
			/**
			 * Affiche la langue du wordpress
			 */
			 wp_register_script( 'r4w-lang-wp', '' );
			 wp_enqueue_script( 'r4w-lang-wp' );
			 wp_add_inline_script( 'r4w-lang-wp', 'var r4w_wp_lang = "'.get_bloginfo("language").'";' );


			/**
			 * Affiche le soutien en direct
			 */
			if(isset($wp_setting['general_setting']['support']['chat']) AND $wp_setting['general_setting']['support']['chat'] == 'on'){
				wp_register_script( 'r4w-support-live', '' );
				wp_enqueue_script( 'r4w-support-live' );
				wp_add_inline_script( 'r4w-support-live', 'jQuery(document).ready(function(){jQuery( \'body\' ).append( \'<a id="r4w_support" href="https://join.skype.com/invite/ea0wSiTNKDqa" target="_blank"><div class="r4w_supp_launcher">'.r4w_assets_svg_code('puce_support').'</div></a> \');});' );
			}

			/**
			 * Affichage d'un avertissement dans l'inspecter
			 */
			$clog_cr = '\n';
		 	$clog_1 = __('Rank4Win: could we help you', 'app_rank4win' );
			$clog_2 = __('We notice that you may need help, if this is a mistake then we wish you a pleasant day', 'app_rank4win');
			$clog_3 = __('Any modification by mistake or intentional will be detected by our teams, we reserve the right to close any account that we deem suspicious without any warning or refund', 'app_rank4win');
			wp_register_script( 'r4w-console', '' );
 			wp_enqueue_script( 'r4w-console' );
 			wp_add_inline_script( 'r4w-console', "console.log(\"%c".$clog_1." ?\"+\"%c".$clog_cr."\"+\"%c".$clog_2.". ".$clog_3.".\",'font-size: 24px;background:#FA6742;color:#fff;padding:5px 5px;','','font-size: 14px;background:#444;color:#fff;padding:5px;');" );

			/**
			 * Récupération de la médiathèque WP
			 */
			wp_enqueue_media();
			if(isset($_GET['page'])){
				if($_GET['page']=='r4w_subscription' OR $_GET['page']=='r4w_tools' OR $_GET['page']=='r4w_editor' OR $_GET['page']=='r4w_account'){
					/**
					 * Charge l'intention de paiement api dans les paramètres
					 */
					wp_enqueue_script( md5('stripe_v3'), 'https://js.stripe.com/v3/', true );
				}
			}

			/**
			 * Charge les librairies javascript
			 */
			if(isset($_GET['page'])){
				if($_GET['page']=='r4w_editor'){
					/**
					 * Charge le jquery ui autocomplete
					 */
					wp_enqueue_script('jquery-ui-autocomplete', '', array('jquery-ui-widget', 'jquery-ui-position'), '1.8.6');
				}
			}
			foreach (glob(r4w_plugin_folder."/assets/js/lib/lib.*.js") as $file_name) {
			    if (is_file($file_name)) {
			    	if(stripos(strtolower(basename($file_name)),'jquery-core') !== false){
			        	wp_enqueue_script( md5(basename($file_name)), r4w_plugin_url .'assets/js/lib/'. basename($file_name), array( 'jquery-core' ), md5(r4w_get_version()), true );
			        }else{
			        	wp_enqueue_script( md5(basename($file_name)), r4w_plugin_url .'assets/js/lib/'. basename($file_name), array(), md5(r4w_get_version()), true );
			        }
			    }
			}
			if(isset($_GET['page'])){
				if($_GET['page']=='r4w_editor'){
					$r4w_translation_javascript = r4w_fcnt_locale("editor");
					wp_enqueue_script( md5('r4w_editor_js'), r4w_api_url_base.r4w_get_version().r4w_api_url_request.'/wp/assets/ecdc59ba2460468c/js/', array( 'jquery-core' ), md5(r4w_get_version()), true );
					wp_localize_script( md5('r4w_editor_js'), 'r4w_editor_vars', array(
		                    'url_admin'     => admin_url(),
		                    'url_plugin'    => plugin_dir_url( __FILE__ ),
		                    'path_plugin'   => __FILE__,
		                    'host_wp'       =>  site_url(),
		                    'external_ws'   => r4w_api_url_base.r4w_get_version().r4w_api_url_request,
		                    'ajax'          => admin_url( 'admin-ajax.php' ),
		                    'ajax_security'  => wp_create_nonce( 'r4w-security-nonce' ),
	                		)
					  );
					  wp_localize_script( md5(basename("r4w_editor_js")), 'localize_editor', $r4w_translation_javascript);
				}
			}

			/**
			 * Charge les functions javascript
			 */
			foreach (glob(r4w_plugin_folder."/assets/js/fcnt/fcnt.*.js") as $file_name) {
			    if (is_file($file_name)) {
			    	if(stripos(strtolower(basename($file_name)),'jquery-core') !== false){
						$exp_file_name = explode('.js', basename($file_name));
						$r4w_file_name = str_replace('.', '_', $exp_file_name[0]);
						$r4w_translation_javascript = r4w_fcnt_locale($r4w_file_name);

						wp_register_script( md5(basename($file_name)), r4w_plugin_url .'assets/js/fcnt/'. basename($file_name),array( 'jquery-core' ), '1.0.0', true);
						wp_localize_script( md5(basename($file_name)), 'localize_'.$r4w_file_name, $r4w_translation_javascript);
						wp_enqueue_script( md5(basename($file_name)) );
			       	}else{
						$exp_file_name = explode('.js', basename($file_name));
						$r4w_file_name = str_replace('.', '_', $exp_file_name[0]);
						$r4w_translation_javascript = r4w_fcnt_locale($r4w_file_name);

						wp_register_script( md5(basename($file_name)), r4w_plugin_url .'assets/js/fcnt/'. basename($file_name));
						wp_localize_script( md5(basename($file_name)), 'localize_'.$r4w_file_name, $r4w_translation_javascript);
						wp_enqueue_script( md5(basename($file_name)) );
			       	}
			    }
			}

			/**
			 * Charge les librairies stylesheet
			 */
			foreach (glob(r4w_plugin_folder."/assets/css/lib/lib.*.css") as $file_name) {
			    if (is_file($file_name)) {
			    	 wp_enqueue_style( md5(basename($file_name)), r4w_plugin_url .'assets/css/lib/'. basename($file_name), array(), md5(r4w_get_version()));
			    }
			}
			if(isset($_GET['page'])){
				if($_GET['page']=='r4w_editor'){
					 wp_enqueue_style( md5('r4w_editor_css'), r4w_api_url_base.r4w_get_version().r4w_api_url_request.'/wp/assets/ecdc59ba2460468c/css/', array(), md5(r4w_get_version()));
				}
			}
			/**
			 * Ajoute les stylesheet indispensable
		 	*/
		    $files_name = [
		        'stylesheet.css'
		    ];
		    foreach ($files_name as $file_name) {
		        wp_enqueue_style( md5(basename($file_name)), r4w_plugin_url .'assets/css/'. basename($file_name),array(), md5(r4w_get_version()));
		    }

		    $glob_tpl = glob(r4w_plugin_folder."/tpl/*/style.css");

			/**
			 * Charge le stylesheet des templates
			 */
		    foreach ($glob_tpl as $r4w_folder) {
		    	preg_match('#tpl/(.*?)/style.css#', $r4w_folder, $matches);
				wp_enqueue_style( md5($r4w_folder.'/style.css'), r4w_plugin_url .'tpl/'.$matches[1].'/style.css', array(), md5(r4w_get_version()));
		    }
		}
		add_action( 'admin_enqueue_scripts', 'r4w_hook_enqueue' );

		function box_open_setting_cloud( $hook ) {
			echo '<script type="text/javascript">jQuery(document).ready(function(){jQuery("#r4w_box-cloud").modal();});</script>';
		}
		add_action( 'admin_enqueue_scripts', 'box_open_setting_cloud' ); 
		

	/**
	 * Récupération feuilles de styles pour l'éditeur
	 */
		function r4w_hook_editor( $hook ) {
			return ', ' . r4w_plugin_url.'assets/css/editor.css';
		}
		add_filter( 'mce_css', 'r4w_hook_editor' );

	/**
	 * Supprime les balise rajouter par rank4win dans le contenu lors de la sauvegarde
	 */
		function r4w_remove_tag_content( $data , $postarr ) {
		    $data['post_content'] = addslashes(preg_replace('/<span class=\"r4w_mark_info\"(.*?)<\/span>/i', '', stripslashes($data['post_content'])));
		    return $data;
		}
		add_filter( 'wp_insert_post_data' , 'r4w_remove_tag_content' , '99', 2 );

	/**
	 * Activation du plugin
	 */
		function r4w_activation( $network_wide ) {
			global $wpdb;
		    	if ( is_multisite() && $network_wide ) {
			     $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
		        	foreach ( $blog_ids as $blog_id ) {
		            	switch_to_blog( $blog_id );
		            	r4w_create_base();
		            	restore_current_blog();
			     }
			} else {
				r4w_create_base();
			}
		    r4w_insert_table();
		    add_option('r4w_activation_redirect', true);
		}
		register_activation_hook( r4w_plugin_file, 'r4w_activation' );

		/**
		 * Permet de rechercher et de désactiver certaine extention [Disabled]
		 */
		function r4w_disabled_ext(){
			$active_plugins = get_option('active_plugins');
			// Ext : WP Writup
			$r4w_search = array_search('wp-writup/wpwritup.php',$active_plugins);
			if($r4w_search){
				unset($active_plugins[$r4w_search]);
				update_option('active_plugins',$active_plugins);
			}
		}

		function r4w_activation_redirect(){
			if (get_option('r4w_activation_redirect', false)) {
			    delete_option('r4w_activation_redirect');
			    if(!isset($_GET['activate-multi']))
			    {
			        wp_redirect(get_admin_url('','admin.php?page=r4w_wizard'));
			        exit;
			    }
			 }
		}
		add_action( 'admin_init', 'r4w_activation_redirect' );

		function r4w_create_base(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
		    	if($wpdb->get_var("show tables like '{$wp_table_app}'") != $wp_table_app)
		    	{
		        	$req_sql = "CREATE TABLE " . $wp_table_app . " (`id` mediumint(9) NOT NULL AUTO_INCREMENT, `uuid` VARCHAR(225), `wp_activation` VARCHAR(225), `oauth` LONGTEXT, `oauth_tmp`  LONGTEXT, `settings` LONGTEXT,  `wizard` LONGTEXT, `last_backup` VARCHAR(225), `version` TEXT, `hash` VARCHAR(225), UNIQUE KEY id (id));";
		        	$wpdb->query($req_sql);
		    	}

		    	$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
		    	if($wpdb->get_var("show tables like '{$wp_table_document}'") != $wp_table_document)
		    	{
		        	$req_sql = "CREATE TABLE " . $wp_table_document . " (`id` mediumint(9) NOT NULL AUTO_INCREMENT, `uuid` VARCHAR(225), `post_id` bigint(20), `locale_uuid` VARCHAR(225), `timecode` int(11), `request` LONGTEXT, `data` LONGTEXT, `keywords` LONGTEXT, `links` LONGTEXT, `overallscore` VARCHAR(3),`config` LONGTEXT, `locked` CHAR(1), `hash_param` VARCHAR(64), UNIQUE KEY id (id));";
		        	$wpdb->query($req_sql);
		    	}

			$wp_table_taxonomy = $wpdb->prefix.r4w_bdd_table_taxonomy;
		    	if($wpdb->get_var("show tables like '{$wp_table_taxonomy}'") != $wp_table_taxonomy)
		    	{
		        	$req_sql = "CREATE TABLE " . $wp_table_taxonomy . " (`id` mediumint(9) NOT NULL AUTO_INCREMENT, `uuid` VARCHAR(225), `term_id` bigint(20), `config` LONGTEXT, `hash_param` VARCHAR(64), UNIQUE KEY id (id));";
		        	$wpdb->query($req_sql);
		    	}

		    	$wp_table_process = $wpdb->prefix.r4w_bdd_table_process;
		    	if($wpdb->get_var("show tables like '{$wp_table_process}'") != $wp_table_process)
		    	{
		        	$req_sql = "CREATE TABLE " . $wp_table_process . " (`id` mediumint(9) NOT NULL AUTO_INCREMENT, `uuid` VARCHAR(225), `request` TEXT, `data` LONGTEXT, `hash` VARCHAR(225), UNIQUE KEY id (id));";
		        	$wpdb->query($req_sql);
		    	}
		}

		function r4w_insert_table(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wpdb->query($wpdb->prepare("INSERT INTO $wp_table_app (uuid) VALUES(%s)", array(r4w_fcnt_uuid())));

			/**
			 * Ajout de la configuration par defaut
			 */

			$file_default = r4w_plugin_base.'/_inc/default.r4w';
			if(file_exists($file_default)){
				$r4w_default = file_get_contents($file_default);
				if(!empty($r4w_default)){
					$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET settings = %s WHERE id = %d", $r4w_default, 1));
				}
			}

			if ( function_exists( 'get_plugin_data' ) ) {
	            	$plugin_data = get_plugin_data( r4w_plugin_file  );
	            	$plugin_version = $plugin_data['Version'];
        		}

    			if(!empty($plugin_version)){
				$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET version = %s WHERE id = %d", $plugin_version, 1));
			}

			$start_wizard = bin2hex(json_encode([
				"step" => 1
			]));

			$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET wizard = %s WHERE id = %d", $start_wizard, 1));
		}

	/**
	 * Désactivation du plugin
	 */
		function r4w_desactivation() {
			global $wpdb;
		    	if ( is_multisite() && $network_wide ) {
		        	$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
		        	foreach ( $blog_ids as $blog_id ) {
		            	switch_to_blog( $blog_id );
		            	r4w_delect_base();
		            	restore_current_blog();
		        	}
		    	} else {
		        r4w_delect_base();
		    	}
		}
		register_deactivation_hook ( r4w_plugin_file, 'r4w_desactivation' );

		function r4w_delect_base(){
			global $wpdb;

			/**
			 * Supprime la base de donnée app
			 */
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
		    	$req_sql = "DROP TABLE IF EXISTS " . $wp_table_app. ";";
		    	$wpdb->query($req_sql);

		    /**
		     * Supprime la base de donnée process
		     */
			$wp_table_process = $wpdb->prefix.r4w_bdd_table_process;
		    	$req_sql = "DROP TABLE IF EXISTS " . $wp_table_process. ";";
		    	$wpdb->query($req_sql);
		}

	/**
	 * Récupération des fonctionnalités de l'utilisateur
	 */
		function r4w_user_feature(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
			if(!empty($r4w_app['settings'])){
		    		$r4w_settings =  json_decode(hex2bin($r4w_app['settings']),true);
		    	}

			if(isset($r4w_settings['general_setting']['feature']['counter_links']) AND $r4w_settings['general_setting']['feature']['counter_links']=='on'){

				$curl_data = [
					"request_method" => "GET",
					"url" => "/wp/user/feature/",
					"auth" => "true",
					"postfileds" => [
						"json_encode" => true,
						"data" => [
							"features" => [
								"generalsettings_counterlinks",
								"generalsettings_permalinks",
								"generalsettings_support"
							]
						]
					]
				];
				$curl_feature = r4w_curl_request($curl_data);
				if($curl_feature['info']['http_code'] == 200){
					$r4w_setting_update = false;
					if(!empty($curl_feature['resp']['success']['features'])){
						
						foreach ($curl_feature['resp']['success']['features'] as $resp_feature => $resp_result) {
							switch ($resp_feature) {
								case 'generalsettings_counterlinks':
									if($resp_result == "false" or empty($resp_result)){
										$r4w_settings['general_setting']['feature']['counter_links'] = "off";
										$r4w_setting_update = true;
									}
									break;
								case 'generalsettings_permalinks':
									if($resp_result == "false" or empty($resp_result)){
										$r4w_settings['general_setting']['parmalinks']['remove_homepage'] = "off";
										$r4w_setting_update = true;
									}
									break;
								case 'generalsettings_support':
									if($resp_result == "false" or empty($resp_result)){
										$r4w_settings['general_setting']['support']['chat'] = "off";
										$r4w_setting_update = true;
									}
									break;
							}
						}
					}
					if($r4w_setting_update){
						$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET settings = %s WHERE id = %d", bin2hex(json_encode($r4w_settings)), 1));
						$curl_data = [
							"request_method" => "PUT",
							"url" => "/wp/config/",
							"auth" => "true",
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"wp_setting" => $r4w_settings
								]
							]
						];
						r4w_curl_request($curl_data);
					}
				}
			}
		}
		add_action( 'admin_init', 'r4w_user_feature' );

	/**
	 * Action lors de la sauvegarde d'un post
	 */
		function r4w_save_document(){
			global $wpdb;
			if(!empty($_POST['post_ID'])){
				$post_id = $_POST['post_ID'];
		    		$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
		    		$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$post_id);

				$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);
				if(empty($r4w_document['uuid'])){
					r4w_new_document('document',$post_id);
				}
				preg_match_all('/<a href="(.*?)"/s', stripslashes($_POST['content']), $match);
				foreach ($match[1] as $url) {
					$postid_url = url_to_postid($url);
					if(isset($postid_url) and $postid_url != 0){
						$link_internal[] = $postid_url;
					}
				}
				if(!isset($link_internal)){
					$link_internal = [];
				}
				$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET links = %s WHERE post_id = %d", bin2hex(json_encode($link_internal)), $post_id));
			}
		}
		foreach ($r4w_define['app']['post_types'] as $r4w_post_type) {
		    add_action( 'save_'.$r4w_post_type['slug'] , 'r4w_save_document', 10, 3 );
		}

	/**
	 * Action lors de la suppresion d'un post
	 */
		function r4w_remove_document_with_post( $post_id ){
	    		global $wpdb;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			$wpdb->query( $wpdb->prepare( "DELETE FROM $wp_table_document WHERE post_id = %d", $post_id));
		}
		foreach ($r4w_define['app']['post_types'] as $r4w_post_type) {
		    add_action( 'before_delete_'.$r4w_post_type['slug'] , 'r4w_remove_document_with_post', 10);
		}

	/**
	 * Liens dans la pages extensions
	 */
		function r4w_plugin_action_links( $links, $file ) {
		    // Lien vers la configuration du plugin
		    array_unshift( $links, '<a href="' . admin_url( 'admin.php?page=r4w_settings' ) . '">' . __( 'Settings' ) . '</a>' );
		    return $links;
		}
	    add_filter( 'plugin_action_links_'.r4w_plugin_file, 'r4w_plugin_action_links', 10, 2 );

	/**
	 * 	Declanche la vérification d'authentification
	 */
		function r4w_page_oauth() {
			global $r4w_define;
			if(isset($_GET['page'])){
				$screen = $_GET['page'];
				if(in_array($screen, $r4w_define['app']['wordpress_oauth'], true)){
					$wp_oauth = r4w_wordpress_oauth();
					$info = $wp_oauth['info'];
					$resp = $wp_oauth['resp'];
					if($info['http_code'] == 301){
						wp_redirect(get_admin_url('','admin.php?page=r4w_auth_login'));
			    		exit;
					}
					if($info['http_code'] == 500){
						//
					}
					if($info['http_code'] == 401){
						if($resp['error']['name'] == 'bad_wp_token'){
							wp_redirect(get_admin_url('','admin.php?page=r4w_auth_login'));
			    			exit;
						}
					}
					if($info['http_code'] == 402){
						if($resp['error']['name'] == 'payment_required'){
							header('location:/account/subscription/');
							exit;
						}
					}
					if($info['http_code'] == 200){
						if(!$resp['success']['associated']){
							wp_redirect(get_admin_url('','admin.php?page=r4w_auth_wordpress'));
			    			exit;
						}
					}
				}
			}
		}
		add_action( 'admin_init', 'r4w_page_oauth' );

	/**
	 * Verrouillage d'un document
	 */
		function r4w_document_locking($a){
			global $wpdb;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			$wp_update = $wpdb->query($wpdb->prepare("UPDATE ".$wp_table_document." SET locked=%d WHERE uuid=%s",1,$a));
		}

	/**
	 * Réinitialise un document
	 */
		function r4w_document_reset($a){
			global $wpdb;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			$wp_update = $wpdb->query($wpdb->prepare("UPDATE ".$wp_table_document." SET timecode=%s, request=%s, data=%s, overallscore=%s, hash_param=%s WHERE uuid=%s",'','','','','',$a));
		}

	/**
	 * Gestion des metas box pour les taxonomy
	 */
		function r4w_boxes_taxonomy(){
			global $wpdb;
			$taxonomies = get_taxonomies( array( 'public' => true ), "names" );
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
		    	$wp_select = "SELECT * from ".$wp_table_app;
		    	$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_app['settings'])){
		    		$r4w_settings =  json_decode(hex2bin($r4w_app['settings']),true);
		    	}

			$display_boxe = false;

			if(isset($_GET['taxonomy']) AND isset($taxonomies)){
				$term_taxonomy = $_GET['taxonomy'];
				foreach( $taxonomies as $tax ){
					if ($tax == $term_taxonomy) {
			           $display_boxe = true;
			        }
				}
			}

			if($display_boxe AND isset($r4w_settings['general_setting']['language'])){
				$wp_oauth = r4w_wordpress_oauth();
				$info = $wp_oauth['info'];
				$resp = $wp_oauth['resp'];
				if($info['http_code'] == 200){
					if($resp['success']['associated']){
						add_action( $term_taxonomy . "_edit_form", 'r4w_callback_box_page', 10,3, 'taxonomy' );
					}
				}
			}
		}
		add_action( 'admin_init', 'r4w_boxes_taxonomy' );

	/**
	 * Gestion des metas box pour les type de contenue
	 */
		function r4w_boxes_page(){
			global $pagenow, $wpdb, $r4w_define;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_app['settings'])){
				$r4w_settings =  json_decode(hex2bin($r4w_app['settings']),true);
			}

			$display_boxe = false;

			if(!empty($_GET['post'])){
				$post_id = $_GET['post'];
				$post_type = get_post_type($_GET['post']);
			}else{
				if($pagenow == "post-new.php"){
					if(isset($_GET['post_type'])){
						$post_type = $_GET['post_type'];
					}else{
						$post_type = "post";
					}
				}
			}

			if(!empty($post_type) AND !empty($r4w_define['app']['post_types'])){
				foreach ($r4w_define['app']['post_types'] as $r4w_post_type) {
			       if ($r4w_post_type['slug'] == $post_type) {
			           $display_boxe = true;
			       }
	  			}
			}

			if($display_boxe AND isset($r4w_settings['general_setting']['language'])){
				$wp_oauth = r4w_wordpress_oauth();
				$info = $wp_oauth['info'];
				$resp = $wp_oauth['resp'];
				if($info['http_code'] == 200){
					if($resp['success']['associated']){
						global $wpdb;
						global $post;
						if(isset($post_id)){
					    		$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
					    		$wp_select = "SELECT * from ".$wp_table_document." WHERE post_id=";
							$wp_result = $wpdb->get_row(
							    $wpdb->prepare(
							        "SELECT * FROM {$wp_table_document} WHERE post_id = %d",
							        $post_id
							    ),ARRAY_A
							);
							if(isset($r4w_settings['general_setting']['parmalinks']['remove_homepage']) AND $r4w_settings['general_setting']['parmalinks']['remove_homepage']=='on'){
								add_action( 'edit_form_before_permalink', function() { r4w_callback("box_permalink"); } );
							}
							if(empty($wp_result["hash_param"])){
								add_action( 'add_meta_boxes', 'r4w_box_page', $post_type );
								if(isset($r4w_settings['general_setting']['analysis'][$post_type]) AND $r4w_settings['general_setting']['analysis'][$post_type]=='on'){
									add_action( 'add_meta_boxes', function($post_type) { r4w_box_keywords($post_type,'show'); } );
								}
							}else{
								if(isset($r4w_settings['general_setting']['analysis'][$post_type]) AND $r4w_settings['general_setting']['analysis'][$post_type]=='on'){
									add_action( 'add_meta_boxes', function($post_type) { r4w_box_keywords($post_type, 'hidden'); } );
								}
								add_action( 'add_meta_boxes', 'r4w_box_page', $post_type );
	 							if(isset($r4w_settings['general_setting']['analysis'][$post_type]) AND $r4w_settings['general_setting']['analysis'][$post_type]=='on'){
	 								add_action( 'add_meta_boxes', 'r4w_box_analyzes',$post_type );
	 								add_action( 'edit_form_top', function() { r4w_callback("box_title"); } );
									add_action( 'edit_form_after_title', function() { r4w_callback("box_overall"); } );
									add_action( 'edit_form_after_editor', function() { r4w_callback("box_answer"); } );
									add_action( 'edit_form_after_editor', function() { r4w_callback("box_semantic"); } );
									add_action( 'edit_form_after_editor', function() { r4w_callback("box_synonymous"); } );
									add_filter( 'tiny_mce_before_init', 'r4w_tinymce_init' );

	 							}
							}
						}else{
							if(isset($r4w_settings['general_setting']['analysis'][$post_type]) AND $r4w_settings['general_setting']['analysis'][$post_type]=='on'){
								add_action( 'add_meta_boxes', function($post_type) { r4w_box_keywords($post_type,'show'); } );
							}
						}
					}
				}
				if($info['http_code'] == 401){
					if($resp['error']['name'] == 'bad_version'){
						add_action( 'admin_notices', 'r4w_notice_update' );
					}
				}
			}
		}
		add_action( 'admin_init', 'r4w_boxes_page' );

	/**
	 * Box Analyzes
	 */
		function r4w_box_analyzes( $post_type ){
			add_meta_box(
			    'bb3a1009-ccd2-42cf-bc4b-6c9575c23a0f',
			    '<img src="'.r4w_plugin_url.'assets/svg/rank4win_box.svg'.'">',
				function() { r4w_callback("box_analyzes"); },
			    $post_type,
			    'side',
			    'high'
			);
		}

	/**
	 * Box page
	 */
		function r4w_box_page( $post_type ){
			add_meta_box(
			    'vd25a3ac-3562-4b4d-8e4f-808f26cc4120',
			    '<img src="'.r4w_plugin_url.'assets/svg/rank4win_box.svg'.'">',
				'r4w_callback_box_page',
			    $post_type,
			    'normal',
			    'high'
			);
		}
		function r4w_callback_box_page( $data, $box){
			$arr = [
				"folder" => "box_page",
				"data" => $data,
				"callback_box" => $box
			];
			echo r4w_tpl($arr);
		}

	/**
	 * Box Keywords
	 */
		function r4w_box_keywords( $post_type, $view ){
			add_meta_box(
			    'bafe3a29-9c24-4562-94f0-133376d853e2',
			    '<img src="'.r4w_plugin_url.'assets/svg/rank4win_box.svg'.'">',
				function() { r4w_callback("box_keywords"); },
			    $post_type,
			    'side',
			    'high'
			);
			if($view == 'hidden'){
				function add_metabox_classes($classes) {
					array_push($classes,'r4w_hidden');
					return $classes;
				}
				add_filter('postbox_classes_'.$post_type.'_bafe3a29-9c24-4562-94f0-133376d853e2','add_metabox_classes');
			}
		}

	/**
	 * Appel une fonction quand le text change dans l'éditeur Tinymce
	 */
		function r4w_tinymce_init( $init ) {
		    $init['setup'] = "function( ed ) { ed.onChange.add( function( ed, e ) { r4w_analyzes( 'wp_content' ,e , 'tinymce' ); }); }";
		    return $init;
		}

	/**
	 * Ajouter des colonnes (post/page)
	 */
		function r4w_add_column( $columns, $post_type = null) {
			if(empty($post_type))
			{
				$post_type = 'page';
			}

			global $wpdb,$r4w_define;

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_app['settings'])){
				$r4w_settings =  json_decode(hex2bin($r4w_app['settings']),true);
			}

			if(isset($r4w_settings['general_setting']['feature']['counter_links']) AND $r4w_settings['general_setting']['feature']['counter_links']=='on'){
				$columns = array_merge( $columns, [ 'counterlinks' => __( 'Internal links', 'app_rank4win' ) ] );
			}

			if(isset($r4w_settings['general_setting']['analysis'][$post_type]) AND $r4w_settings['general_setting']['analysis'][$post_type]=='on'){
				$columns = array_merge( $columns , [ 'overall_score' => __( 'Overall score', 'app_rank4win' ) ] );
			}
			return $columns;
		}
		foreach ($r4w_define['app']['post_types'] as $r4w_post_type) {
			add_filter( 'manage_'.$r4w_post_type['column'].'_columns' , 'r4w_add_column', 10, 2, $r4w_post_type['slug'] );
		}

	/**
	 * Page admin
	 */
		// Création du routage des pages
	    	function r4w_adm_menu() {
	        	add_menu_page(
		        	'Rank4Win : '.__( 'My account', 'app_rank4win' ),
		        	'Rank4Win',
		        	'administrator',
		        	'r4w_account',
		        	function() { r4w_callback("account"); },
		        	r4w_plugin_url.'assets/svg/4ofr4w.svg'
	    		);
		    	add_submenu_page(
		        	'r4w_account',
		        	'Rank4Win : '.__( 'My account', 'app_rank4win' ),
		        	'1) '.__( 'My account', 'app_rank4win' ),
		        	'administrator',
		        	'r4w_account'
		    	);
	    		add_submenu_page(
		        	'r4w_account',
		        	'Rank4Win : '.__( 'Settings', 'app_rank4win' ),
		        	'2) '.__( 'Settings', 'app_rank4win' ),
		        	'administrator',
		        	'r4w_settings',
		        	function() { r4w_callback("settings"); }
		    	);
			add_submenu_page(
		        	'r4w_account',
		        	'Rank4Win : '.__( 'Structures', 'app_rank4win' ),
		        	'3) '.__( 'Structures', 'app_rank4win' ),
		        	'administrator',
		        	'r4w_tools',
		        	function() { r4w_callback("tools"); }
		    	);
	    		add_submenu_page(
		        	'r4w_account',
		        	'Rank4Win : '.__( 'Positions & Analyses', 'app_rank4win' ),
		        	'4) '.__( 'Positions & Analyses', 'app_rank4win' ),
		        	'administrator',
		        	'r4w_analysis',
		        	function() { r4w_callback("analysis"); }
		    	);
		    	add_submenu_page(
		        	'Rank4Win',
		        	'Rank4Win : '.__( 'Editor', 'app_rank4win' ),
		        	'hidden',
		        	'administrator',
		        	'r4w_editor',
		        	function() { r4w_callback("editor"); }
		    	);
		    	add_submenu_page(
		        	'Rank4Win',
		        	'Rank4Win : '.__( 'Login', 'app_rank4win' ),
		        	'hidden',
		        	'administrator',
		        	'r4w_auth_login',
		        	function() { r4w_callback("auth_login"); }
		    	);
		    	add_submenu_page(
		        	'Rank4Win',
		        	'Rank4Win : '.__( 'Subscription', 'app_rank4win' ),
		        	'hidden',
		        	'administrator',
		        	'r4w_subscription',
		        	function() { r4w_callback("subscription"); }
		    	);
		    	add_submenu_page(
		        	'Rank4Win',
		        	'Rank4Win : '.__( 'Forgot', 'app_rank4win' ),
		        	'hidden',
		        	'administrator',
		        	'r4w_auth_forgot',
		        	function() { r4w_callback("auth_forgot"); }
		    	);
		    	add_submenu_page(
		        	'Rank4Win',
		        	'Rank4Win : '.__( 'Register', 'app_rank4win' ),
		        	'hidden',
		        	'administrator',
		        	'r4w_auth_register',
		        	function() { r4w_callback("auth_register"); }
		    	);
		    	add_submenu_page(
		        	'Rank4Win',
		        	'Rank4Win : '.__( 'One-time password authentication', 'app_rank4win' ),
		        	'hidden',
		        	'administrator',
		        	'r4w_auth_otp',
		        	function() { r4w_callback("auth_otp"); }
		    	);
		    	add_submenu_page(
		        	'Rank4Win',
		        	'Rank4Win : '.__( 'Associate Wordpress', 'app_rank4win' ),
		        	'hidden',
		        	'administrator',
		        	'r4w_auth_wordpress',
		        	function() { r4w_callback("auth_wordpress"); }
		    	);
		    	add_submenu_page(
		        	'Rank4Win',
		        	'Rank4Win : '.__( 'Update available', 'app_rank4win' ),
		        	'hidden',
		        	'administrator',
		        	'r4w_update_available',
		        	function() { r4w_callback("update_available"); }
		    	);
		    	add_submenu_page(
		        	'Rank4Win',
		        	'Rank4Win : '.__( 'Export Configuration', 'app_rank4win' ),
		        	'hidden',
		        	'administrator',
		        	'r4w_export_configuration',
			    'r4w_callback_export_configuration'
		    	);
		    	add_submenu_page(
		        	'Rank4Win',
		        	'Rank4Win : '.__( 'Retrieve the image of the structure', 'app_rank4win' ),
		        	'hidden',
		        	'administrator',
		        	'r4w_download_str_image',
		        	'r4w_callback_download_str_image'
		    	);
		    	add_submenu_page(
		        	'Rank4Win',
		        	'Rank4Win : '.__( 'Your invoice in pdf format', 'app_rank4win' ),
		        	'hidden',
		        	'administrator',
		        	'r4w_download_invoice',
		        	'r4w_callback_download_invoice'
		    	);
		    	add_submenu_page(
	        		'Rank4Win',
		        	'Rank4Win : '.__( 'Configuration of rank4win', 'app_rank4win' ),
		        	'hidden',
		        	'administrator',
		        	'r4w_wizard',
		        	function() { r4w_callback("wizard"); }
		    	);

		}
		add_action( 'admin_menu', 'r4w_adm_menu' );

		// Récupère le template de la page
		function r4w_callback($a) {
			$arr = [
				"folder" => $a
			];
			echo r4w_tpl($arr);
		}

		// PAGE : Export configuration
		function r4w_callback_export_configuration(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

		    	if(!empty($_GET['hash']) AND $_GET['hash'] == $r4w_app['hash']){
				$filename = 'config_'.$r4w_app['hash'].'.r4w';
				$target_dir = r4w_plugin_base.'/temp/';
				$content = $r4w_app['settings'];

				if (!file_exists($target_dir)) {
					mkdir($target_dir, 0777, true);
				}
				if (file_put_contents($target_dir.$filename, $content) !== false) {
					$wp_update = $wpdb->query($wpdb->prepare("UPDATE ".$wp_table_app." SET hash='' WHERE id=%s",1));
					header("Pragma: public");
					header("Expires: 0");
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					header("Content-Type: application/octet-stream");
					header("Content-Disposition: attachment; filename=$filename");
					header("Content-Transfer-Encoding: binary");
					header("Content-Length: ".filesize($target_dir.$filename));
					while (ob_get_level()) {
						ob_end_clean();
						@readfile($target_dir.$filename);
					}
					unlink($target_dir.$filename);
				}
				die();
			}else{
				header('location:'.admin_url());
			}
		}

		// PAGE : Télécharge l'image de la structure
		function r4w_callback_download_str_image(){
			$filename = 'structure_'.$_GET['hash'].'.jpeg';
			$target_dir = r4w_plugin_base.'/temp/';
			if(!empty($_GET['hash']) AND file_exists($target_dir.$filename)){
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-Type: image/jpeg");
				header("Content-Disposition: attachment; filename=$filename");
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($target_dir.$filename));
				while (ob_get_level()) {
					ob_end_clean();
					@readfile($target_dir.$filename);
				}
				unlink($target_dir.$filename);
				die();
			}else{
				header('location:'.get_admin_url('','admin.php?page=r4w_tools'));
			}
		}

		// PAGE : Télécharge la facture au format pdf
		function r4w_callback_download_invoice(){
			$filename = 'invoice_'.$_GET['invoice_id'].'.pdf';
			$target_dir = r4w_plugin_base.'/temp/';
			if(!empty($_GET['invoice_id']) AND file_exists($target_dir.$filename)){
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-Type: application/pdf");
				header("Content-Disposition: attachment; filename=$filename");
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($target_dir.$filename));
				while (ob_get_level()) {
					ob_end_clean();
					@readfile($target_dir.$filename);
				}
				unlink($target_dir.$filename);
				die();
			}else{
				header('location:'.get_admin_url('','admin.php?page=r4w_account&tab=invoice'));
			}
		}

		// PAGE : Va chercher le template pour les colonnes
		function r4w_callback_custom_column( $column_name, $post_id ) {
				global $r4w_define;
				switch($column_name){
					case 'counterlinks':
						$arr = [
							"folder" => "columns_counter_links",
							"post_id" => $post_id
						];
						echo r4w_tpl($arr);
					break;
					case 'overall_score':
						$arr = [
							"folder" => "columns_overall_score",
							"post_id" => $post_id
						];
						echo r4w_tpl($arr);
					break;
					default:
					break;
				}
			}
			foreach ($r4w_define['app']['post_types'] as $r4w_post_type) {
		    		add_action( 'manage_'.$r4w_post_type['column'].'_custom_column' , 'r4w_callback_custom_column', 10, 2);
			}

	/**
	 * Ajout un filtre dans les colonnes
	 */
		function r4w_column_sorts_score(){
			global $pagenow, $wpdb, $r4w_define;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_app['settings'])){
				$r4w_settings =  json_decode(hex2bin($r4w_app['settings']),true);
			}

			$display_boxe = false;

			if(isset($_GET['post_type'])){
				$post_type = $_GET['post_type'];
			}else{
				$post_type = "post";
			}

			if(!empty($post_type) AND !empty($r4w_define['app']['post_types'])){
				foreach ($r4w_define['app']['post_types'] as $r4w_post_type) {
			       if ($r4w_post_type['slug'] == $post_type) {
			           $display_boxe = true;
			       }
	  			}
			}

			if ($display_boxe){
				$values = [
					'' => __('Overall score', 'app_rank4win'). ' : ' . __( 'All', 'app_rank4win' ),
					'any' => __('Overall score', 'app_rank4win'). ' : ' . __( 'Any', 'app_rank4win' ),
					'poor' => __('Overall score', 'app_rank4win'). ' : ' . __( 'Poor', 'app_rank4win' ),
					'good' => __('Overall score', 'app_rank4win'). ' : ' . __( 'Good', 'app_rank4win' ),
					'perfect' => __('Overall score', 'app_rank4win'). ' : ' . __( 'Perfect', 'app_rank4win' ),
				];
				?>
				<select name="r4w_overallscore">
				<?php
					$current_v = isset($_GET['r4w_overallscore'])? $_GET['r4w_overallscore']:'';
					foreach ($values as $value => $label) {
						printf
							(
								'<option value="%s"%s>%s</option>',
								$value,
								$value == $current_v? ' selected="selected"':'',
								$label
							);
						}
				?>
				</select>
				<?php
			}
		}
		add_action( 'restrict_manage_posts', 'r4w_column_sorts_score' );

	/**
	 * Gestion du filtre dans les colonnes
	 */
		function r4w_callback_sorts( $query ) {
			global $pagenow, $wpdb, $r4w_define;
			$display_boxe = false;

			if(isset($_GET['post_type'])){
				$post_type = $_GET['post_type'];
			}else{
				$post_type = "post";
			}

			if(!empty($post_type) AND !empty($r4w_define['app']['post_types'])){
				foreach ($r4w_define['app']['post_types'] as $r4w_post_type) {
					if ($r4w_post_type['slug'] == $post_type) {
					 	$display_boxe = true;
					}
				}
			}

		    	if ($display_boxe && is_admin() && $pagenow=='edit.php' && isset($_GET['r4w_overallscore']) && $_GET['r4w_overallscore'] != '') {
			    	$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			    	switch ($_GET['r4w_overallscore']) {
			    		case 'any':
			    			$wp_result = $wpdb->get_results("SELECT * FROM {$wp_table_document} WHERE overallscore != '' ",ARRAY_A);
					    	$post_in_id = [];

						if(!empty($wp_result)){
							foreach ($wp_result as $document) {
								$post_in_id[] = $document['post_id'];
							}
						}

					     $query->set( 'post__not_in', $post_in_id );
					     return $query;
			    		break;
			    		case 'poor':
			    			$r4w_os_a = 0;
			    			$r4w_os_b = 39;
			    			$wp_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE overallscore BETWEEN %d AND %d",$r4w_os_a, $r4w_os_b),ARRAY_A);
					    	$post_in_id = [];

						if(!empty($wp_result)){
							foreach ($wp_result as $document) {
								$post_in_id[] = $document['post_id'];
							}
						}

						$query->set( 'post__in', $post_in_id );
					     return $query;
			    		break;
			    		case 'mediocre':
			    			$r4w_os_a = 40;
			    			$r4w_os_b = 59;
			    			$wp_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE overallscore BETWEEN %d AND %d",$r4w_os_a, $r4w_os_b),ARRAY_A);
			    			$post_in_id = [];

						if(!empty($wp_result)){
							foreach ($wp_result as $document) {
								$post_in_id[] = $document['post_id'];
							}
						}

						$query->set( 'post__in', $post_in_id );
						return $query;
			    		break;
			    		case 'good':
			    			$r4w_os_a = 60;
			    			$r4w_os_b = 79;
			    			$wp_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE overallscore BETWEEN %d AND %d",$r4w_os_a, $r4w_os_b),ARRAY_A);
			    			$post_in_id = [];

						if(!empty($wp_result)){
							foreach ($wp_result as $document) {
								$post_in_id[] = $document['post_id'];
							}
						}

						$query->set( 'post__in', $post_in_id );
						return $query;
			    		break;
			    		case 'perfect':
			    			$r4w_os_a = 80;
			    			$r4w_os_b = 100;
			    			$wp_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE overallscore BETWEEN %d AND %d",$r4w_os_a, $r4w_os_b),ARRAY_A);
			    			$post_in_id = [];

						if(!empty($wp_result)){
							foreach ($wp_result as $document) {
								$post_in_id[] = $document['post_id'];
							}
						}

						$query->set( 'post__in', $post_in_id );
						return $query;
			    		break;
		    		}
		   	}
		}
		foreach ($r4w_define['app']['post_types'] as $r4w_post_type) {
		    add_action( 'pre_get_'.$r4w_post_type['column'] , 'r4w_callback_sorts', 10, 2);
		}

	/**
	 * Information "notice"
	 */
		function r4w_notice_auth() {
			global $wpdb, $r4w_define;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_app['settings'])){
				$r4w_settings =  json_decode(hex2bin($r4w_app['settings']),true);
		    	}

		    	if(!$r4w_app['oauth']){
				if(!in_array(get_current_screen()->id, $r4w_define['app']['exempt_message'], true)){
					echo '<div id="r4w_notice_auth" class="notice notice-warning"><div><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 451.74 451.74" xml:space="preserve"><path style="fill:#E24C4B;" d="M446.324,367.381L262.857,41.692c-15.644-28.444-58.311-28.444-73.956,0L5.435,367.381 c-15.644,28.444,4.267,64,36.978,64h365.511C442.057,429.959,461.968,395.825,446.324,367.381z"></path><path style="fill:#FFFFFF;" d="M225.879,63.025l183.467,325.689H42.413L225.879,63.025L225.879,63.025z"></path><g> <path style="fill:#3F4448" d="M196.013,212.359l11.378,75.378c1.422,8.533,8.533,15.644,18.489,15.644l0,0 c8.533,0,17.067-7.111,18.489-15.644l11.378-75.378c2.844-18.489-11.378-34.133-29.867-34.133l0,0 C207.39,178.225,194.59,193.87,196.013,212.359z" data-original="#3F4448" class="active-path"></path><circle style="fill:#3F4448" cx="225.879" cy="336.092" r="17.067" class="active-path"></circle></svg></div><div class="r4w_message"><div>'.__( 'Rank4Win is not functional, you must first make some settings', 'app_rank4win' ).'</div><div><a href="'.get_admin_url('','admin.php?page=r4w_settings').'">'.__( 'Now configure rank4win', 'app_rank4win' ).'</a></div></div></div>';
				}
			}else{
				if(!isset($r4w_settings['general_setting']['language']) AND !in_array(get_current_screen()->id, $r4w_define['app']['exempt_message'], true)){
					echo '<div id="r4w_notice_auth" class="notice notice-warning"><div><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 451.74 451.74" xml:space="preserve"><path style="fill:#E24C4B;" d="M446.324,367.381L262.857,41.692c-15.644-28.444-58.311-28.444-73.956,0L5.435,367.381 c-15.644,28.444,4.267,64,36.978,64h365.511C442.057,429.959,461.968,395.825,446.324,367.381z"></path><path style="fill:#FFFFFF;" d="M225.879,63.025l183.467,325.689H42.413L225.879,63.025L225.879,63.025z"></path><g> <path style="fill:#3F4448" d="M196.013,212.359l11.378,75.378c1.422,8.533,8.533,15.644,18.489,15.644l0,0 c8.533,0,17.067-7.111,18.489-15.644l11.378-75.378c2.844-18.489-11.378-34.133-29.867-34.133l0,0 C207.39,178.225,194.59,193.87,196.013,212.359z" data-original="#3F4448" class="active-path"></path><circle style="fill:#3F4448" cx="225.879" cy="336.092" r="17.067" class="active-path"></circle></svg></div><div class="r4w_message"><div>'.__( 'Rank4Win : You must choose the language and country of your essays in the settings', 'app_rank4win' ).'</div><div><a href="'.get_admin_url('','admin.php?page=r4w_settings').'">'.__( 'Now configure rank4win', 'app_rank4win' ).'</a></div></div></div>';
				}
			}
		}
		add_action( 'admin_notices', 'r4w_notice_auth' );

		function r4w_notice_update() {
			echo '<div id="r4w_notice_update" class="notice notice-warning"><div>'.r4w_assets_svg_code('rank4win_black').'</div><div class="r4w_message"><div>'.__( 'Update is required to access the features', 'app_rank4win' ).'. <a href="'.get_admin_url('','plugins.php?plugin_status=upgrade').'">'.__( 'Update now', 'app_rank4win' ).'</a></div></div></div>';
		}

	/**
	 * Remplace les balaises wp par rank4win
	 */
		 function remove_redundant_shortlink() {
		 	remove_action('wp_head', 'wp_shortlink_wp_head', 10);
		 	remove_action('wp_head', 'rel_canonical', 10);
		 }
		 add_filter('after_setup_theme', 'remove_redundant_shortlink');

	/**
	 * Ajoute les balises metas dans les pages
	 */
		function r4w_html_meta_tags(){
			remove_action( 'wp_head', 'noindex', 1 );
			r4w_callback('html_meta_tags');
		}
		add_action( 'wp_head', 'r4w_html_meta_tags', -1 );

	/**
	 * Change la balise title
	 */
		function r4w_html_meta_title( $title ){
			$arr = [
				"folder" => "html_meta_title"
			];
		  return r4w_tpl($arr);
		}
		add_filter( 'pre_get_document_title', 'r4w_html_meta_title', 50 );

	/**
	 * Création / Mise à jour du fichier sitemap.xml
	 */
		function r4w_create_sitemap() {
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_app['settings'])){
				$r4w_settings =  json_decode(hex2bin($r4w_app['settings']),true);
			}

		    	if(!empty($r4w_settings['general_setting']['feature']['xml_sitemaps']) AND $r4w_settings['general_setting']['feature']['xml_sitemaps']=='on'){
				$postsForSitemap = get_posts(array(
				    'numberposts' => -1,
				    'orderby' => 'modified',
				    'post_type'  => array( 'post', 'page' ),
				    'order'    => 'DESC'
				));

				$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
				$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

				foreach( $postsForSitemap as $wp_post ) {
					setup_postdata( $wp_post );
					$sitemap .= '<url>'.
					'<loc>' . get_permalink( $wp_post->ID ) . '</loc>' .
					'<lastmod>' . date(DATE_W3C, strtotime($wp_post->post_modified)) . '</lastmod>' .
					'<changefreq>monthly</changefreq>' .
					'</url>';
				}

				$sitemap .= '</urlset>';
				$fp = fopen( ABSPATH . 'sitemap.xml', 'w' );
				fwrite( $fp, $sitemap );
				fclose( $fp );
		   	}
		}
		add_action( 'publish_post', 'r4w_create_sitemap' );
		add_action( 'publish_page', 'r4w_create_sitemap' );

	/**
	 * Redirigée vers "homepage" quand aucun sitemap.xml
	 */
		function r4w_redirect_sitemap(){
			if($_SERVER["REQUEST_URI"] == '/sitemap.xml') {
				$file = ABSPATH . 'sitemap.xml';
				if(!file_exists($file)){
		    			wp_redirect( home_url() );
		       		exit;
				}
			}
		}
		add_action( 'init', 'r4w_redirect_sitemap' );

	/**
	 * Supprime le fichier sitemap.xml
	 */
		function r4w_delete_sitemap() {
			$file = ABSPATH . 'sitemap.xml';
			if(unlink($file)){
				return true;
			}
		}

	/**
	 * Ajoute du contenu au flux RSS
	 */
	 	function r4w_custom_rss( $content ){
			$arr = [
				"folder" => "html_feed",
				"content" => $content
			];
		  	return r4w_tpl($arr);
	 	}
	 	add_filter( 'the_content_feed', 'r4w_custom_rss' );
	 	add_filter( 'the_excerpt_rss', 'r4w_custom_rss' );

	/**
	 * Gestion de l'affichage des archives
	 */
		function r4w_display_archives( $query ){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_app['settings'])){
				$GLOBALS['r4w_settings'] =  json_decode(hex2bin($r4w_app['settings']),true);
				global $r4w_settings;
			}

			if( is_author() ){
				if(empty($r4w_settings['seo_settings']['archive']['author_archives']['display']) OR $r4w_settings['seo_settings']['archive']['author_archives']['display'] == 'off'){
		    			wp_redirect( home_url() );
		       		exit;
			    }
			}
			if( is_date() ){
				if(empty($r4w_settings['seo_settings']['archive']['date_archives']['display']) OR $r4w_settings['seo_settings']['archive']['date_archives']['display'] == 'off'){
		    			wp_redirect( home_url() );
		       		exit;
			    }
			}
		}
		add_action( 'parse_query', 'r4w_display_archives' );

	/**
	 * Shortcode : Liens des pages soeurs
	 */
		function r4w_sc_sister_links(){
			global $wpdb, $post;

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_app['settings']) AND ctype_xdigit($r4w_app['settings'])){
				$wp_setting = json_decode(hex2bin($r4w_app['settings']),true);
		 	}

			// <!> Limiter à une utilisation dans les pages
			if($post->post_type == 'page'){
				$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
				$wp_post_id = get_the_ID();
				
				if(empty($wp_setting['general_setting']['sisterlinks']['limit'])){
					$wp_setting['general_setting']['sisterlinks']['limit'] = 20;
				}
				$posts_per_page = $wp_setting['general_setting']['sisterlinks']['limit'];
				if( $posts_per_page == "unlimited"){
					$posts_per_page = '-1';
				}

				if ( $post->post_parent ) {
					$query = new WP_Query( array( 'post_type' => 'page','order' => 'ASC', 'posts_per_page' => $posts_per_page, 'post_parent' => $post->post_parent, 'post__not_in' => [ $wp_post_id ] ) );
					$sister_pages_link = $query->posts;
				}
				//print_r($sister_pages_link);

				$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$wp_post_id);
				$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);

				if(!empty($r4w_document['config']) AND ctype_xdigit($r4w_document['config'])){
					$wp_page_config = json_decode(hex2bin($r4w_document['config']),true);
				}

				if(isset($wp_page_config['shortcode']['customize']['display']) AND $wp_page_config['shortcode']['customize']['display'] == 'on'){
					if(isset($wp_page_config['shortcode']['customize']['title']) and !empty($wp_page_config['shortcode']['customize']['title'])){
						$text_before = '<h4>'.$wp_page_config['shortcode']['customize']['title'].'</h4>';
					}else{
						$text_before = '';
					}
				}else{
					$text_before = '<h4>'.__('To read also', 'app_rank4win').'</h4>';
				}

				if(!empty($sister_pages_link)){
					$tpl_li = '';
					foreach ($sister_pages_link as $page) {
						if(!empty($wp_page_config['shortcode']['links'][bin2hex($page->post_name)])){
							$text_link_custom = $wp_page_config['shortcode']['links'][bin2hex($page->post_name)];
						}else{
							$text_link_custom = $page->post_title;
						}
						$tpl_li .= '<li class="page_item"><a href="'.r4w_get_permalink($page->ID).'">'.$text_link_custom.'</a></li>';
					}
					$return = $text_before.$tpl_li;
					return $return;
				}
			}
		}
		add_shortcode( r4w_shortcode_sister_page_link, 'r4w_sc_sister_links' );

	/**
	 * Fonction de tampon de sortie
	 * Cela permettra à une redirection d'avoir lieu avant
	 * que le chargement de la page initiale ne soit terminé.
	 */
		function r4w_output_buffer() {
		    ob_start();
		}
		add_action( 'init', 'r4w_output_buffer' );

	/**
	 * Démarrer le processus d'arrière-plan
	 */
		function r4w_background_process() {
			class r4w_process extends r4w_background_process {
				protected function task( $item) {
					r4w_backgroundProcess($item);
					return false;
				}
				protected function complete() {
					parent::complete();
				}
			}
			$process_all = new r4w_process();
		}
		add_action( 'plugins_loaded', 'r4w_background_process' );

	/**
	 * Action pour le processus d'arrière-plan
	 */
		function r4w_backgroundProcess( $process_uuid ) {
			global $wpdb;

			$wp_table_process = $wpdb->prefix.r4w_bdd_table_process;

			$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_process} WHERE uuid = %s",$process_uuid);
		     $r4w_process = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_process['data'])){
				$r4w_process_data = json_decode(hex2bin($r4w_process['data']),true);
			}

		    // Créer les pages du diagramme
			if($r4w_process['request'] == 'deploy'){

				$curl_data = [
					"request_method" => "GET",
					"auth" => "true",
					"url" => "/wp/structure/semantic/".$r4w_process_data['editor_uuid'],
					"postfileds" => [
						"json_encode" => true,
						"data" => [
							"method" => $r4w_process['request']
						]
					]
				];
				$curl = r4w_curl_request($curl_data);
				if(!empty($r4w_process_data)){
					$r4w_process_data['total'] = $curl['resp']['success']['str_semantic']['page'];
					if($r4w_process_data['total'] >=0){
						$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_process SET data = %s WHERE uuid = %s", bin2hex(json_encode($r4w_process_data)) , $r4w_process['uuid']));

						if($r4w_process_data['how_deploy']=='160513a9-dc4d-48f9-821d-a047206b2913'){
							// Supprime toutes les pages de wordpress
							$pages = get_pages();
							foreach ( $pages as $page ) {
								wp_delete_post($page->ID, true);
							}
						}
						$diagram = json_decode(utf8_decode(base64_decode($curl['resp']['success']['str_semantic']['data'])),true);
						$releventIds = r4w_get_relevent_id( $diagram['root'] );
						r4w_trash_irrelevant_pages( $releventIds );
						if($r4w_process_data['how_deploy']=='e92f58c6-c94d-4768-8536-72f1e6f3dd69'){
							// Réorganise les pages de wordpress
						}
						$result = [
							'uuid' => $r4w_process['uuid'],
							'created'       => 0,
							'create_error'  => 0,
							'updated'       => 0,
							'update_error'  => 0,
							'children_skipped'=> 0,
							'updated_permalinks' => []
						];
						r4w_deploy_pages($diagram['root'],'',$result,true);
					}
				}
				$curl_data = [
					"request_method" => "POST",
					"auth" => "true",
					"url" => "/wp/structure/deploy/",
					"postfileds" => [
						"json_encode" => true,
						"data" => null
					]
				];
				$curl = r4w_curl_request($curl_data);
			}

			// Déclanche la recherche d'un mot
			if($r4w_process['request'] == 'search_word'){
				$curl_data = [
					"request_method" => "PUT",
					"auth" => "true",
					"url" => "/wp/strategy/",
					"postfileds" => [
						"json_encode" => true,
						"data" => [
							"request" => $r4w_process_data['request'],
							"word" => $r4w_process_data['word']
						]
					]
				];
				$curl = r4w_curl_request($curl_data);
			}

			// Déclanche la recherche des questionnements
			if($r4w_process['request'] == 'answer'){
				$curl_data = [
					"request_method" => "PUT",
					"auth" => "true",
					"url" => "/wp/cloud/synonymous/".$r4w_process_data['document'],
					"postfileds" => ""
				];
				$curl = r4w_curl_request($curl_data);
			}

			// Déclanche la recherche semantique
			if($r4w_process['request'] == 'semantic'){
				$curl_data = [
					"request_method" => "PUT",
					"auth" => "true",
					"url" => "/wp/cloud/semantics/".$r4w_process_data['document'],
					"postfileds" => ""
				];
				$curl = r4w_curl_request($curl_data);
			}

			// Déclanche la recherche synonyme
			if($r4w_process['request'] == 'synonymous'){
				$curl_data = [
					"request_method" => "PUT",
					"auth" => "true",
					"url" => "/wp/cloud/synonymous/".$r4w_process_data['document'],
					"postfileds" => ""
				];
				$curl = r4w_curl_request($curl_data);
			}

			$wpdb->query( $wpdb->prepare( "DELETE FROM $wp_table_process WHERE uuid = %s", $process_uuid));
		}

	/**
	 * Permaliens : Vérifie la configuration choisie du permaliens "Homepage"
	 */
		function r4w_set_permalink(){
			global $wpdb, $wp_rewrite;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_app['settings']) AND ctype_xdigit($r4w_app['settings'])){
				$wp_setting = json_decode(hex2bin($r4w_app['settings']),true);
			}

			if(isset($wp_setting['general_setting']['parmalinks']['remove_homepage']) AND $wp_setting['general_setting']['parmalinks']['remove_homepage'] == 'on'){
				$wp_rewrite->set_permalink_structure('/%postname%/');
				add_filter( 'request', 'r4w_make_request', 10, 1 );
				add_filter( 'url_to_postid', 'r4w_check_permalink', 10 );
				add_filter( 'user_trailingslashit', 'r4w_apply_trailingslash', 10, 2 );
			}
		}
		add_action('init', 'r4w_set_permalink');

	/**
	 * Permaliens : Permet de récupérer le permalink en fonction de la configuration choisie
	 */
		function r4w_get_permalink($page_ID){
			global $wpdb, $wp_rewrite;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_app['settings']) AND ctype_xdigit($r4w_app['settings'])){
				$wp_setting = json_decode(hex2bin($r4w_app['settings']),true);
			}
			if(isset($wp_setting['general_setting']['parmalinks']['remove_homepage']) AND $wp_setting['general_setting']['parmalinks']['remove_homepage'] == 'on'){
				return r4w_remove_home_page_link(get_permalink($page_ID),$page_ID);
			}else{
				return get_permalink($page_ID);
			}
		}

   	/**
   	 * Permaliens : Recupère les slugs des pages parents et supprime la page d'accueil
   	 */
	    	function r4w_get_post_name($id,$permalink = ''){
	    		$post = get_post($id);
	    		if(get_post_status($post) === 'publish'){
		    		$permalink = $post->post_name.'/'.$permalink;
		    		if(!empty($post->post_parent)){
		    			$permalink = r4w_get_post_name($post->post_parent, $permalink);
		    		}
		    		$page_home = get_post(get_option( 'page_on_front' ));
		        	$permalink = str_replace( $page_home->post_name.'/', "", $permalink );
		    		return $permalink;
	    		}
	    	}

    /**
     * Permaliens : Filtre pour réécrire la requête si nous avons une page correspondant.
     */
		function r4w_make_request( $query ) {
			global $wpdb;
			global $_CPRegisteredURL;
			$original_url = NULL;
			$url          = parse_url( get_bloginfo( 'url' ) );
			$url          = isset( $url['path'])  ? $url['path'] : '';
			$request      = ltrim( substr( $_SERVER['REQUEST_URI'], strlen( $url ) ), '/' );
			$pos          = strpos( $request, '?' );
			if ( $pos ) {
				$request = substr( $request, 0, $pos );
			}

			if ( ! $request ) {
				return $query;
			}

			$redirect = r4w_check_redirect( $request );
			if ( isset( $redirect ) && ! empty( $redirect ) ) {
				wp_redirect( trailingslashit( home_url() ) . $redirect, 301 );
				exit();
			}

			$page_home = get_post(get_option( 'page_on_front' ));

			if(!empty($page_home)){
				$permalink = $page_home->post_name.'/'.$request;
				$request_noslash = preg_replace( '@/+@', '/', trim( $request, '/' ) );
				$post = get_page_by_path($permalink);
			}

			if( isset($post) ){
				$query['pagename'] = $permalink;
				unset($query['name']);
				unset($query['attachment']);
				unset($query['error']);
			}

			return $query;
		}

	/**
	 * Permaliens : Renvoie le permaliens d'origine
	 */
		function r4w_check_permalink( $permalink ) {

			if ( ! isset( $permalink ) || empty( $permalink ) ) {
				return $permalink;
			}

			$page_home = get_post(get_option( 'page_on_front' ));
			$permalink = $page_home->post_name.'/'.$permalink;

			$request = ltrim( $permalink, '/' );
			$request_noslash = preg_replace( '@/+@', '/', trim( $request, '/' ) );

			$post = get_page_by_path($permalink);

			if ( isset( $post ) && isset( $post->post_type ) ) {
				if ( 'page' === $post->post_type ) {
					$permalink = r4w_original_page_link( $post->ID );
				}
			}
			return $permalink;
		}

	/**
	 * Permaliens : Vérifiez que l'URL demandée a une redirection (retourne l'URL de redirection).
	 */
		function r4w_check_redirect( $url ) {
			$return_uri = '';
			if ( isset( $url ) && ! empty( $url ) ) {
				$page_home = get_post(get_option( 'page_on_front' ));
				if(!empty($page_home)){
					if (strpos($url, $page_home->post_name) !== false) {
						$return_uri = str_replace( $page_home->post_name.'/', "", $url );
					}
				}
			}
			return $return_uri;
		}

	/**
	 * Permaliens : Supprimer le filtre page_link pour obtenir le permalien d'origine
	 */
		function r4w_original_page_link( $post_id ) {
		    remove_filter( 'page_link', 'r4w_remove_home_page_link', 10, 2 );

		    $wp_perm = get_permalink( $post_id );
		    $original_permalink = ltrim( preg_replace( '|^(https?:)?//[^/]+(/.*)|i', '$2', $wp_perm ), '/' );

		    add_filter( 'page_link', 'r4w_remove_home_page_link', 10, 2 );
		    return $original_permalink;
		}

	/**
	 * Permaliens : Filtre pour recupérer le permalien sans la page d'accueil.
	 */
		function r4w_remove_home_page_link( $permalink, $page ) {
			$r4w_permalinks = r4w_get_post_name($page);
			if ( $r4w_permalinks ) {
				$language_code = apply_filters( 'wpml_element_language_code', null, array( 'element_id' => $page, 'element_type' => 'page' ) );
				if ( $language_code ) {
					return apply_filters( 'wpml_permalink', trailingslashit( home_url() ) . $r4w_permalinks, $language_code );
				} else {
					return apply_filters( 'wpml_permalink', trailingslashit( home_url() ) . $r4w_permalinks );
				}
			}
			return $permalink;
		}

	/**
	 * Permaliens : Utilisez pour ajouter une barre oblique finale.
	 */
		function r4w_apply_trailingslash( $string, $type ) {
			global $_CPRegisteredURL;

			remove_filter( 'user_trailingslashit','r4w_apply_trailingslash', 10, 2);

			$url = parse_url( get_bloginfo( 'url' ) );
			$request = ltrim( isset( $url['path'] ) ? substr( $string, strlen( $url['path'] ) ) : $string, '/' );

			add_filter( 'user_trailingslashit', 'r4w_apply_trailingslash' , 10, 2);

			if ( ! trim( $request ) ) {
				return $string;
			}

			if ( trim( $_CPRegisteredURL, '/' ) == trim( $request, '/' ) ) {
				if ( isset( $url['path'] ) ) {
					return ( $string[0] == '/' ? '/' : '' ) . trailingslashit( $url['path'] ) . $_CPRegisteredURL;
				} else {
					return ( $string[0] == '/' ? '/' : '' ) . $_CPRegisteredURL;
				}
			}
			return $string;
		}

	/**
	 * Permaliens : Action à rediriger vers le permalien personnalisé.
	 */
		function r4w_mapke_redirect() {
			global $wp_query;
			$url     = parse_url( get_bloginfo( 'url' ) );
			$url     = isset( $url['path'] ) ? $url['path'] : '';
			$request = ltrim( substr( $_SERVER['REQUEST_URI'], strlen( $url ) ), '/' );

			if ( ( $pos= strpos( $request, '?' ) ) ) {
				$request = substr( $request, 0, $pos );
			}

			$r4w_permalinks = '';
			$original_permalink    = '';

			if ( is_single() || is_page() ) {
				$post = $wp_query->post;
				$r4w_permalink = r4w_get_post_name($post->ID);

				if ( 'page' == $post->post_type ) {
					$original_permalink = r4w_original_page_link( $post->ID );
				}
			}

			if ( $r4w_permalink && ( substr( $request, 0, strlen( $r4w_permalink ) ) != $r4w_permalink || $request == $r4w_permalink . '/' ) ) {
				$url = $r4w_permalink;

				if ( substr( $request, 0, strlen( $original_permalink ) ) == $original_permalink && trim( $request, '/' ) != trim( $original_permalink, '/' ) ) {
					$url = preg_replace( '@//*@', '/', str_replace( trim( $original_permalink, '/' ), trim( $r4w_permalinks, '/' ), $request ) );
					$url = preg_replace( '@([^?]*)&@', '\1?', $url );
				}

				$url .= strstr( $_SERVER['REQUEST_URI'], '?' );
				wp_redirect( trailingslashit( home_url() ) . $url, 301 );
				exit();
			}
		}

	/**
	 * Prise en charge de Noscript
	 */
		function r4w_add_noscript_filter($tag, $handle, $src){
			if ( 'script-handle' === $handle ){
				$noscript = '<noscript>';
				$noscript .= '<style>.simplebar-content-wrapper { overflow: auto; }</style>';
				$noscript .= '</noscript>';
				$tag = $tag . $noscript;
			}
			return $tag;
		}
		add_filter('script_loader_tag', 'r4w_add_noscript_filter', 10, 3);