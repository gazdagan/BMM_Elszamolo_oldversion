<?php

/* 
 * Kp partnerek ripost havi bontásban
 */


include ("./includes/RiportClass.php");
echo'<script>';
include ("./js/copyclipboard.js");
echo '</script>';
echo '<h1>Kp partner bevételek - kp kifizetések orvosonként időszaki bontásban </h1>';

$month1report = new RiportClass();
echo $month1report -> Select_month_form('kppartner_riport');
echo $month1report -> Admin_post_select_mounth();