<?php
	if ( ! function_exists( 'r4w_define' ) ) {
		/**
		 * Gestion du define global
		 */
		function r4w_define(){
			$GLOBALS['r4w_define'] = [
				"app" => [
					"exempt_message" => [
						"rank4win_page_r4w_settings",
						"rank4win_page_r4w_account",
						"rank4win_page_r4w_helper",
						"admin_page_r4w_auth_login",
						"admin_page_r4w_auth_register",
						"admin_page_r4w_auth_wordpress",
						"admin_page_r4w_auth_otp",
						"admin_page_r4w_wizard"
					],
					"wordpress_oauth" => [
						"r4w_analysis",
						"r4w_tools",
						"r4w_account",
						"r4w_settings",
						"r4w_subscription",
						"r4w_helper"
					],
					"post_types" => [
						[
							"slug" => 'post',
							"column" => 'posts',
							"name" => __('Article')
						],
						[
							"slug" => "page",
							"column" => 'pages',
							"name" => __('Page')
						],
						[
							"slug" => "product",
							"column" => 'products',
							"name" => __('Product')
						],
						[
							"slug" => "portfolio",
							"column" => 'portfolio',
							"name" => __('Portfolio')
						]
					],
					"title_separator" => [
						"dash" => "-",
						"ndash" => "–",
						"mdash" => "—",
						"colon" => ":",
						"middot" => ".",
						"bull" => "•",
						"star" => "*",
						"smstar" => "⋆",
						"pipe" => "|",
						"tilde" => "~",
						"laquo" => "«",
						"raquo" => "»",
						"lt" => "<",
						"gt" => ">",
					],
					"twitter_card" => [
						[
							"slug" => 'with_image',
							"name" => __('Summarize with an image', 'app_rank4win')
						],
						[
							"slug" => 'without_image',
							"name" => __('Summarize without image', 'app_rank4win')
						]
					],
					"open_graph" => [
						"type" => [
							[
								"name" => __('Article', 'app_rank4win'),
								"og" => "article"
							],
							[
								"name" => __('Book', 'app_rank4win'),
								"og" => "book"
							],
							[
								"name" => __('Profile', 'app_rank4win'),
								"og" => "profile"
							],
							[
								"name" => __('Website', 'app_rank4win'),
								"og" => "website"
							]
						]
					],
					"knowledge_graph" => [
						"contact_type" => [
							"customer support" => __('Customer support', 'app_rank4win'),
							"technical support" => __('Technical support', 'app_rank4win'),
							"billing support" => __('Billing support', 'app_rank4win'),
							"bill payment" => __('Bill payment', 'app_rank4win'),
							"sales" => __('Sales', 'app_rank4win'),
							"reservations" => __('Reservations', 'app_rank4win'),
							"credit card support" => __('Credit card support', 'app_rank4win'),
							"emergency" => __('Emergency', 'app_rank4win'),
							"baggage tracking" => __('Baggage tracking', 'app_rank4win'),
							"roadside assistance" => __('Roadside assistance', 'app_rank4win'),
							"package tracking" => __('Package tracking', 'app_rank4win'),
						],
						"type" => [
							[
								"name" => __('Person', 'app_rank4win'),
								"slug" => "Person"
							],
							[
								"name" => __('Organization', 'app_rank4win'),
								"slug" => "Organization"
							],
							/*[
								"name" => __('Product', 'app_rank4win'),
								"slug" => "Product"
							],
							[
								"name" => __('Event', 'app_rank4win'),
								"slug" => "Event"
							],*/
							[
								"name" => __('Website', 'app_rank4win'),
								"slug" => "Website"
							]
						],
						"organization" => [
							[
								"name" => __('Organization', 'app_rank4win'),
								"slug" => "Organization"
							],
							[
								"name" => __('Corporation', 'app_rank4win'),
								"slug" => "Corporation"
							],
							[
								"name" => __('Educational Organization', 'app_rank4win'),
								"slug" => "EducationalOrganization"
							],
							[
								"name" => __('Government Organization', 'app_rank4win'),
								"slug" => "GovernmentOrganization"
							],
							[
								"name" => __('Non-Governmental Organization (NGO)', 'app_rank4win'),
								"slug" => "NGO"
							],
							[
								"name" => __('Performing Group', 'app_rank4win'),
								"slug" => "PerformingGroup"
							],
							[
								"name" => __('Sports Team', 'app_rank4win'),
								"slug" => "SportsTeam"
							]
						],
						"event" => [
							[
								"name" => __('Event', 'app_rank4win'),
								"slug" => "Event"
							],
							[
								"name" => __('Business Event', 'app_rank4win'),
								"slug" => "BusinessEvent"
							],
							[
								"name" => __('Childrens Event', 'app_rank4win'),
								"slug" => "ChildrensEvent"
							],
							[
								"name" => __('Comedy Event', 'app_rank4win'),
								"slug" => "ComedyEvent"
							],
							[
								"name" => __('Dance Event', 'app_rank4win'),
								"slug" => "DanceEvent"
							],
							[
								"name" => __('Educational Event', 'app_rank4win'),
								"slug" => "EducationEvent"
							],
							[
								"name" => __('Festival', 'app_rank4win'),
								"slug" => "Festival"
							],
							[
								"name" => __('Food Event', 'app_rank4win'),
								"slug" => "FoodEvent"
							],
							[
								"name" => __('Literary Event', 'app_rank4win'),
								"slug" => "LiteraryEvent"
							],
							[
								"name" => __('Music Event', 'app_rank4win'),
								"slug" => "MusicEvent"
							],
							[
								"name" => __('Sales Event', 'app_rank4win'),
								"slug" => "SaleEvent"
							],
							[
								"name" => __('Social Event', 'app_rank4win'),
								"slug" => "SocialEvent"
							],
							[
								"name" => __('Theater Event', 'app_rank4win'),
								"slug" => "TheaterEvent"
							],
							[
								"name" => __('User Interaction', 'app_rank4win'),
								"slug" => "UserInteraction"
							],
							[
								"name" => __('Visual Arts Event', 'app_rank4win'),
								"slug" => "VisualArtsEvent"
							]
						]
					],
				    "tag" => [
						/**
						 * PAGE : Basic config
						 */
						"basic_config" => [
							"title" => [
								[
									"name" => __('Date of publication', 'app_rank4win'),
									"tag" => "page_date"
								],
								[
									"name" => __('Title of the publication', 'app_rank4win'),
									"tag" => "page_title"
								],
								[
									"name" => __('Title of the parent page', 'app_rank4win'),
									"tag" => "parent_page_title"
								],
								[
									"name" => __('Name of the site', 'app_rank4win'),
									"tag" => "wp_name"
								],
								[
									"name" => __('Separator defined in the configuration', 'app_rank4win'),
									"tag" => "wp_separator"
								]
							],
							"description" => [
								[
									"name" => __('Slogan of the site', 'app_rank4win'),
									"tag" => "wp_slogan"
								],
								[
									"name" => __('Extract from the publication or auto-generated', 'app_rank4win'),
									"tag" => "page_content_generated"
								],
								[
									"name" => __('Extract from the publication without auto-generated', 'app_rank4win'),
									"tag" => "page_content"
								],
								[
									"name" => __('Modification time', 'app_rank4win'),
									"tag" => "page_time_update"
								],
								[
									"name" => __('Name of the site', 'app_rank4win'),
									"tag" => "wp_name"
								],
								[
									"name" => __('Separator defined in the configuration', 'app_rank4win'),
									"tag" => "wp_separator"
								]
							]
						],
						"basic_config_product" => [
							"title" => [
								[
									"name" => __('Product Name', 'app_rank4win'),
									"tag" => "product_name"
								],
								[
									"name" => __('Name of the site', 'app_rank4win'),
									"tag" => "wp_name"
								],
								[
									"name" => __('Separator defined in the configuration', 'app_rank4win'),
									"tag" => "wp_separator"
								]
							],
							"description" => [
								[
									"name" => __('Name of the site', 'app_rank4win'),
									"tag" => "wp_name"
								],
								[
									"name" => __('Separator defined in the configuration', 'app_rank4win'),
									"tag" => "wp_separator"
								]
							]
						],
						/**
						 * PAGE : Type contenu
						 */
						"type_contenu" => [
							"title" => [
								[
									"name" => __('Date of publication', 'app_rank4win'),
									"tag" => "page_date"
								],
								[
									"name" => __('Title of the publication', 'app_rank4win'),
									"tag" => "page_title"
								],
								[
									"name" => __('Title of the parent page', 'app_rank4win'),
									"tag" => "parent_page_title"
								],
								[
									"name" => __('Name of the site', 'app_rank4win'),
									"tag" => "wp_name"
								],
								[
									"name" => __('Separator defined in the configuration', 'app_rank4win'),
									"tag" => "wp_separator"
								]
							],
							"description" => [
								[
									"name" => __('Slogan of the site', 'app_rank4win'),
									"tag" => "wp_slogan"
								],
								[
									"name" => __('Extract from the publication or auto-generated', 'app_rank4win'),
									"tag" => "page_content_generated"
								],
								[
									"name" => __('Extract from the publication without auto-generated', 'app_rank4win'),
									"tag" => "page_content"
								],
								[
									"name" => __('Modification time', 'app_rank4win'),
									"tag" => "page_time_update"
								],
								[
									"name" => __('Name of the site', 'app_rank4win'),
									"tag" => "wp_name"
								],
								[
									"name" => __('Separator defined in the configuration', 'app_rank4win'),
									"tag" => "wp_separator"
								]
							]
						],
						/**
						 * PAGE : Taxonomy
						 */
						"taxonomy" => [
							"title" => [
								[
									"name" => __('Name of the site', 'app_rank4win'),
									"tag" => "wp_name"
								],
								[
									"name" => __('Separator defined in the configuration', 'app_rank4win'),
									"tag" => "wp_separator"
								]
							],
							"description" => [
							]
						],
						/**
						 * PAGE : Archives
						 */
						"authors_archives" => [
							"title" => [
								[
									"name" => __('Name of the author', 'app_rank4win'),
									"tag" => "author_name"
								],
								[
									"name" => __('author ID', 'app_rank4win'),
									"tag" => "author_id"
								],
								[
									"name" => __('Name of the site', 'app_rank4win'),
									"tag" => "wp_name"
								],
								[
									"name" => __('Separator defined in the configuration', 'app_rank4win'),
									"tag" => "wp_separator"
								]
							],
							"description" => [
								[
									"name" => __('Biographical information', 'app_rank4win'),
									"tag" => "author_bio"
								],
								[
									"name" => __('Name of the site', 'app_rank4win'),
									"tag" => "wp_name"
								],
								[
									"name" => __('Separator defined in the configuration', 'app_rank4win'),
									"tag" => "wp_separator"
								]
							]
						],
						"dates_archives" => [
							"title" => [
								[
									"name" => __('Date of the archive', 'app_rank4win'),
									"tag" => "archive_date"
								],
								[
									"name" => __('Name of the site', 'app_rank4win'),
									"tag" => "wp_name"
								],
								[
									"name" => __('Separator defined in the configuration', 'app_rank4win'),
									"tag" => "wp_separator"
								]
							],
							"description" => [
								[
									"name" => __('Date of the archive', 'app_rank4win'),
									"tag" => "archive_date"
								],
								[
									"name" => __('Name of the site', 'app_rank4win'),
									"tag" => "wp_name"
								],
								[
									"name" => __('Separator defined in the configuration', 'app_rank4win'),
									"tag" => "wp_separator"
								]
							]
						],
						/**
						 * PAGE : Special page search
						 */
						"special_page_search" => [
							[
								"name" => __('Search phrase', 'app_rank4win'),
								"tag" => "search_phrase"
							],
							[
								"name" => __('Wordpress name', 'app_rank4win'),
								"tag" => "wp_name"
							],
							[
								"name" => __('Separator', 'app_rank4win'),
								"tag" => "wp_separator"
							]
						],
						/**
						 * PAGE : Special page 404
						 */
						"special_page_404" => [
							[
								"name" => __('Wordpress name', 'app_rank4win'),
								"tag" => "wp_name"
							],
							[
								"name" => __('Separator', 'app_rank4win'),
								"tag" => "wp_separator"
							]
						],
						/**
						 * PAGE : RSS
						 */
						"rss" => [
							[
								"name" => __('Link to the authors archives', 'app_rank4win'),
								"tag" => "authors_link"
							],
							[
								"name" => __('Link to the publication', 'app_rank4win'),
								"tag" => "post_link"
							],
							[
								"name" => __('Link to the wordpress', 'app_rank4win'),
								"tag" => "wp_link"
							],
							[
								"name" => __('Link to the wordpress with the description', 'app_rank4win'),
								"tag" => "wp_link_desc"
							]
						]
				    ],
				    "dates" => [
						"monday" => __('Monday', 'app_rank4win'),
						"tuesday" => __('Tuesday', 'app_rank4win'),
						"wednesday" => __('Wednesday', 'app_rank4win'),
						"thursday" => __('Thursday', 'app_rank4win'),
						"friday" => __('Friday', 'app_rank4win'),
						"saturday" => __('Saturday', 'app_rank4win'),
						"sunday" => __('Sunday', 'app_rank4win')
					],
					"requires_sub" => [
						"msg" => '<div class="r4w_requires_subscription"> <div class="css-5d5fe0fe8f">'.r4w_assets_svg_code('star').'</div> <div class="css-d5f8grer6">'.__( 'This feature requires a subscription for is available', 'app_rank4win' ).'</div> </div>',
						"input" => 'disabled="disabled"'
					]
				]
			];
			global $r4w_define;
			return $r4w_define;
		}
	}
