<?php

/* 
 *Irodai célúszámalképek feltöltése
 */

echo '<h1>IRODAI számlaképek feltöltése</h1>';

$szamla =  new Szamla_befogadasClass;
$szamla->user_post_szamlabefogadas();
$szamla->VisualizeSzamlaBefogadasForm_Admin();
echo '<div class="container">';
$szamla->telephely = "iroda";
echo $szamla->Visualize_All_Szamla_Table_User("napiosszes");
echo '</div>';

