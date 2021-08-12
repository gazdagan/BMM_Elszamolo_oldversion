<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include ("./includes/RiportClass.php");
echo'<script>';
include ("./js/copyclipboard.js");
include ("./js/jquery.table2excel.js");
include ("./js/CreateXls.js");
echo '</script>';
echo '<h1>Medical Plusz Kft havi forgalomi tábla</h1>';

$month1report = new RiportClass();
echo $month1report -> Select_month_form('4_medicalplusz_riport');
echo $month1report -> Admin_post_select_mounth();