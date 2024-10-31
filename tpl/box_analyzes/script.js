jQuery(document).ready(function(){
	jQuery(window).load(function(){
		/**
		 * Lance la première analyse une fois le document charger
		 */
		    r4w_analyzes('wp_auto');

		/**
		 * Vérifie si une modification est apporter
		 */
		 	// Modification du titre
			jQuery('#title').keyup(function(e) {
				r4w_analyzes( 'wp_title', e );
			});

			// Modification du titre (gutenberg)
			jQuery('body').on('keyup', "#post-title-0", function(e) {
				r4w_analyzes( 'wp_title_gutenberg', e );
			});

			// Modification du contenue
		    jQuery('textarea#content').keyup(function(e) {
				r4w_analyzes( 'wp_content', e );
		    });

		    // Modification du contenue (Bouton gras)
		    jQuery( 'body' ).on( 'click', '.mce-widget.mce-btn[aria-label="Bold"]', function(){
		        r4w_analyzes( 'wp_content', '' );
		    });

		    // Modification du contenue (Bouton paragraphe)
		    jQuery( 'body' ).on( 'click', ".mce-container-body .mce-menu-item", function(){
		        r4w_analyzes( 'wp_content', '' );
		    });

		    // Modification du contenue (Image)
		    jQuery( 'body' ).on( 'click', ".media-toolbar .media-button-select", function(){
		        r4w_analyzes( 'wp_content', '' );
		    });

		    // Effectue une première analyse
		    function r4w_start_analyzes(){
		    	jQuery( 'textarea#content' ).trigger( "keyup" );
		    }

			/**
			 * En cas de changement de l'état de éditeur (html/code)
			 */
			jQuery("#content-tmce").on( "click", function() {
				r4w_mark_clean();
			});
			jQuery("#content-html").on( "click", function() {
				r4w_mark_clean();
			});
	});

});


/**
 * Permet d'informer l'utilisateur lors de la copie du text
 */
	function setTooltip(e) {
	  jQuery(e).tooltip('hide')
	    .attr('data-original-title', 'Mot clé copier !')
	    .tooltip('show');
	}
	function hideTooltip() {
	  setTimeout(function() {
	    jQuery('button').tooltip('hide');
	  }, 1000);
	}

/**
 * Permet de copier le mot clé (lors du clique)
 */
	var clipboard = new ClipboardJS('.js-clipboard');
	clipboard.on('success', function(e) {
	  //setTooltip(e.trigger);
	  //hideTooltip();
	});

/**
 *  Permet d'afficher le score global en graphique
 */

	Chart.pluginService.register({
		beforeDraw: function (chart) {
			if (chart.config.options.elements.center) {
		        var ctx = chart.chart.ctx;
		        var centerConfig = chart.config.options.elements.center;
		      	var fontStyle = centerConfig.fontStyle || 'Arial';
				var txt = centerConfig.text;
		        var color = centerConfig.color || '#000';
		        var sidePadding = centerConfig.sidePadding || 20;
		        var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
		        ctx.font = "30px " + fontStyle;
		        var stringWidth = ctx.measureText(txt).width;
		        var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;
		        var widthRatio = elementWidth / stringWidth;
		        var newFontSize = Math.floor(30 * widthRatio);
		        var elementHeight = (chart.innerRadius * 2);
		        var fontSizeToUse = Math.min(newFontSize, elementHeight);
		        ctx.textAlign = 'center';
		        ctx.textBaseline = 'middle';
		        var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
		        var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
		        ctx.font = fontSizeToUse+"px " + fontStyle;
		        ctx.fillStyle = color;
		        ctx.fillText(txt, centerX, centerY);
			}
		}
	});
	var config = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: [100, 0],
				backgroundColor: [
				  "#ced4da",
				  "#ced4da"
				]
			}]
		},
		options: {
			legend: {
				onClick: null
			},
			tooltips: {enabled: false},
			hover: {mode: null},
			elements: {
				center: {
					text: '-',
					color: "#848484",
					fontStyle: 'Arial',
					sidePadding: 20
				}
			}
		}
	};
	var ctx = document.getElementById("OverallScoreDght").getContext("2d");
	var r4w_overallscore = new Chart(ctx, config);

/**
 * Permet de mettre à jour le score global
 */

	function overall_score($percent,$color) {
		var remaining_value = 100 - $percent;
		r4w_overallscore.data.datasets[0].data = [$percent, remaining_value];
		r4w_overallscore.data.datasets[0].backgroundColor = [$color, "#ced4da"];
		r4w_overallscore.options.elements.center.text = $percent+"%";
		r4w_overallscore.options.elements.center.color = $color;
		r4w_overallscore.update();
	}

	jQuery("body").on("click", "#r4w_box_advises .js-diary-show-details", function() {
		return jQuery(this).find("img").toggleClass("rotate-z")
	})
	/**
	* Permet d'ouvrire ou de fermer les ongles de l'analyses
	*/
	jQuery('body').on('click', "#r4w_box_advises .sc-row-space-between", function(e) {
		if(jQuery(this).hasClass('collapsed')){
			jQuery(this).removeClass('collapsed');
			jQuery(this).find('img').addClass('rotate-z');
			jQuery(this).parent().find('.diary-content__collapse').addClass('in');
		}else{
			jQuery(this).addClass('collapsed');
			jQuery(this).find('img').removeClass('rotate-z');
			jQuery(this).parent().find('.diary-content__collapse').removeClass('in');
		}
	});

	jQuery('body').on('click', "#edit_keyword_secondary", function(e) {
		jQuery('#r4w_box-keyword_secondary').modal();
	});
	jQuery('body').on('click', "#edit_keyword_lexical", function(e) {
		jQuery('#r4w_box-keyword_lexical').modal();
	});