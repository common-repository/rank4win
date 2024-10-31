jQuery(document).ready(function(){

    /**
     * Gestion du menu tab
     */
          r4w_tab();
          jQuery('#r4w-tabs li#str_semantic').on('click',function( event ) {
               r4w_str_semantic();
          });
          if(jQuery('#r4w-tabs li#str_semantic').hasClass("active")) {
               r4w_str_semantic();
          }
          jQuery('#r4w-tabs li#deploy').on('click',function( event ) {
               r4w_list_deploy();
          });
          if(jQuery('#r4w-tabs li#deploy').hasClass("active")) {
               r4w_list_deploy();
          }
          jQuery('#r4w-tabs li#strategy').on('click',function( event ) {
               r4w_strategy();
          });

    /**
     * Stratégie : création
     */
          jQuery('#r4w_create_new_strategy').on('click',function( event ) {
               jQuery('#r4w_list_strategy').hide();
               jQuery('#r4w_tab_strategy_select').show();
               jQuery('#r4w_create_new_strategy').hide();
               jQuery('#r4w_cancel_new_strategy').show();
          });
          jQuery('#r4w_cancel_new_strategy').on('click',function( event ) {
               r4w_strategy();
          });

  /**
   * Stratégie : Récupération
   */
          function r4w_strategy(){
               jQuery('#r4w_list_strategy').show();
               jQuery('#r4w_tab_strategy_select').hide();
               jQuery('#r4w_create_new_strategy').show();
               jQuery('#r4w_cancel_new_strategy').hide();
               jQuery('#r4w_list_strategy').html('<div class="box_cnt"> <div class="liste_strategy"> <div class="ph-item"> <div class="ph-line"> <div class="ph_title"></div> <div class="ph_number"></div> <div class="ph_percent"></div> <div class="ph_btn"></div> </div> </div> </div> </div>');
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_strategy',
                    'r4w_method': 'r4w_strategy_list'
               },
               function(ac_result){
                    var ac_result = JSON.parse(ac_result);
                    if(ac_result.error){
                    }
                    if(ac_result.success){
                         jQuery('#r4w_list_strategy').html(ac_result.success.strategy.h2b());
                         /**
                         * Lors d'un clique pour ouvrire le menu
                         */
                         jQuery('.r4w_btn_menu').on('click',function( event ) {
                              var show_menu = jQuery(this).find('.r4w_show_menu').is(':hidden');
                              jQuery('.r4w_show_menu').hide();
                              if(show_menu){
                              jQuery(this).find('.r4w_show_menu').show();
                              }
                         });
                         jQuery(document).click(function(event) {
                              if(!event.target.closest('.r4w_btn_menu')) {
                                   jQuery('.r4w_show_menu').hide();
                              }
                         });
                         jQuery(".r4w_open_create_semantic_structure").on("click", function() {
                              jQuery("#r4w_box_create_str_semantic_structure").modal({backdrop: 'static',keyboard: false});
                         });
                    }
               }
               );
          }

    /**
     * Structure sémantique : création
     */
          jQuery('#r4w_create_new_str_semantic').on('click',function( event ) {
               jQuery("#r4w_box_new_str_semantic").modal({backdrop: 'static',keyboard: false});
          });

    /**
     * Structure sémantique : création via stratégie
     */
          jQuery("#r4w_str_structure_content").change(function() {
               if(jQuery(this).find(":checked").val() ==  "ff55c431-be25-4f81-b23c-680ea9a9e935"){
                    jQuery('#r4w_str_structure_select').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_select"></div> </div> </div>');
                    jQuery("#r4w_box_new_str_semantic #btn_create").prop('disabled', true);
                    jQuery("#r4w_select_strategy").show();
                    jQuery.post(ajaxurl,
                    {
                         'action': 'r4w_exec_strategy',
                         'r4w_method': 'r4w_strategy_str_structure'
                    },
                    function(ac_result){
                         var ac_result = JSON.parse(ac_result);
                         if(ac_result.error){
                              jQuery.modal.close();
                         }
                         if(ac_result.success){
                              if(ac_result.success.select){
                                   jQuery("#r4w_box_new_str_semantic #btn_create").prop('disabled', false);
                              }else{
                                   jQuery("#r4w_box_new_str_semantic #btn_create").prop('disabled', true);
                              }
                              jQuery('#r4w_str_structure_select').html(ac_result.success.data.h2b());
                         }else{
                              jQuery.modal.close();
                         }
                    }
                    );
               }else{
                    if( !jQuery("#r4w_box_new_str_semantic [name='r4w_str_structure_name']").val() ) {
                         jQuery("#r4w_box_new_str_semantic #btn_create").prop('disabled', true);
                    }else{
                         jQuery("#r4w_box_new_str_semantic #btn_create").prop('disabled', false);
                    }
                    jQuery("#r4w_select_strategy").hide();
               }
          });

    /**
     * Vérifie qu'un nom de strucutre est indiqué
     */
          jQuery("#r4w_box_new_str_semantic [name='r4w_str_structure_name']").keyup(function() {
               if( !jQuery(this).val() ) {
                    jQuery("#r4w_box_new_str_semantic #btn_create").prop('disabled', true);
               }else{
                    jQuery("#r4w_box_new_str_semantic #btn_create").prop('disabled', false);
               }
          });
          jQuery('#r4w_box_load_new_str_semantic #btn_create').on('click',function( event ) {
               jQuery(this).closest('#r4w_box_load_new_str_semantic').find('#btn_create').hide();
               jQuery(this).closest('#r4w_box_load_new_str_semantic').find('#loading').show();
               var name = jQuery("#r4w_box_load_new_str_semantic [name='r4w_str_structure_name']").val();
               var content = jQuery('#r4w_box_load_new_str_semantic #r4w_str_structure_content').val();
               var strategy =  jQuery('#r4w_box_load_new_str_semantic #r4w_str_structure_strategy').val();
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_str_semantic',
                    'r4w_method': 'r4w_str_semantic_create',
                    'r4w_str_name': name,
                    'r4w_str_content': content,
                    'r4w_str_strategy': strategy
               },
               function(ac_result){
                    jQuery('#r4w_box_load_new_str_semantic').find('#btn_create').show();
                    jQuery('#r4w_box_load_new_str_semantic').find('#loading').hide();
                    jQuery('#r4w_box_load_new_str_semantic').find('#r4w_select_strategy').hide();
                    jQuery("#r4w_box_load_new_str_semantic [name='r4w_str_structure_name']").val('');
                    jQuery('#r4w_box_load_new_str_semantic #r4w_str_structure_content option[value="a1787db4-59b4-4de5-9dd9-17d2cfbd8c35"]').prop('selected', true);
                    jQuery.modal.close();
                    jQuery( "#str_semantic" ).trigger( "click" );
               }
               );
          });

    /**
     * Structure sémantique : Récupération
     */
          function r4w_str_semantic(){
               jQuery('#r4w_list_str_semantic').show();
               jQuery('#r4w_tab_str_semantic').show();
               jQuery('#r4w_tab_str_semantic_create').hide();
               jQuery('#r4w_create_new_str_semantic').show();
               jQuery('#r4w_cancel_new_str_semantic').hide();
               jQuery('#r4w_list_str_semantic').html('<div class="box_cnt"> <div class="liste_str_semantic"> <div class="ph-item"> <div class="ph-line"> <div class="ph_picture"></div> <div class="ph_box_cnt"> <div class="ph_box_left"> <div class="ph_title"></div> <div class="ph_number"></div> </div> <div class="ph_box_right"> <div class="ph_btn"></div> </div> </div> </div> </div> </div> </div>');
               jQuery('#r4w_msgsync_str_semantic').html('');
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_str_semantic',
                    'r4w_method': 'r4w_str_semantic_list'
               },
               function(ac_result){
                    var ac_result = JSON.parse(ac_result);
                    if(ac_result.error){

                    }
                    if(ac_result.success){
                         if(ac_result.success.str_semantic){
                              jQuery('#r4w_list_str_semantic').html(ac_result.success.str_semantic.h2b());
                         }else{
                              jQuery('#r4w_list_str_semantic').html('');
                         }
                         if(ac_result.success.msg_sync){
                              jQuery('#r4w_msgsync_str_semantic').html(ac_result.success.msg_sync.h2b());
                         }else{
                              jQuery('#r4w_msgsync_str_semantic').html('');
                         }
                    }
               }
               );
          }

    /**
     * Liste des structures deployer
     */
          function r4w_list_deploy(notpreload = null) {
               jQuery('#r4w_deploy').show();
               jQuery('#r4w_box_deploy_str_semantic').hide();
               if(!notpreload){
                    jQuery('#r4w_deploy').html('<div id="r4w_list_deploy" class="box_list_deploy"><div class="box_cnt"><div class="list_deploy"><div class="ph-item"><div class="ph-line"><div class="ph_box_cnt"><div class="ph_box_left"><div class="ph_title"></div><div class="ph_number"></div></div><div class="ph_box_right"><div class="ph_btn"></div></div></div></div></div><div class="ph-item"><div class="ph-line"><div class="ph_box_cnt"><div class="ph_timestatus"></div></div></div></div></div></div></div>');
               }
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_list_deploy'
               },
               function(ac_result){
                    clearTimeout(countUpFromTime.interval);
                    var ac_result = JSON.parse(ac_result);
                    if(ac_result.error){
                    }
                    if(ac_result.success){
                         if(ac_result.success.deploy){
                              jQuery('#r4w_deploy').html(ac_result.success.deploy);
                              if(ac_result.success.progress){
                                   countUpFromTime(ac_result.success.progress.date, 'ghl_deploy_progress');
                                   setTimeout(function(){ r4w_list_deploy(1); }, 10000)
                              }
                         }else{
                              jQuery('#r4w_deploy').html('');
                         }
                    }
               }
               );
          }

    /**
     * Lors d'un clique pour ouvrire le menu
     */
          jQuery('#r4w_box_tools').on('click', ".r4w_btn_menu", function( event ) {
               var show_menu = jQuery(this).find('.r4w_show_menu').is(':hidden');
               jQuery('.r4w_show_menu').hide();
               if(show_menu){
                    jQuery(this).find('.r4w_show_menu').show();
               }
          });

          jQuery(document).click(function(event) {
               if(!event.target.closest('.r4w_btn_menu')) {
                    jQuery('.r4w_show_menu').hide();
               }
          });

    /**
     * Annule le déploiement en cours
     */
          jQuery('body.rank4win_page_r4w_tools').on('click', "#stop_deploy", function(){
               jQuery.modal.close();
               jQuery("#r4w_box_wait").modal({backdrop: 'static',keyboard: false});
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_process',
                    'r4w_request': 'r4w_str_semantic_deploy',
                    'r4w_method': 'DELETE'
               },
               function(ac_result){
                    var ac_result = JSON.parse(ac_result);
                    if(ac_result.error){
                         jQuery.modal.close();
                    }
                    if(ac_result.success){
                         window.location = ac_result.success.url;
                         jQuery.modal.close();
                    }
               }
               );
          });

    /**
     * Achat de déploiement supplémentaire
     */
          function r4w_proceed_checkout(uuid = null){
               jQuery.modal.close();
               jQuery('#r4w_box_stripe_preview #r4w_box_stripe').html('<div id="box_cardx" class="r4w_stripe_card"> <div class="ph-item"> <div class="ph-line"> <div class="ph_svglogo"></div> <div class="ph_card_title"></div> <div class="ph_card_number"></div> <div class="ph_card_btn"></div> <div class="ph_card_cvg_1"></div> <div class="ph_card_cvg_2"></div> </div> </div> </div> <div id="box_features" class="r4w_stripe_features"> <div class="ph-item"> <div class="ph-line"> <div class="ph_features_price"></div> <div class="ph_features_title"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> </div> </div> </div>');
               jQuery("#r4w_box_stripe_preview").modal({backdrop: 'static',keyboard: false});
               var data_strategie = jQuery('#r4w_box_load_deploy_select').attr('data-strategy');
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_buy_option',
                    'option': 'editor_deploystructure',
                    'data': data_strategie
               },
               function(ac_result){
                    var ac_result = JSON.parse(ac_result);
                    if(ac_result.error){
                         jQuery.modal.close();
                    }
                    if(ac_result.success){
                         if(ac_result.success.preview){
                              jQuery('#r4w_box_stripe_preview #r4w_box_stripe').html(ac_result.success.preview);

                              /**
                              * Applique le nouveau prix en fonction de la quantité
                              */
                              jQuery('body.rank4win_page_r4w_tools').on("change", 'input[name="product_unit"]', function(){
                              var product_unit = jQuery(this).val();
                              var product_min = parseFloat(jQuery(this).attr('min'));
                              var product_max = parseFloat(jQuery(this).attr('max'));
                              if(product_unit < product_min){
                                   product_unit = product_min;
                                   jQuery(this).val(product_unit);
                              }
                              if(product_unit > product_max){
                                   product_unit = product_max;
                                   jQuery(this).val(product_unit);
                              }
                              var new_amount = (ac_result.success.amount/100) * product_unit;
                              jQuery('#r4w_box_stripe_preview .amount').html(new_amount.toFixed(2).replace(".", ","));
                              });
                              r4w_stripe(ac_result.success.option.uuid,ac_result.success.stripe.pk);
                         }else{
                              jQuery.modal.close();
                         }
                    }
               }
               );
               return false;
          }

    /**
     * Diminution quantité option
     */
          jQuery("body.rank4win_page_r4w_tools").on("click", "button.quantity_down", function() {
               var product_unit = jQuery(this).parent().find('input[name="product_unit"]');
               var num = +product_unit.val() - 1;
               product_unit.val(num);
               jQuery(product_unit).trigger('change');
          });

    /**
     * Augementation quantité option
     */
          jQuery("body.rank4win_page_r4w_tools").on("click", "button.quantity_up", function() {
               var product_unit = jQuery(this).parent().find('input[name="product_unit"]');
               var num = +product_unit.val() + 1;
               product_unit.val(num);
               jQuery(product_unit).trigger('change');
          });

 /**
   * Stripe : Aperçu et vérification de la carte
   */
          function r4w_stripe(a,b){
               var stripe = Stripe(b);
               var elements = stripe.elements();
               var card = elements.create('card');
               card.mount('#card-element');

               card.addEventListener('change', function(event) {
               var displayError = document.getElementById('card-errors');
               if (event.error) {
                    displayError.textContent = event.error.message;
               } else {
                    displayError.textContent = '';
               }
               });
               var form = document.getElementById('payment-form');
               form.addEventListener('submit', function(event) {
                    jQuery("#payment-form #loading_payment").show();
                    jQuery("#payment-form #success_payment").hide();
                    jQuery("#payment-form #submit_payment").hide();
                    event.preventDefault();

                    stripe.createToken(card).then(function(result) {
                         if (result.error) {
                         jQuery("#payment-form #loading_payment").hide();
                         jQuery("#payment-form #success_payment").hide();
                         jQuery("#payment-form #submit_payment").show();

                         var errorElement = document.getElementById('card-errors');
                         errorElement.textContent = result.error.message;
                         } else {
                         var product_unit = 1;
                         r4w_stripe_TokenHandler(a,product_unit,result.token);
                         }
                    });
               });
          }

  /**
   * Stripe : Paiement et validation de l'option
   */
          function r4w_stripe_TokenHandler(a,b,c){
               var semantic_uuid = jQuery('#r4w_box_load_deploy_select').attr('data-strategy');
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_stripe',
                    'product_type': 'option',
                    'option_uuid': a,
                    'option_unit': b,
                    'stripe_token': c.id,
                    'additional': semantic_uuid
               },
               function(ac_result){
                    var ac_result = JSON.parse(ac_result);
                    if(ac_result.error){
                         jQuery("#payment-form #loading_payment").hide();
                         jQuery("#payment-form #success_payment").hide();
                         jQuery("#payment-form #submit_payment").hide();
                         jQuery("#payment-form #error_payment").show();
                    }
                    if(ac_result.success){
                         jQuery("#payment-form #loading_payment").hide();
                         jQuery("#payment-form #success_payment").show();
                         jQuery("#payment-form #error_payment").hide();
                         jQuery("#payment-form #submit_payment").hide();
                         r4w_str_semantic_deploy(semantic_uuid);
                    }
               }
               );
          }

          jQuery("#r4w_box_tools").on('click', ".r4w_duplicate_str_semantic", function() {
               jQuery('#r4w_list_str_semantic').html('<div class="box_cnt"> <div class="liste_str_semantic"> <div class="ph-item"> <div class="ph-line"> <div class="ph_picture"></div> <div class="ph_box_cnt"> <div class="ph_box_left"> <div class="ph_title"></div> <div class="ph_number"></div> </div> <div class="ph_box_right"> <div class="ph_btn"></div> </div> </div> </div> </div> </div> </div>');
               jQuery("#r4w_box_duplicate_str_semantic").modal({backdrop: 'static',keyboard: false});
               r4w_str_semantic_duplicate(jQuery(this).closest('.box_cnt').attr('data-strategy'));
          });

          jQuery("#r4w_box_deploy_str_semantic").on('click', "#r4w_box_load_deploy_select #btn_deploy", function() {
               var semantic_uuid = jQuery(this).closest('#r4w_box_load_deploy_select').attr('data-strategy');
               var data_deploy = jQuery("#r4w_box_deploy_str_semantic").attr('data-deployment');
               if(data_deploy == 'available'){
                    r4w_str_semantic_deploy(semantic_uuid);
               }
               if(data_deploy == 'unavailable'){
                    r4w_proceed_checkout(semantic_uuid);
               }
          });

          jQuery("#r4w_box_tools").on('click', ".r4w_str_semantic_delete", function() {
               jQuery('#r4w_list_str_semantic').html('<div class="box_cnt"> <div class="liste_str_semantic"> <div class="ph-item"> <div class="ph-line"> <div class="ph_picture"></div> <div class="ph_box_cnt"> <div class="ph_box_left"> <div class="ph_title"></div> <div class="ph_number"></div> </div> <div class="ph_box_right"> <div class="ph_btn"></div> </div> </div> </div> </div> </div> </div>');
               r4w_str_semantic_delete(jQuery(this).closest('.box_cnt').attr('data-strategy'));
          });

          jQuery("#r4w_box_tools").on('click', ".r4w_image_str_semantic", function() {
             r4w_str_semantic_image(jQuery(this).closest('.box_cnt').attr('data-strategy'));
          });

          jQuery("#r4w_box_tools").on('click', ".r4w_rename_str_semantic", function() {
             jQuery("#r4w_box_rename_str_semantic").modal({backdrop: 'static',keyboard: false});
             var semantic_uuid = jQuery(this).closest('.box_cnt').attr('data-strategy');
             jQuery("#r4w_box_rename_str_semantic #btn_rename").prop('disabled', true);
             jQuery('#r4w_box_rename_str_semantic').find('#btn_rename').show();
             jQuery('#r4w_box_rename_str_semantic').find('#loading').hide();
             jQuery("#r4w_box_rename_str_semantic").attr('data-strategy',semantic_uuid);
             jQuery("#r4w_box_rename_str_semantic [name='r4w_str_structure_name']").val('');
             /**
              * Vérifie qu'un nom de strucutre est indiqué
              */
             jQuery("#r4w_box_rename_str_semantic [name='r4w_str_structure_name']").keyup(function() {
               if( !jQuery(this).val() ) {
                 jQuery("#r4w_box_rename_str_semantic #btn_rename").prop('disabled', true);
               }else{
                 jQuery("#r4w_box_rename_str_semantic #btn_rename").prop('disabled', false);
               }
             });
          });

          jQuery("#r4w_box_rename_str_semantic #btn_rename").on("click", function() {
               jQuery('#r4w_box_rename_str_semantic').find('#btn_rename').hide();
               jQuery('#r4w_box_rename_str_semantic').find('#loading').show();
               var name = jQuery("#r4w_box_rename_str_semantic [name='r4w_str_structure_name']").val();
               var semantic_uuid = jQuery(this).closest('#r4w_box_rename_str_semantic').attr('data-strategy');
               jQuery.post(ajaxurl,
                    {
                         'action': 'r4w_exec_str_semantic',
                         'r4w_method': 'r4w_str_semantic_rename',
                         'r4w_str_semantic_uuid': semantic_uuid,
                         'r4w_str_name': name
                    },
                    function(ac_result){
                         jQuery('#r4w_box_rename_str_semantic').find('#btn_rename').show();
                         jQuery('#r4w_box_rename_str_semantic').find('#loading').hide();
                         jQuery("#r4w_box_rename_str_semantic [name='r4w_str_structure_name']").val('');
                         jQuery.modal.close();
                         jQuery( "#str_semantic" ).trigger( "click" );
                    }
               );
          });

    /**
     * Déployement information
     */
          jQuery("#r4w_str_how_deploy").change(function() {
               var deploy_id = jQuery(this).find(":checked").val();
               jQuery("#r4w_str_deploy_info .deploy_info").hide();
               jQuery("#"+deploy_id).show();
          });

    /**
     * Structure sémantique : Déployer
     */
          function r4w_str_semantic_deploy($a){
             jQuery.post(ajaxurl,
               {
                 'action': 'r4w_exec_process',
                 'r4w_request': 'r4w_str_semantic_deploy',
                 'r4w_method': 'PUT',
                 'r4w_deploy': 'tool',
                 'r4w_str_semantic' : $a,
                 'r4w_str_how_deploy' : jQuery('#r4w_box_load_deploy_select #r4w_str_how_deploy').val()
               },
               function(ac_result){
                 var ac_result = JSON.parse(ac_result);
                 if(ac_result.error){
                   jQuery.modal.close();
                 }
                 if(ac_result.success){
                    jQuery.modal.close();
                    r4w_list_deploy();
                 }
               }
             );
          }

    /**
     * Structure sémantique : Duplication
     */
          function r4w_str_semantic_duplicate($a){
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_str_semantic',
                    'r4w_method': 'r4w_str_semantic_duplicate',
                    'r4w_str_semantic_uuid': $a
               },
               function(ac_result){
                    var ac_result = JSON.parse(ac_result);
                    if(ac_result.error){
                         jQuery.modal.close();
                    }
                    if(ac_result.success){
                         jQuery.modal.close();
                         r4w_str_semantic();
                    }
               }
               );
          }

    /**
     * Structure sémantique : Supprimer
     */
          function r4w_str_semantic_delete($a){
          jQuery.post(ajaxurl,
          {
               'action': 'r4w_exec_str_semantic',
               'r4w_method': 'r4w_str_semantic_delete',
               'r4w_str_semantic_uuid': $a
          },
          function(ac_result){
               var ac_result = JSON.parse(ac_result);
               if(ac_result.error){
               }
               if(ac_result.success){
                    r4w_str_semantic();
               }
          }
          );
     }

    /**
     * Structure sémantique : Télécharge l'image
     */
          function r4w_str_semantic_image($a){
          jQuery.post(ajaxurl,
          {
               'action': 'r4w_exec_str_semantic',
               'r4w_method': 'r4w_str_semantic_image',
               'r4w_str_semantic_uuid': $a
          },
          function(ac_result){
               var ac_result = JSON.parse(ac_result);
               if(ac_result.error){
               }
               if(ac_result.success){
                  window.location = ac_result.success.url;
               }
          }
          );
     }

     /**
     * Affiche le temps de comptage
     */
          function countUpFromTime(countFrom, id) {
               countFrom = new Date(countFrom).getTime();
               var now = new Date(),
               countFrom = new Date(countFrom),
               timeDifference = (now - countFrom);
               if(timeDifference < 0){
                    timeDifference = 0;
               }

               var secondsInADay = 60 * 60 * 1000 * 24,
               secondsInAHour = 60 * 60 * 1000;

               //days = Math.floor(timeDifference / (secondsInADay) * 1);
               hours = Math.floor((timeDifference % (secondsInADay)) / (secondsInAHour) * 1);
               mins = Math.floor(((timeDifference % (secondsInADay)) % (secondsInAHour)) / (60 * 1000) * 1);
               secs = Math.floor((((timeDifference % (secondsInADay)) % (secondsInAHour)) % (60 * 1000)) / 1000 * 1);

               var idEl = document.getElementById(id);

               //idEl.getElementsByClassName('days')[0].innerHTML = days;
               idEl.getElementsByClassName('hours')[0].innerHTML = hours;
               idEl.getElementsByClassName('minutes')[0].innerHTML = mins;
               idEl.getElementsByClassName('seconds')[0].innerHTML = secs;

               clearTimeout(countUpFromTime.interval);
               countUpFromTime.interval = setTimeout(function(){ countUpFromTime(countFrom, id); }, 1000);
          }

     /**
     * Pointage vers api système
     */
          r4w_ping_system('r4w_tools');
});

