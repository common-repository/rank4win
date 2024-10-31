jQuery( "form" ).submit(function( event ) {
	jQuery("#loading").show();
	jQuery("button[type='submit']").hide();
 	//jQuery("form").submit();
});
jQuery(document).ready(function(){  

  /**
   * Pointage vers api système
   */
    r4w_ping_system('r4w_auth_wordpress');
});