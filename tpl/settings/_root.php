<?php
	global $wpdb,$r4w_define;

	r4w_wizard();

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
		return $output;
	}

	/**
	 * Récupération du template "tab_general"
	 */
		$tpl_tab_general = new r4w_template(dirname(__FILE__)."/tab_general/contained.tpl");
		$ctd->set("tab_general", $tpl_tab_general->output());

			// Incorporation de "tab_language"
			$tpl_tg_language = new r4w_template(dirname(__FILE__)."/tab_general/tab_language.tpl");
			$ctd->set("tab_language", $tpl_tg_language->output());

			// Incorporation de "tab_analysis"
			$tpl_tg_analysis = new r4w_template(dirname(__FILE__)."/tab_general/tab_analysis.tpl");
			$ctd->set("tab_analysis", $tpl_tg_analysis->output());

			// Incorporation de "tab_feature"
			$tpl_tg_feature = new r4w_template(dirname(__FILE__)."/tab_general/tab_feature.tpl");
			$ctd->set("tab_feature", $tpl_tg_feature->output());

			// Incorporation de "tab_permalinks"
			$tpl_tg_permalinks = new r4w_template(dirname(__FILE__)."/tab_general/tab_permalinks.tpl");
			$ctd->set("tab_permalinks", $tpl_tg_permalinks->output());

			// Incorporation de "tab_sisterlinks"
			$tpl_tg_sisterlinks = new r4w_template(dirname(__FILE__)."/tab_general/tab_sisterlinks.tpl");
			$ctd->set("tab_sisterlinks", $tpl_tg_sisterlinks->output());

			
			// Incorporation de "tab_webmaster"
			$tpl_tg_webmaster = new r4w_template(dirname(__FILE__)."/tab_general/tab_webmaster.tpl");
			$ctd->set("tab_webmaster", $tpl_tg_webmaster->output());

			// Incorporation de "tab_permalinks"
			$tpl_tg_support = new r4w_template(dirname(__FILE__)."/tab_general/tab_support.tpl");
			$ctd->set("tab_support", $tpl_tg_support->output());

	/**
	 * Récupération du template "tab_seo_settings"
	 */
		$tpl_tab_seo_settings = new r4w_template(dirname(__FILE__)."/tab_seo_settings/contained.tpl");
		$ctd->set("tab_seo_settings", $tpl_tab_seo_settings->output());

			// Incorporation de "tab_basic_config"
			$tpl_tbc_basic_config = new r4w_template(dirname(__FILE__)."/tab_seo_settings/tab_basic_config.tpl");
			$tpl_tbc_basic_config->set("tag_data", bin2hex(json_encode($r4w_define['app']['tag']['basic_config'])));
			$ctd->set("tab_basic_config", $tpl_tbc_basic_config->output());

			// Incorporation de "tab_type"
			$tpl_tbc_type = new r4w_template(dirname(__FILE__)."/tab_seo_settings/tab_type.tpl");
			$ctd->set("tab_type", $tpl_tbc_type->output());

			// Incorporation de "tab_taxonomy"
			$tpl_tbc_taxonomy = new r4w_template(dirname(__FILE__)."/tab_seo_settings/tab_taxonomy.tpl");
			$ctd->set("tab_taxonomy", $tpl_tbc_taxonomy->output());

			// Incorporation de "tab_archive"
			$tpl_tbc_archive = new r4w_template(dirname(__FILE__)."/tab_seo_settings/tab_archive.tpl");
			$tpl_tbc_archive->set("author_archives_tag_data_title", bin2hex(json_encode($r4w_define['app']['tag']['authors_archives']['title'])));
			$tpl_tbc_archive->set("author_archives_tag_data_description", bin2hex(json_encode($r4w_define['app']['tag']['authors_archives']['description'])));

			$tpl_tbc_archive->set("date_archives_tag_data_title", bin2hex(json_encode($r4w_define['app']['tag']['dates_archives']['title'])));
			$tpl_tbc_archive->set("date_archives_tag_data_description", bin2hex(json_encode($r4w_define['app']['tag']['dates_archives']['description'])));

			$ctd->set("tab_archive", $tpl_tbc_archive->output());

			// Incorporation de "tab_special_page"
			$tpl_tbc_special_page = new r4w_template(dirname(__FILE__)."/tab_seo_settings/tab_special_page.tpl");
			$tpl_tbc_special_page->set("tag_data_search", bin2hex(json_encode($r4w_define['app']['tag']['special_page_search'])));
			$tpl_tbc_special_page->set("tag_data_error404", bin2hex(json_encode($r4w_define['app']['tag']['special_page_404'])));
			$ctd->set("tab_special_page", $tpl_tbc_special_page->output());

			// Incorporation de "tab_rss"
			$tpl_tbc_rss = new r4w_template(dirname(__FILE__)."/tab_seo_settings/tab_rss.tpl");
			$tpl_tbc_rss->set("tag_data", bin2hex(json_encode($r4w_define['app']['tag']['rss'])));
			$ctd->set("tab_rss", $tpl_tbc_rss->output());


	/**
	 * Récupération du template "tab_social_networks"
	 */
		$tpl_tab_social_networks = new r4w_template(dirname(__FILE__)."/tab_social_networks/contained.tpl");
		$ctd->set("tab_social_networks", $tpl_tab_social_networks->output());

			// Incorporation de "tab_open_graph"
			$tpl_tsn_open_graph = new r4w_template(dirname(__FILE__)."/tab_social_networks/tab_open_graph.tpl");
			$ctd->set("tab_open_graph", $tpl_tsn_open_graph->output());

			// Incorporation de "tab_facebook"
			$tpl_tsn_facebook = new r4w_template(dirname(__FILE__)."/tab_social_networks/tab_facebook.tpl");
			$ctd->set("tab_facebook", $tpl_tsn_facebook->output());

			// Incorporation de "tab_twitter"
			$tpl_tsn_twitter = new r4w_template(dirname(__FILE__)."/tab_social_networks/tab_twitter.tpl");
			$ctd->set("tab_twitter", $tpl_tsn_twitter->output());

			// Incorporation de "tab_pinterest"
			$tpl_tsn_pinterest = new r4w_template(dirname(__FILE__)."/tab_social_networks/tab_pinterest.tpl");
			$ctd->set("tab_pinterest", $tpl_tsn_pinterest->output());


	/**
	 * Récupération du template "tab_tool"
	 */
		$tpl_tab_tool = new r4w_template(dirname(__FILE__)."/tab_tool/contained.tpl");
		$ctd->set("tab_tool", $tpl_tab_tool->output());

			// Incorporation de "tab_export_import"
			$tpl_tsn_export_import = new r4w_template(dirname(__FILE__)."/tab_tool/tab_export_import.tpl");
			$ctd->set("tab_export_import", $tpl_tsn_export_import->output());

			// Incorporation de "tab_file_editor"
			$tpl_tsn_file_editor = new r4w_template(dirname(__FILE__)."/tab_tool/tab_file_editor.tpl");
			$ctd->set("tab_file_editor", $tpl_tsn_file_editor->output());

			// Incorporation de "tab_reset"
			$tpl_tsn_reset = new r4w_template(dirname(__FILE__)."/tab_tool/tab_reset.tpl");
			$ctd->set("tab_reset", $tpl_tsn_reset->output());


		$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
		$wp_table_option = $wpdb->prefix.'options';

		$wp_select = "SELECT * from ".$wp_table_app;
		$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

		$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_option} WHERE option_name = %s",'blog_public');
		$wp_options = $wpdb->get_row($wp_select,ARRAY_A);

		if(!empty($r4w_app['settings']) AND ctype_xdigit($r4w_app['settings'])){
			$wp_setting = json_decode(hex2bin($r4w_app['settings']),true);
		}
		if(empty($wp_setting['general_setting']['language'])){
			wp_redirect( admin_url( 'admin.php?page=r4w_wizard' ) );
			exit;
		}

		$curl_data = [
		"request_method" => "GET",
		"url" => "/wp/config/",
		"auth" => "true",
		"postfileds" => [
				"json_encode" => true,
				"data" => [
					"wp_setting" => $r4w_app['settings']
				]
			]
		];
		$curl_settings = r4w_curl_request($curl_data);
		if(empty($curl_settings['resp']['success'])){
			wp_redirect( admin_url( 'admin.php?page=r4w_auth_login' ) );
			exit;
		}

		$curl_settings['resp']['success']['synchronization']['status'] = false;
		if($curl_settings['resp']['success']['synchronization']['status'] == false){

			
		$ctd->set("javascript_modal", '');

		if(empty($curl_settings['resp']['success']['synchronization']['last_backup']) OR is_null($curl_settings['resp']['success']['synchronization']['last_backup'])){
			$last_backup = __('No information', 'app_rank4win');
		}else{
			$last_backup = date_i18n("d F Y (H:i:s)",$curl_settings['resp']['success']['synchronization']['last_backup']);
		}

		$ctd->set("cloud_last_backup", $last_backup);
	}else{
		$ctd->set("javascript_modal", '');
		$ctd->set("cloud_last_backup", '');
	}
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
					"generalsettings_support",
					"tools_exportimport",
					"tools_fileditor"
				]
			]
		]
	];
	$curl_feature = r4w_curl_request($curl_data);

	/**
	 * general_setting | language
	 */
		if(!empty($curl_settings['resp']['success']['locale'])){
			$tpl_option_language = '';
			foreach ($curl_settings['resp']['success']['locale'] as $locale) {
				/**
				 * Vérifie si la langue est selectioner dans les paramètres
				 */
				$selected = '';
				if(isset($wp_setting['general_setting']['language']) AND $wp_setting['general_setting']['language'] == $locale['uuid']){
					$selected = 'selected="selected"';
				}
				/**
				 * Affiche l'option
				 */
				$tpl_option_language .= '<option value="'.$locale['uuid'].'" '.$selected.'>'.$locale['name'].'</option>';
			}
			$ctd->set("list_language", $tpl_option_language);
		}

	/**
	 * general_setting | analysis
	 */
		if(!empty($r4w_define['app']['post_types'])){
			$tpl_analyisis_input = '';
			foreach ($r4w_define['app']['post_types'] as $post_type) {
				if(array_key_exists($post_type['slug'], get_post_types(array( 'public' => true )))){
					/**
					 * Vérifie si le "post_type" est activé dans les paramètres
					 */
					$checked = '';
					if(isset($wp_setting['general_setting']['analysis'][$post_type['slug']]) AND $wp_setting['general_setting']['analysis'][$post_type['slug']] == 'on'){
						$checked = 'checked="checked"';
					}
					/**
					 * Affiche la description de l'option
					 */
					$r4w_info = sprintf(__('This option allows you to enable the analysis in %s','app_rank4win'), $post_type['name']);
					/**
					 * Affiche l'option
					 */
					$tpl_analyisis_input .= '<div class="switch r4w_autosave_info"><label><input type="checkbox" class="r4w_autosave" name="general_setting|analysis|'.$post_type['slug'].'" '.$checked.'><span class="lever"></span>'.$post_type['name'].'</label></div><div class="r4w_additional_info">'.$r4w_info.'</div>';
				}
			}
			$ctd->set("list_analyisis", $tpl_analyisis_input);
		}

	/**
	 * general_setting | feature
	 */

 		if($curl_feature['resp']['success']['features']['generalsettings_counterlinks'] == "true"){
 			$ctd->set("rs_counter_links_txt", '');
			$checked = '';
			if(isset($wp_setting['general_setting']['feature']['counter_links']) AND $wp_setting['general_setting']['feature']['counter_links'] == 'on'){
				$checked = 'checked="checked"';
			}
			$ctd->set("counter_links", $checked);
 		}else{
 			$ctd->set("rs_counter_links_txt", $r4w_define['app']['requires_sub']['msg']);
 			$ctd->set("counter_links", $r4w_define['app']['requires_sub']['input']);
 		}

		if(isset($wp_setting['general_setting']['feature']['xml_sitemaps']) AND $wp_setting['general_setting']['feature']['xml_sitemaps'] == 'on'){
			$ctd->set("xml_sitemaps", 'checked="checked"');
			$ctd->set("sitemaps_active", 'active');
		}else{
			$ctd->set("sitemaps_active", '');
			$ctd->set("xml_sitemaps", '');
		}

 		if($curl_feature['resp']['success']['features']['generalsettings_support'] == "true"){
 			$ctd->set("rs_support_chat_txt", '');
			$checked = '';
			if(isset($wp_setting['general_setting']['support']['chat']) AND $wp_setting['general_setting']['support']['chat'] == 'on'){
				$checked = 'checked="checked"';
			}
			$ctd->set("support_chat", $checked);
 		}else{
 			$ctd->set("rs_support_chat_txt", $r4w_define['app']['requires_sub']['msg']);
 			$ctd->set("support_chat", $r4w_define['app']['requires_sub']['input']);
 		}

		$checked = '';
		if(isset($wp_setting['general_setting']['feature']['overallscore']) AND $wp_setting['general_setting']['feature']['overallscore'] == 'on'){
			$checked = 'checked="checked"';
		}
		$ctd->set("overallscore", $checked);

		$checked = '';
		if(isset($wp_setting['general_setting']['feature']['indexability']) AND $wp_setting['general_setting']['feature']['indexability'] == 'on'){
			$checked = 'checked="checked"';
		}
		$ctd->set("indexability", $checked);

	/**
	 * general_setting | permalinks
	 */
 		if($curl_feature['resp']['success']['features']['generalsettings_permalinks'] == "true"){
 			$ctd->set("rs_parmalinks_txt", '');
			$checked = '';
			if(isset($wp_setting['general_setting']['parmalinks']['remove_homepage']) AND $wp_setting['general_setting']['parmalinks']['remove_homepage'] == 'on'){
				$checked = 'checked="checked"';
			}
			$ctd->set("remove_homepage", $checked);
 		}else{
 			$ctd->set("rs_parmalinks_txt", $r4w_define['app']['requires_sub']['msg']);
 			$ctd->set("remove_homepage", $r4w_define['app']['requires_sub']['input']);
		 }
		 
	/**
	 * general_setting | sisterlinks
	 */
		$tpl_option_sisterlinks = '';
		$lists_option_sister = [
			"5","10","20","30","40","50","60","70","80","90","100","200","300","400","500","600","700","800","900","1000","2000","3000","4000","5000","6000","7000","8000","9000","10000","unlimited"
		];
		if(empty($wp_setting['general_setting']['sisterlinks']['limit'])){
			$wp_setting['general_setting']['sisterlinks']['limit'] = 20;
		}
		foreach ($lists_option_sister as $list_option_sister) {
			/**
			 * Vérifie si la valeur est selectioner dans les paramètres
			 */
			$selected = '';
			if(isset($wp_setting['general_setting']['sisterlinks']['limit']) AND $wp_setting['general_setting']['sisterlinks']['limit'] == $list_option_sister){
				$selected = 'selected="selected"';
			}

			 $option_name = $list_option_sister;
			 if($list_option_sister == "unlimited"){
				 $option_name = __('No limit','app_rank4win');
			 }
			 
			$tpl_option_sisterlinks .= '<option value="'.$list_option_sister.'" '.$selected.'>'.$option_name.'</option>';
		}
		$ctd->set("list_sisterlinks", $tpl_option_sisterlinks);
		
		
	/**
	 * general_setting | webmaster_tools
	 */
		if(isset($wp_setting['general_setting']['webmaster_tools']['google'])){
			$ctd->set("google", $wp_setting['general_setting']['webmaster_tools']['google']);
		}else{
			$ctd->set("google", '');
		}
		if(isset($wp_setting['general_setting']['webmaster_tools']['bing'])){
			$ctd->set("bing", $wp_setting['general_setting']['webmaster_tools']['bing']);
		}else{
			$ctd->set("bing", '');
		}
		if(isset($wp_setting['general_setting']['webmaster_tools']['baidu'])){
			$ctd->set("baidu", $wp_setting['general_setting']['webmaster_tools']['baidu']);
		}else{
			$ctd->set("baidu", '');
		}
		if(isset($wp_setting['general_setting']['webmaster_tools']['yandex'])){
			$ctd->set("yandex", $wp_setting['general_setting']['webmaster_tools']['yandex']);
		}else{
			$ctd->set("yandex", '');
		}


	/**
	 * seo_settings | basic_configuration | no_index
	 */
		$checked = '';
		if($wp_options['option_value'] == 1){
			$checked = 'checked="checked"';
		}
		$ctd->set("seo_settings_noindex", $checked);

	/**
	 * seo_settings | basic_configuration | title_separator
	 */
		if(!empty($r4w_define['app']['title_separator'])){
			$tpl_title_separator = '';
			foreach ($r4w_define['app']['title_separator'] as $title_separator_value => $title_separator_name) {
				/**
				 * Vérifie le "title_separator" activé
				 */
				$checked = '';
				if(isset($wp_setting['seo_settings']['basic_configuration']['title_separator']) AND $wp_setting['seo_settings']['basic_configuration']['title_separator'] == $title_separator_value){
					$checked = 'checked="checked"';
				}
				/**
				 * Affiche l'option
				 */
				$tpl_title_separator .= '<input id="'.$title_separator_value.'" type="radio" value="'.$title_separator_value.'" class="r4w_autosave" name="seo_settings|basic_configuration|title_separator" '.$checked.'/><label for="'.$title_separator_value.'">'.$title_separator_name.'</label>';
			}
		}
		$ctd->set("title_separator", $tpl_title_separator);

		$checked = '';
		if(isset($wp_setting['seo_settings']['basic_configuration']['home_page']['editing_meta']) AND $wp_setting['seo_settings']['basic_configuration']['home_page']['editing_meta'] == 'on'){
			$checked = 'checked="checked"';
		}
		$ctd->set("home_page_editing_meta", $checked);

		$checked = '';
		if(isset($wp_setting['seo_settings']['basic_configuration']['home_page']['index']) AND $wp_setting['seo_settings']['basic_configuration']['home_page']['index'] == 'on'){
			$checked = 'checked="checked"';
		}
		$ctd->set("home_page_index", $checked);

		$checked = '';
		if(isset($wp_setting['seo_settings']['basic_configuration']['home_page']['follow']) AND $wp_setting['seo_settings']['basic_configuration']['home_page']['follow'] == 'on'){
			$checked = 'checked="checked"';
		}
		$ctd->set("home_page_follow", $checked);

	/**
	 * seo_settings | basic_configuration | home_page | meta_title
	 */
		if(isset($wp_setting['seo_settings']['basic_configuration']['home_page']['meta_title'])){
			$meta_title = callback_display_tag($wp_setting['seo_settings']['basic_configuration']['home_page']['meta_title']);
			$ctd->set("home_page_meta_title", $meta_title);
		}else{
			$ctd->set("home_page_meta_title", '');
		}

	/**
	 * seo_settings | basic_configuration | home_page | meta_description
	 */
		if(isset($wp_setting['seo_settings']['basic_configuration']['home_page']['meta_description'])){
			$meta_description = callback_display_tag($wp_setting['seo_settings']['basic_configuration']['home_page']['meta_description']);
			$ctd->set("home_page_meta_description", $meta_description);
		}else{
			$ctd->set("home_page_meta_description", '');
		}

		$ctd->set("tag_data_home_title", bin2hex(json_encode($r4w_define['app']['tag']['type_contenu']['title'])));
		$ctd->set("tag_data_home_description", bin2hex(json_encode($r4w_define['app']['tag']['type_contenu']['description'])));


	/**
	 * seo_settings | basic_configuration | knowledge_graph | type
	 */
		$tpl_knowledge_graph_type_option = '';
		foreach ($r4w_define['app']['knowledge_graph']['type'] as $knowledge_graph_type_option) {
			$selected = '';
			if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['type']) AND $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['type'] == $knowledge_graph_type_option['slug']){
				$selected = 'selected="selected"';
			}
			$tpl_knowledge_graph_type_option .= '<option value="'.$knowledge_graph_type_option['slug'].'" '.$selected.'>'.$knowledge_graph_type_option['name'].'</option>';
		}
		$ctd->set("knowledge_graph_type_option", $tpl_knowledge_graph_type_option);

	/**
	 * knowledge_graph : Person
	 */
		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['name'])){
			$ctd->set("kg_person_name", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['name']);
		}else{
			$ctd->set("kg_person_name", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['jobTitle'])){
			$ctd->set("kg_person_jobTitle", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['jobTitle']);
		}else{
			$ctd->set("kg_person_jobTitle", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['image'])){
			$ctd->set("kg_person_image", 'style="background-image: url('.$wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['image'].')"');
		}else{
			$ctd->set("kg_person_image", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['url'])){
			$ctd->set("kg_person_url", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['url']);
		}else{
			$ctd->set("kg_person_url", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['address']['streetAddress'])){
			$ctd->set("kg_person_address_streetAddress", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['address']['streetAddress']);
		}else{
			$ctd->set("kg_person_address_streetAddress", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['address']['postalCode'])){
			$ctd->set("kg_person_address_postalCode", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['address']['postalCode']);
		}else{
			$ctd->set("kg_person_address_postalCode", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['address']['addressLocality'])){
			$ctd->set("kg_person_address_addressLocality", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['address']['addressLocality']);
		}else{
			$ctd->set("kg_person_address_addressLocality", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['address']['addressCountry'])){
			$ctd->set("kg_person_address_addressCountry", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['address']['addressCountry']);
		}else{
			$ctd->set("kg_person_address_addressCountry", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['email'])){
			$ctd->set("kg_person_email", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['email']);
		}else{
			$ctd->set("kg_person_email", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['telephone'])){
			$ctd->set("kg_person_telephone", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['telephone']);
		}else{
			$ctd->set("kg_person_telephone", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['birthDate'])){
			$ctd->set("kg_person_birthDate", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Person']['birthDate']);
		}else{
			$ctd->set("kg_person_birthDate", '');
		}

	/**
	 * knowledge_graph : Organization
	 */

		$tpl_knowledge_graph_organization_option = '';
		foreach ($r4w_define['app']['knowledge_graph']['organization'] as $knowledge_graph_organization_option) {
			$selected = '';
			if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['type']) AND $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['type'] == $knowledge_graph_organization_option['slug']){
				$selected = 'selected="selected"';
			}
			$tpl_knowledge_graph_organization_option .= '<option value="'.$knowledge_graph_organization_option['slug'].'" '.$selected.'>'.$knowledge_graph_organization_option['name'].'</option>';
		}
		$ctd->set("knowledge_graph_organization_option", $tpl_knowledge_graph_organization_option);

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['logo'])){
			$ctd->set("kg_organization_logo", 'style="background-image: url('.$wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['logo'].')"');
		}else{
			$ctd->set("kg_organization_logo", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['image'])){
			$ctd->set("kg_organization_image", 'style="background-image: url('.$wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['image'].')"');
		}else{
			$ctd->set("kg_organization_image", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['name'])){
			$ctd->set("kg_organization_name", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['name']);
		}else{
			$ctd->set("kg_organization_name", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['url'])){
			$ctd->set("kg_organization_url", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['url']);
		}else{
			$ctd->set("kg_organization_url", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['description'])){
			$ctd->set("kg_organization_description", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['description']);
		}else{
			$ctd->set("kg_organization_description", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['address']['streetAddress'])){
			$ctd->set("kg_organization_address_streetAddress", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['address']['streetAddress']);
		}else{
			$ctd->set("kg_organization_address_streetAddress", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['address']['addressLocality'])){
			$ctd->set("kg_organization_address_addressLocality", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['address']['addressLocality']);
		}else{
			$ctd->set("kg_organization_address_addressLocality", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['address']['postalCode'])){
			$ctd->set("kg_organization_address_postalCode", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['address']['postalCode']);
		}else{
			$ctd->set("kg_organization_address_postalCode", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['address']['addressCountry'])){
			$ctd->set("kg_organization_address_addressCountry", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['address']['addressCountry']);
		}else{
			$ctd->set("kg_organization_address_addressCountry", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['geo']['latitude'])){
			$ctd->set("kg_organization_geo_latitude", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['geo']['latitude']);
		}else{
			$ctd->set("kg_organization_geo_latitude", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['geo']['longitude'])){
			$ctd->set("kg_organization_geo_longitude", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['geo']['longitude']);
		}else{
			$ctd->set("kg_organization_geo_longitude", '');
		}

		$tpl_loop_openinghours_output = '';
		$start=strtotime('00:00');
		$end=strtotime('23:45');
		foreach ($r4w_define['app']['dates'] as $slug => $name) {
			$tpl_loop_openinghours = new r4w_template(dirname(__FILE__)."/tab_seo_settings/kg_loop_hours.tpl");
			$tpl_loop_openinghours->set("day_slug", $slug);
			$tpl_loop_openinghours->set("day_name", $name);

			$checked = '';
			$hours_disabled = 'disabled';
			if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['openingHours'][$slug]['checked']) AND $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['openingHours'][$slug]['checked'] == "on"){
				$checked = 'checked="checked"';
				$hours_disabled = '';
			}
			$tpl_loop_openinghours->set("day_checked", $checked);
			$tpl_loop_openinghours->set("hours_disabled", $hours_disabled);

			$hours_open = '';
		    for ($i=$start;$i<=$end;$i = $i + 15*60)
		    {
				$selected = '';
				if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['openingHours'][$slug]['open']) AND $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['openingHours'][$slug]['open'] == date('H:i',$i)){
				$selected = 'selected="selected"';
				}
		    	$hours_open .= '<option value="'.date('H:i',$i).'" '.$selected.'>'.date('H:i',$i).'</option>';
		    }
		    $tpl_loop_openinghours->set("hours_open", $hours_open);

		    $hours_close = '';
		    for ($i=$start;$i<=$end;$i = $i + 15*60)
		    {
				$selected = '';
				if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['openingHours'][$slug]['close']) AND $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['openingHours'][$slug]['close'] == date('H:i',$i)){
				$selected = 'selected="selected"';
				}
		    	$hours_close .= '<option value="'.date('H:i',$i).'" '.$selected.'>'.date('H:i',$i).'</option>';
		    }
		    $tpl_loop_openinghours->set("hours_close", $hours_close);

			$tpl_loop_openinghours_output .= $tpl_loop_openinghours->output();
		}
		$ctd->set("organization_openingHours", $tpl_loop_openinghours_output);

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['contactPoint']['telephone'])){
			$ctd->set("kg_organization_contactPoint_telephone", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['contactPoint']['telephone']);
		}else{
			$ctd->set("kg_organization_contactPoint_telephone", '');
		}


		$tpl_organization_contacPtoint_contacttype = '';
		foreach ($r4w_define['app']['knowledge_graph']['contact_type'] as $contacttype_slug => $contacttype_name) {
			$selected = '';
			if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['contactPoint']['contactType']) AND $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Organization']['contactPoint']['contactType'] == $contacttype_slug){
				$selected = 'selected="selected"';
			}
			$tpl_organization_contacPtoint_contacttype .= '<option value="'.$contacttype_slug.'" '.$selected.'>'.$contacttype_name.'</option>';
		}
		$ctd->set("kg_organization_contacPtoint_contacttype", $tpl_organization_contacPtoint_contacttype);

	/**
	 * knowledge_graph : Product
	 */
		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Product']['brand'])){
			$ctd->set("kg_product_brand", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Product']['brand']);
		}else{
			$ctd->set("kg_product_brand", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Product']['name'])){
			$ctd->set("kg_product_name", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Product']['name']);
		}else{
			$ctd->set("kg_product_name", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Product']['image'])){
			$ctd->set("kg_product_image", 'style="background-image: url('.$wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Product']['image'].')"');
		}else{
			$ctd->set("kg_product_image", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Product']['description'])){
			$ctd->set("kg_product_description", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Product']['description']);
		}else{
			$ctd->set("kg_product_description", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Product']['aggregateRating']['ratingValue'])){
			$ctd->set("kg_product_ratingValue", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Product']['aggregateRating']['ratingValue']);
		}else{
			$ctd->set("kg_product_ratingValue", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Product']['aggregateRating']['reviewCount'])){
			$ctd->set("kg_product_reviewCount", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Product']['aggregateRating']['reviewCount']);
		}else{
			$ctd->set("kg_product_reviewCount", '');
		}

	/**
	 * knowledge_graph : Event
	 */
		$tpl_knowledge_graph_event_option = '';
		foreach ($r4w_define['app']['knowledge_graph']['event'] as $knowledge_graph_event_option) {
			$selected = '';
			if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['type']) AND $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['type'] == $knowledge_graph_event_option['slug']){
				$selected = 'selected="selected"';
			}
			$tpl_knowledge_graph_event_option .= '<option value="'.$knowledge_graph_event_option['slug'].'" '.$selected.'>'.$knowledge_graph_event_option['name'].'</option>';
		}
		$ctd->set("knowledge_graph_event_option", $tpl_knowledge_graph_event_option);

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['name'])){
			$ctd->set("kg_event_name", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['name']);
		}else{
			$ctd->set("kg_event_name", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['url'])){
			$ctd->set("kg_event_url", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['url']);
		}else{
			$ctd->set("kg_event_url", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['description'])){
			$ctd->set("kg_event_description", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['description']);
		}else{
			$ctd->set("kg_event_description", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['location']['name'])){
			$ctd->set("kg_event_location_name", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['location']['name']);
		}else{
			$ctd->set("kg_event_location_name", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['location']['sameAs'])){
			$ctd->set("kg_event_location_sameAs", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['location']['sameAs']);
		}else{
			$ctd->set("kg_event_location_sameAs", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['location']['address']['streetAddress'])){
			$ctd->set("kg_event_address_streetAddress", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['location']['address']['streetAddress']);
		}else{
			$ctd->set("kg_event_address_streetAddress", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['location']['address']['addressLocality'])){
			$ctd->set("kg_event_address_addressLocality", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['location']['address']['addressLocality']);
		}else{
			$ctd->set("kg_event_address_addressLocality", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['location']['address']['postalCode'])){
			$ctd->set("kg_event_address_postalCode", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['location']['address']['postalCode']);
		}else{
			$ctd->set("kg_event_address_postalCode", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['location']['address']['addressCountry'])){
			$ctd->set("kg_event_address_addressCountry", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['location']['address']['addressCountry']);
		}else{
			$ctd->set("kg_event_address_addressCountry", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['offers']['description'])){
			$ctd->set("kg_event_offers_description", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['offers']['description']);
		}else{
			$ctd->set("kg_event_offers_description", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['offers']['url'])){
			$ctd->set("kg_event_offers_url", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['offers']['url']);
		}else{
			$ctd->set("kg_event_offers_url", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['offers']['price'])){
			$ctd->set("kg_event_offers_price", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Event']['offers']['price']);
		}else{
			$ctd->set("kg_event_offers_price", '');
		}

	/**
	 * knowledge_graph : Website
	 */

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Website']['name'])){
			$ctd->set("kg_website_name", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Website']['name']);
		}else{
			$ctd->set("kg_website_name", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Website']['alternateName'])){
			$ctd->set("kg_website_alternatename", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Website']['alternateName']);
		}else{
			$ctd->set("kg_website_alternatename", '');
		}

		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Website']['url'])){
			$ctd->set("kg_website_url", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['Website']['url']);
		}else{
			$ctd->set("kg_website_url", '');
		}

	/**
	 * seo_settings | basic_configuration | knowledge_graph | name
	 */
		if(isset($wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['name'])){
			$ctd->set("home_page_knowledge_name", $wp_setting['seo_settings']['basic_configuration']['knowledge_graph']['name']);
		}else{
			$ctd->set("home_page_knowledge_name", '');
		}

	/**
	 * seo_settings | types_content
	 */
		if(!empty($r4w_define['app']['post_types'])){
			$tpl_loop_type_output = '';
			$tpl_loop_type_li = '';
			foreach ($r4w_define['app']['post_types'] as $post_type) {
				if(array_key_exists($post_type['slug'], get_post_types(array( 'public' => true )))){
					$tpl_loop_type = new r4w_template(dirname(__FILE__)."/tab_seo_settings/loop_type.tpl");

					if(isset($wp_setting['seo_settings']['types_content'][$post_type['slug']]['editing_meta']) AND $wp_setting['seo_settings']['types_content'][$post_type['slug']]['editing_meta'] == 'on'){
						$tpl_loop_type->set("editing_meta", 'checked="checked"');
					}else{
						$tpl_loop_type->set("editing_meta", '');
					}

					if(isset($wp_setting['seo_settings']['types_content'][$post_type['slug']]['index'])){
						if($wp_setting['seo_settings']['types_content'][$post_type['slug']]['index'] == 'on'){
							$tpl_loop_type->set("index", 'checked="checked"');
						}else{
							$tpl_loop_type->set("index", '');
						}
					}else{
						if($wp_options['option_value'] == 1){
							$tpl_loop_type->set("index", 'checked="checked"');
						}else{
							$tpl_loop_type->set("index", '');
						}
					}

					if(isset($wp_setting['seo_settings']['types_content'][$post_type['slug']]['follow']) AND $wp_setting['seo_settings']['types_content'][$post_type['slug']]['follow'] == 'on'){
						$tpl_loop_type->set("follow", 'checked="checked"');
					}else{
						$tpl_loop_type->set("follow", '');
					}
					if(isset($wp_setting['seo_settings']['types_content'][$post_type['slug']]['meta_title'])){
						$meta_title = callback_display_tag($wp_setting['seo_settings']['types_content'][$post_type['slug']]['meta_title']);
						$tpl_loop_type->set("meta_title", $meta_title);
					}else{
						$tpl_loop_type->set("meta_title", '');
					}
					if(isset($wp_setting['seo_settings']['types_content'][$post_type['slug']]['meta_description'])){
						$meta_description = callback_display_tag($wp_setting['seo_settings']['types_content'][$post_type['slug']]['meta_description']);
						$tpl_loop_type->set("meta_description", $meta_description);
					}else{
						$tpl_loop_type->set("meta_description", '');
					}

					/**
					 * Menu
					 */
					$tpl_loop_type_li .= '<li id="subpage_'.$post_type['slug'].'" class="btn_subtab">'.$post_type['name'].'</li>';

					/**
					 * Personnalisation des textes
					 */
					$tpl_loop_type->set("type_slug", $post_type['slug']);
					$tpl_loop_type->set("svg_bullet_info", r4w_assets_svg_code('bullet_info'));
					$tpl_loop_type->set("svg_add_more", r4w_assets_svg_code('add_more'));
					$tpl_loop_type->set("type_txt_remplace_meta", sprintf(__('Replace the meta tag %s','app_rank4win'), $post_type['name']));
					$tpl_loop_type->set("type_txt_edititng_meta", sprintf(__('Allow editing the meta tag in %s','app_rank4win'), $post_type['name']));
					$tpl_loop_type->set("type_text_index", sprintf(__('Allow search engines to index this %s','app_rank4win'), $post_type['name']));
					$tpl_loop_type->set("type_additional_info_index", sprintf(__('This option allows you to ask the search engines to index the %s','app_rank4win'), $post_type['name']));
					$tpl_loop_type->set("type_text_follow", sprintf(__('Allow search engines to follow the links in the %s','app_rank4win'), $post_type['name']));
					$tpl_loop_type->set("type_additionnal_info_follow", sprintf(__('This option allows search engine robots to follow links from the %s','app_rank4win'), $post_type['name']));

					/**
					 * Ajout des data tag
					 */
					$tpl_loop_type->set("tag_data_title", bin2hex(json_encode($r4w_define['app']['tag']['type_contenu']['title'])));
					$tpl_loop_type->set("tag_data_description", bin2hex(json_encode($r4w_define['app']['tag']['type_contenu']['description'])));

					$tpl_loop_type_output .= $tpl_loop_type->output();

				}
			}
			$ctd->set("loop_type_li", $tpl_loop_type_li);
			$ctd->set("loop_type_content", $tpl_loop_type_output);
		}

	/**
	 * seo_settings | taxonomies
	 */
		$taxonomies = get_taxonomies( array( 'public' => true ) );
		$tpl_loop_taxonomy_output = '';
		$tpl_loop_taxonomy_li = '';
		if(!empty($taxonomies)){
		    foreach ($taxonomies as $tax) {

		    	$tpl_loop_taxonomy = new r4w_template(dirname(__FILE__)."/tab_seo_settings/loop_taxonomy.tpl");
		        $tax_obj = get_taxonomy( $tax );

				if(isset($wp_setting['seo_settings']['taxonomies'][$tax_obj->name]['editing_meta']) AND $wp_setting['seo_settings']['taxonomies'][$tax_obj->name]['editing_meta'] == 'on'){
					$tpl_loop_taxonomy->set("editing_meta", 'checked="checked"');
				}else{
					$tpl_loop_taxonomy->set("editing_meta", '');
				}
				if(isset($wp_setting['seo_settings']['taxonomies'][$tax_obj->name]['index']) AND $wp_setting['seo_settings']['taxonomies'][$tax_obj->name]['index'] == 'on'){
					$tpl_loop_taxonomy->set("index", 'checked="checked"');
				}else{
					$tpl_loop_taxonomy->set("index", '');
				}
				if(isset($wp_setting['seo_settings']['taxonomies'][$tax_obj->name]['follow']) AND $wp_setting['seo_settings']['taxonomies'][$tax_obj->name]['follow'] == 'on'){
					$tpl_loop_taxonomy->set("follow", 'checked="checked"');
				}else{
					$tpl_loop_taxonomy->set("follow", '');
				}
				if(isset($wp_setting['seo_settings']['taxonomies'][$tax_obj->name]['meta_title'])){
					$meta_title = callback_display_tag($wp_setting['seo_settings']['taxonomies'][$tax_obj->name]['meta_title']);
					$tpl_loop_taxonomy->set("meta_title", $meta_title);
				}else{
					$tpl_loop_taxonomy->set("meta_title", '');
				}
				if(isset($wp_setting['seo_settings']['taxonomies'][$tax_obj->name]['meta_description'])){
					$meta_description = callback_display_tag($wp_setting['seo_settings']['taxonomies'][$tax_obj->name]['meta_description']);
					$tpl_loop_taxonomy->set("meta_description", $meta_description);
				}else{
					$tpl_loop_taxonomy->set("meta_description", '');
				}

				/**
				 * Personnalisation des textes
				 */
		        $tpl_loop_taxonomy->set("taxonomy_slug", $tax_obj->name);
		        $tpl_loop_taxonomy->set("taxonomy_name", $tax_obj->labels->name);
				$tpl_loop_taxonomy->set("svg_bullet_info", r4w_assets_svg_code('bullet_info'));
				$tpl_loop_taxonomy->set("svg_add_more", r4w_assets_svg_code('add_more'));
				$tpl_loop_taxonomy->set("taxonomy_txt_remplace_meta", sprintf(__('Replace the meta tag %s','app_rank4win'), $tax_obj->labels->name));
				$tpl_loop_taxonomy->set("taxonomy_txt_editing_meta", sprintf(__('Allow editing the meta tag in %s','app_rank4win'), $tax_obj->labels->name));
				$tpl_loop_taxonomy->set("taxonomy_text_index", sprintf(__('Allow search engines to index this %s','app_rank4win'), $tax_obj->labels->name));
				$tpl_loop_taxonomy->set("taxonomy_additional_info_index", sprintf(__('This option allows you to ask the search engines to index the %s','app_rank4win'), $tax_obj->labels->name));
				$tpl_loop_taxonomy->set("taxonomy_text_follow", sprintf(__('Allow search engines to follow the links in the %s','app_rank4win'), $tax_obj->labels->name));
				$tpl_loop_taxonomy->set("taxonomy_additionnal_info_follow", sprintf(__('This option allows search engine robots to follow links from the %s','app_rank4win'), $tax_obj->labels->name));
				/**
				 * Ajout des data tag
				 */
				$define_tag_title = $r4w_define['app']['tag']['taxonomy']['title'];
				$add_tag_title = [
					[
						"name" => sprintf(__('Name of %s','app_rank4win'), $tax_obj->labels->name),
						"tag" => "term_name"
					]
				];
				if($tax_obj->name == 'category'){
					$add_category = [
						[
							"name" => __('Parent category', 'app_rank4win'),
							"tag" => "term_cat_parent"
						]
					];
					$add_tag_title = array_merge($add_tag_title, $add_category );
				}
				$tpl_loop_taxonomy->set("tag_data_title", bin2hex(json_encode(array_merge($add_tag_title,$define_tag_title))));
				$define_tag_description = $r4w_define['app']['tag']['taxonomy']['description'];
				$add_tag_description = [
					[
						"name" => sprintf(__('Description of %s','app_rank4win'), $tax_obj->labels->name),
						"tag" => "term_description"
					]
				];
				$tpl_loop_taxonomy->set("tag_data_description", bin2hex(json_encode(array_merge($add_tag_description,$define_tag_description))));
		        $tpl_loop_taxonomy_output .= $tpl_loop_taxonomy->output();

				/**
				 * Menu
				 */
				$tpl_loop_taxonomy_li .= '<li id="subpage_'.$tax_obj->name.'" class="btn_subtab">'.$tax_obj->labels->name.'</li>';
			}
		}
		$ctd->set("loop_taxonomy_li", $tpl_loop_taxonomy_li);
		$ctd->set("loop_taxonomy_content", $tpl_loop_taxonomy_output);

	/**
	 * seo_settings | archive
	 */
		if(isset($wp_setting['seo_settings']['archive']['author_archives']['display']) AND $wp_setting['seo_settings']['archive']['author_archives']['display'] == 'on'){

			$ctd->set("author_archives_box_contenteditable", '');
			$ctd->set("author_archives_metatag", 'athow_content');
			$ctd->set("author_archives_contenteditable", 'true');
			$ctd->set("author_archives_display", 'checked="checked"');

			$checked = '';
			if(isset($wp_setting['seo_settings']['archive']['author_archives']['index_have_post']) AND $wp_setting['seo_settings']['archive']['author_archives']['index_have_post'] == 'on'){
				$checked = 'checked="checked"';
			}
			$ctd->set("author_archives_index_have_post", $checked);

			$checked = '';
			if(isset($wp_setting['seo_settings']['archive']['author_archives']['follow_have_post']) AND $wp_setting['seo_settings']['archive']['author_archives']['follow_have_post'] == 'on'){
				$checked = 'checked="checked"';
			}
			$ctd->set("author_archives_follow_have_post", $checked);

			$checked = '';
			if(isset($wp_setting['seo_settings']['archive']['author_archives']['index_no_post']) AND $wp_setting['seo_settings']['archive']['author_archives']['index_no_post'] == 'on'){
				$checked = 'checked="checked"';
			}
			$ctd->set("author_archives_index_no_post", $checked);

			$checked = '';
			if(isset($wp_setting['seo_settings']['archive']['author_archives']['follow_no_post']) AND $wp_setting['seo_settings']['archive']['author_archives']['follow_no_post'] == 'on'){
				$checked = 'checked="checked"';
			}
			$ctd->set("author_archives_follow_no_post", $checked);

			if(isset($wp_setting['seo_settings']['archive']['author_archives']['meta_title'])){
				$meta_title = callback_display_tag($wp_setting['seo_settings']['archive']['author_archives']['meta_title']);
				$ctd->set("author_archives_meta_title", $meta_title);
			}else{
				$ctd->set("author_archives_meta_title", '');
			}
			if(isset($wp_setting['seo_settings']['archive']['author_archives']['meta_description'])){
				$meta_description = callback_display_tag($wp_setting['seo_settings']['archive']['author_archives']['meta_description']);
				$ctd->set("author_archives_meta_description", $meta_description);
			}else{
				$ctd->set("author_archives_meta_description", '');
			}
		}else{
			$ctd->set("author_archives_display", '');
			$ctd->set("author_archives_index_have_post", 'disabled="disabled"');
			$ctd->set("author_archives_follow_have_post", 'disabled="disabled"');
			$ctd->set("author_archives_index_no_post", 'disabled="disabled"');
			$ctd->set("author_archives_follow_no_post", 'disabled="disabled"');
			$ctd->set("author_archives_metatag", 'athow_disabled');
			$ctd->set("author_archives_box_contenteditable", 'content_disabled');
			$ctd->set("author_archives_contenteditable", 'false');
			$ctd->set("author_archives_meta_title", '');
			$ctd->set("author_archives_meta_description", '');
		}

		if(isset($wp_setting['seo_settings']['archive']['date_archives']['display']) AND $wp_setting['seo_settings']['archive']['date_archives']['display'] == 'on'){

			$ctd->set("date_archives_box_contenteditable", '');
			$ctd->set("date_archives_metatag", 'athow_content');
			$ctd->set("date_archives_contenteditable", 'true');
			$ctd->set("date_archives_display", 'checked="checked"');

			$checked = '';
			if(isset($wp_setting['seo_settings']['archive']['date_archives']['index']) AND $wp_setting['seo_settings']['archive']['date_archives']['index'] == 'on'){
				$checked = 'checked="checked"';
			}
			$ctd->set("date_archives_index", $checked);

			$checked = '';
			if(isset($wp_setting['seo_settings']['archive']['date_archives']['follow']) AND $wp_setting['seo_settings']['archive']['date_archives']['follow'] == 'on'){
				$checked = 'checked="checked"';
			}
			$ctd->set("date_archives_follow", $checked);

			if(isset($wp_setting['seo_settings']['archive']['date_archives']['meta_title'])){
				$meta_title = callback_display_tag($wp_setting['seo_settings']['archive']['date_archives']['meta_title']);
				$ctd->set("date_archives_meta_title", $meta_title);
			}else{
				$ctd->set("date_archives_meta_title", '');
			}
			if(isset($wp_setting['seo_settings']['archive']['date_archives']['meta_description'])){
				$meta_description = callback_display_tag($wp_setting['seo_settings']['archive']['date_archives']['meta_description']);
				$ctd->set("date_archives_meta_description", $meta_description);
			}else{
				$ctd->set("date_archives_meta_description", '');
			}
		}else{
			$ctd->set("date_archives_display", '');
			$ctd->set("date_archives_index", 'disabled="disabled"');
			$ctd->set("date_archives_follow", 'disabled="disabled"');
			$ctd->set("date_archives_metatag", 'athow_disabled');
			$ctd->set("date_archives_box_contenteditable", 'content_disabled');
			$ctd->set("date_archives_contenteditable", 'false');
			$ctd->set("date_archives_meta_title", '');
			$ctd->set("date_archives_meta_description", '');
		}

	/**
	 * seo_settings | special_page
	 */
		/**
		 * seo_settings | special_page | search
		 */
			$checked = '';
			if(isset($wp_setting['seo_settings']['special_page']['search']['replace_meta']) AND $wp_setting['seo_settings']['special_page']['search']['replace_meta'] == 'on'){
				$checked = 'checked="checked"';
			}
			$ctd->set("search_replace_meta", $checked);

			if(isset($wp_setting['seo_settings']['special_page']['search']['meta_title'])){
				$meta_title = callback_display_tag($wp_setting['seo_settings']['special_page']['search']['meta_title']);
				$ctd->set("search_meta_title", $meta_title);
			}else{
				$ctd->set("search_meta_title", '');
			}

		/**
		 * seo_settings | special_page | error_404
		 */
			$checked = '';
			if(isset($wp_setting['seo_settings']['special_page']['error_404']['replace_meta']) AND $wp_setting['seo_settings']['special_page']['error_404']['replace_meta'] == 'on'){
				$checked = 'checked="checked"';
			}
			$ctd->set("error_404_replace_meta", $checked);

			if(isset($wp_setting['seo_settings']['special_page']['error_404']['meta_title'])){
				$meta_title = callback_display_tag($wp_setting['seo_settings']['special_page']['error_404']['meta_title']);
				$ctd->set("error_404_meta_title", $meta_title);
			}else{
				$ctd->set("error_404_meta_title", '');
			}

	/**
	 * seo_settings | rss_feed
	 */
		/**
		 * seo_settings | rss_feed | content_before
		 */
			if(isset($wp_setting['seo_settings']['rss_feed']['content_before'])){
				$content_before = callback_display_tag($wp_setting['seo_settings']['rss_feed']['content_before']);
				$ctd->set("rss_feed_content_before", $content_before);
			}else{
				$ctd->set("rss_feed_content_before", '');
			}

		/**
		 * seo_settings | rss_feed | content_after
		 */
			if(isset($wp_setting['seo_settings']['rss_feed']['content_after'])){
				$content_after = callback_display_tag($wp_setting['seo_settings']['rss_feed']['content_after']);
				$ctd->set("rss_feed_content_after", $content_after);
			}else{
				$ctd->set("rss_feed_content_after", '');
			}

	/**
	 * social_networks | facebook
	 */
		$checked = '';
		if(isset($wp_setting['social_networks']['facebook']['editing_meta']) AND $wp_setting['social_networks']['facebook']['editing_meta'] == 'on'){
			$checked = 'checked="checked"';
		}
		$ctd->set("facebook_editing_meta", $checked);

		/**
		 * social_networks | facebook | url_page
		 */
			if(isset($wp_setting['social_networks']['facebook']['url_page'])){
				$ctd->set("facebook_url_page", $wp_setting['social_networks']['facebook']['url_page']);
			}else{
				$ctd->set("facebook_url_page", '');
			}

		/**
		 * social_networks | facebook | app_id
		 */
			if(isset($wp_setting['social_networks']['facebook']['app_id'])){
				$ctd->set("facebook_app_id", $wp_setting['social_networks']['facebook']['app_id']);
			}else{
				$ctd->set("facebook_app_id", '');
			}

	/**
	 * social_networks | twitter
	 */
		$checked = '';
		if(isset($wp_setting['social_networks']['twitter']['editing_meta']) AND $wp_setting['social_networks']['twitter']['editing_meta'] == 'on'){
			$checked = 'checked="checked"';
		}
		$ctd->set("twitter_editing_meta", $checked);

		/**
		 * social_networks | twitter | card_type
		 */
			$tpl_twitter_option = '';
			foreach ($r4w_define['app']['twitter_card'] as $twitter_option) {
				/**
				 * Vérifie si la langue est selectioner dans les paramètres
				 */
				$selected = '';
				if(isset($wp_setting['social_networks']['twitter']['card_type']) AND $wp_setting['social_networks']['twitter']['card_type'] == $twitter_option['slug']){
					$selected = 'selected="selected"';
				}
				$tpl_twitter_option .= '<option value="'.$twitter_option['slug'].'" '.$selected.'>'.$twitter_option['name'].'</option>';
			}
			$ctd->set("twitter_option", $tpl_twitter_option);

		/**
		 * social_networks | twitter | username
		 */
			if(isset($wp_setting['social_networks']['twitter']['username'])){
				$ctd->set("twitter_username", $wp_setting['social_networks']['twitter']['username']);
			}else{
				$ctd->set("twitter_username", '');
			}

	/**
	 * social_networks | pinterest
	 */

		/**
		 * social_networks | pinterest | url_page
		 */
			if(isset($wp_setting['social_networks']['pinterest']['url_page'])){
				$ctd->set("pinterest_url_page", $wp_setting['social_networks']['pinterest']['url_page']);
			}else{
				$ctd->set("pinterest_url_page", '');
			}

		/**
		 * social_networks | pinterest | verification_code
		 */
			if(isset($wp_setting['social_networks']['pinterest']['verification_code'])){
				$ctd->set("pinterest_verification_code", $wp_setting['social_networks']['pinterest']['verification_code']);
			}else{
				$ctd->set("pinterest_verification_code", '');
			}

	/**
	 * tools | file_editor | import / export
	 */
 		if($curl_feature['resp']['success']['features']['tools_exportimport'] == "true"){
 			$ctd->set("rs_importexport_txt", "");
			$ctd->set("tools_export_btn", '<div id="loading"><div class="dual-ring"></div></div><div><button id="task_export" type="submit" class="btn_setting_save btn_expimp">'.__('Download the configuration file', 'app_rank4win').'</button></div>');
			$ctd->set("tools_import_btn", '<div id="loading"><div class="dual-ring"></div></div> <div> <button id="task_import" type="submit" class="btn_setting_save btn_expimp">'.__('Import the configuration file', 'app_rank4win').'</button> </div>');
			$ctd->set("tools_import_input", '<div class="input-field s12"> <div class="file-field input-field"> <div class="btn css-gef8808ef"> <span class="css-f5hyr0ee">'.__('File', 'app_rank4win').'</span> <input id="r4w_import_config" type="file"> </div> <div class="file-path-wrapper"> <input class="file-path validate" type="text" placeholder="'.__('Configuration file','app_rank4win').'"> </div> </div> </div>');
 		}else{
 			$ctd->set("rs_importexport_txt", $r4w_define['app']['requires_sub']['msg']);
 			$ctd->set("tools_export_btn", '');
 			$ctd->set("tools_import_btn", '');
 			$ctd->set("tools_import_input", '');
 		}

		/**
		 * tools | file_editor | htaccess
		 */
		if($curl_feature['resp']['success']['features']['tools_fileditor'] == "true"){
			$htaccess_path = ABSPATH . '.htaccess';
			$htaccess_file_cont = '';
			if( file_exists( $htaccess_path ) ){
				$htaccess_file_cont = file_get_contents( $htaccess_path );
			}
			$ctd->set("rs_file_editor_htaccess_txt", '');
			 $ctd->set("tools_file_editor_htaccess_walring", '<div class="css-warning_reset"> <div class="css-d5f0ef50ef">'.r4w_assets_svg_code('warning').'</div> <div class="css-df5pzek20">'.__('Be careful when editing this file. These changes may prevent your wordpress, your themes or plugin from working properly. Make these changes only if you are safe without causing problems').'.</div> </div>');
 			$ctd->set("tools_file_editor_htaccess_btn", '<div id="loading"><div class="dual-ring"></div></div> <div> <button id="editor_htaccess" type="submit" class="btn_setting_save btn_editor">'.__('Save', 'app_rank4win').'</button> </div>');
 			$ctd->set("tools_file_editor_htaccess_input", '<div class="r4w_textaera_box select-field"> <label for="bac_spp_pse_title">'.__('File content', 'app_rank4win').'</label> <textarea>'.$htaccess_file_cont.'</textarea> </div>');
		}else{
 			$ctd->set("rs_file_editor_htaccess_txt", $r4w_define['app']['requires_sub']['msg']);
 			$ctd->set("tools_file_editor_htaccess_walring", '');
 			$ctd->set("tools_file_editor_htaccess_btn", '');
 			$ctd->set("tools_file_editor_htaccess_input", '');
		}

		/**
		 * tools | file_editor | robots
		 */
		if($curl_feature['resp']['success']['features']['tools_fileditor'] == "true"){
			$robots_path 	= ABSPATH . 'robots.txt';
			$robots_file_cont 	= '';
			if( file_exists( $robots_path ) ){
				$robots_file_cont = file_get_contents( $robots_path );
		    }
 			$ctd->set("rs_file_editor_robots_txt", '');
 			$ctd->set("tools_file_editor_robots_btn", '<div id="loading"><div class="dual-ring"></div></div> <div> <button id="editor_robots" type="submit" class="btn_setting_save btn_editor">'.__('Save','app_rank4win').'</button> </div>');
 			$ctd->set("tools_file_editor_robots_input", '<div class="r4w_textaera_box select-field"> <label for="bac_spp_pse_title">'.__('File content', 'app_rank4win').'</label> <textarea>'.$robots_file_cont.'</textarea> </div>');
		}else{
 			$ctd->set("rs_file_editor_robots_txt", $r4w_define['app']['requires_sub']['msg']);
 			$ctd->set("tools_file_editor_robots_btn", '');
 			$ctd->set("tools_file_editor_robots_input", '');
		}
