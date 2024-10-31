<?php
if ( ! class_exists( 'r4w_template' ) ) {
     class r4w_template {
          /**
          * Le nom du fichier à charger
          */
          protected $file;
          
          /**
          * Un tableau de valeurs pour remplacer chaque balise sur le modèle (la clé de chaque valeur est la balise correspondante).
          */
          protected $values = array();

          /**
          * Crée un nouvel objet Template et définit son fichier associé.
          */
          public function __construct($file) {
               $this->file = $file;
          }

          /**
          * Définit une valeur pour remplacer une balise spécifique.
          */
          public function set($key, $value) {
               $this->values[$key] = $value;
          }
          public function gettext_tpl(){

          }
          /**
          * Affiche le contenu du modèle, en remplaçant les clés par leurs valeurs respectives.
          */
          public function output() {
               /**
               * Essaie de vérifier si le fichier existe.
               * S'il ne revient pas avec un message d'erreur
               * Tout le reste charge le contenu du fichier et effectue une boucle dans le tableau en remplaçant chaque clé par sa valeur.
               */
               if (!file_exists($this->file)) {
                    return "Erreur lors du chargement du fichier modèle : $this->file <br />";
               }
               $output = file_get_contents($this->file);

               foreach ($this->values as $key => $value) {
                    $tagToReplace = "[@$key]";
                    $output = str_replace($tagToReplace, $value, $output);
               }
               /**
               * Récupère et inclus les svg dans la page tpl
               */
               $output = preg_replace_callback('/\[@svg_([^\'\)}].*)\]/',function($matches){return r4w_assets_svg_code($matches[1]);} ,$output);

               /**
               * Récupère et inclus les traductions dans la page tpl
               */
               $output = preg_replace_callback('/{_\(\'([^\'\)}].*)\'\)}/',function($matches){return __($matches[1], 'app_rank4win');} ,$output);



               return $output;
          }

          /**
          * Fusionne le contenu d'un tableau de modèles et le sépare avec le $separator.
          */
          static public function merge($templates, $separator = "\n") {
               /**
               * Boucles dans le tableau concaténant les sorties de chaque modèle, en les séparant avec le $separator.
               * Si un type différent de Template est trouvé, nous fournissons un message d'erreur.
               */
               $output = "";

               foreach ($templates as $template) {
                    $content = (get_class($template) !== "Template")
                    ? "Error, incorrect type - expected Template."
                    : $template->output();
                    $output .= $content . $separator;
               }
               return $output;
          }
     }
}
