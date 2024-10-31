/**
 * Gestion des menus tabs
 */
     function r4w_tab(){
          /**
          * Si une demande d'ouverture d'onglet est demander
          */
               if(jQuery('#r4w-tabs').attr('tab-open')){
                    var data_tab = jQuery('#r4w-tabs').attr('tab-open');
                    var tab_index = jQuery('#r4w-tabs li#'+data_tab).index()+1;
               }
               if (typeof tab_index === "undefined" || tab_index == 0) {
                    var tab_index = 1;
               }

          /**
          * Permet d'ouvrire les onglets
          */
               jQuery('.tab_content').hide();
               jQuery('#r4w-tabs li:nth-child('+tab_index+')').addClass('active').show();
               jQuery('.tab_content:nth-child('+tab_index+')').show();
               var tab_box_page = jQuery('#r4w-tabs li:nth-child('+tab_index+')').attr('id');
               jQuery('#r4w_tab_'+tab_box_page+' #r4w_box_tabs li').first().addClass('active');
               jQuery('#r4w_tab_'+tab_box_page+' #r4w_box_pages .page_tab').first().addClass('active');

          /**
          * Lors d'un clique dans les ongles pages (haut)
          */
               jQuery('#r4w-tabs li').on('click',function( event ) {
                    var tab_box_page = jQuery(this).attr('id');
                    jQuery('#r4w-tabs li').removeClass('active');
                    jQuery(this).addClass('active');
                    jQuery('.tab_content').hide();
                    jQuery('#r4w_tab_'+tab_box_page).fadeIn();
                    jQuery('#r4w_tab_'+tab_box_page+' #r4w_box_tabs .btn_tab').removeClass('active');
                    jQuery('#r4w_tab_'+tab_box_page+' #r4w_box_pages .page_tab').removeClass('active');
                    jQuery('#r4w_tab_'+tab_box_page+' #r4w_box_tabs li').first().addClass('active');
                    jQuery('#r4w_tab_'+tab_box_page+' #r4w_box_pages .page_tab').first().addClass('active');
                    if(jQuery('#r4w_tab_'+tab_box_page+' #r4w_box_pages .page_tab').first().find('#r4w_box_subtabs').length){
                         jQuery('#r4w_tab_'+tab_box_page+' #r4w_box_pages .page_tab').first().find('#r4w_box_subtabs .btn_subtab').removeClass('active');
                         jQuery('#r4w_tab_'+tab_box_page+' #r4w_box_pages .page_tab').first().find('#r4w_box_subpages .page_subtab').removeClass('active');
                         jQuery('#r4w_tab_'+tab_box_page+' #r4w_box_pages .page_tab').first().find('#r4w_box_subtabs .btn_subtab').first().addClass('active');
                         jQuery('#r4w_tab_'+tab_box_page+' #r4w_box_pages .page_tab').first().find('#r4w_box_subpages .page_subtab').first().addClass('active');
                    }
               });

          /**
          * Lors d'un clique dans les ongles menu (gauche)
          */
          jQuery( "#r4w_box_tabs li" ).on('click',function( event ) {
               var tab_box_page = jQuery(this).attr('id');
               if(jQuery('#r4w_st_'+tab_box_page+' #r4w_box_subtabs').length){
                    jQuery('#r4w_st_'+tab_box_page+' #r4w_box_subtabs .btn_subtab').removeClass('active');
                    jQuery('#r4w_st_'+tab_box_page+' #r4w_box_subpages .page_subtab').removeClass('active');
                    jQuery('#r4w_st_'+tab_box_page+' #r4w_box_subtabs .btn_subtab').first().addClass('active');
                    jQuery('#r4w_st_'+tab_box_page+' #r4w_box_subpages .page_subtab').first().addClass('active');
               }
               jQuery('#r4w_box_tabs .btn_tab').removeClass('active');
               jQuery('#r4w_box_pages .page_tab').removeClass('active');
               jQuery(this).addClass('active');
               jQuery('#r4w_box_pages #r4w_st_'+tab_box_page).addClass('active');
          });

          /**
          * Lors d'un clique dans les ongles sous menu (interieur haut)
          */
          jQuery( "#r4w_box_subtabs li" ).on('click',function( event ) {
               var subtab_page = jQuery(this).attr('id');
               jQuery('#r4w_box_subtabs .btn_subtab').removeClass('active');
               jQuery('#r4w_box_subpages .page_subtab').removeClass('active');
               jQuery(this).addClass('active');
               jQuery('#r4w_box_subpages #r4w_sst_'+subtab_page).addClass('active');
          });
     }