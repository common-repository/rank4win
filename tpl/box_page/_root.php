<?php
	/**
	 * Modifie le code par des balise de style (pour l'affichage)
	 */
	function callback_display_tag($a){
		$output = preg_replace_callback('/%%([^%%]*)%%/',function($matches){
			if(!empty($matches[1])){
				return '<span class="r4w_atwho" contenteditable="false"><sp>%%</sp>'.$matches[1].'<sp>%%</sp></span>';
			}else{
				return $matches[0];
			}
		} ,$a);
		return stripslashes($output);
	}

	global $wpdb, $r4w_define, $wp_query, $post;

	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
	$wp_table_taxonomy = $wpdb->prefix.r4w_bdd_table_taxonomy;
	$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
	$wp_table_option = $wpdb->prefix.'options';

    $wp_select = "SELECT * from ".$wp_table_app;
    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

	$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_option} WHERE option_name = %s",'blog_public');
	$wp_options = $wpdb->get_row($wp_select,ARRAY_A);

	if(!empty($r4w_app['settings']) AND ctype_xdigit($r4w_app['settings'])){
    	$GLOBALS['r4w_settings'] =  json_decode(hex2bin($r4w_app['settings']),true);
    	global $r4w_settings;
    }

	if(isset($tpl_data['callback_box']['callback']) AND $tpl_data['callback_box']['callback'] == 'r4w_callback_box_page'){
		$wp_post_id = get_the_ID();
		$GLOBALS['wp_post'] = $wp_post = get_post($wp_post_id);

    		global $wp_post;
		$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$wp_post_id);
		$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);

	    if(!empty($r4w_document['config']) AND ctype_xdigit($r4w_document['config'])){
			$wp_page_config = json_decode(hex2bin($r4w_document['config']),true);
		}

		if($wp_post_id == get_option('page_on_front')){
			if(!empty($r4w_settings['seo_settings']['basic_configuration']['home_page'])){
				$r4w_settings_type = $r4w_settings['seo_settings']['basic_configuration']['home_page'];
			}
		}else{
			if(!empty($r4w_settings['seo_settings']['types_content'][get_post_type($wp_post_id)])){
				$r4w_settings_type = $r4w_settings['seo_settings']['types_content'][get_post_type($wp_post_id)];
			}
		}

		$ctd->set("wp_type", 'wp-type="document" wp-id="'.$wp_post_id.'"');
		$ctd->set("class_type", 'r4w_document');
	}else{
		$GLOBALS['wp_term'] = $tpl_data['data'];
		global $wp_term;

		$wp_term_id = $tpl_data['data']->term_id;
		$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_taxonomy} WHERE term_id = %d",$wp_term_id);
		$r4w_taxonomy = $wpdb->get_row($wp_select,ARRAY_A);

	    if(!empty($r4w_taxonomy['config']) AND ctype_xdigit($r4w_taxonomy['config'])){
			$wp_page_config = json_decode(hex2bin($r4w_taxonomy['config']),true);
		}
		if(!empty($r4w_settings['seo_settings']['taxonomies'][$tpl_data['data']->taxonomy])){
			$r4w_settings_type = $r4w_settings['seo_settings']['taxonomies'][$tpl_data['data']->taxonomy];
		}

		$ctd->set("wp_type", 'wp-type="taxonomy" wp-id="'.$wp_term_id.'"');
		$ctd->set("class_type", 'r4w_taxonomy');
	}

    $ctd->set("tag_value", bin2hex(json_encode(r4w_callback_tag_all())));

	/**
	 * configuration
	 */
	$tpl_tab_config = new r4w_template(dirname(__FILE__)."/tab_config.tpl");

	if(isset($wp_page_config['page']['robots']['custom']) and $wp_page_config['page']['robots']['custom']=='on'){
		$tpl_tab_config->set("robots_custom", 'checked="checked"');
		if(isset($wp_page_config['page']['robots']['no_archive']) and $wp_page_config['page']['robots']['no_archive']=='on'){
			$tpl_tab_config->set("robots_no_archive", 'checked="checked"');
		}else{
			$tpl_tab_config->set("robots_no_archive", '');
		}
		if(isset($wp_page_config['page']['robots']['no_image']) and $wp_page_config['page']['robots']['no_image']=='on'){
			$tpl_tab_config->set("robots_no_image", 'checked="checked"');
		}else{
			$tpl_tab_config->set("robots_no_image", '');
		}
		if(isset($wp_page_config['page']['robots']['no_meta']) and $wp_page_config['page']['robots']['no_meta']=='on'){
			$tpl_tab_config->set("robots_no_meta", 'checked="checked"');
		}else{
			$tpl_tab_config->set("robots_no_meta", '');
		}
	}else{
		$tpl_tab_config->set("robots_custom", '');
		$tpl_tab_config->set("robots_no_archive", 'disabled="disabled"');
		$tpl_tab_config->set("robots_no_image", 'disabled="disabled"');
		$tpl_tab_config->set("robots_no_meta", 'disabled="disabled"');
	}

	/**
	 * page|index
	 */
	$checked = '';
	if(isset($wp_page_config['page']['index'])){
		if($wp_page_config['page']['index'] == 'on'){
			$checked = 'checked="checked"';
		}
	}else{
		if(isset($r4w_settings_type['index'])){
			if(!empty($r4w_settings_type['index']) AND $r4w_settings_type['index'] == "on"){
				$checked = 'checked="checked"';
			}
		}else{
			if($wp_options['option_value'] == 1){
				$checked = 'checked="checked"';
			}
		}
	}
	$tpl_tab_config->set("index", $checked);

	/**
	 * page|follow
	 */
	$checked = '';
	if(isset($wp_page_config['page']['follow'])){
		if($wp_page_config['page']['follow'] == 'on'){
			$checked = 'checked="checked"';
		}
	}else{
		if(!empty($r4w_settings_type['follow']) AND $r4w_settings_type['follow'] == "on"){
			$checked = 'checked="checked"';
		}
	}
	$tpl_tab_config->set("follow", $checked);

	if(isset($wp_page_config['page']['canonical'])){
		$tpl_tab_config->set("canonical", $wp_page_config['page']['canonical']);
	}else{
		$tpl_tab_config->set("canonical", "");
	}
	$ctd->set("tab_config", $tpl_tab_config->output());

	/**
	 * Contenue editorial
	 */
		$r4w_editorial = true;

		if(isset($r4w_document['deploy'])){
			
			$deploy_data = json_decode(hex2bin($r4w_document['deploy_data']),true);
			
			$ctd->set("js_editorial", '<script type="text/javascript">jQuery(document).ready(function(){new SimpleBar(document.getElementById("r4w_sc_editorial"), { autoHide: false });});</script>');

			$ctd->set("btn_edit_editorial", '<li id="page_sn_editorial" class="btn_tab"><div class="ico_tab css-5g0r5re5t0gre">'.r4w_assets_svg_code('workflow').'</div><div class="css-sd5g0rg80g"><div class="r4w_btn_title">'.__('Semantic structure', 'app_rank4win').'</div></div></li>');
			$tpl_tab_editorial = new r4w_template(dirname(__FILE__)."/tab_editorial.tpl");
			$tpl_tab_editorial->set("post_id", get_the_ID());

			$tpl_tab_editorial->set("image", '<div class="css-079f56384a91">'.__('No image', 'app_rank4win' ).'</div>');

			$tpl_tab_editorial->set("link", '<div class="css-079f56384a91">'.__('No link', 'app_rank4win' ).'</div>');
			$tpl_tab_editorial->set("note", '<div class="css-079f56384a91">'.__('No note', 'app_rank4win' ).'</div>');
			
			$data_progression = __('No progression', 'app_rank4win' );
			$data_priotiy = __('No priority', 'app_rank4win' );

			if($deploy_data['node']){
				switch ($deploy_data['node']['priority']) {
					case 1:
						$data_priotiy = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g id="node_priority1"><path id="kity_path_44" fill="#840023" stroke="none" d="M0,13c0,3.866,3.134,7,7,7h6c3.866,0,7-3.134,7-7V7H0V13z" transform="translate( 0.5 0.5 )"></path><path id="kity_path_45" fill="#FF1200" stroke="none" d="M20,10c0,3.866-3.134,7-7,7H7c-3.866,0-7-3.134-7-7V7c0-3.866,3.134-7,7-7h6c3.866,0,7,3.134,7,7V10z" opacity="0.8" transform="translate( 0.5 0.5 )"></path><text id="kity_text_46" text-rendering="geometricPrecision" x="9.5" y="10" text-anchor="middle" font-style="italic" font-size="12" fill="white" dy="5">1</text></g></svg>';
					break;
					case 2:
						$data_priotiy = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g id="node_priority1"><path id="kity_path_44" fill="#01467F" stroke="none" d="M0,13c0,3.866,3.134,7,7,7h6c3.866,0,7-3.134,7-7V7H0V13z" transform="translate( 0.5 0.5 )"></path><path id="kity_path_45" fill="#0074FF" stroke="none" d="M20,10c0,3.866-3.134,7-7,7H7c-3.866,0-7-3.134-7-7V7c0-3.866,3.134-7,7-7h6c3.866,0,7,3.134,7,7V10z" opacity="0.8" transform="translate( 0.5 0.5 )"></path><text id="kity_text_46" text-rendering="geometricPrecision" x="9.5" y="10" text-anchor="middle" font-style="italic" font-size="12" fill="white" dy="5">2</text></g></svg>';
					break;
					case 3:
						$data_priotiy = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g id="node_priority1"><path id="kity_path_44" fill="#006300" stroke="none" d="M0,13c0,3.866,3.134,7,7,7h6c3.866,0,7-3.134,7-7V7H0V13z" transform="translate( 0.5 0.5 )"></path><path id="kity_path_45" fill="#00AF00" stroke="none" d="M20,10c0,3.866-3.134,7-7,7H7c-3.866,0-7-3.134-7-7V7c0-3.866,3.134-7,7-7h6c3.866,0,7,3.134,7,7V10z" opacity="0.8" transform="translate( 0.5 0.5 )"></path><text id="kity_text_46" text-rendering="geometricPrecision" x="9.5" y="10" text-anchor="middle" font-style="italic" font-size="12" fill="white" dy="5">3</text></g></svg>';
					break;
					case 4:
						$data_priotiy = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g id="node_priority1"><path id="kity_path_44" fill="#B25000" stroke="none" d="M0,13c0,3.866,3.134,7,7,7h6c3.866,0,7-3.134,7-7V7H0V13z" transform="translate( 0.5 0.5 )"></path><path id="kity_path_45" fill="#FF962E" stroke="none" d="M20,10c0,3.866-3.134,7-7,7H7c-3.866,0-7-3.134-7-7V7c0-3.866,3.134-7,7-7h6c3.866,0,7,3.134,7,7V10z" opacity="0.8" transform="translate( 0.5 0.5 )"></path><text id="kity_text_46" text-rendering="geometricPrecision" x="9.5" y="10" text-anchor="middle" font-style="italic" font-size="12" fill="white" dy="5">4</text></g></svg>';
					break;
					case 5:
						$data_priotiy = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g id="node_priority1"><path id="kity_path_44" fill="#4720C4" stroke="none" d="M0,13c0,3.866,3.134,7,7,7h6c3.866,0,7-3.134,7-7V7H0V13z" transform="translate( 0.5 0.5 )"></path><path id="kity_path_45" fill="#A464FF" stroke="none" d="M20,10c0,3.866-3.134,7-7,7H7c-3.866,0-7-3.134-7-7V7c0-3.866,3.134-7,7-7h6c3.866,0,7,3.134,7,7V10z" opacity="0.8" transform="translate( 0.5 0.5 )"></path><text id="kity_text_46" text-rendering="geometricPrecision" x="9.5" y="10" text-anchor="middle" font-style="italic" font-size="12" fill="white" dy="5">5</text></g></svg>';
					break;
					case 6:
						$data_priotiy = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g id="node_priority1"><path id="kity_path_44" fill="#515151" stroke="none" d="M0,13c0,3.866,3.134,7,7,7h6c3.866,0,7-3.134,7-7V7H0V13z" transform="translate( 0.5 0.5 )"></path><path id="kity_path_45" fill="#A3A3A3" stroke="none" d="M20,10c0,3.866-3.134,7-7,7H7c-3.866,0-7-3.134-7-7V7c0-3.866,3.134-7,7-7h6c3.866,0,7,3.134,7,7V10z" opacity="0.8" transform="translate( 0.5 0.5 )"></path><text id="kity_text_46" text-rendering="geometricPrecision" x="9.5" y="10" text-anchor="middle" font-style="italic" font-size="12" fill="white" dy="5">6</text></g></svg>';
					break;
					case 7:
						$data_priotiy = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g id="node_priority1"><path id="kity_path_44" fill="#515151" stroke="none" d="M0,13c0,3.866,3.134,7,7,7h6c3.866,0,7-3.134,7-7V7H0V13z" transform="translate( 0.5 0.5 )"></path><path id="kity_path_45" fill="#A3A3A3" stroke="none" d="M20,10c0,3.866-3.134,7-7,7H7c-3.866,0-7-3.134-7-7V7c0-3.866,3.134-7,7-7h6c3.866,0,7,3.134,7,7V10z" opacity="0.8" transform="translate( 0.5 0.5 )"></path><text id="kity_text_46" text-rendering="geometricPrecision" x="9.5" y="10" text-anchor="middle" font-style="italic" font-size="12" fill="white" dy="5"></text>7</g></svg>';
					break;
					case 8:
						$data_priotiy = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g id="node_priority1"><path id="kity_path_44" fill="#515151" stroke="none" d="M0,13c0,3.866,3.134,7,7,7h6c3.866,0,7-3.134,7-7V7H0V13z" transform="translate( 0.5 0.5 )"></path><path id="kity_path_45" fill="#A3A3A3" stroke="none" d="M20,10c0,3.866-3.134,7-7,7H7c-3.866,0-7-3.134-7-7V7c0-3.866,3.134-7,7-7h6c3.866,0,7,3.134,7,7V10z" opacity="0.8" transform="translate( 0.5 0.5 )"></path><text id="kity_text_46" text-rendering="geometricPrecision" x="9.5" y="10" text-anchor="middle" font-style="italic" font-size="12" fill="white" dy="5">8</text></g></svg>';
					break;
					case 9:
						$data_priotiy = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g id="node_priority1"><path id="kity_path_44" fill="#515151" stroke="none" d="M0,13c0,3.866,3.134,7,7,7h6c3.866,0,7-3.134,7-7V7H0V13z" transform="translate( 0.5 0.5 )"></path><path id="kity_path_45" fill="#A3A3A3" stroke="none" d="M20,10c0,3.866-3.134,7-7,7H7c-3.866,0-7-3.134-7-7V7c0-3.866,3.134-7,7-7h6c3.866,0,7,3.134,7,7V10z" opacity="0.8" transform="translate( 0.5 0.5 )"></path><text id="kity_text_46" text-rendering="geometricPrecision" x="9.5" y="10" text-anchor="middle" font-style="italic" font-size="12" fill="white" dy="5">9</text></g></svg>';
					break;
					default:
						$data_priotiy = __('No priority', 'app_rank4win' );
					break;
				}
				switch ($deploy_data['node']['progress']) {
					case 1:
						$data_progression = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g id="node_progress1"><path id="kity_path_48" fill="#FFED83" stroke="none" d="M9,0A9,9,0,1,1,-9,0A9,9,0,1,1,9,0"></path><path id="kity_path_49" fill="#43BC00" stroke="none" d="M0 0L9 0A9,9,0,0,0,8.31491579260158 -3.444150891285808A9,9,0,0,0,6.3639610306789285 -6.363961030678928L0 0z"></path><path id="kity_path_50" fill="#8E8E8E" stroke="none" d="M10,3c4.418,0,8,3.582,8,8h1c0-5.523-3.477-10-9-10S1,5.477,1,11h1C2,6.582,5.582,3,10,3z" transform="translate( -10 -10 )"></path><path id="kity_path_52" fill="#EEE" stroke="none" transform="translate( -10 -10 )" d="M15.812,7.896l-6.75,6.75l-4.5-4.5L6.25,8.459l2.812,2.803l5.062-5.053L15.812,7.896z" display="none"></path><path id="kity_path_51" fill="url(#kity_linearGradient_17)" stroke="none" transform="translate( -10 -10 )" d="M10,0C4.477,0,0,4.477,0,10c0,5.523,4.477,10,10,10s10-4.477,10-10C20,4.477,15.523,0,10,0zM10,18c-4.418,0-8-3.582-8-8s3.582-8,8-8s8,3.582,8,8S14.418,18,10,18z"></path></g></svg>';
					break;
					case 2:
						$data_progression = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g><path id="kity_path_61" fill="#FFED83" stroke="none" d="M9,0A9,9,0,1,1,-9,0A9,9,0,1,1,9,0"></path><path id="kity_path_62" fill="#43BC00" stroke="none" d="M0 0L9 0A9,9,0,0,0,8.31491579260158 -3.444150891285808A9,9,0,0,0,6.3639610306789285 -6.363961030678928L0 0z"></path><path id="kity_path_63" fill="#8E8E8E" stroke="none" d="M10,3c4.418,0,8,3.582,8,8h1c0-5.523-3.477-10-9-10S1,5.477,1,11h1C2,6.582,5.582,3,10,3z" transform="translate( -10 -10 )"></path><path id="kity_path_65" fill="#EEE" stroke="none" transform="translate( -10 -10 )" d="M15.812,7.896l-6.75,6.75l-4.5-4.5L6.25,8.459l2.812,2.803l5.062-5.053L15.812,7.896z" display="none"></path><path id="kity_path_64" fill="url(#kity_linearGradient_17)" stroke="none" transform="translate( -10 -10 )" d="M10,0C4.477,0,0,4.477,0,10c0,5.523,4.477,10,10,10s10-4.477,10-10C20,4.477,15.523,0,10,0zM10,18c-4.418,0-8-3.582-8-8s3.582-8,8-8s8,3.582,8,8S14.418,18,10,18z"></path></g></svg>';
					break;
					case 3:
						$data_progression = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g><path id="kity_path_61" fill="#FFED83" stroke="none" d="M9,0A9,9,0,1,1,-9,0A9,9,0,1,1,9,0"></path><path id="kity_path_62" fill="#43BC00" stroke="none" d="M0 0L9 0A9,9,0,0,0,6.3639610306789285 -6.363961030678928A9,9,0,0,0,5.51091059616309e-16 -9L0 0z"></path><path id="kity_path_63" fill="#8E8E8E" stroke="none" d="M10,3c4.418,0,8,3.582,8,8h1c0-5.523-3.477-10-9-10S1,5.477,1,11h1C2,6.582,5.582,3,10,3z" transform="translate( -10 -10 )"></path><path id="kity_path_65" fill="#EEE" stroke="none" transform="translate( -10 -10 )" d="M15.812,7.896l-6.75,6.75l-4.5-4.5L6.25,8.459l2.812,2.803l5.062-5.053L15.812,7.896z" display="none"></path><path id="kity_path_64" fill="url(#kity_linearGradient_17)" stroke="none" transform="translate( -10 -10 )" d="M10,0C4.477,0,0,4.477,0,10c0,5.523,4.477,10,10,10s10-4.477,10-10C20,4.477,15.523,0,10,0zM10,18c-4.418,0-8-3.582-8-8s3.582-8,8-8s8,3.582,8,8S14.418,18,10,18z"></path></g></svg>';
					break;
					case 4:
						$data_progression = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g><path id="kity_path_61" fill="#FFED83" stroke="none" d="M9,0A9,9,0,1,1,-9,0A9,9,0,1,1,9,0"></path><path id="kity_path_62" fill="#43BC00" stroke="none" d="M0 0L9 0A9,9,0,0,0,3.4441508912858083 -8.31491579260158A9,9,0,0,0,-6.363961030678928 -6.3639610306789285L0 0z"></path><path id="kity_path_63" fill="#8E8E8E" stroke="none" d="M10,3c4.418,0,8,3.582,8,8h1c0-5.523-3.477-10-9-10S1,5.477,1,11h1C2,6.582,5.582,3,10,3z" transform="translate( -10 -10 )"></path><path id="kity_path_65" fill="#EEE" stroke="none" transform="translate( -10 -10 )" d="M15.812,7.896l-6.75,6.75l-4.5-4.5L6.25,8.459l2.812,2.803l5.062-5.053L15.812,7.896z" display="none"></path><path id="kity_path_64" fill="url(#kity_linearGradient_17)" stroke="none" transform="translate( -10 -10 )" d="M10,0C4.477,0,0,4.477,0,10c0,5.523,4.477,10,10,10s10-4.477,10-10C20,4.477,15.523,0,10,0zM10,18c-4.418,0-8-3.582-8-8s3.582-8,8-8s8,3.582,8,8S14.418,18,10,18z"></path></g></svg>';
					break;
					case 5:
						$data_progression = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g><path id="kity_path_61" fill="#FFED83" stroke="none" d="M9,0A9,9,0,1,1,-9,0A9,9,0,1,1,9,0"></path><path id="kity_path_62" fill="#43BC00" stroke="none" d="M0 0L9 0A9,9,0,0,0,5.51091059616309e-16 -9A9,9,0,0,0,-9 -1.102182119232618e-15L0 0z"></path><path id="kity_path_63" fill="#8E8E8E" stroke="none" d="M10,3c4.418,0,8,3.582,8,8h1c0-5.523-3.477-10-9-10S1,5.477,1,11h1C2,6.582,5.582,3,10,3z" transform="translate( -10 -10 )"></path><path id="kity_path_65" fill="#EEE" stroke="none" transform="translate( -10 -10 )" d="M15.812,7.896l-6.75,6.75l-4.5-4.5L6.25,8.459l2.812,2.803l5.062-5.053L15.812,7.896z" display="none"></path><path id="kity_path_64" fill="url(#kity_linearGradient_17)" stroke="none" transform="translate( -10 -10 )" d="M10,0C4.477,0,0,4.477,0,10c0,5.523,4.477,10,10,10s10-4.477,10-10C20,4.477,15.523,0,10,0zM10,18c-4.418,0-8-3.582-8-8s3.582-8,8-8s8,3.582,8,8S14.418,18,10,18z"></path></g></svg>';
					break;
					case 6:
						$data_progression = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g><path id="kity_path_43" fill="#FFED83" stroke="none" d="M9,0A9,9,0,1,1,-9,0A9,9,0,1,1,9,0"></path><path id="kity_path_44" fill="#43BC00" stroke="none" d="M0 0L9 0A9,9,0,0,0,-3.4441508912858074 -8.31491579260158A9,9,0,0,0,-6.363961030678929 6.363961030678928L0 0z"></path><path id="kity_path_45" fill="#8E8E8E" stroke="none" d="M10,3c4.418,0,8,3.582,8,8h1c0-5.523-3.477-10-9-10S1,5.477,1,11h1C2,6.582,5.582,3,10,3z" transform="translate( -10 -10 )"></path><path id="kity_path_47" fill="#EEE" stroke="none" transform="translate( -10 -10 )" d="M15.812,7.896l-6.75,6.75l-4.5-4.5L6.25,8.459l2.812,2.803l5.062-5.053L15.812,7.896z" display="none"></path><path id="kity_path_46" fill="url(#kity_linearGradient_17)" stroke="none" transform="translate( -10 -10 )" d="M10,0C4.477,0,0,4.477,0,10c0,5.523,4.477,10,10,10s10-4.477,10-10C20,4.477,15.523,0,10,0zM10,18c-4.418,0-8-3.582-8-8s3.582-8,8-8s8,3.582,8,8S14.418,18,10,18z"></path></g></svg>';
					break;
					case 7:
						$data_progression = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g><path id="kity_path_43" fill="#FFED83" stroke="none" d="M9,0A9,9,0,1,1,-9,0A9,9,0,1,1,9,0"></path><path id="kity_path_44" fill="#43BC00" stroke="none" d="M0 0L9 0A9,9,0,0,0,-6.363961030678928 -6.3639610306789285A9,9,0,0,0,-1.6532731788489267e-15 9L0 0z"></path><path id="kity_path_45" fill="#8E8E8E" stroke="none" d="M10,3c4.418,0,8,3.582,8,8h1c0-5.523-3.477-10-9-10S1,5.477,1,11h1C2,6.582,5.582,3,10,3z" transform="translate( -10 -10 )"></path><path id="kity_path_47" fill="#EEE" stroke="none" transform="translate( -10 -10 )" d="M15.812,7.896l-6.75,6.75l-4.5-4.5L6.25,8.459l2.812,2.803l5.062-5.053L15.812,7.896z" display="none"></path><path id="kity_path_46" fill="url(#kity_linearGradient_17)" stroke="none" transform="translate( -10 -10 )" d="M10,0C4.477,0,0,4.477,0,10c0,5.523,4.477,10,10,10s10-4.477,10-10C20,4.477,15.523,0,10,0zM10,18c-4.418,0-8-3.582-8-8s3.582-8,8-8s8,3.582,8,8S14.418,18,10,18z"></path></g></svg>';
					break;
					case 8:
						$data_progression = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g><path id="kity_path_43" fill="#FFED83" stroke="none" d="M9,0A9,9,0,1,1,-9,0A9,9,0,1,1,9,0"></path><path id="kity_path_44" fill="#43BC00" stroke="none" d="M0 0L9 0A9,9,0,0,0,-8.31491579260158 -3.444150891285809A9,9,0,0,0,6.363961030678926 6.363961030678929L0 0z"></path><path id="kity_path_45" fill="#8E8E8E" stroke="none" d="M10,3c4.418,0,8,3.582,8,8h1c0-5.523-3.477-10-9-10S1,5.477,1,11h1C2,6.582,5.582,3,10,3z" transform="translate( -10 -10 )"></path><path id="kity_path_47" fill="#EEE" stroke="none" transform="translate( -10 -10 )" d="M15.812,7.896l-6.75,6.75l-4.5-4.5L6.25,8.459l2.812,2.803l5.062-5.053L15.812,7.896z" display="none"></path><path id="kity_path_46" fill="url(#kity_linearGradient_17)" stroke="none" transform="translate( -10 -10 )" d="M10,0C4.477,0,0,4.477,0,10c0,5.523,4.477,10,10,10s10-4.477,10-10C20,4.477,15.523,0,10,0zM10,18c-4.418,0-8-3.582-8-8s3.582-8,8-8s8,3.582,8,8S14.418,18,10,18z"></path></g></svg>';
					break;
					case 9:
						$data_progression = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%"><g><path id="kity_path_43" fill="#FFED83" stroke="none" d="M9,0A9,9,0,1,1,-9,0A9,9,0,1,1,9,0"></path><path id="kity_path_44" fill="#43BC00" stroke="none" d="M0 0L9 0A9,9,0,0,1,-9 1.102182119232618e-15A9,9,0,0,1,9 -2.204364238465236e-15L0 0z"></path><path id="kity_path_45" fill="#8E8E8E" stroke="none" d="M10,3c4.418,0,8,3.582,8,8h1c0-5.523-3.477-10-9-10S1,5.477,1,11h1C2,6.582,5.582,3,10,3z" transform="translate( -10 -10 )"></path><path id="kity_path_47" fill="#EEE" stroke="none" transform="translate( -10 -10 )" d="M15.812,7.896l-6.75,6.75l-4.5-4.5L6.25,8.459l2.812,2.803l5.062-5.053L15.812,7.896z"></path><path id="kity_path_46" fill="url(#kity_linearGradient_17)" stroke="none" transform="translate( -10 -10 )" d="M10,0C4.477,0,0,4.477,0,10c0,5.523,4.477,10,10,10s10-4.477,10-10C20,4.477,15.523,0,10,0zM10,18c-4.418,0-8-3.582-8-8s3.582-8,8-8s8,3.582,8,8S14.418,18,10,18z"></path></g></svg>';
					break;
					default:
						$data_progression = __('No progression', 'app_rank4win' );
					break;
				}

				if($deploy_data['node']['image']){
					$tpl_tab_editorial->set("image", '<img class="css-bc4041cebd17" src="'.$deploy_data['node']['image'].'" alt="">');
				}
				
				if($deploy_data['node']['note']){
					$tpl_tab_editorial->set("note", '<div class="css-079f56384a91">'.$deploy_data['node']['note'].'</div>');
				}
				if($deploy_data['node']['hyperlink']){
					if($deploy_data['node']['hyperlinkTitle']){
						$title_link = $deploy_data['node']['hyperlinkTitle'];
					}else{
						$title_link = $deploy_data['node']['hyperlink'];
					}
					$tpl_tab_editorial->set("link", '<div class="css-079f56384a91"><a target="_blanc" href="'.$deploy_data['node']['hyperlink'].'">'.$title_link.'</a></div>');
				}
			}

			$tpl_tab_editorial->set("priority", $data_priotiy);
			$tpl_tab_editorial->set("progression", $data_progression);
			$ctd->set("tab_editorial", $tpl_tab_editorial->output());
			
		}else{
			$ctd->set("js_editorial", '');
			$ctd->set("cnt_editorial", '');
			$ctd->set("btn_edit_editorial", '');
			$ctd->set("tab_editorial", '');
		}

	/**
	 * Page Metatag
	 */

	if(isset($r4w_settings_type['editing_meta']) AND $r4w_settings_type['editing_meta']=='on'){
		$ctd->set("btn_edit_metatag", '<li id="page_sn_metatag" class="btn_tab"><div class="ico_tab css-2d5gere0t">'.r4w_assets_svg_code('tg_page_webmaster').'</div><div class="css-sd5g0rg80g"><div class="r4w_btn_title">'.__('Page', 'app_rank4win').'</div><div class="r4w_btn_sutitle">'.__('Metadata', 'app_rank4win').'</div></div></li>');

		$tpl_tab_metatag = new r4w_template(dirname(__FILE__)."/tab_metatag.tpl");
		if(isset($tpl_data['callback_box']['callback']) AND $tpl_data['callback_box']['callback'] == 'r4w_callback_box_page'){
			$post_type = get_post_type();
			if(isset($r4w_define['app']['tag']['basic_config_'.$post_type])){
				$r4w_define_basic_config = $r4w_define['app']['tag']['basic_config_'.$post_type];
			}else{
				$r4w_define_basic_config = $r4w_define['app']['tag']['basic_config'];
			}

			$tpl_tab_metatag->set("tag_data_title", bin2hex(json_encode($r4w_define_basic_config['title'])));
			$tpl_tab_metatag->set("tag_data_description", bin2hex(json_encode($r4w_define_basic_config['description'])));
			$preview_wp_post_title =   str_replace(array("\n", "\t", "\r"), '', substr(strip_tags($wp_post->post_title), 0,72));
			$preview_wp_post_description =  htmlentities(str_replace(array("\n", "\t", "\r"), '', substr(strip_tags($wp_post->post_content), 0,155)));
		}else{
			$term_id = $tpl_data['data']->term_id;
			$taxonomy = get_taxonomy($_GET['taxonomy']);
			$define_tag_title = $r4w_define['app']['tag']['taxonomy']['title'];
			$add_tag_title = [
				[
					"name" => sprintf(__('Name of %s','app_rank4win'), $taxonomy->label),
					"tag" => "term_name"
				]
			];
			if($taxonomy->name == 'category'){
				$add_category = [
					[
						"name" => __('Parent category', 'app_rank4win'),
						"tag" => "term_cat_parent"
					]
				];
				$add_tag_title = array_merge($add_tag_title, $add_category );
			}
			$define_tag_description = $r4w_define['app']['tag']['taxonomy']['description'];
			$add_tag_description = [
				[
					"name" => sprintf(__('Description of %s','app_rank4win'), $taxonomy->label),
					"tag" => "term_description"
				]
			];
			$tpl_tab_metatag->set("tag_data_title", bin2hex(json_encode(array_merge($add_tag_title,$define_tag_title))));
			$tpl_tab_metatag->set("tag_data_description", bin2hex(json_encode(array_merge($add_tag_description,$define_tag_description))));
			$preview_wp_post_title = '';
			$preview_wp_post_description = '';
		}
		$tpl_tab_metatag->set("wp_post_title", $preview_wp_post_title);
		$tpl_tab_metatag->set("wp_post_content", $preview_wp_post_description);

		if(isset($wp_page_config['page']['meta_title']) and !empty($wp_page_config['page']['meta_title'])){
			$meta_title = callback_display_tag($wp_page_config['page']['meta_title']);
			$tpl_tab_metatag->set("meta_title", $meta_title);
			$tpl_tab_metatag->set("preview_title", substr(r4w_callback_tag(strip_tags($meta_title)), 0,72));
		}else{
			$tpl_tab_metatag->set("meta_title", "");
			$tpl_tab_metatag->set("preview_title", r4w_callback_tag($preview_wp_post_title));
		}
		if(isset($wp_page_config['page']['meta_description']) and !empty($wp_page_config['page']['meta_description'])){
			$meta_description = callback_display_tag($wp_page_config['page']['meta_description']);
			$tpl_tab_metatag->set("meta_description", $meta_description);
			$tpl_tab_metatag->set("preview_description", substr(r4w_callback_tag(strip_tags($meta_description)), 0,155));
		}else{
			$tpl_tab_metatag->set("meta_description", "");
			$tpl_tab_metatag->set("preview_description", r4w_callback_tag($preview_wp_post_description));
		}
		$tpl_tab_metatag->set("preview_url", get_site_url());

		if(isset($tpl_data['callback_box']['callback']) AND $tpl_data['callback_box']['callback'] == 'r4w_callback_box_page'){
			$tpl_tab_metatag->set("preview_slug", $wp_post->post_name);
		}else{
			$tpl_tab_metatag->set("preview_slug", $tpl_data['data']->taxonomy.'	&rsaquo; '.$tpl_data['data']->slug);
		}

		$ctd->set("tab_metatag", $tpl_tab_metatag->output());
	}else{
		$ctd->set("btn_edit_metatag", '');
		$ctd->set("tab_metatag", '');
	}

	/**
	 * facbeook
	 */
	if(isset($r4w_settings['social_networks']['facebook']['editing_meta']) AND $r4w_settings['social_networks']['facebook']['editing_meta']=='on'){
		$ctd->set("btn_edit_facebook", '<li id="page_sn_facebook" class="btn_tab"><div class="ico_tab css-5hrtyrt0b">'.r4w_assets_svg_code('tsn_page_facebook').'</div><div class="css-sd5g0rg80g"><div class="r4w_btn_title">'.__('Facebook','app_rank4win').'</div><div class="r4w_btn_sutitle">'.__('Metadata','app_rank4win').'</div></div></li>');
		$tpl_tab_facebook = new r4w_template(dirname(__FILE__)."/tab_facebook.tpl");
		$tpl_tab_facebook->set("tag_data_title", bin2hex(json_encode($r4w_define['app']['tag']['basic_config']['title'])));
		$tpl_tab_facebook->set("tag_data_description", bin2hex(json_encode($r4w_define['app']['tag']['basic_config']['description'])));
		$checked = '';
		if(isset($tpl_data['callback_box']['callback']) AND $tpl_data['callback_box']['callback'] == 'r4w_callback_box_page'){
			$preview_wp_post_title =   str_replace(array("\n", "\t", "\r"), '', substr(strip_tags($wp_post->post_title), 0,72));
			$preview_wp_post_description =  str_replace(array("\n", "\t", "\r"), '', substr(strip_tags($wp_post->post_content), 0,155));
		}else{
			$preview_wp_post_title = '';
			$preview_wp_post_description = '';
		}
		$tpl_tab_facebook->set("wp_post_title", r4w_callback_tag($preview_wp_post_title));
		$tpl_tab_facebook->set("wp_post_content", htmlentities(r4w_callback_tag($preview_wp_post_description)));

		if(isset($wp_page_config['facebook']['replace_meta']) AND $wp_page_config['facebook']['replace_meta'] == 'on'){
			$checked = 'checked="checked"';
		}
		$tpl_tab_facebook->set("replace_meta", $checked);
		if(isset($wp_page_config['facebook']['meta_title']) and !empty($wp_page_config['facebook']['meta_title'])){
			$meta_title = callback_display_tag($wp_page_config['facebook']['meta_title']);
			$tpl_tab_facebook->set("meta_title", $meta_title);
			$tpl_tab_facebook->set("preview_title", substr(r4w_callback_tag(strip_tags($meta_title)), 0,72));
		}else{
			$tpl_tab_facebook->set("meta_title", "");
			$tpl_tab_facebook->set("preview_title", r4w_callback_tag($preview_wp_post_title));
		}
		if(isset($wp_page_config['facebook']['meta_description']) and !empty($wp_page_config['facebook']['meta_description'])){
			$meta_description = callback_display_tag($wp_page_config['facebook']['meta_description']);
			$tpl_tab_facebook->set("meta_description", $meta_description);
			$tpl_tab_facebook->set("preview_description", substr(r4w_callback_tag(strip_tags($meta_description)), 0,155));
		}else{
			$tpl_tab_facebook->set("meta_description", "");
			$tpl_tab_facebook->set("preview_description", r4w_callback_tag($preview_wp_post_description));
		}
		if(isset($wp_page_config['facebook']['picture']) and !empty($wp_page_config['facebook']['picture'])){
			$tpl_tab_facebook->set("picture", 'style="background-image: url('.$wp_page_config['facebook']['picture'].')"');
		}else{
			$tpl_tab_facebook->set("picture", "");
		}
		$preview_url = preg_replace('#^https?://#', '', get_site_url());
		$tpl_tab_facebook->set("preview_url", $preview_url);

		$ctd->set("tab_facebook", $tpl_tab_facebook->output());
	}else{
		$ctd->set("btn_edit_facebook", '');
		$ctd->set("tab_facebook", '');
	}
	/**
	 * twitter
	 */
	if(isset($r4w_settings['social_networks']['twitter']['editing_meta']) AND $r4w_settings['social_networks']['twitter']['editing_meta']=='on'){
		$ctd->set("btn_edit_twitter", '<li id="page_sn_twitter" class="btn_tab"><div class="ico_tab css-2hg0fjh0r">'.r4w_assets_svg_code('tsn_page_twitter').'</div><div class="css-sd5g0rg80g"><div class="r4w_btn_title">'.__('Twitter', 'app_rank4win').'</div><div class="r4w_btn_sutitle">'.__('Metadata', 'app_rank4win').'</div></div></li>');
		$tpl_tab_twitter = new r4w_template(dirname(__FILE__)."/tab_twitter.tpl");
		$tpl_tab_twitter->set("tag_data_title", bin2hex(json_encode($r4w_define['app']['tag']['basic_config']['title'])));
		$tpl_tab_twitter->set("tag_data_description", bin2hex(json_encode($r4w_define['app']['tag']['basic_config']['description'])));
		if(isset($tpl_data['callback_box']['callback']) AND $tpl_data['callback_box']['callback'] == 'r4w_callback_box_page'){
			$preview_wp_post_title =   str_replace(array("\n", "\t", "\r"), '', substr(strip_tags($wp_post->post_title), 0,72));
			$preview_wp_post_description =  str_replace(array("\n", "\t", "\r"), '', substr(strip_tags($wp_post->post_content), 0,155));
		}else{
			$preview_wp_post_title = '';
			$preview_wp_post_description = '';
		}
		$tpl_tab_twitter->set("wp_post_title", r4w_callback_tag($preview_wp_post_title));
		$tpl_tab_twitter->set("wp_post_content", htmlentities(r4w_callback_tag($preview_wp_post_description)));

		$checked = '';
		if(isset($wp_page_config['twitter']['replace_meta']) AND $wp_page_config['twitter']['replace_meta'] == 'on'){
			$checked = 'checked="checked"';
		}
		$tpl_tab_twitter->set("replace_meta", $checked);
		if(isset($wp_page_config['twitter']['meta_title']) and !empty($wp_page_config['twitter']['meta_title'])){
			$meta_title = callback_display_tag($wp_page_config['twitter']['meta_title']);
			$tpl_tab_twitter->set("meta_title", $meta_title);
			$tpl_tab_twitter->set("preview_title", substr(r4w_callback_tag(strip_tags($meta_title)), 0,72));
		}else{
			$tpl_tab_twitter->set("meta_title", "");
			$tpl_tab_twitter->set("preview_title", r4w_callback_tag($preview_wp_post_title));
		}
		if(isset($wp_page_config['twitter']['meta_description']) and !empty($wp_page_config['twitter']['meta_description'])){
			$meta_description = callback_display_tag($wp_page_config['twitter']['meta_description']);
			$tpl_tab_twitter->set("meta_description", $meta_description);
			$tpl_tab_twitter->set("preview_description", substr(r4w_callback_tag(strip_tags($meta_description)), 0,155));
		}else{
			$tpl_tab_twitter->set("meta_description", "");
			$tpl_tab_twitter->set("preview_description", r4w_callback_tag($preview_wp_post_description));
		}
		if(isset($wp_page_config['twitter']['picture']) and !empty($wp_page_config['twitter']['picture'])){
			$tpl_tab_twitter->set("picture", 'style="background-image: url('.$wp_page_config['twitter']['picture'].')"');
		}else{
			$tpl_tab_twitter->set("picture", "");
		}
		$preview_url = preg_replace('#^https?://#', '', get_site_url());
		$tpl_tab_twitter->set("preview_url", $preview_url);

		$ctd->set("tab_twitter", $tpl_tab_twitter->output());
	}else{
		$ctd->set("btn_edit_twitter", '');
		$ctd->set("tab_twitter", '');
	}

	/**
	 * Shortcode
	 */
	if($wp_post->post_type == 'page'){

		$ctd->set("btn_edit_shortcode", '<li id="page_sn_shortcode" class="btn_tab"><div class="ico_tab css-g5befyze0">'.r4w_assets_svg_code('tsn_page_shortcode').'</div><div class="css-sd5g0rg80g"><div class="r4w_btn_title">'.__('Links of sister pages', 'app_rank4win').'</div><div class="r4w_btn_sutitle">'.__('Shortcode', 'app_rank4win').'</div></div></li>');
		$tpl_tab_shortcode = new r4w_template(dirname(__FILE__)."/tab_shortcode.tpl");

		$pages_to_exclude = [];
		$pages_to_exclude[] = $post->post_parent;
		$pages_to_exclude[] = get_the_ID();
		if(!empty($post->post_parent)){
			$sister_pages_link = [
				'child_of' => $post->post_parent,
				'title_li' => '',
				'depth' => 1,
				'exclude' => implode(',', $pages_to_exclude),
				'echo' => 0
			];
			$sister_pages_link = wp_list_pages( $sister_pages_link );
		}
		if(!empty($sister_pages_link)){
			preg_match_all('/<a .*?>(.*?)<\/a>/',$sister_pages_link,$links);
			if(!empty($links[1])){
				$tpl_custom_link = '';
				foreach ($links[1] as $link) {

					if(!empty($wp_page_config['shortcode']['links'][bin2hex($link)])){
						$link_custom = $wp_page_config['shortcode']['links'][bin2hex($link)];
					}else{
						$link_custom = $link;
					}

					$tpl_custom_link .= '<div class="r4w_atwho_box select-field"> <label for="bac_hom_description">'.__('Link', 'app_rank4win').' : '.$link.' </label> <div class="r4w_autosave_info r4w_progress_div dsgn_input_athow"> <input class="athow_input r4w_autosave" name="shortcode|links|'.bin2hex($link).'"> <div contenteditable="true" class="athow_content" >'.$link_custom.'</div> </div> </div>';
				}
			}
		}
		if(!empty($tpl_custom_link)){
			$tpl_tab_shortcode->set("shortcode_customize_links", $tpl_custom_link);
		}else{
			$tpl_tab_shortcode->set("shortcode_customize_links", '');
		}

		$tpl_tab_shortcode->set("sc_sister_pages_link", r4w_shortcode_sister_page_link);
		$tpl_tab_shortcode->set("shortcode_customize_box_contenteditable", '');
		$tpl_tab_shortcode->set("shortcode_customize_athow", 'athow_content');
		$tpl_tab_shortcode->set("shortcode_customize_contenteditable", 'true');

		$checked = '';
		if(isset($wp_page_config['shortcode']['customize']['display']) AND $wp_page_config['shortcode']['customize']['display'] == 'on'){
			$checked = 'checked="checked"';
			if(isset($wp_page_config['shortcode']['customize']['title']) and !empty($wp_page_config['shortcode']['customize']['title'])){
				$tpl_tab_shortcode->set("shortcode_customize_title", $wp_page_config['shortcode']['customize']['title']);
			}else{
				$tpl_tab_shortcode->set("shortcode_customize_title", '');
			}
		}else{
			$tpl_tab_shortcode->set("shortcode_customize_box_contenteditable", 'content_disabled');
			$tpl_tab_shortcode->set("shortcode_customize_athow", 'athow_disabled');
			$tpl_tab_shortcode->set("shortcode_customize_contenteditable", 'false');
			$tpl_tab_shortcode->set("shortcode_customize_title", '');
		}
		$tpl_tab_shortcode->set("shortcode_customize_display", $checked);

		$ctd->set("tab_shortcode", $tpl_tab_shortcode->output());
	}else{
		$ctd->set("btn_edit_shortcode", '');
		$ctd->set("tab_shortcode", '');
	}
