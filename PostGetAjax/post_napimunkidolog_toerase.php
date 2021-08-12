<?php

/* 
 Munkaidő log törölt állapot váltogatása 
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
                    
                    if ($row["Torolt_log"] == 0){
                            $sql1 = "UPDATE munkaido_log SET Torolt_log = '1' WHERE log_id = '$munkaido_log_id'";
                        
                    }elseif ($row["Torolt_log"] == 1) {
                            $sql1 = "UPDATE munkaido_log SET Torolt_log = '0' WHERE log_id = '$munkaido_log_id'";
                }
                   
                   if ($conn->query($sql1) === TRUE) {
                        echo "Munkaidő log - törölt állapot változás " . $munkaido_log_id;
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                           
                   
                }
            } else {
                echo "echo 'Nincs munkidő log_id hibás';";
            }
        
    }else{echo 'Nincs munkidő log';}    
}