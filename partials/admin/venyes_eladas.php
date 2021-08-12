<?php

/* 
 * vényes ealdások lista 
 */

include ("./includes/Postazott_szamlakClass.php");
echo '<script>';
require_once './js/Postazas.js';
//include ("./js/keszletkezeles.js");
echo '</script>';

echo '<h1>Vények elszámolásásnak nyilvántartása.</h1>';

$szamlak = new Postazott_szamlakClass();

echo '<div id="HiddenIfPrint"><div class="row">';
echo '<div class="col-sm-12">';
echo $szamlak->AdminSelectVenyForm();
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="containr"><div class="row><div class="col-sm-12">';
    $szamlak->AdminPostVenyQuery(); 

echo '</div></div></div>';





