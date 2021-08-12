<?php

/* 
 * napi elszámolás adat
 * 
 * használaton kívül
 */
$maketable = new napi_elszamolas;
$maketable->Visualize_New_Szolgaltats_Form();

$t = new User_Select_NapiElsz;
$t->user_napi_medportszamla();
?>