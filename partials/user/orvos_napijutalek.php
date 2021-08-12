<?php

/* 
 * ORVOS NAPI JUTALÉKLISTA NYOMTATÁSA
 */

$jutalekform = new User_Select_NapiOsszesito;
$jutalekform->select_orvos_naipjutaléklista();
echo '<script>
    function StartPrtintJutalekPage(){
        
        document.getElementById("HiddenIfPrint").style.display = "none"; 
        
        window.print();

}
</script>';