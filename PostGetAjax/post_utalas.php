<?php

/**
 * számlák utalásának rögzítése adatbázisban 
 * 
 */

include ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");

if (isset($_POST["szamla_id"]) AND isset($_POST["event"]) ){
    
    $conn = DbConnect();
    $szamla_id = test_input($_POST["szamla_id"]);
    $event = test_input($_POST["event"]);
    $date = test_input($_POST["date"]);
    
    if ($event == "add"){
        $sql2 = "UPDATE szamla_befogadas SET szamla_utalas_date='$date' WHERE szamla_id = '$szamla_id'";
        echo "add ";
    } 
    
    if ($event == "erease"){
        $sql2 = "UPDATE szamla_befogadas SET szamla_utalas_date = NULL WHERE  szamla_id = '$szamla_id'";
        echo "delete ";
    }
  
    if ($conn->query($sql2) === TRUE) {
        echo " Utalva : ".$szamla_id." - " .$date ;
    } else {
        echo " Error updating record: " . $conn->error;
    }


    $conn->close();
    
    
}
