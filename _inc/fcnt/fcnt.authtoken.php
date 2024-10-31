<?php
	if ( ! function_exists( 'r4w_auth_token' ) ) {
		/**
		 * Retourn un token qui est enregistrer en session
		 * Il permet en autre d'autentifier des formulaires
		 */
		function r4w_auth_token($a) {
			$_SESSION["authenticity"]["token"]["$a"] = md5(time() . rand(1,100));
			return $_SESSION["authenticity"]["token"]["$a"];
		}
	}