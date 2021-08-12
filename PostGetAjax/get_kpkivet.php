<?php
/**
*készpénz kivét jutalék elszámolás az adott napra 
*/

include ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");
//echo 'PHP call ok'; 
if (isset($_GET["kivet_kezelo"]) AND isset($_GET["telephely"]) ){
 
    $conn = DbConnect();
    $kezelo_neve = test_input($_GET["kivet_kezelo"]);
    $telephely = test_input($_GET["telephely"]);
   
    $date = date("y-m-d");

    // kezelő orvos jutaléka az adott napon recepcióstól függetlenül
    $sql1 = "SELECT sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE date = '$date' AND torolt_szamla = '0' AND kezelo_orvos_id = '$kezelo_neve' AND  telephely = '$telephely'";

    $result = $conn->query($sql1);
        
    
    if ($result->num_rows > 0) {    
        while ($row = $result->fetch_assoc()) {
            echo $row["sum_jutalek"];
            }
    }else{echo "Nincs rögzített adat";}
    
}
?>