jQuery(document).ready(function(){

     /**
     * Vérifie les changements à enregistrer via autosave
     */
          jQuery(".r4w_autosave").bind("change", function(e) {
               var r4w_this = jQuery(this);
               var config_update = jQuery(this).attr('name');
               var config_value = jQuery(this).val();

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
                         var config_value = 'on';
                    }else{
                         var config_value = 'off';
                    }
               }
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_document',
                    'config_update': config_update,
                    'config_value': config_value,
                    'wp_type': jQuery('#r4w_seo_settings').attr('wp-type'),
                    'wp_id': jQuery('#r4w_seo_settings').attr('wp-id')
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
     * Gestion du menu tab
     */
          r4w_tab();

          jQuery('#r4w_box_tabs .btn_tab:first').addClass('active');
          var tab_box_page = jQuery('#r4w_box_tabs .btn_tab:first').attr('id');
          if(jQuery('#r4w_st_'+tab_box_page+' #r4w_box_subtabs').length){
               jQuery('#r4w_st_'+tab_box_page+' #r4w_box_subtabs .btn_subtab').first().addClass('active');
               jQuery('#r4w_st_'+tab_box_page+' #r4w_box_subpages .page_subtab').first().addClass('active');
          }
          jQuery('#r4w_box_pages #r4w_st_'+tab_box_page).addClass('active');

          if(jQuery('#page_sn_editorial').hasClass('active')) {
              r4w_editorial_content();
          }

     /**
     * Ajoute les changements du contenteditable dans un input
     */
          jQuery(".athow_content").bind("focusout", function(e) {
               jQuery(this).parent().find('.athow_input').val(jQuery(this).text()).trigger( "change" );
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
     * Met à jour la aperçu
     */
          jQuery('.content_preview_title').on('keyup', function() {
               var preview_text = r4w_display_tag(jQuery(this).text());
               r4w_st_page_meta(jQuery(this),preview_text);
               if(!preview_text.length){
                    jQuery(this).closest('.page_tab').find('.r4w_box_preview .preview_title').html(jQuery("#r4w_seo_settings input[name~='wp_post_title'").val());
               }else{
                    jQuery(this).closest('.page_tab').find('.r4w_box_preview .preview_title').html(preview_text);
               }
          });
          jQuery('.content_preview_description').on('keyup', function() {
               var preview_text = r4w_display_tag(jQuery(this).text());
               r4w_st_page_meta(jQuery(this),preview_text);
               if(!preview_text.length){
                    jQuery(this).closest('.page_tab').find('.r4w_box_preview .preview_description').html(jQuery("#r4w_seo_settings     input[name~='wp_post_description'").val());
               }else{
                    jQuery(this).closest('.page_tab').find('.r4w_box_preview .preview_description').html(preview_text);
               }
          });

     /**
     * Permet d'activation ou de désactivation les checkbox de la personnalisation des robots
     */
          jQuery('.r4w_input_custom_robots').on('change', function() {
               jQuery('.r4w_checkbox_custom_robots input').removeAttr('checked');
               if(jQuery(this).is(':checked')){
                    jQuery('.r4w_checkbox_custom_robots input').prop("disabled", false);
               }else{
                    jQuery('.r4w_checkbox_custom_robots input').prop("disabled", true);
               }
          });

    /**
     * Permet d'activer ou de désactiver la personnalisation dans le shortcode
     */
          jQuery('.r4w_input_custom_shortcode').on('change', function() {
               var input_cbh = jQuery(this);
               if(jQuery(input_cbh).is(':checked')){
                    jQuery(input_cbh).closest('.page_tab').find('.ck_custom.r4w_progress_div div').attr('contenteditable','true');
                    jQuery(input_cbh).closest('.page_tab').find('.ck_custom.r4w_progress_div div').removeClass("athow_disabled");
                    jQuery(input_cbh).closest('.page_tab').find('.ck_custom.r4w_atwho_box').removeClass("content_disabled");
                    jQuery(input_cbh).closest('.page_tab').find('.ck_custom.r4w_progress_div div').addClass("athow_content");
               }else{
                    jQuery(input_cbh).closest('.page_tab').find('.ck_custom.r4w_progress_div div').attr('contenteditable','false');
                    jQuery(input_cbh).closest('.page_tab').find('.ck_custom.r4w_progress_div div').removeClass("athow_content");
                    jQuery(input_cbh).closest('.page_tab').find('.ck_custom.r4w_atwho_box').addClass("content_disabled");
                    jQuery(input_cbh).closest('.page_tab').find('.ck_custom.r4w_progress_div div').addClass("athow_disabled");
               }
          });

     /**
      * Récupère le contenue éditorial
      */
          function r4w_editorial_content() {
               var post_id = jQuery('#r4w_cnt_editorial').attr('data-post');
               jQuery('#r4w_cnt_editorial').html('<div class="ph-item"> <div class="ph-box-editorial"><div class="ph_editorial_hn"></div><div class="ph_editorial_cnt"></div><div class="ph_editorial_cnt"></div><div class="ph_editorial_cnt"></div><div class="ph_editorial_cnt"></div><div class="ph_editorial_cnt"></div><div class="ph_editorial_hn"></div><div class="ph_editorial_cnt"></div><div class="ph_editorial_cnt"></div><div class="ph_editorial_cnt"></div><div class="ph_editorial_cnt"></div><div class="ph_editorial_cnt"></div></div></div>');
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_editorial_content',
                    'r4w_post': post_id,
               },
               function(ac_result){
                    var ac_result = JSON.parse(ac_result);
                    if(ac_result.error){}
                    if(ac_result.success){
                         var result_editorial = ac_result.success.preview;
		               var output_editorial = result_editorial.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
		               	return localize_box_page[contents];
		               });
                         jQuery("#r4w_btn_import #loading").hide();
                         jQuery("#r4w_btn_import #r4w_import_editorial").show();
                         jQuery('#r4w_cnt_editorial').html(output_editorial);
                    }
               });
          }
});

     /**
      * Permet de récupérer et d'afficher la liste des tags disponible
      */
          
          var tribute = new Tribute({
               collection: [{
                    trigger: '%',
                    values: function(text,cb) {
                        let select_tt = jQuery(".select_tribute");
                        cb(jQuery.parseJSON(select_tt.context.activeElement.dataset.tag.h2b()));
                        cb(jQuery.parseJSON(select_tt.prevObject[0].activeElement.dataset.tag.h2b()));
                    },
                    selectTemplate: function (item) {
                         return '<span class="r4w_atwho" contenteditable="false"><sp>%%</sp>'+item.original.tag+'<sp>%%</sp></span>';
                    },
                    menuItemTemplate: function (item) {
                         return item.original.name;
                    },
                    autocompleteMode: false,
               }]
          });
          tribute.attach(document.querySelectorAll('[data-tag]'));

          jQuery('.r4w_status_meta').each(function(){
               r4w_st_page_meta(jQuery(this).parents('.r4w_atwho_box').find('.athow_content'));
          });

     /**
     * Affiche la limit du titre et de la description
     */
          function r4w_st_page_meta(a,b = null) {
               if(b == null){
                    if(jQuery(a).hasClass('content_preview_title')){
                         var preview_text = r4w_display_tag(jQuery(a).parents('.r4w_box_preview').find('.preview_title').text());
                    }
                    if(jQuery(a).hasClass('content_preview_description')){
                         var preview_text = r4w_display_tag(jQuery(a).parents('.r4w_box_preview').find('.preview_description').text());
                    }
               }else{
                    var preview_text = r4w_display_tag(b);
               }
               var count = preview_text.length;
               jQuery(a).parents('.r4w_atwho_box').find('.r4w_status_meta').removeClass("poor mediocre good perfect");

               if(jQuery(a).hasClass('content_preview_title')){
                    if(count >= 0 && count <= 45){
                         var class_status = "poor";
                         var text_status = localize_box_page.title_too_short;
                    }
                    if(count >= 46 && count <= 60){
                         var class_status = "mediocre";
                         var text_status = localize_box_page.title_too_short;
                    }
                    if(count >= 61 && count <= 67){
                         var class_status = "good";
                         var text_status = localize_box_page.title_short;
                    }
                    if(count >= 68 && count <= 72){
                         var class_status = "perfect";
                         var text_status = localize_box_page.title_perfect;
                    }
                    if(count >= 73){
                         var class_status = "poor";
                         var text_status = localize_box_page.title_too_long;
                    }
               }
               if(jQuery(a).hasClass('content_preview_description')){
                    if(count >= 0 && count <= 70){
                         var class_status = "poor";
                         var text_status = localize_box_page.description_too_short;
                    }
                    if(count >= 71 && count <= 99){
                         var class_status = "mediocre";
                         var text_status = localize_box_page.description_too_short;
                    }
                    if(count >= 100 && count <= 145){
                         var class_status = "good";
                         var text_status = localize_box_page.description_short;
                    }
                    if(count >= 146 && count <= 155){
                         var class_status = "perfect";
                         var text_status = localize_box_page.description_perfect;
                    }
                    if(count >= 156){
                         var class_status = "poor";
                         var text_status = localize_box_page.description_too_long;
                    }
               }
               jQuery(a).parents('.r4w_atwho_box').find('.r4w_status .r4w_status_meta').addClass(class_status);
               jQuery(a).parents('.r4w_atwho_box').find('.r4w_status .r4w_status_description').html(text_status);
          }

     /**
      * Insert le contenue editorial
      */
          jQuery("#r4w_st_page_sn_editorial").on('click', '#r4w_import_editorial', function() {
               jQuery("#r4w_btn_import #r4w_import_complete").hide();
               jQuery("#r4w_btn_import #r4w_import_editorial").hide();
               jQuery("#r4w_btn_import #loading").show();
               if(tinyMCE && tinyMCE.activeEditor){
                    tinyMCE.activeEditor.selection.setContent("\n\n<div>" + jQuery('#r4w_cnt_editorial').html() + "</div>");
               }
               jQuery("#r4w_btn_import #r4w_import_complete").show();
               jQuery("#r4w_btn_import #r4w_import_editorial").show();
               jQuery("#r4w_btn_import #loading").hide();
               return false;
          });