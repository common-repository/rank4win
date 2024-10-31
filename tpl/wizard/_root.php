<?php
	global $wpdb;
	$wp_table_option = $wpdb->prefix.'options';
	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

	$wp_select = "SELECT * from ".$wp_table_app;
     $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

 	$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_option} WHERE option_name = %s",'blog_public');
 	$wp_options = $wpdb->get_row($wp_select,ARRAY_A);

     if(!empty($r4w_app['settings']) AND ctype_xdigit($r4w_app['settings'])){
 		$wp_setting = json_decode(hex2bin($r4w_app['settings']),true);
 	}
	if(!empty($r4w_app['wizard']) AND ctype_xdigit($r4w_app['wizard'])){
		$step_wizard = json_decode(hex2bin($r4w_app['wizard']),true);
	}

	$tpl_step = new r4w_template(dirname(__FILE__)."/step.tpl");
	$tpl_button = new r4w_template(dirname(__FILE__)."/button.tpl");
	$tpl_step_required = new r4w_template(dirname(__FILE__)."/step/required.tpl");
	$tpl_step_setting = new r4w_template(dirname(__FILE__)."/step/setting.tpl");

	$ctd->set( "step_screen", $tpl_step->output() );
	$ctd->set( "step_button", $tpl_button->output() );
	$ctd->set( "cancel",admin_url() );
	$ctd->set("next_step", admin_url( 'admin.php?page=r4w_settings' ));
	function r4w_step_menu($a){
		$menus = [
			[
				"title" => __( 'Identification', 'app_rank4win' ),
				"description" => __( 'You need an account to use rank4win login or create an account', 'app_rank4win' ),
			],
			[
				"title" => __( 'System requirements', 'app_rank4win' ),
				"description" => __( 'Lets check if your wordpress is compatible to run rank4win', 'app_rank4win' ),
			],
			[
				"title" => __( 'Settings', 'app_rank4win' ),
				"description" => __( 'Set up your site and rank4win options', 'app_rank4win' ),
			],
		];
		$i = 1;
		$tpl_menu = '';
		foreach ($menus as $menu) {
			$tpl_step_menu = new r4w_template(dirname(__FILE__)."/menu.tpl");
			$tpl_step_menu->set("menu_step", '<div class="css-d5d50sqdd">'.$i.'</div>');
			$tpl_step_menu->set("menu_class", '');
			if($a > $i){
				$tpl_step_menu->set("menu_step", r4w_assets_svg_code('check'));
				$tpl_step_menu->set("menu_class", 'class="complete"');
			}
			if($a == $i){
				$tpl_step_menu->set("menu_class", 'class="active"');
			}
			$tpl_step_menu->set("menu_title", $menu['title']);
			$tpl_step_menu->set("menu_description", $menu['description']);
			$i++;
			$tpl_menu .= $tpl_step_menu->output();
		}
		return $tpl_menu;
	}
	if(!isset($_GET['step'])){
		$_GET['step'] = '';
	}


	if(!empty($step_wizard['step']) AND !empty($_GET['step'])){
		if($_GET['step'] != md5($step_wizard['step'])){

		}
	}

	switch ($_GET['step']) {
		case 'c81e728d9d4c2f636f067f89cc14862c':
			$step = 2;
			$next = 3;
			break;
		case 'eccbc87e4b5ce2fe28308fd9f2a7baf3':
			$step = 3;
			$next = null;
			break;
		default:
			$step = 1;
			$next = 2;
			break;
	}

	switch ($step) {
		case 1:
			$ctd->set( "step_menu", r4w_step_menu(1) );
			$ctd->set( "step_content", __('Identification in progress, please wait...','app_rank4win' ));

			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/account/",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl_auth = r4w_curl_request($curl_data);

			if(empty($curl_auth['resp']['success'])){
				wp_redirect(get_admin_url('','admin.php?page=r4w_auth_login'));
				exit;
			}else{
				wp_redirect(get_admin_url('','admin.php?page=r4w_wizard&step='.md5(2)));
				exit;
			}
			break;
		case 2:
			if(!empty( $step_wizard['step'] )){
				if($step_wizard['step'] > $step){
					wp_redirect(get_admin_url('','admin.php?page=r4w_wizard&step='.md5($step_wizard['step'])));
					exit;
				}
			}
			$start_wizard = bin2hex(json_encode([
				"step" => 2
			]));
			$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET wizard = %s WHERE id = %d", $start_wizard, 1));

			$ctd->set("step_menu", r4w_step_menu(2));
			$ctd->set("step_content", $tpl_step_required->output());
			if(!empty($next)){
				$ctd->set("next_step", admin_url( 'admin.php?page=r4w_wizard&step='.md5($next) ));
			}

		  	$version_php = "failed";
		 	$version_wp = "failed";
		 	$domain_dns = "failed";
		 	$domain_txt = __( 'No', 'app_rank4win' );
			$https_domain = "failed";
			$https_domain_txt = __( 'No', 'app_rank4win' );
			$curl_data = [
				"request_method" => "GET",
				"url" => "/wp/required/",
				"auth" => "true",
				"postfileds" => [
					"json_encode" => true,
					"data" => null
				]
			];
			$curl = r4w_curl_request($curl_data);
			if($curl['resp']['success']){
				$required = $curl['resp']['success']['required'];
			}
			if(phpversion() >= $required['php']){
				$version_php = "good";
			}
			$ctd->set("version_php_result", $required['php'].' '.__( 'or higher', 'app_rank4win' ));
			$ctd->set("version_php_color", $version_php);

			if( get_bloginfo('version') >= $required['wordpress']){
				$version_wp = "good";
			}
			$ctd->set("version_wp_result", $required['wordpress'].' '.__( 'or higher', 'app_rank4win' ));
			$ctd->set("version_wp_color", $version_wp);

			if(r4w_get_version() >= $required['rank4win']){
				$version_r4w = "good";
			}
			$ctd->set("version_r4w_result", $required['rank4win']);
			$ctd->set("version_r4w_color", $version_r4w);

			if($required['dns'] == true){
				$domain_dns = "good";
				$domain_txt = __( 'Yes', 'app_rank4win' );
			}
			$ctd->set("domain_result", $domain_txt);
			$ctd->set("domain_color", $domain_dns);

			if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'){
				$https_domain = "good";
				$https_domain_txt = __( 'Yes', 'app_rank4win' );
			}
			$ctd->set("https_result", $https_domain_txt);
			$ctd->set("https_color", $https_domain);

			if($version_php == 'good' AND $version_wp == 'good' AND $version_r4w == 'good' AND $domain_dns == 'good'){
				$ctd->set("result_config", '<div class="css-5d0df5e"> <div class="css-f5r0hg8tnht">'.__( 'Congratulations, your configuration allows you to use rank4win correctly. You can move on to the next step', 'app_rank4win' ).'. </div> </div>');
				$ctd->set("btn_next_step", 'active');
			}else{
				$ctd->set("result_config", '<div class="css-5d0df5e"> <div class="css-5ef0erg5hry">'.__( 'Your configuration does not allow you to use rank4win, to continue you must upgrade your configuration','app_rank4win' ).'. </div> </div>');
				$ctd->set("btn_next_step", '');
			}
			break;
		case 3:
			if(!empty( $step_wizard['step'] )){
				if($step_wizard['step'] > $step){
					wp_redirect(get_admin_url('','admin.php?page=r4w_wizard&step='.md5($step_wizard['step'])));
					exit;
				}
			}
			$start_wizard = bin2hex(json_encode([
				"step" => 3
			]));
			$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET wizard = %s WHERE id = %d", $start_wizard, 1));

			$ctd->set("step_menu", r4w_step_menu(3));
			$ctd->set("step_content", $tpl_step_setting->output());
			if(!empty($next)){
				$ctd->set("next_step", admin_url( 'admin.php?page=r4w_wizard&step='.md5($next) ));
			}else{
				$start_wizard = bin2hex(json_encode([
					"step" => 'finish'
				]));
				$wpdb->query( $wpdb->prepare( "UPDATE $wp_table_app SET wizard = %s WHERE id = %d", $start_wizard, 1));
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
			if($curl_settings['resp']['success']['synchronization']['status'] == false){
				$ctd->set("javascript_modal", '<script type="text/javascript">jQuery(document).ready(function(){jQuery("#r4w_box-cloud").modal();});</script>');

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

			if(!empty($curl_settings['resp']['success']['locale'])){
				$tpl_option_language = '';
				foreach ($curl_settings['resp']['success']['locale'] as $locale) {
					$selected = '';
					if(isset($wp_setting['general_setting']['language']) AND $wp_setting['general_setting']['language'] == $locale['uuid']){
						$selected = 'selected="selected"';
					}
					$tpl_option_language .= '<option value="'.$locale['uuid'].'" '.$selected.'>'.$locale['name'].'</option>';
				}
				$ctd->set("list_language", $tpl_option_language);
			}
			$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_option} WHERE option_name = %s",'blog_public');
			$wp_options = $wpdb->get_row($wp_select,ARRAY_A);

			$checked = '';
			if($wp_options['option_value'] == 1){
				$checked = 'checked="checked"';
			}
			$ctd->set("seo_settings_noindex", $checked);

			$ctd->set("btn_next_step", 'active');
			break;
	}
