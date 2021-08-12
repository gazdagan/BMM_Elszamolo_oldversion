<?php

/* 
 * bérlet -> bmm kártya kapcsolat berletet az egyedi bmm kártya id hez rendeli
 */



include ( "../includes/DbConnect.inc.php");

if (isset($_POST["berlet_id"])  AND isset($_POST["kartya_id"])){
     
    $conn = DbConnect();
    
    $berletid = $_POST["berlet_id"];
    $kartyaid = $_POST["kartya_id"];
    
    $sql = "UPDATE berlet_kezeles SET user_id='$kartyaid' WHERE berlet_id='$berletid'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

    $conn->close();        
    
    
    
    
}
