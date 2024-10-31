<?php 
	if ( ! function_exists( 'r4w_curl_request' ) ) {
		/**
		 * Permet de transférer et récupérer des données sur le réseau rank4win
		 */ 
		function r4w_curl_request($a){
			global $wpdb;
			$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

		    $wp_select = "SELECT * from ".$wp_table_app;
		    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
		    if(!isset($a['json_return'])){
		    	$json_return = true;
		    }else{
		    	$json_return = $a['json_return'];
		    }
		    if(empty($postfileds) or !isset($postfileds)){
		    	$postfileds = null;
		    }
			if(!empty($a['postfileds']['data'])){
				if($a['postfileds']['json_encode']){
					$postfileds = json_encode($a['postfileds']['data']);
				}else{
					$postfileds = $a['postfileds']['data'];
				}
			}
			if($a['auth'] == 'true'){
				$httpdeader = [
			    	"Authorization: Wordpress ".$r4w_app['oauth'],
			    	"APIKEY: ".r4w_api_api_key,
				];
			}
			if($a['auth'] == 'tmp'){
				$httpdeader = [
			    	"Authorization: Wordpress ".$r4w_app['oauth_tmp'],
			    	"APIKEY: ".r4w_api_api_key,
				];
			}
			if($a['auth'] == 'false'){
				$httpdeader = [
					"Authorization: Wordpress ",
					"APIKEY: ".r4w_api_api_key,
				];
			}
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => r4w_api_url_base.r4w_get_version().r4w_api_url_request.$a['url'],
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 90,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => $a['request_method'],
			  CURLOPT_REFERER => $_SERVER['SERVER_NAME'],
			  CURLOPT_POSTFIELDS => $postfileds,
			  CURLOPT_HTTPHEADER => $httpdeader
			));
			if($json_return === false){
				$return = curl_exec($curl);
				curl_close($curl);
				return $return;
			}else{
				$resp = json_decode(curl_exec($curl),true);
				$err = curl_error($curl);
				$info = curl_getinfo($curl);
				curl_close($curl);
				$return = [
					"resp" => $resp,
					"err" => $err,
					"info" => $info
				];
				return $return;
			}
		}
	}