<?php
/**
 * Gestion des actions javascript POST WP
 */

	/**
	 * Auth : Identification du compte rank4win
	 */
		function r4w_exec_auth_login(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

			if(empty($_POST['r4w_user'])){
	            $return = [
	                'error' => [
						'name' => 'credentials_invalid',
						'description' => __( 'Wrong email or password', 'app_rank4win' )
	                ]
	            ];
				echo json_encode($return);
				die();
			}
			if(empty($_POST['r4w_pwd'])){
	            $return = [
	                'error' => [
						'name' => 'credentials_invalid',
						'description' => __( 'Wrong email or password', 'app_rank4win' )
	                ]
	            ];
				echo json_encode($return);
				die();
			}
			$curl_data = [
				"request_method" => "POST",
				"url" => "/wp/user/auth/",
				"auth" => "false",
				"postfileds" => [
					"json_encode" => true,
					"data" => [
						"user" => $_POST['r4w_user'],
						"pwd" => $_POST['r4w_pwd'],
					]
				]
			];
			$curl = r4w_curl_request($curl_data);
			if($curl['info']['http_code'] == 404){
				if($curl['resp']['error']['name'] == 'credentials_invalid'){
		            $return = [
		                'error' => [
							'name' => 'credentials_invalid',
							'description' => __( 'Wrong email or password', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
			}
			if($curl['info']['http_code'] == 403){
				if($curl['resp']['error']['name'] == 'account_blocked'){
		            $return = [
		                'error' => [
							'name' => 'account_blocked',
							'description' => __( 'Your account is temporarliy blocked', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
				if($curl['resp']['error']['name'] == 'credentials_invalid'){
		            $return = [
		                'error' => [
							'name' => 'account_disabled',
							'description' => __( 'Your account has been permanently disabled', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
			}
			if($curl['info']['http_code'] == 200){
				$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET oauth_tmp = %s WHERE id = %d", $curl['resp']['success']['user']['token'],1));
				if($curl['resp']['success']['user']['authorization'] == 401){
					$return = [
		                'success' => [
		                	'url' => admin_url( 'admin.php?page=r4w_auth_otp' ),
		                    'request' => md5(r4w_fcnt_uuid())
		                ]
		            ];
					echo json_encode($return);
					die();
				}else{
					$return = [
		                'success' => [
		                	'url' => admin_url( 'admin.php?page=r4w_auth_wordpress' ),
		                    'request' => md5(r4w_fcnt_uuid())
		                ]
		            ];
					echo json_encode($return);
					die();
				}
			}
		}
		add_action( 'wp_ajax_r4w_exec_auth_login', 'r4w_exec_auth_login' );

	/**
	 * Auth : Mot de passe perdu
	 */
		function r4w_exec_auth_forgot(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

			if(empty($_POST['r4w_user'])){
	            $return = [
	                'error' => [
						'name' => 'email_invalid',
						'description' => __( 'Email must be a valid email', 'app_rank4win' )
	                ]
	            ];
				echo json_encode($return);
				die();
			}
			$curl_data = [
				"request_method" => "POST",
				"url" => "/wp/user/forgot/",
				"auth" => "false",
				"postfileds" => [
					"json_encode" => true,
					"data" => [
						"user" => $_POST['r4w_user']
					]
				]
			];
			$curl = r4w_curl_request($curl_data);
			if($curl['info']['http_code'] == 404){
				if($curl['resp']['error']['name'] == 'email_invalid'){
		            $return = [
		                'error' => [
							'name' => 'email_invalid',
							'description' => __( 'Email must be a valid email', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
			}
			if($curl['info']['http_code'] == 200){
				$return_data =  $curl['resp']['success'];
		    	$oauth = $return_data['user']['token'];
				$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET oauth_tmp = %s WHERE id = %d", $oauth,1));
				$return = [
	                'success' => [
	                	'url' => admin_url( 'admin.php?page=r4w_auth_otp&control=password' ),
	                    'request' => md5(r4w_fcnt_uuid())
	                ]
	            ];
				echo json_encode($return);
				die();
			}
		}
		add_action( 'wp_ajax_r4w_exec_auth_forgot', 'r4w_exec_auth_forgot' );

	/**
	 * Auth : Création d'un compte rank4win
	 */
		function r4w_exec_auth_register(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

			if(empty($_POST['r4w_pwd'])){
	            $return = [
	                'error' => [
						'name' => 'pwd_invalid',
						'description' => __( 'Password is a required field', 'app_rank4win' )
	                ]
	            ];
				echo json_encode($return);
				die();
			}
			if($_POST['r4w_pwd'] != $_POST['r4w_repwd']){
	            $return = [
	                'error' => [
						'name' => 'pwd_invalid',
						'description' => __( 'Password and confirmation must match', 'app_rank4win' )
	                ]
	            ];
				echo json_encode($return);
				die();
			}
			if(empty($_POST['r4w_user'])){
	            $return = [
	                'error' => [
						'name' => 'email_invalid',
						'description' => __( 'Email must be a valid email', 'app_rank4win' )
	                ]
	            ];
				echo json_encode($return);
				die();
			}
			$curl_data = [
				"request_method" => "POST",
				"url" => "/wp/user/register/",
				"auth" => "false",
				"postfileds" => [
					"json_encode" => true,
					"data" => [
						"user" => $_POST['r4w_user'],
						"pwd" => $_POST['r4w_pwd'],
						"repwd" => $_POST['r4w_repwd']
					]
				]
			];
			$curl = r4w_curl_request($curl_data);
			if($curl['info']['http_code'] == 404){
				if($curl['resp']['error']['name'] == 'email_invalid'){
		            $return = [
		                'error' => [
							'name' => 'email_invalid',
							'description' => __( 'Email must be a valid email', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
				if($curl['resp']['error']['name'] == 'pwd_invalid'){
		            $return = [
		                'error' => [
							'name' => 'pwd_invalid',
							'description' => __( 'Password and confirmation must match', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
				if($curl['resp']['error']['name'] == 'user_used'){
		            $return = [
		                'error' => [
							'name' => 'user_used',
							'description' => __( 'An account already exists with this email address', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
			}
			if($curl['info']['http_code'] == 200){
				$return_data =  $curl['resp']['success'];
		    	$oauth = $return_data['user']['token'];
				$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET oauth_tmp = %s WHERE id = %d", $oauth,1));
				if($return_data['user']['authorization'] == 401){
					$return = [
		                'success' => [
		                	'url' => admin_url( 'admin.php?page=r4w_auth_otp' ),
		                    'request' => md5(r4w_fcnt_uuid())
		                ]
		            ];
					echo json_encode($return);
					die();
				}else{
					$return = [
		                'success' => [
		                	'url' => admin_url( 'admin.php?page=r4w_auth_wordpress' ),
		                    'request' => md5(r4w_fcnt_uuid())
		                ]
		            ];
					echo json_encode($return);
					die();
				}
			}
		}
		add_action( 'wp_ajax_r4w_exec_auth_register', 'r4w_exec_auth_register' );

	/**
	 * Auth : Code OTP - Vérification email
	 */
		function r4w_exec_auth_otp_email(){
			if(is_null($_POST['r4w_otp_1']) or is_null($_POST['r4w_otp_2']) or is_null($_POST['r4w_otp_3']) or is_null($_POST['r4w_otp_4'])){
	            $return = [
	                'error' => [
						'name' => 'code_otp_invalid',
						'description' => __( 'Wrong verification code', 'app_rank4win' )
	                ]
	            ];
				echo json_encode($return);
				die();
			}
			$curl_data = [
				"request_method" => "POST",
				"url" => "/wp/user/email/otp/",
				"auth" => "tmp",
				"postfileds" => [
					"json_encode" => true,
					"data" => [
						"code_otp" => $_POST['r4w_otp_1'].''.$_POST['r4w_otp_2'].''.$_POST['r4w_otp_3'].''.$_POST['r4w_otp_4']
					]
				]
			];
			$curl = r4w_curl_request($curl_data);
			if($curl['info']['http_code'] == 404){
				if($curl['resp']['error']['name'] == 'code_otp_invalid'){
		            $return = [
		                'error' => [
							'name' => 'code_otp_invalid',
							'description' => __( 'Wrong verification code', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
			}
			if($curl['info']['http_code'] == 401){
	            $return = [
	                'error' => [
	                	'url' => admin_url( 'admin.php?page=r4w_auth_login' ),
                    	'request' => md5(r4w_fcnt_uuid())
	                ]
	            ];
				echo json_encode($return);
				die();
			}
			if($curl['info']['http_code'] == 200){
				$return = [
	                'success' => [
	                	'url' => admin_url( 'admin.php?page=r4w_auth_wordpress' ),
	                    'request' => md5(r4w_fcnt_uuid())
	                ]
	            ];
				echo json_encode($return);
				die();
			}
		}
		add_action( 'wp_ajax_r4w_exec_auth_otp_email', 'r4w_exec_auth_otp_email' );

	/**
	 * Auth : Code OTP - Changement du mot de passe
	 */
		function r4w_exec_auth_otp_password(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

			if($_POST['request'] == 'change_password'){
				if(empty($_POST['r4w_pwd'])){
		            $return = [
		                'error' => [
							'name' => 'pwd_invalid',
							'description' => __( 'Password is a required field', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
				if($_POST['r4w_pwd'] != $_POST['r4w_repwd']){
		            $return = [
		                'error' => [
							'name' => 'pwd_invalid',
							'description' => __( 'Password and confirmation must match', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
				if($_POST['code_otp']){
		            $return = [
		                'error' => [
		                	'url' => admin_url( 'admin.php?page=r4w_auth_forgot' ),
	                    	'request' => md5(r4w_fcnt_uuid())
		                ]
		            ];
					echo json_encode($return);
					die();
				}
				$code_otp = $_POST['r4w_otp'];
				$curl_postfileds = [
					"code_otp" => $_POST['r4w_otp'],
					"pwd_new" => $_POST['r4w_pwd'],
					"request" => "change_password"
				];
			}else{
				if(is_null($_POST['r4w_otp_1']) or is_null($_POST['r4w_otp_2']) or is_null($_POST['r4w_otp_3']) or is_null($_POST['r4w_otp_4'])){
		            $return = [
		                'error' => [
							'name' => 'code_otp_invalid',
							'description' => __( 'Wrong verification code', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
				$curl_postfileds = [
					"code_otp" => $_POST['r4w_otp_1'].''.$_POST['r4w_otp_2'].''.$_POST['r4w_otp_3'].''.$_POST['r4w_otp_4']
				];
			}
			$curl_data = [
				"request_method" => "POST",
				"url" => "/wp/user/password/otp/",
				"auth" => "tmp",
				"postfileds" => [
					"json_encode" => true,
					"data" => $curl_postfileds
				]
			];
			$curl = r4w_curl_request($curl_data);
			if($curl['info']['http_code'] == 404){
				if($curl['resp']['error']['name'] == 'code_otp_invalid'){
		            $return = [
		                'error' => [
							'name' => 'code_otp_invalid',
							'description' => __( 'Wrong verification code', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
				if($curl['resp']['error']['name'] == 'pwd_invalid'){
		            $return = [
		                'error' => [
							'name' => 'pwd_invalid',
							'description' => __( 'Password and confirmation must match', 'app_rank4win' )
		                ]
		            ];
					echo json_encode($return);
					die();
				}
			}
			if($curl['info']['http_code'] == 200){
				$return_data =  $curl['resp']['success'];
				if($_POST['request'] == 'change_password'){
					$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET oauth_tmp = null WHERE id = %d", 1));
					$return = [
		                'success' => [
		                	'url' => admin_url( 'admin.php?page=r4w_auth_login' ),
		                    'request' => md5(r4w_fcnt_uuid())
		                ]
		            ];
		        }else{
					$return = [
		                'success' => [
		                	'code_otp' => $return_data['code_otp'],
		                    'request' => md5(r4w_fcnt_uuid())
		                ]
		            ];
		        }
				echo json_encode($return);
				die();
			}
		}
		add_action( 'wp_ajax_r4w_exec_auth_otp_password', 'r4w_exec_auth_otp_password' );

	/**
	 * Effectue l'enregistrement des mots clés séléctionner
	 */
		function r4w_exec_keywords(){
			global $wpdb;
			global $wp;
			if(!empty($_POST['r4w_document_id'])){
				$post_id = $_POST['r4w_document_id'];
			}
			$wp_post = get_post($post_id);

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$post_id);
			$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);
			switch ($_POST['r4w_method']) {
				case 'r4w_box-keyword_main':
					if(empty($_POST['r4w_keywords'])){
						$return = [
							'error' => [
								'name' => 'keyword_invalid',
								'description' => 'Keyword is empty or invalid'
							]
						];
						echo json_encode($return);
						die();
					}
					if(!empty($_POST['r4w_keywords'])){
						$keywords_main = json_encode([$_POST['r4w_keywords']]);
						if(empty($r4w_document['uuid'])){
							$wp_document_uuid = r4w_new_document('document', $post_id);
						}else{
							$wp_document_uuid = $r4w_document['uuid'];
						}
						$curl_data = [
							"request_method" => "PUT",
							"url" => "/wp/create/document",
							"auth" => "true",
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"uuid" => $wp_document_uuid,
									"wp_post_id" => $post_id,
									"keywords_main" => $_POST['r4w_keywords']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
						if(isset($curl['err']) AND !empty($curl['err'])){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}
						if(isset($curl['resp']['error'])){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}
						if(isset($curl['resp']['success'])){
							/**
							 * Créer page si c'est un nouveau document
							 */
							if($wp_post->post_status=="auto-draft"){
								$post_lock_id = [
									'ID' => $post_id,
									'post_title' =>  trim(preg_replace('/\s\s+/', ' ', $_POST['r4w_keywords'])).' :',
									'post_status' => 'draft'
								];
								wp_update_post($post_lock_id);
							}
							/**
							 * Enregistrement / Mise a jour des données dans la table
							 */
							 if(!empty($r4w_document['deploy_data'])){
								$update_data_deploy = json_decode(hex2bin($r4w_document['deploy_data']),true);
							 }
							 $update_data_deploy['keywords']['main'] = $_POST['r4w_keywords'];
							
							$update_dd =  bin2hex(preg_replace('/\\\\/', '', json_encode($update_data_deploy, JSON_UNESCAPED_UNICODE )));
							$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET request= %s, data = %s, locale_uuid = %s, timecode = %s, deploy_data = %s WHERE uuid = %s", $curl['resp']['success']['keyword'], $curl['resp']['success']['data'], $curl['resp']['success']['locale_uuid'], $curl['resp']['success']['timecode'], $update_dd, $wp_document_uuid));
							$return = [
								'success' => [
									'step' => 'r4w_box-keyword_secondary',
									'finish' => false,
									'request' => md5(r4w_fcnt_uuid())
								]
							];
							echo json_encode($return);
							die();
						}
						die();
					}
				break;
				case 'r4w_box-keyword_secondary':
					if(!empty($r4w_document['uuid'])){
						if(!empty($_POST['r4w_keywords'])){
							$keywords_secondary = explode(',',$_POST['r4w_keywords']);
						}
						$curl_data = [
							"request_method" => "PUT",
							"url" => "/wp/create/document/".$r4w_document['uuid'],
							"auth" => "true",
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"action" => "r4w_box-keyword_secondary",
									"keywords_secondary" => $keywords_secondary
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
						if(isset($curl['err']) AND !empty($curl['err'])){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}
						if(isset($curl['resp']['error'])){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}
						if(isset($curl['resp']['success'])){
							/**
							 * Enregistrement des données dans la table
							 */
							if(!empty($r4w_document['deploy_data'])){
								$update_data_deploy = json_decode(hex2bin($r4w_document['deploy_data']),true);
							}
							$update_data_deploy['keywords']['secondary'] = $keywords_secondary;
							$update_dd =  bin2hex(preg_replace('/\\\\/', '', json_encode($update_data_deploy, JSON_UNESCAPED_UNICODE )));
							if(empty($curl['resp']['success']['hash_param'])){
								$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET data = %s, deploy_data = %s WHERE uuid = %s", $curl['resp']['success']['data'], $update_dd, $r4w_document['uuid']));
								$return = [
									'success' => [
										'step' => 'r4w_box-keyword_lexical',
										'finish' => false,
										'request' => md5(r4w_fcnt_uuid())
									]
								];
								echo json_encode($return);
								die();
							}else{
									$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET data = %s, deploy_data = %s, hash_param = %s WHERE uuid = %s", $curl['resp']['success']['data'], $update_dd, $curl['resp']['success']['hash_param'], $r4w_document['uuid']));
								$return = [
									'success' => [
										'url' => admin_url( 'post.php?post='.$post_id.'&action=edit' ),
										'finish' => true,
										'request' => md5(r4w_fcnt_uuid())
									]
								];
								echo json_encode($return);
								die();
							}
						}
						die();
					}
				break;
				case 'r4w_box-keyword_lexical':
					if(!empty($r4w_document['uuid'])){
						if(!empty($_POST['r4w_keywords'])){
							$keywords_lexical = explode(',',$_POST['r4w_keywords']);
						}
						$curl_data = [
							"request_method" => "PUT",
							"url" => "/wp/create/document/".$r4w_document['uuid'],
							"auth" => "true",
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"action" => "r4w_box-keyword_lexical",
									"keywords_lexical" => $keywords_lexical
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
						if(isset($curl['err']) AND !empty($curl['err'])){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}
						if(isset($curl['resp']['error'])){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}
						if(isset($curl['resp']['success'])){
							/**
							 * Enregistrement des données dans la table
							 */
							if(!empty($r4w_document['deploy_data'])){
								$update_data_deploy = json_decode(hex2bin($r4w_document['deploy_data']),true);
							}
							$update_data_deploy['keywords']['lexical'] = $keywords_lexical;
							$update_dd =  bin2hex(preg_replace('/\\\\/', '', json_encode($update_data_deploy, JSON_UNESCAPED_UNICODE )));
							if(!empty($keywords_lexical)){
								$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET data = %s, deploy_data = %s, hash_param = %s WHERE uuid = %s", $curl['resp']['success']['data'], $update_dd, $curl['resp']['success']['hash_param'], $r4w_document['uuid']));
								$return = [
									'success' => [
										'url' => admin_url( 'post.php?post='.$post_id.'&action=edit' ),
										'finish' => true,
										'request' => md5(r4w_fcnt_uuid())
									]
								];
								echo json_encode($return);
								die();
							}else{
									$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET data = %s, deploy_data = %s, hash_param = %s WHERE uuid = %s", $curl['resp']['success']['data'], $update_dd, $curl['resp']['success']['hash_param'], $r4w_document['uuid']));
								$return = [
									'success' => [
										'url' => admin_url( 'post.php?post='.$post_id.'&action=edit' ),
										'finish' => true,
										'request' => md5(r4w_fcnt_uuid())
									]
								];
								echo json_encode($return);
								die();
							}
						}
						die();
					}
				break;
			}
			die();
	 	}
	 	add_action( 'wp_ajax_r4w_exec_keywords', 'r4w_exec_keywords' );

	/**
	 * Effectue l'analyse du document
	 */
		function r4w_exec_analyzes(){
			global $wpdb;
			if(!empty($_POST['wp_post_id'])){
				$post_id = $_POST['wp_post_id'];
			}
			if(isset($_POST['r4w_keyword_type']) AND !empty($_POST['r4w_keyword_type'])){
				$r4w_keyword_type = $_POST['r4w_keyword_type'];
			}
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
		    	$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

		    	$wp_select = "SELECT * from ".$wp_table_app;
		    	$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

	    		$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$post_id);
			$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);

	 		switch ($_POST['wp_update']) {
	 			case 'wp_title':
	 				$method_request = "PUT";
	 				break;
	 			case 'wp_title_gutenberg':
	 				$method_request = "PUT";
	 				break;
	 			case 'wp_content':
	 				$method_request = "PUT";
	 				break;
	 			case 'wp_auto':
	 				$method_request = "PUT";
	 				break;
	 			default:
	 				$method_request = "GET";
	 				break;
	 		}
			if(empty($r4w_app['oauth'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
		    	die();
		    }

		    /**
		     * Effectue l'analyse
		     */
		    if(isset($_POST['wp_update']) AND !empty($_POST['wp_update'])){
		    	$wp_data = null;
		    	$wp_title = null;
		    	$wp_content = null;
			    if(isset($_POST['wp_data']) AND !empty($_POST['wp_data'])){
			    	$wp_data = bin2hex($_POST['wp_data']);
			    }
			    if(isset($_POST['wp_title']) AND !empty($_POST['wp_title'])){
			    	$wp_title = bin2hex($_POST['wp_title']);
			    }
			    if(isset($_POST['wp_content']) AND !empty($_POST['wp_content'])){
			    	$wp_content = bin2hex($_POST['wp_content']);
			    }
				$postfileds = [
					"update" => $_POST['wp_update'],
					"data" => $wp_data,
					"title" => $wp_title,
					"content" => $wp_content,
				];
			}
			$curl_data = [
				"request_method" => $method_request,
				"url" => "/wp/cloud/document/".$r4w_document['uuid'],
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => $postfileds
				]
			];
			$curl = r4w_curl_request($curl_data);
			if(isset($curl['err']) AND !empty($curl['err'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			}
			if(isset($curl['resp']['error'])){
				if($curl['resp']['error']['name'] == 'strange_data'){
					r4w_document_locking($r4w_document['uuid']);
					$return = [
						'error' => [
							'name' => 'strange_data',
							'description' => 'The data does not match'
						]
					];
					echo json_encode($return);
					die();
				}
				if($curl['resp']['error']['name'] == 'uuid_invalid'){
					r4w_document_reset($r4w_document['uuid']);
					$return = [
						'error' => [
							'name' => 'document_invalid',
							'url' => admin_url( 'post.php?post='.$post_id.'&action=edit' ),
							'request' => md5(r4w_fcnt_uuid())
						]
					];
					echo json_encode($return);
					die();
				}
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			}
			if(isset($curl['resp']['success'])){
				if($_POST['wp_update'] == 'wp_content'){
					if(isset($curl['resp']['success']['score']['percent'])){
						$score = $curl['resp']['success']['score']['percent'];
					}else{
						$score = '';
					}
					$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET overallscore = %d WHERE post_id = %d", $score, $post_id));
				}
				$return = [
					'success' => [
						'score' => $curl['resp']['success']['score'],
						'title' => $curl['resp']['success']['title'],
						'extra' => $curl['resp']['success']['extra'],
						'overall' => $curl['resp']['success']['overall'],
						'advises' => $curl['resp']['success']['advises'],
						'request' => md5(r4w_fcnt_uuid())
					]
				];
				echo json_encode($return);
				die();
			}
			die();
	 	}
	 	add_action( 'wp_ajax_r4w_exec_analyzes', 'r4w_exec_analyzes' );

	 /**
	  * Récupération des idées de contenu
	  */
	 	function r4w_exec_analyzes_answer(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

		    $wp_select = "SELECT * from ".$wp_table_app;
		    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/cloud/answers/".$_POST['r4w_document'],
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl = r4w_curl_request($curl_data);
			if(isset($curl['err']) AND !empty($curl['err'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			}
			if(isset($curl['resp']['error'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			}
			if(isset($curl['resp']['success'])){
				$return = [
					'success' => [
						'answers' => $curl['resp']['success']['answers'],
						'request' => md5(r4w_fcnt_uuid())
					]
				];
				echo json_encode($return);
				die();
			}
			die();
	 	}
	 	add_action( 'wp_ajax_r4w_exec_analyzes_answer', 'r4w_exec_analyzes_answer' );

 	/**
 	 * Effectue l'analyse semantique
 	 */
 		function r4w_exec_analyzes_semantic(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

		    $wp_select = "SELECT * from ".$wp_table_app;
		    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/cloud/semantics/".$_POST['r4w_document'],
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl = r4w_curl_request($curl_data);
			if(isset($curl['err']) AND !empty($curl['err'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			}
			if(isset($curl['resp']['error'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			}
			if(isset($curl['resp']['success'])){
				$return = [
					'success' => [
						'semantics' => $curl['resp']['success']['semantics'],
						'request' => md5(r4w_fcnt_uuid())
					]
				];
				echo json_encode($return);
				die();
			}
			die();
	 	}
 		add_action( 'wp_ajax_r4w_exec_analyzes_semantic', 'r4w_exec_analyzes_semantic' );

	 /**
	  * Récupération des synonymes
	  */
	 	function r4w_exec_analyzes_synonymous(){
			global $wpdb;

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

		    $wp_select = "SELECT * from ".$wp_table_app;
		    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			$curl_data = [
				"request_method" => "PUT",
				"url" => "/wp/cloud/synonymous/".$_POST['r4w_document'],
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => [
						"word" => $_POST['r4w_word']
					]
				]
			];
			$curl = r4w_curl_request($curl_data);

			if(isset($curl['err']) AND !empty($curl['err'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			}
			if(isset($curl['resp']['error'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			}
			if(isset($curl['resp']['success'])){
				$return = [
					'success' => [
						'syn_result' => $curl['resp']['success']['synonymous']['result'],
						'request' => md5(r4w_fcnt_uuid())
					]
				];
				echo json_encode($return);
				die();
			}
			die();
	 	}
	 	add_action( 'wp_ajax_r4w_exec_analyzes_synonymous', 'r4w_exec_analyzes_synonymous' );

	/**
	 * Récupértation de l'autocomplete
	 */
		function r4w_exec_autocomplete(){
			if(!empty($_POST['r4w_search'])){
				$curl_data = [
					"request_method" => "POST",
					"url" => "/wp/autocomplete/",
					"auth" => "true",
					"postfileds" => [
						"json_encode" => true,
						"data" => [
							"search" => $_POST['r4w_search']
						]
					]
				];
				$curl = r4w_curl_request($curl_data);
				if(isset($curl['err']) AND !empty($curl['err'])){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}
				if(isset($curl['resp']['error'])){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}
				if(isset($curl['resp']['success'])){
					$return = [
						'success' => [
							'words' => $curl['resp']['success']['words'],
							'request' => md5(r4w_fcnt_uuid())
						]
					];
					echo json_encode($return);
					die();
				}
				die();
			}
	 		die();
	 	}
	 	add_action( 'wp_ajax_r4w_exec_autocomplete', 'r4w_exec_autocomplete' );

	/**
	 * Récupération des suggestions de mots clés
	 */
		function r4w_exec_keywords_suggestion(){
			global $wpdb;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

			if(!empty($_POST['r4w_document_id'])){
				$post_id = $_POST['r4w_document_id'];
			}
			if(isset($_POST['r4w_keyword_type']) AND !empty($_POST['r4w_document_id'])){
				$r4w_keyword_type = $_POST['r4w_keyword_type'];
			}

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
			$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$post_id);
			$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);

			if($r4w_keyword_type != 'secondary' AND $r4w_keyword_type != 'lexical'){
				$return = [
					'error' => [
						'name' => 'type_invalid',
						'description' => 'Keyword type is empty or invalid'
					]
				];
				echo json_encode($return);
				die();
			}
			if(!empty($r4w_document['uuid'])){
				$curl_data = [
					"request_method" => "GET",
					"url" => "/wp/keywords/".$r4w_keyword_type."/".$r4w_document['uuid'],
					"auth" => "true",
					"postfileds" => [
						"json_encode" => true,
						"data" => null
					]
				];
				$curl = r4w_curl_request($curl_data);

				if(isset($curl['err']) AND !empty($curl['err'])){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}
				
				if(isset($curl['resp']['error'])){
					switch ($curl['resp']['error']['name']) {
						case 'uuid_invalid':
							$wp_doc_uuid = r4w_fcnt_uuid();
							if(!empty($r4w_document['deploy_data'])){
								$wp_update = $wpdb->query($wpdb->prepare("UPDATE ".$wp_table_document." SET uuid=%s, hash_param=%s,data=%s WHERE uuid=%s",$wp_doc_uuid,null,null,$r4w_document['uuid']));
							}
							$return = [
								'error' => [
									'name' => 'xdocument_refresh',
									'description' => 'Document refresh needed'
								]
							];
							echo json_encode($return);
							die();
						break;			
						default:
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						break;
					}
					
				}
				if(isset($curl['resp']['success'])){
					$return = [
						'success' => [
							'data' => $curl['resp']['success']['keywords'],
							'request' => md5(r4w_fcnt_uuid())
						]
					];
					echo json_encode($return);
					die();
				}
				die();
			}
	 		die();
		}
	 	add_action( 'wp_ajax_r4w_exec_keywords_suggestion', 'r4w_exec_keywords_suggestion' );

	/**
	 * Enregistrement des paramètres du plugin
	 */
		function r4w_exec_settings(){
			global $wpdb,$wp_rewrite;
			if(!empty($_POST['r4w_document_id'])){
				$post_id = $_POST['r4w_document_id'];
			}
			if(isset($_POST['r4w_keyword_type']) AND !empty($_POST['r4w_keyword_type'])){
				$r4w_keyword_type = $_POST['r4w_keyword_type'];
			}
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			$wp_table_options = $wpdb->prefix.'options';

		    $wp_select = "SELECT * from ".$wp_table_app;
		    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

		    if(!empty($r4w_app['settings'])){
		    	if(!is_null(hex2bin($r4w_app['settings']))){
		    		$r4w_settings =  json_decode(hex2bin($r4w_app['settings']),true);
		    	}else{
		    		$r4w_settings =  [];
		    	}
		    }else{
		    	$r4w_settings = [];
		    }

		    $setting_update = $_POST['setting_update'];
		    $setting_value = $_POST['setting_value'];

		    if($setting_update == 'general_setting|parmalinks|remove_homepage'){
			    //$wp_rewrite->flush_rewrite_rules();3
			    //var_dump($wp_rewrite);
			   // $wp_rewrite->generate_rewrite_rules();
		    }
		    if($setting_update == 'seo_settings_noindex'){
				/**
				 * Enregistrement de la configuration no index
				 */
				$blog_public = 1;
				if($setting_value == 'off'){
					$blog_public = 0;
				}
				$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_options SET option_value = %d WHERE option_name = 'blog_public'", $blog_public));
				foreach ($r4w_settings['seo_settings']['types_content'] as $setting_key => $setting_content) {
		    		unset($r4w_settings['seo_settings']['types_content'][$setting_key]['index']);
		    		unset($r4w_settings['seo_settings']['basic_configuration']['home_page']['index']);
		    	}
				$r4w_new_settings = json_encode($r4w_settings);

				$wp_result = $wpdb->get_results("SELECT * FROM {$wp_table_document} WHERE config != '' ",ARRAY_A);
		    	if(!empty($wp_result)){
				    foreach ($wp_result as $document) {
			    		$r4w_config =  json_decode(hex2bin($document['config']),true);
			    		unset($r4w_config['page']['index']);
			    		$r4w_config = bin2hex(json_encode($r4w_config));
			    		$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET config = %s WHERE id = %d", $r4w_config , $document['id']));
			    	}
			    }

				$curl_data = [
					"request_method" => "PUT",
					"url" => "/wp/config/",
					"auth" => "true",
					"postfileds" => [
						"json_encode" => true,
						"data" => [
							"wp_setting" => $r4w_new_settings
						]
					]
				];
				$curl = r4w_curl_request($curl_data);

				if(isset($curl['err']) AND !empty($curl['err'])){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}
				if(isset($curl['resp']['error'])){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}
				if(isset($curl['resp']['success'])){
					/**
					 * Enregistrement des données dans la table
					 */
					$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET settings = %s WHERE uuid = %s", $curl['resp']['success']['setting'], $r4w_app['uuid']));

				    if($setting_update == 'general_setting|feature|xml_sitemaps'){
				    	if($setting_value == 'on'){
				    		r4w_create_sitemap();
				    	}else{
				    		r4w_delete_sitemap();
				    	}
				    }

					$return = [
						'success' => [
							'request' => md5(r4w_fcnt_uuid())
						]
					];
					echo json_encode($return);
					die();
				}
		    }

		    $r4w_update_keys = explode('|', $setting_update);

			if($r4w_update_keys[1] == 'types_content'){
				switch ($r4w_update_keys[2]) {
					case 'post':
						$foreach = get_posts(['post_status'=>['publish', 'pending', 'draft']]);
						break;
					case 'page':
						$foreach = get_pages(['post_status'=>['publish', 'pending', 'draft']]);
						break;
					case 'product':
						$foreach = wc_get_products(['status'=> ['publish', 'pending', 'draft']]);
						break;
				}
				if(!empty($foreach)){
					foreach ($foreach as $document) {
						if(!empty($document->ID)){
							$document_id = $document->ID;
						}else{
							$document_id = $document->get_id();
						}
						if(!empty($document_id)){
							$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d AND config !=%s ",$document_id,'');
							$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);
					    	if(!empty($r4w_document)){
					    		$r4w_config =  json_decode(hex2bin($r4w_document['config']),true);
					    		unset($r4w_config['page']['index']);
					    		$r4w_config = bin2hex(json_encode($r4w_config));
					    		$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET config = %s WHERE id = %d", $r4w_config , $r4w_document['id']));
						    }
						}
					}
				}
			}

			$r4w_settings_update = [];
			$temp =& $r4w_settings_update;
			foreach($r4w_update_keys as $r4w_update_key) {
				$temp =& $temp[$r4w_update_key];
			}
			$temp = $setting_value;

			$r4w_new_settings = json_encode(array_replace_recursive($r4w_settings, $r4w_settings_update));
			
			$curl_data = [
				"request_method" => "PUT",
				"url" => "/wp/config/",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => [
						"wp_setting" => $r4w_new_settings
					]
				]
			];
			$curl = r4w_curl_request($curl_data);

			if($curl['err']) {
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			}
			if(isset($curl['resp']['error'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			}
			if(isset($curl['resp']['success'])){
				/**
				 * Enregistrement des données dans la table
				 */
				$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET settings = %s WHERE uuid = %s", $curl['resp']['success']['setting'], $r4w_app['uuid']));

			    if($setting_update == 'general_setting|feature|xml_sitemaps'){
			    	if($setting_value == 'on'){
			    		r4w_create_sitemap();
			    	}else{
			    		r4w_delete_sitemap();
			    	}
			    }

				$return = [
					'success' => [
						'request' => md5(r4w_fcnt_uuid())
					]
				];
				echo json_encode($return);
				die();
			}
			die();
		}
		add_action( 'wp_ajax_r4w_exec_settings', 'r4w_exec_settings' );

	/**
	 * Mise à jour des paramètre informations dans le cloud
	 */
		function r4w_exec_cloud_setting(){
			global $wpdb;

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_app['settings'])){
				if(!is_null(hex2bin($r4w_app['settings']))){
					$r4w_settings =  json_decode(hex2bin($r4w_app['settings']),true);
				}else{
					$r4w_settings =  [];
				}
			}else{
				$r4w_settings = [];
			}
			switch ($_POST['r4w_used']) {
				case 'cloud':
					$curl_data = [
						"request_method" => "GET",
						"url" => "/wp/config/",
						"auth" => "true",
						"postfileds" => [
							"json_encode" => true,
							"data" => null
						]
					];
					$curl = r4w_curl_request($curl_data);
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					}
					if(isset($curl['resp']['error'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					}
					if(isset($curl['resp']['success'])){
						$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET settings = %s WHERE uuid = %s", $curl['resp']['success']['settings'], $r4w_app['uuid']));
						$return = [
							'success' => [
								'url' =>  admin_url( 'admin.php?page=r4w_wizard' ),
								'request' => md5(r4w_fcnt_uuid())
							]
						];
						echo json_encode($return);
						die();
					}
				break;
				case 'wordpress':
					$curl_data = [
						"request_method" => "PUT",
						"url" => "/wp/config/",
						"auth" => "true",
						"json_return" => true,
						"postfileds" => [
							"json_encode" => true,
							"data" => [
								"wp_setting" => $r4w_settings
							]
						]
					];
					$curl = r4w_curl_request($curl_data);

					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					}
					if(isset($curl['resp']['error'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					}
					if(isset($curl['resp']['success'])){
						$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET last_backup = %s WHERE uuid = %s", $curl['resp']['success']['last_backup'], $r4w_app['uuid']));
						$return = [
							'success' => [
								'url' =>  admin_url( 'admin.php?page=r4w_settings' ),
								'request' => md5(r4w_fcnt_uuid())
							]
						];
						echo json_encode($return);
						die();
					}
					break;
			}
		}
		add_action( 'wp_ajax_r4w_exec_cloud_setting', 'r4w_exec_cloud_setting' );

	/**
	 * Enregistrement des paramètres de la page
	 */
		function r4w_exec_document(){
			global $wpdb;
			$wp_id = $_POST['wp_id'];
			$wp_type = $_POST['wp_type'];
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			$wp_table_taxonomy = $wpdb->prefix.r4w_bdd_table_taxonomy;

			if($wp_type == 'document'){
		    		$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$wp_id);
				$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);
			}
			if($wp_type == 'taxonomy'){
		    		$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_taxonomy} WHERE term_id = %d",$wp_id);
				$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);
			}
			if(empty($r4w_document['uuid'])){
				r4w_new_document($wp_type,$wp_id);
			}
			

			if(!empty($r4w_document['config'])){
				$r4w_config = hex2bin($r4w_document['config']);
				if($r4w_config != "null"){
					$r4w_config =  json_decode(hex2bin($r4w_document['config']),true);
				}else{
					$r4w_config = [];
				}
				
			}else{
				$r4w_config = [];
			}

			$config_update = $_POST['config_update'];
			$config_value = $_POST['config_value'];

			$r4w_update_keys = explode('|', $config_update);

			$r4w_config_update = [];
			$temp =& $r4w_config_update;
			foreach($r4w_update_keys as $r4w_update_key) {
				$temp =& $temp[$r4w_update_key];
			}
			$temp = $config_value;

			$r4w_new_configuration_page = bin2hex(json_encode(array_replace_recursive($r4w_config, $r4w_config_update)));

			/**
			 * Enregistrement / Mise à jour  de la configuration
			 */
			if($wp_type == 'document'){
		    		$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET config = %s WHERE post_id = %d", $r4w_new_configuration_page, $wp_id));
			}
			if($wp_type == 'taxonomy'){
				$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_taxonomy SET config = %s WHERE term_id = %d", $r4w_new_configuration_page, $wp_id));
			}

			$return = [
				'success' => [
					'request' => md5(r4w_fcnt_uuid())
				]
			];
			echo json_encode($return);
	    		die();
		}
		add_action( 'wp_ajax_r4w_exec_document', 'r4w_exec_document');

	/**
	 * Mettre à jour les fichiers
	 */
		function r4w_exec_tool_editor_files(){
			global $wpdb;
			if(!empty($_POST['wp_post_id'])){
				$post_id = $_POST['wp_post_id'];
			}
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			$wp_table_taxonomy = $wpdb->prefix.r4w_bdd_table_taxonomy;

			switch ($_POST['task']) {
				case 'editor_htaccess':
					$content = $_POST['file_cnt'];
					$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/.htaccess","wb");
					fwrite($fp,$content);
					fclose($fp);
					$return = [
						'success' => [
							'request' => md5(r4w_fcnt_uuid())
						]
					];
					echo json_encode($return);
					break;
				case 'editor_robots':
					$content = $_POST['file_cnt'];
					$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/robots.txt","wb");
					fwrite($fp,$content);
					fclose($fp);
					$return = [
						'success' => [
							'request' => md5(r4w_fcnt_uuid())
						]
					];
					echo json_encode($return);
					break;
			}
			die();
		}
		add_action( 'wp_ajax_r4w_exec_tool_editor_files', 'r4w_exec_tool_editor_files' );

	/**
	 * Enregistre les mots clés dans la structure
	 */
		function r4w_exec_editor_keyword(){
			if(!empty($_POST['r4w_type'])){
				if(!empty($_POST['r4w_semantic_uuid'])){
					$r4w_semantic_uuid = hex2bin($_POST['r4w_semantic_uuid']);
				}
				if(!empty($_POST['r4w_semantics_page'])){
					$r4w_semantics_page = $_POST['r4w_semantics_page'];
				}
				$curl_data = [
					"request_method" => "PUT",
					"url" => "/wp/structure/keyword/".$r4w_semantic_uuid,
					"auth" => "true",
					"postfileds" => [
						"json_encode" => true,
						"data" => [
							"type" => $_POST['r4w_type'],
							"semantics_page" => $r4w_semantics_page
						]
					]
				];
				$curl = r4w_curl_request($curl_data);
				if(isset($curl['err']) AND !empty($curl['err'])){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}
				if(isset($curl['resp']['error'])){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}
				if(isset($curl['resp']['success'])){
					$return = [
						'success' => [
							'data'=> $curl['resp']['success']['keywords'],
							'request' => md5(r4w_fcnt_uuid())
						]
					];
					echo json_encode($return);
					die();
				}
				die();
			}
	 		die();
		}
		add_action( 'wp_ajax_r4w_exec_editor_keyword', 'r4w_exec_editor_keyword' );

	/**
	 * Réinitialiser la configuration
	 */
		function r4w_exec_reset(){
			global $wpdb;
			if(!empty($_POST['wp_post_id'])){
				$post_id = $_POST['wp_post_id'];
			}
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			$wp_table_taxonomy = $wpdb->prefix.r4w_bdd_table_taxonomy;

			switch ($_POST['task']) {
				case 'reset_setting':
					$wp_update = $wpdb->query($wpdb->prepare("UPDATE ".$wp_table_app." SET settings=%s",''));
					r4w_delete_sitemap();
					$return = [
						'success' => [
							'url' =>  admin_url( 'admin.php?page=r4w_settings' ),
							'request' => md5(r4w_fcnt_uuid())
						]
					];
					echo json_encode($return);
					break;
				case 'reset_type_of_content':
					$wp_update = $wpdb->query($wpdb->prepare("UPDATE ".$wp_table_document." SET config=%s",''));
					$return = [
						'success' => [
							'request' => md5(r4w_fcnt_uuid())
						]
					];
					echo json_encode($return);
					break;
				case 'reset_taxonomy':
					$wp_update = $wpdb->query($wpdb->prepare("UPDATE ".$wp_table_taxonomy." SET config=%s",''));
					$return = [
						'success' => [
							'request' => md5(r4w_fcnt_uuid())
						]
					];
					echo json_encode($return);
					break;
			}
			die();
		}
		add_action( 'wp_ajax_r4w_exec_reset', 'r4w_exec_reset' );

	/**
	 * Export  configuration
	 */
		function r4w_exec_export(){
			global $wpdb;

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
		     $hash_param = hash('md5', r4w_fcnt_uuid());
		     $wp_update = $wpdb->query($wpdb->prepare("UPDATE ".$wp_table_app." SET hash='%s' WHERE id=%s",$hash_param,1));

			$return = [
				'success' => [
					'url' =>  admin_url( 'admin.php?page=r4w_export_configuration&hash='.$hash_param ),
					'request' => md5(r4w_fcnt_uuid())
				]
			];
			echo json_encode($return);
			die();
		}
		add_action( 'wp_ajax_r4w_exec_export', 'r4w_exec_export' );

	/**
	 * Import configuration
	 */
		function r4w_exec_import(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
   			$file = file_get_contents($_FILES["file"]["tmp_name"]);
   			$r4w_file = false;
   			if(ctype_xdigit($file) AND $_FILES["file"]["type"] == 'application/octet-stream'){
   				$file_config = json_decode(hex2bin($file),true);
   				if(is_array($file_config)){
   					$r4w_file = true;
   				}
   			}
   			if($r4w_file){
   				$wp_update = $wpdb->query($wpdb->prepare("UPDATE ".$wp_table_app." SET settings='%s' WHERE id=%s",$file,1));
				$return = [
					'success' => [
						'url' =>  admin_url( 'admin.php?page=r4w_settings' ),
						'request' => md5(r4w_fcnt_uuid())
					]
				];
				echo json_encode($return);
   			}else{
				$return = [
					'error' => [
						'name' =>  "Invalid file",
						'request' => md5(r4w_fcnt_uuid())
					]
				];
				echo json_encode($return);
   			}
			die();
		}
		add_action( 'wp_ajax_r4w_exec_import', 'r4w_exec_import' );

	/**
	 * Récupération des stratégies
	 */
		function r4w_exec_strategy(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
			$postfileds = array(
				"request" => "search_keyword",
				"word" => $_POST['r4w_word']
			);
			switch ($_POST['r4w_method']) {
	 			case 'r4w_strategy_list':
					$curl_data = [
						"request_method" => "GET",
						"url" => "/wp/strategy/",
						"auth" => "true",
						"postfileds" => [
							"json_encode" => true,
							"data" => [
								"request" => "search_keyword",
								"word" => $_POST['r4w_word']
							]
						]
					];
					$curl = r4w_curl_request($curl_data);
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					} else {
						if($curl['info']['http_code'] != 200){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}else{
							if(!empty($curl['resp']['success']['strategy'])){
								function r4w_score_strategy($a){
							        if($a<=29.99) {
							        	 return "#fc5252";
							        }
							        if($a>=30.00 and $a<=69.99) {
							        	 return "#ff7f00";
							        }
							        if($a>=70.00 and $a<=99.99) {
							            return "#8BC34A";
							        }
							        if($a>=100) {
							             return "#4fae33";
							        }
							    }
								$tpl_strategy = '';
								foreach ($curl['resp']['success']['strategy'] as $strategy) {
								    	if(!is_null($strategy['keywords'])){
								    		$keyword_work = 0;
								    		$keyword_total = 0;
											foreach (json_decode(hex2bin($strategy['keywords']),true) as $keyword) {
												$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE request = %d",$keyword);
												$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);
												if(!empty($r4w_document)){
													$keyword_work++;
												}
												$keyword_total++;
											}
											$keyword_info = $keyword_work.'/'.$keyword_total;
											$keyword_score = round($keyword_work * 100 / $keyword_total);
											if(!is_numeric($keyword_score) OR is_nan($keyword_score) OR is_null($keyword_score)){
												$keyword_score = 0;
											}
								    	}
									$loop_strategy = new r4w_template(r4w_plugin_base."/tpl/tools/tab_strategy/list_loop.tpl");
									$loop_strategy->set("title", hex2bin($strategy['name']));
									$loop_strategy->set("number_keywords", $keyword_info);
									$loop_strategy->set("score_keywords", $keyword_score.'%');
									$loop_strategy->set("score_color", r4w_score_strategy($keyword_score));
									$tpl_strategy .= $loop_strategy->output();
								}
							}
				            $return = [
				                'success' => [
				                	'strategy' => bin2hex(utf8_decode($tpl_strategy)),
				                    'request' => md5(r4w_fcnt_uuid())
				                ]
				            ];
							echo json_encode($return);
							die();
						}
					}
					break;
				case 'r4w_strategy_word':
					$curl_data = [
						"request_method" => "PUT",
						"url" => "/wp/strategy/",
						"auth" => "true",
						"postfileds" => [
							"json_encode" => true,
							"data" => [
								"request" => "search_keyword",
								"word" => $_POST['r4w_word']
							]
						]
					];
					$curl = r4w_curl_request($curl_data);
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					} else {
						if($curl['info']['http_code'] != 200){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}else{
				            $return = [
				                'success' => [
				                	'keywords' => [
				                		'suggestions' => $curl['resp']['success']['keywords']['suggestions'],
				                		'related' => $curl['resp']['success']['keywords']['related'],
				                		'answer' => $curl['resp']['success']['keywords']['answer']
				                	],
				                    'request' => md5(r4w_fcnt_uuid())
				                ]
				            ];
							echo json_encode($return);
							die();
						}
					}
					break;
				case 'r4w_strategy_str_structure':
					$curl_data = [
						"request_method" => "GET",
						"url" => "/wp/strategy/",
						"auth" => "true",
						"postfileds" => [
							"json_encode" => true,
							"data" => null
						]
					];
					$curl = r4w_curl_request($curl_data);
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					} else {
						if($curl['info']['http_code'] != 200){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}else{
							if(!empty($curl['resp']['success']['strategy'])){
								$tpl_strategy_option = '';
								foreach ($curl['resp']['success']['strategy'] as $strategy) {
									$tpl_strategy_option .= '<option value="'.$strategy['uuid'].'">'.hex2bin($strategy['name']).'</option>';
								}
							}
							if(empty($tpl_strategy_option)){
								$tpl_strategy = '<div class="css-g8re0erg8e0e">'.__('No keyword strategy available', 'app_rank4win').'</div>';
								$select = false;
							}else{
								$tpl_strategy = '<select id="r4w_str_structure_strategy" class="browser-default" name="r4w_str_structure_strategy">'.$tpl_strategy_option.'</select>';
								$select = true;
							}
				            $return = [
				                'success' => [
				                	'data' => bin2hex(utf8_decode($tpl_strategy)),
				                	'select' => $select,
				                    'request' => md5(r4w_fcnt_uuid())
				                ]
				            ];
							echo json_encode($return);
							die();
						}
					}
					break;
			}
		}
		add_action( 'wp_ajax_r4w_exec_strategy', 'r4w_exec_strategy' );

	/**
	 * Récupération des structures sémantique
	 */
		function r4w_exec_str_semantic(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			$wp_table_process = $wpdb->prefix.r4w_bdd_table_process;

		     $wp_select = "SELECT * from ".$wp_table_app;
		     $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_process} WHERE request = %s",'deploy');
		     $r4w_process = $wpdb->get_row($wp_select,ARRAY_A);

			switch ($_POST['r4w_method']) {
				case 'r4w_str_semantic_check':
					$curl_data = [
						"request_method" => "POST",
						"url" => "/wp/structure/semantic/".$_POST['r4w_semantic_uuid'],
						"auth" => "true",
						"postfileds" => [
							"json_encode" => true,
							"data" => [
								"method" => "check",
							]
						]
					];
					$curl = r4w_curl_request($curl_data);
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed',
								'url' => admin_url( 'admin.php?page=r4w_tools' )
							]
						];
						echo json_encode($return);
						die();
					}
					$url_deploy = admin_url( 'admin.php?page=r4w_tools&tab=deploy&diagram='.$_POST['r4w_semantic_uuid'] );
					if(!empty($curl['resp']['success'])){
						$return = [
							'success' => [
								'keyword' =>  $curl['resp']['success']['keyword'],
								'url_deploy' => $url_deploy,
								'request' => md5(r4w_fcnt_uuid())
							]
						];
						echo json_encode($return);
						die();
					}
				break;
	 			case 'r4w_str_semantic_list':
					$curl_data = [
						"request_method" => "GET",
						"url" => "/wp/structure/semantic/",
						"auth" => "true",
						"postfileds" => [
							"json_encode" => true,
							"data" => null
						]
					];
					$curl = r4w_curl_request($curl_data);
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					} else {
						if($curl['info']['http_code'] != 200){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}else{
							$tpl_str_semantic = '';
							$tpl_msgsync_str_semantic = '';
							if(!empty($curl['resp']['success']['str_semantic'])){
								foreach ($curl['resp']['success']['str_semantic'] as $semantic) {
									$loop_str_semantic = new r4w_template(r4w_plugin_base."/tpl/tools/tab_str_semantic/list_loop.tpl");
									$loop_str_semantic->set("title", stripcslashes(hex2bin($semantic['name'])));
									$loop_str_semantic->set("number_page",' '.sprintf(_n("%s page", "%s pages",$semantic['page'],'app_rank4win'),number_format_i18n($semantic['page'])));
									if(!empty($semantic['picture'])){
										$loop_str_semantic->set("preview_image", 'style="background-image: url('.hex2bin($semantic['picture']).');    background-size: contain;"');
									}else{
										$loop_str_semantic->set("preview_image", '');
									}
									$loop_str_semantic->set("uuid_str_strategy", $semantic['uuid']);
									$url_editor = admin_url( 'admin.php?page=r4w_editor' ).'&diagram='.bin2hex($semantic['uuid']);
									$loop_str_semantic->set("url_editor", $url_editor);
									$diagram_sync = '';
									$delete_str = __('Delete structure', 'app_rank4win');
									if($semantic['sync']){
										$diagram_sync = '<div class="css-d5sd0s5d">'.r4w_assets_svg_code('sync').'</div>';
										$delete_str = __('Remove sync', 'app_rank4win');
									}
									$protected_sync = '';
									$url_deploy = admin_url( 'admin.php?page=r4w_tools&tab=deploy&diagram='.bin2hex($semantic['uuid']) );
									//<a class="r4w_deploy_str_semantic" href="'.$url_deploy.'">'.__('Deploy the structure', 'app_rank4win').'</a>
									$show_menu = '<a href="'.$url_editor.'">'.__('Open', 'app_rank4win').'</a> <a class="r4w_rename_str_semantic" href="#">'.__('Rename', 'app_rank4win').'</a> <a class="r4w_duplicate_str_semantic" href="#">'.__('Duplicate', 'app_rank4win').'</a>  <a class="r4w_image_str_semantic" href="#">'.__('Retrieve the image of the structure', 'app_rank4win').'</a> <a class="r4w_str_semantic_delete delete" href="#">'.$delete_str.'</a>';
									if($semantic['protected']){
										$diagram_sync = '<div class="css-sd6e0fe5fe">'.r4w_assets_svg_code('shild').'</div>';
										$protected_sync = 'protected';
										$show_menu = '<a href="'.$url_editor.'">'.__('Open', 'app_rank4win').'</a>';
									}
									$loop_str_semantic->set("show_menu", $show_menu);
									$loop_str_semantic->set("protected", $protected_sync);
									$loop_str_semantic->set("diga_sync", $diagram_sync);
									$tpl_str_semantic .= $loop_str_semantic->output();
									if($semantic['sync']){
						    			$tpl_msgsync_str_semantic .= bin2hex(utf8_decode('<div class="r4w_bullet_info"> <div class="css-sd5r0fze5">'.r4w_assets_svg_code('sync').'</div> <div class="css-df5r0grg">'.__('A semantic structure is synchronized with your WordPress. When you edit your pages, your semantic structure automatically updates. If you enter your semantic structure, you will have to deploy your structure again to synchronize it with your wordpress', 'app_rank4win').'.</div> </div>'));
						    		}
								}
								$tpl_str_semantic = bin2hex(utf8_decode($tpl_str_semantic));
							}
				            $return = [
				                'success' => [
				                	'str_semantic' => $tpl_str_semantic,
			                		'msg_sync' => $tpl_msgsync_str_semantic,
				                    'request' => md5(r4w_fcnt_uuid())
				                ]
				            ];
							echo json_encode($return);
							die();
						}
					}
				break;
				case 'r4w_str_semantic_sync':
					$file_page_hash = r4w_fcnt_uuid();
		          	$target_dir = r4w_plugin_base.'/temp/';
					if (!file_exists($target_dir)) {
					    mkdir($target_dir, 0755, true);
					}
					if (file_put_contents($target_dir.'page_'.$file_page_hash.'.r4w', base64_encode(json_encode(r4w_existing_pages(),JSON_UNESCAPED_UNICODE))) !== false) {
						$file_create_page = true;
						$url_file = plugins_url(r4w_plugin_name.'/temp/page_'.$file_page_hash.'.r4w');
					}
					$curl_data = [
						"request_method" => "POST",
						"url" => "/wp/structure/semantic/".$_POST['r4w_semantic_uuid'],
						"auth" => "true",
						"postfileds" => [
							"json_encode" => true,
							"data" => [
								"method" => "sync",
								"str_page" => $url_file
							]
						]
					];
					$curl = r4w_curl_request($curl_data);
					if($file_create_page){
						unlink($target_dir.'page_'.$file_page_hash.'.r4w');
					}
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed',
								'url' => admin_url( 'admin.php?page=r4w_tools' )
							]
						];
						echo json_encode($return);
						die();
					} else {
						if($curl['info']['http_code'] != 200){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed',
									'url' => admin_url( 'admin.php?page=r4w_tools' )
								]
							];
							echo json_encode($return);
							die();
						}else{
							if(!empty($curl['resp']['success']['str_semantic'])){
								$return = [
					                'success' => [
					                	'str_semantic' => [
					                		'name' => $curl['resp']['success']['str_semantic']['name'],
					                		'editor' =>  $curl['resp']['success']['str_semantic']['data'],
					                		'hash' => $curl['resp']['success']['str_semantic']['hash'],
					                	],
					                    'request' => md5(r4w_fcnt_uuid())
					                ]
					            ];
								echo json_encode($return);
								die();
							}
						}
					}
				break;
				case 'r4w_str_semantic_view':
					$curl_data = [
						"request_method" => "POST",
						"url" => "/wp/structure/semantic/".$_POST['r4w_semantic_uuid'],
						"auth" => "true",
						"json_return" => true,
						"postfileds" => [
							"json_encode" => true,
							"data" => [
								"method" => "recovery",
							]
						]
					];
					$curl = r4w_curl_request($curl_data);
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed',
								'url' => admin_url( 'admin.php?page=r4w_tools' )
							]
						];
						echo json_encode($return);
						die();
					} else {
						
						if($curl['info']['http_code'] != 200){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed',
									'url' => admin_url( 'admin.php?page=r4w_tools' )
								]
							];
							echo json_encode($return);
							die();
						}else{
							$str_search = new r4w_template(r4w_plugin_base."/tpl/editor/str_search.tpl");
							$str_search->set("placeholder_search", __('Enter a word', 'app_rank4win'));
							$tpl_msgprotected_str_semantic = '';
							if($curl['resp']['success']['str_semantic']['protected']){
								$tpl_msgprotected_str_semantic = bin2hex(utf8_decode('<div class="r4w_bullet_info"> <div class="css-sd5r0fze5">'.r4w_assets_svg_code('shild').'</div> <div class="css-df5r0grg">'.sprintf(__('This semantic structure is synchronized with %s. The backup of the changes is possible from this wordpress. You can duplicate this semantic structure if you want to save your changes', 'app_rank4win'),$curl['resp']['success']['str_semantic']['protected']).'.</div> </div>'));
								$protected = true;
							}else{
								$protected = false;
							}
							if(!empty($curl['resp']['success']['str_semantic'])){
								$url_deploy = admin_url( 'admin.php?page=r4w_tools&tab=deploy&diagram='.$_POST['r4w_semantic_uuid'] );
								$desync = false;
								$page_structure = [];
								$page_structure = base64_decode($curl['resp']['success']['str_semantic']['data']);
								if(!is_array($page_structure)){
									$page_structure = json_decode($page_structure,true);
								}
								if($curl['resp']['success']['str_semantic']['sync'] == 1){
									
									$page_wordpress = [];								
									$page_wordpress = r4w_existing_pages();
									
									function array_diff_assoc_recursive($array1, $array2){
										$difference = array();
										
										foreach ($array1 as $key => $value) {
											if (is_array($value)) {
												if (!isset($array2[$key]) || !is_array($array2[$key])) {
													$difference[$key] = $value;
												} else {
													$new_diff = array_diff_assoc_recursive($value, $array2[$key]);
													if (!empty($new_diff)) {
														$difference[$key] = $new_diff;
													}
												}
											} elseif (!array_key_exists($key, $array2) || $array2[$key] !== $value) {
												$difference[$key] = $value;
											}
										}
										
										return $difference;
									}
			
									$result_array = array_diff_assoc_recursive($page_structure, $page_wordpress);
				
									if(!empty($result_array)){
										$desync = true;
									}
								}
								$return = [
					                'success' => [
					                	'str_semantic' => [
					                		'name' => $curl['resp']['success']['str_semantic']['name'],
					                		'editor' => base64_encode(utf8_decode(json_encode($page_structure))),
					                		'hash' => $curl['resp']['success']['str_semantic']['hash'],
										'protected' => $protected,
										'desync' => $desync
					                	],
									'url_deploy' => $url_deploy,
					                	'msg_protected' => $tpl_msgprotected_str_semantic,
					                	'str_search' => bin2hex(utf8_decode($str_search->output())),
					                    'request' => md5(r4w_fcnt_uuid())
					               	]
					            	];
								echo json_encode($return);

								
								die();
							}
						}
					}
				break;
				case 'r4w_str_semantic_update':
					$file_data_hash = r4w_fcnt_uuid();
					$file_picture_hash = r4w_fcnt_uuid();
		            	$target_dir = r4w_plugin_base.'/temp/';

					if (!file_exists($target_dir)) {
					    mkdir($target_dir, 0755, true);
					}
					if (file_put_contents($target_dir.'editor_'.$file_data_hash.'.r4w', file_get_contents($_FILES["r4w_data"]["tmp_name"])) !== false) {
						$file_create_data = true;
					}
					if (file_put_contents($target_dir.'picture_'.$file_picture_hash.'.r4w', file_get_contents($_FILES["r4w_picture"]["tmp_name"])) !== false) {
						$file_create_picture = true;
					}
					$url_data = plugins_url(r4w_plugin_name.'/temp/editor_'.$file_data_hash.'.r4w');
					$url_picture = plugins_url(r4w_plugin_name.'/temp/picture_'.$file_picture_hash.'.r4w');
					$curl_data = [
						"request_method" => "POST",
						"url" => "/wp/structure/semantic/".$_POST['r4w_uuid'],
						"auth" => "true",
						"postfileds" => [
							"json_encode" => true,
							"data" => [
								"method" => "update",
								"url_data" => $url_data,
								"url_picture" => $url_picture,
								"hash" => $_POST['r4w_hash']
							]
						]
					];
					$curl = r4w_curl_request($curl_data);
					if($file_create_data){
						//unlink($target_dir.'editor_'.$file_data_hash.'.r4w');
					}
					if($file_create_picture){
						unlink($target_dir.'picture_'.$file_picture_hash.'.r4w');
					}
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					} else {
						if($curl['info']['http_code'] != 200){
							if($curl['info']['http_code'] == 403){
								$return = [
									'error' => [
										'name' => 'user_conflicts',
										'description' => 'User conflicts between users'
									]
								];
								echo json_encode($return);
								die();
							}else{
								$return = [
									'error' => [
										'name' => 'browser_refresh',
										'description' => 'Browser refresh needed'
									]
								];
								echo json_encode($return);
								die();
							}
						}else{
							$return = [
				                'success' => [
				                	'hash' => $curl['resp']['success']['hash'],
				                    'request' => md5(r4w_fcnt_uuid())
				                ]
				            ];
							echo json_encode($return);
							die();
						}
					}
				break;
				case 'r4w_str_semantic_create':
					switch ($_POST['r4w_str_content']) {
						case 'a1787db4-59b4-4de5-9dd9-17d2cfbd8c35':
							$postfileds = [
								"method" => "create",
								"str_name" => $_POST['r4w_str_name'],
								"str_content" => $_POST['r4w_str_content']
							];
							break;
						case '65696b7e-b217-4945-bff5-2bd43fe04d0a':
							$file_page_hash = r4w_fcnt_uuid();
				            $target_dir = r4w_plugin_base.'/temp/';
							if (!file_exists($target_dir)) {
							    mkdir($target_dir, 0755, true);
							}
							if (file_put_contents($target_dir.'page_'.$file_page_hash.'.r4w', bin2hex(json_encode(r4w_existing_pages(),JSON_UNESCAPED_UNICODE))) !== false) {
								$file_create_page = true;
							}
							$url_page = plugins_url(r4w_plugin_name.'/temp/page_'.$file_page_hash.'.r4w');
							$postfileds = [
								"method" => "create",
								"str_name" => $_POST['r4w_str_name'],
								"str_content" => $_POST['r4w_str_content'],
								"str_page" => $url_page
							];
							break;
						case 'ff55c431-be25-4f81-b23c-680ea9a9e935':
							$postfileds = [
								"method" => "create",
								"str_name" => $_POST['r4w_str_name'],
								"str_content" => $_POST['r4w_str_content'],
								"str_strategy" => $_POST['r4w_str_strategy']
							];
							break;
					}
					$curl_data = [
						"request_method" => "POST",
						"url" => "/wp/structure/semantic/",
						"auth" => "true",
						"postfileds" => [
							"json_encode" => true,
							"data" => $postfileds
						]
					];
					$curl = r4w_curl_request($curl_data);
					if($file_create_page){
						unlink($target_dir.'page_'.$file_page_hash.'.r4w');
					}
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					} else {
						if($curl['info']['http_code'] != 200){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}else{
				            $return = [
				                'success' => [
				                    'request' => md5(r4w_fcnt_uuid())
				                ]
				            ];
							echo json_encode($return);
							die();
						}
					}
				break;
				case 'r4w_str_semantic_duplicate':
					$curl_data = [
						"request_method" => "POST",
						"url" => "/wp/structure/semantic/".$_POST['r4w_str_semantic_uuid'],
						"auth" => "true",
						"postfileds" => [
							"json_encode" => true,
							"data" => [
								"method" => "duplicate",
							]
						]
					];
					$curl = r4w_curl_request($curl_data);
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					} else {
						if($curl['info']['http_code'] != 200){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}else{
				            $return = [
				                'success' => [
				                    'request' => md5(r4w_fcnt_uuid())
				                ]
				            ];
							echo json_encode($return);
							die();
						}
					}
				break;
				case 'r4w_str_semantic_delete':
					$curl_data = [
						"request_method" => "DELETE",
						"url" => "/wp/structure/semantic/".$_POST['r4w_str_semantic_uuid'],
						"auth" => "true",
						"postfileds" => [
							"json_encode" => true,
							"data" => null
						]
					];
					$curl = r4w_curl_request($curl_data);
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					} else {
						if($curl['info']['http_code'] != 200){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}else{
				            $return = [
				                'success' => [
				                    'request' => md5(r4w_fcnt_uuid())
				                ]
				            ];
							echo json_encode($return);
							die();
						}
					}
				break;
				case 'r4w_str_semantic_rename':
					$curl_data = [
						"request_method" => "POST",
						"url" => "/wp/structure/semantic/".$_POST['r4w_str_semantic_uuid'],
						"auth" => "true",
						"postfileds" => [
							"json_encode" => true,
							"data" => [
								"str_name" => $_POST['r4w_str_name'],
								"method" => 'rename'
							]
						]
					];
					$curl = r4w_curl_request($curl_data);
					if(isset($curl['err']) AND !empty($curl['err'])){
						$return = [
							'error' => [
								'name' => 'browser_refresh',
								'description' => 'Browser refresh needed'
							]
						];
						echo json_encode($return);
						die();
					} else {
						if($curl['info']['http_code'] != 200){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						}else{
				            $return = [
				                'success' => [
				                    'request' => md5(r4w_fcnt_uuid())
				                ]
				            ];
							echo json_encode($return);
							die();
						}
					}
				break;
				case 'r4w_str_semantic_image':
					$curl_data = [
						"request_method" => "POST",
						"url" => "/wp/structure/semantic/".$_POST['r4w_str_semantic_uuid'],
						"auth" => "true",
						"json_return" => false,
						"postfileds" => [
							"json_encode" => true,
							"data" => [
								"method" => 'image'
							]
						]
					];
					$curl = r4w_curl_request($curl_data);
					if ($curl) {
						$file_image_hash = r4w_fcnt_uuid();
			            $target_dir = r4w_plugin_base.'/temp/';
						if (!file_exists($target_dir)) {
						    mkdir($target_dir, 0755, true);
						}
						if (file_put_contents($target_dir.'structure_'.$file_image_hash.'.jpeg', $curl) !== false) {
							$file_create_structure_image = true;
						}
			            $return = [
			                'success' => [
			                	'url' => admin_url( 'admin.php?page=r4w_download_str_image&hash='.$file_image_hash ),
			                    'request' => md5(r4w_fcnt_uuid())
			                ]
			            ];
						echo json_encode($return);
						die();
					}
				break;
				case 'r4w_str_semantic_deploy':
						if(empty($r4w_process)){
							$deploy = false;
						}else{
							$deploy = true;
						}
			            $return = [
			                'success' => [
			                	'process' => $deploy,
			                    'request' => md5(r4w_fcnt_uuid())
			                ]
			            ];
						echo json_encode($return);
						die();
					break;
			}
		}
		add_action( 'wp_ajax_r4w_exec_str_semantic', 'r4w_exec_str_semantic' );

	/**
	* Récupération des déploiement effectué
	*/
		function r4w_exec_list_deploy(){
			global $wpdb;

			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/structure/deploy",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl = r4w_curl_request($curl_data);
			$tpl_strategy = '';

			foreach ($curl['resp']['success']['deploy'] as $deploy_uuid => $list_deploy) {
				$loop_deploy = new r4w_template(r4w_plugin_base."/tpl/tools/tab_deploy/list_loop.tpl");
				$loop_deploy->set("title", stripcslashes($list_deploy['title']));
				$loop_deploy->set("status", $list_deploy['status']);
				$loop_deploy->set("uuid", $deploy_uuid);
				switch ($list_deploy['status']) {
					case 'progress':
						$loop_deploy->set("status_bar", '<div class="css-gkktth89y2d"> <div class="css-f8egeg89e"> <div class="css-55e2eg82rg">'.__( 'Elapsed time', 'app_rank4win' ).':</div> <div class="css-5d5f5gr8gr5"> <div class="countup" id="ghl_deploy_progress"> <span class="timeel hours">00</span> <span class="timeel timeRefHours">'.__( 'hours', 'app_rank4win' ).'</span> <span class="timeel minutes">00</span> <span class="timeel timeRefMinutes">'.__( 'minutes', 'app_rank4win' ).'</span> <span class="timeel seconds">00</span> <span class="timeel timeRefSeconds">'.__( 'seconds', 'app_rank4win' ).'</span> </div> </div> </div> <div class="css-5fe5f2gee"> <div class="css-55e2eg82rg">'.__( 'Page', 'app_rank4win' ).':</div> <div class="css-5d5f5gr8gr5">'.$list_deploy['page'].'</div> </div> </div> <div class="css-f6efe5f2e"> <div class="css-55e2eg82rg">'.__( 'Status', 'app_rank4win' ).':</div> <div class="css-5d5f5gr8gr5">'.__( 'Deployment in progress', 'app_rank4win' ).'</div> </div>');
						$loop_deploy->set("svg", '<svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0"  viewBox="0 0 128 128" xml:space="preserve"><g transform="rotate(190.153 64 64)"><path d="M109.25 55.5h-36l12-12a29.54 29.54 0 0 0-49.53 12H18.75A46.04 46.04 0 0 1 96.9 31.84l12.35-12.34v36zm-90.5 17h36l-12 12a29.54 29.54 0 0 0 49.53-12h16.97A46.04 46.04 0 0 1 31.1 96.16L18.74 108.5v-36z"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1200ms" repeatCount="indefinite"/></g></svg>');
					break;
					case 'done':
						$hours = floor($list_deploy['finish'] / 3600);
						$mins = floor($list_deploy['finish'] / 60 % 60);
						$secs = floor($list_deploy['finish'] % 60);
						$loop_deploy->set("status_bar", '<div class="css-gkktth89y2d"> <div class="css-f8egeg89e"> <div class="css-55e2eg82rg"> '.__( 'Deploy in', 'app_rank4win' ).' :</div> <div class="css-5d5f5gr8gr5"> <div id="ghl_deploy_progress"> <span class="timeel hours">'.$hours.'</span> <span class="timeel timeRefHours"> '.__( 'hours', 'app_rank4win' ).' </span> <span class="timeel minutes">'.$mins.'</span> <span class="timeel timeRefMinutes"> '.__( 'minutes', 'app_rank4win' ).' </span> <span class="timeel seconds">'.$secs.'</span> <span class="timeel timeRefSeconds"> '.__( 'seconds', 'app_rank4win' ).' </span> </div> </div> </div> <div class="css-5fe5f2gee"> <div class="css-55e2eg82rg"> '.__( 'Page', 'app_rank4win' ).' :</div> <div class="css-5d5f5gr8gr5">'.$list_deploy['page'].'</div> </div> </div> <div class="css-f6efe5f2e"> <div class="css-55e2eg82rg"> '.__( 'Status', 'app_rank4win' ).':</div> <div class="css-5d5f5gr8gr5"> '.__( 'Deployment complete', 'app_rank4win' ).' </div> </div>');
						$loop_deploy->set("svg", '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 442.533 442.533" xml:space="preserve"><path d="M434.539,98.499l-38.828-38.828c-5.324-5.328-11.799-7.993-19.41-7.993c-7.618,0-14.093,2.665-19.417,7.993L169.59,247.248   l-83.939-84.225c-5.33-5.33-11.801-7.992-19.412-7.992c-7.616,0-14.087,2.662-19.417,7.992L7.994,201.852  C2.664,207.181,0,213.654,0,221.269c0,7.609,2.664,14.088,7.994,19.416l103.351,103.349l38.831,38.828 c5.327,5.332,11.8,7.994,19.414,7.994c7.611,0,14.084-2.669,19.414-7.994l38.83-38.828L434.539,137.33 c5.325-5.33,7.994-11.802,7.994-19.417C442.537,110.302,439.864,103.829,434.539,98.499z"></path></svg>');
					break;
					case 'warning':
						$loop_deploy->set("status_bar", '<div class="css-gg5s56f29e2f"> <div class="css-55e2eg82rg">' .__( 'Status', 'app_rank4win' ).':</div> <div class="css-5d5f5gr8gr5"> <div class="css-sdf62rrgge">  '.__( 'Your deployment has not been successful', 'app_rank4win' ).' </div> <a href="https://join.skype.com/invite/ea0wSiTNKDqa" target="_blank" class="css-3134a1f79f1e"><div class="css-2fe5e2ezzede">Contactez-nous</div> </a></div> </div>');
						$loop_deploy->set("svg", '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve" class="css-5e0fe8ef5e2e"><path d="M507.494,426.066L282.864,53.537c-5.677-9.415-15.87-15.172-26.865-15.172c-10.995,0-21.188,5.756-26.865,15.172    L4.506,426.066c-5.842,9.689-6.015,21.774-0.451,31.625c5.564,9.852,16.001,15.944,27.315,15.944h449.259 c11.314,0,21.751-6.093,27.315-15.944C513.508,447.839,513.336,435.755,507.494,426.066z M256.167,167.227 c12.901,0,23.817,7.278,23.817,20.178c0,39.363-4.631,95.929-4.631,135.292c0,10.255-11.247,14.554-19.186,14.554 c-10.584,0-19.516-4.3-19.516-14.554c0-39.363-4.63-95.929-4.63-135.292C232.021,174.505,242.605,167.227,256.167,167.227z M256.498,411.018c-14.554,0-25.471-11.908-25.471-25.47c0-13.893,10.916-25.47,25.471-25.47c13.562,0,25.14,11.577,25.14,25.47 C281.638,399.11,270.06,411.018,256.498,411.018z"></path></svg>');
					break;
					case 'cancel':
						$loop_deploy->set("status_bar", '<div class="css-gg5s56f29e2f"> <div class="css-55e2eg82rg">' .__( 'Status', 'app_rank4win' ).':</div> <div class="css-5d5f5gr8gr5"> <div class="css-sdf62rrgge">  '.__( 'You canceled deployment', 'app_rank4win' ).' </div>  </div> </div>');
						$loop_deploy->set("svg", '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.992 511.992"><path d="m415.402344 495.421875-159.40625-159.410156-159.40625 159.410156c-22.097656 22.09375-57.921875 22.09375-80.019532 0-22.09375-22.097656-22.09375-57.921875 0-80.019531l159.410157-159.40625-159.410157-159.40625c-22.09375-22.097656-22.09375-57.921875 0-80.019532 22.097657-22.09375 57.921876-22.09375 80.019532 0l159.40625 159.410157 159.40625-159.410157c22.097656-22.09375 57.921875-22.09375 80.019531 0 22.09375 22.097657 22.09375 57.921876 0 80.019532l-159.410156 159.40625 159.410156 159.40625c22.09375 22.097656 22.09375 57.921875 0 80.019531-22.097656 22.09375-57.921875 22.09375-80.019531 0zm0 0"></path></svg>');
					break;
				}
				$tpl_strategy .= $loop_deploy->output();
			}
			$return = [
				'success' => [
					'progress' => $curl['resp']['success']['progress'],
					'deploy' => $tpl_strategy,
					'request' => md5(r4w_fcnt_uuid())
				]
			];
			echo json_encode($return);
			die();
		}
		add_action( 'wp_ajax_r4w_exec_list_deploy', 'r4w_exec_list_deploy' );

	/**
	 * Création d'une page via une stratégie
	 */
		function r4w_exec_create_page(){
			global $wpdb, $wp, $r4w_define;

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
	    		$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

		    	$wp_select = "SELECT * from ".$wp_table_app;
		    	$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			$post_available = false;
			if(!empty($_POST['r4w_post_types']) AND !empty($r4w_define['app']['post_types'])){
				foreach ($r4w_define['app']['post_types'] as $r4w_post_type) {
			       if ($r4w_post_type['slug'] == $_POST['r4w_post_types']) {
			           $post_available = true;
			       }
	  			}
			}
			if(!$post_available OR empty($_POST['r4w_post_data'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
		    		die();
			}

			$my_post = [
				'post_title' => hex2bin($_POST['r4w_post_data']).' : ',
				'post_type'     => $_POST['r4w_post_types'],
				'post_status' => 'draft',
			];
			$post_id = wp_insert_post( $my_post );
			$wp_document_uuid = r4w_new_document('document', $post_id);

			if(!empty($_POST['r4w_post_data'])){
				$post_keyword = hex2bin($_POST['r4w_post_data']);
				$keywords_main = json_encode([$post_keyword]);
				$curl_data = [
					"request_method" => "PUT",
					"url" => "/wp/create/document",
					"auth" => "true",
					"postfileds" => [
						"json_encode" => true,
						"data" => [
							"uuid" => $wp_document_uuid,
							"wp_post_id" => $post_id,
							"keywords_main" => $post_keyword
						]
					]
				];
				$curl = r4w_curl_request($curl_data);
				if(isset($curl['err']) AND !empty($curl['err'])){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}
				if(isset($curl['resp']['error'])){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}
				if(isset($curl['resp']['success'])){
					/**
					 * Enregistrement / Mise a jour des données dans la table
					 */
					$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET keywords_main = %s, locale_uuid = %s, t_create = %s, t_update = %s WHERE uuid = %s", $keywords_main, $curl['resp']['success']['locale_uuid'], $curl['resp']['success']['timestamp'], $curl['resp']['success']['timestamp'], $wp_document_uuid));
					$return = [
						'success' => [
							'url' => admin_url( 'post.php?post='.$post_id.'&action=edit' ),
							'request' => md5(r4w_fcnt_uuid())
						]
					];
					echo json_encode($return);
					die();
				}
				die();
			}
		}
		add_action( 'wp_ajax_r4w_exec_create_page', 'r4w_exec_create_page' );

	/**
	 * Récupération du produit
	 */
		function r4w_exec_products(){
			global $wpdb;
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/account/",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl_account = r4w_curl_request($curl_data);
			if(isset($curl_account['err']) AND !empty($curl_account['err'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			} else {
				if($curl_account['info']['http_code'] != 200){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}else{
					if($curl_account['resp']['success']['account']['subscription']){
						$already_subscribed = new r4w_template(r4w_plugin_base."/tpl/subscription/already_subscribed.tpl");
						$already_subscribed->set("url_another_account", admin_url( 'admin.php?page=r4w_auth_login' ));
						$already_subscribed->set("url_manage_subscription", admin_url( 'admin.php?page=r4w_account' ));
						$already_subscribed->set("we_love", sprintf(__( 'We love you too much for taking your hard earned money twice. The user %s already has a rank4win subscription', 'app_rank4win' ), $curl_account['resp']['success']['account']['email']) );
						$tpl_already_subscribed = $already_subscribed->output();
			            $return = [
			                'success' => [
			                	'preview' => $tpl_already_subscribed,
			                    'request' => md5(r4w_fcnt_uuid())
			                ]
			            ];
						echo json_encode($return);
						die();
					}else{
						$product_uuid = '';
						if(!empty($_POST['product_uuid'])){
							$product_uuid = $_POST['product_uuid'];
						}
						if(!empty($_POST['product_unit'])){
							$product_unit = [ "unit" => $_POST['product_unit'] ];
						}else{
							$product_unit = null;
						}
						$curl_data = [
							"request_method" => "GET",
							"url" => "/wp/products/".$product_uuid,
							"auth" => "true",
							"postfileds" => [
								"json_encode" => true,
								"data" => $product_unit
							]
						];
						$curl = r4w_curl_request($curl_data);
						if(isset($curl['err']) AND !empty($curl['err'])){
							$return = [
								'error' => [
									'name' => 'browser_refresh',
									'description' => 'Browser refresh needed'
								]
							];
							echo json_encode($return);
							die();
						} else {
							if($curl['info']['http_code'] != 200){
								$return = [
									'error' => [
										'name' => 'browser_refresh',
										'description' => 'Browser refresh needed'
									]
								];
								echo json_encode($return);
								die();
							}else{
								if(!empty($curl['resp']['success']['products'])){

     									switch ($_POST['method']) {
     										case 'product':
     											$price_products = '';
                                                            if(empty($product_uuid)){
                                                                 foreach ($curl['resp']['success']['products'] as $products) {
                                                                      $this_popular = '';
                                                                      if(isset($products['metadata']['display_popular']) AND $products['metadata']['display_popular'] == "true"){
                                                                           $this_popular = " popular";
                                                                      }
                                                                      if(!isset($products['amount_ht']) OR $products['amount_ht'] == 0){
                                                                           $product_head = '<div class="table-cell product'.$this_popular.'"> <h3>'.r4w_fcnt_locale_tag_js($products['name']).'</h3> </div>';
                                                                      }else{
                                                                           $product_head = '<div class="table-cell product'.$this_popular.'"> <h3>'.r4w_fcnt_locale_tag_js($products['name']).'</h3> <div class="css-5f0ezgererg">'.r4w_price_currency($products['currency'],$products['amount_ht']).' '.r4w_fcnt_locale_tag_js($products['interval']).'</div> <div class="r4w_box_subscription" data-plan="'.$products['uuid'].'" data-unit="1"> <a href="#" class="btn r4w_open_subscribe">'.__('Subscribe','app_rank4win').'</a> </div> </div>';
                                                                      }
                                                                      $price_products .= $product_head;
                                                                 }
                                                                 $feature_products = '';
                                                                 foreach ($curl['resp']['success']['display'] as $display) {
                                                                      $feature_products .= '<div class="tab-cell-group">'.r4w_fcnt_locale_tag_js($display['set']).'</div>';
                                                                      foreach ($display['subset'] as $subset) {
                                                                           $feature_products .= '<div class="table-cell-content">';
                                                                           $feature_products .= '<div class="table-cell cell-feature">'.r4w_fcnt_locale_tag_js($subset['name']).'</div>';
                                                                           foreach ($curl['resp']['success']['products'] as $products) {
                                                                                $feature_class = '';
                                                                                $feature_cnt = '';
                                                                                switch ($subset['type']) {
                                                                                     case 'manual':
                                                                                          if($subset['value'] == "true"){
                                                                                               $feature_cnt = r4w_assets_svg_code('check');
                                                                                               $feature_class = ' check';
                                                                                          }else{
                                                                                               $feature_cnt = r4w_assets_svg_code('cross');
                                                                                               $feature_class = ' cross';
                                                                                          }
                                                                                     break;
                                                                                     case 'boolean':
                                                                                          if(isset($products['metadata'][$subset['id']])){
                                                                                               if($products['metadata'][$subset['id']] == "true"){
                                                                                                    $feature_cnt = r4w_assets_svg_code('check');
                                                                                                    $feature_class = ' check';
                                                                                               }else{
                                                                                                    $feature_cnt = r4w_assets_svg_code('cross');
                                                                                                    $feature_class = ' cross';
                                                                                               }
                                                                                          }
                                                                                     break;
                                                                                     case 'text':
                                                                                          if(isset($products['metadata'][$subset['id']])){
                                                                                               if(is_numeric($products['metadata'][$subset['id']])){
                                                                                                    $feature_cnt = $products['metadata'][$subset['id']];
                                                                                               }else{
                                                                                                    if( $subset['id'] == 'subscription_wordpress' AND $products['metadata'][$subset['id']] == "limited"){
                                                                                                         $feature_cnt = __( 'From 1 to 300', 'app_rank4win' );
                                                                                                    }else{
                                                                                                         $feature_cnt = r4w_fcnt_locale_tag_js($products['metadata'][$subset['id']]);
                                                                                                    }
                                                                                               }
                                                                                               if(!empty($subset['cnt'])){
                                                                                                    foreach ($subset['cnt'] as $cnt_id => $cnt) {
																					switch ($cnt['text']) {
																						case 'from_to_per_page':
																							if($cnt_id != 0){
																								$cnt['text'] = '';
																								foreach ($curl['resp']['success']['feature']['editor_deploystructure'][$products['name']] as $feature) {
																									if($feature['price'] != 0){
																										if($feature['end'] == null){
																											$feature['end'] = __( 'and more', 'app_rank4win' );
																										}else{
																											$feature['end'] = __('to', 'app_rank4win' ).' '.$feature['end'];
																										}
																										$cnt_tr = sprintf(__('From %s %s : %s / pages','app_rank4win'), 		$feature['start'],$feature['end'],r4w_price_currency($products['currency'],$feature['price']));
																										$cnt['text'] .= "\n".'<div class="css-5dfefeer">'.$cnt_tr.'</div>';
																									}
																								}
		                                                                                                         }
																						break;
																						default:
																							$cnt['text'] = r4w_fcnt_locale_tag_js($cnt['text']);
																							if($cnt_id != 0){
		                                                                                                              $cnt['text'] = "\n".'<div class="css-5dfefeer">'.$cnt['text'].'</div>';
		                                                                                                         }
																						break;
																					}
                                                                                                         switch ($cnt['position']) {
                                                                                                              case 'before':
                                                                                                                   $feature_cnt = $cnt['text'].' '.$feature_cnt;
                                                                                                              break;
                                                                                                              case 'after':
                                                                                                                   $feature_cnt = $feature_cnt.' '. $cnt['text'];
                                                                                                              break;

                                                                                                         }
                                                                                                    }
                                                                                               }
                                                                                          }
                                                                                     break;
                                                                                }
                                                                                $feature_products .= '<div class="table-cell'.$feature_class.'"> <div class="css-5dfefeer"> '.$feature_cnt.' </div> </div>';

                                                                           }
                                                                           $feature_products .= '</div>';
                                                                      }
                                                                 }
                                                            }else{
                                                                 $products = $curl['resp']['success']['products'][0];
                                                                 switch ($products['interval']) {
                                                                      case 'month':
                                                                           $product_int =  __( 'month', 'app_rank4win' );
                                                                           break;
                                                                      case 'year':
                                                                           $product_int =  __( 'year', 'app_rank4win' );
                                                                           break;
                                                                 }
                                                            }

                                                            if(!empty($product_uuid)){
                                                                 $tpl_products = new  r4w_template(r4w_plugin_base."/tpl/subscription/stripe_preview.tpl");
                                                                 $tpl_products->set("amount", r4w_price_currency($products['currency'],$products['amount_ttc']));
                                                                 $tpl_products->set("sub_interval",  $product_int);
                                                                 $tpl_products->set("name", r4w_fcnt_locale_tag_js($products['name']));
                                                                 $tpl_products->set("features", $features);
                                                                 $tpl_products->set("plan_uuid", $products['uuid']);
                                                                 switch ($products['metadata']['subscription_wordpress']) {
                                                                      case 'unlimited':
                                                                           $tpl_products->set("choice_number", '<div>'.__( 'Number of WordPress', 'app_rank4win' ).':</div><div class="css-sd50sd5e">'.__( 'Unlimited','app_rank4win' ).'</div>');
                                                                      break;
                                                                      default:
                                                                           $tpl_products->set("choice_number", '<div>'.__( 'Number of subscriptions', 'app_rank4win' ).':</div> <div class="number-input"> <button class="quantity_down"></button> <input class="quantity" min="1" max="300" name="product_unit" value="1" type="number"> <button class="plus quantity_up"></button> </div>');
                                                                      break;
                                                                 }
                                                            }else{
                                                                 $tpl_products = new  r4w_template(r4w_plugin_base."/tpl/subscription/products.tpl");
                                                                 $tpl_products->set("price_products", $price_products);
                                                                 $tpl_products->set("feature_products", $feature_products);
                                                            }
     											if(!empty($product_uuid)){
     												$tpl_sub_prod = $tpl_products->output();
                                                                 $return = [
                                                                      'success' => [
                                                                           'preview' => $tpl_sub_prod,
                                                                           'amount' => $curl['resp']['success']['products'][0]['amount_ttc'],
                                                                           'product' => $curl['resp']['success']['products'][0],
                                                                           'stripe' => $curl['resp']['success']['stripe'],
                                                                           'request' => md5(r4w_fcnt_uuid())
                                                                      ]
                                                                 ];
     												echo json_encode($return);
     												die();
     											}else{
     												$tpl_sub_prod = $tpl_products->output();
                                                                 $return = [
                                                                      'success' => [
                                                                           'preview' => $tpl_sub_prod,
                                                                           'request' => md5(r4w_fcnt_uuid())
                                                                      ]
                                                                 ];
     												echo json_encode($return);
     												die();
     											}
     										break;
     									}
     								}
							}
						}
					}
				}
			}
		}
		add_action( 'wp_ajax_r4w_exec_products', 'r4w_exec_products' );

	/**
	 * Récupération des analyses de site web
	 */
		function r4w_exec_analysis_website(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/analysis/website/",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl = r4w_curl_request($curl_data);
			if(isset($curl['err']) AND !empty($curl['err'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			} else {
				if($curl['info']['http_code'] != 200){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}else{
					if(empty($curl['resp']['success']['website'])){
						$return_website = bin2hex(utf8_decode('<div class="box_cnt css-s5df0zdgrf"> <div class="css-5fs0sfrgr"> <div class="css-sd65z0ezf"> <div class="sum_title">'.__('Keywords','app_rank4win').'</div> <div id="r4w_summary_keyword" class="sum_number"> '.r4w_assets_svg_code('dash_no_data').' </div> </div> <div class="css-sg5r0z6zfd0"> <div class="css-s5fd0eztgf"> '.r4w_assets_svg_code('keywords').' </div> </div> </div> <div class="sum_desc"> '.__('The number of keywords that bring you organic traffic','app_rank4win').' </div> </div><div class="box_cnt css-s5df0zdgrf"> <div class="css-5fs0sfrgr"> <div class="css-sd65z0ezf"> <div class="sum_title">'.__('Traffic').'</div> <div id="r4w_summary_keyword" class="sum_number"> '.r4w_assets_svg_code('dash_no_data').' </div> </div> <div class="css-sg5r0z6zfd0"> <div class="css-s5fd0eztgf"> '.r4w_assets_svg_code('traffic','app_rank4win').' </div> </div> </div> <div class="sum_desc"> '.__('Organic traffic planned for next month','app_rank4win').' </div> </div><div class="box_cnt css-s5df0zdgrf"> <div class="css-5fs0sfrgr"> <div class="css-sd65z0ezf"> <div class="sum_title">'.__('Cost of the traffic','app_rank4win').'</div> <div id="r4w_summary_keyword" class="sum_number"> '.r4w_assets_svg_code('dash_no_data').' </div> </div> <div class="css-sg5r0z6zfd0"> <div class="css-s5fd0eztgf"> '.r4w_assets_svg_code('cost_traffic').' </div> </div> </div> <div class="sum_desc"> '.__('Savings, normally that what you should pay in Google AdWords for your traffic','app_rank4win').' </div> </div>'));
					}else{
						$return_website = $curl['resp']['success']['website'];
					}
					$return_lastupdate = bin2hex(utf8_decode(__('Last update', 'app_rank4win').' : '.date_i18n("d F Y (H:i)",$curl['resp']['success']['lastupdate'])));
		            $return = [
		                'success' => [
		                	'lastupdate' => $return_lastupdate,
		                	'website' => $return_website,
		                    'request' => md5(r4w_fcnt_uuid())
		                ]
		            ];
					echo json_encode($return);
					die();
				}
			}
		}
		add_action( 'wp_ajax_r4w_exec_analysis_website', 'r4w_exec_analysis_website' );

	/**
	 * Récupération des analyses de la recherche organique
	 */
		function r4w_exec_analysis_research(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/analysis/research/",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl = r4w_curl_request($curl_data);
			if(isset($curl['err']) AND !empty($curl['err'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			} else {
				if($curl['info']['http_code'] != 200){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}else{
					if(empty($curl['resp']['success']['research'])){
						$return_research = bin2hex(utf8_decode('<div id="box_empty_data"><div>'.r4w_assets_svg_code('empty_data').'</div><div class="css-sdf5sq0fe">'.__('Sorry, no data related to your query','app_rank4win').'</div><div class="css-s5dz0f5ere">'.__('We did not find your site in the first 100 search results','app_rank4win').'</div></div>'));
					}else{
						$return_research = $curl['resp']['success']['research'];
					}
					$return_lastupdate = bin2hex(utf8_decode(__('Last update', 'app_rank4win').' : '.date_i18n("d F Y (H:i)",$curl['resp']['success']['lastupdate'])));
		            $return = [
		                'success' => [
		                	'lastupdate' => $return_lastupdate,
		                	'research' => $return_research,
		                    'request' => md5(r4w_fcnt_uuid())
		                ]
		            ];
					echo json_encode($return);
					die();
				}
			}
		}
		add_action( 'wp_ajax_r4w_exec_analysis_research', 'r4w_exec_analysis_research' );

	/**
	 * Récupération des analyses de compétition
	 */
		function r4w_exec_analysis_competition(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/analysis/competition/",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl = r4w_curl_request($curl_data);
			if(isset($curl['err']) AND !empty($curl['err'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			} else {
				if($curl['info']['http_code'] != 200){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}else{
					if(empty($curl['resp']['success']['competitor'])){
						$return_competitor = bin2hex(utf8_decode('<div id="box_empty_data"><div>'.r4w_assets_svg_code('empty_data').'</div><div class="css-sdf5sq0fe">'.__('Sorry, no data related to your query','app_rank4win').'</div><div class="css-s5dz0f5ere">'.__('We found no competitors linking to your site','app_rank4win').'</div></div>'));
					}else{
						$return_competitor = $curl['resp']['success']['competitor'];
					}
					$return_lastupdate = bin2hex(utf8_decode(__('Last update', 'app_rank4win').' : '.date_i18n("d F Y (H:i)",$curl['resp']['success']['lastupdate'])));
		            $return = [
		                'success' => [
		                	'lastupdate' => $return_lastupdate,
		                	'competitor' => $return_competitor,
		                    'request' => md5(r4w_fcnt_uuid())
		                ]
		            ];
					echo json_encode($return);
					die();
				}
			}
		}
		add_action( 'wp_ajax_r4w_exec_analysis_competition', 'r4w_exec_analysis_competition' );

	/**
	 * Effectue un pointage aurpès de api
	 */
		function r4w_exec_ping_system(){
			global $wpdb,$wp_version;

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/ping/system/",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => [
						"version_php" => phpversion(),
						"version_wp" => $wp_version,
						"version_r4w" => r4w_get_version()
					]
				]
			];
			$curl = r4w_curl_request($curl_data);
			if(isset($curl['err']) AND !empty($curl['err'])){
				$ping_msg = bin2hex(utf8_decode('<div class="r4w_msg_opr_maintenance"> <div class="css-fd5e0fe9fezr">'.r4w_assets_svg_code('question_info').'</div> <div class="css-df5e0fz5gz">'.__('The connection to the rank4win server has been interrupted unexpectedly, some features may not work properly. Wait and try to refresh the page to fix the problem','app_rank4win').'.</div> </div>'));
			} else {
				if($curl['info']['http_code'] == 404){
					if($curl['resp']['error']['name'] == 'wordpress_invalid'){
						$return = [
			                'success' => [
			                	'url' => admin_url( 'admin.php?page=r4w_wizard' ),
			                    'request' => md5(r4w_fcnt_uuid())
			                ]
			            ];
						echo json_encode($return);
						die();
					}
				}
				if($curl['info']['http_code'] == 401){
					if($curl['resp']['error']['name'] == 'bad_version'){
						$return = [
			                'success' => [
			                	'url' => admin_url( 'admin.php?page=r4w_update_available' ),
			                    'request' => md5(r4w_fcnt_uuid())
			                ]
			            ];
						echo json_encode($return);
						die();
					}
				}
				$good = false;
				if($curl['info']['http_code'] == 200){
					if(!empty($curl['resp']['success'])){
						if(!empty($curl['resp']['success']['downtime'])){
							foreach ($curl['resp']['success']['downtime'] as $downtime) {
								if($downtime == $_POST['r4w_tpl']){
									$ping_msg = bin2hex(utf8_decode('<div class="r4w_msg_opr_maintenance "> <div class="css-fd5e0fe9fezr">'.r4w_assets_svg_code('question_info').'</div> <div class="css-df5e0fz5gz">'.__('We make improvements on this service, do not be surprised if some features do not work properly during our intervention','app_rank4win').'.</div> </div>'));
								}
							}
						}
						$good = true;
					}
				}
				if(!$good){
					$ping_msg = bin2hex(utf8_decode('<div class="r4w_msg_opr_maintenance "> <div class="css-fd5e0fe9fezr">'.r4w_assets_svg_code('question_info').'</div> <div class="css-df5e0fz5gz">'.__('The connection to the rank4win server has been interrupted unexpectedly, some features may not work properly. Wait and try to refresh the page to fix the problem','app_rank4win').'.</div> </div>'));
				}else{
					$ping_msg = null;
				}
			}
			$return = [
                'success' => [
                	'msg' => $ping_msg,
                    'request' => md5(r4w_fcnt_uuid())
                ]
            ];
			echo json_encode($return);
			die();
		}
		add_action( 'wp_ajax_r4w_exec_ping_system', 'r4w_exec_ping_system' );

	/**
	 * Indique si un déploiement est en cours
	 */
		function r4w_exec_deploy(){
			global $wpdb;

			$wp_table_process = $wpdb->prefix.r4w_bdd_table_process;
			$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_process} WHERE request = %s",'deploy');
			$r4w_process_progress = $wpdb->get_row($wp_select,ARRAY_A);
			if(!empty($r4w_process_progress)){
				$deploy = 'in_progress';
			}
			$return = [
				'success' => [
					'deploy' => $deploy,
					'request' => md5(r4w_fcnt_uuid())
				]
			];
			echo json_encode($return);
			die();
		}
	 	add_action( 'wp_ajax_r4w_exec_deploy', 'r4w_exec_deploy' );

	/**
	 * Mise en place et vérification des demandes en attente
	 */
		function r4w_exec_process(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			$wp_table_process = $wpdb->prefix.r4w_bdd_table_process;

			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($_POST['r4w_process'])){
				$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_process} WHERE uuid = %s",$_POST['r4w_process']);
				$r4w_process = $wpdb->get_row($wp_select,ARRAY_A);
				if(!empty($r4w_process['data'])){
					$r4w_process_data = json_decode(hex2bin($r4w_process['data']),true);
				}
			}

			if(!empty($_POST['r4w_request'])){

				switch ($_POST['r4w_request']) {
					case 'r4w_str_semantic_deploy':
						if($_POST['r4w_method'] == 'PUT'){
							if($_POST['r4w_deploy'] == 'editor'){
								$editor_uuid = hex2bin($_POST['r4w_str_semantic']);
							}else{
								$editor_uuid = $_POST['r4w_str_semantic'];
							}
							$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_process} WHERE request = %s",'deploy');
				    			$r4w_process_progress = $wpdb->get_row($wp_select,ARRAY_A);
				    			if(empty($r4w_process_progress)){
								$process_uuid = r4w_fcnt_uuid();
								$data = [
									"editor_uuid" => $editor_uuid,
									"how_deploy" => $_POST['r4w_str_how_deploy'],
									"total" => 0,
									"realized" => 0
								];
								$data = bin2hex(json_encode($data));
								$wpdb->query($wpdb->prepare("INSERT INTO $wp_table_process (uuid,request,data,hash) VALUES(%s,%s,%s,%s)", array($process_uuid,'deploy',$data,md5($process_uuid))));

								$r4w_process_all = new r4w_process();
								$r4w_process_all->push_to_queue($process_uuid);
								$r4w_process_all->save()->dispatch();

								$return = [
									'success' => [
										'process' => $process_uuid,
										'request' => md5(r4w_fcnt_uuid())
									]
								];
								echo json_encode($return);
								wp_die();
								die();
							}
						}
						if($_POST['r4w_method'] == 'GET'){
							if(!empty($r4w_process_data['realized']) AND !empty($r4w_process_data['total'])){
								$progress = round($r4w_process_data['realized'] * 100 / $r4w_process_data['total']);
								if(!is_numeric($progress) or is_nan($progress)){
									$progress = 0;
								}
								$return = [
									'success' => [
										'process' => 'in_progress',
										'deploy' => [
											'progression' => $progress,
										],
										'request' => md5(r4w_fcnt_uuid())
									]
								];
								echo json_encode($return);
								die();
							}
						}
						if($_POST['r4w_method'] == 'DELETE'){
							$curl_data = [
								"request_method" => "DELETE",
								"url" => "/wp/structure/deploy/",
								"auth" => "true",
								"postfileds" => [
									"json_encode" => true,
									"data" => null
								]
							];
							$curl = r4w_curl_request($curl_data);
							if(isset($curl['err']) AND !empty($curl['err'])){
								$return = [
									'error' => [
										'name' => 'browser_refresh',
										'description' => 'Browser refresh needed'
									]
								];
								echo json_encode($return);
								die();
							} else {
								if($curl['info']['http_code'] != 200){
									$return = [
										'error' => [
											'name' => 'browser_refresh',
											'description' => 'Browser refresh needed'
										]
									];
									echo json_encode($return);
									die();
								}else{
									$r4w_process_all = new r4w_process();
									$r4w_process_all->cancel_process();
									$wpdb->query( $wpdb->prepare( "DELETE FROM $wp_table_process WHERE request = %s", 'deploy'));
									$return = [
										'success' => [
											'url' => admin_url( 'admin.php?page=r4w_tools&tab=deploy' ),
											'request' => md5(r4w_fcnt_uuid())
										]
									];
									echo json_encode($return);
									wp_die();
									die();
								}
							}
						}
					break;
					case 'search_word':
						if($_POST['r4w_method'] == 'PUT'){
							$process_uuid = r4w_fcnt_uuid();
							$data = [
								"request" => 'search_keyword',
								"word" => $_POST['r4w_word']
							];
							$data = bin2hex(json_encode($data));
							$wpdb->query($wpdb->prepare("INSERT INTO $wp_table_process (uuid,request,data,hash) VALUES(%s,%s,%s,%s)", array($process_uuid,'search_word',$data,md5($process_uuid))));
							$r4w_process_all = new r4w_process();
							$r4w_process_all->push_to_queue($process_uuid);
							$r4w_process_all->save()->dispatch();
							$return = [
								'success' => [
									'process' => $process_uuid,
									'request' => md5(r4w_fcnt_uuid())
								]
							];
							echo json_encode($return);
							wp_die();
							die();
						}
						if($_POST['r4w_method'] == 'GET'){
							if(!empty($r4w_process)){
					            $return = [
					                'success' => [
					                	'process' => 'in_progress',
					                    'request' => md5(r4w_fcnt_uuid())
					                ]
					            ];
								echo json_encode($return);
								die();
							}
						}
					break;
					case 'answers':
						if($_POST['r4w_method'] == 'PUT'){
							$process_uuid = r4w_fcnt_uuid();
							$data = [
								"request" => 'answers',
								"document" => $_POST['r4w_document']
							];
							$data = bin2hex(json_encode($data));
							$wpdb->query($wpdb->prepare("INSERT INTO $wp_table_process (uuid,request,data,hash) VALUES(%s,%s,%s,%s)", array($process_uuid,'answers',$data,md5($process_uuid))));
							$r4w_process_all = new r4w_process();
					        $r4w_process_all->push_to_queue($process_uuid);
							$r4w_process_all->save()->dispatch();
				            $return = [
				                'success' => [
				                	'process' => $process_uuid,
				                    'request' => md5(r4w_fcnt_uuid())
				                ]
				            ];
							echo json_encode($return);
							wp_die();
							die();
						}
						if($_POST['r4w_method'] == 'GET'){
							if(!empty($r4w_process)){
					            $return = [
					                'success' => [
					                	'process' => 'in_progress',
					                    'request' => md5(r4w_fcnt_uuid())
					                ]
					            ];
								echo json_encode($return);
								die();
							}
						}
					break;
					case 'semantic':
						if($_POST['r4w_method'] == 'PUT'){
							$process_uuid = r4w_fcnt_uuid();
							$data = [
								"request" => 'semantic',
								"document" => $_POST['r4w_document']
							];
							$data = bin2hex(json_encode($data));
							$wpdb->query($wpdb->prepare("INSERT INTO $wp_table_process (uuid,request,data,hash) VALUES(%s,%s,%s,%s)", array($process_uuid,'semantic',$data,md5($process_uuid))));
							$r4w_process_all = new r4w_process();
					        $r4w_process_all->push_to_queue($process_uuid);
							$r4w_process_all->save()->dispatch();
				            $return = [
				                'success' => [
				                	'process' => $process_uuid,
				                    'request' => md5(r4w_fcnt_uuid())
				                ]
				            ];
							echo json_encode($return);
							wp_die();
							die();
						}
						if($_POST['r4w_method'] == 'GET'){
							if(!empty($r4w_process)){
					            $return = [
					                'success' => [
					                	'process' => 'in_progress',
					                    'request' => md5(r4w_fcnt_uuid())
					                ]
					            ];
								echo json_encode($return);
								die();
							}
						}
					break;
					case 'synonymous':
						if($_POST['r4w_method'] == 'PUT'){
							$process_uuid = r4w_fcnt_uuid();
							if(!empty($_POST['r4w_document'])){
								$r4w_document = $_POST['r4w_document'];
							}
							$data = [
								"request" => 'synonymous',
								"document" => $r4w_document,

							];
							$data = bin2hex(json_encode($data));
							$wpdb->query($wpdb->prepare("INSERT INTO $wp_table_process (uuid,request,data,hash) VALUES(%s,%s,%s,%s)", array($process_uuid,'synonymous',$data,md5($process_uuid))));
							$r4w_process_all = new r4w_process();
					        	$r4w_process_all->push_to_queue($process_uuid);
							$r4w_process_all->save()->dispatch();
							$return = [
								'success' => [
									'process' => $process_uuid,
									'request' => md5(r4w_fcnt_uuid())
								]
							];
							echo json_encode($return);
							wp_die();
							die();
						}
						if($_POST['r4w_method'] == 'GET'){
							if(!empty($r4w_process)){
					            $return = [
					                'success' => [
					                	'process' => 'in_progress',
					                    'request' => md5(r4w_fcnt_uuid())
					                ]
					            ];
								echo json_encode($return);
								die();
							}
						}
					break;
				}
			}
			$return = [
                'success' => [
                	'process' => 'finish',
                    'request' => md5(r4w_fcnt_uuid())
                ]
            ];
			echo json_encode($return);
			die();
		}
		add_action( 'wp_ajax_r4w_exec_process', 'r4w_exec_process' );

	/**
	 * Récupération de l'abonnement de l'utilisateur
	 */
		function r4w_exec_user_subscription(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

			$wp_select = "SELECT * from ".$wp_table_app;
			$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/user/subscription/",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl = r4w_curl_request($curl_data);
			if(isset($curl['err']) AND !empty($curl['err'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			} else {
				if($curl['info']['http_code'] != 200){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}else{
					$class_credit_applied = '';
					$tpl_sub_reduction = '';
					$nbr_card = __('No cards added','app_rank4win');
					if(!empty($curl['resp']['success']['subscription'])){
						if($curl['resp']['success']['subscription']['cancel']){
							$sub_cancelsub = new r4w_template(r4w_plugin_base."/tpl/account/tab_account/sub_cancelsub.tpl");
							$sub_cancelsub->set("subscription_text", sprintf(__('Your subscription will be canceled on %s, after this date you will no longer have access to the benefit of your subscription','app_rank4win'), '<b>'.r4w_date_format_timezone($curl['resp']['success']['subscription']['date']).'</b>'));
							$sub_cancelsub->set("sub_reduction",$tpl_sub_reduction);
							$tpl_sub_reduction = $sub_cancelsub->output();
						}else{
							$tpl_inc = false;
							if($curl['resp']['success']['subscription']['status'] == 'trialing'){
								$sub_trialing = new r4w_template(r4w_plugin_base."/tpl/account/tab_account/sub_trialing.tpl");
								$amount = $curl['resp']['success']['subscription']['amount'];
								$tpl_sub_reduction = $sub_trialing->output();
								$tpl_inc = true;
							}

							if($curl['resp']['success']['subscription']['status'] == 'past_due'){
								$sub_issue = new r4w_template(r4w_plugin_base."/tpl/account/tab_account/sub_issue.tpl");
								$sub_issue->set("issue_msg", sprintf(__('A problem occurred during the payment of your last invoice for an amount of %s, we will represent the payment on %s, remember to update your credit card','app_rank4win'), r4w_price_currency($curl['resp']['success']['subscription']['currency'],$curl['resp']['success']['subscription']['issue']['total']), '<b>'.r4w_date_format_timezone($curl['resp']['success']['subscription']['issue']['next_payment_attempt']).'</b>'));
								$amount = $curl['resp']['success']['subscription']['amount'];
								$tpl_sub_issue = $sub_issue->output();
								$tpl_inc = true;
							}
							if($curl['resp']['success']['account']['card']){
								$sub_card = new r4w_template(r4w_plugin_base."/tpl/account/tab_account/sub_card.tpl");
								$sub_card->set("card_logo", r4w_assets_svg_code('card_'.strtolower($curl['resp']['success']['account']['card']['name'])));
								$sub_card->set("card_last_card", $curl['resp']['success']['account']['card']['last_card']);
								$sub_card->set("card_expiration_date", $curl['resp']['success']['account']['card']['expiration_date']);
								$nbr_card = $sub_card->output();
							}

							if(!empty($curl['resp']['success']['account']['discount'])){
								$sub_reduction = new r4w_template(r4w_plugin_base."/tpl/account/tab_account/sub_reduction.tpl");
								if($curl['resp']['success']['account']['discount'] >= 99){
									$class_credit_applied = ' class="credit_applied" ';
									$sub_reduction->set("discount_msg", sprintf(__( 'Your %s discount will be used to pay your next bill', 'app_rank4win' ), $curl['resp']['success']['account']['discount'].'%'));
									$amount = $curl['resp']['success']['subscription']['amount'];
								}else{
									$sub_reduction->set("discount_msg", sprintf(__( 'Your %s discount will be applied to your next bill', 'app_rank4win' ), $curl['resp']['success']['account']['discount'].'%'));
									$amount = $curl['resp']['success']['subscription']['amount_discount'];
								}
								$tpl_sub_reduction = $sub_reduction->output();
								$tpl_inc = true;
							}

							if(!$tpl_inc){
								if($curl['resp']['success']['account']['balance']){
									$sub_balance = new r4w_template(r4w_plugin_base."/tpl/account/tab_account/sub_balance.tpl");
									$tpl_sub_balance = $sub_balance->output();
								}
								/*
								if( $resp['success']['account']['balance'] < 0 ){
									if($resp['success']['subscription']['amount'] + $resp['success']['account']['balance'] < 0){

										$class_credit_applied = ' class="credit_applied" ';
										$sub_reduction->set("discount_msg", sprintf(__( 'Your %s discount will be applied to your next bill', 'app_rank4win' ), $resp['success']['account']['discount'].'%'));
										$amount = $resp['success']['subscription']['amount'];

									}else{
										//$sub_reduction->set("discount_msg", sprintf(__( 'Your %s credit will be used to pay your next bill', 'app_rank4win' ), r4w_price_currency($resp['success']['subscription']['currency'],$resp['success']['account']['balance'])));
										//$amount = $resp['success']['subscription']['amount_discount'] + $resp['success']['account']['balance'];
									}
								}
								*/
								$amount = $curl['resp']['success']['subscription']['amount'];
							}
							$price = '<b'.$class_credit_applied.'>'.r4w_price_currency($curl['resp']['success']['subscription']['currency'],$amount).'</b>';

							$sub_subscribes = new r4w_template(r4w_plugin_base."/tpl/account/tab_account/sub_subscribes.tpl");
							$sub_subscribes->set("card", $nbr_card);
							$sub_subscribes->set("url_subscription", admin_url( 'admin.php?page=r4w_subscription' ));
							$sub_subscribes->set("sub_date_d", date('d',$curl['resp']['success']['subscription']['date']));
							$sub_subscribes->set("sub_date_my", r4w_f_months(date('F',$curl['resp']['success']['subscription']['date'])).' '.date('Y',$curl['resp']['success']['subscription']['date']));
							$sub_subscribes->set("subscription_text", sprintf(__('Your next bill will be %s. It will be taken on %s','app_rank4win'), $price,'<b>'.r4w_date_format_timezone($curl['resp']['success']['subscription']['date']).'</b>'));
							$sub_subscribes->set("sub_reduction",$tpl_sub_reduction);
							$sub_subscribes->set("time_before_expiration", sprintf(__('The cancellation will be effective at the end of the current billing period, the %s','app_rank4win'), '<b>'.r4w_date_format_timezone($curl['resp']['success']['subscription']['date']).'</b>'));
							$tpl_sub_reduction = $sub_subscribes->output();
						}
					}else{
						$sub_unsubscribed = new r4w_template(r4w_plugin_base."/tpl/account/tab_account/sub_unsubscribed.tpl");
						$sub_unsubscribed->set("url_subscription", admin_url( 'admin.php?page=r4w_subscription' ));
						$tpl_sub_reduction = $sub_unsubscribed->output();
					}
					$return = [
						'success' => [
							'subscription' => [
								'box' => $tpl_sub_reduction,
								'issue' => $tpl_sub_issue,
							],
							'request' => md5(r4w_fcnt_uuid())
						]
					];
					echo json_encode($return);
					die();
				}
			}
		}
		add_action( 'wp_ajax_r4w_exec_user_subscription', 'r4w_exec_user_subscription' );

	/**
	 * Achat d'une option supplémentaire
	 */
		function r4w_exec_buy_option(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
		     $wp_select = "SELECT * from ".$wp_table_app;
		     $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/buy/option/",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => [
						"option" => $_POST['option'],
						"data_uuid" => $_POST['data']
					]
				]
			];
			$curl = r4w_curl_request($curl_data);
			if(isset($curl['err']) AND !empty($curl['err'])){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			} else {
				if($curl['info']['http_code'] != 200){
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}else{
					if(!empty($curl['resp']['success']['option'])){
						$stripe_preview = new r4w_template(r4w_plugin_base."/tpl/tools/tab_deploy/stripe_preview.tpl");
						$stripe_preview->set("amount", r4w_price_currency($curl['resp']['success']['option']['currency'],$curl['resp']['success']['option']['amount']));
						$stripe_preview->set("nbr_page", $curl['resp']['success']['additional']['pages']);
						$return_stripe_preview = $stripe_preview->output();
						$return = [
							'success' => [
								'preview' => $return_stripe_preview,
								'option' => $curl['resp']['success']['option'],
								'stripe' => $curl['resp']['success']['stripe'],
								'request' => md5(r4w_fcnt_uuid())
							]
						];
						echo json_encode($return);
						die();
					}
				}
			}
		}
		add_action( 'wp_ajax_r4w_exec_buy_option', 'r4w_exec_buy_option' );

	/**
	 *  Stripe : Paiement et validation de l'abonnement
	 */
		function r4w_exec_stripe(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

		    $wp_select = "SELECT * from ".$wp_table_app;
		    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
		    if(empty($_POST['product_unit'])){
		    	$product_unit = 1;
		    }else{
		    	$product_unit = $_POST['product_unit'];
		    }
		    if(!empty($_POST['product_type'])){
			    switch ($_POST['product_type']) {
			    	case 'option':
					$curl_data = [
						"request_method" => "PUT",
						"auth" => "true",
						"url" => "/wp/stripe/option/".$_POST['option_uuid'],
						"postfileds" => [
							"json_encode" => true,
							"data" => [
								"option_unit" => $_POST['option_unit'],
								"stripe_token" => $_POST['stripe_token'],
								"additional" => $_POST['additional']
							]
						]
					];
					$curl = r4w_curl_request($curl_data);
					$success = [
						'request' => md5(r4w_fcnt_uuid())
					];
			    	break;
			    	case 'subscription':
					if( $_POST['stripe_type'] == 'add'){
						$curl_data = [
							"request_method" => "PUT",
							"auth" => "true",
							"url" => "/wp/stripe/subscription/".$_POST['product_uuid'],
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"product_unit" => $product_unit,
									"coupon" => $_POST['product_discount'],
									"stripe_token" => $_POST['stripe_token']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
						if(!isset($curl['resp']['error'])){
							$success = [
								'url' => admin_url( 'admin.php?page=r4w_account&tab=wordpress' ),
								'request' => md5(r4w_fcnt_uuid())
							];
						}
					}
					if( $_POST['stripe_type'] == 'reactivate'){
						$curl_data = [
							"request_method" => "POST",
							"auth" => "true",
							"url" => "/wp/stripe/subscription/",
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"type" => "reactivate"
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
						if(!isset($curl['resp']['error'])){
							$success = [
								'url' => admin_url( 'admin.php?page=r4w_account' ),
								'request' => md5(r4w_fcnt_uuid())
							];
						}
					}
					if( $_POST['stripe_type'] == 'canceled'){
						$curl_data = [
							"request_method" => "POST",
							"auth" => "true",
							"url" => "/wp/stripe/subscription/",
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"type" => "canceled",
									"reason" => $_POST['reason']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
						if(!isset($curl['resp']['error'])){
							$success = [
								'url' => admin_url( 'admin.php?page=r4w_account' ),
								'request' => md5(r4w_fcnt_uuid())
							];
						}
					}
					if( $_POST['stripe_type'] == 'unpaid'){
						$curl_data = [
							"request_method" => "POST",
							"auth" => "true",
							"url" => "/wp/stripe/subscription/",
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"type" => "unpaid",
									"reason" => $_POST['reason']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
						if(!isset($curl['resp']['error'])){
							$success = [
								'url' => admin_url( 'admin.php?page=r4w_account' ),
								'request' => md5(r4w_fcnt_uuid())
							];
						}
					}
					if( $_POST['stripe_type'] == 'discount'){
						$curl_data = [
							"request_method" => "POST",
							"auth" => "true",
							"url" => "/wp/stripe/subscription/",
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"type" => "discount",
									"coupon" => $_POST['product_discount']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
						if(!isset($curl['resp']['error'])){
							$success = [
								'msg' => '<div class="css-fd50e5fef">'.$curl['resp']['success']['discount']['name'].'</div>',
								'code' => $curl['resp']['success']['discount']['code'],
								'request' => md5(r4w_fcnt_uuid())
							];
						}
					}
			    	break;
				case 'account':
					if( $_POST['stripe_type'] == 'get_payment'){
						$curl_data = [
							"request_method" => "GET",
							"auth" => "true",
							"url" => "/wp/stripe/customer/",
							"postfileds" => [
								"json_encode" => true,
								"data" => null
							]
						];
						$curl = r4w_curl_request($curl_data);
						if(!isset($curl['resp']['error'])){
							$stripe_preview = new r4w_template(r4w_plugin_base."/tpl/account/tab_account/stripe_preview.tpl");
							$return_stripe_preview = $stripe_preview->output();
							$success = [
								'preview' => $return_stripe_preview,
								'stripe' => $curl['resp']['success']['stripe'],
								'request' => md5(r4w_fcnt_uuid())
							];
						}
					}
					if( $_POST['stripe_type'] == 'update_payment'){
						$curl_data = [
							"request_method" => "PUT",
							"auth" => "true",
							"url" => "/wp/stripe/customer/",
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"stripe_token" => $_POST['stripe_token']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
						if(!isset($curl['resp']['error'])){
							$success = [
								'url' => admin_url( 'admin.php?page=r4w_account' ),
								'request' => md5(r4w_fcnt_uuid())
							];
						}
					}
					break;
			    }
			}
			if(!empty($curl)){
				if($curl['info']['http_code'] != 201){
					if($curl['resp']['error']['name'] == 'stripe_payment'){
						$return = [
							'error' => [
								'name' => 'stripe_payment',
								'description' => "Stripe payment did not succeed"
							]
						];
						echo json_encode($return);
						die();
					}
					if($curl['resp']['error']['name'] == 'stripe_coupon_invalid'){
						$return = [
							'success' =>  [
								'msg' => '<div class="css-sdg50e5fe">'.__('Invalid or expired coupon','app_rank4win').'</div>',
								'request' => md5(r4w_fcnt_uuid())
							]
						];
						echo json_encode($return);
						die();
					}
					$return = [
						'error' => [
							'name' => 'browser_refresh',
							'description' => 'Browser refresh needed'
						]
					];
					echo json_encode($return);
					die();
				}else{
					if(isset($curl['resp']['success'])){
						$return = [
			                'success' => $success
			            ];
						echo json_encode($return);
						die();
					}
				}
			}
		}
		add_action( 'wp_ajax_r4w_exec_stripe', 'r4w_exec_stripe' );

	/**
	 *  Liste des wordpress de l'utilisateur
	 */
		function r4w_exec_user_wordpress(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

		    $wp_select = "SELECT * from ".$wp_table_app;
		    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
		    if(isset($_POST['r4w_method'])){
			    switch ($_POST['r4w_method']) {
			    	case 'remove_linked':
			    		$curl_data = [
							"request_method" => "DELETE",
							"auth" => "true",
							"url" => "/wp/user/wordpress/".$_POST['r4w_uuid'],
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"action" => $_POST['r4w_method']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
			    		break;
			    	case 'remove_wordpress':
			    		$curl_data = [
							"request_method" => "DELETE",
							"auth" => "true",
							"url" => "/wp/user/wordpress/".$_POST['r4w_uuid'],
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"action" => $_POST['r4w_method']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
			    		break;
			    	case 'remove_subscription':
			    		$curl_data = [
							"request_method" => "DELETE",
							"auth" => "true",
							"url" => "/wp/user/wordpress/".$_POST['r4w_uuid'],
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"action" => $_POST['r4w_method']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
			    		break;
			    	case 'add_subscription':
			    		$curl_data = [
							"request_method" => "PUT",
							"auth" => "true",
							"url" => "/wp/user/wordpress/".$_POST['r4w_uuid'],
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"action" => $_POST['r4w_method']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
			    		break;
			    	case 'reassociate_subscription':
			    		$curl_data = [
							"request_method" => "PUT",
							"auth" => "true",
							"url" => "/wp/user/wordpress/".$_POST['r4w_uuid'],
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"action" => $_POST['r4w_method']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
			    		break;
			    }
			}
    			$curl_data = [
				"request_method" => "GET",
				"auth" => "true",
				"url" => "/wp/user/wordpress",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl = r4w_curl_request($curl_data);
			if($curl['info']['http_code'] != 200){
				$return = [
					'error' => [
						'name' => 'browser_refresh',
						'description' => 'Browser refresh needed'
					]
				];
				echo json_encode($return);
				die();
			}else{
				if($curl['resp']['success']['list']){

					if(empty($curl['resp']['success']['subscription'])){
						$sub_rm_wordpress = '<div id="r4w_sub_wordpress" class="css-5fd0fgevvre"><b>'.__( 'No subscription', 'app_rank4win' ).'</b> </div>';
						$data_reamining = 'empty';
					}else{
						if(!is_numeric($curl['resp']['success']['subscription']['available'])){
							$sub_rm_wordpress = '<div id="r4w_sub_wordpress" class="css-5fd0fgevvre"><b>'.__( 'Unlimited Wordpress', 'app_rank4win' ).'</b> </div>';
							$data_reamining = 'true';
						}else{
							$sub_rm_wordpress = '<div id="r4w_sub_wordpress" class="css-5fd0fgevvre">'.__( 'Subscription available', 'app_rank4win').' : <b>'.$curl['resp']['success']['subscription']['available'].'/'.$curl['resp']['success']['subscription']['total'].'</b> </div>';
							if($curl['resp']['success']['subscription']['available'] >=1){
								$data_reamining = 'true';
							}else{
								$data_reamining = 'false';
							}
						}
					}

					$tpl_list_wordpress = '';
					foreach ($curl['resp']['success']['list'] as $list_wordpress) {
						$list_wp_msg ='';
						$tpl_loop_wordpress = new r4w_template(r4w_plugin_base."/tpl/account/tab_wordpress/loop_wordpress.tpl");
						$tpl_loop_wordpress->set("wordpress_url",$list_wordpress['url']);

						/**
						 * Wordpress : associé au compte (oui)
						 */
						if($list_wordpress['sync_account']){
							$color_wp = 'r4w_wpsync_green';
							$r4w_menu_acc = '<a class="r4w_open_remove_linked" href="#">'.__( 'Remove the association from the account','app_rank4win' ).'</a>';
						}

						/**
						 * Wordpress : associé au compte (non)
						 */
						if(!$list_wordpress['sync_account']){
							$color_wp = 'r4w_wpsync_red';
							$r4w_menu_acc = '<a class="r4w_open_remove_wordpress" href="#">'.__( 'Delete from account','app_rank4win' ).'</a>';
						}

						/**
						 * Wordpress : associé à l'abonnement (non)
						 */
						if($list_wordpress['sync_subscription'] == false){
							$color_sub = 'r4w_wpsync_red';
							$r4w_menu_sub = '<a class="r4w_open_add_subscription" href="#">'.__( 'Add to your subscription','app_rank4win' ).'</a>';
						}

						/**
						 * Wordpress : associé à l'abonnement (oui)
						 */
						if($list_wordpress['sync_subscription'] == true){
							$color_sub = 'r4w_wpsync_green';
							$r4w_menu_sub = '<a class="r4w_remove_subscription" href="#">'.__( 'Remove from your subscription','app_rank4win' ).'</a>';
						}

						/**
						 * Wordpress : associé au compte (non) | associé à l'abonnement (oui)
						 */
						if($list_wordpress['sync_account'] == false AND $list_wordpress['sync_subscription'] == true){
							$color_sub = 'r4w_wpsync_grey';
							$r4w_menu_acc = '';
							$list_wp_msg = '<div class="css-s5d0f0e5fe">'.__('This wordpress must be associated with your account to benefit from your subscription', 'app_rank4win').'</div>';
						}

						/**
						 * Wordpress : supprime de l'abonnement (oui) | associé au compte (non) | associé à l'abonnement (oui)
						 */
						if($list_wordpress['sub_cancel'] == true AND $list_wordpress['sync_account'] == false AND  $list_wordpress['sync_subscription'] == true){
							$r4w_menu_acc = '';
						}

						/**
						 * Wordpress: supprime de l'abonnement (oui) | associé à l'abonnement (oui)
						 */
						if($list_wordpress['sub_cancel'] == true AND $list_wordpress['sync_subscription'] == true){
							$color_sub = 'r4w_wpsync_orange';
							$r4w_menu_sub = '<a class="r4w_reassociate" href="#">'.__( 'Re-add to your subscription','app_rank4win' ).'</a>';
							$list_wp_msg = '<div class="css-s5d0f0e5fe r4w_wpbar_orange">'.__('On your next bill, this wordpress will no longer be associated with your subscription', 'app_rank4win').'</div>';
						}

						/**
						 * S'il s'agit de ce wordpress
						 */
						if($list_wordpress['current'] == true){
							$r4w_menu_acc = '';
							$tpl_loop_wordpress->set("this_wordpress_txt", '<div class="css-5f0df5dsfve">'.__('You are on this wordpress', 'app_rank4win').'</div>');
							$tpl_loop_wordpress->set("this_wordpress_ico",'<div class="r4w_star">'.r4w_assets_svg_code('star').'</div>');
						}else{
							$tpl_loop_wordpress->set("this_wordpress_txt", '');
							$tpl_loop_wordpress->set("this_wordpress_ico", '');
						}

						$show_menu =  $r4w_menu_acc.$r4w_menu_sub;

						$tpl_loop_wordpress->set("remaining_subscription",$data_reamining);
						$tpl_loop_wordpress->set("user_wp_uuid",$list_wordpress['uuid']);
						$tpl_loop_wordpress->set("show_menu",$show_menu);
						$tpl_loop_wordpress->set("color_wp",$color_wp);
						$tpl_loop_wordpress->set("list_wp_msg", $list_wp_msg);
						$tpl_loop_wordpress->set("color_sub",$color_sub);
						$tpl_list_wordpress .= $tpl_loop_wordpress->output();
					}

					$return = [
		                'success' => [
		                	'wordpress' => $sub_rm_wordpress.$tpl_list_wordpress,
		                    'request' => md5(r4w_fcnt_uuid())
		                ]
		            ];
					echo json_encode($return);
					die();
				}else{
					$return = [
		                'success' => [
		                	'wordpress' => '<div id="box_empty_data"><div>'.r4w_assets_svg_code('empty_data').'</div><div class="css-sdf5sq0fe">'.__('Sorry, no wordpress available','app_rank4win').'</div><div class="css-s5dz0f5ere">'.__('when you connect to a wordpress it will appear in this list','app_rank4win').'</div></div>',
		                    'request' => md5(r4w_fcnt_uuid())
		                ]
		            ];
					echo json_encode($return);
					die();
				}
			}
		}
		add_action( 'wp_ajax_r4w_exec_user_wordpress', 'r4w_exec_user_wordpress' );

	/**
	 * Vérification des options de l'abonnement
	 */
		function r4w_exec_user_feature(){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

		     $wp_select = "SELECT * from ".$wp_table_app;
		     $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/user/feature/",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => [
						"features" => [
							$_POST['r4w_features']
						]
					]
				]
			];
			$curl_feature = r4w_curl_request($curl_data);
			if($curl_feature['resp']['success']){
				$str_semantic = '';
				$curl_data = [ 
					"request_method" => "GET",
					"url" => "/wp/structure/semantic/",
					"auth" => "true",
					"postfileds" => [
						"json_encode" => true,
						"data" => null
					]
				];
				$curl_semantic = r4w_curl_request($curl_data);
				$r4w_semantic = $_POST['r4w_semantic'];
				if(isset($curl_semantic['info']['http_code']) and $curl_semantic['info']['http_code'] == 200){
					if(!empty($curl_semantic['resp']['success']['str_semantic'])){
						if(!empty($r4w_semantic)){
							foreach ($curl_semantic['resp']['success']['str_semantic'] as $str_sem) {
								if($r4w_semantic == $str_sem['uuid']){
									$price = htmlentities(r4w_price_currency($str_sem['deploy']['currency'],$str_sem['deploy']['amount_ttc']));
									$page = $str_sem['page'];
									$name = stripcslashes(hex2bin($str_sem['name']));
									$pbp = htmlentities(r4w_price_currency($str_sem['deploy']['currency'],$str_sem['deploy']['price_page_ttc']));
									$str_semantic = '<option value="'.$str_sem['uuid'].'" data-cost="'.$price.'" data-pbp="'.$pbp.'" data-page="'.$page.'"  >'.$name.'</option>';
								}
							}
						}else{
							foreach ($curl_semantic['resp']['success']['str_semantic'] as $str_sem) {
								$price = htmlentities(r4w_price_currency($str_sem['deploy']['currency'],$str_sem['deploy']['amount_ttc']));
								$page = $str_sem['page'];
								$name = stripcslashes(hex2bin($str_sem['name']));
								$pbp = htmlentities(r4w_price_currency($str_sem['deploy']['currency'],$str_sem['deploy']['price_page_ttc']));
								$str_semantic .= '<option value="'.$str_sem['uuid'].' data-cost="'.$price.'"  data-pbp="'.$pbp.'" data-page="'.$page.'" >'.$name.'</option>';
							}
						}

					}

				}
				if(!empty($str_semantic)){
					$str_semantic = '<select id="r4w_str_deploy_uuid" class="browser-default r4wfix_wp_input" name="r4w_str_deploy_uuid">'.$str_semantic.'</select>';
				}
				$return = [
					'success' => [
							'structure' => $str_semantic,
							'subscription' => $curl_feature['resp']['success']
						]
				];
				echo json_encode($return);
				die();
			}
		}
		add_action( 'wp_ajax_r4w_exec_user_feature', 'r4w_exec_user_feature' );

	/**
	 * Recupération des factures
	 */
		function r4w_exec_user_invoice(){
			if(isset($_POST['r4w_method'])){
			    switch ($_POST['r4w_method']) {
			    	case 'list_invoice':
			    		$curl_data = [
							"request_method" => "GET",
							"auth" => "true",
							"url" => "/wp/user/invoice/",
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"action" => $_POST['r4w_method']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
						if(!empty($curl)){
							if($curl['info']['http_code'] != 200){
								$return = [
									'error' => [
										'name' => 'browser_refresh',
										'description' => 'Browser refresh needed'
									]
								];
								echo json_encode($return);
								die();
							}else{
								if(isset($curl['resp']['success'])){
									$tpl_list_wordpress = '';
									$tpl_list_invoice = null;
									foreach ($curl['resp']['success']['invoice'] as $list_invoice) {
										$list_wp_msg ='';
										$tpl_loop_invoice = new r4w_template(r4w_plugin_base."/tpl/account/tab_invoice/loop_invoice.tpl");
										$tpl_loop_invoice->set("invoice_uuid", $list_invoice['uuid']);
										if(!empty($list_invoice['date'])){
		                                             $tpl_loop_invoice->set("invoice_date", date_i18n("d F Y",$list_invoice['date']));
                                                  }else{
                                                       $tpl_loop_invoice->set("invoice_date", r4w_assets_svg_code('dash_no_data'));
                                                  }
										$tpl_loop_invoice->set("invoice_id", $list_invoice['id']);
										$tpl_loop_invoice->set("invoice_amount", number_format($list_invoice['amount']/100,2)."€");
										$tpl_list_invoice .= $tpl_loop_invoice->output();
									}
									$return = [
						                'success' => [
						                	'invoices' => $tpl_list_invoice
						                ]
						            ];
									echo json_encode($return);
									die();
								}
							}
						}
			    		break;
			    	case 'pdf_invoice':
			    		$curl_data = [
							"request_method" => "GET",
							"auth" => "true",
							"url" => "/wp/user/invoice/".$_POST['r4w_uuid'],
							"json_return" => false,
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"action" => $_POST['r4w_method']
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
						$file_pdf_id = $_POST['r4w_invoice'];
			            $target_dir = r4w_plugin_base.'/temp/';
						if (!file_exists($target_dir)) {
						    mkdir($target_dir, 0755, true);
						}
						if (file_put_contents($target_dir.'invoice_'.$file_pdf_id.'.pdf', $curl) !== false) {
							$file_create_pdf = true;
						}
						$return = [
			                'success' => [
			                	'url' => admin_url( 'admin.php?page=r4w_download_invoice&invoice_id='.$file_pdf_id ),
			                    'request' => md5(r4w_fcnt_uuid())
			                ]
			            ];
						echo json_encode($return);
						die();
			    		break;
			    }
			}
		}
		add_action( 'wp_ajax_r4w_exec_user_invoice', 'r4w_exec_user_invoice' );

	/**
	 * Récupération des informations de l'utilisateur
	 */
		function r4w_exec_account(){
			if(!empty($_POST['r4w_method'])){
				switch ($_POST['r4w_method']) {
					case 'r4w_account_update':
						parse_str(urldecode($_POST['r4w_data']), $r4w_account_updates);
						foreach ($r4w_account_updates as $r4w_account_update => $r4w_account_value) {
							$r4w_return_acc = [];
							$temp =& $r4w_config_ur4w_return_accpdate;
							foreach($r4w_update_keys as $r4w_update_key) {
								$temp =& $temp[$r4w_update_key];
							}
							$temp = $r4w_account_value;
						}
						$curl_data = [
							"request_method" => "PUT",
							"url" => "/wp/account/",
							"auth" => "true",
							"postfileds" => [
								"json_encode" => true,
								"data" => [
									"user_data" => $r4w_return_acc
								]
							]
						];
						$curl = r4w_curl_request($curl_data);
						$return = [
			                'success' => [
			                    'request' => md5(r4w_fcnt_uuid())
			                ]
			            ];
						echo json_encode($return);
						die();
					break;
				}
			}else{
				$curl_data = [
					"request_method" => "GET",
					"url" => "/wp/account/",
					"auth" => "true",
					"postfileds" => [
						"json_encode" => true,
						"data" => null
					]
				];
				$curl = r4w_curl_request($curl_data);

				$acc_email = r4w_assets_svg_code('dash_no_data');
				$acc_firstname = r4w_assets_svg_code('dash_no_data');
				$acc_lastname = r4w_assets_svg_code('dash_no_data');
				$preview_detail = '';
				$account = '';
				if(isset($curl['resp']['success'])){
					$account = $curl['resp']['success']['account'];
					if(isset($curl['resp']['success']['account']['type'])){
						$acc_type = $curl['resp']['success']['account']['type'];
					}
					if(isset($curl['resp']['success']['account']['email'])){
						$acc_email = $curl['resp']['success']['account']['email'];
					}
					if(isset($curl['resp']['success']['account']['individual']['firstname'])){
						$acc_firstname = $curl['resp']['success']['account']['individual']['firstname'];
					}
					if(isset($curl['resp']['success']['account']['individual']['lastname'])){
						$acc_lastname = $curl['resp']['success']['account']['individual']['lastname'];
					}
					if(isset($curl['resp']['success']['account']['professional']['company'])){
						$acc_company = $curl['resp']['success']['account']['professional']['company'];
					}

					if(empty($acc_type)){
						$preview_detail = ' <div><b>'.__('First name', 'app_rank4win').' :</b> '.$acc_firstname.'</div> <div><b>'.__('Last name','app_rank4win').' : </b>'.$acc_lastname.'</div>';
					}else{
						if($acc_type == 'individual'){
							$preview_detail = ' <div><b>'.__('First name', 'app_rank4win').' :</b> '.$acc_firstname.'</div> <div><b>'.__('Last name','app_rank4win').' :</b> '.$acc_lastname.'</div>';
						}
						if($acc_type == 'professional'){
							$preview_detail = ' <div><b>'.__('Company Name', 'app_rank4win').' :</b> '.$acc_company.'</div>';
						}
					}
				}
				$preview = '<div><b>'.__('E-mail', 'app_rank4win').' : </b>'.$acc_email.'</div>'.$preview_detail;
				$return = [
	                'success' => [
	                	'account' => $account,
	                	'preview' => $preview,
	                    'request' => md5(r4w_fcnt_uuid())
	                ]
	            ];
				echo json_encode($return);
				die();
			}
		}
		add_action( 'wp_ajax_r4w_exec_account', 'r4w_exec_account' );

	/**
	 * Récupère le contenue editorial
	 */
		function r4w_exec_editorial_content(){
			global $wpdb,$post;

			$pageID = get_option('page_on_front');

			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			if(!empty($_POST['r4w_post'])){
				$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$_POST['r4w_post']);
				$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);

				if(!empty($r4w_document['deploy_data'])){
					$update_data_deploy = json_decode(hex2bin($r4w_document['deploy_data']),true);
				}
				if(!empty($r4w_document['uuid'])){
					$post_childs = get_children($_POST['r4w_post']);
					$post = get_post($_POST['r4w_post']);
					$post_parent = $post->post_parent;

					$page_data_parent = get_post($post_parent);
					if($pageID != $_POST['r4w_post']){
						$wp_select_parent = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$page_data_parent->ID);
						$r4w_document_parent = $wpdb->get_row($wp_select_parent,ARRAY_A);

						if(!empty($r4w_document_parent['deploy_data'])){
							$update_data_deploy_parent = json_decode(hex2bin($r4w_document_parent['deploy_data']),true);
						}
						if($update_data_deploy_parent['keywords'] && $update_data_deploy_parent['keywords']['main']){
							if(is_array( $update_data_deploy_parent['keywords']['main'] )){
								$keyword_parent_main = $update_data_deploy_parent['keywords']['main'][0];
							}else{
								$keyword_parent_main = $update_data_deploy_parent['keywords']['main'];
							}
						}
						$k_parent = [
							'keyword_parent' => [
								'ID' => $page_data_parent->ID,
								'name' => $keyword_parent_main,
								'link' => get_permalink($post_parent)
							]
						];
					}
					$keywords = $update_data_deploy['keywords'];

					$data = [
						"post_parent" => $k_parent,
						"post_childs" => $post_childs,
						"keywords" => $keywords,
					];
					$editorial_content = r4w_fcnt_editorial_content($data);
				}
			}
			$return = [
				'success' => [
					'preview' => $editorial_content,
					'request' => md5(r4w_fcnt_uuid())
				]
			];
			echo json_encode($return);
			die();
		}
		add_action( 'wp_ajax_r4w_exec_editorial_content', 'r4w_exec_editorial_content' );

	/**
	 * Récupération des informations pour le support live
	 */
		function r4w_exec_support(){
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/support/",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl = r4w_curl_request($curl_data);
			if(isset($curl['resp']['success'])){
				$return = [
	                'success' => [
	                	'support' => $curl['resp']['success']['support'],
	                    'request' => md5(r4w_fcnt_uuid())
	                ]
	            ];
				echo json_encode($return);
				die();
			}
		}
		add_action( 'wp_ajax_r4w_exec_support', 'r4w_exec_support' );