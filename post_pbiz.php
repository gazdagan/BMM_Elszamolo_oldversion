<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include ( "./includes/DbConnect.inc.php");
include ( "./includes/Inputvalidation.inc.php");

if (isset($_POST["receprios"])AND isset($_POST["telephely"]) AND isset($_POST["tipus"])){
    
    $conn = DbConnect();
    
    $bitonylat_tipus = $_POST["tipus"];
    $recepcio = test_input($_POST["receprios"]);
    $pg_telephely = test_input($_POST["telephely"]);
    $adatok = test_input($_POST["bizonylat_adatok"]);
  
    if ($bitonylat_tipus == "bevetel"){
        $sql = "INSERT INTO bev_penztarbiz (recepcio, telephely, bizonylat_adatok) VALUES ('$recepcio', '$pg_telephely','$adatok')";
    } 
    if($bitonylat_tipus == "kiadas"){
        $sql = "INSERT INTO kiadasi_penztarbiz (recepcio, telephely, bizonylat_adatok) VALUES ('$recepcio', '$pg_telephely','$adatok')";
    }
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    
    
}

