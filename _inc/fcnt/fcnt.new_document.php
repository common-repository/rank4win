<?php
    if ( ! function_exists( 'r4w_new_document' ) ) {
		/**
		 * Création d'un nouveau document
		 */ 
		function r4w_new_document( $wp_type, $wp_id ){
			global $wpdb;
			$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
			$wp_table_taxonomy = $wpdb->prefix.r4w_bdd_table_taxonomy;
			$uuid = r4w_fcnt_uuid();

			if($wp_type == 'document'){
				$wpdb->query($wpdb->prepare("INSERT INTO $wp_table_document (uuid,post_id) VALUES(%s,%s)", array($uuid,$wp_id)));
			}
			if($wp_type == 'taxonomy'){
				$wpdb->query($wpdb->prepare("INSERT INTO $wp_table_taxonomy (uuid,term_id) VALUES(%s,%s)", array($uuid,$wp_id)));
			}
			return $uuid;
		}
	}