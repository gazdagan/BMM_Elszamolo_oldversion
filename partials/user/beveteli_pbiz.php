<?php
/* 
* Házipénztár Bevételi pénztárbizonylat 
*/
require_once './includes/HaziPenztarClass.php';
echo '<script>';
require_once './js/penztarbizonylat.js';
require_once './js/NumberToString.js';
echo '</script>';
echo'<div class="container" id ="store_content" >';

$bizonylat = new HaziPenztarClass();
echo $bizonylat -> beveteli_penzterbizonylat();

echo '</div>';

echo'<div class="container">';
echo '<div id="HiddenIfPrint"><div class="btn-group"><a href="#"onclick="  StartPrtintPage('."'bevetel'".')" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>'
. '<button type="button" class="btn btn-success" onclick="bizonylat_kitolt()">Számol</button>'
        . '</div></div>';
echo '</div>';


echo '<script>';
echo 'window.onload =bizonylat_kitolt();';
include './js/hazipenztar_napielsz.js';
echo '</script>';
   