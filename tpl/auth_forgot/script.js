jQuery(document).ready(function(){  
	jQuery( "#btn_submit" ).on('click',function( event ) {
		jQuery('#r4w_error').html('');
		jQuery("#loading").show();
		jQuery("#btn_submit" ).hide();
		jQuery.post(ajaxurl,
			{
			  'action': 'r4w_exec_auth_forgot',
			  'r4w_user' : jQuery('#user').val()
 			}, 
			function(ac_result){
			  var ac_result = JSON.parse(ac_result);
			  if(ac_result.error){
			  	if(ac_result.error.url){
			  		window.location = ac_result.error.url;
			  	}else{
					jQuery("#loading").hide();
					jQuery("#btn_submit" ).show();
				  	jQuery('#r4w_error').html('<div class="css-n9jk6">'+ac_result.error.description+'</div>');
			  	}
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
    r4w_ping_system('r4w_auth_forgot');
});