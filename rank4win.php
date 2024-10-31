<?php
/*
 * Plugin Name:  Rank4win
 * Plugin URI:   https://rank4win.fr
 * Description:  Rank4Win is an ultra powerful new generation SEO tool & helps you multiply your traffic. All you need to reach the first page of Google! We created Rank4win, a WordPress SEO plugin, to make it easier for every website owner to build keyword strategy, to create a Semantic Structure to reinforce the natrual SEO of their site, to have help with Optimizing Content Writing and Enrichment lexicalment and semantically.
 * Version:      1.3.7
 * Author:       Rank4win
 * Author URI:   https://rank4win.fr
 * Text Domain:  app_rank4win
 * Domain Path:  /languages/
*/ 

    /**
     *  Quitter si on y accède directement
     */
        if ( ! defined( 'ABSPATH' ) ) {
            exit;
        }     
 
    /**
     * Récupération des constante définit
     */ 
        require_once("_inc/config.php");

     /**
     * Chargement des fichiers langue
     */
          function r4w_load_textdomain() {
               load_plugin_textdomain( 'app_rank4win', false, r4w_plugin_name. '/languages' );
          }
          add_action( 'init', 'r4w_load_textdomain' );

    /**
     * Récupération automatique des fonctions
     */
          foreach (glob( dirname(__FILE__)."/_inc/fcnt/fcnt.*.php") as $require_file) {
               if (is_file($require_file)) {
                    require_once($require_file);
               }
          }

    /**
     * Récupération automatique des librairies
     */
          foreach (glob( dirname(__FILE__)."/_inc/lib/*/lib.init.php") as $require_file) {
               if (is_file($require_file)) {
                    require_once($require_file);
               }
          }

    /**
     * Récupération automatique des class
     */
          foreach (glob( dirname(__FILE__)."/_inc/class/class.*.php") as $require_file) {
               if (is_file($require_file)) {
                    require_once($require_file);
               }
          }
