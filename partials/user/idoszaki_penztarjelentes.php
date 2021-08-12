<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include ("./includes/HaziPenztarClass.php");
echo '<script>';
include ("./js/copyclipboard.js");
echo '</script>';

//echo '<h1>Időszaki pénztárjelentés nyomtatása</h1>';

$penztarjelentes = new HaziPenztarClass();

echo '<div id="HiddenIfPrint"><div class="row">';
echo '<div class="col-sm-12">';
echo $penztarjelentes->idoszaki_penztarjelentes_form();
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="container"><div class="row><div class="col-sm-12">';
echo $penztarjelentes->UserPostQuery_IdőszakiPenztarjelentesTable(); 

echo '</div></div></div>';


echo '<script>
function StartPrtintPage(){
    document.getElementById("HiddenIfPrint").style.display = "none"; 
    $(".HideIfPrint").hide();
    window.print();
}';
echo'</script>';    