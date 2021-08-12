<?PHP

/**
 * Adabevitle frontend form minfden esemény ezen a frontend formon keresztül érkezik
 * 
 */
echo '<div id="alertbox"></div>';
$maketable = new napi_elszamolas;
$maketable->Visualize_New_Allin_Szolgaltatas_Form("mai napra");


echo '<div id="elorogzites_table">';
$maketable -> VisualizeNapiElőjegyzésTable($_SESSION["set_telephely"]);
echo '</div>';
echo '<script type="text/javascript">';
include ("./js/allinform.js");
echo '</script>';
?>