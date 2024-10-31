<?php
	if ( ! function_exists( 'r4w_display_links' ) ) {
		/**
		 * Verifie l'existance du "http" dans un lien
		 * ajoute les "http" en cas d'absence
		 */
		function r4w_display_links($a){
			if (!preg_match("~^(?:f|ht)tps?://~i", $a)) {
				$_rquest_scheme = "http://";
				if(r4w_is_ssl()){
					$_rquest_scheme = "https://";
				}
				return $_rquest_scheme.$a;
		    }else{
				return $a;
		    }
		}
	}