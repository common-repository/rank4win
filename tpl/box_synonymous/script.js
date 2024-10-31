jQuery(document).ready(function(){
	const r4w_sc_synonymous = new SimpleBar(jQuery('#r4w_analyzes_synonymous')[0], { autoHide: false });

	/**
	 * Synonyme: Lance la function de recherche
	 */
		jQuery('#btn_synonymous').on('click', function(event) {
			r4w_process_semantic(jQuery('#r4w_box-analyzes_synonymous').attr("data-document"),jQuery('#r4w_synonymous_word').val());
		});

		jQuery('#r4w_box-analyzes_synonymous').on('keyup','#r4w_synonymous_word',function(e){
			if(e.keyCode == 13)
			{
				r4w_process_semantic(jQuery('#r4w_box-analyzes_synonymous').attr("data-document"),jQuery('#r4w_synonymous_word').val());
			}
		});

	/**
	 * Synonyme: Lance la recherche de synonymes
	 */
		function r4w_process_semantic(a,b){
			jQuery('#btn-synonymous').addClass("disabled");
			jQuery('#r4w_analyzes_synonymous .analyzes_synonymous').html('<div class="ph-item"><div class="ph-box-syn_request"><div class="ph_syn_request"></div></div></div><div class="ph-item"><div class="ph-box-syn_result"><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div><div class="ph_syn_result"></div></div></div>');

			new SimpleBar(jQuery('#r4w_analyzes_synonymous')[0], { autoHide: false });
			r4w_sc_synonymous.recalculate();

			jQuery.post(ajaxurl,
			{
				'action': 'r4w_exec_process',
				'r4w_request': 'synonymous',
				'r4w_method': 'PUT',
				'r4w_document' : a,
				'r4w_word' : b
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
							'r4w_request': 'synonymous',
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
									r4w_synonymous(a,b);
								}
							}
						});
					}, 1500);
				}
				new SimpleBar(jQuery('#r4w_analyzes_synonymous')[0], { autoHide: false });
				r4w_sc_synonymous.recalculate();
			});
		}

    /**
     * Synonyme: Récupère les synonymes
     */
    	function r4w_synonymous(a,b){
		jQuery.post(ajaxurl,
		{
			'action': 'r4w_exec_analyzes_synonymous',
			'r4w_document': a,
			'r4w_word': b
		},
		function(ac_result){
			jQuery('#btn-synonymous').removeClass("disabled");
			var ac_result = JSON.parse(ac_result);
			if(ac_result.error){
				jQuery('#r4w_analyzes_synonymous .analyzes_synonymous').html("");
			}
			if(ac_result.success){
				var rc_result = ac_result.success.syn_result.h2b();
				var output_result = rc_result.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
					return localize_box_synonymous[contents];
				});
				if(rc_result != null){
					jQuery('#r4w_analyzes_synonymous .analyzes_synonymous').html(output_result);
				}else{
					jQuery('#r4w_analyzes_synonymous .analyzes_synonymous').html('<div id="synonymous_empty" class="synonymous_empty">'+localize_box_analyzes.syn_noresult+'</div>');
				}
			}
		});
	}
});