<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include ("./includes/HaziPenztarClass.php");

echo '<h1>Pénztárgépek napi zárásai</h1>';


$pgzarasok =new HaziPenztarClass;
echo '<div id="HiddenIfPrint"><div class="row">';
echo '<div class="col-sm-12">';
echo $pgzarasok->PenztargepZarasokForm();
echo '</div>';
echo '</div>';
echo '</div>';