<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once './includes/HaziPenztarClass.php';
echo '<h1>Rendelő pénztárbizonylatainak listája</h1>';

$bizonylat_lista = new HaziPenztarClass();
echo $bizonylat_lista ->hazip_bizonylat_keres_form();
echo '<div class = "container">';
echo $bizonylat_lista->UserPostQuery_Penztarbiz_kereses();
echo '</div>';

