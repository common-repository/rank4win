<?php
	/**
	 * Définie l'application
	 */
		define("r4w_plugin_name", basename(dirname(__DIR__)));
		define("r4w_plugin_url", plugins_url(basename(dirname(__DIR__)).'/'));
		define("r4w_plugin_base", dirname(__DIR__));
		define("r4w_plugin_file", dirname(__DIR__).'/'.basename(dirname(__DIR__)).'.php');
		define("r4w_plugin_folder", dirname(__DIR__));
		define("r4w_shortcode_sister_page_link", "r4w_sc_sister_pages_link");

	/**
	 * Base de donnée
	 */
		define("r4w_bdd_table_app", "rank4win_app");
		define("r4w_bdd_table_document", "rank4win_document");
		define("r4w_bdd_table_taxonomy", "rank4win_taxonomy");
		define("r4w_bdd_table_strategy", "rank4win_strategy");
		define("r4w_bdd_table_process", "rank4win_process");

	/**
	 * Rank4win appel
	 */
		define("r4w_api_url_base", "https://ws.r4w.fr/");
		define("r4w_api_url_request", "/api");
		define("r4w_api_api_key", "572335d3-dd0f-4550-81cd-ec8ff4807e6f");