<?php 
    if ( ! function_exists( 'r4w_tpl' ) ) {
		/**
		 * Récupération automatique des élements du template
		 */
			function r4w_tpl($tpl_data){
				$r4w_folder = $tpl_data["folder"];
				
				$ctd = new r4w_template(r4w_plugin_folder."/tpl/".$r4w_folder."/contained.tpl");

				/**
				 * Charge le scripts
				 */ 
				if(file_exists(r4w_plugin_folder."/tpl/".$r4w_folder."/_root.php")){
					require r4w_plugin_folder."/tpl/".$r4w_folder."/_root.php";
				}

				/**
				 * Charge le javascript
				 */ 
				if(file_exists(r4w_plugin_folder."/tpl/".$r4w_folder."/script.js")){
					$r4w_translation_javascript = r4w_fcnt_locale($r4w_folder);
				    $r4w_plugin = [
				    	"url" => r4w_plugin_url
				    ];
				    wp_register_script( md5($r4w_folder.'/script.js'),  r4w_plugin_url .'tpl/'.$r4w_folder.'/script.js','',md5(r4w_get_version()), true );
				    wp_localize_script( md5($r4w_folder.'/script.js'), 'localize_'.$r4w_folder, $r4w_translation_javascript);
				    wp_localize_script( md5($r4w_folder.'/script.js'), 'r4w_plugin', $r4w_plugin);
				    wp_enqueue_script( md5($r4w_folder.'/script.js'));
				}
				return $ctd->output();
			}
	}