<?php

/* 
 * Pillanatnyilag nics használva
 */

$napi_zaras = new napi_elszamolas;
$napi_zaras_tablak = new User_Select_NapiElsz_NapiZarasClass;

echo '<div class="row">';
  echo '<div class="col-sm-2"></div>';
   echo '<div class="col-sm-4">';
    $napi_zaras_tablak->napi_select_medport_bevetelek();
   echo '</div>';
  echo '<div class="col-sm-4">';
    $napi_zaras_tablak->user_select_napi_medicalplus_bevetelek();
   echo '</div>';
echo '<div class="col-sm-2"></div>';
   echo '</div>'; 
$napi_zaras_tablak->user_select_napi_jutalekelszamolas();
$napi_zaras_tablak->user_read_napielsz_all_szamla();

?>