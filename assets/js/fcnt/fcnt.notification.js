/**
 * Affiche une notification [Sauvegarde]
 */
  function r4w_notification_save($a){
    if($a == 'error'){
      jQuery('#r4w_notificationBlock').dangerNotification(localize_fcnt_notification.saved_failed_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.saved_failed_title+ ' :'}, function () {
      });
    }
    if($a == 'success'){
      jQuery('#r4w_notificationBlock').successNotification(localize_fcnt_notification.saved_successfully_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.saved_successfully_title+ ' :'}, function () {
      });
    }
  }
  function r4w_notification_file($a){
    if($a == 'error'){
      jQuery('#r4w_notificationBlock').dangerNotification(localize_fcnt_notification.file_failed_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.file_failed_title+ ' :'}, function () {
      });
    }
    if($a == 'success'){
      jQuery('#r4w_notificationBlock').successNotification(localize_fcnt_notification.file_successfully_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.file_successfully_title+ ' :'}, function () {
      });
    }
  }
  function r4w_notification_reset($a){
    if($a == 'error'){
      jQuery('#r4w_notificationBlock').dangerNotification(localize_fcnt_notification.reset_failed_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.reset_failed_title+ ' :'}, function () {
      });
    }
    if($a == 'success'){
      jQuery('#r4w_notificationBlock').successNotification(localize_fcnt_notification.reset_successfully_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.reset_successfully_title+ ' :'}, function () {
      });
    }
  }
  function r4w_notification_import($a){
    if($a == 'error'){
      jQuery('#r4w_notificationBlock').dangerNotification(localize_fcnt_notification.import_failed_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.import_failed_title+ ' :'}, function () {
      });
    }
    if($a == 'success'){
      jQuery('#r4w_notificationBlock').successNotification(localize_fcnt_notification.import_successfully_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.import_successfully_title+ ' :'}, function () {
      });
    }    
  }
  function r4w_notification_strategy_add($a){
    if($a == 'error'){
      jQuery('#r4w_notificationBlock').dangerNotification(localize_fcnt_notification.strategy_add_failed_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.strategy_add_failed_title+ ' :'}, function () {
      });
    }
    if($a == 'success'){
      jQuery('#r4w_notificationBlock').successNotification(localize_fcnt_notification.strategy_add_successfully_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.strategy_add_successfully_title+ ' :'}, function () {
      });
    }    
  }
  function r4w_notification_strategy_remove($a){
    if($a == 'error'){
      jQuery('#r4w_notificationBlock').dangerNotification(localize_fcnt_notification.strategy_remove_failed_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.strategy_remove_failed_title+ ' :'}, function () {
      });
    }
    if($a == 'success'){
      jQuery('#r4w_notificationBlock').successNotification(localize_fcnt_notification.strategy_remove_successfully_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.strategy_remove_successfully_title+ ' :'}, function () {
      });
    }    
  }
  function r4w_notification_strategy_title($a){
    if($a == 'error'){
      jQuery('#r4w_notificationBlock').dangerNotification(localize_fcnt_notification.strategy_title_failed_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.strategy_title_failed_title+ ' :'}, function () {
      });
    }
    if($a == 'success'){
      jQuery('#r4w_notificationBlock').successNotification(localize_fcnt_notification.strategy_title_successfully_cnt, {stickMode: false, textPrefix: localize_fcnt_notification.strategy_title_successfully_title+ ' :'}, function () {
      });
    }    
  }