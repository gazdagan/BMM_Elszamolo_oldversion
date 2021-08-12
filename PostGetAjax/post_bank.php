<?php

/* 
 * postázott számaltételek banki utalások dátumozása
 */



include ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");

if (isset($_POST["id_szamla"]) AND isset($_POST["event"]) ){
    
    $conn = DbConnect();
    $id_szamla = test_input($_POST["id_szamla"]);
    $event = test_input($_POST["event"]);
    $date = test_input($_POST["date"]);
    
    if ($event == "add"){
        $sql2 = "UPDATE napi_elszamolas SET banki_utalas='$date' WHERE id_szamla = '$id_szamla'";
        echo "add ";
    } 
    
    if ($event == "erease"){
        $sql2 = "UPDATE napi_elszamolas SET banki_utalas = NULL WHERE id_szamla = '$id_szamla'";
        echo "delete ";
    }
  
    if ($conn->query($sql2) === TRUE) {
        echo " Bankolva:".$id_szamla." - " .$date ;
    } else {
        echo " Error updating record: " . $conn->error;
    }


    $conn->close();
    
    
}

