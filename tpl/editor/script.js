jQuery(document).ready(function(){
     new SimpleBar(jQuery('#r4w_sc_keyword_secondary')[0], { autoHide: false });

     /**
     * Permet de réduire le menu de wordpress
     */
          if( !jQuery('body').hasClass('folded') ){
               jQuery('body').addClass('folded')
          }

     /**
     * Ouvre l'éditeur
     */
          function r4w_open_editor(a){
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_str_semantic',
                    'r4w_method': 'r4w_str_semantic_view',
                    'r4w_semantic_uuid' : a
               },
               function(ac_result){
                    var ac_result = JSON.parse(ac_result);
                    if(ac_result.error){}
                    if(ac_result.success){
                         if( ac_result.success.str_semantic.protected ){
                              if(ac_result.success.msg_protected){
                                   jQuery('#r4w_msgprotected_str_semantic').html(ac_result.success.msg_protected.h2b());
                              }else{
                                   jQuery('#r4w_msgprotected_str_semantic').html('');
                              }
                              jQuery('#r4w_editor_name').html(ac_result.success.str_semantic.name.h2b());
                              jQuery('#rank4win-cloud-editor').attr('data-protected', 'true' );
                              jQuery('#r4w_editor_left').width("100%");
                              jQuery('#r4w_editor_right').remove();
                              jQuery('#r4w_splitter_bar').remove();
                              jQuery('#r4w_editor_left #ph_str_editor').remove();
                              editor.apprank4win.importJson( JSON.parse( window.atob(ac_result.success.str_semantic.editor) ) );
                         }else{
                              if(ac_result.success.str_semantic.desync) {
                                   jQuery("#r4w_box-synchronization").modal({backdrop: 'static',keyboard: false});
                              }
                              jQuery('#r4w_editor_name').html(ac_result.success.str_semantic.name.h2b());
                              jQuery('#rank4win-cloud-editor').attr('data-protected', 'false' );
                              jQuery('#rank4win-cloud-editor').attr('data-hash', ac_result.success.str_semantic.hash );
                              jQuery('#r4w_editor_left #ph_str_editor').remove();
                              jQuery('#r4w_editor_right').html( ac_result.success.str_search.h2b() );
                              editor.apprank4win.importJson( JSON.parse( window.atob(ac_result.success.str_semantic.editor) ) );
                              jQuery("#rank4win-cloud-editor ul.nav-tabs").append('<li class="css-sf2e5fezf0"><a id="r4w_deploy_str_semantic" class="r4w_deploy_str_semantic" href="#">'+localize_editor.deploy_the_structure+'</a></li>');
                              r4w_tab();
                              var selected = apprank4win.getSelectedNodes();
                              var selection = [];
                              apprank4win.select(selection, true);
                              apprank4win.fire('receiverfocus');
                         }
                         //window.location = ac_result.error.url;
                    }
               });
          } 

     /**
      * 
      */
          
          jQuery("#r4w_box_editor").on("click",'#r4w_deploy_str_semantic', function() {
               jQuery.modal.close();
               jQuery("#r4w_box-checkstr").modal({backdrop: 'static',keyboard: false});
               jQuery("#r4w_box-checkstr #str_checking").show();
               jQuery("#r4w_box-checkstr #str_conclude").hide();
               jQuery("#r4w_box-checkstr #str_inconclusive").hide();
               var a = jQuery('#rank4win-cloud-editor').attr('data-diagram');
               jQuery.post(ajaxurl,
                    {
                         'action': 'r4w_exec_str_semantic',
                         'r4w_method': 'r4w_str_semantic_check',
                         'r4w_semantic_uuid' : a
                    },
                    function(ac_result){
                         var ac_result = JSON.parse(ac_result);
                         if(ac_result.error){}
                         if(ac_result.success){
                             if(ac_result.success.keyword.missing){
                                   jQuery("#r4w_box-checkstr #str_checking").hide();
                                   jQuery("#r4w_box-checkstr #str_inconclusive").show();
                                   let page_li = "";
                                   if(ac_result.success.keyword.list){
                                        jQuery.each( ac_result.success.keyword.list, function( key, value ) {
                                             page_li += "<li>"+value+"</li>";
                                        });
                                   }
                                   jQuery("#r4w_box-checkstr #str_inconclusive ul").html(page_li);
                             }else{
                                  jQuery("#r4w_box-checkstr #str_checking").hide();
                                  jQuery("#r4w_box-checkstr #str_conclude").show();
                                  jQuery("#r4w_box-checkstr #str_conclude #str_btn_deploy").attr("href", ac_result.success.url_deploy);
                             }
                         }
                    });
          });
     /**    
      *  
      */
          jQuery("#r4w_box-synchronization").on("click",'#r4w_desynchronized_close', function() {
               jQuery.modal.close();
          });
          jQuery("#r4w_box-synchronization").on("click",'#r4w_desynchronized_replace', function() {
               var a = jQuery('#rank4win-cloud-editor').attr('data-diagram');
               jQuery.post(ajaxurl,
                    {
                         'action': 'r4w_exec_str_semantic',
                         'r4w_method': 'r4w_str_semantic_sync',
                         'r4w_semantic_uuid' : a
                    },
                    function(ac_result){
                         var ac_result = JSON.parse(ac_result);
                         if(ac_result.error){}
                         if(ac_result.success){
                              editor.apprank4win.importJson( JSON.parse( window.atob(ac_result.success.str_semantic.editor) ) );
                              jQuery.modal.close();
                         }
                    });
          });

     /**
      * Ouverture de la box pour l'ajout des mots clés
      */
          jQuery("#r4w_box_editor").on("click",'.r4w_page_keyword', function() {
               var box_keyword = jQuery(this).attr('box_keyword');
               var str_id = jQuery(this);
               jQuery("#r4w_box-keyword_"+box_keyword+" button").show();
               jQuery("#r4w_box-keyword_"+box_keyword+" #loading").hide();
               jQuery("#r4w_keywords_"+box_keyword+"").val("");
               jQuery("#r4w_box-keyword_"+box_keyword).modal({backdrop: 'static',keyboard: false});
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

          jQuery( "#r4w_box-keyword_main form" ).submit(function( event ) {
               event.preventDefault();

               jQuery('#r4w_box-keyword_main button').hide();
               jQuery('#r4w_box-keyword_main #loading').show();

               let a = jQuery('#rank4win-cloud-editor').attr('data-diagram');
               let b = jQuery('#r4w_editor_page_info').attr('r4w_semantics_page');
               let c = jQuery('#r4w_box-keyword_main #r4w_keywords_main').val();
               
               jQuery.r4w_wp_page_keyword('main',c);
          });

          jQuery( "#r4w_box-keyword_secondary form" ).submit(function( event ) {
               event.preventDefault();
               jQuery('#r4w_box-keyword_secondary button').hide();
               jQuery('#r4w_box-keyword_secondary #loading').show();

               let a = jQuery('#rank4win-cloud-editor').attr('data-diagram');
               let b = jQuery('#r4w_editor_page_info').attr('r4w_semantics_page');
               let c = jQuery('#r4w_box-keyword_secondary #r4w_keywords_secondary').val();

               jQuery.r4w_wp_page_keyword('secondary',c);
          });

     /**
      * Initalisation de la selection des mots-clés
      */
          jQuery('input[name="r4w_keywords"].r4w_select_keywords').tagsInput({
               'defaultText':localize_editor.add_new_keyword_tags_input,
               'onChange' : r4w_edior_callback_keyword_change
          });

     /**
     * Vérifier les mots-clés selectioner lors d'un changement
     */
          function r4w_edior_callback_keyword_change(a){
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

          jQuery("#r4w_box_editor").on("click", ".css-3c61c15b8f61", function(event) {
               var click_close = event.target.className;
               if(click_close == "box_subtab css-6f06fg5rg0r css-3c61c15b8f61" || click_close == "css-77fe49a2eba1"){
                    var selected = apprank4win.getSelectedNodes();
                    var selection = [];
                    apprank4win.select(selection, true);
                    apprank4win.fire('receiverfocus');
               }
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

          var a = jQuery('#rank4win-cloud-editor').attr('data-diagram');
          r4w_open_editor(a);

          jQuery(".r4w_splitter-left").resizable({
               handleSelector: ".splitter",
               resizeHeight: false,
          });

          jQuery(".r4w_splitter-top").resizable({
               handleSelector: ".splitter-horizontal",
               resizeWidth: false,
          });

          jQuery( "#r4w_editor_right" ).on('click','#btn_search_word',function(event) {
               r4w_process_search_word(jQuery('#r4w_search_word').val());
          });

          jQuery('#r4w_editor_right').on('keyup','#r4w_search_word',function(e){
               if(e.keyCode == 13)
               {
                    r4w_process_search_word(jQuery('#r4w_search_word').val());
               }
          });

     /**
     * Ajoute le mot dans la structure
     */
          jQuery("#r4w_box_editor").on("click", ".tab_content .inc_topic", function(a) {
               var r4w_editor_structure = editor.apprank4win.exportJson();
               var r4w_kw = jQuery(this).attr("data-kw");
               r4w_editor_structure['root']['children'].push(jQuery.parseJSON('{"data":{"uuid":"'+r4w_fcnt_uuid()+'","created":"'+jQuery.now()+'","text":"'+r4w_kw+'","r4w_post_data":{"keywords":{"main":"'+r4w_kw+'"}}}}'));
               editor.apprank4win.importJson(r4w_editor_structure);
          });

     /**
     * Affiche et cache les questionnements
     */
          jQuery('#r4w_box_editor').on('click', ".js-diary-show-details", function(){
               if(jQuery(this).parent().hasClass('open_details')){
                    jQuery(this).parent().removeClass('open_details');
                    jQuery(this).parent().find('img').removeClass('rotate-z');
                    jQuery(this).parent().find('.list_document_answers').hide();
                    var height_cal = jQuery("#r4w_tab_search_answer .search_content").height();
                    jQuery("#r4w_tab_search_answer").height(height_cal);
               }else{
                    jQuery(this).parent().addClass('open_details');
                    jQuery(this).parent().find('img').addClass('rotate-z');
                    jQuery(this).parent().find('.list_document_answers').show();
                    var height_cal = jQuery("#r4w_tab_search_answer .search_content").height();
                    jQuery("#r4w_tab_search_answer").height(height_cal);
               }
          });

     /**
     * Pointage vers api système
     */
          r4w_ping_system('r4w_editor');
});

     /**
     * Structure sémantique : Lance la recherche de mot
     */
          function r4w_process_search_word(a){
          jQuery('#r4w_tab_search_suggestion .search_content').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div>  </div> </div>');
          jQuery('#r4w_tab_search_related .search_content').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div>  </div> </div>');
          jQuery('#r4w_tab_search_answer .search_content').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div>  </div> </div>');
          jQuery.post(ajaxurl,
          {
               'action': 'r4w_exec_process',
               'r4w_request': 'search_word',
               'r4w_method': 'PUT',
               'r4w_word' : a,
          },
          function(ac_result){
               var ac_result = JSON.parse(ac_result);
               if(ac_result.error){
                    jQuery.modal.close();
               }
               if(ac_result.success){
                    var intervalId = setInterval(function(){
                         jQuery.post(ajaxurl,
                         {
                              'action': 'r4w_exec_process',
                              'r4w_request': 'search_word',
                              'r4w_method' : 'GET',
                              'r4w_process': ac_result.success.process
                         },
                         function(ac_result){
                              var ac_result = JSON.parse(ac_result);
                              if(ac_result.error){
                                   clearInterval(intervalId);
                                   jQuery.modal.close();
                              }
                              if(ac_result.success){
                                   if(ac_result.success.process == 'finish'){
                                        clearInterval(intervalId);
                                        r4w_search_word(a);
                                   }
                              }
                         });
                    }, 1500);
               }
          });
     }

     /**
     * Structure sémantique : Récupère la recherche de mot
     */
          function r4w_search_word(a){
          if(a){
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_strategy',
                    'r4w_method': 'r4w_strategy_word',
                    'r4w_word' : a
               },
               function(ac_result){
                    var ac_result = JSON.parse(ac_result);
                    if(ac_result.error){}
                    if(ac_result.success){
                         if(ac_result.success.keywords.suggestions){
                              var result_suggestions = ac_result.success.keywords.suggestions.h2b();
                              var output_suggestions = result_suggestions.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
                                   return localize_editor[contents];
                              });
                         }else{
                              jQuery('#r4w_tab_search_suggestion .search_content').html('');
                         }

                         if(ac_result.success.keywords.related){
                              var result_related = ac_result.success.keywords.related.h2b();
                              var output_related = result_related.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
                                   return localize_editor[contents];
                              });
                         }else{
                              jQuery('#r4w_tab_search_related .search_content').html('');
                         }

                         if(ac_result.success.keywords.answer){
                              var result_answer = ac_result.success.keywords.answer.h2b();
                              var output_answer = result_answer.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
                                   return localize_editor[contents];
                              });
                         }else{
                              jQuery('#r4w_tab_search_answer .search_content').html('');
                         }

                         jQuery('#r4w_tab_search_suggestion .search_content').html(output_suggestions);
                         jQuery('#r4w_tab_search_related .search_content').html(output_related);
                         jQuery('#r4w_tab_search_answer .search_content').html(output_answer);
                    }
               });
          }
     }
