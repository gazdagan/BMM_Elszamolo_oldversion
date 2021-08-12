<?php

/* 
 *munkaidő adatok visszaolvasása felhasználó számára 
 */
include ( "../includes/DbConnect.inc.php");
include ( "../includes/SystemlogClass.php");


if (isset($_POST["CardSerialNo"])){
    $class = '';
    $conn = DbConnect();
    $CardSerialNo = $_POST["CardSerialNo"];
    $CardSerialNo = strtolower($CardSerialNo);
    $CardSerialNo = str_replace("ö","0",$CardSerialNo);   //angol billentyűzet 
    $CardSerialNo = str_replace("Ö","0",$CardSerialNo); 
    
      if (preg_match("/^[A-Fa-f0-9]*$/",$CardSerialNo) and strlen($CardSerialNo) <= 10) {

        // létező kiadott káryta ellenörzése    
         
            $sql = "SELECT * FROM users WHERE CardSerialNo = '$CardSerialNo'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {    

                while($row = $result->fetch_assoc()) {
                    echo '<h3>'.$row["real_name"].' munkidő nyilvántartása. </h3>';

                    // káryta log tárolása
                    $sql1 = "SELECT * FROM munkaido_log WHERE CardSerialNo LIKE '%$CardSerialNo%'  AND 	Torolt_log = '0' ORDER BY log_time DESC LIMIT 120";
                    
                    $result1 = $conn->query($sql1);
                    
                    if ($result1->num_rows > 0) {
                        // output data of each row
                        echo ' <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th>Dátum Idő</th>
                                    <th style="text-align:center;">Kerekítés</th>
                                    <th>Távollét oka</th>
                                    <th>Esemény</th>
                                    <th>Rendelő</th>
                                    <th>Feljegyzés</th>
                                  </tr>
                                </thead>
                                <tbody>';
                        while($row1 = $result1->fetch_assoc()) {
                            
                            if ($row1["LogStatus"] == 'Érkezés'){$class = 'success';} 
                            elseif ($row1["LogStatus"] == 'Távozás'){$class = 'info';}
                            else{$class = 'active';}
                            
                            echo '<tr class ="'.$class.'"><td>' . $row1["log_time"]. '</td><td style="text-align:center;">' . $row1["RoundedTime"]. '</td><td>' . $row1["Tavollet_oka"]. '</td><td>' . $row1["LogStatus"]. '</td><td>' . $row1["LogTelephely"]. '</td><td>' . $row1["LogNote"]. '</td></tr>';
                        
                        }
                        echo '</tbody></table>';
                    } else {
                        echo "Nincs eredmény";
                    }
                    
                            

                }    
            }  else {
                echo'<div class="alert alert-danger  alert-dismissible fade in">
                     <strong>Nincs ilyen kártya a rendszerben! </strong>  :-(
                     </div>';

                $systemlog = new SystemlogClass('Hibás munkaidő káryta!',$CardSerialNo);
                $systemlog->writelog();


            }   
        
        }else{
            echo '<div class="alert alert-danger  alert-dismissible fade in">
                     <strong> Érvénytelen kártyaszám! </strong>  :-(
                  </div>';
        }
    
    
 $conn->close();    
   
    
}