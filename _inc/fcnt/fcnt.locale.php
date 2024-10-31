<?php
     if ( ! function_exists( 'r4w_fcnt_locale_tag_js' ) ) {
          /**
          * Permet de créer les balise de langues pour les fichiers script
          */
          function r4w_fcnt_locale_tag_js($a){
               return addslashes("{_('".$a."')}");
          }
     }
    if ( ! function_exists( 'r4w_fcnt_locale' ) ) {
		/**
		 * Permet de générer les traductions qui seront utiliser dans les script.js
		 */
		function r4w_fcnt_locale($a){
			switch ($a) {
				case 'analysis':
					$r4w_fcnt_locale = [
						"tab_domain" => __('Domain', 'app_rank4win'),
						"tab_competition" => __('Level of competition','app_rank4win'),
						"tab_common" => __('Common keywords','app_rank4win'),
						"tab_organic" => __('Seo Keywords','app_rank4win'),
						"tab_traffic" => __('Traffic','app_rank4win'),
						"tab_traffic_cost" => __('Costs','app_rank4win'),
						"tab_keyword" => __('Keyword', 'app_rank4win'),
						"tab_position_acquired" => __('Position acquired','app_rank4win'),
						"tab_kd" => __('Difficulty','app_rank4win'),
						"tab_volume" => __('Volume','app_rank4win'),
						"tab_cpc" => __('Cpc','app_rank4win'),
						"svg_keywords" => r4w_assets_svg_code('keywords'),
						"svg_traffic" => r4w_assets_svg_code('traffic'),
						"svg_cost_traffic" => r4w_assets_svg_code('cost_traffic'),
						"svg_not_available" => r4w_assets_svg_code('not_available'),
						"svg_wait" => r4w_assets_svg_code('wait'),
						"svg_wordpress" => r4w_assets_svg_code('wordpress'),
						"svg_credit_card" => r4w_assets_svg_code('credit_card'),
						"url_subscription" => admin_url( 'admin.php?page=r4w_subscription' ),
						"url_associate" => admin_url( 'admin.php?page=r4w_account&tab=wordpress' ),
						"nd_not_available_title" => __('Not available with your subscription','app_rank4win'),
						"nd_not_available_cnt" => __('Your subscription does not include these tools, if you wish you can change offer to benefit from this tools','app_rank4win'),
						"nd_waiting_title" => __('Waiting for subscription renewal','app_rank4win'),
						"nd_waiting_cnt" => __('You have used the number of searches available in your offer, you must wait for your next billing to receive additional searches','app_rank4win'),
						"nd_associate_title" => __('Add to your subscription','app_rank4win'),
						"nd_associate_cnt" => __('If you still have wordpress available in your subscription you can this wordpress and benefit benefits prenium','app_rank4win'),
						"associate_wordpress" => __('Associated with your subscription','app_rank4win'),
						"nd_subscribe_title" => __('Subscribe to a subscription','app_rank4win'),
						"nd_subscribe_cnt" => __('Upgrade to the higher version by choosing a subscription, you will have the advantages prenium in addition to your deployments','app_rank4win'),
						"subscribe_subscription" => __('Subscribe to a subscription','app_rank4win'),
						"well_tempted" => __('It is well tempted', 'app_rank4win'),
						"keywords" => __('Keywords','app_rank4win'),
						"keywords_desc" => __('The number of keywords that bring you organic traffic','app_rank4win'),
						"traffic" => __('Traffic','app_rank4win'),
						"traffic_desc" => __('Organic traffic planned for next month','app_rank4win'),
						"cost_traffic" => __('Cost of the traffic', 'app_rank4win'),
						"cost_traffic_desc" => __('Savings, normally that what you should pay in Google AdWords for your traffic', 'app_rank4win')
					];
				break;
				case 'editor':
					$r4w_fcnt_locale = [
						"month" => __('month', 'app_rank4win'),
						"tab_keyword" => __('Keyword','app_rank4win'),
						"tab_volume" => __('Volume','app_rank4win'),
						"tab_serp" => __('Serp','app_rank4win'),
						"tab_feasibility" => __('Feasibility','app_rank4win'),
						"tab_cpc" => __('Cpc','app_rank4win'),
						"no_items" => __('We have no results for the moment regarding this keyword','app_rank4win'),
						"deploy_the_structure" => __('Deploy the structure','app_rank4win'),
						"svg_wait" => r4w_assets_svg_code('wait'),
						"svg_wordpress" => r4w_assets_svg_code('wordpress'),
						"svg_credit_card" => r4w_assets_svg_code('credit_card'),
						"url_subscription" => admin_url( 'admin.php?page=r4w_subscription' ),
						"url_associate" => admin_url( 'admin.php?page=r4w_account&tab=wordpress' ),
						"nd_waiting_day_title" => __('Daily search exceeded','app_rank4win'),
						"nd_waiting_day_cnt" => __('You have exceeded the number of authorized searches, you will be able to carry out new research as of tomorrow','app_rank4win'),
						"nd_waiting_title" => __('Waiting for subscription renewal','app_rank4win'),
						"nd_waiting_cnt" => __('You have used the number of searches available in your offer, you must wait for your next billing to receive additional searches','app_rank4win'),
						"nd_associate_title" => __('Add to your subscription','app_rank4win'),
						"nd_associate_cnt" => __('If you still have wordpress available in your subscription you can this wordpress and benefit benefits prenium','app_rank4win'),
						"associate_wordpress" => __('Associated with your subscription','app_rank4win'),
						"nd_subscribe_title" => __('Subscribe to a subscription','app_rank4win'),
						"nd_subscribe_cnt" => __('Upgrade to the higher version by choosing a subscription, you will have the advantages prenium in addition to your deployments','app_rank4win'),
                              "nd_limit_title" => __('Display limits','app_rank4win'),
                              "nd_limit_cnt" => __('As you do not have a subscription, the number of results is limited, so you can remove this limit by choosing a subscription','app_rank4win'),
						"subscribe_subscription" => __('Subscribe to a subscription','app_rank4win'),
						"well_tempted" => __('It is well tempted', 'app_rank4win'),
						"add_new_keyword_tags_input" => __( 'Add a new keyword', 'app_rank4win' ),
						"editor_page_title" => __( 'Page Title', 'app_rank4win' ),
						"editor_main_keyword" => __( 'Main keyword', 'app_rank4win' ),
						"editor_secondary_keyword" => __( 'Secondary keyword', 'app_rank4win' ),
						"editor_lexical_keyword" => __( 'Lexical keyword', 'app_rank4win' ),
						"editor_import_keyword" => __( 'Import keywords', 'app_rank4win' ),
						"editor_enriching" => __( 'Enriching this branch', 'app_rank4win' ),
						"editor_insert_keyword" => __( 'Insert your list of keywords', 'app_rank4win' ),
						"editor_1st_keyword" => __( '1st keyword', 'app_rank4win' ),
						"editor_2nd_keyword" => __( '2nd keyword', 'app_rank4win' ),
						"editor_page_close" => __( 'Close', 'app_rank4win' ),
					];
				break;
				case 'fcnt_datatable':
					$r4w_fcnt_locale = [
						"datatable_processing" => __( 'Ongoing treatment', 'app_rank4win' ),
						"datatable_search" => __( 'Search','app_rank4win' ),
						"datatable_lengthMenu" => __( 'Show _MENU_','app_rank4win' ),
						"datatable_info" => __( 'Showing _START_ to _END_ on _TOTAL_ items','app_rank4win' ),
						"datatable_infoEmpty" => __( 'Showing item 0 to 0 of 0 items','app_rank4win' ),
						"datatable_infoFiltered" => __( '(filtered from _MAX_ total items)','app_rank4win' ),
						"datatable_infoPostFix" => "",
						"datatable_loadingRecords" => __( 'Loading','app_rank4win' ),
						"datatable_zeroRecords" => __( 'No items to display','app_rank4win' ),
						"datatable_emptyTable" => __( 'No data available in the table','app_rank4win' ),
						"datatable_paginate_first" => __( 'First','app_rank4win' ),
						"datatable_paginate_previous" => __( 'Previous','app_rank4win' ),
						"datatable_paginate_next" => __( 'Next','app_rank4win' ),
						"datatable_paginate_last" => __( 'Latest','app_rank4win' ),
						"datatable_aria_sortAscending" => __( 'activate to sort the column in ascending order','app_rank4win' ),
						"datatable_aria_sortDescending" => __( 'activate to sort the column in descending order','app_rank4win' ),
					];
				break;
				case 'strategy_select':
					$r4w_fcnt_locale = [
						"month" => __('month', 'app_rank4win'),
						"tab_keyword" => __('Keyword','app_rank4win'),
						"tab_volume" => __('Volume','app_rank4win'),
						"tab_serp" => __('Serp','app_rank4win'),
						"tab_feasibility" => __('Feasibility','app_rank4win'),
						"tab_cpc" => __('Cpc','app_rank4win')
					];
				break;
                    case 'tools':
                         $r4w_fcnt_locale = [
                              "deploy_included" => __('Included in your subscription', 'app_rank4win')
                         ];
                    break;
				case 'settings':
					$r4w_fcnt_locale = [
						"url_assets" => plugins_url( '/assets/',  r4w_plugin_base  )
					];
				break;
                    case 'box_keywords':
					$r4w_fcnt_locale = [
						"add_new_keyword_tags_input" => __( 'Add a new keyword', 'app_rank4win' ),
						"error_keyword_invalid" => __( 'You must add your main keyword','app_rank4win' )
					];
				break;
				case 'box_analyzes':
					$r4w_fcnt_locale = [
						"ans_noresult" => __( 'Unfortunately, we cannot provide you with content ideas. Your keyword has little result or the language of your document does not match your keyword','app_rank4win' ),
						"syn_noresult" => __( 'We did not find any synonym','app_rank4win' ),
						"ana_noresult" => __( 'Unfortunately, we can not say what the search engines understood from your text. The content of your text is not enough or the language of your account does not match your text','app_rank4win' )
					];
				break;
				case 'box_answer':
					$r4w_fcnt_locale = [
						"no_items" => __('We have no questions available at the moment','app_rank4win'),
						"svg_wait" => r4w_assets_svg_code('wait'),
						"svg_wordpress" => r4w_assets_svg_code('wordpress'),
						"svg_credit_card" => r4w_assets_svg_code('credit_card'),
						"url_subscription" => admin_url( 'admin.php?page=r4w_subscription' ),
						"url_associate" => admin_url( 'admin.php?page=r4w_account&tab=wordpress' ),
						"nd_waiting_title" => __('Waiting for subscription renewal','app_rank4win'),
						"nd_waiting_cnt" => __('You have used the number of searches available in your offer, you must wait for your next billing to receive additional searches','app_rank4win'),
						"nd_associate_title" => __('Add to your subscription','app_rank4win'),
						"nd_associate_cnt" => __('If you still have wordpress available in your subscription you can this wordpress and benefit benefits prenium','app_rank4win'),
						"associate_wordpress" => __('Associated with your subscription','app_rank4win'),
						"nd_subscribe_title" => __('Subscribe to a subscription','app_rank4win'),
						"nd_subscribe_cnt" => __('Upgrade to the higher version by choosing a subscription, you will have the advantages prenium in addition to your deployments','app_rank4win'),
						"subscribe_subscription" => __('Subscribe to a subscription','app_rank4win'),
						"well_tempted" => __('It is well tempted', 'app_rank4win')
					];
				break;
				case 'box_synonymous':
					$r4w_fcnt_locale = [
						"no_items" => __('We have no synonymous available at the moment','app_rank4win'),
						"svg_wait" => r4w_assets_svg_code('wait'),
						"svg_wordpress" => r4w_assets_svg_code('wordpress'),
						"svg_credit_card" => r4w_assets_svg_code('credit_card'),
						"url_subscription" => admin_url( 'admin.php?page=r4w_subscription' ),
						"url_associate" => admin_url( 'admin.php?page=r4w_account&tab=wordpress' ),
						"nd_waiting_title" => __('Waiting for subscription renewal','app_rank4win'),
						"nd_waiting_cnt" => __('You have used the number of searches available in your offer, you must wait for your next billing to receive additional searches','app_rank4win'),
						"nd_associate_title" => __('Add to your subscription','app_rank4win'),
						"nd_associate_cnt" => __('If you still have wordpress available in your subscription you can this wordpress and benefit benefits prenium','app_rank4win'),
						"associate_wordpress" => __('Associated with your subscription','app_rank4win'),
						"nd_subscribe_title" => __('Subscribe to a subscription','app_rank4win'),
						"nd_subscribe_cnt" => __('Upgrade to the higher version by choosing a subscription, you will have the advantages prenium in addition to your deployments','app_rank4win'),
						"subscribe_subscription" => __('Subscribe to a subscription','app_rank4win'),
						"well_tempted" => __('It is well tempted', 'app_rank4win')
					];
				break;
				case 'box_semantic':
					$r4w_fcnt_locale = [
						"svg_wait" => r4w_assets_svg_code('wait'),
						"svg_wordpress" => r4w_assets_svg_code('wordpress'),
						"svg_credit_card" => r4w_assets_svg_code('credit_card'),
						"url_subscription" => admin_url( 'admin.php?page=r4w_subscription' ),
						"url_associate" => admin_url( 'admin.php?page=r4w_account&tab=wordpress' ),
						"nd_waiting_title" => __('Waiting for subscription renewal','app_rank4win'),
						"nd_waiting_cnt" => __('You have used the number of searches available in your offer, you must wait for your next billing to receive additional searches','app_rank4win'),
						"nd_associate_title" => __('Add to your subscription','app_rank4win'),
						"nd_associate_cnt" => __('If you still have wordpress available in your subscription you can this wordpress and benefit benefits prenium','app_rank4win'),
						"associate_wordpress" => __('Associated with your subscription','app_rank4win'),
						"nd_subscribe_title" => __('Subscribe to a subscription','app_rank4win'),
						"nd_subscribe_cnt" => __('Upgrade to the higher version by choosing a subscription, you will have the advantages prenium in addition to your deployments','app_rank4win'),
						"subscribe_subscription" => __('Subscribe to a subscription','app_rank4win'),
						"well_tempted" => __('It is well tempted', 'app_rank4win'),
                              "text_contexte" => __('Which corresponds to the lexical field','app_rank4win')
					];
				break;
                    case 'box_page':
                         $r4w_fcnt_locale = [
                              "title_too_short" => __('The length of the title is too short', 'app_rank4win'),
                              "title_short" => __('The length of the title is a little short', 'app_rank4win'),
                              "title_perfect" => __('The length of the title is perfect', 'app_rank4win'),
                              "title_too_long" => __('The length of the title is too long', 'app_rank4win'),
                              "description_too_short" => __('The length of the description is too short', 'app_rank4win'),
                              "description_short" => __('The length of the description is a little short', 'app_rank4win'),
                              "description_perfect" => __('The length of the description is perfect', 'app_rank4win'),
                              "description_too_long" => __('The length of the description is too long', 'app_rank4win'),


                         ];
                    break;
				case 'fcnt_notification':
					$r4w_fcnt_locale = [
						"saved_successfully_title" => __( 'Saved successfully', 'app_rank4win' ),
						"saved_successfully_cnt" =>  __( 'Your settings have been saved', 'app_rank4win' ),
						"saved_failed_title" => __( 'Saved failed', 'app_rank4win' ),
						"saved_failed_cnt" =>  __( 'Your settings have not been saved, please try again', 'app_rank4win' ),
						"file_successfully_title" => __( 'File edit successfully', 'app_rank4win' ),
						"file_successfully_cnt" =>  __( 'Modification of the file has been saved', 'app_rank4win' ),
						"file_failed_title" => __( 'File edit failed', 'app_rank4win' ),
						"file_failed_cnt" =>  __( 'The changes to the file have not been saved, please try again', 'app_rank4win' ),
						"reset_successfully_title" => __( 'Successful reset', 'app_rank4win' ),
						"reset_successfully_cnt" =>  __( 'Reset options have been completed', 'app_rank4win' ),
						"reset_failed_title" => __( 'Reset failed', 'app_rank4win' ),
						"reset_failed_cnt" =>  __( 'Reset options has not been done, please try again', 'app_rank4win' ),
						"import_successfully_title" => __( 'Successful import', 'app_rank4win' ),
						"import_successfully_cnt" =>  __( 'Your settings have been successfully imported', 'app_rank4win' ),
						"import_failed_title" => __( 'Import failed', 'app_rank4win' ),
						"import_failed_cnt" =>  __( 'The import of your settings has not been done, please try again', 'app_rank4win' ),
						"strategy_add_successfully_title" => __( 'Successful keyword add', 'app_rank4win' ),
						"strategy_add_successfully_cnt" =>  __( 'The keyword has been added in your strategy', 'app_rank4win' ),
						"strategy_add_failed_title" => __( 'Keyword add failed', 'app_rank4win' ),
						"strategy_add_failed_cnt" =>  __( 'Can not add the keyword in your strategy, please try again', 'app_rank4win' ),
						"strategy_remove_successfully_title" => __( 'Successful keyword remove', 'app_rank4win' ),
						"strategy_remove_successfully_cnt" =>  __( 'The keyword has been removed from your strategy', 'app_rank4win' ),
						"strategy_remove_failed_title" => __( 'Keyword remove failed', 'app_rank4win' ),
						"strategy_remove_failed_cnt" =>  __( 'Unable to remove the keyword from your strategy, please try again', 'app_rank4win' ),
						"strategy_title_successfully_title" => __( 'Successful Updated name', 'app_rank4win' ),
						"strategy_title_successfully_cnt" =>  __( 'The name of your strategy has been updated', 'app_rank4win' ),
						"strategy_title_failed_title" => __( 'Updated name failed', 'app_rank4win' ),
						"strategy_title_failed_cnt" =>  __( 'Unable to update the name of your strategy, please try again', 'app_rank4win' ),
					];
				break;
				case 'fcnt_suggestion':
					$r4w_fcnt_locale = [
						"keyword_empty_titre" => __( 'No keyword suggestions are currently available for your main keyword', 'app_rank4win'),
						"keyword_empty_cnt" => __( 'Please, insert your expression, query or keyword', 'app_rank4win'),
						"volume" => __( 'volume', 'app_rank4win'),
						"month" => __( 'month' , 'app_rank4win' ),
						"feasibility" => __( 'Feasibility', 'app_rank4win' ),
						"svg_wait" => r4w_assets_svg_code('wait'),
						"svg_wordpress" => r4w_assets_svg_code('wordpress'),
						"svg_credit_card" => r4w_assets_svg_code('credit_card'),
						"svg_not_available" => r4w_assets_svg_code('not_available'),
						"url_subscription" => admin_url( 'admin.php?page=r4w_subscription' ),
						"url_associate" => admin_url( 'admin.php?page=r4w_account&tab=wordpress' ),
						"nd_not_available_title" => __('Not available with your subscription','app_rank4win'),
						"nd_not_available_cnt" => __('Your subscription does not include these tools, if you wish you can change offer to benefit from this tools','app_rank4win'),
						"nd_waiting_day_title" => __('Daily search exceeded','app_rank4win'),
						"nd_waiting_day_cnt" => __('You have exceeded the number of authorized searches, you will be able to carry out new research as of tomorrow','app_rank4win'),
						"nd_waiting_title" => __('Waiting for subscription renewal','app_rank4win'),
						"nd_waiting_cnt" => __('You have used the number of searches available in your offer, you must wait for your next billing to receive additional searches','app_rank4win'),
						"nd_associate_title" => __('Add to your subscription','app_rank4win'),
						"nd_associate_cnt" => __('If you still have wordpress available in your subscription you can this wordpress and benefit benefits prenium','app_rank4win'),
						"associate_wordpress" => __('Associated with your subscription','app_rank4win'),
						"nd_subscribe_title" => __('Subscribe to a subscription','app_rank4win'),
						"nd_subscribe_cnt" => __('Upgrade to the higher version by choosing a subscription, you will have the advantages prenium in addition to your deployments','app_rank4win'),
						"subscribe_subscription" => __('Subscribe to a subscription','app_rank4win'),
						"well_tempted" => __('It is well tempted', 'app_rank4win')
					];
				break;
				case 'fcnt_analyzes':
					$r4w_fcnt_locale = [
						"error_maintenance_titre" => __('Analysis tools in maintenance','app_rank4win'),
						"error_maintenance_cnt" => __('In order to always be able to provide you with quality service, we are currently performing maintenance operations','app_rank4win'),
						"error_strange_titre" => __('We can not analyze this document','app_rank4win'),
						"error_strange_cnt" => __('The information transmitted is incorrect and no longer guarantees the results. This document is lock for analysis, you can contact rank4win for more information','app_rank4win'),
						"eye_main_keyword" => __('Main keyword','app_rank4win'),
						"eye_secondary_keyword" => __('Secondary keyword','app_rank4win'),
						"eye_lexical_keyword" => __('Lexical keyword','app_rank4win'),
						"overall_score" => __('Overall Score','app_rank4win'),
						"questioning" => __('Questioning','app_rank4win'),
						"analyzes_semantics" => __('Analyzes semantics','app_rank4win'),
						"synonymous" => __('Synonymous','app_rank4win'),
						"scoretextlevel_0" => __('Easily understood by an average 4th-grade student or lower','app_rank4win'),
						"scoretextlevel_5" => __('Easily understood by an average 5th or 6th-grade student','app_rank4win'),
						"scoretextlevel_6" => __('Easily understood by an average 7th or 8th-grade student','app_rank4win'),
						"scoretextlevel_7" => __('Easily understood by an average 9th or 10th-grade student','app_rank4win'),
						"scoretextlevel_8" => __('Easily understood by an average 11th or 12th-grade student','app_rank4win'),
						"scoretextlevel_9" => __('Easily understood by an average 13th to 15th-grade (college) student','app_rank4win'),
						"scoretextlevel_10" => __('Easily understood by an average college graduate','app_rank4win'),
						"scoretextreadabilit_0" => __('Very difficult','app_rank4win'),
						"scoretextreadabilit_30" => __('Difficult','app_rank4win'),
						"scoretextreadabilit_50" => __('Quite difficult','app_rank4win'),
						"scoretextreadabilit_60" => __('Easily understandable','app_rank4win'),
						"scoretextreadabilit_70" => __('Easy enough','app_rank4win'),
						"scoretextreadabilit_80" => __('Easy','app_rank4win'),
						"scoretextreadabilit_90" => __('Very easy','app_rank4win'),
						"number_words" => __('Number of words','app_rank4win'),
						"goal" => __('Goal','app_rank4win'),
						"reading_time" => __('Reading time','app_rank4win'),
						"difficulty_reading" => __('Difficulty reading','app_rank4win'),
						"overall_score" => __('Overall score','app_rank4win'),
						"target_keywords" => __('Target Keywords', 'app_rank4win'),
						"tak_main_keyword" => __('Main keyword', 'app_rank4win'),
						"tak_secondary_keyword" => __('Secondary keyword', 'app_rank4win'),
						"tak_lexical_keyword" => __('Lexical keyword', 'app_rank4win'),
						"title_structures" => __('Title structures', 'app_rank4win'),
						"tis_main_keyword" => __('Main keyword in title', 'app_rank4win'),
						"tis_length" => __('The title has a good length', 'app_rank4win'),
						"text_structures" => __('Text structures', 'app_rank4win'),
						"tes_h1" => __('Main keyword in H1 tag', 'app_rank4win'),
						"tes_h2" => __('Secondary Keywords in H2 tags', 'app_rank4win'),
						"tes_h3" => __('Lexical keywords in H3 tags', 'app_rank4win'),
						"tes_h4h5h6" => __('Some keywords in H4 / H5 / H6 tags', 'app_rank4win'),
						"tes_keyword_hat" => __('Main keyword in the hat', 'app_rank4win'),
						"tes_nbr_keyword_paragraph" => __('Number of words in your paragraph', 'app_rank4win'),
						"tes_rate_main_keyword" => __('Presence rate of the main keyword', 'app_rank4win'),
						"tes_rate_sentence_word" => __('Rate of sentences with a transition word', 'app_rank4win'),
						"tes_average_sentences" => __('The average of your sentences have a good length', 'app_rank4win'),
						"tes_main_keyword_bold" => __('Main keyword in bold in a paragraph', 'app_rank4win'),
						"tes_presence_image" => __('Presence of an image in the text', 'app_rank4win'),
						"tes_main_keyword_alt" => __('Main keyword in alt tag', 'app_rank4win'),
						"tes_length_text" => __('Length of the text', 'app_rank4win'),
						"main_keyword_title" => __('Main keyword in title', 'app_rank4win'),
						"title_length" => __('Title length', 'app_rank4win'),
						"title_too_short" => __('Title length too short', 'app_rank4win'),
						"title_too_long" => __('Title length too long', 'app_rank4win'),
						"svg_not_touch" => r4w_assets_svg_code('not_touch'),
						"svg_wrench" => r4w_assets_svg_code('wrench'),
						"well_tempted" => __('It is well tempted', 'app_rank4win'),
						"lorem_ipsum" => 'Duis aute irure dolor in reprehenderit in voluptate',
                              "svg_edit" => r4w_assets_svg_code('edit')
					];
				break;
                    case 'subscription':
					$r4w_fcnt_locale = [
						"unlimited" => __( 'unlimited', 'app_rank4win'),
						"limited" => __( 'limited', 'app_rank4win'),
						"free_offer" => __('Free Offer', 'app_rank4win'),
						"medium_offer" => __('Medium Offer', 'app_rank4win'),
						"light_offer" => __('Light Offer', 'app_rank4win'),
						"pro_offer" => __('Pro Offer', 'app_rank4win'),
                              "presale_offer" => __('Pre-sale Offer', 'app_rank4win'),
                              "agency_offer" => __('Agency Offer', 'app_rank4win'),
						"general_settings" => __('General settings', 'app_rank4win'),
						"number_of_wordpress" => __('Number of wordpress', 'app_rank4win'),
						"choice_of_language_and_country" => __('Choice of language and country', 'app_rank4win'),
						"analysis_of_the_writings" => __('Analysis of the writings', 'app_rank4win'),
						"seo_parameters_configuration" => __('SEO Parameters Configuration', 'app_rank4win'),
						"setting_(block_indexing)" => __('Setting (block indexing)', 'app_rank4win'),
						"separator_title" => __('Separator title', 'app_rank4win'),
						"homepage" => __('Homepage', 'app_rank4win'),
						"knowledge_graph" => __('Knowledge Graphs', 'app_rank4win'),
						"suggested_keyword" => __('Suggested keyword', 'app_rank4win'),
						"add_keywords_manually" => __('Add keywords manually', 'app_rank4win'),
						"automatically_suggest_main_keyword" => __('Automatically suggest main keyword', 'app_rank4win'),
						"automatically_suggest_secondary_keyword" => __('Automatically suggest secondary keyword', 'app_rank4win'),
						"automatically_suggest_lexical_keyword" => __('Automatically suggest lexical keyword', 'app_rank4win'),
						"features" => __('Features', 'app_rank4win'),
						"internal_link_counter" => __('Internal Link Counter', 'app_rank4win'),
						"sitemap" => __('Sitemap', 'app_rank4win'),
						"primary_keyword_in_the_title" => __('Primary keyword in the title', 'app_rank4win'),
						"title_length" => __('Title length', 'app_rank4win'),
						"numbe_of_words" => __('Number of words', 'app_rank4win'),
						"reading_time" => __('Reading time', 'app_rank4win'),
						"difficulty_reading" => __('Difficulty reading', 'app_rank4win'),
						"overall_score" => __('Overall score', 'app_rank4win'),
						"questioning" => __('Questioning', 'app_rank4win'),
						"synonym_search_engine" => __('Synonym search engine', 'app_rank4win'),
						"semantic_analysis" => __('Semantic Analysis', 'app_rank4win'),
						"target_keywords" => __('Target keywords', 'app_rank4win'),
						"title_structure" => __('Title Structure', 'app_rank4win'),
						"text_structure" => __('Text structure', 'app_rank4win'),
						"tools_for_webmasters" => __('Tools for webmasters', 'app_rank4win'),
						"google" => __('Google', 'app_rank4win'),
						"bing" => __('Bing', 'app_rank4win'),
						"baidu" => __('Baidu', 'app_rank4win'),
						"yandex" => __('Yandex', 'app_rank4win'),
						"type_of_content" => __('Type of content', 'app_rank4win'),
						"page" => __('Page', 'app_rank4win'),
						"article" => __('Article', 'app_rank4win'),
						"portfolio" => __('Portfolio', 'app_rank4win'),
						"product" => __('Product', 'app_rank4win'),
						"other" => __('Other', 'app_rank4win'),
						"taxonomies" => __('Taxonomies', 'app_rank4win'),
						"categories" => __('Categories', 'app_rank4win'),
						"tags" => __('Tags', 'app_rank4win'),
						"formats" => __('Formats', 'app_rank4win'),
						"projects_categories" => __('Projects categories', 'app_rank4win'),
						"projects_attributes" => __('Projects Attributes', 'app_rank4win'),
						"other" => __('Other', 'app_rank4win'),
						"social_networks" => __('Social networks', 'app_rank4win'),
						"facebook" => __('Facebook', 'app_rank4win'),
						"twitter" => __('Twitter', 'app_rank4win'),
						"pinterest" => __('Pinterest', 'app_rank4win'),
						"overview_of_social_networks" => __('Overview of social networks', 'app_rank4win'),
						"archives" => __('Archives', 'app_rank4win'),
						"author_archives" => __('Author Archives', 'app_rank4win'),
						"dates_archives" => __('Dates Archives', 'app_rank4win'),
						"creation_of_semantic_structure" => __('Creation of semantic structure', 'app_rank4win'),
						"creating_a_new_structure" => __('Creating a new structure', 'app_rank4win'),
						"reorganization_of_your_site" => __('Reorganization of your site', 'app_rank4win'),
						"deployment_of_the_structure" => __('Deployment of the structure', 'app_rank4win'),
						"number_of_searches" => __('Number of searches', 'app_rank4win'),
						"number_of_results" => __('Number of results', 'app_rank4win'),
						"export_import_tools" => __('Export / Import Tools', 'app_rank4win'),
						"export" => __('Export', 'app_rank4win'),
						"import" => __('Import', 'app_rank4win'),
						"special_pages" => __('Special pages', 'app_rank4win'),
						"search_page" => __('Search page', 'app_rank4win'),
						"page_error_404" => __('Page Error 404', 'app_rank4win'),
						"tracking_the_positioning_of_the_site" => __('Tracking the positioning of the site', 'app_rank4win'),
						"summary" => __('Summary', 'app_rank4win'),
						"site_analysis" => __('Site Analysis', 'app_rank4win'),
						"analysis_of_organic_research" => __('Analysis of organic research', 'app_rank4win'),
						"competition_analysis" => __('Competition Analysis', 'app_rank4win'),
						"file_editor" => __('File Editor', 'app_rank4win'),
						"htaccess" => __('Htaccess', 'app_rank4win'),
						"robots_txt" => __('Robots.txt', 'app_rank4win'),
						"rss" => __('RSS', 'app_rank4win'),
						"add_content_before_and_after" => __('Add content before and after', 'app_rank4win'),
						"reset" => __('Reset', 'app_rank4win'),
						"application" => __('Application', 'app_rank4win'),
						"content_type" => __('Content type', 'app_rank4win'),
						"taxonomy" => __('Taxonomy', 'app_rank4win'),
						"month" => '/ '.__('month', 'app_rank4win'),
						"days" => '/ '.__('days', 'app_rank4win'),
						"beyond_payment_page" => __('Beyond that, payment per page', 'app_rank4win'),
						"results" => '/ '.__('results', 'app_rank4win')
					];
				break;
				default:
					$r4w_fcnt_locale = [];
					break;
			}
			return $r4w_fcnt_locale;
		}
	}
