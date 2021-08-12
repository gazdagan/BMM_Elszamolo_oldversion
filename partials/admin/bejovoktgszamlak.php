<?php

/* 
 *bejövő ktg számlák 
 */


include ("./includes/bejovoszamlaknyilvantartasClass.php");
echo'<script>';
include ("./js/copyclipboard.js");
include ("./js/ajax.js");
include ("./js/ktgszamlak.js");

echo '</script>';



$ktgszamlak = new bejovoszamlaknyilvantartasClass();
echo $ktgszamlak -> Tabmenu();
