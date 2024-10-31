<?php

	global $wpdb;
	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
	$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

	$wp_select = "SELECT * from ".$wp_table_app;
	$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

	$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$tpl_data['post_id']);
	$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);

	/**
	 * Affiche le nombre de liens interne sortant
	 */
		$link_outgoing = 0;
		if(!empty($r4w_document['links'])){
			$link_outgoing = count(json_decode(hex2bin($r4w_document['links']),true));
		}
		$ctd->set("nbr_link_outgoing", '<div class="css-f5e0fdf5e">'.r4w_assets_svg_code('link_outgoing').'</div><div class="css-sdf5e0r">'.$link_outgoing.'</div>');
		
	/**
	 * Affiche le nombre de liens interne entrent
	 */
		$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id != %d",$tpl_data['post_id']);
		$r4w_documents = $wpdb->get_results($wp_select,ARRAY_A);
		$link_inbound = 0;
		foreach ($r4w_documents as $document) {
			if(!empty($document['links'])){
				$link_array = array_count_values(json_decode(hex2bin($document['links']),true));
				if(isset($link_array[$tpl_data['post_id']])){
					$link_inbound += $link_array[$tpl_data['post_id']];
				}
			}
		}
		$ctd->set("nbr_link_inbound", '<div class="css-f5e0fdf5e">'.r4w_assets_svg_code('link_inbound').'</div><div class="css-sdf5e0r">'.$link_inbound.'</div>');