/**
 * addslashes — Ajoute des antislashs dans une chaîne
 * stripslashes — Supprime les antislashs d'une chaîne
 */
     function r4w_addslashes(str) {
         str = str.replace(/\\/g, '\\\\');
         str = str.replace(/\'/g, '\\\'');
         str = str.replace(/\"/g, '\\"');
         str = str.replace(/\0/g, '\\0');
         return str;
     }

     function r4w_stripslashes(str) {
         str = str.replace(/\\'/g, '\'');
         str = str.replace(/\\"/g, '"');
         str = str.replace(/\\0/g, '\0');
         str = str.replace(/\\\\/g, '\\');
         return str;
     }