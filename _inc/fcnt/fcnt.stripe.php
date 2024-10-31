<?php
	if ( ! function_exists( 'r4w_price_currency' ) ) {
		/**
		 * Retourn le prix dans le bon format en fonction de la monnaie
		 */
		function r4w_price_currency($a,$b) {
			if($a['onleft']) {
				return $a['symbol']. '<span class="amount">'.str_replace(',00', '',number_format($b/100, 2, ',', ' ')).'</span>';
			}else{
				return  '<span class="amount">'.str_replace(',00', '', number_format($b/100, 2, ',', ' '))."</span> ".$a['symbol'];
			}
		}
	}

	if ( ! function_exists( 'r4w_price_interval' ) ) {
		/**
		 * Retourn l'inerval d'un prix
		 */
		function r4w_price_interval($a,$b) {
			switch ($a) {
			    case "day":
			        return _('per day');
			        break;
			    case "week":
			        return _('per week');
			        break;
			    case "month":
			        return _('per month');
			        break;
			    case "year":
			        return _('per year');
			        break;
			}
		}
	}

	if ( ! function_exists( 'r4w_days_interval' ) ) {
		/**
		 * Retourn le nombre de jour par interval
		 */
		function r4w_days_interval($a,$b) {
			switch ($a) {
			    case "day":
			        return 1;
			        break;
			    case "week":
			        return 7;
			        break;
			    case "month":
			        return 30;
			        break;
			    case "year":
			        return 365;
			        break;
			}
		}
	}

	if ( ! function_exists( 'r4w_days_between_ts' ) ) {
		/**
		 * Retourn le nombre de jour entre deux timestamps
		 */
		function r4w_days_between_ts($a,$b) {
		    $c = $b - $a;
		    return round($c / 86400);
		}
	}

	if ( ! function_exists( 'r4w_card_clean' ) ) {
		/**
		 * Retourn le numéro de la card en minuscule et supprime les espaces
		 */
		function r4w_card_clean($a,$b) {
			$b = preg_replace('/\s*/', '', $a);
			return strtolower($b);
		}
	}