jQuery(document).ready(function(){

  /**
   * Gestion du menu tab
   */
    r4w_tab();

    jQuery('#r4w-tabs li#analysis_website').on('click',function( event ) {
      analysis_website();
    });
    jQuery('#r4w-tabs li#analysis_research').on('click',function( event ) {
      analysis_research();
    });
    jQuery('#r4w-tabs li#analysis_competition').on('click',function( event ) {
      analysis_competition();
    });

  /**
   * Récupération des analyses de site web
   */
      function analysis_website(){
        jQuery('#r4w_summary_lastupdate').html('<div id="loading"> <div class="dual-ring"></div> </div>');
        jQuery('#r4w_summary_website').html('<div class="box_cnt css-s5df0zdgrf"> <div class="ph-item"> <div class="ph-line"> <div class="css-5df0f65ef"> <div class="css-5f0efef5g"> <div class="ph_advbox_title"></div> <div class="ph_advbox_sum"></div> </div> <div class="css-sf5f0e5fez"> <div class="ph_advbox_svg"></div> </div> </div> <div class="css-fdf5e0fe"> <div class="ph_advbox_desc"></div> </div> </div> </div> </div> <div class="box_cnt css-s5df0zdgrf"> <div class="ph-item"> <div class="ph-line"> <div class="css-5df0f65ef"> <div class="css-5f0efef5g"> <div class="ph_advbox_title"></div> <div class="ph_advbox_sum"></div> </div> <div class="css-sf5f0e5fez"> <div class="ph_advbox_svg"></div> </div> </div> <div class="css-fdf5e0fe"> <div class="ph_advbox_desc"></div> </div> </div> </div> </div> <div class="box_cnt css-s5df0zdgrf"> <div class="ph-item"> <div class="ph-line"> <div class="css-5df0f65ef"> <div class="css-5f0efef5g"> <div class="ph_advbox_title"></div> <div class="ph_advbox_sum"></div> </div> <div class="css-sf5f0e5fez"> <div class="ph_advbox_svg"></div> </div> </div> <div class="css-fdf5e0fe"> <div class="ph_advbox_desc"></div> </div> </div> </div> </div>');
        jQuery.post(ajaxurl,
          {
            'action': 'r4w_exec_analysis_website'
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
              var result_website = ac_result.success.website.h2b();
              var output_website = result_website.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
                return localize_analysis[contents];
              });
              jQuery('#r4w_summary_lastupdate').html(ac_result.success.lastupdate.h2b());
              jQuery('#r4w_summary_website').html(output_website);
            }
          }
        );
      }

  /**
   * Récupération des analyses de la recherche organique
   */
      function analysis_research(){
        jQuery('#r4w_research_lastupdate').html('<div id="loading"> <div class="dual-ring"></div> </div>');
        jQuery('#r4w_result_research').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> </div> </div>');
        jQuery.post(ajaxurl,
          {
            'action': 'r4w_exec_analysis_research'
          },
          function(ac_result){
            var ac_result = JSON.parse(ac_result);
            if(ac_result.error){

            }
            if(ac_result.success){
              var result_research = ac_result.success.research.h2b();
              var output_research = result_research.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
                return localize_analysis[contents];
              });
              jQuery('#r4w_research_lastupdate').html(ac_result.success.lastupdate.h2b());
              jQuery('#r4w_result_research').html(output_research);
              datatable = jQuery('#table_analysis_research').DataTable(config_datatable);
            }
          }
        );
      }

  /**
   * Récupération des analyses de compétition
   */
      function analysis_competition(){
        jQuery('#r4w_competition_lastupdate').html('<div id="loading"> <div class="dual-ring"></div> </div>');
        jQuery('#r4w_result_competition').html('<div class="ph-item"> <div class="ph-line"> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> <div class="ph_advbox"></div> </div> </div>');
        jQuery.post(ajaxurl,
          {
            'action': 'r4w_exec_analysis_competition'
          },
          function(ac_result){
            var ac_result = JSON.parse(ac_result);
            if(ac_result.error){

            }
            if(ac_result.success){
              var result_competitor = ac_result.success.competitor.h2b();
              var output_competitor = result_competitor.replace(/{_\(\'(.+?)\'\)}/gi, function(match, contents){
                return localize_analysis[contents];
              });
              jQuery('#r4w_competition_lastupdate').html(ac_result.success.lastupdate.h2b());
              jQuery('#r4w_result_competition').html(output_competitor);
              datatable = jQuery('#table_analysis_competitor').DataTable(config_datatable);
            }
          }
        );
      }

  /**
   * Affiche le score des documents en graphique
   */
      jQuery("canvas").each(function(i){
        var r4w_canvas = jQuery(this);
        var r4w_canvas_id = jQuery(this).attr('id');
        if(r4w_canvas_id){
          var a = r4w_canvas.attr('score-any');
          var b = r4w_canvas.attr('score-poor');
          var c = r4w_canvas.attr('score-mediocre');
          var d = r4w_canvas.attr('score-good');
          var e = r4w_canvas.attr('score-perfect');
          switch (r4w_canvas_id) {
            case 'r4w_dashboard_overallscore_post':
                r4w_dashboard_overallscore_post = new Chart(r4w_canvas[0].getContext('2d'), r4w_overscore_config(a,b,c,d,e));
                break;
            case 'r4w_dashboard_overallscore_page':
                r4w_dashboard_overallscore_page = new Chart(r4w_canvas[0].getContext('2d'), r4w_overscore_config(a,b,c,d,e));
                break;
            case 'r4w_dashboard_overallscore_product':
                r4w_dashboard_overallscore_post = new Chart(r4w_canvas[0].getContext('2d'), r4w_overscore_config(a,b,c,d,e));
                break;
          }
        }
      });
      jQuery('body').on('click', 'canvas', function(e) {
        var base_url = jQuery(this).attr('data-url');
        var chart_name = jQuery(this).attr('id');
          switch (chart_name) {
            case 'r4w_dashboard_overallscore_post':
                var slice = r4w_dashboard_overallscore_post.getElementAtEvent(e);
                break;
            case 'r4w_dashboard_overallscore_page':
                var slice = r4w_dashboard_overallscore_page.getElementAtEvent(e);
                break;
            case 'r4w_dashboard_overallscore_product':
                var slice = r4w_dashboard_overallscore_product.getElementAtEvent(e);
                break;
          }
        if (!slice.length) return;
        var label = slice[0]._model.label;
        window.location = base_url+label;
      });

  /**
   * Pointage vers api système
   */
      r4w_ping_system('r4w_analysis');

});