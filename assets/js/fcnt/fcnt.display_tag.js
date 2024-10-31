/**
 * Affiche la suggestion de mot-clé
 */
  function r4w_display_tag(preview_text){
    var r4w_obj_tag = jQuery.parseJSON( jQuery('#r4w_tag_value').attr('data-tag').h2b() );
    preview_text = preview_text.replace(/%%(.+?)%%/g, function(match, contents, offset, input_string)
        {
          if(typeof r4w_obj_tag[contents] !== "undefined"){
            return r4w_obj_tag[contents]
          }else{
            return '';
          }
        }
    );
    return preview_text;
} 