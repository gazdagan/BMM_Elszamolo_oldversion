<?php

/* 
 *orvos kezeló telephely jutalélk allinriport
 */

include ("./includes/RiportClass.php");
echo'<script>';
include ("./js/copyclipboard.js");
echo '</script>';
echo '<h1>Telephelyek orvosok kezelők bevétel jutalék időszaki bontásban </h1>';

$month1report = new RiportClass();
echo $month1report -> Select_month_form('3_allin_riport');
echo $month1report -> Admin_post_select_mounth();