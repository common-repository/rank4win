<?php 
	if ( ! function_exists( 'r4w_assets_svg_code' ) ) {
		/**
		 * Permet de récuperer le contenu d'un fichier svg
		 */
		function r4w_assets_svg_code($a){
			return file_get_contents(r4w_plugin_folder.'/assets/svg/'.$a.'.svg');
		}
	}