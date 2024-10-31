jQuery(document).ready(function(){
     jQuery( "#btn_next_step" ).on('click',function( event ) {
          jQuery( "#step_button #btn_next_step" ).hide();
          jQuery( "#step_button #loading" ).show();
          window.location = jQuery( "#box_wizard" ).attr("data-next");
     });

     jQuery( "#btn_use_cloud" ).on('click',function( event ) {
          jQuery("#r4w_box-cloud #loading").show();
          jQuery("#btn_use_cloud").hide();
          jQuery("#btn_use_wp").hide();
          jQuery.post(ajaxurl,
          {
               'action': 'r4w_exec_cloud_setting',
               'r4w_used': 'cloud',
          },
          function(ac_result){
               var ac_result = JSON.parse(ac_result);
               if(ac_result.success){
                    window.location = ac_result.success.url;
               }else{
                    jQuery.modal.close();
               }
          });
     });

     jQuery( "#btn_use_wp" ).on('click',function( event ) {
          jQuery("#r4w_box-cloud #loading").show();
          jQuery("#btn_use_cloud").hide();
          jQuery("#btn_use_wp").hide();
          jQuery.post(ajaxurl,
          {
               'action': 'r4w_exec_cloud_setting',
               'r4w_used': 'wordpress',
          },
          function(ac_result){
               var ac_result = JSON.parse(ac_result);
               if(ac_result.success){
                    window.location = ac_result.success.url;
               }else{
                    jQuery.modal.close();
               }
          });
     });

     /**
      * Changement de l'indexation du wordpress
      */
     jQuery("body.admin_page_r4w_wizard").on('change', "input[name='seo_settings_noindex']", function(){
       if(jQuery(this).is(':checked')){
         jQuery('.r4w_types_content_index').prop('checked', true);
       }else{
         jQuery('.r4w_types_content_index').prop('checked', false);
       }
     })
     /**
     * Vérifie les changements à enregistrer via autosave
     */
     jQuery(".r4w_autosave").bind("change", function(e) {
       var r4w_this = jQuery(this);
       var setting_update = jQuery(this).attr('name');
       var setting_value = jQuery(this).val();

       /**
        * Sauvegarde est en cours
        */
         if(r4w_this.hasClass("r4w_autosave_info")) {
           r4w_this.addClass('r4w_autosave_progress');
         }else{
           r4w_this.parents('.r4w_autosave_info').addClass('r4w_autosave_progress');
         }

       /**
        * Récupère la valeur d'un checkbox
        */
         if(r4w_this.is(':checkbox')){
           if(r4w_this.is(':checked')){
             var setting_value = 'on';
           }else{
             var setting_value = 'off';
           }
         }

         jQuery.post(ajaxurl,
           {
             'action': 'r4w_exec_settings',
             'setting_update': setting_update,
             'setting_value': setting_value
           },
           function(ac_result){
             var ac_result = JSON.parse(ac_result);
             if(ac_result.error){
             /**
              * Sauvegarde erreur
              */
              if(r4w_this.hasClass("r4w_autosave_info")) {
                r4w_this.removeClass('r4w_autosave_progress');
              }else{
                r4w_this.parents('.r4w_autosave_info').removeClass('r4w_autosave_progress');
              }
              r4w_notification_save('error');
             }
             if(ac_result.success){
             /**
              * Sauvegarde terminer
              */
              if(r4w_this.hasClass("r4w_autosave_info")) {
                r4w_this.removeClass('r4w_autosave_progress');
              }else{
                r4w_this.parents('.r4w_autosave_info').removeClass('r4w_autosave_progress');
              }
              r4w_notification_save('success');
             }

             }
         );

     });

});
