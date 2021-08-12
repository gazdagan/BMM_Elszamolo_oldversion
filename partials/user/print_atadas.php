<?php

/* 
 * Napi átadás táblák nyomtatása
 */

 
   $userselect = new User_Select_NapiElsz;
   $szamla =  new Szamla_befogadasClass;

            echo '<div class="">';
                $userselect ->user_select_all_bevetelektipusok();
                $userselect -> user_select_napiadat_table();
                $userselect ->user_select_kpkivet_table();
                $szamla ->Visualize_All_Szamla_Table_User();
            echo '</div>';

            echo '<script type="text/javascript">
            window.onload = function() { window.print(); }
             </script>';