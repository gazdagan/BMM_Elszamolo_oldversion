<?php

/* 
 * napi munkaidő adatok javítása törlése
 * 
 */
include ( "../includes/DbConnect.inc.php");
include ( "../includes/SystemlogClass.php");
include ( "../includes/MunkaidoClass.php");;

if (isset($_POST["log_id"])){
    
    $munkaido_log_id = $_POST["log_id"];
   
    //echo "log_id = '. $munkaido_log_id .'; 
    
    $conn = DbConnect();
    
    if ($munkaido_log_id != 0){
    
    $sql = "SELECT * FROM munkaido_log WHERE log_id = '$munkaido_log_id'";
    
        $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {

                   
                    $log_date = strtotime($row["log_time"]);
                    $log_date  = date('Y-m-d',$log_date);
                    $card_serial_no = $row["CardSerialNo"];
                    $Status = $row["LogStatus"];
                    
                    $sql2 = "SELECT * FROM munkaido_log WHERE CardSerialNo = '$card_serial_no' AND log_time LIKE '%$log_date%' AND LogStatus = '$Status'";
                        
                        $result = $conn->query($sql2);
                              if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    
                                    $eraselog = $row["log_id"];
                                    
                                    if ($row["Torolt_log"] == 0){
                                    
                                        echo $row["log_time"]. " - " . $row["LogStatus"]. " - " . $row["LogTelephely"]. " - ".$row["LogNote"]. " - ".
                                            '<label><input type="checkbox" value="" onclick="modifi_erase_muinkaido_log('.$eraselog.')" > - Töröl / Vissszaállít</label> <br>';
                                    }else{
                                        
                                        echo $row["log_time"]. " - " . $row["LogStatus"]. " - " . $row["LogTelephely"]. " - " .$row["LogNote"]. " - ".
                                            '<label><input type="checkbox" value="" onclick="modifi_erase_muinkaido_log('.$eraselog.')"  checked> - Töröl / Vissszaállít</label> <br>';
                                        
                                        
                                    }
                                }     
                           }    
                           
                   
                }
            } else {
                echo "echo 'Nincs munkidő log_id hibás';";
            }
        
    }else{echo 'Nincs munkidő log';}    
}