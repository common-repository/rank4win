<?php
	if ( ! function_exists( 'r4w_is_ssl' ) ) {
		/**
		 * Vérifie si le serveur est en HTTPS
		 */
		function r4w_is_ssl(){
               if ( isset( $_SERVER['HTTPS'] ) ) {
                   if ( 'on' == strtolower( $_SERVER['HTTPS'] ) ) {
                       return true;
                   }
                   if ( '1' == $_SERVER['HTTPS'] ) {
                       return true;
                   }
               } elseif ( isset( $_SERVER['SERVER_PORT'] ) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
                   return true;
               }
               return false;
          }
     }
