<?php
/**
 * Fonction pour la structure sémantique
 */
     /**
      * Corbeille des pages non pertinentes
      */
          if ( ! function_exists( 'r4w_trash_irrelevant_pages' ) ) {
               function r4w_trash_irrelevant_pages( $releventIds ){
                    $pages = get_posts([
                         'post_type' => 'page',
                         'post_status' => 'any',
                         'posts_per_page' => -1
                    ]);
                    $frontpage_id = get_option( "page_on_front" );
                    foreach( $pages as $page ){
                         if( !in_array( $page->ID, $releventIds ) ){
                              wp_update_post([
                                   'ID'            => $page->ID,
                                   'post_status'   => 'trash'
                              ]);
                              if( $frontpage_id == $page->ID ){
                                   update_option( "page_on_front", 0 );
                                   update_option( 'show_on_front', 'posts' );
                              }
                         }
                    }
               }
          }

     /**
      * Permet d'obtenir l'identifiant pertinent
      */
          if ( ! function_exists( 'r4w_get_relevent_id' ) ) {
               function r4w_get_relevent_id( $node, &$result = [] ){
                    if( isset( $node['data']['r4w_post_data']['ID'] ) ){
                         if( !is_array($result) ){
                              $result = [];
                         }
                         array_push( $result, $node['data']['r4w_post_data']['ID'] );
                    }
                    if( isset( $node['children'] ) && count($node['children']) > 0 ){
                         foreach( $node['children'] as $childNode ){
                              r4w_get_relevent_id( $childNode, $result );
                         }
                    }
                    return $result;
               }
          }

     /**
      * Création des pages lors du déploiement du diagramme
      */
          if ( ! function_exists( 'r4w_deploy_pages' ) ) {
               function r4w_deploy_pages( $node, $parentPageId = 0, &$result = [], $isHome = false){
                    $nodeTitle = $node["data"]["text"];
                    $km = "";
                    if(is_array($node["data"]["r4w_post_data"]["keywords"]["main"])){
                         $km = $node["data"]["r4w_post_data"]["keywords"]["main"][0];
                    }else{
                         $km = $node["data"]["r4w_post_data"]["keywords"]["main"];
                    }
                    $nodeSlug = sanitize_title( $km );
                    $old_permalink = '';
                    $existingPost = false;
                    $pageId = 0;

                    if( isset($node["data"]["r4w_post_data"]["ID"]) ){
                         $pageId = $node["data"]["r4w_post_data"]["ID"];
                         $old_permalink = $node["data"]["r4w_post_data"]["post_permalink"];
                    }
                    $pageArgs = [
                         "post_type"     => "page",
                         "post_title"    => $nodeTitle,
                         "post_content"  => '',
                         "post_parent"   => $parentPageId,
                         "post_name"     => $nodeSlug,
                         "post_status"   => "publish"
                    ];

                    if( $pageId ){
                         $existingPost = get_post( $pageId, "OBJECT" );
                    }

                    if( $existingPost && $existingPost->post_status != "trash"){
                         $updatePageArgs = [
                              "ID"            => $pageId,
                              "post_title"    => $nodeTitle,
                              "post_parent"   => $parentPageId,
                              "post_name"     => $nodeSlug,
                              "post_status"   => "publish"
                         ];

                         if( $isHome ){
                              $updatePageArgs["post_parent"] = 0;
                         }

                         $pageId = wp_update_post( $updatePageArgs );

                         if( $pageId ){
                              $pageObj = get_post( $pageId );
                              $result['updated']++;
                              $new_permalink = str_replace( get_home_url(), '', get_permalink( $pageId ) );
                              if( $new_permalink != $old_permalink ){
                                   if( !array_key_exists( 'updated_permalinks',  $result ) || !is_array($result[ 'updated_permalinks' ] ) ){
                                        $result[ 'updated_permalinks' ] = [];
                                   }
                                   array_push( $result['updated_permalinks'], [
                                        'old' => $old_permalink,
                                        'new' => $new_permalink,
                                   ]);
                              }
                         }else{
                              $result['update_error']++;
                         }
                    }else{

                         /**
                          * Faire en sorte que le noeud principal ne pointe pas vers une page parente
                          */
                         if( $isHome ){
                              $pageArgs["post_parent"] = 0;
                         }

                         /**
                          * Créer une page ici et obtenir un identifiant
                          * Met en pause certaine fonctionnalité pour rendre le script plus rapide
                          */
                         wp_defer_term_counting (true);
                         wp_defer_comment_counting (true);
                         $pageId = wp_insert_post( $pageArgs );

                         if( $pageId ){
                              $result['created']++;
                         }else{
                              $result['create_error']++;
                         }

                         /**
                          * Reactive les fonctionnalité mis en pause
                          */
                         wp_defer_term_counting (false);
                         wp_defer_comment_counting (false);
                    }

                    if( $pageId ){

                         /**
                          * Faire du nœud principal la page d'accueil du site
                          */
                         if( $isHome ){
                              update_option( "page_on_front", $pageId );
                              update_option( 'show_on_front', 'page' );
                         }

                         if( isset( $node["children"] ) ){
                              unset($nodeLexical);
                              forEach( $node["children"] as $childNode ){
                                   $children = r4w_deploy_pages( $childNode, $pageId, $result );
                                   $ml = "";
                                   if($childNode["data"]["r4w_post_data"]["keywords"]["main"]){
                                        if(is_array($childNode["data"]["r4w_post_data"]["keywords"]["main"])){
                                             $ml = $childNode["data"]["r4w_post_data"]["keywords"]["main"][0];
                                        }else{
                                             $ml = $childNode["data"]["r4w_post_data"]["keywords"]["main"];
                                        }
                                   }
                                   $nodeLexical[] = $ml;
                                   $keyword_lexical[] = [
                                        'id' => $children['page_info'],
                                        'name' => $ml,
                                        'link' => get_permalink($children['page_info'])
                                   ];
                              }

                              /**
                              * Créer le document et ajoute les mots-clés associée
                              */
                              global $wpdb;
                              $wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
                              $wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

                              $wp_select = "SELECT * from ".$wp_table_app;
                              $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

                              $wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$pageId);
                              $r4w_document = $wpdb->get_row($wp_select,ARRAY_A);

                              if(empty($r4w_document['uuid'])){
                                   $wp_document_uuid = r4w_new_document('document', $pageId);
                              }else{
                                   $wp_document_uuid = $r4w_document['uuid'];
                              }

                              if(!isset($nodeLexical) or empty($nodeLexical)){
                                   $nodeLexical = null;
                              }
                              
                              $data = [
                                   "node" => [
                                        "image" => $node["data"]["image"],
                                        "imageTitle" => $node["data"]["imageTitle"],
                                        "imageSize" => [
                                             "width" => $node["data"]["imageSize"]["width"],
                                             "height" => $node["data"]["imageSize"]["height"]
                                        ],
                                        "priority" => $node["data"]["priority"],
                                        "background" => $node["data"]["background"],
                                        "font-weight" => $node["data"]["font-weight"],
                                        "font-size" => $node["data"]["font-size"],
                                        "font-family" => $node["data"]["font-family"],
                                        "color" => $node["data"]["color"],
                                        "progress" => $node["data"]["progress"],
                                        "note" => $node["data"]["note"],
                                        "hyperlink" => $node["data"]["hyperlink"],
                                        "hyperlinkTitle" => $node["data"]["hyperlinkTitle"],
                                   ],
                                   "keywords" => [
                                        "main" => $node["data"]["r4w_post_data"]["keywords"]["main"],
                                        "secondary" => $node["data"]["r4w_post_data"]["keywords"]["secondary"],
                                        "lexical" => $nodeLexical,
                                   ]
                              ];

                              $deploy_data = bin2hex(json_encode($data));
                              $wpdb->query( $wpdb->prepare( "UPDATE $wp_table_document SET deploy = %s, deploy_data = %s WHERE uuid = %s", $result['uuid'], $deploy_data,  $wp_document_uuid));
                         }

                         if(!isset($keyword_lexical) or empty($keyword_lexical)){
                              $keyword_lexical = null;
                         }
                         $a = [
                              'keyword_main' => [
                                   'name' => $node["data"]["r4w_post_data"]["keywords"]["main"]
                              ],
                              "keyword_secondary" => $node["data"]["r4w_post_data"]["keywords"]["secondary"],
                              'keyword_lexical' => $keyword_lexical,
                              'page_sister' => null
                         ];
                         if(!$isHome){
                              $page_data_parent = get_post($parentPageId);
                              $keyword_parent = [
                                   'keyword_parent' => [
                                        'name' => $page_data_parent->post_title,
                                        'link' => get_permalink($parentPageId)
                                   ]
                              ];
                              $a = array_merge($a, $keyword_parent);
                         }
                         $page_cnt = get_page($pageId);

                         if(empty($page_cnt->post_content) or $page_cnt->post_author==0){
                              wp_update_post([
                                   'ID' => $pageId,
                                   'post_author' => 0
                              ]);
                         }

                    }else{
                         $result['children_skipped']++;
                    }
                    $result['page_info'] = $pageId;
                    return $result;
               }
          }

     /**
      * Récupérer la structure de la page d'accueil principale
      */
          if ( ! function_exists( 'r4w_home_pages' ) ) {
               function r4w_home_pages(){
                    $rootNode = [
                         "root"  => [
                              "data" => [
                                   "uuid" => r4w_fcnt_uuid(),
                                   "created" => time(),
                                   "text" =>  site_url(),
                                   'r4w_post_data' => [
                                        'ID' => 0,
                                        'post_parent' => 0,
                                        'post_status' => 'draft',
                                        'post_permalink'=> ''
                                   ],
                              ],
                              "children" => '',
                         ],
                         "template"   => "default",
                         "theme"      => "rank4win-default",
                         "version"    => "1.4.43"
                    ];

                    /**
                     * Obtenir la page d'accueil principale sur le site
                     */
                    $homePageID = get_option('page_on_front');

                    if( $homePageID ){
                         $homePage = get_post( $homePageID );

                         /**
                          * Supprimer l'URL de la page d'accueil du permalien
                          */
                         $related_permalink = str_replace( get_home_url(), '', get_permalink( $homePageID ) );

                         global $wpdb;
                         $wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
                         $wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

                         $wp_select = "SELECT * from ".$wp_table_app;
                         $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

                         $wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$homePageID);
                         $r4w_document = $wpdb->get_row($wp_select,ARRAY_A);
                         $deploy_data = json_decode(hex2bin($r4w_document['deploy_data']),true);

                         $rootNode["root"]["data"] = [
                              'uuid' => $r4w_document['uuid'],
                              'created' => $r4w_document['timecode'],
                              'text' => $homePage->post_title,
                              'r4w_post_data' => [
                                   'ID' => $homePage->ID,
                                   'post_parent' => $homePage->post_parent,
                                   'post_status' => $homePage->post_status,
                                   'post_permalink'=> $related_permalink,
                                   'keywords' => [
                                        'main' => $deploy_data['keywords']['main'],
                                        'secondary' => $deploy_data['keywords']['secondary'],
                                        'lexical' => $deploy_data['keywords']['lexical']
                                   ]
                              ],
                              "image" => $deploy_data['node']['image'],
                              "imageTitle" => $deploy_data['node']['imageTitle'],
                              "imageSize" => [
                                   "width" => $deploy_data['node']['imageSize']['width'],
                                   "height" => $deploy_data['node']['imageSize']['height'],
                              ],
                              "priority" => $deploy_data['node']['priority'],
                              "background" => $deploy_data['node']['background'],
                              "font-weight" => $deploy_data['node']['font-weight'],
                              "font-size" => $deploy_data['node']['font-size'],
                              "font-family" => $deploy_data['node']['font-family'],
                              "color" => $deploy_data['node']['color'],
                              "progress" => $deploy_data['node']['progress'],
                              "note" => $deploy_data['node']['note'],
                              "hyperlink" => $deploy_data['node']['hyperlink'],
                              "hyperlinkTitle" => $deploy_data['node']['hyperlinkTitle']
                         ];
                    }
                    return $rootNode;
               }
          }

     /**
      * Récupérer la structure des pages soeurs
      */
          if ( ! function_exists( 'r4w_child_pages' ) ) {
               function r4w_child_pages($node, $fromPages, $root_id = 0){

                    foreach ($fromPages as $pageChild) {

                         /**
                          * Ignorer si la page racine est en cours
                          */
                         if( $root_id == $pageChild->ID ){
                              continue;
                         }

                         if( 0 !== $pageChild->post_parent ){
                              $parent_post = $pageChild->post_parent;
                         }else{
                              $parent_post = $root_id;
                         }

                         if( $parent_post == $node[ "data" ][ "r4w_post_data" ][ "ID" ] ){
 
                              /**
                               * Supprimer l'URL de la page d'accueil du permalien
                               */
                              
                              $related_permalink = str_replace( get_home_url(), '', get_permalink( $pageChild->ID ) );
     
                              global $wpdb;
                              $wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
                              $wp_table_document = $wpdb->prefix.r4w_bdd_table_document;

                              $wp_select = "SELECT * from ".$wp_table_app;
                              $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

                              $wp_select = $wpdb->prepare("SELECT * FROM {$wp_table_document} WHERE post_id = %d",$pageChild->ID);
                              $r4w_document = $wpdb->get_row($wp_select,ARRAY_A);
                              $deploy_data = json_decode(hex2bin($r4w_document['deploy_data']),true);
                              
                              $nodeChild = [
                                   'data' => [
                                        'uuid' => $r4w_document['uuid'],
                                        'created' => $r4w_document['timecode'],
                                        'text' => $pageChild->post_title,
                                        'r4w_post_data' => [
                                             'ID' => $pageChild->ID,
                                             'post_parent' => $parent_post,
                                             'post_status' => $pageChild->post_status,
                                             'post_permalink'=> $related_permalink,
                                             'keywords' => [
                                                  'main' => $deploy_data['keywords']['main'],
                                                  'secondary' => $deploy_data['keywords']['secondary'],
                                                  'lexical' => $deploy_data['keywords']['lexical']
                                             ]
                                        ],
                                        "image" => $deploy_data['node']['image'],
                                        "imageTitle" => $deploy_data['node']['imageTitle'],
                                        "imageSize" => [
                                             "width" => $deploy_data['node']['imageSize']['width'],
                                             "height" => $deploy_data['node']['imageSize']['height'],
                                        ],
                                        "priority" => $deploy_data['node']['priority'],
                                        "background" => $deploy_data['node']['background'],
                                        "font-weight" => $deploy_data['node']['font-weight'],
                                        "font-size" => $deploy_data['node']['font-size'],
                                        "font-family" => $deploy_data['node']['font-family'],
                                        "color" => $deploy_data['node']['color'],
                                        "progress" => $deploy_data['node']['progress'],
                                        "note" => $deploy_data['node']['note'],
                                        "hyperlink" => $deploy_data['node']['hyperlink'],
                                        "hyperlinkTitle" => $deploy_data['node']['hyperlinkTitle']
                                   ],
                                   'children'  => [],
                              ];

                              /**
                               * Sous enfants appeler la même fonction courante
                               */
                              $nodeChild = r4w_child_pages($nodeChild, $fromPages, $root_id );

                              if( !array_key_exists( 'children',  $node ) || !is_array($node[ 'children' ] ) ){
                                   $node[ 'children' ] = [];
                              }
                              array_push( $node[ 'children' ], $nodeChild );
                         }
                    }
                    return $node;
               }
          }

     /**
      * Récupérer la structure des pages de wordpress
      */
          if ( ! function_exists( 'r4w_existing_pages' ) ) {
               function r4w_existing_pages(){
                    global $wp_query;
                    $all_wp_pages = $wp_query->query(['post_type' => 'page', 'posts_per_page' => '-1']);
                    $rootNode = r4w_home_pages();
                    $rootNode[ "root" ] = r4w_child_pages( $rootNode[ "root" ], $all_wp_pages, $rootNode[ "root" ][ "data" ][ "r4w_post_data" ][ "ID" ] );
                    return $rootNode;
               }
          }