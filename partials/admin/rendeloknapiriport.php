<?php

/* 
 *Rendelők napi riportjának visszakerelsés riposrtok ujraelőállítása
 * 
 */
$riport = new User_Select_NapiOsszesito();
echo'<script>';
//include ("./js/copyclipboard.js");
include ("./js/jquery.table2excel.js");
include ("./js/CreateXls.js");
echo '</script>';

echo '<div class="row" id="HiddenIfPrintForm">'
. '<div class="col-sm-4"> ';   
echo $riport->Napizaras_Form();
echo '</div></div>';
echo $riport->admin_post_zarasdate();


echo '<script>
function StartPrtintPage(){
    document.getElementById("HiddenIfPrint").style.display = "none"; 
    document.getElementById("HiddenIfPrintForm").style.display = "none"; 

    
     window.print();
}  
function copyClipboard(){
    var text = document.getElementById("riport");
    var range = document.createRange();
         
    range.selectNode(text);
    window.getSelection().addRange(range);
    document.execCommand("copy");   
    
}'; 

echo'</script>';     