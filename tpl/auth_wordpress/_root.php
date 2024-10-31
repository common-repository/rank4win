<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
/**
 * Vérifie que l'utilisateur est identifier
 */
	global $wpdb;
	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
    $wp_select = "SELECT * from ".$wp_table_app;
    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

    if(empty($r4w_app['oauth_tmp'])){
    	wp_redirect(get_admin_url('','admin.php?page=r4w_auth_login'));
    	exit;
    }

	/**
	 * Vérifie les identificaton du wordpress
	 */
		$curl_data = [
			"request_method" => "GET",
			"auth" => "tmp",
			"url" => "/wp/association/",
			"postfileds" => [
				"json_encode" => true,
				"data" => null
			]
		];
		$curl = r4w_curl_request($curl_data);
		if ($curl['err']) {
			wp_redirect(get_admin_url('','admin.php?page=r4w_unavailable'));
    		exit;
		} else {
			if($curl['info']['http_code'] == 401){
				if($curl['resp']['error']['name'] == 'bad_wp_token'){
					wp_redirect(get_admin_url('','admin.php?page=r4w_auth_login'));
	    			exit;
				}
			}
			if($curl['info']['http_code'] == 200){
				if($curl['resp']['success']['associated']){
					$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET oauth = %s, oauth_tmp = %s WHERE id = %d", $r4w_app['oauth_tmp'],'',1));
					wp_redirect(get_admin_url('','admin.php?page=r4w_settings'));
	    			exit;
				}
				$ctd->set("account_r4w", $curl['resp']['success']['account']);
			}
		}

	/**
	 * Ajout les text dans la page
	 */
	$ctd->set("link_wordpress", $_SERVER['SERVER_NAME']);

	/**
	 * GESTION DU FORMULAIRE
	 */
	if($_POST){
		if( $_POST['_method'] == "wordpress" ){
			$form_method = $_POST['_method'];
			if($_SESSION["authenticity"]["token"]["$form_method"]!=$_POST['authenticity_token']){
				$error = true;
			}else{
				unset($_SESSION["authenticity"]["token"]["$form_method"]);
			}
			if(empty($error)){
				$curl_data = [
					"request_method" => "PUT",
					"auth" => "tmp",
					"url" => "/wp/association/",
					"postfileds" => [
						"json_encode" => true,
						"data" => null
					]
				];
				$curl = r4w_curl_request($curl_data);
				if ($curl['err']) {
					wp_redirect(get_admin_url('','admin.php?page=r4w_unavailable'));
					exit;
				} else {
					if($curl['info']['http_code'] == 401){
						if($curl['resp']['error']['name'] == 'bad_wp_token'){
							wp_redirect(get_admin_url('','admin.php?page=r4w_auth_login'));
							exit;
						}
					}
					if($curl['info']['http_code'] == 200){
						if($curl['resp']['success']){
							$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET wp_activation = %s, oauth = %s, oauth_tmp = %s WHERE id = %d", md5(r4w_fcnt_uuid_activation()),$r4w_app['oauth_tmp'],'',1));
							wp_redirect(get_admin_url('','admin.php?page=r4w_settings'));
							exit;
						}
					}
				}
			}
		}
	}
	$ctd->set("authenticity_token_wordpress", r4w_auth_token('wordpress'));
