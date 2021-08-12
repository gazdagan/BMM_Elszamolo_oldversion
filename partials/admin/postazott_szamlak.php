<?php

/* 
 *postázott szálák kezelése a napi_elszámolás táblában 
 */
include ("./includes/Postazott_szamlakClass.php");
echo '<script>';
require_once './js/Postazas.js';
echo '</script>';

echo '<h1>Adv. med. és Ep. számlák postázásának nyilvántartása.</h1>';

$szamlak = new Postazott_szamlakClass();

echo '<div id="HiddenIfPrint"><div class="row">';
echo '<div class="col-sm-12">';
echo $szamlak->AdminSelectForm();
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="containr"><div class="row><div class="col-sm-12">';
    $szamlak->AdminPostQuery(); 

echo '</div></div></div>';


echo '<script>
function StartPrtintPage(){
    document.getElementById("HiddenIfPrint").style.display = "none"; 
    $(".HideIfPrint").hide();
    window.print();
}';
echo'</script>';    