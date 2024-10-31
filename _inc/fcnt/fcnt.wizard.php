<?php
    if ( ! function_exists( 'r4w_wizard' ) ) {
		/**
		 * Redirection vers le système de wizard
		 */
			function r4w_wizard(){
                    global $wpdb;

                    $wp_table_app = $wpdb->prefix.r4w_bdd_table_app;
                    $wp_select = "SELECT * from ".$wp_table_app;
                    $r4w_app = $wpdb->get_row($wp_select,ARRAY_A);

                    if(!empty($r4w_app['wizard'])){
                         $wizard = json_decode(hex2bin($r4w_app['wizard']),true);
                         if(empty($wizard['step']) OR $wizard['step'] != 'finish'){
                              wp_redirect(get_admin_url('','admin.php?page=r4w_wizard'));
                              exit;
                         }
                    }
               }
     }