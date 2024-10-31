<?php
	if ( ! function_exists( 'r4w_wordpress_oauth' ) ) {
		/**
		 * Vérifie la liaison entre le wordpress et le serveur rank4win
		 */
		function r4w_wordpress_oauth() {
			global $wpdb;

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			
		    $wp_select = "SELECT * from ".$wp_table_app;
		    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

		    if(!empty($r4w_app['settings']) AND ctype_xdigit($r4w_app['settings'])){
				$wp_setting = json_decode(hex2bin($r4w_app['settings']),true);
			}
		    if(empty($r4w_app['oauth'])){
				$array = [
					'resp' => $return = [
						'error' => [
							'name' => 'required_configuration',
							'description' => 'The plugin must be configured before being used'
						]
					],
					'info' => [
						'http_code' => 301
					]
				];
				return $array;
		    	exit;
		    }else{
				$curl_data = [
					"request_method" => "GET",
					"auth" => "true",
					"url" => "/wp/oauth/",
					"postfileds" => [
						"json_encode" => true,
						"data" => null
					]
				];
				$curl = r4w_curl_request($curl_data);
				if ($curl['err']) {					
					$array = [
						'resp' => $return = [
							'error' => [
								'name' => 'service_unavailable',
								'description' => 'Service in maintenance or unavailable'
							]
						],
						'info' => [
							'http_code' => 500
						]
					];
					return $array;
			    	exit;
				} else {
					$array = [
						'resp' => $curl['resp'],
						'info' => $curl['info']
					];
			    	return $array;
					exit;
				}
		    }
		}
	}