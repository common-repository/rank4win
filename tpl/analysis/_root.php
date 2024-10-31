<?php
	global $wpdb;

	r4w_wizard();

	$wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
	$wp_select = "SELECT * from ".$wp_table_app;
	$r4w_app = $wpdb->get_row($wp_select,ARRAY_A);
	if(!empty($r4w_app['settings'])){
		$r4w_settings =  json_decode(hex2bin($r4w_app['settings']),true);
	}
	if(!isset($r4w_settings['general_setting']['language'])){
		header('location:'.admin_url( 'admin.php?page=r4w_settings'));
	}

	$ctd->set("analyse_domain", get_site_url());

	$tpl_tab_summary = new r4w_template(dirname(__FILE__)."/tab_summary/contained.tpl");
	$ctd->set("tab_summary", $tpl_tab_summary->output());

	$tpl_tab_analysis_website = new r4w_template(dirname(__FILE__)."/tab_analysis_website/contained.tpl");
	$ctd->set("tab_analysis_website", $tpl_tab_analysis_website->output());

	$tpl_tab_analysis_research = new r4w_template(dirname(__FILE__)."/tab_analysis_research/contained.tpl");
	$ctd->set("tab_analysis_research", $tpl_tab_analysis_research->output());

	$tpl_tab_analysis_competition = new r4w_template(dirname(__FILE__)."/tab_analysis_competition/contained.tpl");
	$ctd->set("tab_analysis_competition", $tpl_tab_analysis_competition->output());

	global $wpdb,$r4w_define;
	$wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

    $tpl_loop_global = '';
	foreach ($r4w_define['app']['post_types'] as $post_type) {
		$foreach = '';
		if(array_key_exists($post_type['slug'], get_post_types(array( 'public' => true )))){
			switch ($post_type['slug']) {
				case 'post':
					$foreach = get_posts(['post_status'=>['publish', 'pending', 'draft']]);
					break;
				case 'page':
					$foreach = get_pages(['post_status'=>['publish', 'pending', 'draft']]);
					break;
				case 'product':
					$foreach = wc_get_products(['status'=> ['publish', 'pending', 'draft']]);
					break;
			}
			if(!empty($foreach)) {
				$tpl_loop = new r4w_template(dirname(__FILE__)."/tab_summary/score_loop.tpl");
				$tpl_loop->set("name", sprintf(__('Score %s', 'app_rank4win'), $post_type['name']));
				$tpl_loop->set("slug", $post_type['slug']);
				$tpl_loop->set("url", admin_url('edit.php?post_type='.$post_type['slug'].'&r4w_overallscore='));

				$any = 0;
				$poor = 0;
				$mediocre = 0;
				$good = 0;
				$perfect = 0;
				$ttdoc = count($foreach);
				foreach ($foreach as $document) {
					if(!empty($document->ID)){
						$document_id = $document->ID;
					}else{
						$document_id = $document->get_id();
					}
					if(!empty($document_id)){
						$wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$document_id);
						$r4w_document = $wpdb->get_row($wp_select,ARRAY_A);
						if(empty($r4w_document['overallscore'])){
							$any += 1;
						}else{
					        if($r4w_document['overallscore']<=39.99) {
					        	$poor += 1;
					        }
					        if($r4w_document['overallscore']>=40.00 and $r4w_document['overallscore']<=59.99) {
					        	$mediocre += 1;
					        }
					        if($r4w_document['overallscore']>=60.00 and $r4w_document['overallscore']<=79.99) {
					        	$good += 1;
					        }
					        if($r4w_document['overallscore']>=80.00) {
					        	$perfect += 1;
					        }
						}
					}
					if(!is_numeric($ttdoc) or is_nan($ttdoc)){
						$ttdoc = 0;
					}
					$tpl_loop->set("total_document", $ttdoc);
					$tpl_loop->set("url_all_doc", admin_url( 'edit.php?post_type='.$post_type['slug'] ));
				}

				$tpl_loop->set("score_any", $any);
				$tpl_loop->set("score_poor", $poor);
				$tpl_loop->set("score_mediocre", $mediocre);
				$tpl_loop->set("score_good", $good);
				$tpl_loop->set("score_perfect", $perfect);
				$tpl_loop_global .= $tpl_loop->output();
			}
	    }
		}

    $ctd->set("score_loop", $tpl_loop_global);
