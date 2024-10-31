<?php
     if ( ! function_exists( 'r4w_fcnt_uuid' ) ) {
          /**
          * Génération d'un identifiant unique universel
          */
          function r4w_fcnt_uuid() {
               return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
               mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
               mt_rand( 0, 0xffff ),
               mt_rand( 0, 0x0fff ) | 0x4000,
               mt_rand( 0, 0x3fff ) | 0x8000,
               mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
               );
          }
     }

     if ( ! function_exists( 'r4w_fcnt_uuid_activation' ) ) {
          /**
          * Génération d'un identifiant unique universel pour l'activation
          */
          function r4w_fcnt_uuid_activation() {
               return sprintf( '%04x%04x-%04x-%04x-%04x%04x%04x-%04x-%04x-%04x%04x%04x',
               mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
               mt_rand( 0, 0xffff ),
               mt_rand( 0, 0x0fff ) | 0x4000,
               mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
               mt_rand( 0, 0xffff ),
               mt_rand( 0, 0x3fff ) | 0x8000,
               mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
               );
          }
     }