<?php
	global $wpdb;
	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
	$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

     $wp_select = "SELECT * from ".$wp_table_app;
     $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
	if(!empty($r4w_app['settings'])){
    		$r4w_settings =  json_decode(hex2bin($r4w_app['settings']),true);
     }
	$wp_post_id = get_the_ID();

	/**
	 * Ajout les text dans la page
	 */
	$ctd->set("wp_document_id", $wp_post_id);
	$ctd->set("javascript_modal", '');
	$ctd->set("btn_open_box_keyword", '');

	/**
	 * Recupère les dépendances du template
	 */
	$tpl_keyword_main = new r4w_template(dirname(__FILE__)."/keyword_main.tpl");
	$tpl_keyword_secondary = new r4w_template(dirname(__FILE__)."/keyword_secondary.tpl");
	$tpl_keyword_lexical = new r4w_template(dirname(__FILE__)."/keyword_lexical.tpl");
	$tpl_button = new r4w_template(dirname(__FILE__)."/button.tpl");

	$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$wp_post_id);
	$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);

	if(empty($r4w_document['hash_param'])){
		$create_doc_sync = false;
		if(!empty($r4w_document['data'])){
			$r4w_data = json_decode(hex2bin($r4w_document['data']),true);
			if(!empty($r4w_document['uuid']) AND !empty($r4w_document['deploy_data'])){
				$deploy_data = json_decode(hex2bin($r4w_document['deploy_data']),true);
				if( !empty($deploy_data['keywords']) AND !empty($deploy_data['keywords']['main']) AND !empty($deploy_data['keywords']['secondary']) AND !empty($deploy_data['keywords']['lexical']) ){
					$create_doc_sync = true;
				}
			}
		}else{
			if(!empty($r4w_document['uuid']) AND !empty($r4w_document['deploy_data'])){
				$create_doc_sync = true;
			}
		}
		if($create_doc_sync){
			$deploy_data = json_decode(hex2bin($r4w_document['deploy_data']),true);
			$document_keyword = $deploy_data['keywords']['main'][0];
			if($document_keyword){
				$curl_data = [
					"request_method" => "PUT",
					"auth" => "true",
					"url" => "/wp/create/document/",
					"postfileds" => [
						"json_encode" => true,
						"data" => [
							"uuid" => $r4w_document['uuid'],
							"wp_post_id" => $wp_post_id,
							"deploy_data" => $r4w_document['deploy_data']
						]
					]
				];
				$curl = r4w_curl_request($curl_data);
				if (isset($curl['err']) AND !empty($curl['err'])) {
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
				if($curl['resp']['success']){
					$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET request= %s, data = %s, locale_uuid = %s, timecode = %s, hash_param = %s WHERE uuid = %s", $curl['resp']['success']['keyword'], $curl['resp']['success']['data'], $curl['resp']['success']['locale_uuid'], $curl['resp']['success']['timecode'], $curl['resp']['success']['hash_param'], $r4w_document['uuid']));
					$r4w_data = json_decode(hex2bin($curl['resp']['success']['data']),true);
					if(!empty($curl['resp']['success']['hash_param'])){
						$link = admin_url( 'post.php?post='.$wp_post_id.'&action=edit' );
						header('location:'.$link);
					}
				}
			}
		}

		$fcnt_keywords_suggestion = '';
		if(empty($r4w_data['keywords_main'])){
			$tpl_modal_launch = "r4w_box-keyword_main";
			$type_keyword = "main";
		}
		if(empty($r4w_data['keywords_secondary']) AND empty($tpl_modal_launch)){
			$tpl_modal_launch = "r4w_box-keyword_secondary";
			$type_keyword = "secondary";
		}
		if(empty($r4w_data['keywords_lexical']) AND empty($tpl_modal_launch)){
			$tpl_modal_launch = "r4w_box-keyword_lexical";
			$type_keyword = "lexical";
		}
		if(!empty($type_keyword)){
			if($type_keyword != "main"){
				$fcnt_keywords_suggestion = 'keywords_suggestion("'.$type_keyword.'")';
			}
			$ctd->set("javascript_modal", '<script type="text/javascript">jQuery(document).ready(function(){jQuery("#'.$tpl_modal_launch.'").modal(); '.$fcnt_keywords_suggestion.'});</script>');
		}
	}
	$tpl_keyword_main->set("r4w_locale", $r4w_settings['general_setting']['language']);
	if(!empty($type_keyword)){
		$ctd->set("btn_open_box_keyword", $tpl_button->output());
		$ctd->set("open_keyword", $type_keyword);
	}
	$ctd->set("box_km", $tpl_keyword_main->output());
	$ctd->set("box_ks", $tpl_keyword_secondary->output());
	$ctd->set("box_kl", $tpl_keyword_lexical->output());