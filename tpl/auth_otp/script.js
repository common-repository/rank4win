jQuery(document).ready(function(){
	jQuery('#r4w_auth_otp .r4w_digit_otp').find('input').each(function() {
		jQuery(this).attr('maxlength', 1);
		jQuery(this).on('keyup', function(e) {
			jQuery(this).val(jQuery(this).val().replace(/[^0-9\.]/g,''));
			var parent = jQuery(jQuery(this).parent());
			if(e.keyCode === 8 || e.keyCode === 37) {
				var prev = parent.find('input#' + jQuery(this).data('previous'));

				if(prev.length) {
					jQuery(prev).select();
				}
			} else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
				if(jQuery(this).val()!=''){
					var next = parent.find('input#' + jQuery(this).data('next'));
					console.log(next);
					if(next.length) {
						jQuery(next).select();
					} else {
						jQuery('button.btn_submit').trigger('click');
					}
				}
			}
		});
	});

	jQuery( ".btn_submit" ).on('click',function( event ) {
		var type_otp = jQuery('#r4w_auth_otp').attr('data-type');
		if(type_otp == 'email'){
			jQuery('#r4w_error').html('');
			jQuery("#loading").show();
			jQuery(".btn_submit" ).hide();

			jQuery.post(ajaxurl,
				{
				  'action': 'r4w_exec_auth_otp_email',
				  'r4w_otp_1' : jQuery('#otp_1').val(),
				  'r4w_otp_2' : jQuery('#otp_2').val(),
				  'r4w_otp_3' : jQuery('#otp_3').val(),
				  'r4w_otp_4' : jQuery('#otp_4').val()
	 			},
				function(ac_result){
				  var ac_result = JSON.parse(ac_result);
				  if(ac_result.error){
				  	if(ac_result.error.url){
				  		window.location = ac_result.error.url;
				  	}else{
						jQuery("#loading").hide();
						jQuery(".btn_submit" ).show();
					  	jQuery('#r4w_error').html('<div class="css-n9jk6">'+ac_result.error.description+'</div>');
				  	}
				  }
				  if(ac_result.success){
				  	window.location = ac_result.success.url;
				  }
				}
			);
		}
		if(type_otp == 'password'){
			var code_otp = jQuery('#r4w_auth_otp').attr('code-otp');
			if(!code_otp){
				jQuery('#box_otp #r4w_error').html('');
				jQuery("#box_otp #loading").show();
				jQuery("#box_otp .btn_submit" ).hide();
				jQuery.post(ajaxurl,
					{
					  'action': 'r4w_exec_auth_otp_password',
					  'r4w_otp_1' : jQuery('#otp_1').val(),
					  'r4w_otp_2' : jQuery('#otp_2').val(),
					  'r4w_otp_3' : jQuery('#otp_3').val(),
					  'r4w_otp_4' : jQuery('#otp_4').val()
		 			},
					function(ac_result){
					  var ac_result = JSON.parse(ac_result);
					  if(ac_result.error){
					  	if(ac_result.error.url){
					  		window.location = ac_result.error.url;
					  	}else{
							jQuery("#box_otp #loading").hide();
							jQuery("#box_otp .btn_submit" ).show();
						  	jQuery('#box_otp #r4w_error').html('<div class="css-n9jk6">'+ac_result.error.description+'</div>');
					  	}
					  }
					  if(ac_result.success){
					  	jQuery('#r4w_auth_otp').attr('code-otp', ac_result.success.code_otp);
					  	jQuery('#box_otp').hide();
					  	jQuery('#box_password').show();
					  }
					}
				);
			}else{
				jQuery('#box_password #r4w_error').html('');
				jQuery("#box_password #loading").show();
				jQuery("#box_password .btn_submit" ).hide();
				jQuery.post(ajaxurl,
					{
					  'action': 'r4w_exec_auth_otp_password',
					  'request': 'change_password',
					  'r4w_otp' : code_otp,
					  'r4w_pwd' : jQuery('#pwd').val(),
					  'r4w_repwd' : jQuery('#repwd').val()
		 			},
					function(ac_result){
					  var ac_result = JSON.parse(ac_result);
					  if(ac_result.error){
					  	if(ac_result.error.url){
					  		window.location = ac_result.error.url;
					  	}else{
							jQuery("#box_password #loading").hide();
							jQuery("#box_password .btn_submit" ).show();
						  	jQuery('#box_password #r4w_error').html('<div class="css-n9jk6">'+ac_result.error.description+'</div>');
					  	}
					  }
					  if(ac_result.success){
					  	window.location = ac_result.success.url;
					  }
					}
				);
			}
		}

	});

  /**
   * Pointage vers api système
   */
    r4w_ping_system('r4w_auth_otp');
});