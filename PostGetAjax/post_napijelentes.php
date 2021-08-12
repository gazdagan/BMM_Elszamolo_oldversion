<?php

/* 
 *
 */

require_once ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");

if (isset($_POST["napijelentes_adat"])){
    $conn = DbConnect();
    echo'post call:'.$_POST["napijelentes_adat"];
   
    $date = date("Y-m-d");
    $recepcios = test_input($_POST["recepcios"]);
    $telephely = test_input($_POST["telephely"]);
    
    if ( $_POST["napijelentes_adat"] === "paciensadatok"){
    
    $paciens_elegedettseg = test_input($_POST["paciens_elegedettseg"]);
    $paciens_panasz = test_input($_POST["paciens_panasz"]);
    $paciens_varakozasiido = test_input($_POST["paciens_varakozasiido"]);
    
    
    $sql = "SELECT * FROM napi_jelentes WHERE jelentes_telephely = '$telephely' AND jelentes_date = '$date'";
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // már van napi jelentés elkezdve  update 
            echo "UPDATE";
            $sql = "UPDATE napi_jelentes "
                    . "SET jelentes_keszito='$recepcios' , paciens_elegedettseg ='$paciens_elegedettseg', paciens_panasz='$paciens_panasz', paciens_varakozasiido ='$paciens_varakozasiido'"
                   ."WHERE jelentes_telephely = '$telephely' AND jelentes_date = '$date'";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
            }
                
        } else {
            // még nincs napi jelentés a rendelőhöz INSERTINTO
            echo "INSERTINTO";
            $sql = "INSERT INTO napi_jelentes (	jelentes_keszito, jelentes_telephely, jelentes_date,paciens_elegedettseg,paciens_panasz,paciens_varakozasiido)
                    VALUES ('$recepcios', '$telephely', '$date', '$paciens_elegedettseg', '$paciens_panasz', '$paciens_varakozasiido')";

                    if (mysqli_query($conn, $sql)) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }

            
        }
    }


    
    if ( $_POST["napijelentes_adat"] === "elojegyzes"){
    
    $elojegyzes_kapacitas = test_input($_POST["elojegyzes_kapacitas"]);
    $elojegyzes_varakozas = test_input($_POST["elojegyzes_varakozas"]);
    $elojegyzes_rendeles = test_input($_POST["elojegyzes_rendeles"]);
    
    
    $sql = "SELECT * FROM napi_jelentes WHERE jelentes_telephely = '$telephely' AND jelentes_date = '$date'";
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // már van napi jelentés elkezdve  update 
            echo "UPDATE";
            $sql = "UPDATE napi_jelentes "
                    . "SET jelentes_keszito='$recepcios' , elojegyzes_kapacitas ='$elojegyzes_kapacitas', elojegyzes_varakozas='$elojegyzes_varakozas', elojegyzes_rendeles ='$elojegyzes_rendeles'"
                   ."WHERE jelentes_telephely = '$telephely' AND jelentes_date = '$date'";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
            }
                
        } else {
            // még nincs napi jelentés a rendelőhöz INSERTINTO
            echo "INSERTINTO";
            $sql = "INSERT INTO napi_jelentes (	jelentes_keszito, jelentes_telephely, jelentes_date,elojegyzes_kapacitas,elojegyzes_varakozas,elojegyzes_rendeles)
                    VALUES ('$recepcios', '$telephely', '$date', '$elojegyzes_kapacitas', '$elojegyzes_varakozas', '$elojegyzes_rendeles')";

                    if (mysqli_query($conn, $sql)) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }

            
        }
    }
    
    
    
    if ( $_POST["napijelentes_adat"] === "orvos_terapeuta_table"){
    
    $orvos_terapeuta = test_input($_POST["orvos_terapeuta"]);
       
    
    $sql = "SELECT * FROM napi_jelentes WHERE jelentes_telephely = '$telephely' AND jelentes_date = '$date'";
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // már van napi jelentés elkezdve  update 
            echo "UPDATE";
            $sql = "UPDATE napi_jelentes "
                    . "SET jelentes_keszito='$recepcios' , orvos_terapeuta ='$orvos_terapeuta'"
                   ."WHERE jelentes_telephely = '$telephely' AND jelentes_date = '$date'";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
            }
                
        } else {
            // még nincs napi jelentés a rendelőhöz INSERTINTO
            echo "INSERTINTO";
            $sql = "INSERT INTO napi_jelentes (	jelentes_keszito, jelentes_telephely, jelentes_date,orvos_terapeuta)
                    VALUES ('$recepcios', '$telephely', '$date', '$orvos_terapeuta')";

                    if (mysqli_query($conn, $sql)) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }

            
        }
    
          
          
          
          
      }
      
    if ( $_POST["napijelentes_adat"] === "ugyfelszolgalat_table"){
    
    $ugyfelszolgalat = test_input($_POST["ugyfelszolgalat"]);
       
    
    $sql = "SELECT * FROM napi_jelentes WHERE jelentes_telephely = '$telephely' AND jelentes_date = '$date'";
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // már van napi jelentés elkezdve  update 
            echo "UPDATE";
            $sql = "UPDATE napi_jelentes "
                    . "SET jelentes_keszito='$recepcios' , ugyfelszolgalat ='$ugyfelszolgalat'"
                   ."WHERE jelentes_telephely = '$telephely' AND jelentes_date = '$date'";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
            }
                
        } else {
            // még nincs napi jelentés a rendelőhöz INSERTINTO
            echo "INSERTINTO";
            $sql = "INSERT INTO napi_jelentes (	jelentes_keszito, jelentes_telephely, jelentes_date,ugyfelszolgalat)
                    VALUES ('$recepcios', '$telephely', '$date', '$ugyfelszolgalat')";

                    if (mysqli_query($conn, $sql)) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
           
        }
          
      }  
    
      
     if ( $_POST["napijelentes_adat"] === "eszkozok_table"){
    
    $meghibasodott_eszkoz = test_input($_POST["meghibasodott_eszkoz"]);
    $hiányzo_eszkoz = test_input($_POST["hiányzo_eszkoz"]);
    $injekcio_db = test_input($_POST["injekcio_db"]);
       
    
    $sql = "SELECT * FROM napi_jelentes WHERE jelentes_telephely = '$telephely' AND jelentes_date = '$date'";
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // már van napi jelentés elkezdve  update 
            echo "UPDATE";
            $sql = "UPDATE napi_jelentes "
                   ."SET jelentes_keszito='$recepcios' , meghibasodott_eszkoz ='$meghibasodott_eszkoz', hiányzo_eszkoz ='$hiányzo_eszkoz', injekcio_db ='$injekcio_db'"
                   ."WHERE jelentes_telephely = '$telephely' AND jelentes_date = '$date'";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
            }
                
        } else {
            // még nincs napi jelentés a rendelőhöz INSERTINTO
            echo "INSERTINTO";
            $sql = "INSERT INTO napi_jelentes (	jelentes_keszito, jelentes_telephely, jelentes_date,meghibasodott_eszkoz,hiányzo_eszkoz,injekcio_db)
                    VALUES ('$recepcios', '$telephely', '$date', '$meghibasodott_eszkoz', '$hiányzo_eszkoz', '$injekcio_db')";

                    if (mysqli_query($conn, $sql)) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
           
        }
          
      }   
      
    $conn->close();

}