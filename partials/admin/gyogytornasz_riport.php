<?php

/* 
 *Gyógytornászok időszakos rioirtolása
 */

include ("./includes/gyogytornasz_ripotrtClass.php");
echo '<script>';
include ("./js/copyclipboard.js");
echo '</script>';
$riport = new gyogytornasz_ripotrtClass(); 

echo $riport->Gyt_riport_form();

echo $riport->admin_post_gytquery();


echo '<script>
    function StartPrtintPage(){
        
        document.getElementById("HiddenIfPrint").style.display = "none"; 
        
        window.print();

}

function copyClipboard(){
    var text = document.getElementById("riport");
    var range = document.createRange();
         
    range.selectNode(text);
    window.getSelection().addRange(range);
    document.execCommand("copy");
    
    
}';
echo '</script>';