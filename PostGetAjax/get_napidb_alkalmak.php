<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");

if (isset($_GET["napi_tetel_id"]) ){
    
       
    $conn = DbConnect();
    $szamla_id = test_input($_GET["napi_tetel_id"]);
       
    
    // kezelő orvos jutaléka az adott napon recepcióstól függetlenül
    $sql1 = "SELECT * FROM napi_elszamolas WHERE  id_szamla =  '$szamla_id'";

    $result = $conn->query($sql1);
    
    if ($result->num_rows > 0) {    
        while ($row = $result->fetch_assoc()) {
            echo     '<p>Tétel id : ' .$row["id_szamla"].'</p>'; 
            echo     ' Rögzítés időpontja : '  . $row["date_bevetel"].'</p>';
            echo '<form class="form-horizontal" method = "POST" action= "index.php?pid=page90"style ="pagging: 10px;">';
                  
            echo '<input type="hidden" value="'.$row["id_szamla"].'" name="nap_elsz_update_id">';
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Páciens neve:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="paciens_neve"  value ="'. $row["paciens_neve"].'"></div></div>';    
           
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Kezelő neve:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="kezelo_orvos_id"  value ="'. $row["kezelo_orvos_id"] .'"></div></div>';
                    
            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Szolg típusa:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="szolgaltatas_id"  value ="'. $row["szolgaltatas_id"] .'"></div></div>';
                               
                    
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Bevétel típusa:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="bevetel_tipusa_id"  value ="'. $row["bevetel_tipusa_id"] .'"></div></div>';
                              
           
                
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">EP típusa:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="ep_tipus" value ="'. $row["ep_tipus"] .'"></div></div>';
         
            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Bevétel:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="bevetel_osszeg" value ="'. $row["bevetel_osszeg"] .'"></div></div>';
                
            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Jutalék:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="jutalek_osszeg" value ="'. $row["jutalek_osszeg"] .'"></div></div>';
                      
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Bérlet:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="berlet_adatok" value ="'. $row["berlet_adatok"] .'"></div></div>';
                      
            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Számlaszám:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="szamlaszam" value ="'. $row["szamlaszam"] .'"></div></div>';
                          
                    
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">BK slip:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="slipsz" value ="'. $row["slipsz"] .'"></div></div>';
  
            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">PG slip:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="nyugtasz" value ="'. $row["nyugtasz"] .'"></div></div>';
                     
                     
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Rögzitő:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="rogzito" value ="'. $row['rogzito'] .'"></div></div>';
 
            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Telephely:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="telephely" value ="'. $row["telephely"] .'"></div></div>';
                   
            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Átvevő:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="atvevo_neve" value ="'. $row["atvevo_neve"] .'"></div></div>';

            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Lezárt tétel:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="lezart_szamla" value ="'. $row["lezart_szamla"] .'"></div></div>';
                   
            
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Beteglista id:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="el_beteglista_id" value ="'. $row["el_beteglista_id"] .'"></div></div>';
                      
           
            echo     '<div class="row">
                      <div class ="col-sm-3"><label for="pac">Törölt tétel:</label></div>
                      <div class ="col-sm-9"><input id="pac" type="text" class="form-control" name="torolt_szamla" value ="'. $row["torolt_szamla"] .'"></div></div>';
                      
            echo    '<div class="row">
                    <div class ="col-sm-12"><button type="" class="btn btn-danger btn-block" onclick="update_napibev_table()">Módosít</button>
                    </div>
                    </div>'; 
            
           
         
            echo '</form>';
            }
    }else{echo "Nincs rögzített adat";}
    
}
?>

