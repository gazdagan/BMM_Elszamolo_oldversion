<?php


/**
 * Description of AdminSelectClass
 * Admin felhasználó lekérdezéseit feldolgozó osztály
 * @author Andras
 */
class AdminSelectClass {
    
    //put your code here
    public $where;
    public $startdate;
    public $enddate;
    public $telephely;
    public $mons;
    private $year;
    
    public $forgalmi_adatok = array();
    
    public function __construct() {
        $this->where = 'nincs parameter';
        $this->startdate = 'nincs parameter';
        $this->enddate = 'nincs parameter';
        $this->telephely = 'nincs parameter';
        $this-> mons = array(1 => "Január", 2 => "Február", 3 => "Március", 4 => "Április", 5 => "Május", 6 => "Június", 7 => "Július", 8 => "Augusztus", 9 => "Szeptember", 10 => "Októbet", 11 => "November", 12 => "December");
        $this->year = date ("Y");
        //$this->year = 2019;
    }
    

    public function AdminSelectQueryForm(){
         
     $conn = DbConnect();
        $date = date("y-m-d");
              
        echo '<div class="panel panel-danger">';
            echo'<div class="panel-heading">Összesített időszaki lekérdezések </div>';
            echo '<div class="panel-body">';
                echo '<form action="' . $_SERVER['PHP_SELF'] . '?pid=page90" method="post" >'; 
                
                //lekérdezési időszak eleje
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Időszak eleje :</label>
                        <div class="col-sm-7"><input type="date" class="form-control" name="startdate" required></div>
                     </div>';
                //lekérdezés időszak vége
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Időszak vége :</label>
                        <div class="col-sm-7"><input type="date" class="form-control"  name="enddate" required></div>
                     </div>';
                //rögzítő
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Recepciós :</label>
                        <div class="col-sm-7">';
                
                        
                        echo'<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-female"></i></span>';
                            echo'<select class = "form-control" name = "select_rogzito">';
                             echo '<option value=""> Összes recepciós </option>';
                            $sql = "SELECT * FROM users";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["real_name"] . '">' . $row["real_name"] . '</option>';
                                }
                            } else {
                                echo "0 results";
                            }
                            echo '</select></div>';
                
                
                echo'</div>
                     </div>';
               
                
                //terapeuta
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Terapeuta :</label>
                        <div class="col-sm-7">';
                       
                        echo'<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-user-md"></i></span>';
                            echo'<select class = "form-control" name = "select_terapeuta">';
                             echo '<option value=""> Összes terapeuta </option>';
                            $sql = "SELECT DISTINCT kezelo_neve FROM kezelok_orvosok ORDER BY kezelo_neve ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["kezelo_neve"] . '">' . $row["kezelo_neve"] . '</option>';
                                }
                            } else {
                                echo "0 results";
                            }
                            echo '</select></div>';


                echo  '</div>
                     </div>';
                //telephely
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Telephely :</label>
                        <div class="col-sm-7">';
                        
                        echo'<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-building"></i></span>';
                            echo'<select class = "form-control" name = "select_telephely">';
                             echo '<option value=""> Összes telephely </option>';
                            $sql = "SELECT * FROM telephelyek";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["telephely_neve"] . '">' . $row["telephely_neve"] . '</option>';
                                }
                            } else {
                                echo "0 results";
                            }
                            echo '</select></div>';
                
                        echo'</div>
                     </div>';
                        
                  //fizetési mód
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Fizetés módja:</label>
                        <div class="col-sm-7">';
                        
                        echo'<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-money"></i></span>';
                            echo'<select class = "form-control" name = "select_fizmod">';
                            
                                echo '<option value=""> Összes fizetési mód </option>';
                                echo '<option value="kp-nyugta"> Készpénz nyugtával </option>';
                                echo '<option value="kp-számla"> Készpénz számlával </option>';
                                echo '<option value="kp-partner"> Készpénz partner </option>';
                                echo '<option value="bankkártya-nyugta"> Bankkártya nyugtával </option>';
                                echo '<option value="bankkártya-számla"> Bankkártya szamlával </option>';
                                echo '<option value="egészségpénztár-számla"> EP számlával </option>';
                                echo '<option value="egészségpénztár-kártya"> EP kártyával </option>';
                                echo '<option value="europe assistance"> Europe Assistance </option>';
                                echo '<option value="TELADOC"> TELADOC </option>'; 
                                echo '<option value="advance medical"> Advance Medical </option>';
                                echo '<option value="szamlazz.hu-átutalás"> Szamlazz.hu </option>';
                                echo '<option value="ajándék"> Ajándék </option>';
                                echo '<option value="átutalás"> Átutalás </option>';
                                                                   
                            echo '</select></div>';
                
                        echo'</div>
                     </div>';  
                // szolgáltatások
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Szolgáltatások:</label>
                        <div class="col-sm-7">';
                        
                        echo'<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-user-plus"></i></span>';
                            echo'<input class = "form-control" name="szogl_tip" type="text" placeholder="szolgáltatás tipusa szövegesen"> ';
                                                       
                                        
                            echo '</div>';
                
                        echo'</div>
                     </div>';     
                        
                  // páciens neve
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Páciens neve:</label>
                        <div class="col-sm-7">';
                        
                        echo'<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-male"></i></span>';
                            echo'<input class = "form-control" name="paciens_neve" type="text" placeholder="Gipsz Jakab"> ';
                                                       
                                        
                            echo '</div>';
                
                        echo'</div>
                     </div>';                 
                                
                        
                        
                        
                
                 // törölt rögzítések
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Törölt rögzítések :</label>
                        <div class="col-sm-7">';
                        
                        echo '<div class="checkbox">
                                 <label><input type="checkbox" name="select_totolt" value="1">Csak a törölt elemek! </label>
                            </div>';
                        
                
                
                echo'</div>
                     </div>';            
                //gombok
                echo '<div class="form-group">';
                    echo '<label class="col-sm-3 control-label"></label>';    
                    echo'<div class="btn-group">';
                        
                        echo'<button type="submit" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> Lekérdez</button>';
                       // echo'<a href="#" onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
                       // echo'<a href="#" onclick="CopyClipboard()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a>'                        
                        
                       echo '</div>'
                . '</div>';        
                echo '</form>';
            
            echo'</div>';
            echo'<div class="panel-footer">BMM
                </div></div>';
                
        mysqli_close($conn);
        
}

