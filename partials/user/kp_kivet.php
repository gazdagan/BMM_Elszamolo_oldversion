<?php

/* 
 * Kp kivét frontend form megjelenítése
 */



$kpform = new Keszpenz_kivetClass;
$kpform->Visualize_Kpkivet_Form();

echo '<script type="text/javascript">';
include ("./js/kpkivet.js");

echo '</script>';
echo '<script type="text/javascript">

function upload_file_require(){
    document.getElementById("szamlakep").style.display = "block"
   
    document.getElementById("szamla_sorszam").required = true;
    document.getElementById("szamla_kibocsato").required = true;
    document.getElementById("fileToUpload").required = true;
}        
function upload_file_NOTrequire(){
   document.getElementById("szamlakep").style.display = "none"
   
   document.getElementById("szamla_sorszam").required = false;
   document.getElementById("szamla_kibocsato").required = false;
   document.getElementById("fileToUpload").required = false;

}

</script>';