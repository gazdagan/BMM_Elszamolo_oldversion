<?php

/* 
 *munkaidő adatok visszaolvasása felhasználó számára 
 */
include ( "../includes/DbConnect.inc.php");
include ( "../includes/SystemlogClass.php");

// új esemény hozzáadása db -hez + törlés
if (isset($_POST["name"]) AND isset($_POST["date"]) AND  isset($_POST["tavollet_oka"])){
    
    echo 'post munkahelyi távollét';
  
    $name = $_POST["name"];
    $date = $_POST["date"];
    $tavollet_oka = $_POST["tavollet_oka"];
    $user = 'Rögzítette - '.$_POST["user"];
    $conn = DbConnect();
    $CardSerialNo = "ERR000";
        
        // létező kiadott káryta ellenörzése    
         
            $sql = "SELECT * FROM users WHERE real_name = '$name'";
            $result = $conn->query($sql);
            if ($result->num_rows == 1) {    
                while($row = $result->fetch_assoc()) {
                   $CardSerialNo = $row["CardSerialNo"];
                
                    if ($_POST["event"] == 'add'){
                    $sql1 = "INSERT INTO munkaido_log (log_time,CardSerialNo,Tavollet_oka,LogNote)
                             VALUES ('$date', '$CardSerialNo', '$tavollet_oka', '$user')";

                            if ($conn->query($sql1) === TRUE) {
                                echo " New record created successfully ";
                            } else {
                                echo "Error: " . $sql1 . "<br>" . $conn->error;
                            }
                    } 
                    
                    if ($_POST["event"] == 'delete'){
                                    
                 
                    $sql2 = "DELETE FROM munkaido_log WHERE CardSerialNo = '$CardSerialNo' AND log_time LIKE '%$date%' AND Tavollet_oka = '$tavollet_oka'";

                           if ($conn->query($sql2) === TRUE) {
                                echo " Record deleted successfully ";
                            } else {
                                echo "Error: " . $sql2 . "<br>" . $conn->error;
                            }
                    }  
                    
                }    
            }  else {
                echo'Nincs ilyen user: '. $name ;

                $systemlog = new SystemlogClass('Nincs ilyen user!',$CardSerialNo);
                $systemlog->writelog();

            }   
   
   
 $conn->close();    

    
}
