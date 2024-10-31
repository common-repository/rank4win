jQuery(document).ready(function(){
	const r4w_sc_semantics = new SimpleBar(jQuery('#r4w_analyzes_semantics')[0], { autoHide: false });

	/**
	 * Semantique: Lance la function de recupération lors de l'ouverture de la modale
	 */
		jQuery('#r4w_box-analyzes_semantics').on(jQuery.modal.BEFORE_OPEN, function(event, modal) {
			 // Initalisation de la simplebar
			r4w_semantic(jQuery('#r4w_box-analyzes_semantics').attr("data-document"));
		});

	/**
	 * Semantique: Lance la function de recherche lors du clique
	 */
		jQuery('#btn_analyzes_semantics').on('click', function(event) {
			r4w_process_semantic(jQuery('#r4w_box-analyzes_semantics').attr("data-document"));
		});

	/**
	 * Semantique: Lance la recherche sémantique
	 */
	function r4w_process_semantic(a){
		jQuery('#r4w_analyzes_semantics .analyzes_semantics').html('<div class="ph-item"><div class="ph-box-semantic"><div class="ph_semantic"></div><div class="ph_semantic"></div><div class="ph_semantic"></div><div class="ph_semantic"></div><div class="ph_semantic"></div><div class="ph_semantic"></div><div class="ph_semantic"></div></div></div>');
		jQuery('#btn_analyzes_semantics').attr("disabled", true);

		new SimpleBar(jQuery('#r4w_analyzes_semantics')[0], { autoHide: false });
		r4w_sc_semantics.recalculate();

		jQuery.post(ajaxurl,
		{
			'action': 'r4w_exec_process',
			'r4w_request': 'semantic',
			'r4w_method': 'PUT',
			'r4w_document' : a,
		},
		function(ac_result){
			var ac_result = JSON.parse(ac_result);
			if(ac_result.error){
				jQuery.modal.close();
			}
			if(ac_result.success){
				var intervalId = setInterval(function(){
					jQuery.post(ajaxurl,
					{
						'action': 'r4w_exec_process',
						'r4w_request': 'semantic',
						'r4w_method' : 'GET',
						'r4w_process': ac_result.success.process
					},
					function(ac_result){
						var ac_result = JSON.parse(ac_result);
						if(ac_result.error){
							clearInterval(intervalId);
							jQuery.modal.close();
						}
						if(ac_result.success){
							if(ac_result.success.process == 'finish'){
								clearInterval(intervalId);
								r4w_semantic(a);
							}
						}
					});
				}, 1500);
			}
		});
	}

    /**
     * Semantique: Récupère la sémantique
     */
    	function r4w_semantic(a){
		jQuery('#r4w_analyzes_semantics .analyzes_semantics').html('<div class="ph-item"><div class="ph-box-semantic"><div class="ph_semantic"></div><div class="ph_semantic"></div><div class="ph_semantic"></div><div class="ph_semantic"></div><div class="ph_semantic"></div><div class="ph_semantic"></div><div class="ph_semantic"></div></div></div>');
		jQuery('#btn_analyzes_semantics').attr("disabled", true);
		new SimpleBar(jQuery('#r4w_analyzes_semantics')[0], { autoHide: false });
		r4w_sc_semantics.recalculate();
		jQuery.post(ajaxurl,
		{
			'action': 'r4w_exec_analyzes_semantic',
			'r4w_document': a
		},
		function(ac_result){
			jQuery('#btn_analyzes_semantics').attr("disabled", false);
			var ac_result = JSON.parse(ac_result);
			if(ac_result.error){
				jQuery('#r4w_analyzes_semantics').html("");
			}
			if(ac_result.success){
				if(ac_result.success.semantics == '' || ac_result.success.semantics == null ){
					jQuery('#r4w_analyzes_semantics .analyzes_semantics').html("");
				}else{
					var result = ac_result.success.semantics.h2b();
					if(result){
						var output_semantic = result.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
							return localize_box_semantic[contents];
						});
						jQuery('#r4w_analyzes_semantics .analyzes_semantics').html(output_semantic);
					}else{
						jQuery('#r4w_analyzes_semantics .analyzes_semantics').html("");
					}
				}
				new SimpleBar(jQuery('#r4w_analyzes_semantics')[0], { autoHide: false });
				r4w_sc_semantics.recalculate();
			}
		});
	}

});