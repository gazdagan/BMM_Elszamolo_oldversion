<?php

/* 
 Havi könyvelói összesített adattáble
 */

include ("./includes/MunkaidoClass.php");
echo'<script>';
include ("./js/copyclipboard.js");
//include ("./js/jquery.table2excel.js");
//include ("./js/CreateXls.js");
include ("./js/munkaido.js");
//include ("./js/ajax.js");
echo '</script>';
//echo '<h1>Munkiadő nyilvántartás</h1>';

$havi_osszesítes_riport = new MunkaidoClass();
echo $havi_osszesítes_riport->munkaido_konyveles_havi_queryform();
echo $havi_osszesítes_riport ->Admin_post_munkaido_havikonyeloiexpotrt_query();

echo '<script>
function StartPrtintPage(){
    document.getElementById("HiddenIfPrint").style.display = "none"; 
    $(".HideIfPrint").hide();
    window.print();
}';
echo'</script>';   