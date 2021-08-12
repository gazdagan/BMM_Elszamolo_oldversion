<?php
 function DbConnect(){
    
   // $db_servername = "127.0.0.1";
   // $db_username   = "cxgqji_napielszamolo";
   // $db_password   = "VW}rd5.kBE[H";
   // $db_name       = "cxgqji_elszbmm";
	
//    BMM Mysql bejelentkez�s
//    $db_servername = "127.0.0.1";
//    $db_username = "cxgqji_gazdagan";
//    $db_password = "Yaq12wsX";
//    $db_name = "cxgqji_elszbmm";
    
     
    //Local Mysql Config   
    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "cxgqji_elszbmm";
    
    // Create connection
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
    $conn->set_charset("utf8");
    
    
	// Check connection
    if ($conn->connect_error) {
        echo "MySql Connection Error'";
        die("Connection failed: " . $conn->connect_error);
    } else {
        $conn->query("SET SESSION sql_mode = ''");
        //echo "Connected successfully <br>";
      return $conn;  
    }

 }



