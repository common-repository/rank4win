<?php
	if ( ! function_exists( 'r4w_callback_knowledge_type' ) ) {
		/**
		 * Retourn les resulats pour les tags
		 */ 
		function r4w_callback_knowledge_type($a){
			switch ($a) {
				case 'address':
					return '"@type": "PostalAddress"';
					break;
				case 'geo':
					return '"@type": "GeoCoordinates"';
					break;
				case 'contactPoint':
					return '"@type": "ContactPoint"';
					break;
				case 'aggregateRating':
					return '"@type": "aggregateRating"';
					break;
				case 'location':
					return '"@type": "Place"';
					break;
				case 'offers':
					return '"@type": "Offer"';
					break;
			}
		} 
	}