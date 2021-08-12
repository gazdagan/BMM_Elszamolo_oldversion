<?php

/* 
 * munkaidő elszámolás havi összesítése
 */

include ("./includes/MunkaidoClass.php");
echo'<script>';
include ("./js/copyclipboard.js");
include ("./js/jquery.table2excel.js");
//include ("./js/CreateXls.js");
include ("./js/munkaido.js");
include ("./js/ajax.js");
echo '</script>';
//echo '<h1>Munkiadő nyilvántartás</h1>';

$munkaidoriport = new MunkaidoClass();
echo $munkaidoriport ->DolgozoHavi_MunkaidoTable();
echo $munkaidoriport -> User_post_munkaido_query();
echo $munkaidoriport ->Admin_post_munkaido_havikonyeloiexpotrt_query();

//$munkaidoriport ->RoundDBLogTime();

echo '<script>
function StartPrtintPage(){
    document.getElementById("HiddenIfPrint").style.display = "none"; 
    $(".HideIfPrint").hide();
    window.print();
}';
echo'</script>';   