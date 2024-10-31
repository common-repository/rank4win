/**
 * Affiche la suggestion de mot-clé
 */
     function keywords_suggestion(a){
          jQuery('#r4w_sc_keyword_'+a).html('<ul class="ui-choose css-sdf55fe0er" multiple="multiple" id="uc_03"><div class="ph-item"> <div class="ph-box-keyword"> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> </div> </div></ul>');
          jQuery.post(ajaxurl,
          {
               'action': 'r4w_exec_keywords_suggestion',
               'r4w_document_id': jQuery('#r4w_document_id').val(),
               'r4w_keyword_type': a
          },
          function(ac_result){
               var ac_result = JSON.parse(ac_result);
               if(ac_result.error){
                    if(ac_result.error.name == "document_refresh"){
                         location.reload();
                    }
               }
               if(ac_result.success){
                    if(ac_result.success.data){
                         var result_suggestion = ac_result.success.data.h2b();
                         var output_suggestion = result_suggestion.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
                              return localize_fcnt_suggestion[contents];
                         });
                         jQuery('#r4w_box-keyword_'+a+' ul.ui-choose').html(output_suggestion);
                         const r4w_sc_suggest = new SimpleBar(jQuery('#r4w_sc_keyword_'+a)[0]);
                         //r4w_sc_suggest.recalculate();
                    }
               }

               /**
               * Ajoute / Supprime la suggestion selectionner
               */
               jQuery('.selectkeyword_box li.addkeyword').on("click", function(){
                    var a = jQuery(this);
                    var b = jQuery(this).find("span").text()
                    if(a.hasClass('selected')){
                         jQuery(a).parentsUntil('.selectkeyword_box').find('input[name="r4w_keywords"]').removeTag(b);
                    }else{
                         jQuery(a).parentsUntil('.selectkeyword_box').find('input[name="r4w_keywords"]').addTag(b);
                    }
               });

               /**
               * Permet d'afficher le score global en graphique
               */
               jQuery( ".tip_keyword" ).tip();
               jQuery( ".tip_keyword" ).hover(function() {
                    percent = parseInt(jQuery(this).attr("data-kd"));
                    color = jQuery(this).attr("data-color");
                    deg = 360*percent/100;
                    if (percent > 50) {
                         jQuery('.progress-pie-chart').addClass('gt-50');
                         jQuery('.progress-pie-chart').css("background-color", color);
                         jQuery('.ppc-progress-fill').css("background-color", "#E5E5E5");
                    }else{
                         jQuery('.progress-pie-chart').removeClass('gt-50');
                         jQuery('.progress-pie-chart').css("background-color", "#E5E5E5");
                         jQuery('.ppc-progress-fill').css("background-color", color);
                    }
                    jQuery('.pcc-percents-wrapper span').css("color", color);
                    jQuery('.ppc-progress-fill').css('transform','rotate('+ deg +'deg)');
                    jQuery('.ppc-percents span').html(percent+'%');
               });
          });
     }