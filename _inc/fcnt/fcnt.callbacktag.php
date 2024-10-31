<?php
	if ( ! function_exists( 'r4w_callback_result_tag' ) ) {
		/**
		 * Retourne le resultat du tag
		 */ 
		function r4w_callback_result_tag($a){
			global $wpdb, $r4w_settings, $wp_post, $wp_query, $wp_term, $r4w_define;
			if(!empty($wp_post->post_parent)){
				$wp_post_parent = $wp_post->post_parent;
				$wp_post_parent_title = get_the_title($wp_post_parent);
			}
			$get_the_category = get_the_category();
			$get_the_date = get_the_date();
			$get_the_title  = get_the_title();
			$get_bloginfo_name = get_bloginfo('name');
			$get_bloginfo_description = get_bloginfo('description');
			$get_site_url = get_site_url();
			$get_permalink = get_permalink();
			$get_queried_object = $wp_query->get_queried_object();
			$category_description = category_description();



			switch ($a) {
				case 'page_name':
					if(!empty($wp_post->post_name)){
						return $wp_post->post_name;
					}
					break;
				case 'page_date':
					if(!empty($get_the_date)){
						return $get_the_date;
					}
					break;
				case 'page_title':
					if(!empty($get_the_title)){
						return $get_the_title;
					}
					break;
				case 'product_name':
					if(!empty($get_the_title)){
						return $get_the_title;
					}
					break;
				case 'parent_page_title':
					if(!empty($wp_post_parent_title)){
						return $wp_post_parent_title;
					}
					break;
				case 'wp_name':
					if(!empty($get_bloginfo_name)){
						return $get_bloginfo_name;
					}
					break;
				case 'wp_separator':
					if(!empty($r4w_settings['seo_settings']['basic_configuration']['title_separator'])){
						return $r4w_define['app']['title_separator'][$r4w_settings['seo_settings']['basic_configuration']['title_separator']];
					}
					break;
				case 'wp_slogan':
					if(!empty($get_bloginfo_description)){
						return $get_bloginfo_description;
					}
					break;
				case 'page_content_generated':
					if(!empty($wp_post->post_excerpt)){
						return str_replace(array("\n", "\t", "\r"), '', strip_tags(r4w_unwanted_tag($wp_post->post_excerpt)));
					}else{
						if(!empty($wp_post->post_content)){
							return str_replace(array("\n", "\t", "\r"), '',strip_tags(substr(r4w_unwanted_tag($wp_post->post_content), 0, 300)));
						}
					}
					break;
				case 'page_content':
					if(!empty($wp_post->post_content)){
						return str_replace(array("\n", "\t", "\r"), '',strip_tags(substr(r4w_unwanted_tag($wp_post->post_content), 0, 300)));
					}
					break;
				case 'page_update':
					if(!empty($wp_post->post_modified)){
						return $wp_post->post_modified;
					}
					break;
				case 'page_time_update':
					if(!empty($wp_post->post_modifie)){
						$time_update = explode(' ',$wp_post->post_modified);
						return $time_update[1];
					}
					break;
				case 'wp_site_url':
					if(!empty($get_site_url)){
						return $get_site_url;
					}
					break;
				case 'post_link':
					if(!empty($get_permalink)){
						return $get_permalink;
					}
					break;
				case 'page_main_category':
					if(!empty($get_the_category)){
						if(!empty($get_the_category[0])){
							return $get_the_category[0]->cat_name;
						}
					}
					break;
				case 'term_cat_all':
					break;
				case 'term_cat_main':
					break;
				case 'term_keyword':
					break;
				case 'term_cat_parent':
					if(!empty($get_queried_object)){
						$term = $get_queried_object;
						if($term->parent!=0){
						  $category_parent = get_term( $term->parent, 'category' );
						  return $category_parent->name;
						}
					}
					break;
				case 'term_name':
					if(!empty($wp_term->name)){
					 	return $wp_term->name;
					}
					break;
				case 'wp_search':
					break;
				case 'term_cat_description':
					if(!empty($category_description)){
						return str_replace(array("\n", "\t", "\r"), '', strip_tags($category_description));
					}
					break;
				case 'term_keyword_description':
					break;
				case 'term_description':
					if(!empty($wp_term->description)){
						return  str_replace(array("\n", "\t", "\r"), '', strip_tags($wp_term->description));
					}
					break;
				case 'term_time_update':
					break;
				case 'author_name':
					$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
					if(!empty($author)){
						return get_the_author_meta( 'display_name', $author->ID );
					}
					break;
				case 'author_id':
					$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
					if(!empty($author)){
						return get_the_author_meta('ID', $author->ID );
					}
					break;
				case 'author_bio':
					$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
					if(!empty($author)){
						return get_the_author_meta('description', $author->ID );
					}
					break;
				case 'archive_date':
					if(!empty($get_the_date)){
						return $get_the_date;
					}
					break;
				case 'search_phrase':
					if(!empty($_GET['s'])){
						return $_GET['s'];
					}
					break;
				case 'search_phrase':
					if(!empty($_GET['s'])){
						return $_GET['s'];
					}
					break;
				case 'authors_link':
					if(!empty($wp_post->post_author)){
						return get_author_posts_url($wp_post->post_author);
					}
					break;
				case 'wp_link':
					if(!empty($get_site_url)){
						return $get_site_url;
					}
					break;
				case 'wp_link_desc':
					if(!empty($get_site_url) AND !empty($get_bloginfo_description)){
						return '<a href="'.$get_site_url.'">'.$get_bloginfo_description.'</a>';
					}
					break;
				default:
					break;
			}
		}
	}

	if ( ! function_exists( 'r4w_callback_tag' ) ) {
		/**
		 * Analyse une chaîne à la recherche de tag
		 */
		function r4w_callback_tag($a){
			if(!empty($a)){
				$output = preg_replace_callback('/%%([^%%]*)%%/s',function($matches){
					return r4w_callback_result_tag($matches[1]);
				} ,$a);
			    return stripslashes(strip_tags(html_entity_decode($output)));
			}
		}
	}

	if ( ! function_exists( 'r4w_callback_tag_all' ) ) {
		/**
		 * Retourne les tags disponibles avec leurs resulats
		 */
		function r4w_callback_tag_all(){
			$tags_avalable = array('page_name','page_date','page_title','product_name','parent_page_title','wp_name','wp_separator','wp_slogan','page_content_generated','page_content','page_update','page_time_update','wp_site_url','post_link','page_main_category','term_cat_all','term_cat_main','term_keyword','term_cat_parent','term_name','wp_search','term_cat_description','term_keyword_description','term_description','term_time_update','author_name','author_id','author_bio','archive_date','search_phrase','authors_link','wp_link','wp_link_desc');
			foreach ($tags_avalable as $tag) {
				$tags[$tag] = stripslashes(strip_tags(html_entity_decode(r4w_callback_result_tag($tag))));
			} 
		    return $tags;
		}
	}