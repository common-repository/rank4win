jQuery(document).ready(function(){

  /**
   * Gestion du menu tab
   */
    r4w_tab();

  /**
   * Récuperation des informations de l'utilisateur
   */
    jQuery('#r4w_box_account').on("click", '#account', function(){
      r4w_subscription_account();
      r4w_account();
    });
    if(jQuery('#r4w_tab_account').is(':visible')){
      r4w_subscription_account();
      r4w_account();
    }
    function r4w_account(){
      jQuery('#box_account #acc_detail').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_email"></div> <div class="ph_firstname"></div> <div class="ph_lastname"></div> </div> </div>');
      jQuery.post(ajaxurl,
        {
          'action': 'r4w_exec_account'
        },
        function(ac_result){
          var ac_result = JSON.parse(ac_result);
          if(ac_result.error){

          }
          if(ac_result.success){
            if(ac_result.success.account.type){
                jQuery('.acc_show_type').hide();
                jQuery('#'+ac_result.success.account.type).show();
                var r4w_acc_type = ac_result.success.account.type;
                jQuery.each(ac_result.success.account[r4w_acc_type], function(index, value){
                  jQuery('#r4w_acc_'+index).val(value);
                });
            }else{
              jQuery('#individual').show();
            }
            jQuery('#box_account #acc_detail').html(ac_result.success.preview);
          }
        }
      );
    }

    /**
     * Change le type du compte
     */
    jQuery("#r4w_acc_type_account").change(function() {
      var type_account_id = jQuery(this).find(":checked").val();
      jQuery("#r4w_box_manage_account .acc_show_type").hide();
      jQuery("#"+type_account_id).show();
    });

    /**
     * Mise à jour des informations utilisateur
     */
    jQuery("#r4w_account_update").submit(function(e){
      event.preventDefault();
      jQuery("#r4w_account_update #loading").show();
      jQuery("#r4w_account_update #btn_take_hand").hide();
      jQuery.post(ajaxurl,
        {
          'action': 'r4w_exec_account',
          'r4w_method': 'r4w_account_update',
          'r4w_data': jQuery(this).serialize(),
        },
        function(ac_result){
          var ac_result = JSON.parse(ac_result);
          if(ac_result.error){

          }
          if(ac_result.success){
            jQuery.modal.close();
            r4w_account();
          }
          jQuery("#r4w_account_update #loading").hide();
          jQuery("#r4w_account_update #btn_take_hand").show();
        }
      );
    });

    function r4w_subscription_account(){
      jQuery('#box_subscription').html('<div class="css-5fedf0e85f"> <div class="css-sf50sdfg5ze"> <div id="acc_sub_date" class="css-sf5egf0ef"><div class="ph-item"> <div class="ph-line"> <div class="ph_sub_date"></div> </div> </div></div> </div> <div class="css-sf52d0fefe"> <div id="acc_sub_title" class="css-f5e0fgegve"><div class="ph-item"> <div class="ph-line"> <div class="ph_title"></div> </div> </div></div> <div id="acc_sub_next_billing" class="css-sq65df6fdv"><div class="ph-item"> <div class="ph-line"> <div class="ph_next_billing"></div> </div> </div></div> </div> </div> <div id="acc_sub_btn" class="css-5fe0f5eze"><div class="ph-item"> <div class="ph-line"> <div class="ph_sub_btn"></div> </div> </div></div>');
      jQuery.post(ajaxurl,
        {
          'action': 'r4w_exec_user_subscription'
        },
        function(ac_result){
          var ac_result = JSON.parse(ac_result);
          if(ac_result.error){

          }
          if(ac_result.success){
               jQuery('#box_subscription').html(ac_result.success.subscription.box);
               if(ac_result.success.subscription.issue){
                    jQuery('#box_issue').html(ac_result.success.subscription.issue);
               }
          }
        }
      );
    }

     /**
     * Gestion du compte
     */
     jQuery("#r4w_box_account").on('click', '#manage_account', function() {
          jQuery("#r4w_manage_account").modal({backdrop: 'static',keyboard: false});
     });


     /**
     * Mise à jour des information de paiements
     */
     jQuery("#r4w_box_account").on('click', '#update_payment', function() {
          jQuery('#r4w_update_payment .r4w_box_stripe_preview').html('<div id="box_cardx" class="r4w_stripe_card"> <div class="ph-item"> <div class="ph-line">  <div class="ph_card_title"></div> <div class="ph_card_number"></div> <div class="ph_card_btn"></div> </div> </div> </div>');
          jQuery("#r4w_update_payment").modal({backdrop: 'static',keyboard: false});
          jQuery.post(ajaxurl,
          {
               'action': 'r4w_exec_stripe',
               'product_type': 'account',
               'stripe_type': 'get_payment'
          },
          function(ac_result){
               var ac_result = JSON.parse(ac_result);
               if(ac_result.error){
                    jQuery.modal.close();
               }
               if(ac_result.success){
                    jQuery('#r4w_update_payment .r4w_box_stripe_preview').html(ac_result.success.preview);
                    r4w_stripe(ac_result.success.stripe.pk);
               }
          });
          return false;
     });

     /**
     * Stripe : Aperçu et vérification de la carte
     */
     function r4w_stripe(a){
          var stripe = Stripe(a);
          var elements = stripe.elements();
          var card = elements.create('card');
          card.mount('#card-element');
          card.addEventListener('change', function(event) {
               var displayError = document.getElementById('card-errors');
               if(event.error){
                    displayError.textContent = event.error.message;
               }else{
                    displayError.textContent = '';
               }
          });
          var form = document.getElementById('payment-form');
          form.addEventListener('submit', function(event) {
               jQuery("#payment-form #loading_payment").show();
               jQuery("#payment-form #success_payment").hide();
               jQuery("#payment-form #error_payment").hide();
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
                         r4w_stripe_TokenHandler(result.token);
                    }
               });
          });
     }

     /**
     * Stripe : Paiement et validation de l'abonnement
     */
     function r4w_stripe_TokenHandler(c){
          jQuery.post(ajaxurl,
          {
               'action': 'r4w_exec_stripe',
               'product_type': 'account',
               'stripe_type': 'update_payment',
               'stripe_token': c.id
          },
          function(ac_result){
               var ac_result = JSON.parse(ac_result);
               if(ac_result.error){
                    jQuery("#payment-form #loading_payment").hide();
                    jQuery("#payment-form #error_payment").show();
                    jQuery("#payment-form #submit_payment").hide();
                    jQuery("#payment-form #success_payment").hide();
               }
               if(ac_result.success){
                    jQuery("#payment-form #error_payment").hide();
                    jQuery("#payment-form #loading_payment").hide();
                    jQuery("#payment-form #success_payment").show();
                    jQuery("#payment-form #submit_payment").hide();
                    window.location = ac_result.success.url;
               }
          });
     }

     /**
     * Annulation de l'abonnement
     */
     jQuery("#r4w_box_account").on('click', '#cancelled_sub', function() {
          jQuery("#r4w_cancelled_sub").modal({backdrop: 'static',keyboard: false});
     });
     jQuery("#r4w_box_account").on('click', '#btn_cancelled_sub.css-35f2ve0f', function() {
          jQuery('#r4w_cancelled_sub #btn_cancelled_sub').hide();
          jQuery('#r4w_cancelled_sub #loading').show();
          var reason = jQuery('.r4w_cancelled_reasons').val();
          jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_stripe',
                    'product_type': 'subscription',
                    'stripe_type': 'canceled',
                    'reason': reason
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
     });

     /**
     * Réactivation de l'annulation
     */
     jQuery("#r4w_box_account").on('click', '#btn_reactivate_sub', function() {
          jQuery('#reactivate_sub #btn_reactivate_sub').hide();
          jQuery('#reactivate_sub #loading').show();
          jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_stripe',
                    'product_type': 'subscription',
                    'stripe_type': 'reactivate',
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
     });

     /**
     * Tentative de paiement
     */
     jQuery("#r4w_box_account").on("click", '#try_again', function() {
          jQuery('#box_issue #try_again').hide();
          jQuery('#box_issue #loading').show();

          jQuery.post(ajaxurl,
          {
               'action': 'r4w_exec_stripe',
               'product_type' : 'subscription',
               'stripe_type': 'unpaid'
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
     });

     /**
     * Femeture de la modal
     */
     jQuery("body").on('click', '#r4w_cancelled_sub .close_modal', function() {
          jQuery.modal.close();
     });
     jQuery('body').on("keyup", '#r4w_cancelled_sub .r4w_cancelled_reasons', function(){
          if( jQuery(this).val() ){
               jQuery("#btn_cancelled_sub").addClass("css-35f2ve0f");
          }else{
               jQuery("#btn_cancelled_sub").removeClass("css-35f2ve0f");
          }
     });

  /**
   * Recupération des liste de vos wordpress
   */
    jQuery('#r4w_box_account').on("click", "#wordpress", function(){
      r4w_list_wordpress();
    });
    if(jQuery('#r4w_list_wordpress').is(':visible')){
      r4w_list_wordpress();
    }
    function r4w_list_wordpress(){
      jQuery('#r4w_list_wordpress').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_list_wordpress"></div> </div> </div>');
      jQuery.post(ajaxurl,
        {
          'action': 'r4w_exec_user_wordpress'
        },
        function(ac_result){
          var ac_result = JSON.parse(ac_result);
          if(ac_result.error){

          }
          if(ac_result.success){
            jQuery('#r4w_list_wordpress').html(ac_result.success.wordpress);
          }
        }
      );
    }

  /**
   * Récuperation des factures de l'utilisateur
   */
    jQuery('#r4w_box_account').on("click", "#invoice", function(){
      r4w_invoice();
    });
    if(jQuery('#r4w_tab_invoice').is(':visible')){
      r4w_invoice();
    }
    function r4w_invoice(){
      jQuery('#r4w_list_invoices').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_list_invoice"></div> <div class="ph_list_invoice"></div> <div class="ph_list_invoice"></div> </div> </div>');
      jQuery.post(ajaxurl,
        {
          'action': 'r4w_exec_user_invoice',
          'r4w_method' : 'list_invoice'
        },
        function(ac_result){
          var ac_result = JSON.parse(ac_result);
          if(ac_result.error){

          }
          if(ac_result.success){
          jQuery('#r4w_list_invoices').html(ac_result.success.invoices);
          }
        }
      );
    }
  /**
   *
   */
    jQuery('#r4w_box_account').on("click", ".r4w_open_pdf_invoice", function(){
      var r4w_btn = jQuery(this);
      jQuery(r4w_btn).closest('.r4w_list_invoice').find("#loading").show();
      jQuery(r4w_btn).closest('.r4w_list_invoice').find(".r4w_btn_menu").hide();
      var invoice_uuid = jQuery(r4w_btn).closest('.r4w_list_invoice').attr('data-uuid');
      var invoice_id = jQuery(r4w_btn).closest('.r4w_list_invoice').attr('data-invoice');
      jQuery.post(ajaxurl,
        {
          'action': 'r4w_exec_user_invoice',
          'r4w_method' : 'pdf_invoice',
          'r4w_uuid' : invoice_uuid,
          'r4w_invoice' : invoice_id
        },
        function(ac_result){
          var ac_result = JSON.parse(ac_result);
          if(ac_result.error){
            jQuery(r4w_btn).closest('.r4w_list_invoice').find("#loading").hide();
            jQuery(r4w_btn).closest('.r4w_list_invoice').find(".r4w_btn_menu").show();
            jQuery(r4w_btn).closest('.r4w_list_invoice').find(".r4w_show_menu").hide();
          }
          if(ac_result.success){
            jQuery(r4w_btn).closest('.r4w_list_invoice').find("#loading").hide();
            jQuery(r4w_btn).closest('.r4w_list_invoice').find(".r4w_btn_menu").show();
            jQuery(r4w_btn).closest('.r4w_list_invoice').find(".r4w_show_menu").hide();
            window.location = ac_result.success.url;
          }
        }
      );
    });


  /**
   * Supprime l'association d'un wordpress
   */
      jQuery("#r4w_box_account").on("click", ".r4w_open_remove_linked", function() {
        jQuery('#r4w_list_wordpress').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_list_wordpress"></div> </div> </div>');
        var r4w_user_wp = jQuery(this).closest('.r4w_list_wordpress').attr('data-uuid');
        jQuery.post(ajaxurl,
          {
            'action': 'r4w_exec_user_wordpress',
            'r4w_method' : 'remove_linked',
            'r4w_uuid': r4w_user_wp
          },
          function(ac_result){
            var ac_result = JSON.parse(ac_result);
            if(ac_result.error){
            }
            if(ac_result.success){
              jQuery('#r4w_list_wordpress').html(ac_result.success.wordpress);
            }
          }
        );
      });

  /**
   * Supprime un wordpress du compte
   */
      jQuery("#r4w_box_account").on("click", ".r4w_open_remove_wordpress", function() {
        jQuery('#r4w_list_wordpress').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_list_wordpress"></div> </div> </div>');
        var r4w_user_wp = jQuery(this).closest('.r4w_list_wordpress').attr('data-uuid');
        jQuery.post(ajaxurl,
          {
            'action': 'r4w_exec_user_wordpress',
            'r4w_method' : 'remove_wordpress',
            'r4w_uuid': r4w_user_wp
          },
          function(ac_result){
            var ac_result = JSON.parse(ac_result);
            if(ac_result.error){
            }
            if(ac_result.success){
              jQuery('#r4w_list_wordpress').html(ac_result.success.wordpress);
            }
          }
        );
      });

  /**
   * Ajouter un abonnement à un wordpress
   */
      jQuery("#r4w_box_account").on("click", '.r4w_open_add_subscription', function() {
        var r4w_remaining = jQuery(this).closest('.r4w_list_wordpress').attr('data-remaining');
        var r4w_uuid = jQuery(this).closest('.r4w_list_wordpress').attr('data-uuid');
        switch (r4w_remaining) {
          case 'true':
            jQuery("#r4w_box_add_subscription").modal();
            jQuery('#r4w_box_add_subscription').attr('data-uuid',r4w_uuid);
          break;
          case 'false':
            jQuery("#r4w_box_change_subscription").modal();
          break;
          case 'empty':
            jQuery("#r4w_box_new_subscription").modal();
          break;
        }
      });

  /**
   * Supprime un abonnement à un wordpress
   */
      jQuery("#r4w_box_account").on("click", ".r4w_remove_subscription", function() {
        jQuery('#r4w_list_wordpress').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_list_wordpress"></div> </div> </div>');
        var r4w_user_wp = jQuery(this).closest('.r4w_list_wordpress').attr('data-uuid');
        jQuery.post(ajaxurl,
          {
            'action': 'r4w_exec_user_wordpress',
            'r4w_method' : 'remove_subscription',
            'r4w_uuid': r4w_user_wp
          },
          function(ac_result){
            var ac_result = JSON.parse(ac_result);
            if(ac_result.error){
            }
            if(ac_result.success){
              jQuery('#r4w_list_wordpress').html(ac_result.success.wordpress);
            }
          }
        );
      });

  /**
   * Ajoute un abonnement à un wordpress
   */
      jQuery("body").on("click", "#r4w_add_subscription", function() {
        jQuery('#r4w_list_wordpress').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_list_wordpress"></div> </div> </div>');
        jQuery.modal.close();
        var r4w_user_wp = jQuery('#r4w_box_add_subscription').attr('data-uuid');
        jQuery.post(ajaxurl,
          {
            'action': 'r4w_exec_user_wordpress',
            'r4w_method' : 'add_subscription',
            'r4w_uuid': r4w_user_wp
          },
          function(ac_result){
            var ac_result = JSON.parse(ac_result);
            if(ac_result.error){
            }
            if(ac_result.success){
              jQuery('#r4w_list_wordpress').html(ac_result.success.wordpress);
            }
          }
        );
      });

  /**
   * Réassocier un abonnement à un wordpress
   */
      jQuery("#r4w_box_account").on("click", ".r4w_reassociate", function() {
        jQuery('#r4w_list_wordpress').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_list_wordpress"></div> </div> </div>');
        var r4w_user_wp = jQuery(this).closest('.r4w_list_wordpress').attr('data-uuid');
        jQuery.post(ajaxurl,
          {
            'action': 'r4w_exec_user_wordpress',
            'r4w_method' : 'reassociate_subscription',
            'r4w_uuid': r4w_user_wp
          },
          function(ac_result){
            var ac_result = JSON.parse(ac_result);
            if(ac_result.error){
            }
            if(ac_result.success){
              jQuery('#r4w_list_wordpress').html(ac_result.success.wordpress);
            }
          }
        );
      });

    /**
     * Lors d'un clique pour ouvrire le menu
     */
      jQuery('#r4w_box_account').on('click', ".r4w_btn_menu", function( event ) {
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
      * Pointage vers api système
      */
         r4w_ping_system('r4w_account');
});