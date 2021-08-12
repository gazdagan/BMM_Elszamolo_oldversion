<?php

/* 
 * bérlet alkalmak modális ablak feltöltése adatokkal
 * modális ablakba rakja az eedményeket
 */

include ( "../includes/DbConnect.inc.php");

if (isset($_GET["berlet_id"]) ){
     
    $conn = DbConnect();
    
    $berletid = $_GET["berlet_id"];
    
                //   bérlet felhasunálás lekérdezése               
                $sql1 = "SELECT * FROM berlet_felh WHERE felh_berlet_id='$berletid'";
                $result1 = $conn->query($sql1);
                echo '<div class="modal-dialog">';
                echo '<div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">No.: '.$berletid.' bérlet felhasználásának dátumai.</h4>
                            </div>
                       <div class="modal-body container" stlye="width:300 px;">';
            
                // táblázat
                echo'<table  class="table-condensed"><thead><tr><th>Alkalom</th><th>Dátum</th><tr></thead><tbody>';
                
                if ($result1->num_rows > 0) {    
                    while ($row = $result1->fetch_assoc()) {
                        echo '<tr><td>'.$row["felh_berlet_alkalom"].'</td><td>' .$row["felh_berlet_date_time"]. '</td></tr>';
                        }
                }else{echo "<tr><td>Nincs rögzített adat</td></tr>";}
                echo '</tbody></table>';
                
                echo '</div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Bezár</button>
                        </div>
                </div></div>';

    
}
