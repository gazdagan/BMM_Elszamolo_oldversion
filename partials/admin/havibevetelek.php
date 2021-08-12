<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<h1>'.date ("Y").' Orvosok , kezelők havi forgalma - jutalék összesített tábla.</h1>';

$bevetel_teble = new AdminSelectClass();
$bevetel_teble ->orvos_kezelo_bmmbevetel_table();