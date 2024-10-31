jQuery(document).ready(function(){  
	jQuery( "#btn_submit" ).on('click',function( event ) {
		jQuery('#r4w_error').html('');
		jQuery("#loading").show();
		jQuery("#btn_submit" ).hide();
		jQuery.post(ajaxurl,
			{
			  'action': 'r4w_exec_auth_register',
			  'r4w_user' : jQuery('#user').val(),
			  'r4w_pwd' : jQuery('#pwd').val(),
			  'r4w_repwd' : jQuery('#repwd').val()
 			},
			function(ac_result){
			  var ac_result = JSON.parse(ac_result);
			  if(ac_result.error){
				jQuery("#loading").hide();
				jQuery("#btn_submit" ).show();
			  	jQuery('#r4w_error').html('<div class="css-n9jk6">'+ac_result.error.description+'</div>');
			  }
			  if(ac_result.success){
			  	window.location = ac_result.success.url;
			  }
			}
		);
	});

  /**
   * Pointage vers api système
   */
    r4w_ping_system('r4w_auth_register');
});