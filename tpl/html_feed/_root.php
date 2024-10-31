<?php
	global $wpdb;
	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;

    $wp_select = "SELECT * from ".$wp_table_app;
    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

	if(!empty($r4w_app['settings'])){
    	$GLOBALS['r4w_settings'] =  json_decode(hex2bin($r4w_app['settings']),true);
    	global $r4w_settings;
    }

	if ( is_feed() ) {
		$content = $tpl_data["content"];
		if(!empty($r4w_settings['seo_settings']['rss_feed']['content_before'])){

			$before_content = nl2br( r4w_callback_tag( $r4w_settings['seo_settings']['rss_feed']['content_before'] ) );
			$content = '<p>' . $before_content . '</p>' . $content;
		}
		if(!empty($r4w_settings['seo_settings']['rss_feed']['content_after'])){
			$after_content = nl2br( r4w_callback_tag( $r4w_settings['seo_settings']['rss_feed']['content_after'] ) );
			$content = $content . '<p>' . $after_content . '</p>';
		}
	}

	$ctd->set("feed", $content);