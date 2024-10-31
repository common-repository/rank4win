<?php
	global $wpdb, $r4w_define, $r4w_version;
	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
	$wp_table_option = $wpdb->prefix.'options';
	
	r4w_wizard();

	$wp_select = "SELECT * from ".$wp_table_app;
	$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

	$tpl_tab_account = new r4w_template(dirname(__FILE__)."/tab_account/contained.tpl");
	$ctd->set("tab_account", $tpl_tab_account->output());

	$tpl_tab_wordpress = new r4w_template(dirname(__FILE__)."/tab_wordpress/contained.tpl");
	$ctd->set("tab_wordpress", $tpl_tab_wordpress->output());

	$tpl_tab_invoice = new r4w_template(dirname(__FILE__)."/tab_invoice/contained.tpl");
	$ctd->set("tab_invoice", $tpl_tab_invoice->output());

	$ctd->set("url_another_account", admin_url( 'admin.php?page=r4w_auth_login' ));
	$ctd->set("url_subscription", admin_url( 'admin.php?page=r4w_subscription' ));

	$tab_open_forced = '';
	if(!empty($_GET['tab'])){
		$tab_open_forced = 'tab-open="'.$_GET['tab'].'"';
	}
	$ctd->set("tab_open", $tab_open_forced);