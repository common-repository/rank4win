jQuery(document).ready(function(){  
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
      }
    );
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
      }
    );
	});   

  /**
   * Editeur de fichier
   */
  jQuery("#r4w_st_page_file_editor .btn_editor").on('click',function( event ) {
    jQuery("#r4w_st_page_file_editor #loading").show();
    jQuery("#r4w_st_page_file_editor .btn_editor").hide();
    var task = jQuery(this).attr('id');
    var file_cnt = jQuery(this).closest('.page_subtab').find('textarea').val();
    jQuery.post(ajaxurl,
      {
        'action': 'r4w_exec_tool_editor_files',
        'file_cnt': file_cnt,
        'task': task,
      },
      function(ac_result){
        jQuery("#r4w_st_page_file_editor #loading").hide();
        jQuery("#r4w_st_page_file_editor .btn_editor").show();
        var ac_result = JSON.parse(ac_result);
        if(ac_result.success){
          r4w_notification_file('success');
        }else{
          r4w_notification_file('error');
        }
      }
    );
  });

  /**
   * Changement de l'indexation du wordpress
   */
  jQuery("#r4w_box_settings").on('change', "input[name='seo_settings_noindex']", function(){
    if(jQuery(this).is(':checked')){
      jQuery('.r4w_types_content_index').prop('checked', true);
    }else{
      jQuery('.r4w_types_content_index').prop('checked', false);
    }
  })

  /**
   * Réinitialisation de la configuration
   */
  jQuery("#r4w_st_page_reset .btn_reset").on('click',function( event ) {
    jQuery("#r4w_st_page_reset #loading").show();
    jQuery("#r4w_st_page_reset .btn_reset").hide();
    var task = jQuery(this).attr('id');
    jQuery.post(ajaxurl,
      {
        'action': 'r4w_exec_reset',
        'task': task,
      },
      function(ac_result){
        jQuery("#r4w_st_page_reset #loading").hide();
        jQuery("#r4w_st_page_reset .btn_reset").show();
        var ac_result = JSON.parse(ac_result);
        if(ac_result.success){
          if(task == 'reset_setting'){
            window.location = ac_result.success.url;
          }else{
            r4w_notification_reset('success');
          }
        }else{
          r4w_notification_reset('error');
        }
      }
    );
  });

  /**
   * Export configuration
   */
  jQuery("#r4w_st_page_export_import #task_export").on('click',function( event ) {
    jQuery("#r4w_st_page_export_import #loading").show();
    jQuery("#r4w_st_page_export_import #task_export").hide();
    jQuery.post(ajaxurl,
      {
        'action': 'r4w_exec_export'
      },
      function(ac_result){
        jQuery("#r4w_st_page_export_import #loading").hide();
        jQuery("#r4w_st_page_export_import #task_export").show();
        var ac_result = JSON.parse(ac_result);
        if(ac_result.success){
          window.location = ac_result.success.url;
        }
      }
    );
  });

  /**
   * Import configuration
   */
  jQuery("#r4w_st_page_export_import #task_import").on('click',function( event ) {
    jQuery("#r4w_st_page_export_import #loading").show();
    jQuery("#r4w_st_page_export_import #task_import").hide();

    var file_data = jQuery('#r4w_import_config').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('action', 'r4w_exec_import');

    jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        contentType: false,
        processData: false,
        data: form_data,
        success: function (ac_result) {
          var ac_result = JSON.parse(ac_result);
          jQuery("#r4w_st_page_export_import #loading").hide();
          jQuery("#r4w_st_page_export_import #task_import").show();
          if(ac_result.success){
            r4w_notification_import('success');
             window.location = ac_result.success.url;
          }else{
            r4w_notification_import('error');
          }
        }
    });
  });
 
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

      /**
       * Efface l'information du paramétrage de la langue
       */
      jQuery("#r4w_settings_country").bind("change", function(e) {
        jQuery('#r4w_notice_auth').hide();
      });

      /**
       * Gestion du menu tab
       */
      r4w_tab();

      /**
       * Affiche le code international pour les numéro de téléphone
       */
          document.querySelectorAll(".intl_tel").forEach( el => {
            window.intlTelInput(el, {
              preferredCountries: ['fr','us'],
              utilsScript: localize_settings.url_assets+'/js/fcnt/fcnt.tel.js',
            });
          });

      /**
       * Ouvre les données du Knowledge en fonction du type
       */
      function knowledge_markup(tab_page){
        jQuery('#r4w_sst_subpage_knowledge .knowledge_page_tab').removeClass('active');
        jQuery('#r4w_sst_subpage_knowledge #knowledge_'+tab_page).addClass('active');
      }
      jQuery( ".knowledge_box_tab" ).on('change',function( event ) {
        var knowledge_tab_page = jQuery(this).val();
        knowledge_markup(knowledge_tab_page);
      });
      if(jQuery(".knowledge_box_tab option:selected" ).val() != ''){
         knowledge_markup(jQuery(".knowledge_box_tab option:selected" ).val());
      }

    /**
     * Permet d'activer / désactiver la personnalisation des horaires 
     */
    jQuery('.r4w_input_custom_business_hours').on('change', function() {
      var input_cbh = jQuery(this);
      if(jQuery(input_cbh).is(':checked')){
        jQuery(input_cbh).closest('.r4w_business_hours').find('.r4w_openingHours select').prop("disabled", false);
        jQuery(input_cbh).closest('.r4w_business_hours').find('.r4w_openingHours').removeClass("disabled");
      }else{
        jQuery(input_cbh).closest('.r4w_business_hours').find('.r4w_openingHours select').prop("disabled", true);
        jQuery(input_cbh).closest('.r4w_business_hours').find('.r4w_openingHours').addClass("disabled");
      }
    });

    /**
     * Permet d'activer ou de désactiver les archives
     */
    jQuery('.r4w_input_custom_archive').on('change', function() {
      var input_cbh = jQuery(this);
      if(jQuery(input_cbh).is(':checked')){
        jQuery(input_cbh).closest('.page_subtab').find('input.r4w_archive').prop("disabled", false);
        jQuery(input_cbh).closest('.page_subtab').find('.r4w_progress_div div').attr('contenteditable','true');
        jQuery(input_cbh).closest('.page_subtab').find('.r4w_progress_div div').removeClass("athow_disabled");
        jQuery(input_cbh).closest('.page_subtab').find('.r4w_atwho_box').removeClass("content_disabled");
        jQuery(input_cbh).closest('.page_subtab').find('.r4w_progress_div div').addClass("athow_content");
      }else{
        jQuery(input_cbh).closest('.page_subtab').find('.r4w_archive').prop("disabled", true);
        jQuery(input_cbh).closest('.page_subtab').find('.r4w_progress_div div').attr('contenteditable','false');
        jQuery(input_cbh).closest('.page_subtab').find('.r4w_progress_div div').removeClass("athow_content");
        jQuery(input_cbh).closest('.page_subtab').find('.r4w_atwho_box').addClass("content_disabled");
        jQuery(input_cbh).closest('.page_subtab').find('.r4w_progress_div div').addClass("athow_disabled");
      }

    });

  /**
   * Ajoute les changements du contenteditable dans un input
   */
  jQuery(".athow_content").bind("focusout", function(e) {
    if ( jQuery(this).is( "input" ) ) {
        jQuery(this).closest('.r4w_atwho_box').find('.athow_input').val('+33'+jQuery(this).val()).trigger( "change" );
      }
    if ( jQuery(this).is( "div" ) ){
       jQuery(this).closest('.r4w_atwho_box').find('.athow_input').val(jQuery(this).text()).trigger( "change" );
    }
    
  }); 

  /**
   * Bouton pour ajouter un nouveau tag
   */
  document.querySelectorAll(".btn_add_tag").forEach(function(elem) {
    elem.addEventListener("mousedown", function(e) {
      e.preventDefault(); 
      var input = jQuery(this).parent().find('.athow_content');
      jQuery(".athow_content").removeClass('.select_tribute');
      jQuery(input).addClass('.select_tribute');
      tribute.isActive = false;
      tribute.showMenuForCollection(input[0]);
    });
  });

  /**
   * Permet de fermer le menu tag
   */
    document.addEventListener('mousedown',function(event){
      if (tribute.isActive && event.path[2].className!='btn_add_tag') {
        jQuery('.tribute-container').hide();
      }
    });
 
  /**
   * Permet d'ouvrire la médiathèque
   */
  jQuery('.r4w_add_img_button a').click(function() {
      var send_attachment_bkp = wp.media.editor.send.attachment;
      var button = jQuery(this);
      wp.media.editor.send.attachment = function(props, attachment) {
          jQuery(button).closest('.r4w_box_preview').find('.r4w_picture_input').val(attachment.url).trigger( "change" );
          jQuery(button).closest('.cnt_picture').css('background-image', 'url('+attachment.url+')');
          wp.media.editor.send.attachment = send_attachment_bkp;
      }
      wp.media.editor.open(button);
      return false;
  });

  /**
   * Peremet de supprimer l'image séléctionner
   */
  jQuery('.r4w_remove_img_button a').click(function() {
      var button = jQuery(this);
      jQuery(button).closest('.r4w_box_preview').find('.r4w_picture_input').val('').trigger( "change" );
      jQuery(button).parent().parent().css('background-image', '');
      return false;
  });

  /**
   * Permet d'afficher le liens du sitemaps
   */
  jQuery('.r4w_sitemaps_input').on('change', function(){
    if(jQuery(this).is(':checked')){
      jQuery('.r4w_sitemaps_view').addClass('active');
    }else{
      jQuery('.r4w_sitemaps_view').removeClass('active');
    }

  });
  
  /**
   * Pointage vers api système
   */
      r4w_ping_system('r4w_settings');
});
      
/**
 * Permet de récupérer et d'afficher la liste des tags disponible
 */
var tribute = new Tribute({
  collection: [{
    trigger: '%', 
    values: function(text,cb) {
      let select_tt = jQuery(".select_tribute");
      cb(jQuery.parseJSON(select_tt.prevObject[0].activeElement.dataset.tag.h2b()));
    },
    selectTemplate: function (item) {
      return '<span class="r4w_atwho" contenteditable="false"><sp>%%</sp>'+item.original.tag+'<sp>%%</sp></span>&nbsp;';
    },
    menuItemTemplate: function (item) {
      return item.original.name; 
    },
    autocompleteMode: false,
    requireLeadingSpace: false,
    positionMenu: true,
  }]
});
tribute.attach(document.querySelectorAll('[data-tag]'));