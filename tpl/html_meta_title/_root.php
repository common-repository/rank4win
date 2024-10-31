<?php
	global $wpdb;
	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
	$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

    $wp_select = "SELECT * from ".$wp_table_app;
    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

	if(!empty($r4w_app['settings'])){
    	$GLOBALS['r4w_settings'] =  json_decode(hex2bin($r4w_app['settings']),true);
    	global $r4w_settings;
    }

    $wp_post_id = get_the_ID();
    $wp_post_type = get_post_type();
    $GLOBALS['wp_post'] = $wp_post = get_post($wp_post_id);
    global $wp_post;

	$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$wp_post_id);
	$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);

	if(!empty($r4w_document['config'])){
    	$r4w_doc_config =  json_decode(hex2bin($r4w_document['config']),true);
    }

    $meta_title = '';
	if(is_front_page()){
	    if(!empty($r4w_settings['seo_settings']['types_content']['page']['editing_meta']) AND $r4w_settings['seo_settings']['types_content']['page']['editing_meta'] == "on"){
	    	if(!empty($r4w_doc_config['page']['meta_title'])){
	    		$meta_title = $r4w_doc_config['page']['meta_title'];
	    	}else{
				if(!empty($r4w_settings['seo_settings']['basic_configuration']['home_page']['meta_title'])){
		    		$meta_title = $r4w_settings['seo_settings']['basic_configuration']['home_page']['meta_title'];
		    	}
	    	}
	    }else{
	    	if(!empty($r4w_settings['seo_settings']['basic_configuration']['home_page']['meta_title'])){
	    		$meta_title =  $r4w_settings['seo_settings']['basic_configuration']['home_page']['meta_title'];
	    	}
	    }
	}
	if(!is_front_page()){
		if( is_404() ){
	 		if(!empty($r4w_settings['seo_settings']['special_page']['error_404']['meta_title'])){
	    		$meta_title = $r4w_settings['seo_settings']['special_page']['error_404']['meta_title'];
		    }
		}
		if( is_search() ){
	 		if(!empty($r4w_settings['seo_settings']['special_page']['search']['meta_title'])){
	    		$meta_title = $r4w_settings['seo_settings']['special_page']['search']['meta_title'];
		    } 
		}
		if( is_feed() ){

		}
		if( is_author() ){
			if(!empty($r4w_settings['seo_settings']['archive']['author_archives']['meta_title'])){
	    		$meta_title = $r4w_settings['seo_settings']['archive']['author_archives']['meta_title'];
		    }
		}
		if( is_date() ){
	 		if(!empty($r4w_settings['seo_settings']['archive']['date_archives']['meta_title'])){
	    		$meta_title = $r4w_settings['seo_settings']['archive']['date_archives']['meta_title'];
		    }
		}
		if( is_tax() || is_category() || is_tag() ){
			$term = get_queried_object();

			unset($r4w_doc_config);
			$wp_table_taxonomy = $wpdb->prefix.r4w_bdd_table_taxonomy;

			$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_taxonomy} WHERE term_id = %d",$term->term_id);
			$r4w_taxonomy = $wpdb->get_row($wp_select,ARRAY_A);

			if(!empty($r4w_taxonomy['config'])){
		    	$r4w_doc_config =  json_decode(hex2bin($r4w_taxonomy['config']),true);
		    }
			if(!empty($r4w_settings['seo_settings']['taxonomies'][$term->taxonomy])){
				$r4w_settings_type = $r4w_settings['seo_settings']['taxonomies'][$term->taxonomy];
			}

		    if(!empty($r4w_settings['seo_settings']['taxonomies'][$term->taxonomy]['editing_meta']) AND $r4w_settings['seo_settings']['taxonomies'][$term->taxonomy]['editing_meta'] == "on"){
		    	if(!empty($r4w_doc_config['page']['meta_title'])){
		    		$meta_title = $r4w_doc_config['page']['meta_title'];
		    	}else{
					if(!empty($r4w_settings['seo_settings']['taxonomies'][$term->taxonomy]['meta_title'])){
			    		$meta_title = $r4w_settings['seo_settings']['taxonomies'][$term->taxonomy]['meta_title'];
			    	}
		    	}
		    }else{
		    	if(!empty($r4w_settings['seo_settings']['taxonomies'][$term->taxonomy]['meta_title'])){
		    		$meta_title =  $r4w_settings['seo_settings']['taxonomies'][$term->taxonomy]['meta_title'];
		    	}
		    }
		}
		if( is_single() || is_page() ){
		    if(!empty($r4w_settings['seo_settings']['types_content'][$wp_post_type]['editing_meta']) AND $r4w_settings['seo_settings']['types_content'][$wp_post_type]['editing_meta'] == "on"){
		    	if(!empty($r4w_doc_config['page']['meta_title'])){
		    		$meta_title = $r4w_doc_config['page']['meta_title'];
		    	}else{
					if(!empty($r4w_settings['seo_settings']['types_content'][$wp_post_type]['meta_title'])){
			    		$meta_title = $r4w_settings['seo_settings']['types_content'][$wp_post_type]['meta_title'];
			    	}
		    	}
		    }else{
		    	if(!empty($r4w_settings['seo_settings']['types_content'][$wp_post_type]['meta_title'])){
		    		$meta_title =  $r4w_settings['seo_settings']['types_content'][$wp_post_type]['meta_title'];
		    	}
		    }
		}		
	}
	$ctd->set("meta_title", r4w_callback_tag($meta_title));