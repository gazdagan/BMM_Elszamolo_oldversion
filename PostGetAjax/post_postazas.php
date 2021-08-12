<?php

/* 
 * postázott bizonylatok dátomozása és rögzítése
 * 
 */

include ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");

if (isset($_POST["id_szamla"]) AND isset($_POST["event"]) ){
    
    $conn = DbConnect();
    $id_szamla = test_input($_POST["id_szamla"]);
    $event = test_input($_POST["event"]);
    $date = test_input($_POST["date"]);
    
    if ($event == "add"){
        $sql2 = "UPDATE napi_elszamolas SET szamla_postazas='$date' WHERE id_szamla = '$id_szamla'";
        echo "add ";
    } 
    
    if ($event == "erease"){
        $sql2 = "UPDATE napi_elszamolas SET szamla_postazas = NULL WHERE id_szamla = '$id_szamla'";
        echo "delete ";
    }
  
    if ($conn->query($sql2) === TRUE) {
        echo " Postazva:".$id_szamla." - " .$date ;
    } else {
        echo " Error updating record: " . $conn->error;
    }


    $conn->close();
    
    
}

