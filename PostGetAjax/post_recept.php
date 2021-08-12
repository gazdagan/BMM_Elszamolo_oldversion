<?php

/* 
 receptek nyomkövetése
 */



include ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");

if (isset($_POST["id_szamla"]) AND isset($_POST["event"]) ){
    
    $conn = DbConnect();
    $id_szamla = test_input($_POST["id_szamla"]);
    $event = test_input($_POST["event"]);
    if (isset ($_POST["date"])) {$date = test_input($_POST["date"]);} else {$date= "0000-00-00";}
    if (isset($_POST["recept_artam"])){ $recept_artam = test_input($_POST["recept_artam"]);} else { $recept_artam = NULL;}
    if (isset ($_POST["recept_id"])) {$recept_id = test_input($_POST["recept_id"]);} else { $recept_id = NULL;}
    
    if ($event == "update_benyujtas"){
        $sql2 = "UPDATE napi_elszamolas SET recept_feladas='$date' WHERE id_szamla = '$id_szamla'";
        echo "recept benyujtás add ";
    } 
    
    if ($event == "erease_benyujtas"){
        $sql2 = "UPDATE napi_elszamolas SET recept_feladas = NULL WHERE id_szamla = '$id_szamla'";
        echo "recept benyujtás delete ";
    }
    
    
    if ($event == "update_beerkezes"){
        $sql2 = "UPDATE napi_elszamolas SET  recept_tam_be ='$date' WHERE id_szamla = '$id_szamla'";
        echo "recept támogatása add ";
    } 
    
    if ($event == "erease_beerkezes"){
        $sql2 = "UPDATE napi_elszamolas SET recept_tam_be = NULL WHERE id_szamla = '$id_szamla'";
        echo "recept támogatása delete ";
    }
    
    if ($event == "update_artamogatas"){
        $sql2 = "UPDATE napi_elszamolas SET  recept_artam ='$recept_artam' WHERE id_szamla = '$id_szamla'";
        echo "recept ÁR támogatása add ";
    } 
    
    if ($event == "update_venyid"){
        $sql2 = "UPDATE napi_elszamolas SET  recept_id ='$recept_id' WHERE id_szamla = '$id_szamla'";
        echo "recept ID add ";
    } 
  
    if ($conn->query($sql2) === TRUE) {
        echo " Recept tamogatas:".$id_szamla." - " .$date ;
    } else {
        echo " Error updating record: " . $conn->error;
    }


    $conn->close();
    
    
}

