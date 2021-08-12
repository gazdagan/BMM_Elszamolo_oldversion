<?php

/* 
 * páztárgép zárás paraméterek tárolása db ben
 * 
 */
include ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");

if (isset($_POST["receprios"])){
    
    $conn = DbConnect();
    
    echo 'Pg adattárolás folyamatban! '. $_POST["zarasszam"] .' - '. $_POST["receprios"];

    $recepcio = test_input($_POST["receprios"]);
    $pg_zarasszam = test_input($_POST["zarasszam"]);
    $pg_telephely = test_input($_POST["telephely"]);
    
    $pg_afa5 = test_input($_POST["afa5"]);
    $pg_afa27 = test_input($_POST["afa27"]);
    $pg_afaTAM = test_input($_POST["afaTAM"]);
    
    $hiba1szam = test_input($_POST["hiba1nysz"]);
    $hiba1afa = test_input($_POST["hiba1kulcs"]);
    $hiba1osszeg = test_input($_POST["hiba1osszeg"]);
    
    $hiba2szam = test_input($_POST["hiba2nysz"]);
    $hiba2afa = test_input($_POST["hiba2kulcs"]);
    $hiba2osszeg = test_input($_POST["hiba2osszeg"]);
    
    $hiba3szam = test_input($_POST["hiba3nysz"]);
    $hiba3afa = test_input($_POST["hiba3kulcs"]);
    $hiba3osszeg = test_input($_POST["hiba3osszeg"]);
    $kp_osszes = test_input($_POST["kp_osszes"]);
    
    $sql = "INSERT INTO pgzarasok (recepcio, pg_zarasszam, pg_telephely ,pg_afa5, pg_afa27, pg_TAM, hiba1szam, hiba1afa, hiba1osszeg, hiba2szam, hiba2afa, hiba2osszeg, hiba3szam, hiba3afa, hiba3osszeg, kp_osszes )
    VALUES ('$recepcio', '$pg_zarasszam', '$pg_telephely','$pg_afa5', '$pg_afa27', '$pg_afaTAM', '$hiba1szam', '$hiba1afa','$hiba1osszeg','$hiba2szam', '$hiba2afa','$hiba2osszeg','$hiba3szam', '$hiba3afa','$hiba3osszeg','$kp_osszes')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    
    
}
