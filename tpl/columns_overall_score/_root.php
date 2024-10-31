<?php

	global $wpdb;
	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
	$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

	$wp_select = "SELECT * from ".$wp_table_app;
	$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

	$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$tpl_data['post_id']);
	$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);
	if(isset($r4w_document['overallscore']) AND !empty($r4w_document['overallscore'])){
		$c = $r4w_document['overallscore'];
        if($c<=39.99) {
        	$class_color = "r4w_score_poor";
        }
        if($c>=40.00 and $c<=59.99) {
        	$class_color = "r4w_score_mediocre";
        }
        if($c>=60.00 and $c<=79.99) {
        	$class_color = "r4w_score_good";
        }
        if($c>=80.00) {
        	$class_color = "r4w_score_perfect";
        }
		$ctd->set("score", $c.'%');
		$ctd->set("class", $class_color);
	}else{
		$ctd->set("score", '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"  viewBox="0 0 401.991 401.991" xml:space="preserve"><path d="M394,154.174c-5.331-5.33-11.806-7.995-19.417-7.995H27.406c-7.611,0-14.084,2.665-19.414,7.995 C2.662,159.503,0,165.972,0,173.587v54.82c0,7.617,2.662,14.086,7.992,19.41c5.33,5.332,11.803,7.994,19.414,7.994h347.176 c7.611,0,14.086-2.662,19.417-7.994c5.325-5.324,7.991-11.793,7.991-19.41v-54.82C401.991,165.972,399.332,159.5,394,154.174z"></path></svg>');
		$ctd->set("class", '');
	}	