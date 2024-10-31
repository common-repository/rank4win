/**
 * Vérifie le status d'un déploiement
 */
     function r4w_process_deploy(){
          jQuery.post(ajaxurl,
          {
                'action': 'r4w_exec_deploy'
          },
          function(ac_result){
                var ac_result = JSON.parse(ac_result);
                if(ac_result.error){
                }
                if(ac_result.success){
                     if(ac_result.success.deploy == 'in_progress'){
                         setTimeout(function(){ r4w_process_deploy(1); }, 10000)
                     }else{
                         jQuery('#r4w_warning_deploy').hide();
                     }
                }
          }
          );
     }