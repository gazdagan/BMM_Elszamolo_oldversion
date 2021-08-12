<?php

/* 
 * Készletnyilvántartás adminisztrációs oldala 
 */

include ("./includes/keszletnyilvantartasClass.php");
echo'<script>';
include ("./js/copyclipboard.js");
include ("./js/ajax.js");
include ("./js/keszletkezeles.js");

echo '</script>';


$keszletkezeles= new keszletnyilvantartasClass();
echo $keszletkezeles -> Tabmenu();
echo $keszletkezeles ->kategoria_add_popup();