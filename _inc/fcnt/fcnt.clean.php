<?php
	if ( ! function_exists( 'r4w_unwanted_tag' ) ) {
		/**
		 * Effectue du nettoyage
		 */
			function r4w_unwanted_tag($a){
			    $shotcodes_tags = array( 'vc_', 'nectar_','tabbed_','tab', 'divider','rev_' );
			    return preg_replace( '/\[(\/?(' . implode( '|', $shotcodes_tags ) . ').*?(?=\]))\]/', '', $a );
			}
	}

	if ( ! function_exists( 'r4w_clean_temps' ) ) {
		/**
		 * Permet de nettoyer le dossier temporaire de rank4win
		 */
		function r4w_clean_temps(){
               $target_dir = r4w_plugin_base.'/temp/';
               if (file_exists($target_dir)) {
                    $tmp_files = glob($target_dir.'*');
                    foreach($tmp_files as $tmp_file){
                         if(is_file($tmp_file)){
                              unlink($tmp_file);
                         }
                    }
               }
		}
	}