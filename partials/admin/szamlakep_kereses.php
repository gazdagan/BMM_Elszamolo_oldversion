<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo '<script>';
require_once './js/utalasos_szamlak.js';
echo '</script>';
echo'<h1>Számlaképek</h1>';
$szamlakep =  new Szamla_befogadasClass;
echo $szamlakep->Szamlakekek_Keres_Form();

echo '<div class= "">';
echo $szamlakep->AdminPostSzamlaKereses();
echo '</div>';