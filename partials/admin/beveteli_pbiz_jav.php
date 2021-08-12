<?php

/* 
 * Házipénztár Bevételi pénztárbizonylat 
 */

require_once './includes/HaziPenztarClass.php';




echo'<div class="container" id ="store_content" >';

$bizonylat = new HaziPenztarClass();
echo $bizonylat -> beveteli_penzterbizonylat_jav();

echo '</div>';

echo'<div class="container">';
echo '<div id="HiddenIfPrint"><div class="btn-group"><a href="#"onclick="  StartPrtintPage('."'bevetel'".')" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>'
. '</div></div>';
echo '</div>';


echo '<script>';
include './js/hazipenztar_napielsz.js';
echo '</script>';
   