<?php
	if ( ! function_exists( 'r4w_f_day' ) ) {
		/**
		 * Retourne le jour dans la langues
		 */ 
		function r4w_f_day($a){
			switch ($a) {
			    case "Monday":
			        return __('Monday', 'app_rank4win' );
			        break;
			    case "Tuesday":
			        return __('Tuesday', 'app_rank4win' );
			        break;
			    case "Wednesday":
			        return __('Wednesday', 'app_rank4win' );
			        break;
			    case "Thursday":
			        return __('Thursday', 'app_rank4win' );
			        break;
			    case "Friday":
			        return __('Friday', 'app_rank4win' );
			        break;
			    case "Saturday":
			        return __('Saturday', 'app_rank4win' );
			        break;
			    case "Sunday":
			        return __('Sunday', 'app_rank4win' );
			        break;
			}
		}
	}

	if ( ! function_exists( 'r4w_f_months' ) ) {
		/**
		 * Retourne le mois dans la langues
		 */
		function r4w_f_months($a){
			switch ($a) {
			    case "January":
			        return __('January', 'app_rank4win' );
			        break;
			    case "February":
			        return __('February', 'app_rank4win' );
			        break;
			    case "March":
			        return __('March', 'app_rank4win' );
			        break;
			    case "April":
			        return __('April', 'app_rank4win' );
			        break;
			    case "May":
			        return __('May', 'app_rank4win' );
			        break;
			    case "June":
			        return __('June', 'app_rank4win' );
			        break;
			    case "July":
			        return __('July', 'app_rank4win' );
			        break;
			    case "August":
			        return __('August', 'app_rank4win' );
			        break;
			    case "September":
			        return __('September', 'app_rank4win' );
			        break;
			    case "October":
			        return __('October', 'app_rank4win' );
			        break;
			    case "November":
			        return __('November', 'app_rank4win' );
			        break;
			    case "December":
			        return __('December', 'app_rank4win' );
			        break;
			}
		}
	}

	if ( ! function_exists( 'r4w_date_format_timezone' ) ) {
		/**
		 * Affiche la date en fonction de la langue
		 */
		function r4w_date_format_timezone($a){
			return date_i18n( get_option('date_format'), $a );
		}
	}

	if ( ! function_exists( 'r4w_datetime_format_timezone' ) ) {
		/**
		 * Affiche la date et l'heure en fonction de la langue
		 */
		function r4w_datetime_format_timezone($a){
			return date_i18n( get_option('date_format'), $a, current_time('timestamp') );
		}
	}