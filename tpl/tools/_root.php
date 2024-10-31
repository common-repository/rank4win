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

	$tpl_tab_strategy = new r4w_template(dirname(__FILE__)."/tab_strategy/contained.tpl");
	$ctd->set("tab_strategy", $tpl_tab_strategy->output());

	$tpl_tab_strategy_list = new r4w_template(dirname(__FILE__)."/tab_strategy/list.tpl");
	$ctd->set("tab_strategy_list", $tpl_tab_strategy_list->output());

	$tpl_tab_strategy_select = new r4w_template(dirname(__FILE__)."/tab_strategy/select.tpl");
	$ctd->set("tab_strategy_select", $tpl_tab_strategy_select->output());

	$tpl_tab_str_semantic = new r4w_template(dirname(__FILE__)."/tab_str_semantic/contained.tpl");
	$ctd->set("tab_str_semantic", $tpl_tab_str_semantic->output());

	$tpl_tab_str_preview = new r4w_template(dirname(__FILE__)."/tab_str_preview/contained.tpl");
	$ctd->set("tab_str_preview", $tpl_tab_str_preview->output());	

	$tpl_tab_str_semantic_list = new r4w_template(dirname(__FILE__)."/tab_str_semantic/list.tpl");
	$ctd->set("tab_str_semantic_list", $tpl_tab_str_semantic_list->output());

	$tpl_tab_strategy_editor = new r4w_template(dirname(__FILE__)."/tab_str_semantic/editor.tpl");
	$ctd->set("tab_str_semantic_editor", $tpl_tab_strategy_editor->output());

	$tpl_tab_deploy = new r4w_template(dirname(__FILE__)."/tab_deploy/contained.tpl");
	$ctd->set("tab_deploy", $tpl_tab_deploy->output());

	$tpl_tab_list_deploy = new r4w_template(dirname(__FILE__)."/tab_deploy/list.tpl");
	$ctd->set("tab_list_deploy", $tpl_tab_list_deploy->output());

	$ctd->set("url_adm_page", admin_url( 'edit.php?post_type=page' ));
	$ctd->set("url_subscription", admin_url( 'admin.php?page=r4w_subscription' ));
	$ctd->set("url_associate", admin_url( 'admin.php?page=r4w_account&tab=wordpress' ));

	$tab_open_forced = '';
	if(!empty($_GET['tab'])){
		$tab_open_forced = 'tab-open="'.$_GET['tab'].'"';
	}
	$ctd->set("tab_open", $tab_open_forced);

	if(!empty($_GET['tab']) AND !empty($_GET['diagram']) AND $_GET['tab'] == 'deploy'){
		$ctd->set("r4w_javascript", '<script type="text/javascript">jQuery(document).ready(function(){ r4w_deploy_semantic(\''.hex2bin($_GET['diagram']).'\'); })</script>');
	}else{
		$ctd->set("r4w_javascript", '');
	}