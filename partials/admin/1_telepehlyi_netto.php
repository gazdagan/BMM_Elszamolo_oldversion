<?php

/* 
 * telephelyek havi bontásó nettó forgalmi adatai
 */
include ("./includes/RiportClass.php");
echo'<script>';
include ("./js/copyclipboard.js");
include ("./js/jquery.table2excel.js");
include ("./js/CreateXls.js");
echo '</script>';
echo '<h1>Telephelyi netto tábla</h1>';

$month1report = new RiportClass();
echo $month1report -> Select_month_form('1_telephely_riport');
echo $month1report -> Admin_post_select_mounth();