// admin időszaki összesítés form eredmény post
    function admin_post_select_query(){
       
        
          if (isset($_POST["startdate"]) && isset($_POST["enddate"]) && isset($_POST["select_rogzito"]) && isset($_POST["select_terapeuta"]) && isset($_POST["select_telephely"]) && isset($_POST["select_fizmod"]) ) {
            
            
            $startdate = $_POST["startdate"];
            $enddate = $_POST["enddate"];
            $rogzito = $_POST["select_rogzito"];            
            $terapeuta = $_POST["select_terapeuta"];
            $telephely = $_POST["select_telephely"];
            $szolgaltatas = $_POST["szogl_tip"];
            $paciens_neve = $_POST["paciens_neve"];
            
            if (isset($_POST["select_totolt"])){
                $torolve = $_POST["select_totolt"];
            }else{
                $torolve = 0;
            }
            $fizmod = $_POST["select_fizmod"];
        
        // where paraméter at összesítő tábla számára 
        $this->where = "WHERE telephely LIKE '%$telephely%' AND (date BETWEEN '$startdate' AND '$enddate') AND torolt_szamla = '$torolve' AND  rogzito LIKE '%$rogzito%' AND  kezelo_orvos_id LIKE '%$terapeuta%' AND  bevetel_tipusa_id LIKE '%$fizmod%' AND szolgaltatas_id LIKE '%$szolgaltatas%' AND paciens_neve LIKE '%$paciens_neve%'";
        $this->startdate =  $startdate;
        $this->enddate = $enddate;
        $this->telephely = $telephely;
        }
    }        
    
    //riposrt összes rekordot megjelenytő tábla
    function create_table (){       
        $conn = DbConnect();
        
   
            
             // táblázat visszaolvasása
        echo '<div id="myInput">';
       
        echo'<h1>Lekérdezés eredménye:</h1>';
       
        echo '<p> <a href="#" onclick="copyClipboard1()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a>'.$this->where.'<p>';

        echo '<table class="table table-bordered" id="riport1">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Dátum</th>
                        <th>Páciens Neve</th>
                        <th>Kezelő / Orvos</th>
                        <th>Szolgáltatás típusa</th>
                        <th>Fizetés módja</th>
                        <th>EP lista</th>
                        <th>Bruttó Árbev. Ft</th>
                        <th>Jutalék</th>
                        <th>Bérlet</th>
                        <th>Számlaszám</th>
                        <th>Bankkártya Slip</th>
                        <th>Pénztárgép Slip</th>
                        <th>Rögzítő</th>
                        <th>Telephely</th>
                     </tr>
                </thead>
                <tbody>';
        
    // az aktuális napi bevételek lekérdezése
        if($this->where != 'nincs parameter'){
            $sql = "SELECT * FROM napi_elszamolas ".$this->where;
            $result = $conn->query($sql);    

            if ($result->num_rows > 0) {
            // output data of each row
                while ($row = $result->fetch_assoc()) {
                    if($row["lezart_szamla"] == 1){                  
                        $class = 'success';    
                    }else{
                        $class = 'warning';
                    }
                    $szamla_id =  $row["id_szamla"];             
                    echo "<tr class=".'"'.$class.'"'."><td>"
                    . '<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_db_line('.$szamla_id.')"><i class="fa fa-edit"></i></button></i></td><td>'         
                    . $row["id_szamla"] . "</td><td> "       
                    . $row["date"] . "</td><td> "
                    . $row["paciens_neve"] . "</td><td> "
                    . $row["kezelo_orvos_id"] . "</td><td>"
                    . $row["szolgaltatas_id"] . "</td><td>"
                    . $row["bevetel_tipusa_id"] . "</td><td>"
                    . $row["ep_tipus"] . "</td><td>"
                    . $row["bevetel_osszeg"] . "</td><td>"
                    . $row["jutalek_osszeg"] . "</td><td>"
                    . $row["berlet_adatok"] . "</td><td>"
                    . $row["szamlaszam"] . "</td><td>"        
                    . $row["slipsz"] . "</td><td>"
                    . $row["nyugtasz"] . "</td><td>"
                    . $row["rogzito"] . "</td><td>"
                    . $row["telephely"] . "</td></tr>";
                    
                }
            } else {
                echo "<tr><td>Nincs rögzített adat</td></tr>";
            }
        }
        echo "</tbody></table></div>";
           
       
         // kp kivétek
        
        $this->admin_select_kpkivet_all_table();
        // számla átvétek
        
        $this->admin_select_szamla_table_allatvet();
            
        mysqli_close($conn);
           
            
       echo '<!-- Trigger the modal with a button -->
            
            <!-- Modal -->
            <div id="editModal" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Rögzített adatok módosítása</h4>
                  </div>
                  <div class="modal-body" id="edit_napiadat">
                   
                  </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

              </div>
            </div>';     
    }
    

