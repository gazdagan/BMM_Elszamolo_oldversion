<?php

/**
 * napi_bevetel db napi_elszamolas tablát kezklő ostály
 */

class napi_elszamolas {

    public $MedicalPlusName = "Medical Plus Kft.";
    public $rogzito;
    private $date;
    
    function __construct() {

        if (isset($_SESSION['real_name'])){
            
            $this->rogzito = $_SESSION['real_name'];
        
        }else{
            $this->rogzito="Error real name";
        }
        $this->date = date("Y-m-d");
    }
    
    
    /**
     * Visualize_New_Szolgaltats_Form
     * 
     * használaton kívüli egyszrű adatbefiteli form 
     */
    public function Visualize_New_Szolgaltats_Form (){ 
        $kezelo = "nincs kezelo";
        
        if (isset($_GET["kezelo"]))
            {
            $kezelo= test_input($_GET["kezelo"]);
            }
        
        
        $conn = DbConnect();
        // tábla fejrész
        $date = date("y-m-d");
        echo'<div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
            <div class="panel panel-info">
        <div class="panel-heading">Szolgáltatás kezelés igénybevétele : '.$kezelo.'</div>
        <div class="panel-body">';
        echo '<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '">';
                            //beteg neve
                            echo'<div class="form-group">'
                                    . '<label class="col-sm-3 control-label">Paciens neve:</label>'
                                    . '<div class="col-sm-7">'
                                        . '<input type="text" class="form-control" name="paciensneve"  placeholder="Paciens neve" required>'
                                    . '</div>'
                                . '</div>';

                            //orovos kezelő
                            echo'<div class="form-group">'
                                    . '<label class="col-sm-3 control-label">Orovs kezelő:</label>'
                                    . '<div class="col-sm-7">'
                                        . '<select class = "form-control" name = "kezelo" onchange="showSzolgaltatas(this.value)">';
                                 
                            $kezelo_telephely = $_SESSION['set_telephely'];
                            
                            if($kezelo == "orvos"){
                            $sql = "SELECT DISTINCT * FROM `kezelok_orvosok` WHERE kezelo_tipus = 'Orvos' AND kezelo_telephely ='$kezelo_telephely'";
                            }
                            if($kezelo == "terapeuta"){
                            $sql = "SELECT DISTINCT * FROM `kezelok_orvosok` WHERE (kezelo_tipus = 'Masszőr' OR kezelo_tipus = 'Gyógytornász') "
                                    . "AND kezelo_telephely ='$kezelo_telephely'";
                            }
                      
                            $result = $conn->query($sql);
                                    echo '<option value="NULL"> Válasszon  </option>';
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="'.$row[kezelo_neve].'">'.$row[kezelo_neve].'</option>';
                                }
                            } else {
                                echo "0 results";
                            }
                            echo '</select></div></div>';        

                            // szolgáltatás
                            echo'<div class="form-group" >'
                                    . '<label class="col-sm-3 control-label">Szolgáltatás:</label>'
                                    . '<div class="col-sm-7" id="selectSzolg">';
                                    echo'<select class = "form-control" name = "szolg">';
                                    $sql = "SELECT DISTINCT  szolg_neve FROM szolgaltatasok WHERE (szolg_tipus='Orvos' OR szolg_tipus = 'Masszőr' OR szolg_tipus = 'Gyógytorna')";
                                    $result2 = $conn->query($sql);

                                    if ($result2->num_rows > 0) {
                                        while ($row = $result2->fetch_assoc()) {
                                            echo '<option value="'.$row[szolg_neve].'">'.$row[szolg_neve].'</option>';
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
        <div class="panel-footer" id="armutato">'.$kezelo.'</div>
        </div></div>
        <div class="col-sm-4"></div>
        </div>';
            
        
         mysqli_close($conn);
        
        
        
    }
   
    /**
     * user_post_insert_db()
     * 
     * Itt kezelődik a napi elszámolás tábla felültése a POST események lekezelése ellenörzése bérlet létrehozása
     * 
     * 
     */
    public function user_post_insert_db() {

        // adatbázisba  mentés ha létezik  a kötelező 4 adat 
        if (isset($_POST["paciensneve"]) && isset($_POST["kezelo"]) && isset($_POST["szolg"]) && isset($_POST["fizmod"]) 
        && isset($_SESSION['real_name']) && isset($_SESSION['set_telephely'])  && $_POST["UjPacFormId"] == $_SESSION["UjPacFormID"])  {
        if (isset($_POST["UjPacFormId"]) and $_POST["UjPacFormId"] == $_SESSION["UjPacFormID"])  {echo '<br><br><br>id ok';} else {echo '<br><br><br>id error';} 
            
            $conn = DbConnect();
            // adatbázisba írás
            // tárolandó adatok bemeneti ellenörzése
            $pname = "Nincs megadott név";
            $eptipus = "";
            if ($_POST["paciensneve"] != ""){ $pname = $_POST["paciensneve"];}
            
            $kezelo_orvos = $_POST["kezelo"];
            
            $szolgaltatas = $_POST["szolg"];
           
            $fizmod = $_POST["fizmod"];
            
            if (isset($_POST["eptipus"])){$eptipus = $_POST["eptipus"];}
             
            $bevosszeg = $_POST["szolg_ar"];
            
            $jutalek = $_POST["szolg_jutalek"];
            
            $szamlaszam = $_POST["fizszamlaszam"];
            
            $slipsz = "";
            if (isset($_POST["slipsz"])) {$slipsz = $_POST["slipsz"];}
            
            $nyugtasz = "";
            if (isset($_POST["nyugtasz"])) {$nyugtasz = $_POST["nyugtasz"];}
            
            $beteglista_id = "nincs adat";
            if (isset($_POST["beteglista_id"])) {$beteglista_id = $_POST["beteglista_id"];}
            
            $telephely = $_SESSION['set_telephely'];
            $user = $_SESSION['real_name'];
            
            if (isset($_POST["rogzites_date"]) ){
                $date = $_POST["rogzites_date"];   
            }else{
                $date = date("Y-m-d");
            }
            
            if (isset($_POST["aru_AFA"])) { $bevetel_afa = $_POST["aru_AFA"];} else {$bevetel_afa = 0;}
            if (isset($_POST["aru_AFA_kulcs"])) { $bevetel_afakulcs = $_POST["aru_AFA_kulcs"];} else {$bevetel_afakulcs = 0;}
            if (isset($_POST["aru_db"])) { $eladott_aru_db = $_POST["aru_db"];} else {$eladott_aru_dbb = 0;}
           
            if (isset($_POST["allinformreceptid"])) { $recept_id = $_POST["allinformreceptid"];} else {$recept_id = NULL;}
            if (isset($_POST["allinformnote"])) { $note = $_POST["allinformnote"];} else {$note = NULL;}
            if (isset($_POST["recept_artam"])) { $recept_artam = $_POST["recept_artam"];} else {$recept_artam = '';}
            $sell_type = $_POST["sell_type"];
                                
            //$szolgaltatas tartalmazza a bérlet 10 vagy bérlet 5
            if (stripos($szolgaltatas, "bérlet") == TRUE){
                
                    if (stripos($szolgaltatas, "bérlet 5") == TRUE){ //5 alkalmas bérlet
                    $berlet_alkalom = 5;
                    $lejarat_date = $this->dateadd($berlet_alkalom);
                    $berlet = new BerletClass();    
                    $berlet->Create_Berlet($pname,$kezelo_orvos,$berlet_alkalom,$szolgaltatas,$telephely,$lejarat_date,$bevosszeg);    
                    
                    $szolgaltatas .= ' Eladás';
                   
                    }
                    
                    if (stripos($szolgaltatas, "bérlet 10") == TRUE ){ //10 alkalmas bérlet
                    $berlet_alkalom = 10;
                    $lejarat_date = $this->dateadd($berlet_alkalom);
                    $berlet = new BerletClass();    
                    $berlet->Create_Berlet($pname,$kezelo_orvos,$berlet_alkalom,$szolgaltatas,$telephely,$lejarat_date,$bevosszeg);    
                    
                    $szolgaltatas .= ' Eladás';
                    }
                    
                    if (stripos($szolgaltatas, "bérlet 3 alk") == TRUE ){ //3 alkalmas bérlet
                    $berlet_alkalom = 3;
                    $lejarat_date = $this->dateadd($berlet_alkalom);
                    $berlet = new BerletClass();    
                    $berlet->Create_Berlet($pname,$kezelo_orvos,$berlet_alkalom,$szolgaltatas,$telephely,$lejarat_date,$bevosszeg);    
                    
                    $szolgaltatas .= ' Eladás';
                    }
                    
                    if (stripos($szolgaltatas, "bérlet 8 alk") == TRUE ){ //8 alkalmas bérlet
                    $berlet_alkalom = 8;
                    $lejarat_date = $this->dateadd($berlet_alkalom);
                    $berlet = new BerletClass();    
                    $berlet->Create_Berlet($pname,$kezelo_orvos,$berlet_alkalom,$szolgaltatas,$telephely,$lejarat_date,$bevosszeg);    
                    
                    $szolgaltatas .= ' Eladás';
                    }
                    
                    if (stripos($szolgaltatas, "bérlet 20 alk") == TRUE ){ //20 alkalmas bérlet
                    $berlet_alkalom = 20;
                    $lejarat_date = $this->dateadd($berlet_alkalom);
                    $berlet = new BerletClass();    
                    $berlet->Create_Berlet($pname,$kezelo_orvos,$berlet_alkalom,$szolgaltatas,$telephely,$lejarat_date,$bevosszeg);    
                    
                    $szolgaltatas .= ' Eladás';
                    }
                    
                    if (stripos($szolgaltatas, "bérlet 30 alk") == TRUE ){ //30 alkalmas bérlet
                    $berlet_alkalom = 30;
                    $lejarat_date = $this->dateadd($berlet_alkalom);
                    $berlet = new BerletClass();    
                    $berlet->Create_Berlet($pname,$kezelo_orvos,$berlet_alkalom,$szolgaltatas,$telephely,$lejarat_date,$bevosszeg);    
                    
                    $szolgaltatas .= ' Eladás';
                    }
                            
            }
            else{
                $berlet_alkalom = NULL;
            }
                       
            // adat ellenörzés és tárolás kell legyen fizetési mód és szolgáltatás

            if ($fizmod != "" AND $szolgaltatas != "" AND $kezelo_orvos != "" AND $pname != "" ) {
                    
                     // ha minden szűkséges adat megvan akkor ment db be
                    $sql = "INSERT INTO napi_elszamolas (paciens_neve , kezelo_orvos_id, szolgaltatas_id
                    ,bevetel_tipusa_id,ep_tipus, bevetel_osszeg,jutalek_osszeg, szamlaszam, berlet_adatok, rogzito, telephely, date,slipsz,nyugtasz,el_beteglista_id,bevetel_afa,bevetel_afakulcs,recept_id,note,recept_artam,sell_type)
                    VALUES ('$pname','$kezelo_orvos','$szolgaltatas','$fizmod','$eptipus','$bevosszeg','$jutalek','$szamlaszam','$berlet_alkalom','$user','$telephely','$date','$slipsz','$nyugtasz','$beteglista_id','$bevetel_afa','$bevetel_afakulcs','$recept_id','$note','$recept_artam','$sell_type')";

                    if (mysqli_query($conn, $sql)) {
                        // echo "New record created successfully";
                        $_SESSION["UjPacFormID"]= '';
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    
                    $this->elojezses_azonositas($beteglista_id);
                    
             } else {
               // hibakezelés

                 echo '<div class="alert alert-warning alert-dismissable fade in">
                       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Hiba! </strong> Nincs ilyen  kombináció <b>'.$kezelo_orvos.'</b> és <b>'.$szolgaltatas.'</b> a redszerben ! Nincs ilyen szolgáltatás.
                   </div>';
                
                
             }
            
        // készlet eladás esetén készlet db csökkentése 
        if (isset($_POST["CikkId"]) AND $_POST["CikkId"] != "null"  ) {
            
            $ktelephely = "";
            
            if ( $telephely == "BMM" OR $telephely == "Fizio" OR $telephely == "Lábcentrum" ) {$ktelephely = "BMM";}
            if ( $telephely == "P70" OR $telephely == "P72") {$ktelephely = "P70";}
            //if ( $telephely == "Lábcentrum" ) {$ktelephely = "Lábcentrum";}
            if ( $telephely == "Óbuda" ) {$ktelephely = "Obuda";}
            
            $cikkid =  $_POST["CikkId"];
            // keszlet db csökkentés
            $sql = "SELECT * FROM aru_keszlet WHERE keszlet_aru_id = '$cikkid'  AND keszlet_raktar = '$ktelephely' ORDER BY keszlet_id DESC LIMIT 1";
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                             $keszlet_db = $row["keszlet_db"] - $eladott_aru_db ;
                             $keszlet_raktar = $row["keszlet_raktar"];
                             
                             // készlet ellenörzés $keszlet_db >= "-10000"
                             if (true){
                             // ha select ok insert csökkentett készlet db
                             $sql = "INSERT INTO aru_keszlet (keszlet_aru_id, keszlet_db, keszlet_raktar, keszlet_log) VALUES ('$cikkid', '$keszlet_db', '$keszlet_raktar','Eladás: $user / $szamlaszam')";

                                if ($conn->query($sql) === TRUE) {
                                    echo " Keszelt csökkentes OK";
                                } else {
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }
                             } else {
                                 echo " Keszlet db < 0!";
                             }                        
                        }
                    } else {
                        echo "Err: készlet csökkentés";
                    }   
            // beszerzés hez elsadás tárolás FIFO cikk id legrégebbi bezsezése
                    
                $sql2 = "SELECT * FROM aru_beszerzes WHERE besz_aru_id = '$cikkid'  ORDER BY besz_id ASC";
                    
                $result2 = $conn->query($sql2);
                 if ($result2->num_rows > 0) {
                        // output data of each row
                        while($row2 = $result2->fetch_assoc()) {
                             
                            if ($row2["besz_eladva_db"] < $row2["besz_db"]){
                                
                                $eladva_db  = $row2["besz_eladva_db"] + $eladott_aru_db;
                                $besz_id = $row2["besz_id"];
                                
                                //eladás rözítése beszerzés táblában 
                                $sql3 = "UPDATE aru_beszerzes SET besz_eladva_db = '$eladva_db' WHERE besz_id = '$besz_id'";

                                if ($conn->query($sql3) === TRUE) {
                                    echo " Beszerzés FIFO eladás OK";
                                } else {
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }
                                break;
                                
                            }else{}
                        }
               } else {
               echo "Err: beszerzes FIFO tétel eladás";
               }       
                
        }    
             
             
            mysqli_close($conn);
        }
    }
   
    
    private function dateadd($mounth){
        
       $intervalstr ="" ;
       
       switch ($mounth) {
        case "3":
            $intervalstr = 'P1M';
            break;
        case "8":
            $intervalstr = 'P3M';
            break;
        case "20":
            $intervalstr = 'P6M';
            break;
        case "30":
            $intervalstr = 'P12M';
            break;
        case "5":
            $intervalstr = 'P3M';
            break;
        case "10":
            $intervalstr = 'P6M';
            break;
        default:
             $intervalstr = 'P12M';
        }
        
       $date = new DateTime($this->date);
       $interval = new DateInterval($intervalstr); 
       $date->add($interval);
       
       return $date->format('Y-m-d');
        
    }
            
    
    // előjegyzés azonosítása a napi bevételek között és visszaírása az előjegyzési táblába
    /*
    *Előjegyzési lista visszaírása kezelés rögzítése után
    *
    */    
    public function elojezses_azonositas($el_id) {
        
        $conn = DbConnect();
        $sql = "SELECT id_szamla FROM napi_elszamolas where el_beteglista_id = '$el_id'";
        $result = $conn->query($sql);
        $szamla_id = 0;
        
        if ($result->num_rows == 1) {
        // output data of each row
            while ($row = $result->fetch_assoc()) {
            $szamla_id = $row["id_szamla"];
            }
       
        $sql = "UPDATE napi_beteglista SET napi_elsz_id='$szamla_id' WHERE beteglista_id = '$el_id'";

            if ($conn->query($sql) === TRUE) {
                //echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }

            
        }  
        mysqli_close($conn);
    }
    /**
     * user_select_delete_dbrow
     * 
     * Felhasználó kiválasztja a napi elszámolósból törölhető adatokat 
     */
    public function user_select_delete_dbrow() {
        $conn = DbConnect();
        $date = date("y-m-d");
        
        echo'<div class="container">';
        echo'<h2>Páciens törlése</h2>';
        echo'<form action="'. $_SERVER['PHP_SELF'].'?pid=page12" method="post">';  
        echo'<table class="table table-hover">
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
                        <th>Törlésre kijelöl</th>
                    </tr>
                </thead>
                <tbody>';
        $telephely = $_SESSION['set_telephely'];
        $date = date("Y-m-d");
       
        // az aktuális napi bevételek lekérdezése
 
        $sql = "SELECT * FROM napi_elszamolas where telephely = '$telephely' AND "
                . "date = '$date' AND torolt_szamla = '0' AND rogzito ='$this->rogzito'  AND lezart_szamla ='0' ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row

            while ($row = $result->fetch_assoc()) {
                
                            
             echo '<tr><td>'.$row["paciens_neve"] . '</td>'
                . '<td>'.$row["kezelo_orvos_id"] . '</td>'
                . '<td>'.$row["szolgaltatas_id"] . '</td>'
                . '<td>'.$row["bevetel_tipusa_id"] . '</td>'
                . '<td>'.$row["ep_tipus"] . '</td>'
                . '<td>'.$row["bevetel_osszeg"] . '</td>'
                . '<td>'.$row["jutalek_osszeg"] . '</td>'
                . '<td>'.$row["berlet_adatok"] . '</td>'
                . '<td>'.$row["szamlaszam"] . '</td>'
                . '<td><input type="radio" name="deleteid" value="'.$row["id_szamla"].'"></td></tr>';
            }
        } else {
            echo "0 results";
        }
        echo '<tr>
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        <td><button type = "submit" value = "Submit" type = "button" class = "btn btn-danger">Töröl</button></td></tr>';
        echo '</tbody></table></form></div>';

        mysqli_close($conn);
    }
    /**
     * user_post_delete_db_row(
     * 
     * felhasznló töröltnek jelöli a számlát post lekezelése
     */
 
    public function user_post_delete_db_row() {
        if (isset($_POST['deleteid'])) {
            $deleteid = $_POST['deleteid'];


            $conn = DbConnect();

            $sql = "UPDATE napi_elszamolas SET torolt_szamla=1 WHERE id_szamla='$deleteid'";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

    /**
     * atadás
     * 
     * átadás napi zárás form 
     */
    function atadas() {// átadás form 
        $conn = DbConnect();
        $date = date("y-m-d");
              
        echo '<div class="panel panel-danger">';
            echo'<div class="panel-heading">Rendelő: ' . $_SESSION['set_telephely'] . ' / ' . $date . ' Napon belüli átadás</div>';
            echo '<div class="panel-body">';
                echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post" >'; 
                
                //átadó az aktuális kezelő
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Átadó:</label>
                        <div class="col-sm-7"><input type="text" class="form-control" id="atado" value="'.$this->rogzito.'" disabled></div>
                     </div>';
                //átvevő kiválasztható
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Átvevő:</label>
                        <div class="col-sm-7">';
                         echo'<select class = "form-control" name = "atvevo">';
                           
                            $sql = "SELECT real_name FROM users WHERE email <> '$rogzito' and tipus = 'user' ";
                            $result = $conn->query($sql);
                            //echo $result;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row[real_name] . '">' . $row[real_name] . '</option>';
                                }
                            } else {
                                echo "0 results";
                            }
                                    echo '<option value="napi záro">NAP VÉGÉN ZÁROK</option>';
                            echo '</select>
                        </div>
                     </div>';
                //gombok
                echo '<div class="form-group">';
                    echo '<label class="col-sm-3 control-label"></label>';    
                    echo'<div class="btn-group">';
                       // echo'<a href="#"onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
                        echo '<button type="submit" class="btn btn-danger">Átadás</button>'
                    . '</div>'
                . '</div>';        
                echo '</form>';
            
            echo'</div>';
            echo'<div class="panel-footer">
                <strong>Figyelem! </strong>Ellenőrzés -> Átadás!
                </div></div>';
                
        mysqli_close($conn);
    }
    /**
    *user átadástst post
    * felhasználók közötti átadási finkciók itt vannak POST lekezelés
    */
    function user_post_atadas() {
        // átadás zárolja a napi bevételi számlakat a kiválasztott telephelyen az adoot napon
        // nap végi zárás minden rekord záolódik
        if (isset($_POST['atvevo'])) {
            $conn = DbConnect();
            $telephely = $_SESSION['set_telephely'];
          
            $date = date("Y-m-d");
            $atvevo_neve = $_POST['atvevo'];
            //
            if ($atvevo_neve == 'Napi zaras') {
                  //minden nyitott nyai számlát lezár  
                $sql = "UPDATE napi_elszamolas SET lezart_szamla = '1' atvevo_neve = '$atvevo_neve' WHERE telephely = '$telephely' AND "
                        . "date = '$date' AND torolt_szamla = '0'";
            } else {

                // $sql = "UPDATE napi_elszamolas SET torolt_szamla=1  WHERE id_szamla='$deleteid'";
                $sql = "UPDATE napi_elszamolas SET lezart_szamla = 1 , atvevo_neve = '$atvevo_neve' WHERE telephely = '$telephely' AND "
                        . "date = '$date' AND torolt_szamla = '0' AND rogzito ='$this->rogzito'  AND lezart_szamla ='0' ";
            }

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }
    
// napi zárás form egyenlőre nincs használatban
    function napi_zaras() {   //napi zárás form 
        $conn = DbConnect();
        $date = date("y-m-d");
              
        echo '<div class="panel panel-danger">';
            echo'<div class="panel-heading">Rendelő: ' . $_SESSION['set_telephely'] . ' / ' . $date . ' Nap végi elszámilás zárás</div>';
            echo '<div class="panel-body">';
                echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post" >'; 
                
                //átadó az aktuális kezelő
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Átadó:</label>
                        <div class="col-sm-7"><input type="text" class="form-control" value="'.$this->rogzito.'" disabled></div>
                     </div>';
                //átvevő kiválasztható
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Átvevő:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control"  name = "atvevo" value="Napi zaras" disabled>
                        </div>
                     </div>';
                //gombok
                echo '<div class="form-group">';
                    echo '<label class="col-sm-3 control-label"></label>';    
                    echo'<div class="btn-group">';
                        echo'<button type="submit" class="btn btn-danger">Napi zárás</button>';
                        echo '<a href="#" class="btn btn-info" role="button">Nap zárás nyomtatható váltotztban</a>'
                    . '</div>'
                . '</div>';        
                echo '</form>';
            
            echo'</div>';
            echo'<div class="panel-footer">
                <strong>Figelem! </strong>Ellenörzés -> Nyomatás -> Átadás!
                </div></div>';
   
        mysqli_close($conn);
    }
 /**
  * Visualize_New_Allin_Szolgaltatas_Form
  * 
  * Fő adatbe form uj paciensek rögzítése használatban van
  * 
  */
    public function Visualize_New_Allin_Szolgaltatas_Form($tipe){
        
        $conn = DbConnect();
        //js paraméter formátum
        $telephely = "'". $_SESSION['set_telephely']."'";
        $rogzito = "'".$this->rogzito."'";
        $sql ="SELECT DISTINCT * FROM `kezelok_orvosok` WHERE kezelo_tipus = 'orvos' AND kezelo_telephely ='$telephely' ORDER BY kezelo_neve ASC";
        
        //egyedi form id 
        $Unique_formid = $this->GenerateUniqueID();
        $_SESSION['UjPacFormID']= $Unique_formid;
        
        echo '<div class="row">';
            echo '<div class="col-sm-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3>Előjegyzés a mai pácienslistára</h3>
                            <div class="form-group form-inline">
                                <table class="table-condensed">
                                    <thead>
                                        <tr style="border-bottom: 1px solid;"> 
                                            <th>Páciens neve</th>
                                            <th>Kezelő / Orvos</th>
                                            <th>Előjegyzés felvétele táblára</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <td><input type="text" class="form-control" id="paciensneve_el" placeholder="Beteg Béla" required onkeyup="getpaciensnev(this.value)"></td>
                                        <td><input type="text" class="form-control" id="allinformkezeloneve_el" placeholder="Dr. Bubo Bubo" name = "kezelo"  readonly></td>
                                        <td><button type="button" class="btn btn-success"onclick="paciens_elorogzites('.$rogzito.')">Előjegyzem a mai napra</button></td>
                                     
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <div class="panel-body">';
                    echo '<div class="row">';
                        echo '<div class="col-sm-2">';
                            echo '<div class="form-group">
                                <label >Szolgáltatás:</label>
                                    <div class="radio">
                                        <label><input type="radio" name="form_szolgaltatas" value="orvos" onclick="kezelo('.$telephely.',this.value)" >Orvoshoz</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="form_szolgaltatas" value ="kezelo" onclick="kezelo('.$telephely.',this.value)" >Kezelőhöz</label>
                                    </div>
                                    <div class="radio">
                                    <label ><input type="radio" name="form_szolgaltatas" value ="kezelo" onclick="berletes_paciens()" >Érvényes Bérlettel</label>
                                    </div>
                                    <div class="radio ">
                                        <label><input type="radio" name="form_szolgaltatas" value ="segedeszköz" onclick="keszlet_kategoriak('.$telephely.')">Segédeszköz eladás</label>
                                    </div>
                                </div>
                                </div>';
                            echo '<div class="col-sm-2">
                                    <div class="form-group" id="selectkezelo">
                                        <label >Orvosok - kezelők:</label>';
        
                            echo   '</div>
                                </div>';  

                            echo '<div class="col-sm-5">
                                 <div class="form-group" id="selectszolgaltatas">
                                    <label >Szolgáltatások árak:</label>';
    
                            echo   '</div>
                                </div>';    
                                
                            echo '<div class="col-sm-3">
                                <div class="form-group" id="selectfizmod">
                                <label >Fizetési módok:</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="radio" style="display:none;">
                                                <label><input type="radio"  name="fizmod" value="kp-nyugta" onclick="fizetes_modja(this.value)">Készpénz nyugtával</label>
                                            </div><br>
                                            <div class="radio">
                                                <label><input type="radio" name="fizmod" value ="kp-számla" onclick="fizetes_modja(this.value)">Készpénz számlával</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="fizmod" value ="kp-partner" onclick="fizetes_modja(this.value)">Készpénz partner</label>
                                            </div>
                                            <div class="radio" style="display:none;">
                                            <label><input type="radio" name="fizmod" value="bankkártya-nyugta" onclick="fizetes_modja(this.value)" >Bankkártya nyugtával</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="fizmod" value="bankkártya-számla" onclick="fizetes_modja(this.value)" >Bankkártya számlával</label>
                                            </div>
                                            <div class="radio" style="display:none;">
                                                <label><input type="radio" name="fizmod" value="szamlazz.hu-átutalás" onclick="fizetes_modja(this.value)" >Szamlazz.hu</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="fizmod" value="ajándék" onclick="fizetes_modja(this.value)" >Ajándék</label>
                                            </div>
                                            
                                        </div>
                                        <div class ="col-sm-6"><br>
                                            <div class="radio">
                                                <!--<label><input type="radio" name="fizmod"  value ="egészségpénztár-számla" onclick="fizetes_modja(this.value)">EP számlával</label>-->
                                            </div>
                                            <div class="radio">
                                            <label><input type="radio" name="fizmod"  value ="egészségpénztár-kártya" onclick="fizetes_modja(this.value)">EP kártyával</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="fizmod"  value ="europe assistance" onclick="fizetes_modja(this.value)">Europe Assistance</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="fizmod"  value ="TELADOC" onclick="fizetes_modja(this.value)">TELADOC</label>
                                            </div>
                                             <div class="radio">
                                                <label><input type="radio" name="fizmod"  value ="Union-Érted" onclick="fizetes_modja(this.value)">Union-Érted</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="fizmod"  value ="átutalás" onclick="fizetes_modja(this.value)">Átutalás</label>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>';       
                    echo'</div>';
                echo '</div>
            <div class="panel-footer" id="napielszform">
            <h3>Páciens kezelésének rögzítése</h3>
                <form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page26">';            
                if ($tipe == "potrogzites"){
                echo '<input type="date" class="form-control" name="rogzites_date" style="width:250px;">';
                }
                echo '<table class="table">
                        <thead>
                            <tr>
                                <th>Páciens neve</th>
                                <th>Kezelő / Orvos</th>
                                <th>Szolgáltatás típusa</th>
                                <th>Szolgáltatás ára Ft</th>
                                <th>Jutaléka Ft</th>
                                <th>Fizetési mód</th>
                                <th>EP Típus</th>
                                <th>Számlaszám</th>
                                <th>Bankkártya Slip</th>
                                <th>Pénztárgép Slip</th>
                                <th>Vény</th>
                                <th>Note</th>
                                <th>Rögzítem</th>                  
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" class="form-control" id="allinformpaciensneve" placeholder="Beteg Béla" name="paciensneve" required></td>
                            <td><input type="text" class="form-control" id="allinformkezeloneve" placeholder="Dr. Bubo Bubo" name = "kezelo"  readonly></td>
                            <td><input type="text" class="form-control" id="allinformszolgaltatas" placeholder="Szolgáltatás" name = "szolg"  readonly></td>
                            <td><input type="number" class="form-control" id="allinformszolgaltatasar" placeholder="Szolgáltatás" name = "szolg_ar"  readonly></td>
                            <td><input type="number" class="form-control" id="allinformszolgaltatasjutalek" placeholder="Szolgáltatás" name = "szolg_jutalek"  readonly></td>
                            <td><input type="text" class="form-control" id="allinformszolgaltatasfizmod" placeholder="Fizetés módja" name = "fizmod"   readonly required ></td>
                            <td>';
                
                            echo'<select class = "form-control" name = "eptipus" id="allinformepvalasztas" disabled>';
                            $sql = "SELECT * FROM `ep_lista`";
                            $result1 = $conn->query($sql);
                            echo '<option></option>';
                                if ($result1->num_rows > 0) {
                                    while ($row = $result1->fetch_assoc()) {
                                        echo '<option value="' . $row["ep_neve"] . '">' . $row["ep_neve"] . '</option>';
                                    }
                                } else {
                                    echo "0 results";
                                }
                                echo'</select>';
                
                            echo '</td>';
                            echo'<td><input type="text" class="form-control" id="allinformszolgaltatasszamalaszam" placeholder="Számla szám" name = "fizszamlaszam"  readonly></td>
                            <td><input type="text" class="form-control" id="allinformszolgaltatasslipszam" placeholder="Slip szám" name = "slipsz"  readonly></td>
                            <td><input type="text" class="form-control" id="allinformszolgaltatasnyugtaszam" placeholder="Nyugta szám" name = "nyugtasz"  readonly></td>
                            <td>            
                                <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#veny"><i class="fa fa-th-list" aria-hidden="true"></i></button>
                                    <div id="veny" class="collapse">
                                      <div class="form-group">
                                        <label for="recept_id">Recept azonosító:</label>
                                        <input type="text" class="form-control" id="recept_id" name="allinformreceptid" placeholder="123456789">
                                      </div>
                                    </div>
                            </td>
                            <td>            
                                <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#textarea"><i class="fa fa-commenting" aria-hidden="true"></i></button>
                                    <div id="textarea" class="collapse">
                                      <div class="form-group">
                                        <label for="megjegyzes">Megjegyzés:</label>
                                         <textarea class="form-control" rows="5" id="note" name="allinformnote"  placeholder="megjegyzés az adott rögzítéshez / AUTORIZÁCIÓS KÓD"></textarea>
                                      </div>
                                    </div>
                            </td>
                            <td><button id="allinfomrOK" type="submit" class="btn btn-danger" onclick="checkform()">Rendben</button></td>
                        </tr>
                        </tbody>
                    </table>
                    <input type="hidden" class="form-control" id="allinformbeteglista_id" name = "beteglista_id" readonly >
                    <input type="hidden" class="form-control" id="allinformUnique_id" name = "UjPacFormId" readonly value="'.$Unique_formid.'" >
                    <input type="hidden" class="form-control" id="allinformCikk_id" name = "CikkId" readonly value="null" >    
                    <input type="hidden" class="form-control" id="allinformaru_AFA" name = "aru_AFA" readonly value="0" >    
                    <input type="hidden" class="form-control" id="allinformaru_afakulcs" name = "aru_AFA_kulcs" readonly value="0" >    
                    <input type="hidden" class="form-control" id="allinformaru_eladasdb" name = "aru_db" readonly value="0" >   
                    <input type="hidden" class="form-control" id="allinformaru_artam" name = "recept_artam" value="0" readonly>   
                    <input type="hidden" class="form-control" id="allinformaru_sell_type" name = "sell_type" value="szolgaltatas" readonly>   
                </form>                 
            </div>
            </div>';



            echo '</div>';
        echo '</div>';

        mysqli_close($conn);
    }
/**
 * VisualizeNapiElőjegyzésTable()
 * 
 *napi redelésre előjegyzett páciensek megjelenítése táblázatban az uj páciens rögzítése form alatt innen 
 *innen kerülhetnek a páciensek rözítésre a rendelések után
 * 
 * Használatban
 */
    
    public function VisualizeNapiElőjegyzésTable($telephely){
    
    $conn = DbConnect();    
    $telehely_el = $telephely;
   
    $date_el = date("y-m-d");
 
    $sql = "SELECT * FROM napi_beteglista WHERE telephely = '$telehely_el' AND  date_el = '$date_el' AND torolt_beteg = '0' ";
 
    $result = $conn->query($sql);
   
    echo '<div class="container" >
        <h2>Mai napra előjegyzett páciensek listája</h2>';
        echo'
        <table class="table table-hover">
        <thead>
            <tr>
                <th>No.:</th>
                <th>Páciens</th>
                <th>Orvos / Kezelő</th>
                <th>Rögzítem</th>
                <th>Törlöm</th>
            </tr>
        </thead><tbody>';
            if ($result->num_rows > 0) {    
                while ($row = $result->fetch_assoc()) {
                    
                    $beteglista_id = "'".$row["beteglista_id"]."'";    
                    $beteg_neve = "'".$row["beteg_neve"]."'";    
                    $kezelo_neve = "'".$row["kezelo_neve"]."'";    
                    $rogzitett = 'class=""';
                    if ($row["rogzitett_beteg"] == 1 ){ $rogzitett= 'class="warning"';}// lörögzítésről -> rögzítése folyamatban
                 
                    if ($row["napi_elsz_id"] != 0){ $rogzitett= 'class="success"';}// berögzített páciens
                   
                
                    echo "<tr $rogzitett ><td>"
                    . $row["beteglista_id"] . "</td><td> "
                    . $row["beteg_neve"] . "</td><td>"
                    . $row["kezelo_neve"] . "</td><td>"
                    . '<button type="button" onclick="el_beteg_rogzitesre('.$beteg_neve.',' .$kezelo_neve.','.$beteglista_id.')"><i class="fa fa-check-circle"></i></button></td><td>'
                    . '<button type="button" onclick="el_beteg_torlesre('.$beteglista_id.')"><i class="fa fa-trash"></i></button></td></tr>';
           
                }
            } else {
        echo "<tr><td>Nincs rögzített adat!</td></tr>";
        }
        echo "</tbody></table>";
    echo '</div>';
    mysqli_close($conn);
}   

// egyedi form id generálása
private function GenerateUniqueID(){
    $id = "";
    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 10; $i++) {
        $randstring .= $characters[rand(0, strlen($characters)-1)];
    }
    
    
    $id = time().'-'.$randstring;
    
    return $id;
}
}

?>