<?php
	global $wpdb;
	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
	$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
	$wp_table_option = $wpdb->prefix.'options';

    $wp_select = "SELECT * from ".$wp_table_app;
    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

	if(!empty($r4w_app['settings']) AND ctype_xdigit($r4w_app['settings'])){
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

	$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_option} WHERE option_name = %s",'blog_public');
	$wp_options = $wpdb->get_row($wp_select,ARRAY_A);

	$meta_tags = '';
	$link_tags = '';
	$m_description = '';
	$m_robots_index = '';
	$m_robots_follow = '';
	$m_robots_custom = '';

	/**
	 * Page spéciale (404)
	 */
	if( is_404() ){
	}

	/**
	 * Page spéciale (recherche)
	 */
	if( is_search() ){
	}

	/**
	 * Archive (auteur)
	 */
	if( is_author() ){
		$author = get_queried_object();
		if(!empty($r4w_settings['seo_settings']['archive']['author_archives'])){
			$r4w_settings_type = $r4w_settings['seo_settings']['archive']['author_archives'];
		}
		if(!empty($author) AND count_user_posts($author->ID)>=1){
			/**
			 * seo_settings|archive|author_archives|index_have_post
			 */
			if(!empty($r4w_settings_type['index_have_post']) AND $r4w_settings_type['index_have_post']=='on' AND empty($m_robots_index)){
				$m_robots_index = "index";
			}

			/**
			 * seo_settings|archive|author_archives|follow_have_post
			 */
			if(!empty($r4w_settings_type['follow_have_post']) AND $r4w_settings_type['follow_have_post']=='on' AND empty($m_robots_follow)){
				$m_robots_follow = "follow";
			}
		}else{
			/**
			 * seo_settings|archive|author_archives|index_no_post
			 */
			if(!empty($r4w_settings_type['index_no_post']) AND $r4w_settings_type['index_no_post']=='on' AND empty($m_robots_index)){
				$m_robots_index = "index";
			}

			/**
			 * seo_settings|archive|author_archives|follow_no_post
			 */
			if(!empty($r4w_settings_type['follow_no_post']) AND $r4w_settings_type['follow_no_post']=='on' AND empty($m_robots_follow)){
				$m_robots_follow = "follow";
			}
		}
  		/**
  		 *seo_settings|archive|author_archives|meta_description
  		 */
		if(!empty($r4w_settings_type['meta_description'])){
			if(empty($meta_description)){
    			$m_description = strip_tags(r4w_unwanted_tag($r4w_settings_type['meta_description']));
    		}
    	}
	}

	/**
	 * Archive (date)
	 */
	if( is_date() ){
		if(!empty($r4w_settings['seo_settings']['archive']['date_archives'])){
			$r4w_settings_type = $r4w_settings['seo_settings']['archive']['date_archives'];
		}

		/**
		 * seo_settings|archive|date_archives|index
		 */
		if(!empty($r4w_settings_type['index']) AND $r4w_settings_type['index']=='on' AND empty($m_robots_index)){
			$m_robots_index = "index";
		}

		/**
		 * seo_settings|archive|date_archives|follow
		 */
		if(!empty($r4w_settings_type['follow']) AND $r4w_settings_type['follow']=='on' AND empty($m_robots_follow)){
			$m_robots_follow = "follow";
		}

  		/**
  		 *seo_settings|archive|date_archives|meta_description
  		 */
		if(!empty($r4w_settings_type['meta_description'])){
			if(empty($meta_description)){
    			$m_description = strip_tags(r4w_unwanted_tag($r4w_settings_type['meta_description']));
    		}
    	}
	}

	/**
	 * Taxonomies
	 */
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

		/**
		 * page|facebook
		 */
		if(!empty($r4w_settings['social_networks']['facebook']['editing_meta']) AND $r4w_settings['social_networks']['facebook']['editing_meta'] == "on"){
		    if(!empty($r4w_doc_config['facebook']['meta_title']) AND empty($m_facebook_title)){
		    	$m_facebook_title = $r4w_doc_config['facebook']['meta_title'];
		    }
		    if(!empty($r4w_doc_config['facebook']['meta_description']) AND empty($m_facebook_description)){
		    	$m_facebook_description = $r4w_doc_config['facebook']['meta_description'];
		    }
		}

		/**
		 * page|twitter
		 */
		if(!empty($r4w_settings['social_networks']['twitter']['editing_meta']) AND $r4w_settings['social_networks']['twitter']['editing_meta'] == "on"){
		    if(!empty($r4w_doc_config['twitter']['meta_title']) AND empty($m_twitter_title)){
		    	$m_twitter_title = $r4w_doc_config['twitter']['meta_title'];
		    }
		    if(!empty($r4w_doc_config['twitter']['meta_description']) AND empty($m_twitter_description)){
		    	$m_twitter_description = $r4w_doc_config['twitter']['meta_description'];
		    }
		}

		/**
		 * page|meta
		 */
		if(!empty($r4w_settings_type['editing_meta']) AND $r4w_settings_type['editing_meta'] == "on"){
			/**
			 * page|meta_title
			 */
	    	if(!empty($r4w_doc_config['page']['meta_title'])){

	    		if(empty($m_facebook_title)){
	    			$m_facebook_title = $r4w_doc_config['page']['meta_title'];
	    		}
	    		if(empty($m_twitter_title)){
	    			$m_twitter_title = $r4w_doc_config['page']['meta_title'];
	    		}
	  		}

			/**
			 * page|meta_description
			 */
	    	if(!empty($r4w_doc_config['page']['meta_description'])){
		    		if(empty($m_description)){
		    			$m_description = strip_tags(r4w_unwanted_tag($r4w_doc_config['page']['meta_description']));
		    		}
		    		if(empty($m_facebook_description)){
		    			$m_facebook_description = strip_tags(r4w_unwanted_tag($r4w_doc_config['page']['meta_description']));
		    		}
		    		if(empty($m_twitter_description)){
		    			$m_twitter_description = strip_tags(r4w_unwanted_tag($r4w_doc_config['page']['meta_description']));
		    		}
	  		}
	  	}

  		/**
  		 * seo_settings|type|meta_title
  		 */
		if(!empty($r4w_settings_type['meta_title'])){
    		if(empty($m_facebook_title)){
    			$m_facebook_title = $r4w_settings_type['meta_title'];
    		}
    		if(empty($m_twitter_title)){
    			$m_twitter_title = $r4w_settings_type['meta_title'];
    		}
    	}

  		/**
  		 * seo_settings|type|meta_description
  		 */
		if(!empty($r4w_settings_type['meta_description'])){
			if(empty($m_description)){
    			$m_description = strip_tags(r4w_unwanted_tag($r4w_settings_type['meta_description']));
    		}
    		if(empty($m_facebook_description)){
    			$m_facebook_description = strip_tags(r4w_unwanted_tag($r4w_settings_type['meta_description']));
    		}
    		if(empty($m_twitter_description)){
    			$m_twitter_description = strip_tags(r4w_unwanted_tag($r4w_settings_type['meta_description']));
    		}
    	}

    	/**
    	 * page|index
    	 */
    	if(!empty($r4w_doc_config['page']['index'])){
    		if($r4w_doc_config['page']['index']=='on'){
    			$m_robots_index = "index";
    		}else{
    			$m_robots_index = "noindex";
    		}
    	}else{
    		if(!empty($r4w_settings_type['index']) AND empty($m_robots_index)){
    			if($r4w_settings_type['index']=='on'){
    				$m_robots_index = "index";
    			}else{
    				$m_robots_index = "index";
    			}
    		}
    	}

    	/**
    	 * page|follow
    	 */
    	if(!empty($r4w_doc_config['page']['follow'])){
    		if($r4w_doc_config['page']['follow']=='on'){
    			$m_robots_follow = "follow";
    		}
    	}else{
	    	/**
  		 	* seo_settings|taxonomies|term|follow
  		 	*/
    		if(!empty($r4w_settings_type['follow']) AND $r4w_settings_type['follow']=='on' AND empty($m_robots_follow)){
    			$m_robots_follow = "follow";
    		}
    	}
	}

	/**
	 * Types de contenu
	 */
	if( is_single() || is_page() ){
		if(!empty($r4w_settings['seo_settings']['types_content'][$wp_post_type])){
			$r4w_settings_type = $r4w_settings['seo_settings']['types_content'][$wp_post_type];
		}
		if(is_front_page()){
			if(!empty($r4w_settings['seo_settings']['basic_configuration']['home_page'])){
				$r4w_settings_type = $r4w_settings['seo_settings']['basic_configuration']['home_page'];
			}
			/**
			 * general_setting|webmaster_tools
			 */
		    if(!empty($r4w_settings['general_setting']['webmaster_tools']['google'])){
		    	$meta_tags .= "\r\n".'<meta name="google-site-verification" content="'.$r4w_settings['general_setting']['webmaster_tools']['google'].'">';
		    }
		    if(!empty($r4w_settings['general_setting']['webmaster_tools']['bing'])){
		    	$meta_tags .= "\r\n".'<meta name="msvalidate.01" content="'.$r4w_settings['general_setting']['webmaster_tools']['bing'].'">';
		    }
		    if(!empty($r4w_settings['general_setting']['webmaster_tools']['baidu'])){
		    	$meta_tags .= "\r\n".'<meta name="baidu-site-verification" content="'.$r4w_settings['general_setting']['webmaster_tools']['baidu'].'">' ;
		    }
		    if(!empty($r4w_settings['general_setting']['webmaster_tools']['yandex'])){
		    	$meta_tags .= "\r\n".'<meta name="yandex-verification" content="'.$r4w_settings['general_setting']['webmaster_tools']['yandex'].'">';
		    }

			/**
			 * social_networks|pinterest|verification_code
			 */
		    if(!empty($r4w_settings['social_networks']['pinterest']['verification_code'])){
		    	$meta_tags .= "\r\n".'<meta name="p:domain_verify" content="'.$r4w_settings['social_networks']['pinterest']['verification_code'].'">';
		    }
		}

		/**
		 * page|facebook
		 */
		if(!empty($r4w_settings['social_networks']['facebook']['editing_meta']) AND $r4w_settings['social_networks']['facebook']['editing_meta'] == "on"){
		    if(!empty($r4w_doc_config['facebook']['meta_title']) AND empty($m_facebook_title)){
		    	$m_facebook_title = $r4w_doc_config['facebook']['meta_title'];
		    }
		    if(!empty($r4w_doc_config['facebook']['meta_description']) AND empty($m_facebook_description)){
		    	$m_facebook_description = $r4w_doc_config['facebook']['meta_description'];
		    }
		}

		/**
		 * page|twitter
		 */
		if(!empty($r4w_settings['social_networks']['twitter']['editing_meta']) AND $r4w_settings['social_networks']['twitter']['editing_meta'] == "on"){
		    if(!empty($r4w_doc_config['twitter']['meta_title']) AND empty($m_twitter_title)){
		    	$m_twitter_title = $r4w_doc_config['twitter']['meta_title'];
		    }
		    if(!empty($r4w_doc_config['twitter']['meta_description']) AND empty($m_twitter_description)){
		    	$m_twitter_description = $r4w_doc_config['twitter']['meta_description'];
		    }
		}

		/**
		 * page|meta
		 */
		if(!empty($r4w_settings_type['editing_meta']) AND $r4w_settings_type['editing_meta'] == "on"){
			/**
			 * page|meta_title
			 */
	    	if(!empty($r4w_doc_config['page']['meta_title'])){

	    		if(empty($m_facebook_title)){
	    			$m_facebook_title = $r4w_doc_config['page']['meta_title'];
	    		}
	    		if(empty($m_twitter_title)){
	    			$m_twitter_title = $r4w_doc_config['page']['meta_title'];
	    		}
	  		}

			/**
			 * page|meta_description
			 */
	    	if(!empty($r4w_doc_config['page']['meta_description'])){

	    		if(empty($meta_description)){
	    			$m_description = strip_tags(r4w_unwanted_tag($r4w_doc_config['page']['meta_description']));
	    		}
	    		if(empty($m_facebook_description)){
	    			$m_facebook_description = strip_tags(r4w_unwanted_tag($r4w_doc_config['page']['meta_description']));
	    		}
	    		if(empty($m_twitter_description)){
	    			$m_twitter_description = strip_tags(r4w_unwanted_tag($r4w_doc_config['page']['meta_description']));
	    		}
	  		}
	  	}

  		/**
  		 * seo_settings|type|meta_title
  		 */
		if(!empty($r4w_settings_type['meta_title'])){
    		if(empty($m_facebook_title)){
    			$m_facebook_title = $r4w_settings_type['meta_title'];
    		}
    		if(empty($m_twitter_title)){
    			$m_twitter_title = $r4w_settings_type['meta_title'];
    		}
    	}

  		/**
  		 * seo_settings|type|meta_description
  		 */
		if(!empty($r4w_settings_type['meta_description'])){
			if(empty($meta_description)){
    			$m_description = strip_tags(r4w_unwanted_tag($r4w_settings_type['meta_description']));
    		}
    		if(empty($m_facebook_description)){
    			$m_facebook_description = strip_tags(r4w_unwanted_tag($r4w_settings_type['meta_description']));
    		}
    		if(empty($m_twitter_description)){
    			$m_twitter_description = strip_tags(r4w_unwanted_tag($r4w_settings_type['meta_description']));
    		}
    	}

    	/**
    	 * page|index
    	 */
    	if(!empty($r4w_doc_config['page']['index'])){
    		if($r4w_doc_config['page']['index']=='on'){
    			$m_robots_index = "index";
    		}else{
    			$m_robots_index = "noindex";
    		}
    	}else{
    		if(!empty($r4w_settings_type['index']) AND empty($m_robots_index)){
    			if($r4w_settings_type['index']=='on'){
    				$m_robots_index = "index";
    			}else{
    				$m_robots_index = "noindex";
    			}
    		}
    	}

    	/**
    	 * page|follow
    	 */
    	if(!empty($r4w_doc_config['page']['follow'])){
    		if($r4w_doc_config['page']['follow']=='on'){
    			$m_robots_follow = "follow";
    		}
    	}else{
	    	/**
  		 	* seo_settings|type|follow
  		 	*/
    		if(!empty($r4w_settings_type['follow']) AND $r4w_settings_type['follow']=='on' AND empty($m_robots_follow)){
    			$m_robots_follow = "follow";
    		}
    	}

		/**
		 * Meta : Article
		 */
		if(!empty($r4w_settings['social_networks']['facebook']['url_page'])){
			$meta_tags .=  "\r\n".'<meta property="article:publisher" content="'.$r4w_settings['social_networks']['facebook']['url_page'].'" />';
		}
		if(!empty(get_the_category()[0]->cat_name)){
			$meta_tags .=  "\r\n".'<meta property="article:section" content="'.get_the_category()[0]->cat_name.'" />';
		}
		if(!empty($wp_post->post_date) AND $wp_post->post_date != '0000-00-00 00:00:00'){
			$meta_tags .=  "\r\n".'<meta property="article:published_time" content="'.date(DATE_W3C, strtotime($wp_post->post_date)).'" />';
		}
		if(!empty($wp_post->post_modified) AND $wp_post->post_modified != '0000-00-00 00:00:00'){
			$meta_tags .=  "\r\n".'<meta property="article:modified_time" content="'.date(DATE_W3C, strtotime($wp_post->post_modified)).'" />';
		}
	}

	/**
	 * Types de contenu & Taxonomies (Réseau social)
	 */
	if(  is_single() || is_page() || is_tax() || is_category() || is_tag() ){

		/**
		 * Meta : Facebook (OG)
		 */
		$get_locale = get_locale();
		if(!empty($get_locale)){
			$meta_tags .= "\r\n".'<meta property="og:locale" content="'.$get_locale.'" />';
		}
		if(!empty($r4w_settings['seo_settings']['basic_configuration']['knowledge_graph']['type'])){
			$kg_type = $r4w_settings['seo_settings']['basic_configuration']['knowledge_graph']['type'];
			if(!empty($r4w_settings['seo_settings']['basic_configuration']['knowledge_graph'][$kg_type]['type'])){
				$meta_tags .= "\r\n".'<meta property="og:type" content="'.$r4w_settings['seo_settings']['basic_configuration']['knowledge_graph'][$kg_type]['type'].'" />';
			}else{
				$meta_tags .= "\r\n".'<meta property="og:type" content="'.$kg_type.'" />';
			}
		}
		if(!empty($m_facebook_title)){
			$meta_tags .= "\r\n".'<meta property="og:title" content="'.r4w_callback_tag($m_facebook_title).'" />';
		}
		if(!empty($m_facebook_description)){
			$meta_tags .= "\r\n".'<meta property="og:description" content="'.r4w_callback_tag($m_facebook_description).'" />';
		}
		if(!empty($r4w_doc_config['page']['canonical'])){
			$url = r4w_display_links($r4w_doc_config['page']['canonical']);
			$meta_tags .= "\r\n".'<meta property="og:url" content="'.$url.'" />';
			$link_tags .= "\r\n".'<link rel="canonical" href="'.$url.'" />';
			$link_tags .= "\r\n".'<link rel="shortlink" href="'.$url.'" />';
		}else{
			$_rquest_scheme = "http://";
			if(r4w_is_ssl()){
				$_rquest_scheme = "https://";
			}
			$url = $_rquest_scheme.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
			$meta_tags .= "\r\n".'<meta property="og:url" content="'.$url.'" />';
			$link_tags .= "\r\n".'<link rel="canonical" href="'.$url.'" />';
			$link_tags .= "\r\n".'<link rel="shortlink" href="'.$url.'" />';
		}
		$meta_tags .= "\r\n".'<meta property="og:site_name" content="'.get_bloginfo().'" />';
		if(!empty($r4w_settings['social_networks']['facebook']['app_id'])){
			$meta_tags .=  "\r\n".'<meta property="fb:app_id" content="'.$r4w_settings['social_networks']['facebook']['app_id'].'" />';
		}
		if(!empty($r4w_doc_config['facebook']['picture'])){
			$meta_tags .=  "\r\n".'<meta property="og:image" content="'.$r4w_doc_config['facebook']['picture'].'" />';
			$meta_tags .=  "\r\n".'<meta property="og:image:secure_url" content="'.$r4w_doc_config['facebook']['picture'].'" />';
		}
		if(!empty($wp_post->post_date) AND $wp_post->post_modified != '0000-00-00 00:00:00'){
			$meta_tags .=  "\r\n".'<meta property="og:updated_time" content="'.date(DATE_W3C, strtotime($wp_post->post_modified)).'" />';
		}

		/**
		 * Meta : Twitter
		 */
		if(!empty($m_twitter_title)){
			$meta_tags .= "\r\n".'<meta name="twitter:title" content="'.r4w_callback_tag($m_twitter_title).'" />';
		}
		if(!empty($m_twitter_description)){
			$meta_tags .= "\r\n".'<meta name="twitter:description" content="'.r4w_callback_tag($m_twitter_description).'" />';
		}
		if(!empty($r4w_doc_config['twitter']['picture'])){
			$meta_tags .=  "\r\n".'<meta property="twitter:image" content="'.$r4w_doc_config['twitter']['picture'].'" />';
		}
		if(!empty($r4w_settings['social_networks']['twitter']['card_type'])){
			switch ($r4w_settings['social_networks']['twitter']['card_type']) {
				case 'with_image':
					$meta_tags .=  "\r\n".'<meta name="twitter:card" content="summary-large-img" />';
					break;
				case 'without_image':
					$meta_tags .=  "\r\n".'<meta name="twitter:card" content="summary" />';
					break;
			}
		}
		if(!empty($r4w_settings['social_networks']['twitter']['username'])){
			$meta_tags .=  "\r\n".'<meta name="twitter:site" content="@'.$r4w_settings['social_networks']['twitter']['username'].'" />';
			$meta_tags .=  "\r\n".'<meta name="twitter:creator" content="@'.$r4w_settings['social_networks']['twitter']['username'].'" />';
		}

 		/**
    	 * page|robots|custom
    	 */
    	if(!empty($r4w_doc_config['page']['robots']['custom']) AND $r4w_doc_config['page']['robots']['custom'] == "on"){
    		if(!empty($r4w_doc_config['page']['robots']['no_archive']) AND $r4w_doc_config['page']['robots']['no_archive']=='on'){
    			$m_robots_custom .= ', noarchive';
    		}
    		if(!empty($r4w_doc_config['page']['robots']['no_image']) AND $r4w_doc_config['page']['robots']['no_image']=='on'){
    			$m_robots_custom .= ', noimageindex';
    		}
    		if(!empty($r4w_doc_config['page']['robots']['no_meta']) AND $r4w_doc_config['page']['robots']['no_meta']=='on'){
    			$m_robots_custom .= ', nosnippet';
    		}
    	}

	}

	/**
	 * Meta : Description
	 */
	if(!empty($m_description)){
		$meta_tags .= "\r\n".'<meta name="description" content="'.r4w_callback_tag($m_description).'">';
	}

	/**
	 * Meta : Robots
	 */
	if($wp_options['option_value'] == 1){
		if(empty($m_robots_index)){
			$m_robots_index = "index";
		}
		if(empty($m_robots_follow)){
			$m_robots_follow = "follow";
		}
	}else{
		if(empty($m_robots_index)){
			$m_robots_index = "noindex";
		}
		if(empty($m_robots_follow)){
			$m_robots_follow = "nofollow";
		}
	}
	$meta_tags .=  "\r\n".'<meta name="robots" content="'.$m_robots_index.', '.$m_robots_follow.''.$m_robots_custom.'" />';


	/**
	 * Knowledge Graph / Schema.org
	 */

	function knowledge_display($a,$b){
		global $r4w_define;
		$kg_return =  '';
		if(is_array($b)){
			if($a == 'openingHours'){
				$return_openinghours = '';
				foreach ($r4w_define['app']['dates'] as $day => $hours) {
					if(!empty($return_openinghours)){
						$return_openinghours .= " ";
					}
					$day_dim = ucfirst(substr($day, 0, 2));
					if(!empty($b[$day]) AND $b[$day]['checked']=='on'){
						$open = '';
						$close = '';
						if(isset($b[$day]['open'])){
							$open = $b[$day]['open'];
						}
						if(isset($b[$day]['close'])){
							$close = $b[$day]['close'];
						}
						$return_openinghours .= $day_dim.' '.$open.'-'.$close;
					}else{
						$return_openinghours .= $day_dim.',';
					}
				}
				if(!empty($return_openinghours)){
					$kg_return = ',"'.$a.'": "'.$return_openinghours.'"';
				}
			}else{
				$kg_return_array = '';
				foreach ($b as $aa => $bb) {

					if(is_array($bb)){
						$kg_return_array_array = '';
						foreach ($bb as $aaa => $bbb) {
							if(!empty($bbb)){
								$kg_return_array_array .= ',"'.$aaa.'": "'.$bbb.'"';
							}
						}
						if(!empty($kg_return_array_array)){
							$knowledge_type = r4w_callback_knowledge_type($aa);
							if(!empty($knowledge_type)){
								$kg_return_array_array = $knowledge_type.$kg_return_array_array;
							}
							$kg_return_array .= ',"'.$aa.'": {'.$kg_return_array_array.'}';
						}
					}else{
						if(!empty($bb)){
							if($aa == 'url'){
								$url = r4w_display_links($bb);
								$kg_return_array .= ',"'.$aa.'": "'.$url.'"';
							}else{
								$kg_return_array .= ',"'.$aa.'": "'.$bb.'"';
							}
						}
					}
				}
				if(!empty($kg_return_array)){
					$knowledge_type = r4w_callback_knowledge_type($a);
					if(!empty($knowledge_type)){
						$kg_return_array = $knowledge_type.$kg_return_array;
					}
					$kg_return = ',"'.$a.'": {'.$kg_return_array.'}';
				}
			}
		}else{
			if(!empty($b)){
				if($a != 'type'){
				if($a == 'url'){
					$url = r4w_display_links($b);
					$kg_return = ',"'.$a.'": "'.$url.'"';
				}else{
					$kg_return = ',"'.$a.'": "'.$b.'"';
				}
				}
			}
		}
		return $kg_return;
	}
	$knowledge_graph = '';
	if(!empty($r4w_settings['seo_settings']['basic_configuration']['knowledge_graph']['type'])){

		$kg_type = $r4w_settings['seo_settings']['basic_configuration']['knowledge_graph']['type'];
		if(!empty($r4w_settings['seo_settings']['basic_configuration']['knowledge_graph'][$kg_type]['type'])){
			$knowledge_graph .= ',"@type": "'.$r4w_settings['seo_settings']['basic_configuration']['knowledge_graph'][$kg_type]['type'].'"';
		}else{
			$knowledge_graph .= ',"@type": "'.$kg_type.'"';
		}

		if(!empty($r4w_settings['seo_settings']['basic_configuration']['knowledge_graph'][$r4w_settings['seo_settings']['basic_configuration']['knowledge_graph']['type']])){
			foreach ($r4w_settings['seo_settings']['basic_configuration']['knowledge_graph'][$r4w_settings['seo_settings']['basic_configuration']['knowledge_graph']['type']] as $kg_key => $kg_value) {
				if(!empty($kg_value)){
					$knowledge_graph .= knowledge_display($kg_key, $kg_value);
				}
			}
		}
	}
	$knowledge_graph_sn = '';
	if(!empty($r4w_settings['social_networks']['facebook']['url_page'])){
		$knowledge_graph_sn .= '"'.$r4w_settings['social_networks']['facebook']['url_page'].'"';
	}
	if(!empty($r4w_settings['social_networks']['pinterest']['url_page'])){
		$sep = '';
		if(!empty($knowledge_graph_sn)){
			$sep = ',';
		}
		$knowledge_graph_sn .= $sep.'"'.$r4w_settings['social_networks']['pinterest']['url_page'].'"';
	}
	if(!empty($knowledge_graph_sn)){
		$knowledge_graph_sn = ',"sameAs":['.$knowledge_graph_sn.']';
	}
	if(!empty($knowledge_graph)){
		$meta_tags .= "\r\n".'<script type="application/ld+json">{';
		$meta_tags .= '"@context": "https://schema.org"';
		$meta_tags .= $knowledge_graph;
		$meta_tags .= $knowledge_graph_sn;
		$meta_tags .= '}</script>';
	}
	$meta_tags = $meta_tags . $link_tags;
	$ctd->set("meta_tags", $meta_tags."\r\n");