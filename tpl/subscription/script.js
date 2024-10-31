jQuery(document).ready(function(){

  /**
   * Récupération des produits disponible
   */
          function r4w_subscription_products(){
               jQuery.post(ajaxurl,
               {
                    'action': 'r4w_exec_products',
                    'method': 'product'
               },
               function(ac_result){
                    var ac_result = JSON.parse(ac_result);
                    if(ac_result.error){
                    }
                    if(ac_result.success){
                         var output_products = r4w_stripslashes(ac_result.success.preview).replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
                         return localize_subscription[contents];
                         });
                         jQuery('#r4w_products').html(output_products);
                    }
               }
               );
          }
          r4w_subscription_products();

    /**
     * Récupération des informations du produit
     */
      jQuery("#r4w_box_subscription").on("click", ".r4w_open_subscribe", function() {
        jQuery('#r4w_box_stripe_preview #r4w_box_stripe').html('<div id="box_cardx" class="r4w_stripe_card"> <div class="ph-item"> <div class="ph-line"> <div class="ph_svglogo"></div> <div class="ph_card_title"></div> <div class="ph_card_number"></div> <div class="ph_card_btn"></div> <div class="ph_card_cvg_1"></div> <div class="ph_card_cvg_2"></div> </div> </div> </div> <div id="box_features" class="r4w_stripe_features"> <div class="ph-item"> <div class="ph-line"> <div class="ph_features_price"></div> <div class="ph_features_title"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> </div> </div> </div>');
        jQuery("#r4w_box_stripe_preview").modal();
        var product_uuid = jQuery(this).closest('.r4w_box_subscription').attr("data-plan");
        var product_unit = jQuery(this).closest('.r4w_box_subscription').attr("data-unit");
        jQuery.post(ajaxurl,
          {
            'action': 'r4w_exec_products',
            'method': 'product',
            'product_uuid': product_uuid,
            'product_unit': product_unit
          },
          function(ac_result){
            var ac_result = JSON.parse(ac_result);
            if(ac_result.error){
              jQuery.modal.close();
            }
            if(ac_result.success){
              if(ac_result.success.preview){
                   var output_products = r4w_stripslashes(ac_result.success.preview).replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
                        return localize_subscription[contents];
                   });
                   jQuery('#r4w_box_stripe_preview #r4w_box_stripe').html(output_products);
                /**
                 * Applique le nouveau prix en fonction de la quantité
                 */
                  jQuery('body.admin_page_r4w_subscription').on("change", 'input[name="product_unit"]',function(){
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
                r4w_stripe(ac_result.success.stripe.pk,product_uuid);
              }else{
                jQuery.modal.close();
              }
            }
          }
        );
        return false;
      });

     /**
      * Ouvre la box chèques cadeaux et codes promotionnels
      */
     jQuery("body.admin_page_r4w_subscription").on("click", "#r4w_pormo_code", function() {
          jQuery("#r4w_box_stripe_discount").show();
          jQuery("#r4w_discount").html("");
          jQuery("r4w_discount").attr('data-code','');
     });

     /**
     * Vérification du code promotionnel
     */
     jQuery("body.admin_page_r4w_subscription").on("click", "#submit_discount", function() {
          jQuery("#r4w_box_stripe_discount #discount_btn").hide();
          jQuery("#r4w_box_stripe_discount #loading").show();
          var discount_code = jQuery("#r4w_code_discount").val();
          jQuery.post(ajaxurl,
               {
               'action': 'r4w_exec_stripe',
               'product_type': 'subscription',
               'stripe_type': 'discount',
               'product_discount': discount_code,
               },
               function(ac_result){
                    var ac_result = JSON.parse(ac_result);
                    if(ac_result.error){
                         jQuery("#r4w_box_stripe_discount").hide();
                         jQuery("#r4w_discount").html("");
                         jQuery("r4w_discount").attr('data-code','');
                         jQuery("#r4w_box_stripe_discount #discount_btn").show();
                         jQuery("#r4w_box_stripe_discount #loading").hide();
                         jQuery("#r4w_code_discount").val('');
                    }
                    if(ac_result.success){
                         jQuery("#r4w_box_stripe_discount").hide();
                         jQuery("#r4w_discount").html(ac_result.success.msg);
                         jQuery("#r4w_discount").attr('data-code', ac_result.success.code);
                         jQuery("#r4w_box_stripe_discount #discount_btn").show();
                         jQuery("#r4w_box_stripe_discount #loading").hide();
                    }
               }
          );
     });

     /**
      * Ferme la box chèques cadeaux et codes promotionnels
      */
     jQuery("body.admin_page_r4w_subscription").on("click", "#r4w_cancel_pormo_code", function() {
          jQuery("#r4w_box_stripe_discount").hide();
     });

    /**
     * Diminution quantité option
     */
     jQuery("body.admin_page_r4w_subscription").on("click", "button.quantity_down", function() {
          var product_unit = jQuery(this).parent().find('input[name="product_unit"]');
          var num = +product_unit.val() - 1;
          product_unit.val(num);
          jQuery(product_unit).trigger('change');
     });

    /**
     * Augementation quantité option
     */
     jQuery("body.admin_page_r4w_subscription").on("click", "button.quantity_up", function() {
          var product_unit = jQuery(this).parent().find('input[name="product_unit"]');
          var num = +product_unit.val() + 1;
          product_unit.val(num);
          jQuery(product_unit).trigger('change');
     });

  /**
   * Stripe : Aperçu et vérification de la carte
   */
    function r4w_stripe(a,b){
      var stripe = Stripe(a);
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
            var c = jQuery('#r4w_box_stripe .quantity').val();
            r4w_stripe_TokenHandler(b,c,result.token);
          }
        });
      });
    }

  /**
   * Stripe : Paiement et validation de l'abonnement
   */
     function r4w_stripe_TokenHandler(a,b,c){
          var r4w_discount = jQuery('#r4w_discount').attr('data-code');
      jQuery.post(ajaxurl,
        {
          'action': 'r4w_exec_stripe',
          'product_type': 'subscription',
          'stripe_type': 'add',
          'product_uuid': a,
          'product_unit': b,
          'product_discount': r4w_discount,
          'stripe_token': c.id
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
            jQuery("#payment-form #error_payment").hide();
            jQuery("#payment-form #loading_payment").hide();
            jQuery("#payment-form #success_payment").show();
            jQuery("#payment-form #submit_payment").hide();
            window.location = ac_result.success.url;
          }
        }
      );

     }

  /**
   * Pointage vers api système
   */
      r4w_ping_system('r4w_subscription');
});