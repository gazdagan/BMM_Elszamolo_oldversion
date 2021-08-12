<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo '<h1>'.date ("Y").' Orvosok , kezelők  összesített havi jutalék tábla.</h1>';

$jutalektable = new AdminSelectClass;
$jutalektable->havi_jutalek_table();
