<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Segedeszkoz
 *
 * @author Andras
 */
class SegedeszkozClass extends napi_elszamolas {
    //használaton kívül
    function Visualize_New_Segedeszkoz_Form(){  
        $conn = DbConnect();
       
        echo'<div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
            <div class="panel panel-warning">
        <div class="panel-heading">Medicl Pluss Kft. gyógyászati segédeszköz számlák</div>
        <div class="panel-body">';
        echo '<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '">';
                            //beteg neve
                            echo'<div class="form-group">'
                                    . '<label class="col-sm-3 control-label">Paciens neve:</label>'
                                    . '<div class="col-sm-7">'
                                        . '<input type="text" class="form-control" name="paciensneve"  placeholder="Paciens neve" required>'
                                    . '</div>'
                                . '</div>';

                            //medical Pluss Kft.
                            echo'<div class="form-group">'
                                    . '<label class="col-sm-3 control-label"></label>'
                                    . '<div class="col-sm-7">'
                                        . '<input type="text" class="form-control" name="kezelo"  value="Medical Plus Kft." readonly>'
                                    . '</div>'
                                . '</div>';
                           
                            // gyógyászati segédeszköz
                            echo'<div class="form-group">'
                                    . '<label class="col-sm-3 control-label">Gyógyászati segédeszköz:</label>'
                                    . '<div class="col-sm-7">';
                            echo'<select class = "form-control" name = "szolg">';
                            $sql = "SELECT DISTINCT kezeles_tipus FROM kezeles_arak_jutalek WHERE kezelo_neve ='Medical Plus Kft.'";
                            $result2 = $conn->query($sql);

                            if ($result2->num_rows > 0) {
                                while ($row = $result2->fetch_assoc()) {
                                    echo '<option value="' . $row[kezeles_tipus] . '">' . $row[kezeles_tipus] . '</option>';
                                }
                            } else {
                                echo "0 results";
                            }
                            echo'</select></div></div>';

                            // fizetési módok select
                             echo'<div class="form-group">'
                                    . '<label class="col-sm-3 control-label">Fizetés:</label>'
                                    . '<div class="col-sm-7">';
                            echo'<select class = "form-control" name = "fizmod">';
                            $sql = "SELECT * FROM `bevetel_tipusok` ORDER BY bevetel_id ";
                            $result1 = $conn->query($sql);

                            if ($result1->num_rows > 0) {
                                while ($row = $result1->fetch_assoc()) {
                                    echo '<option value="' . $row[bevetel_neve] . '">' . $row[bevetel_neve] . '</option>';
                                }
                            } else {
                                echo "0 results";
                            }
                            echo'</select></div></div>';

                            // Ep Lista select
                            echo'<div class="form-group">'
                                    . '<label class="col-sm-3 control-label">Egészségpéztár:</label>'
                                    . '<div class="col-sm-7">';
                            echo'<select class = "form-control" name = "eptipus">';
                            $sql = "SELECT * FROM `ep_lista`";
                            $result1 = $conn->query($sql);

                            if ($result1->num_rows > 0) {
                                while ($row = $result1->fetch_assoc()) {
                                    echo '<option value="' . $row[ep_neve] . '">' . $row[ep_neve] . '</option>';
                                }
                            } else {
                                echo "0 results";
                            }
                            echo'</select></div></div>';

                            // számlaszám
                            echo'<div class="form-group">'
                                    . '<label class="col-sm-3 control-label">Számlaszám:</label>'
                                    . '<div class="col-sm-7">';
                                    echo'<input type = "text" class = "form-control" name = "fizszamlaszam" required>'
                                    . '</div></div>';
                                    
                            
                            // ok gomb
                            echo'<div class="form-group">'
                                    . '<label class="col-sm-3 control-label"></label>'
                                    . '<div class="col-sm-7">';
                                    echo'<button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Rendben</button>'
                                    . '</div></div>';
                                                         
                        echo '</form>';


        echo '</div>
        <div class="panel-footer">BMM</div>
        </div></div>
        <div class="col-sm-4"></div>
        </div>';
      
   }
   
 function Visulaize_Segedeszkoz_Eladasok(){
     
      $conn = DbConnect();
        $date = date("y-m-d");
// táblázat visszaolvasása
        echo'<h1>Rendelő: ' . $_SESSION['set_telephely'] . ' / ' . $date . '</h1><h2>Medical Plus Kft. - Gyógyászati Segédeszköz Eladások:</h2>';

        echo '<table class="table table-striped">
                <thead>
                    <tr>
                        <th>Páciens Neve</th>
                        <th>Kezelő / Orvos</th>
                        <th>Szolgáltatás tipusa</th>
                        <th>Fizetés módja</th>
                        <th>EP lista</th>
                        <th>Fizetés Összege</th>
                        <th>Jutalék</th>
                        <th>Bérlet</th>
                        <th>Számlaszám</th>
                    </tr>
                </thead>
                <tbody>';
        $telephely = $_SESSION['set_telephely'];
        $rogzito = $_SESSION['valid_user'];
        $date = date("Y-m-d");
        // az aktuális napi bevételek lekérdezése
        $sql = "SELECT * FROM napi_elszamolas where telephely = '$telephely' AND "
                . "date = '$date' AND torolt_szamla = '0' AND rogzito ='$rogzito'  AND lezart_szamla ='0' AND kezelo_orvos_id ='Medical Plus Kft.'";
    
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>"
                . $row["paciens_neve"] . "</td><td> "
                . $row["kezelo_orvos_id"] . "</td><td>"
                . $row["szolgaltatas_id"] . "</td><td>"
                . $row["bevetel_tipusa_id"] . "</td><td>"
                . $row["ep_tipus"] . "</td><td>"
                . $row["bevetel_osszeg"] . "</td><td>"
                . $row["jutalek_osszeg"] . "</td><td>"
                . $row["berlet_adatok"] . "</td><td>"
                . $row["szamlaszam"] . "</td><td>";
            }
        } else {
             echo "<tr><td>Nincs rögzített adat</td></tr>";
        }
        echo "</tbody></table>";

        mysqli_close($conn);
     
 }  
}