public function admin_osszesített_query(){
    $conn = DbConnect();
    echo '<div class="panel panel-default">
            <div class="panel-heading">Összesített eredmények:'.$this->where.'  
               <a href="#" onclick="copyClipboard()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a></div>
            
            <div class="panel-body" id="date_table">';

        echo '<table class="table table-striped" id="riport">
                <thead>
                    <tr>
                        <th>Bevétel tipusok</th>
                        <th>Összeg(HUF)</th>
                        <th>Darabszám</th>
                    </tr>
                </thead>';
        // az aktuális napi bevételek lekérdezése
        if ($this->where != "nincs parameter"){     // csak ha a lekérdezéshez tartozik paraméterérték is 
        echo'<tr>';
                // készpénz adatok összesítése    
                echo '<td>Készpénz (számla + nyugat)</td>';
                // ósszesített összegek
                $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas ".$this->where. " AND ( bevetel_tipusa_id = 'kp-nyugta' OR bevetel_tipusa_id = 'kp-számla' )";
 

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {
                      
                        
                        while ($row1 = $result->fetch_assoc()) {
                            if ($row1["sum_kp_bevetel"] == "") {$row1["sum_kp_bevetel"] = 0;}
                            
                            echo '<td>'.$row1["sum_kp_bevetel"].'</td>';
                            $this->forgalmi_adatok['kp-ft'] = $row1["sum_kp_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                          
                    }
                // összesített darabszám
               $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas ".$this->where. " AND ( bevetel_tipusa_id = 'kp-nyugta' OR bevetel_tipusa_id = 'kp-számla' )";


                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {

                        while ($row1 = $result->fetch_assoc()) {
                            echo '<td>'.$row1["db_kp_bevetel"].'</td>';
                            $this->forgalmi_adatok['kp-db'] = $row1["db_kp_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }
                
         echo '</tr>';
         echo '<tr>';               
            // Bankkártya forgalomi  adatok összesítése    
                echo '<td>Bankkártya (számla + nyugat)</td>';
                // ósszesített összegek
                $sql1 = "SELECT sum(bevetel_osszeg) as sum_bk_bevetel FROM napi_elszamolas ".$this->where  . " AND ( bevetel_tipusa_id = 'bankkártya-nyugta' OR bevetel_tipusa_id = 'bankkártya-számla' )"; ;

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {
                       
                        
                        while ($row1 = $result->fetch_assoc()) {
                            
                             if ($row1["sum_bk_bevetel"] == "") {$row1["sum_bk_bevetel"] = 0;}
                            
                            echo '<td>'.$row1["sum_bk_bevetel"].'</td>';
                                                   
                            $this->forgalmi_adatok['bankkartya-ft']= $row1["sum_bk_bevetel"];
                           
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }
                // összesített darabszám
               $sql1 = "SELECT count(*) as db_bk_bevetel FROM napi_elszamolas ".$this->where . " AND ( bevetel_tipusa_id = 'bankkártya-nyugta' OR bevetel_tipusa_id = 'bankkártya-számla' )";;

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {

                        while ($row1 = $result->fetch_assoc()) {
                            echo '<td>'.$row1["db_bk_bevetel"].'</td>';
                            $this->forgalmi_adatok['bankkartya-db'] = $row1["db_bk_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }    
            echo '</tr>';
            echo '<tr>';               
            //Egészségpénztári forgalomi  adatok összesítése    
                echo '<td>Egészségpénztár (számla + kártya)</td>';
                // ósszesített összegek
                $sql1 = "SELECT sum(bevetel_osszeg) as sum_ep_bevetel FROM napi_elszamolas ".$this->where . " AND  bevetel_tipusa_id  LIKE '%egészségpénztár%'";;

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {
                        
                        while ($row1 = $result->fetch_assoc()) {
                             if ($row1["sum_ep_bevetel"] == "") {$row1["sum_ep_bevetel"] = 0;}
                            
                            echo '<td>'.$row1["sum_ep_bevetel"].'</td>';
                            $this->forgalmi_adatok['ep-ft'] = $row1["sum_ep_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }
                // összesített darabszám
               $sql1 = "SELECT count(*) as db_ep_bevetel FROM napi_elszamolas ".$this->where. " AND  bevetel_tipusa_id  LIKE '%egészségpénztár%'";;

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {

                        while ($row1 = $result->fetch_assoc()) {
                            echo '<td>'.$row1["db_ep_bevetel"].'</td>';
                            $this->forgalmi_adatok['ep-db'] = $row1["db_ep_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }    
            echo '</tr>';
            echo '<tr>';               
            //EuropeAssistance forgalomi  adatok összesítése    
                echo '<td>Europe Assistance</td>';
                // ósszesített összegek
                $sql1 = "SELECT sum(bevetel_osszeg) as sum_ea_bevetel FROM napi_elszamolas ".$this->where  . " AND  bevetel_tipusa_id = 'europe assistance'";;

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {
                        
                        while ($row1 = $result->fetch_assoc()) {
                            if ($row1["sum_ea_bevetel"] == "") {$row1["sum_ea_bevetel"] = 0;}
                            echo '<td>'.$row1["sum_ea_bevetel"].'</td>';
                            $this->forgalmi_adatok['europeassistance-ft'] = $row1["sum_ea_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }
                // összesített darabszám
               $sql1 = "SELECT count(*) as db_ea_bevetel FROM napi_elszamolas ".$this->where  . " AND  bevetel_tipusa_id = 'europe assistance'";;

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {

                        while ($row1 = $result->fetch_assoc()) {
                            echo '<td>'.$row1["db_ea_bevetel"].'</td>';
                            $this->forgalmi_adatok['europeassistance-db'] = $row1["db_ea_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }    
            echo '</tr>';
            echo '<tr>';               
            //Adv Medical / TELADOC forgalomi  adatok összesítése    
                echo '<td>TELADOC</td>';
                // ósszesített összegek
                $sql1 = "SELECT sum(bevetel_osszeg) as sum_am_bevetel FROM napi_elszamolas ".$this->where . " AND  bevetel_tipusa_id = 'TELADOC'";
                
                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {
                        
                        while ($row1 = $result->fetch_assoc()) {
                            
                            if ($row1["sum_am_bevetel"] == "") {$row1["sum_am_bevetel"] = 0;}
                            
                            echo '<td>'.$row1["sum_am_bevetel"].'</td>';
                            $this->forgalmi_adatok['advancemedical-ft'] = $row1["sum_am_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }
                // összesített darabszám
               $sql1 = "SELECT count(*) as db_am_bevetel FROM napi_elszamolas ".$this->where . " AND  bevetel_tipusa_id = 'TELADOC'";

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {

                        while ($row1 = $result->fetch_assoc()) {
                            echo '<td>'.$row1["db_am_bevetel"].'</td>';
                            $this->forgalmi_adatok['advancemedical-db'] = $row1["db_am_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }    
            echo '</tr>';
            echo '<tr>';               
            
                //Union-Érted forgalomi  adatok összesítése    
                echo '<td>Union-Érted</td>';
                // ósszesített összegek
                $sql1 = "SELECT sum(bevetel_osszeg) as sum_am_bevetel FROM napi_elszamolas ".$this->where . " AND  bevetel_tipusa_id = 'Union-Érted'";
                
                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {
                        
                        while ($row1 = $result->fetch_assoc()) {
                            
                            if ($row1["sum_am_bevetel"] == "") {$row1["sum_am_bevetel"] = 0;}
                            
                            echo '<td>'.$row1["sum_am_bevetel"].'</td>';
                            $this->forgalmi_adatok['Union-Erted-ft'] = $row1["sum_am_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }
                // összesített darabszám
               $sql1 = "SELECT count(*) as db_am_bevetel FROM napi_elszamolas ".$this->where . " AND  bevetel_tipusa_id = 'Union-Érted'";

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {

                        while ($row1 = $result->fetch_assoc()) {
                            echo '<td>'.$row1["db_am_bevetel"].'</td>';
                            $this->forgalmi_adatok['Union-Erted-db'] = $row1["db_am_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }    
            echo '</tr>';
            echo '<tr>';  
            //-----Számlázz.hu forgalomi  adatok összesítése    
                echo '<td>Szamlazz.hu</td>';
                // ósszesített összegek
                $sql1 = "SELECT sum(bevetel_osszeg) as sum_sz_bevetel FROM napi_elszamolas ".$this->where . " AND  bevetel_tipusa_id LIKE '%szamlazz.hu%'";;
                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {
                        
                        while ($row1 = $result->fetch_assoc()) {
                            
                            if ($row1["sum_sz_bevetel"] == "") {$row1["sum_sz_bevetel"] = 0;}
                            
                            echo '<td>'.$row1["sum_sz_bevetel"].'</td>';
                            $this->forgalmi_adatok['szamlazz.hu-ft'] = $row1["sum_sz_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }
                // összesített darabszám
               $sql1 = "SELECT count(*) as db_sz_bevetel FROM napi_elszamolas ".$this->where . " AND  bevetel_tipusa_id LIKE '%szamlazz.hu%'";;

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {

                        while ($row1 = $result->fetch_assoc()) {
                            echo '<td>'.$row1["db_sz_bevetel"].'</td>';
                            $this->forgalmi_adatok['szamlazz.hu-db'] = $row1["db_sz_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }    
            echo '</tr>';
            
            
             echo '<tr>';               
            //átutalás forgami adaton forgalomi  adatok összesítése    
                echo '<td>Átutalás</td>';
                // ósszesített összegek
                $sql1 = "SELECT sum(bevetel_osszeg) as sum_ut_bevetel FROM napi_elszamolas ".$this->where. " AND  bevetel_tipusa_id = 'átutalás'";;

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {
                       
                        while ($row1 = $result->fetch_assoc()) {

                            if ($row1["sum_ut_bevetel"] == "") {$row1["sum_ut_bevetel"] = 0;}
                             
                            echo '<td>'.$row1["sum_ut_bevetel"].'</td>';
                            $this->forgalmi_adatok['atutalas-ft'] = $row1["sum_ut_bevetel"];
                            
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }
                // összesített darabszám
               $sql1 = "SELECT count(*) as db_ut_bevetel FROM napi_elszamolas ".$this->where . " AND  bevetel_tipusa_id = 'átutalás'";;

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {

                        while ($row1 = $result->fetch_assoc()) {
                            echo '<td>'.$row1["db_ut_bevetel"].'</td>';
                            $this->forgalmi_adatok['atutalas-db'] = $row1["db_ut_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }    
            echo '</tr>';
            
          echo '<tr>';               
            //ajándék forgami adatok összesítése    
                echo '<td>Ajándék</td>';
                
                // ósszesített összegek
                //$sql1 = "SELECT sum(bevetel_osszeg) as sum_aj_bevetel FROM napi_elszamolas".$this->where  . " AND  bevetel_tipusa_id = 'ajándék'";
                $sql1 = "SELECT sum(bevetel_osszeg) as sum_aj_bevetel FROM napi_elszamolas ".$this->where. " AND bevetel_tipusa_id = 'ajandek'";

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {
                                       
                        
                        while ($row1 = $result->fetch_assoc()) {
                            
                           if ($row1["sum_aj_bevetel"] == "") {$row1["sum_aj_bevetel"] = 0;}
                            
                            echo '<td>'.$row1["sum_aj_bevetel"].'</td>';
                            $this->forgalmi_adatok['ajandek-ft'] = $row1["sum_aj_bevetel"];
                        }
                        
                    } else {
                         echo "<td></td>";
                    }
                // összesített darabszám
               $sql1 = "SELECT count(*) as db_aj_bevetel FROM napi_elszamolas ".$this->where . " AND  bevetel_tipusa_id = 'ajándék'";

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {
                        
                        $this->forgalmi_adatok['ajandek-db'] = 0;
                         
                        while ($row1 = $result->fetch_assoc()) {
                            echo '<td>'.$row1["db_aj_bevetel"].'</td>';
                            $this->forgalmi_adatok['ajandek-db'] = $row1["db_aj_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }    
            echo '</tr>';  
            
                     // készpénz adatok összesítése    
            echo '<td>Készpénz partner</td>';
                // ósszesített összegek
                $sql1 = "SELECT sum(bevetel_osszeg) as sum_kppart_bevetel FROM napi_elszamolas ".$this->where. " AND bevetel_tipusa_id = 'kp-partner'";
 

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {
                      
                        
                        while ($row1 = $result->fetch_assoc()) {
                            if ($row1["sum_kppart_bevetel"] == "") {$row1["sum_kppart_bevetel"] = 0;}
                            
                            echo '<td>'.$row1["sum_kppart_bevetel"].'</td>';
                            $this->forgalmi_adatok['kp-partner-ft'] = $row1["sum_kppart_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                          
                    }
                // összesített darabszám
               $sql1 = "SELECT count(*) as db_kppart_bevetel FROM napi_elszamolas ".$this->where. " AND bevetel_tipusa_id = 'kp-partner'";


                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {

                        while ($row1 = $result->fetch_assoc()) {
                            echo '<td>'.$row1["db_kppart_bevetel"].'</td>';
                            $this->forgalmi_adatok['kp-partner-db'] = $row1["db_kppart_bevetel"];
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }
                
         echo '</tr>';   
            
            
            echo '<tr  class="success">';               
            // forgami adatok összesítése    
                echo '<td>Összesen</td>';
                
                // ósszesített összegek
                //$sql1 = "SELECT sum(bevetel_osszeg) as sum_all_bevetel FROM napi_elszamolas".$this->where;
                $sql1 = "SELECT sum(bevetel_osszeg) as sum_all_bevetel FROM napi_elszamolas ".$this->where;


                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {

                        while ($row1 = $result->fetch_assoc()) {
                            echo '<td>'.$row1["sum_all_bevetel"].'</td>';
                           
                        }
                        
                    } else {
                         echo "<td></td>";
                    }
                // összesített darabszám
               $sql1 = "SELECT count(*) as db_all_bevetel FROM napi_elszamolas ".$this->where;

                $result = $conn->query($sql1);
                    if ($result->num_rows > 0) {

                        while ($row1 = $result->fetch_assoc()) {
                            echo '<td>'.$row1["db_all_bevetel"].'</td>';
                            
                        }
                        
                    } else {
                         echo "<td>Nincs rögzített adat</td>";
                    }    
            echo '</tr>';    
            
            
 
                        
        }
         
        
        echo "</tbody></table>";
       
        echo '</div>
        </div>';
    
}
   
    function admin_select_szamla_table_allatvet() {
        $conn = DbConnect();
        
        $today_date = date("y-m-d");
        
        $sql = "SELECT * FROM szamla_befogadas WHERE (szamla_atvetdate BETWEEN '$this->startdate' AND '$this->enddate') AND szamla_telephely LIKE '%$this->telephely%' AND szamla_torolt = '0'";
        $result = $conn->query($sql);

        echo'<div class="">
                   
                <table class="table table-striped">
                <thead>
                    <tr><th>Átvett számlák:</th></tr>
                    <tr>
                      <th>No.:</th>
                      <th>Átvevő</th>
                      <th>Kibocsátó</th>
                      <th>Számla sorszám</th>
                      <th>Megjegyzés</th>
                    </tr>
                  </thead><tbody>';
            
        if ($result->num_rows > 0) {    
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>"
                . $row["szamla_id"] . "</td><td> "
                . $row["szamla_atvevo"] . "</td><td>"
                . $row["szamla_kibocsato"] . "</td><td>"
                . $row["szamla_sorszam"] . "</td><td>"   
                . $row["szamla_megjegyzes"] . "</td></tr>" 
               ;
            }
        } else {
            echo "<tr><td>Nincs rögzített adat</td></tr>";
        }
        echo "</tbody></table></div>";
        
       
        mysqli_close($conn);
    }
 
   public function admin_select_kpkivet_all_table(){
 
        $conn = DbConnect();
       
                
        $sql = "SELECT * FROM kp_kivet WHERE (kivet_datum BETWEEN '$this->startdate' AND '$this->enddate') AND kivet_telephely LIKE '%$this->telephely%' AND kivet_torolve ='0'" ;
        $result = $conn->query($sql);
      
            echo'<div class="">
                <table class="table table-striped">
                <thead>
                    <tr><th>Készpénz kivétek</th></tr>
                    <tr>
                      <th>No.:</th>
                      <th>Kiadó</th>
                      <th>Kivét Oka</th>
                      <th>Kivét Összege(Ft)</th>
                      <th>Kivét Átvevő</th>
                      <th>Megjegyzés</th>
                    </tr>
                  </thead><tbody>';
            
        if ($result->num_rows > 0) {     
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>"
                . $row["kivet_id"] . "</td><td> "
                . $row["kivevo_neve"] . "</td><td>"
                . $row["kivet_oka"] . "</td><td>"
                . $row["kivet_osszeg"] . "</td><td>"   
                . $row["kivet_atvevo"] . "</td><td>"
                . $row["kivet_megjegyzes"] . "</td></tr>"
               ;
            }
        } else {
            echo "<tr><td>Nincs rögzített adat</td></tr>";
        }
        // kivét napi szintű összesítése
        
        $sql2 = "SELECT sum(kivet_osszeg) as sum_kivet FROM kp_kivet where kivet_telephely LIKE '%$this->telephely%' AND kivet_torolve = '0' AND (kivet_datum BETWEEN '$this->startdate' AND '$this->enddate')";
            
            $result2 = $conn->query($sql2);
            
            if ($result2->num_rows == 1) {
                   while ($row1 = $result2->fetch_assoc()) {
                    $recepcioKivet= $row1["sum_kivet"];
                }
            } else {
                 $recepcioKivet = 0;
            }
            echo '<tr class="info"><td></td><td></td><td>Összesen: </td><td>'.$recepcioKivet.'</td><td></td><td></td></tr>';
        
        
        
        echo "</tbody></table></div>";
        
              
             mysqli_close($conn);
    }

//évesített haci bontású jutalék tábla
public function havi_jutalek_table(){
    $conn = DbConnect();
    
    echo '<table class="table table-striped" >';
    echo '<thead><tr><th>Orvos - kezelők</th>'; 
    for($honap = 1;$honap < 13;$honap++){
    
    echo '<th><center>'.$this->mons["$honap"].'</center></th>';
 
    }
    echo '</tr></thead>';
    
    $sql = "SELECT DISTINCT kezelo_neve FROM kezelok_orvosok ORDER BY kezelo_neve ASC";
                          
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
            echo '<tr><td>'.$row["kezelo_neve"].'</td> ';
                for($honap = 1 ; $honap <=12 ; $honap++){
                    echo '<td>'.$this->orvos_kezelo_havijutalek($row["kezelo_neve"],$honap).'</td>';
                }
            
        }
        } else {
            echo "0 results";
        }                    
    
    echo '</table>';
    mysqli_close($conn);
}

public function orvos_kezelo_havijutalek($kezelonev,$honap){
    
    $jutalek = 0;
    $conn = DbConnect();
    $startdate = $this->year.'-'.$honap.-'01';
    $enddate = $this->year.'-'.$honap.-'31';
    $sql1 = "SELECT sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE (date BETWEEN '$startdate' AND '$enddate') AND torolt_szamla = '0' AND kezelo_orvos_id = '$kezelonev' ";

                $result = $conn->query($sql1);
                if ($result->num_rows > 0) {
                    while ($row1 = $result->fetch_assoc()) {
                       $jutalek  = $row1["sum_jutalek"] ;
                    }
                } else {
                     $jutalek = 0;
                }
     mysqli_close($conn);
    
    return $jutalek;
}


public function orvos_kezelo_bmmbevetel_table(){
    $conn = DbConnect();
    
   
    echo '<table class="table table-striped table-condensed" >';
    echo '<thead>   <tr><th style="border-right: 1px solid grey;">Orvos - kezelő</th>';
    
    for($honap = 1;$honap < 13;$honap++){
    
    echo '<th  colspan="3"><center>'.$this->mons["$honap"].'</center></th>';
 
    }
    echo '<tr><th style="border-right: 1px solid grey;" ></th>';
    
    for($honap = 1;$honap < 13;$honap++){
    
    echo '<th>Bevétel</th><th>Jutalék</th><th style="border-right: 1px solid grey;">Marad</th>';
    
    }
  
    echo'</tr></thead>';
    $sql = "SELECT DISTINCT kezelo_neve FROM kezelok_orvosok ORDER BY kezelo_neve ASC";
                          
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
            echo '<tr><td style="border-right: 1px solid grey;">'.$row["kezelo_neve"].'</td> ';
                for($honap = 1 ; $honap <=12 ; $honap++){
                    echo $this->orvos_kezelo_havibmmbevetel($row["kezelo_neve"],$honap);
                }
            
        }
        } else {
            echo "0 results";
        }                    
    
    echo '</table>';
    mysqli_close($conn);
}

public function orvos_kezelo_havibmmbevetel($kezelonev,$honap){
    
    $jutalek = 0;
    $bevetel = 0; 
    $bmmbev = 0;
    $conn = DbConnect();
    
        $startdate = $this->year.'-'.$honap.-'01';   
        $enddate = $this->year.'-'.$honap.-'31';
    
//        $startdate = '2019-'.$honap.-'01'; 
//        $enddate = '2019-'.$honap.-'31';
    
    
    $sql1 = "SELECT sum(bevetel_osszeg) as sum_bevetel ,sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE (date BETWEEN '$startdate' AND '$enddate') AND torolt_szamla = '0' AND kezelo_orvos_id = '$kezelonev' ";

                $result = $conn->query($sql1);
                if ($result->num_rows > 0) {


                    while ($row1 = $result->fetch_assoc()) {
                       $jutalek  = $row1["sum_jutalek"] ;
                       $bevetel =  $row1["sum_bevetel"];
                       $bmmbev = $bevetel - $jutalek;
                    }
                } else {
                     $bmmbev = 'nincs adat';
                }
     mysqli_close($conn);
    
    return ('<td>'.$bevetel.'</td><td>'.$jutalek.'</td><td style="border-right: 1px solid grey;">'.$bmmbev.'</td>');
    
}

public function drawchart_script(){
    echo  '<script type="text/javascript">';

      // Load the Visualization API and the corechart package.
    echo  " google.charts.load('current', {'packages':['corechart']});

          // Set a callback to run when the Google Visualization API is loaded.
          google.charts.setOnLoadCallback(drawChart);
          // Callback that creates and populates a data table,
          // instantiates the pie chart, passes in the data and
          // draws it.
          function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([";
    
              echo "['Készpénz',". $this->forgalmi_adatok['kp-db']."],";
              echo "['Bankkártya',". $this->forgalmi_adatok['bankkartya-db']."],";
              echo "['Egészségpénztár',". $this->forgalmi_adatok['ep-db']."],";
              echo "['Europe Assistance',". $this->forgalmi_adatok['europeassistance-db']."],";
              echo "['Advance Medical',". $this->forgalmi_adatok['advancemedical-db']."],"; 
              echo "['Átutalás',". $this->forgalmi_adatok['atutalas-db']."],"; 
              echo "['Ájándék',". $this->forgalmi_adatok['ajandek-db']."],"; 
              echo "['Kp-partner',". $this->forgalmi_adatok['kp-partner-db']."],"; 
              echo "]);

            // Set chart options
            var options = {'title':'Időszaki fizetési módok darabszám',
                           'width':400,
                           'height':400,};

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div_db'));
            chart.draw(data, options);
          }
          
          
        </script>";

}

public function draw_double_chart(){
    echo '<script type="text/javascript">';

    echo "google.charts.load('current', {'packages':['corechart']});

    google.charts.setOnLoadCallback(drawSarahChart);
    
    google.charts.setOnLoadCallback(drawAnthonyChart);";

      // Callback that draws the pie chart for Sarah's pizza.
    echo  "function drawSarahChart() {

        
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([";
              echo "['Készpénz',". $this->forgalmi_adatok['kp-db']."],";
              echo "['Bankkártya',". $this->forgalmi_adatok['bankkartya-db']."],";
              echo "['Egészségpénztár',". $this->forgalmi_adatok['ep-db']."],";
              echo "['Europe Assistance',". $this->forgalmi_adatok['europeassistance-db']."],";
              echo "['Advance Medical',". $this->forgalmi_adatok['advancemedical-db']."],"; 
              echo "['Átutalás',". $this->forgalmi_adatok['atutalas-db']."],"; 
              echo "['Ájándék',". $this->forgalmi_adatok['ajandek-db']."],"; 
              echo "['Kp-partner',". $this->forgalmi_adatok['kp-partner-db']."],"; 
              echo "['Szamlazz.hu',". $this->forgalmi_adatok['szamlazz.hu-db']."],"; 
              echo "['Union-Érted',". $this->forgalmi_adatok['Union-Erted-db']."],"; 
    echo  "])
       
        var options = {title:'Bevételek alakulása fizetési mód drabszáma szerint',
                      width:500,
                       height:500};
       
        var chart = new google.visualization.PieChart(document.getElementById('DB_chart_div'));
        chart.draw(data, options);
      }";

   
   echo  "function drawAnthonyChart() {

        
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([ ";
              echo "['Készpénz',". $this->forgalmi_adatok['kp-ft']."],";
              echo "['Bankkártya',". $this->forgalmi_adatok['bankkartya-ft']."],";
              echo "['Egészségpénztár',". $this->forgalmi_adatok['ep-ft']."],";
              echo "['Europe Assistance',". $this->forgalmi_adatok['europeassistance-ft']."],";
              echo "['Advance Medical',". $this->forgalmi_adatok['advancemedical-ft']."],"; 
              echo "['Átutalás',". $this->forgalmi_adatok['atutalas-ft']."],"; 
              echo "['Ájándék',". $this->forgalmi_adatok['ajandek-ft']."],"; 
              echo "['Kp-partner',". $this->forgalmi_adatok['kp-partner-ft']."],"; 
              echo "['Szamlazz.hu',". $this->forgalmi_adatok['szamlazz.hu-ft']."],"; 
              echo "['Union-Érted',". $this->forgalmi_adatok['Union-Erted-ft']."],"; 
    echo  "])

        var options = {title:'Forint bevételek alakulása fizetési mód szerint',
                       width:500,
                       height:500};
     
        var chart = new google.visualization.PieChart(document.getElementById('FT_chart_div'));
        chart.draw(data, options);
      }
    </script>";

}

 public function select_orvos_idoszaki_jutaléklista(){
        $conn = DbConnect();
        
        echo'<div class="row" id="HiddenIfPrint">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div class="panel panel-info">    
                    <div class="panel-heading">Orvos vagy kezelő kimutatása egészségügyi elláűtásról.</div>
                        <div class="panel-body">';
                        
                        
                            echo '<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page93">';
                            //lekérdezési időszak eleje
                            echo '<div class="form-group">
                                    <label class="col-sm-3 control-label" >Időszak eleje :</label>
                                    <div class="col-sm-7"><input type="date" class="form-control" name="startdate" ></div>
                                 </div>';
                            //lekérdezés időszak vége
                            echo '<div class="form-group">
                                    <label class="col-sm-3 control-label" >Időszak vége :</label>
                                    <div class="col-sm-7 "><input type="date" class="form-control"  name="enddate" ></div>
                                 </div>';
                            //terapeuta
                             echo '<div class="form-group" style="padding-bottom: 0cm;">
                                     <label class="col-sm-3 control-label" >Terapeuta :</label>
                                     <div class="col-sm-7">';

                                     echo'<div class="input-group">'
                                         . '<span class="input-group-addon"><i class="fa fa-user-md"></i></span>';
                                         echo'<select class = "form-control" name = "select_terapeuta">';
                                         
                                         $sql = "SELECT DISTINCT kezelo_neve FROM kezelok_orvosok ORDER BY kezelo_neve ASC";
                                         $result = $conn->query($sql);

                                         if ($result->num_rows > 0) {
                                             while ($row = $result->fetch_assoc()) {
                                                 echo '<option value="' . $row["kezelo_neve"] . '">' . $row["kezelo_neve"] . '</option>';
                                             }
                                         } else {
                                             echo "0 results";
                                         }
                                         echo '</select></div>';


                             echo  '</div>
                                  </div>';
                             
                             // lista típus rádió gomb
                            echo'<div class="form-group">'
                                . '<label class="col-sm-3 control-label">Lista tipus:  </label>'
                                . '<div class="col-sm-7" >'
                                . '<div class="radio">';
                            echo'<label><input type="radio" name="jutaleklista_tipus" value="all_jutalek" checked>Teljes lista.</label></div>'
                                . '<div class="radio"><label><input type="radio" name="jutaleklista_tipus" value="all_jutalek-kppartner"> Kp partnerek nélküli lista.</label></div>'
                                . '</div></div>';
                            
                            
                            echo'<div class="form-group">'
                                . '<label class="col-sm-3 control-label">Számla vevő:  </label>'
                                . '<div class="col-sm-7"><div class="radio"><label><input type="radio" name="szamla_vevo" value="medportkft" checked=""> Medport Kft. ( Budafoki, Pannonia)</label></div>'
                                . '<div class="radio"><label><input type="radio" name="szamla_vevo" value="medicalpluskft"> Medical Plus Kft. ( Óbuda )</label>'
                                . '<div class="radio"><label><input type="radio" name="szamla_vevo" value="SalgoMovekft"> Salgó Move Kft. ( SMM )</label></div>'
                                . '</div></div></div>';
                            
                                echo'<div class="form-group">'
                                    . '<label class="col-sm-3 control-label"></label>'
                                    . '<div class="col-sm-7">';
        
                                    echo'<div class="btn-group"><button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Jutalék</button>'
                                .    '<button type = "button" class = "btn btn-info" onclick="StartPrtintJutalekPage()"><i class="fa fa-print" aria-hidden="true"></i> Nyomtatás</button></div>'
                                . '</div></div>';
                                                    
                            echo '</form>';
                            echo '</div>                
                        </div>
                    </div>';  
                echo '<div class="col-sm-4"></div>
               </div>';                  


        mysqli_close($conn);         
        
        $this->post_select_orvos_idoszakijutaléklista();    
        
    }

    public function  post_select_orvos_idoszakijutaléklista(){
        $sumjutalek  = 0;
        $conn = DbConnect();
        if (isset($_POST["select_terapeuta"]) AND isset($_POST["enddate"]) AND isset($_POST["startdate"]))
        {
            $kezelo = $_POST["select_terapeuta"];
            $enddate = $_POST["enddate"];
            $startdate = $_POST["startdate"];
            
            if (isset($_POST["szamla_vevo"])){ $szamla_vevo = $_POST["szamla_vevo"];} else{$szamla_vevo = "";}
            $where = "";
                    
            if (isset($_POST["jutaleklista_tipus"]) AND $_POST["jutaleklista_tipus"] == "all_jutalek-kppartner") {

            $sql = "SELECT * FROM `napi_elszamolas` WHERE "
                    . "kezelo_orvos_id  = '$kezelo' AND (date BETWEEN '$startdate' AND '$enddate') AND jutalek_osszeg <> '0' AND torolt_szamla = '0' AND bevetel_tipusa_id <> 'kp-partner'";
            }else{
            
            $sql = "SELECT * FROM `napi_elszamolas` WHERE "
                    . "kezelo_orvos_id  = '$kezelo' AND (date BETWEEN '$startdate' AND '$enddate') AND torolt_szamla = '0'";    
                            
            }
            
            if ($szamla_vevo == "medportkft"){ $where = " AND ( telephely = 'BMM' OR telephely = 'Fizio' OR telephely = 'Lábcentrum' OR telephely = 'P70' OR telephely = 'P72' )";}
            if ($szamla_vevo == "medicalpluskft"){ $where = " AND telephely = 'Óbuda'";}
            if ($szamla_vevo == "SalgoMovekft"){ $where .= " AND telephely = 'SMM'";}
                
             $sql = $sql . $where;
            
            
            $result = $conn->query($sql);
            
                    echo'<div class="container">
                                <h2>'.$kezelo.' kimutatása egészségügyi ellátásról</h2>
                                <p>Dátum : '.$startdate.' - '.$enddate.'</p>
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Dátum</th>
                                    <th>Páciens Neve</th>
                                    <th>Kezelő / Orvos</th>
                                    <th>Szolgáltatás tipusa</th>
                                    <th>Fizetés módja</th>
                                    <th>EP lista</th>
                                    <th>Fizetés Összege</th>
                                    <th>Jutalék</th>
                                    <th>Bérlet</th>
                                    <th>Számlaszám</th>
                                    <th>Bankkártya Slip</th>
                                    <th>Pénztárgép Slip</th>
                                    <th>Rögzítő</th>
                                    <th>Telephely</th>
                                </tr>
                              </thead><tbody>';
                        
                    if ($result->num_rows > 0) {    
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>"
                            . $row["date"] . "</td><td> "
                            . $row["paciens_neve"] . "</td><td> "
                            . $row["kezelo_orvos_id"] . "</td><td>"
                            . $row["szolgaltatas_id"] . "</td><td>"
                            . $row["bevetel_tipusa_id"] . "</td><td>"
                            . $row["ep_tipus"] . "</td><td>"
                            . $row["bevetel_osszeg"] . "</td><td>"
                            . $row["jutalek_osszeg"] . "</td><td>"
                            . $row["berlet_adatok"] . "</td><td>"
                            . $row["szamlaszam"] . "</td><td>"        
                            . $row["slipsz"] . "</td><td>"
                            . $row["nyugtasz"] . "</td><td>"
                            . $row["rogzito"] . "</td><td>"
                            . $row["telephely"] . "</td></tr>";
                            
                            $sumjutalek += $row["jutalek_osszeg"];
                        }
                    } else {
                        echo "<tr><td>Nincs rögzített adat</td></tr>";
                    }

//                    $sql1 = "SELECT sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE" 
//                        . "kezelo_orvos_id  = '$kezelo' AND (date BETWEEN '$startdate' AND '$enddate') AND jutalek_osszeg <> '0' AND torolt_szamla = '0'";
//                    $result = $conn->query($sql1);
//                    if ($result->num_rows > 0) {
//                    
//                        while ($row1 = $result->fetch_assoc()) {
                    echo '<tr><td></td><td></td><td></td><td></td><td></td><td>Jutalék összesen:  </td><td></td><td>' . $sumjutalek . '</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
//                        }
//                    } else {
//                        echo "<tr><td>Nincs rögzített adat</td></tr>";
//                    }
//                    echo'</tr>';
                    echo "</tbody></table>";
        
                    echo '<br><br><br><div class="col-sm-4" style="border-top: dotted 1px; text-align: center;"> Időszaki jutalék elszámolás rendben: '.$kezelo. '  </div>';
        }            
        mysqli_close($conn);          
    }

    public function post_orvos_havilekerdezese(){
        $month = "" ;   
        $year = "";
        $timestamp = "";
        $startdate = "";
        $enddate = "";
        // havi jutaléklista
        if (isset($_POST["select_terapeuta"]) AND isset($_POST["jutalek_month"]) AND isset($_POST["jutaleklista_tipus"]) AND isset($_POST["szamla_vevo"]))
        {
            $startdate = $_POST["jutalek_month"].'-01';
            $timestamp = strtotime($startdate);

            $year = date("Y",  $timestamp); 
            $month = date ("m", $timestamp);
            $enddate =$_POST["jutalek_month"].'-'.cal_days_in_month(CAL_GREGORIAN, $month, $year);     
          //  echo $startdate.' - '.$enddate;        

            $_POST["enddate"] = $enddate;
            $_POST["startdate"] = $startdate;
            $this->post_select_orvos_idoszakijutaléklista();
        }
        // napi jutalélklista 
        if (isset($_POST["select_terapeuta"]) AND isset($_POST["jutalek_day"]) AND isset($_POST["jutaleklista_tipus"]))
        {
            $_POST["enddate"] = $_POST["jutalek_day"];
            $_POST["startdate"]  = $_POST["jutalek_day"];


            $this->post_select_orvos_idoszakijutaléklista();
        }
    }
     
    // napi_elszamolas update rekordok javítása
    public function admin_post_elszupdate (){
        
        if ( isset($_POST["nap_elsz_update_id"]) AND isset($_POST["paciens_neve"]) AND isset($_POST["kezelo_orvos_id"]) AND
             isset($_POST["szolgaltatas_id"]) AND isset($_POST["bevetel_tipusa_id"]) AND isset($_POST["ep_tipus"]) AND  
             isset($_POST["bevetel_osszeg"]) AND isset($_POST["jutalek_osszeg"]) AND isset($_POST["berlet_adatok"]) AND
             isset($_POST["szamlaszam"]) AND isset($_POST["slipsz"]) AND isset($_POST["nyugtasz"])   AND
             isset($_POST["rogzito"]) AND isset($_POST["telephely"]) AND isset($_POST["atvevo_neve"])   AND   
             isset($_POST["lezart_szamla"]) AND isset($_POST["el_beteglista_id"]) AND isset($_POST["torolt_szamla"])   
                
            ){
        $conn = DbConnect();
         
        $id_szamla = $_POST["nap_elsz_update_id"];
        $paciens_neve = $_POST["paciens_neve"];
        $kezelo_orvos_id = $_POST["kezelo_orvos_id"];
        $szolgaltatas_id = $_POST["szolgaltatas_id"];
        $bevetel_tipusa_id = $_POST["bevetel_tipusa_id"];
        $ep_tipus = $_POST["ep_tipus"];
        $bevetel_osszeg = $_POST["bevetel_osszeg"];
        $jutalek_osszeg = $_POST["jutalek_osszeg"];
        $berlet_adatok = $_POST["berlet_adatok"];
        $szamlaszam = $_POST["szamlaszam"];
        $slipsz = $_POST["slipsz"];
        $nyugtasz = $_POST["nyugtasz"];
        $rogzito = $_POST["rogzito"];
        $telephely = $_POST["telephely"];
        $atvevo_neve = $_POST["atvevo_neve"];
        $lezart_szamla = $_POST["lezart_szamla"];
        $el_beteglista_id = $_POST["el_beteglista_id"];
        $torolt_szamla = $_POST["torolt_szamla"];
        
        
            $sql = "UPDATE napi_elszamolas SET paciens_neve = '$paciens_neve', kezelo_orvos_id = '$kezelo_orvos_id', "
                . "szolgaltatas_id = '$szolgaltatas_id', bevetel_tipusa_id = '$bevetel_tipusa_id',"
                . "ep_tipus = '$ep_tipus', bevetel_osszeg  = '$bevetel_osszeg', jutalek_osszeg='$jutalek_osszeg',"
                . "berlet_adatok = '$berlet_adatok',szamlaszam = '$szamlaszam', slipsz='$slipsz', nyugtasz='$nyugtasz', "
                . "rogzito='$rogzito',telephely = '$telephely', atvevo_neve = '$atvevo_neve', lezart_szamla = '$lezart_szamla',"
                . "el_beteglista_id = '$el_beteglista_id', torolt_szamla = '$torolt_szamla'  "
                . "WHERE id_szamla= '$id_szamla'";

            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully id:" . $id_szamla ;
            } else {
                echo "Error updating record: " . $conn->error;
            }
            
            
        mysqli_close($conn);      
        }
        
        
             
        
    }
    
}

?>
