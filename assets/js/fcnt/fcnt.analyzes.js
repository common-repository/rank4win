/**
 * Effectue l'analyses du document
 */
	function r4w_analyzes(a,e,t = null){
		r4w_mark_clean();
		if(a == 'wp_title'){
			 var wp_data = jQuery('#title').val();
		}
		if(a == 'wp_title_gutenberg'){
			var wp_data = wp.data.select('core/editor').getEditedPostAttribute('title');
		}
		if(a == 'wp_content'){
			//$content = wp.data.select('core/editor').getEditedPostAttribute('content');
			var targetId = e.target.id;
			if(t != null){
				if ( tinymce && tinymce.activeEditor ){
					var wp_data = tinymce.activeEditor.getContent();
				}
			}else{
				switch ( targetId ) {
					case 'content':
						var wp_data = jQuery('#content').val();
					break;
					case 'tinymce':
						if ( tinymce && tinymce.activeEditor ){
							var wp_data = tinymce.activeEditor.getContent();
						}
					break;
					default:
						if ( tinymce && tinymce.activeEditor ){
							var wp_data = tinymce.activeEditor.getContent();
						}
					break;
				}
			}
		}
		if(a == "wp_auto" ){
			if ( tinymce && tinymce.activeEditor ){
				var wp_content = tinymce.activeEditor.getContent();
			}else{
				var wp_content = jQuery('#content').val();
			}
			var wp_title = jQuery('#title').val();
		}
		r4w_exec_daily(function(){
			if(a != null){
				jQuery('#bb3a1009-ccd2-42cf-bc4b-6c9575c23a0f').addClass('analyzes_progress');
				jQuery('#f7800021-8ed7-4c07-bc5c-f62b050549f6').addClass('analyzes_progress');
			}
		    jQuery.post(ajaxurl,
		      {
		        'action': 'r4w_exec_analyzes',
		        'wp_update': a,
		        'wp_data': wp_data,
		        'wp_title': wp_title,
		        'wp_content': wp_content,
		        'wp_post_id': jQuery('#r4w_box_analyzes').attr('wp-post-id')
		      },
		      function(ac_result){
		      	jQuery('#bb3a1009-ccd2-42cf-bc4b-6c9575c23a0f').removeClass('analyzes_progress');
		      	jQuery('#f7800021-8ed7-4c07-bc5c-f62b050549f6').removeClass('analyzes_progress');
		      	var ac_result = JSON.parse(ac_result);
		      	if(ac_result.success){

			      	var result_extra = ac_result.success.extra.h2b();
			      	var output_extra = result_extra.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
			      		return localize_fcnt_analyzes[contents];
			      	});

			      	jQuery('#ac708114-e5d2-4fb7-b379-7bfe84109722 #r4w_box_extra').html(output_extra);

			      	var result_overall = ac_result.success.overall.h2b();
			      	var output_overall = result_overall.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
			      		return localize_fcnt_analyzes[contents];
			      	});

			      	jQuery('#f7800021-8ed7-4c07-bc5c-f62b050549f6 #r4w_box_overall').html(output_overall);

			      	var result_advises = ac_result.success.advises.h2b();
			      	var output_advises = result_advises.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
			      		return localize_fcnt_analyzes[contents];
			      	});
			      	jQuery('#bb3a1009-ccd2-42cf-bc4b-6c9575c23a0f #r4w_box_advises').html(output_advises);

			      	if(ac_result.success.score != null){
				      	var score_percent = ac_result.success.score.percent;
				      	var score_color = ac_result.success.score.per_color;
				      	var score_progress = ac_result.success.score.progress;
				      }else{
				      	var score_percent = 0;
				      	var score_color = "#444";
				      	var score_progress = "";
				      }
					jQuery('#f7800021-8ed7-4c07-bc5c-f62b050549f6 #box_overall_score').show();
					jQuery('#f7800021-8ed7-4c07-bc5c-f62b050549f6 #box_overall_score').addClass(score_progress);
					overall_score(score_percent,score_color);

					jQuery('.eye_search').on( "click", function() {
						var eye_info = jQuery(this).attr('r4w_eye_info');
						var eye_search = jQuery(this).attr('r4w_eye_search')
						if(jQuery(this).hasClass('active')){
							r4w_mark_clean();
						}else{
							r4w_mark_clean();
							jQuery(this).addClass('active');
							var options = {
								"element": "r4w_mark_cnt",
								"separateWordSearch": false,
								"diacritics": false,
								"caseSensitive": false,
								"exclude": [],
								"iframes": true,
								"iframesTimeout": 5000,
								"each": function(node){
							        jQuery(node).prepend('<span class="r4w_mark_info">'+eye_info+'</span>');
							    }
							};
							jQuery("#content_ifr").contents().find("body").mark(eye_search, options);
						}
					});

					var result_advises = ac_result.success.title.h2b();
			      	var output_title = result_advises.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
			      		return localize_fcnt_analyzes[contents];
			      	});
					jQuery('#aab85762-8b8b-45ba-8851-21119dd6248f #r4w_box_title').html(output_title);
				}
				if(ac_result.error){
					if(ac_result.error.name == "document_invalid"){
						window.location = ac_result.error.url;
					}
					if(ac_result.error.name == "browser_refresh"){
						var error_html = '<div id="box_error_analyse"><div class="css-sdf5gf05e">'+localize_fcnt_analyzes.svg_wrench+'</div><div class="css-dregere450">'+localize_fcnt_analyzes.error_maintenance_titre+'</div><div class="css-df4oiu80d">'+localize_fcnt_analyzes.error_maintenance_cnt+'.</div></div>';
					}
					if(ac_result.error.name == "strange_data"){
						var error_html = '<div id="box_error_analyse"><div class="css-sdf5gf05e">'+localize_fcnt_analyzes.svg_not_touch+'</div><div class="css-dregere450">'+localize_fcnt_analyzes.error_strange_titre+'</div><div class="css-df4oiu80d">'+localize_fcnt_analyzes.error_strange_cnt+'.</div></div>';
					}
					jQuery('#f7800021-8ed7-4c07-bc5c-f62b050549f6 #r4w_box_overall').html(error_html);
					jQuery('#bb3a1009-ccd2-42cf-bc4b-6c9575c23a0f #r4w_box_advises').html(error_html);
					jQuery('#aab85762-8b8b-45ba-8851-21119dd6248f #r4w_box_title').html('');
				}
		      }
	    	);
		});
    }
/**
 * Permet de mettre une durée avant de continuer
 */
	var r4w_exec_daily = (function(){
	  var app_timer = 0;
	  return function(callback){
	  var app_ms = 650;
	    clearTimeout (app_timer);
	    app_timer = setTimeout(callback, app_ms);
	  };
	})();

/**
 * Permet de supprimer les balise rajouter par rank4win
 */
	function r4w_mark_clean(){
		jQuery('.eye_search').removeClass('active');
		jQuery("#content_ifr").contents().find("body span.r4w_mark_info").remove();
		jQuery("#content_ifr").contents().find("body").unmark();
	}