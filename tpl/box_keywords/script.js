jQuery(document).ready(function(){
     new SimpleBar(jQuery('#r4w_sc_keyword_secondary')[0], { autoHide: false });
     new SimpleBar(jQuery('#r4w_sc_keyword_lexical')[0], { autoHide: false });
/**
 * BOX Modal des mots-clés
 */
     jQuery("button.r4w_form").on("click", function() {
          var r4w_btn_clicked = jQuery(this);
          var r4w_method = jQuery(r4w_btn_clicked).parent().find("input[name='r4w_method']").val();
          jQuery(r4w_btn_clicked).parent().find("#r4w_error").html('');
          jQuery(r4w_btn_clicked).parent().find("#loading").show();
          jQuery(r4w_btn_clicked).parent().find("button[type='submit']").hide();
          jQuery.post(ajaxurl,
          {
               'action': 'r4w_exec_keywords',
               'r4w_method': r4w_method,
               'r4w_keywords': jQuery(r4w_btn_clicked).parent().find("input[name='r4w_keywords']").val(),
               'r4w_document_id': jQuery('#r4w_document_id').val()
          },
          function(ac_result){
               var ac_result = JSON.parse(ac_result);
               if(ac_result.error){
                    if(ac_result.error.name == "keyword_invalid"){
                         jQuery(r4w_btn_clicked).parent().find("#r4w_error").html('<div class="r4w_dsc">'+localize_box_keywords.error_keyword_invalid+'</div>');
                         jQuery(r4w_btn_clicked).parent().find("#loading").hide();
                         jQuery(r4w_btn_clicked).parent().find("button[type='submit']").show();
                    }
               }
               if(ac_result.success){
                    if(!ac_result.success.finish){
                         jQuery.modal.close();
                         jQuery('#'+ac_result.success.step).modal();
                    }else{
                         window.location = ac_result.success.url;
                    }
               }
          });
          return false;
     });

     /**
      * Recupération de l'autocomplete en fonction du mot-clé
      */
     jQuery("input#r4w_keywords_main").autocomplete({
          autoFocus: true,
          minLength: 0,
          source: function( request, response ) {
               jQuery('.ui-autocomplete.ui-widget-content').hide();
               if(request.term != ""){
                    jQuery.post(ajaxurl,
                    {
                         'action': 'r4w_exec_autocomplete',
                         'r4w_search': request.term
                    },
                    function(ac_result){
                         var ac_result = JSON.parse(ac_result);
                         if(ac_result.success){
                              var matcher = new RegExp( jQuery.ui.autocomplete.escapeRegex( request.term ), "i" );
                              if(ac_result.success.words != null){
                                   response( jQuery.grep(ac_result.success.words, function( value ) {
                                        return value;
                                   }).slice(0, 10));
                              }else{
                                   jQuery('.ui-autocomplete.ui-widget-content').hide();
                              }
                         }
                         jQuery('#r4w_keywords_main').removeClass('ui-autocomplete-loading');
                    });
               }else{
                    jQuery('.ui-autocomplete.ui-widget-content').hide();
                    jQuery('#r4w_keywords_main').removeClass('ui-autocomplete-loading');
               }
          },
          create: function() {
               jQuery(this).data('ui-autocomplete')._renderItem  = function (ul, item) {
                    return jQuery( "<li>" ).append( item.value ).appendTo( ul );
               };
          },
     }).focus(function(){
          if (this.value != ""){
               jQuery('.ui-autocomplete.ui-widget-content').show();
          }
     });

     jQuery('#r4w_box-keyword_secondary').on(jQuery.modal.OPEN, function(event, modal) {
          jQuery("#r4w_open_keyword").val('secondary');
          keywords_suggestion('secondary');
     });

     jQuery('#r4w_box-keyword_lexical').on(jQuery.modal.OPEN, function(event, modal) {
          jQuery("#r4w_open_keyword").val('lexical');
          keywords_suggestion('lexical');
     });

  /**
   * Initalisation de la selection des mots-clés
   */
     jQuery('input[name="r4w_keywords"].r4w_select_keywords').tagsInput({
          'defaultText':localize_box_keywords.add_new_keyword_tags_input,
          'onChange' : callback_keyword_change
     });

    /**
     * Permet lors d'un clique d'ouvrire la modal de keyword
     */
     jQuery(".r4w_open_keyword").on("click", function() {
          var open_keyword = jQuery("#r4w_open_keyword").val();
          jQuery("#r4w_box-keyword_"+open_keyword).modal();
          if(open_keyword != 'main'){
               keywords_suggestion(open_keyword);
          }
     });

  /**
   * Vérifier les mots-clés selectioner lors d'un changement
   */
     function callback_keyword_change(a){
          if(jQuery('.selectkeyword_box ul li').length > 0) {
               jQuery('.selectkeyword_box ul li').each(function(){
                    if(jQuery(this).parentsUntil('.selectkeyword_box').find('input[name="r4w_keywords"]').tagExist(jQuery(this).attr('id').h2b())){
                         jQuery(this).addClass('selected');
                    }else{
                         jQuery(this).removeClass('selected');
                    }
               });
          }
     }
});