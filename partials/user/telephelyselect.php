<?php

/* 
 * Első menü telephely napi adatainak listája képenyőre
 * telephely kiválasztás a menüben van
 */
//$select_telephely = new telephely_db;
//$select_telephely ->select_telephely();
$folowcode = "'https://datastudio.google.com/reporting/1PRYXQ9TVvrGbcAEY92k5OnN-W03aZmgt/page/08gU'";
echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
. '<a href="https://datastudio.google.com/reporting/1PRYXQ9TVvrGbcAEY92k5OnN-W03aZmgt/page/08gU"  target="_blank"  onclick="trackOutboundLink('.$folowcode.'); return false;" ><strong>Telefonhívások kiértékelése.</strong/> '
        . '<-- Ide kattintva megtekintheted a telefonhívások  összesítését, 2018.06.06. - tól kezdve. Ha kérdésed van hívj. Üdv András!</a></div>';

$table = new User_Select_NapiElsz;
$table->user_select_napiadat_table();
//$table->user_select_medport_jutalekok();
echo'<script type="application/javascript">';
include ('./js/tablarendezes.js')  ; 
echo '</script>';



?>