jQuery(document).ready(function(){
	const r4w_sc_answer = new SimpleBar(jQuery('#r4w_analyzes_answer')[0], { autoHide: false });

	/**
	 * Questionnements: Lance la function de recherche lors de l'ouverture de la modale
	 */
		jQuery('#r4w_box-analyzes_answer').on(jQuery.modal.BEFORE_OPEN, function(event, modal) {
			// Initalisation de la simplebar
			r4w_process_answer(jQuery('#r4w_box-analyzes_answer').attr("document_uuid"));
		});

	/**
	 * Questionnements: Lance la recherche des questionnements
	 */
		function r4w_process_answer(a){
			jQuery('#r4w_analyzes_answer .analyzes_answer').html('<div class="ph-item"> <div class="ph-box-answer"><div class="ph_answer"></div><div class="ph_answer"></div><div class="ph_answer"></div><div class="ph_answer"></div><div class="ph_answer"></div><div class="ph_answer"></div></div></div>');
			new SimpleBar(jQuery('#r4w_analyzes_answer')[0], { autoHide: false });
			r4w_sc_answer.recalculate();
			jQuery.post(ajaxurl,
			{
				'action': 'r4w_exec_process',
				'r4w_request': 'answers',
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
							'r4w_request': 'answers',
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
									r4w_answer(a);
								}
							}
						});
					}, 1500);
				}
				new SimpleBar(jQuery('#r4w_analyzes_answer')[0], { autoHide: false });
				r4w_sc_answer.recalculate();
			});
		}

    /**
     * Questionnements: Récupère les questionnements
     */
		function r4w_answer(a){
			jQuery.post(ajaxurl,
			{
				'action': 'r4w_exec_analyzes_answer',
				'r4w_document': a
			},
			function(ac_result){
				var ac_result = JSON.parse(ac_result);
				if(ac_result.error){}
				if(ac_result.success){
					var answers = ac_result.success.answers.h2b();
					if(answers != null){
						var result_answers = ac_result.success.answers.h2b();
						var output_answers = result_answers.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
							return localize_box_answer[contents];
						});
						jQuery('#r4w_analyzes_answer .analyzes_answer').html(output_answers);
					}else{
						jQuery('#r4w_analyzes_answer .analyzes_answer').html('<div id="answers_empty" class="answers_empty"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 490 490" xml:space="preserve" ><g><g> <path d="M480,54.99H10c-5.523,0-10,4.477-10,10v360.02c0,5.523,4.477,10,10,10h470c5.522,0,10-4.477,10-10V64.99 C490,59.467,485.522,54.99,480,54.99z M470,74.99v48.077H20V74.99H470z M20,415.01V143.067h450V415.01H20z"></path> <g> <path d="M62.574,109.028h5.5c5.522,0,10-4.476,10-10c0-5.522-4.478-10-10-10h-5.5c-5.522,0-10,4.478-10,10 C52.574,104.552,57.052,109.028,62.574,109.028z"></path> <path d="M103.741,109.028h5.5c5.522,0,10-4.476,10-10c0-5.522-4.478-10-10-10h-5.5c-5.523,0-10,4.478-10,10 C93.741,104.552,98.219,109.028,103.741,109.028z"></path> <path d="M144.908,109.028h5.5c5.522,0,10-4.476,10-10c0-5.522-4.478-10-10-10h-5.5c-5.523,0-10,4.478-10,10 C134.908,104.552,139.386,109.028,144.908,109.028z"></path> </g> <path d="M338.354,243.361c-2.843-20.132-18.031-36.885-37.795-41.688c-5.361-1.302-10.774,1.989-12.078,7.355 c-1.305,5.366,1.988,10.774,7.355,12.079c11.878,2.887,21.006,12.953,22.715,25.05c0.705,4.995,4.985,8.604,9.889,8.604 c0.466,0,0.938-0.033,1.411-0.1C335.32,253.89,339.127,248.83,338.354,243.361z"></path> <path d="M359.357,306.206c12.141-15.35,19.398-34.732,19.398-55.779c0-49.668-40.408-90.076-90.077-90.076 c-49.668,0-90.076,40.408-90.076,90.076c0,49.669,40.408,90.077,90.076,90.077c21.429,0,41.131-7.526,56.61-20.068l83.468,77.752 c1.927,1.795,4.373,2.683,6.814,2.683c2.678,0,5.35-1.069,7.319-3.184c3.765-4.041,3.54-10.369-0.501-14.133L359.357,306.206z M218.602,250.427c0-38.641,31.437-70.076,70.076-70.076c38.641,0,70.077,31.436,70.077,70.076 c0,38.641-31.436,70.077-70.077,70.077C250.039,320.504,218.602,289.067,218.602,250.427z"></path> </g></g> </svg>'+localize_box_analyzes.ans_noresult+'</div>');
					}
				}
				jQuery('#r4w_analyzes_answer').on('click', '.js-diary-show-details', function(){
					if(jQuery(this).parent().hasClass('open_details')){
						jQuery(this).parent().removeClass('open_details');
						jQuery(this).parent().find('img').removeClass('rotate-z');
						jQuery(this).parent().find('.list_document_answers').hide();
						var height_cal = jQuery(".analyzes_answer").height();
						jQuery("#r4w_analyzes_answer").height(height_cal);
					}else{
						jQuery(this).parent().addClass('open_details');
						jQuery(this).parent().find('img').addClass('rotate-z');
						jQuery(this).parent().find('.list_document_answers').show();
						var height_cal = jQuery(".analyzes_answer").height();
						jQuery("#r4w_analyzes_answer").height(height_cal);
					}
				});
			});
		}
});