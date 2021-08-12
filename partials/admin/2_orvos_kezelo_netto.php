<?php

/* 
 telephelyenkén örvösonként nettó havi bontásó riport
 */
include ("./includes/RiportClass.php");
echo'<script>';
include ("./js/copyclipboard.js");
echo '</script>';
echo '<h1>Orvosok kezelők telephelyenkénti netto tábla</h1>';

$month1report = new RiportClass();
echo $month1report -> Select_month_form("2_kezelo_riport");
echo $month1report -> Admin_post_select_mounth();
