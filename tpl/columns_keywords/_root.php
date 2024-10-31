<?php

	global $wpdb;
	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
	$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

	$wp_select = "SELECT * from ".$wp_table_app;
	$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

	$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$tpl_data['post_id']);
	$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);

	$ctd->set("keywords", '');

	$tpl_keywords = '';
	if(!empty($r4w_document)){
		if(!empty($r4w_document['keywords_main'])){
			$tpl_loop_keyword = '';
			foreach (json_decode($r4w_document['keywords_main']) as $keyword) {
				$tpl_loop_keyword .= '<div class="keyword_solo">'.$keyword.'</div>';
			}
			if(!empty($tpl_loop_keyword)){
				$tpl_keywords .= '<div class="title_keyword">'.__('Main keyword','rank4win_app').'</div><div class="keyword_main_list">'.$tpl_loop_keyword.'</div>';
			}
		}
		if(!empty($r4w_document['keywords_secondary'])){
			$tpl_loop_keyword = '';
			foreach (json_decode($r4w_document['keywords_secondary']) as $keyword) {
				$tpl_loop_keyword .= '<div class="keyword_solo">'.$keyword.'</div>';
			}
			if(!empty($tpl_loop_keyword)){
				$tpl_keywords .= '<div class="title_keyword">'.__('Secondary keyword','rank4win_app').'</div><div class="keyword_main_list">'.$tpl_loop_keyword.'</div>';
			}
		}
		if(!empty($r4w_document['keywords_lexical'])){
			$tpl_loop_keyword = '';
			foreach (json_decode($r4w_document['keywords_lexical']) as $keyword) {
				$tpl_loop_keyword .= '<div class="keyword_solo">'.$keyword.'</div>';
			}
			if(!empty($tpl_loop_keyword)){
				$tpl_keywords .= '<div class="title_keyword">'.__('Secondary keyword','rank4win_app').'</div><div class="keyword_main_list">'.$tpl_loop_keyword.'</div>';
			}
		}
		if(!empty($tpl_keywords)){
			$ctd->set("keywords", '<div class="r4w_column_keywords"><div class="box_keywords">'.$tpl_keywords.'</div></div>');
		}
	}