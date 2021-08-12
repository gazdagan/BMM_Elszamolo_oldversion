<?php

/* 
 * készletek áthelyezése felhasználóknak
 */



include ("./includes/keszletnyilvantartasClass.php");
echo'<script>';
include ("./js/copyclipboard.js");
include ("./js/ajax.js");
include ("./js/keszletkezeles.js");
echo '</script>';

echo'<div class="container" id ="store_content">';
echo'<h1 style="color:red;"><strong>TESZTELÉS ALATT NE HASZNÁLD </strong></h1>';
$keszletmozgas = new keszletnyilvantartasClass();
echo $keszletmozgas -> szallitolevel_rendelok_kozott();
echo '</div>';