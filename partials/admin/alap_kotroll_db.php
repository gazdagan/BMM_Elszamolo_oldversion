<?php

/* 
 havi alap / kotrollviszálat riport
 */

include ("./includes/RiportClass.php");
echo'<script>';
include ("./js/copyclipboard.js");
include ("./js/jquery.table2excel.js");
include ("./js/CreateXls.js");
echo '</script>';
echo '<h1>Orvosok havi alapvizsgálat / kontroll darabszámok</h1>';

$month1report = new RiportClass();
echo $month1report -> Select_month_form('alap_kotroll_dr');
echo $month1report -> Admin_post_select_mounth();