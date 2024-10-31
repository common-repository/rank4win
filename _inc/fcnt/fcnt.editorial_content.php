<?php
     if ( ! function_exists( 'r4w_fcnt_editorial_content' ) ) {
          /**
          * Insert le contenu editorial d'une page
          */
          function r4w_fcnt_editorial_content($a){
               global $wpdb;
               $page_tpl = new r4w_template(r4w_plugin_base."/tpl/editorial/contained.tpl");
               if(!empty($a['post_parent']['keyword_parent'])){

                    $keyword_parent = '<a href="'.r4w_get_permalink($a['post_parent']['keyword_parent']['ID']).'"><strong>'.$a['post_parent']['keyword_parent']['name'].'</strong></a> ';
               }

               if(!empty($a['keywords']['main'])){
                    if(is_array( $a['keywords']['main'] )){
                         $keyword_main = '<strong>'.$a['keywords']['main'][0].'</strong>';
                    }else{
                         $keyword_main = '<strong>'.$a['keywords']['main'].'</strong>';
                    }
               }

               if(!empty($a['keywords']['secondary'])){
                    $keyword_secondary = '';
                    foreach ($a['keywords']['secondary'] as $ksecondary) {
                         $keyword_secondary .= '<h2>'.sprintf(__('Title 2 (H2): Must contain the secondary keyword %s','app_rank4win'), $ksecondary).'.</h2>'."\n";
                         $keyword_secondary .= __('In these paragraphs you will start to argue and set up your editorial strength, feel free to use a rich vocabulary, you have the synonyms, the complementary keywords too, made so to meet the expectations of the reader', 'app_rank4win').'....'."\n";
                    }
               }else{
                    $keyword_secondary .= '<h2>'.sprintf(__('Title 2 (H2): Must contain the secondary keyword of the page','app_rank4win'), $k_child['name']).'.</h2>'."\n";
                    $keyword_secondary .= __('In these paragraphs you will start to argue and set up your editorial strength, feel free to use a rich vocabulary, you have the synonyms, the complementary keywords too, made so to meet the expectations of the reader', 'app_rank4win').'....';
               }

               if(!empty($a['post_childs'])){
                    $keyword_lexical = '';
                    foreach ($a['post_childs'] as $p_child) {
                         $wp_table_document = $wpdb->prefix.r4w_bdd_table_document;
                         $wp_select_pchild = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$p_child->ID);
                         $r4w_document_pchild = $wpdb->get_row($wp_select_pchild,ARRAY_A);
                         
                         if(!empty($r4w_document_pchild['deploy_data'])){
                              $update_data_deploy_pchild = json_decode(hex2bin($r4w_document_pchild['deploy_data']),true);
                         }
                         $name = $p_child->post_title;
                         if($update_data_deploy_pchild['keywords'] && $update_data_deploy_pchild['keywords']['main']){
                              if(is_array( $update_data_deploy_pchild['keywords']['main'] )){
                                   $name = $update_data_deploy_pchild['keywords']['main'][0];
                              }else{
                                   $name = $update_data_deploy_pchild['keywords']['main'];
                              }

                         }
                         $k_child = [
                              'name' => $name,
                              'link' => r4w_get_permalink($p_child->ID)
                         ];
                         if(!empty($k_child['link']) AND !empty($k_child['name'])){
                              $keyword_lexical .= '<h3>'.sprintf(__('Title 3 (H3): must contain the lexical keyword %s','app_rank4win'), $k_child['name']).'.</h3>'."\n";
                              $keyword_lexical .= sprintf(__('Write a paragraph of 150 words minimum, which summarizes all the content of the page %s this reinforces this page lexically and will be a semantic gateway to the child page','app_rank4win'), '<a href="'.$k_child['link'].'"><strong>'.$k_child['name'].'</strong></a>').'.';
                         }
                    }
               }else{
                    $keyword_lexical .= '<h3>'.__('Title 3 (H3): must contain the lexical keyword of the page','app_rank4win').'.</h3>'."\n";
                    $keyword_lexical .= __('Write a paragraph of 150 words minimum, which summarizes all the content of the page lexical this reinforces this page lexically and will be a semantic gateway to the child page','app_rank4win');
               }

               if(!isset($keyword_parent) or empty($keyword_parent)){
                    $keyword_parent = null;
               }

               $page_tpl->set("keyword_parent", $keyword_parent);
               $page_tpl->set("keyword_main", $keyword_main);
               $page_tpl->set("keyword_secondary", $keyword_secondary);
               $page_tpl->set("keyword_lexical", $keyword_lexical);
               $page_tpl->set("shortcode_sister_pages_link", '['.r4w_shortcode_sister_page_link.']');

               return $page_tpl->output();
          }
     }
