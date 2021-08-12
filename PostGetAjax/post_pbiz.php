<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");

        $error_log =  'Post  :'.$_POST["receprios"] .' - '. $_POST["telephely"].' - '.$_POST["tipus"].'\n';
        echo $error_log;

        echo file_put_contents("hazip_errorlog.txt",$error_log,FILE_APPEND | LOCK_EX);

if (isset($_POST["receprios"])AND isset($_POST["telephely"]) AND isset($_POST["tipus"])AND isset($_POST["bizonylat_datum"])){
    
    $conn = DbConnect();
    $sqltable =  '';
    $bitonylat_tipus = $_POST["tipus"];
    $recepcio = test_input($_POST["receprios"]);
    $pg_telephely = test_input($_POST["telephely"]);
    $error_log = "";
    
    $bizonylat_nev = test_input($_POST["bizonylat_nev"]);
    $bizonylat_foosszegszam = test_input($_POST["bizonylat_foosszegszam"]);
    $bizonylat_foosszegszoveg = test_input($_POST["bizonylat_foosszegszoveg"]);
    $bizonylat_melleklet = test_input($_POST["bizonylat_melleklet"]);
    $bizonylat_kerekites = test_input($_POST["bizonylat_kerekites"]);
    $bizonylat_osszesen = test_input($_POST["bizonylat_osszesen"]);
    $adatok = test_input($_POST["bizonylat_adatok"]);
    $biz_id = test_input($_POST["bizonylat_id"]);
    $biz_date = test_input($_POST["bizonylat_datum"]);
    
    str_replace(".","-",$biz_date);
    $biz_datetime = $biz_date;
    
    
    $bev_dbnames = array("BMM"=>"bev_pbiz_Bmm","Fizio"=>"bev_pbiz_Fizio","P70"=>"bev_pbiz_P70","P72"=>"bev_pbiz_P72","Óbuda"=>"bev_pbiz_Obuda","Lábcentrum"=>"bev_pbiz_Lc","Scolinea"=>"bev_pbiz_Scolinea","SMM"=>"bev_pbiz_SMM");
    $kiad_dbnames = array("BMM"=>"ki_pbiz_Bmm","Fizio"=>"ki_pbiz_Fizio","P70"=>"ki_pbiz_P70","P72"=>"ki_pbiz_P72","Óbuda"=>"ki_pbiz_Obuda","Lábcentrum"=>"ki_pbiz_Lc","Scolinea"=>"ki_pbiz_Scolinea","SMM"=>"ki_pbiz_SMM");
       
    //uj bizonylat
    if ($bitonylat_tipus == "bevetel"){
             
        $sqltable =  $bev_dbnames[$pg_telephely];
        $sql = "INSERT INTO ".$sqltable." (recepcio, telephely, bizonylat_adatok,bizonylat_nev,bizonylat_foosszegszam,bizonylat_foosszegszoveg,bizonylat_melleklet,bizonylat_kerekites,bizonylat_osszesen,datetime) "
                . "VALUES ('$recepcio', '$pg_telephely','$adatok','$bizonylat_nev','$bizonylat_foosszegszam','$bizonylat_foosszegszoveg','$bizonylat_melleklet','$bizonylat_kerekites','$bizonylat_osszesen','$biz_datetime')";
    } 
    if($bitonylat_tipus == "kiadas"){
        
        $sqltable =  $kiad_dbnames[$pg_telephely];
        $sql = "INSERT INTO ".$sqltable." (recepcio, telephely, bizonylat_adatok,bizonylat_nev,bizonylat_foosszegszam,bizonylat_foosszegszoveg,bizonylat_melleklet,bizonylat_kerekites,bizonylat_osszesen,datetime) "
                . "VALUES ('$recepcio', '$pg_telephely','$adatok','$bizonylat_nev','$bizonylat_foosszegszam','$bizonylat_foosszegszoveg','$bizonylat_melleklet','$bizonylat_kerekites','$bizonylat_osszesen','$biz_datetime')";
    }
    // bizonylatok javítása
    if ($bitonylat_tipus == "bevetel_javbiz"){
        $sqltable =  $bev_dbnames[$pg_telephely];
        $sql = "UPDATE  ".$sqltable."  SET bizonylat_nev ='$bizonylat_nev',bizonylat_foosszegszam ='$bizonylat_foosszegszam',bizonylat_foosszegszoveg = '$bizonylat_foosszegszoveg'"
               . ",bizonylat_melleklet='$bizonylat_melleklet', bizonylat_kerekites ='$bizonylat_kerekites',bizonylat_osszesen='$bizonylat_osszesen', bizonylat_adatok = '$adatok', datetime = '$biz_datetime' "
               . " WHERE bevpbiz_id = '$biz_id'"; 
        
    }
    if ($bitonylat_tipus == "kiadasi_javbiz"){
       
       $sqltable =  $kiad_dbnames[$pg_telephely];
       $sql = "UPDATE ".$sqltable."  SET bizonylat_nev ='$bizonylat_nev',bizonylat_foosszegszam ='$bizonylat_foosszegszam',bizonylat_foosszegszoveg = '$bizonylat_foosszegszoveg'"
               . ",bizonylat_melleklet='$bizonylat_melleklet', bizonylat_kerekites ='$bizonylat_kerekites',bizonylat_osszesen='$bizonylat_osszesen', bizonylat_adatok = '$adatok',datetime = '$biz_datetime'"
               . " WHERE kiadpbiz_id = '$biz_id'"; 
        
    }
   
     
    
    if ($conn->query($sql) === TRUE) {
        $error_log =  "New record created successfully :".$pg_telephely ."-".$biz_date."-".$recepcio."\n";
        echo $error_log;

        echo file_put_contents("hazip_errorlog.txt",$error_log,FILE_APPEND | LOCK_EX);
        
    } else {
            $error_log =  "Error : ".$pg_telephely ." - ".$biz_date." - ".$recepcio." - " . $sql . "<br>" . $conn->error. "\n";
            
            echo  $error_log;
            echo file_put_contents("hazip_errorlog.txt",$error_log,FILE_APPEND | LOCK_EX);

    }

    $conn->close();
    
    
}

