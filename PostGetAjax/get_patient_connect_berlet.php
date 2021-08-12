<?php

/* 
 * bérlet  pácienshez rendelése
 */

include ( "../includes/DbConnect.inc.php");

if (isset($_GET["berlet_id"]) ){
     
    $conn = DbConnect();
    
    $berletid = $_GET["berlet_id"];
  
    $PacName = "";
    $AID = "";
    
    if (isset($_GET["PacName"])) {$PacName = $_GET["PacName"];}
    if (isset($_GET["ArteriaID"])) {$AID = $_GET["ArteriaID"];}
        
                //   bérlet felhasunálás lekérdezése                
                $sql1 = "SELECT * FROM users WHERE tipus='patient' AND real_name LIKE '%$PacName%' AND email LIKE '%$AID%'";
                $result1 = $conn->query($sql1);
                echo '<div class="modal-dialog ">';
                echo '<div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">No.: '.$berletid.' bérlet -> páciens kapcsolat.</h4>
                               Keresés a páciensek között:
                                        <div class="form-inline">
                                         <div class="form-group">
                                           <label for="name">Név:</label>
                                           <input type="text" class="form-control" id="PacName" placeholder="Páciens neve ">
                                         </div>
                                         <div class="form-group">
                                           <label for="AID">Artéria ID:</label>
                                           <input type="text" class="form-control" id="AID" placeholder="66778899">
                                         </div>
                                                                                
                                         <button onclick="berlet_patient_list('.$berletid.')" class="btn btn-default">Keres</button>
                                       </div>
                            </div>
                       <div class="modal-body container" stlye="width:300 px;">';
            
                // táblázat
                echo'<table  class="table-condensed"><thead><tr><th>Páciens neve</th><th>Arteria ID</th><th>BMM kártya </th><th>Kapcsolat</th><tr></thead><tbody>';
                
                if ($result1->num_rows > 0) {    
                    while ($row = $result1->fetch_assoc()) {
                        echo '<tr><td>' .$row["real_name"]. '</td><td>' .$row["email"]. '</td><td>' .$row["CardReadableNo"]. '</td>'
                                . '<td><button  type="button" onclick="berlet_patient_connect_create('.$berletid.','.$row["CardReadableNo"].' )"  data-toggle="modal" data-target="#berlet_connect"><i class="fa fa-link" aria-hidden="true"></i></button></td>'
                                . '</tr>';
                        }
                }else{echo "<tr><td>Nincs rögzített adat</td></tr>";}
                echo '</tbody></table>';
                
                echo '</div>
                        <div class="modal-footer">
                           Kiválasztott No.:'.$berletid.' bérlet BMM kártya kapcsolat törlése '
                        . '<div class="btn-group"> <button type="button" class="btn btn-default" onclick="berlet_patient_connect_delete('.$berletid.')"><i class="fa fa-trash-o" aria-hidden="true"></i></button></span>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Bezár</button></div>
                        </div>
                </div></div>';

    
}
