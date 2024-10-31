<?php 
	global $wpdb;
	$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

	$post_id = get_the_ID();

    $wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$post_id);
	$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);

	$ctd->set("document_uuid", $r4w_document['uuid']);