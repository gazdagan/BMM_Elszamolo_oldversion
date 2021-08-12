<?php
/**
 * Jutalék elszámolási lista könyvelés felé drvosok időszaki tétekléei
 * 
 */
$tableform = new AdminSelectClass();
// ha orvos kérdezi le a jutalékot nem kell a form 

$tableform->select_orvos_idoszaki_jutaléklista();






echo '<script>
    function StartPrtintJutalekPage(){
        
        document.getElementById("HiddenIfPrint").style.display = "none"; 
        
        window.print();

}
</script>'
?>
