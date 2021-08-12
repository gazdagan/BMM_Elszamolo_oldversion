<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './includes/HaziPenztarClass.php';
//include ( "./includes/Inputvalidation.inc.php");

$jav_bizonylat = new HaziPenztarClass();

echo '<div class="container">';

$jav_bizonylat ->user_post_pbizid_jav(); 

echo '</div>';

echo '<script>';
include './js/hazipenztar_napielsz.js';
echo '</script>';
   