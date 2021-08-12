<?php

/* 
 * user_log adattábla visszaolvasása 
 */

echo '<h1>user_log lekérdezés</h1>';

echo  '<form class="form-inline" method="post" action="' . $_SERVER["PHP_SELF"] . '?pid=page100">
            <div class="form-group">
            <label for="email">Dátum:</label>
            <input type="date" class="form-control" id="email" placeholder="Enter email" name="log_day" value="'.date("Y-m-d").'">
            <button type="submit" class="btn btn-default">Submit</button>
    </form><br>';

if (isset($_POST["log_day"])){
    
    $db_connect = DbConnect(); 
   
    $day = $_POST["log_day"];
   
    
    $sql_select = "SELECT * FROM  user_log WHERE log_timestamp LIKE '%$day%'";
    
    $result = $db_connect->query($sql_select);
    echo '<table class="table table-bordered"><tr><th>Időpont</th><th>Név</th><th>Log</th></tr>';
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["log_timestamp"]. "</td><td>" . $row["user_name"]. "</td><td>" . $row["log_txt"]. "</td></tr>";
        }
    } else {
        echo "0 results";
    }
    echo '</table>';   
    
    
    $db_connect->close();
    
}