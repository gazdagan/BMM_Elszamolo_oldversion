<?php

$jutalekallinform = new User_Select_NapiOsszesito;
//$tableform->select_orvos_naipjutaléklista();
$jutalekallinform->jutalek_kifiz_allfunction_form();
echo '<script>
    function StartPrtintJutalekPage(){
        
        document.getElementById("HiddenIfPrint").style.display = "none"; 
        
        window.print();

}

    document.getElementById("szamla_kibocsato").value = '.'"'.$jutalekallinform->kp_kivevo_kezelo.'"'.';
    document.getElementById("kivet_atvevo").value = '.'"'.$jutalekallinform->kp_kivevo_kezelo.'"'.';
    document.getElementById("kp_kivet_osszeg").value = '.'"'.$jutalekallinform->kp_kivet_osszeg.'"'.';
    document.getElementById("kp_kivet_osszeg").readOnly = true;

function duplicate(str){
    console.log(str);
    if (str == "") {
        document.getElementById("szamla_megjegyzes").innerHTML = "";
        return;
    } else {
       document.getElementById("szamla_megjegyzes").value = str;    
    }

}
</script>';
// ha kezelő orvos kppartner legyen a számlaszám helyett KP-partner        
if ($jutalekallinform->kp_padtner == "TRUE") {
    
   echo '<script>document.getElementById("szamla_szama").value = "KP PARTNER"; '
        . 'document.getElementById("szamla_szama").readOnly = true;'
           . ''
           . '</script>';
    
}       
        
?>