/**
 * Effectue un pointage aurpès de api
 */
  function r4w_ping_system(a){
    jQuery.post(ajaxurl,
      {
        'action': 'r4w_exec_ping_system',
        'r4w_tpl': a
      },
      function(ac_result){
        var ac_result = JSON.parse(ac_result);
        if(ac_result.error){
        }
        if(ac_result.success){
          if(ac_result.success.msg != null){
            jQuery('#r4w_system_message').html(ac_result.success.msg.h2b());
          }
          if(ac_result.success.url != null){
            window.location = ac_result.success.url;
          }
        }
      }
    );
  }