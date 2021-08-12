<?php

/* 
 * Napi teljesítmény összehasonlító riportolása
 * 
 * használaton kívül
 */
require_once 'includes/AdminNapiRiportClass.php'; 
echo ' <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
echo '<h1>Orvosok kezelők napi összehasonlítása</h1>';

$kezeloriport = new AdminNapiRiportClass ();
$kezeloriport->Admin_Post_Riport_Param();

$kezeloriport->SelectKezeloForm();

echo $kezeloriport->Create_Riport_Table(); 

$kezeloriport->drawchart_script();