/**
 * Vérification et option du déploiement près selectionner
 */
     function r4w_deploy_semantic(semantic_uuid = null){
          jQuery("#r4w_box_wait").modal({backdrop: 'static',keyboard: false});
          jQuery.post(ajaxurl,
          {
               'action': 'r4w_exec_user_feature',
               'r4w_features': 'editor_deploystructure',
               'r4w_semantic': semantic_uuid
          },
          function(ac_result){
               var ac_result_feature = JSON.parse(ac_result);
               if(ac_result_feature.error){
                    jQuery.modal.close();
               }
               if(ac_result_feature.success.subscription){
                    jQuery.post(ajaxurl,
                    {
                         'action': 'r4w_exec_str_semantic',
                         'r4w_method': 'r4w_str_semantic_deploy'
                    },
                    function(ac_result){
                         var ac_result_deploy = JSON.parse(ac_result);
                         if(ac_result_deploy.error){
                              jQuery.modal.close();
                         }
                         if(ac_result_deploy.success){
                              if(ac_result_deploy.success.process == true){
                                   jQuery.modal.close();
                                   jQuery("#r4w_box_deploy_being").modal({backdrop: 'static',keyboard: false});
                              }else{
                                   jQuery.modal.close();
                                   jQuery("#r4w_box_deploy_str_semantic #r4w_select_deploy_list").html(ac_result_feature.success.structure);
                                   jQuery("#r4w_box_deploy_str_semantic").modal({backdrop: 'static',keyboard: false});
                                   jQuery("#r4w_box_load_deploy_select").show();
                                   jQuery("#r4w_box_load_deploy_select").attr('data-strategy',semantic_uuid);
                                   jQuery('#r4w_deploy_page').html(jQuery('#r4w_str_deploy_uuid option:selected').attr("data-page"));
                                   jQuery('#r4w_price_by_page').html(jQuery('#r4w_str_deploy_uuid option:selected').attr("data-pbp"));
                                   if(ac_result_feature.success.subscription.features.editor_deploystructure){
                                        jQuery('#r4w_deploy_price').html(localize_tools.deploy_included);
                                        jQuery('#r4w_box_deploy_str_semantic').attr('data-deployment','available');
                                   }else{
                                        jQuery('#r4w_deploy_price').html(jQuery('#r4w_str_deploy_uuid option:selected').attr("data-cost"));
                                        jQuery('#r4w_box_deploy_str_semantic').attr('data-deployment','unavailable');
                                   }
                              }
                              jQuery("#r4w_str_deploy_uuid").change(function() {
                                   var page = jQuery(this).children(":selected").attr("data-page");
                                   var price = jQuery(this).children(":selected").attr("data-cost");
                                   jQuery('#r4w_deploy_page').html(page);
                                   jQuery('#r4w_deploy_price').html(price);
                              });
                         }
                    }
                    );
               }
          });
     }
