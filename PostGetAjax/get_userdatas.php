<?php

/* 
 * user datas back to fontend
 
 */

include ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");


if (isset($_GET["user_id"]) ){
    
       
    $conn = DbConnect();
    $user_id = test_input($_GET["user_id"]);
       
    
    // kezelő orvos jutaléka az adott napon recepcióstól függetlenül
    $sql1 = "SELECT * FROM users WHERE  user_id =  '$user_id'";

    $result = $conn->query($sql1);
    
    if ($result->num_rows > 0) {    
        while ($row = $result->fetch_assoc()) {
            echo     '<p>User id : ' .$row["user_id"].'</p>'; 
         
            echo '<form class="form-horizontal" method = "POST" action= "index.php?pid=page85" style ="pagging: 10px;">';
                  
            echo '<input type="hidden" value="'.$row["user_id"].'" name="user_id">';
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Login email :</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="email"  value ="'. $row["email"].'"></div></div>';    
           
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Password :</label></div>
                      <div class ="col-sm-9"><input id="pac" type="password" class="form-control" name="jelszo"  value ="'. $row["jelszo"].'"></div></div>';
                    
            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Típus:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="tipus"  value ="'. $row["tipus"] .'"></div></div>';
            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Valódi név:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="real_name" value ="'. $row["real_name"] .'"></div></div>';
            
            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Aktiv user:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="Enable_user" value ="'. $row["Enable_user"] .'"></div></div>';
                               
                    
           
            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Kártyára írt szám:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="CardReadableNo" placeholder="2012 xxx xxx xxx" value ="'. $row["CardReadableNo"] .'"></div></div>';
                              
           
                
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Kártya kód:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="CardSerialNo" placeholder="Olvasd ki a kártyaolvasóval" value ="'. $row["CardSerialNo"] .'"></div></div>';
         
            
            
           
                      
            echo    '<div class="row">
                    <div class ="col-sm-3"><label for="pac">OK:</label></div>
                    <div class ="col-sm-9"><button type="" class="btn btn-danger btn-block" onclick="update_user_table()">Módosít</button>
                    </div>
                    </div>'; 
            echo '<input  type="hidden"  name="userupdate"  value ="userupdate">';
           
         
            echo '</form>';
            }
    }else{echo "Nincs rögzített adat!";}
    
}
?>