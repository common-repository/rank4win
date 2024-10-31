<?php
	global $wpdb;

	r4w_wizard();

	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
	$wp_select = "SELECT * from ".$wp_table_app;
	$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
	if(!empty($r4w_app['settings'])){
		$r4w_settings =  json_decode(hex2bin($r4w_app['settings']),true);
	}
	if(!isset($r4w_settings['general_setting']['language'])){
		header('location:'.admin_url( 'admin.php?page=r4w_settings'));
	}

	/**
	 * Recupère les dépendances du template
	 */
	$tpl_keyword_main = new r4w_template(dirname(__FILE__)."/keyword_main.tpl");
	$tpl_keyword_secondary = new r4w_template(dirname(__FILE__)."/keyword_secondary.tpl");
	$tpl_editor = new r4w_template(dirname(__FILE__)."/str_editor.tpl");


	$ctd->set("str_editor", $tpl_editor->output());
	$ctd->set("editor_diagram", $_GET['diagram']);
	$ctd->set("wp_admin_url_page", admin_url( 'post.php?post=' ));
	$ctd->set("editor_leave", admin_url( 'admin.php?page=r4w_tools' ));
	$ctd->set("url_adm_page", admin_url( 'edit.php?post_type=page' ));
	$ctd->set("url_subscription", admin_url( 'admin.php?page=r4w_subscription' ));
	$ctd->set("url_associate", admin_url( 'admin.php?page=r4w_account&tab=wordpress' ));

	$users = get_users( array( 'fields' => array( 'ID','display_name','user_nicename' ) ) );
	$list_select_author = '<option value="0">'.__('By default','app_rank4win').'</option>';

	foreach($users as $user){
		$select = '';
		$list_select_author .= '<option value="'.$user->ID.'" '.$select.'>'.$user->display_name.'</option>';
	}

    $ctd->set("list_select_author", $list_select_author);

    $tpl_keyword_main->set("r4w_locale", $r4w_settings['general_setting']['language']);
    $ctd->set("box_km", $tpl_keyword_main->output());
    $ctd->set("box_ks", $tpl_keyword_secondary->output());