<?PHP

class User_Select_NapiOsszesito {

    public $MedicalPlusName;
    public $rogzito;
    public $telephely;
    public $date;
    public $kp_padtner;
    public $kp_kivet_osszeg;
    public $kp_kivevo_kezelo;
    public $conn;
    public $printdate;

    function __construct() {

        if (isset($_SESSION['real_name'])) {

            $this->rogzito = $_SESSION['real_name'];
        } else {
            $this->rogzito = "Error rogzito name";
        }

        if (isset($_SESSION['set_telephely'])) {

            $this->telephely = $_SESSION['set_telephely'];
        } else {
            $this->telephely = "Error telephely";
        }

        $this->date = date("Y-m-d");
        $this->printdate = date("Y-m-d H:i");
        $this->kp_kivet_osszeg = 0;
        $this->kp_kivevo_kezelo = '';
        $this->kp_padtner = 'FALSE';
        $this->MedicalPlusName = 'Medical Plus Kft.';
        $this->conn = DbConnect();
    }

    function __destruct() {
        mysqli_close($this->conn);
    }
    
    function __set_Date($date){
        
        $this->date = $date;
    }
    
    function __set_Telephely($telephely){
        
        $this->telephely = $telephely;
    }
        
    
    
    public function user_select_napi_all_bevetelektipusok() {
        $recepciosokKpBevetel = 0;
        $recepciosokKpKivet = 0;
       // $conn = DbConnect();
       // $date = date("y-m-d");
        $summbevetel = 0;
        $summdb = 0;
        $html = "";


        // táblázat visszaolvasása
        $html .= '<div class="container">';
        $html .= $this->Check_Napi_PaciensLista();
        $html .= '<div id="HiddenIfPrint" "><a href="#"onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a></div>';
        $html .='<h1>Összesített napi adatok az összes kezelőnél:</h1><p>Rendelő:' . $this->telephely . ' / ' . $this->printdate . '</p>';
        $html .= '<table class="table">
                <thead>
                    <tr>
                        <th>Bevétel típusok</th>
                        <th>Összeg(HUF)</th>
                        <th>Darabszám</th>
                    </tr>
                </thead>';
        // az aktuális napi bevételek lekérdezése

        $html .='<tr>';
        // készpénz adatok összesítése    
        $html .= '<td>Készpénz (számla + nyugat)</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND ( bevetel_tipusa_id = 'kp-nyugta' OR bevetel_tipusa_id = 'kp-számla' )";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
                $recepciosokKpBevetel += $row1["sum_kp_bevetel"];
                $summbevetel += $row1["sum_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND ( bevetel_tipusa_id = 'kp-nyugta' OR bevetel_tipusa_id = 'kp-számla' )";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
                $summdb += $row1["db_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }

        $html .= '</tr>';
        $html .= '<tr>';
        // Bankkártya forgalomi  adatok összesítése    
        $html .= '<td>Bankkártya (számla + nyugat)</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND ( bevetel_tipusa_id = 'bankkártya-nyugta' OR bevetel_tipusa_id = 'bankkártya-számla' )";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
                $summbevetel += $row1["sum_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0'"
                . "AND ( bevetel_tipusa_id = 'bankkártya-nyugta' OR bevetel_tipusa_id = 'bankkártya-számla' )";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
                $summdb +=  $row1["db_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        $html .= '</tr>';
        $html .= '<tr>';
        //Egészségpénztári forgalomi  adatok összesítése    
        $html .= '<td>Egészségpénztár (számla + kártya)</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id  LIKE '%egészségpénztár%'";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
                $summbevetel += $row1["sum_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id LIKE '%egészségpénztár%'";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
                $summdb += $row1["db_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        $html .= '</tr>';
        $html .= '<tr>';
        //EuropeAssistance forgalomi  adatok összesítése    
        $html .= '<td>Europe Assistance</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id = 'europe assistance'";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
                $summbevetel += $row1["sum_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0'  "
                . "AND  bevetel_tipusa_id = 'europe assistance'";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
                $summdb += $row1["db_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        $html .= '</tr>';
        $html .= '<tr>';
        //TELADOC forgalomi  adatok összesítése    
        $html .= '<td>TELADOC</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0'  "
                . "AND  (bevetel_tipusa_id = 'TELADOC' OR bevetel_tipusa_id = 'advance medical') ";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
                $summbevetel += $row1["sum_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0'  "
                . "AND  (bevetel_tipusa_id = 'TELADOC' OR bevetel_tipusa_id = 'advance medical')";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
                $summdb += $row1["db_kp_bevetel"];
                             }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        $html .= '</tr>';

        $html .= '<tr>';
        // union érted biztosító
         $html .= '<tr>';
        //Union érted forgalomi  adatok összesítése    
        $html .= '<td>Union-Érted</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0'  "
                . "AND  bevetel_tipusa_id = 'Union-Érted'";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
                 $summbevetel += $row1["sum_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0'  "
                . "AND  bevetel_tipusa_id = 'Union-Érted'";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
                $summdb += $row1["db_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        $html .= '</tr>';

//        //------------Szamalazz.hu
//         $html .= '<tr>';
//       
//        $html .= '<td>Szamlazz.hu</td>';
//        // ósszesített összegek
//        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
//                . "date = '$this->date' AND torolt_szamla = '0'  "
//                . "AND  bevetel_tipusa_id LIKE '%Szamlazz.hu%'";
//
//        $result = $this->conn->query($sql1);
//        if ($result->num_rows > 0) {
//
//            while ($row1 = $result->fetch_assoc()) {
//                $html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
//                 $summbevetel += $row1["sum_kp_bevetel"];
//            }
//        } else {
//            $html .= "<td>Nincs rögzített adat</td>";
//        }
//        // összesített darabszám
//        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
//                . "date = '$this->date' AND torolt_szamla = '0'  "
//                . "AND  bevetel_tipusa_id  LIKE '%Szamlazz.hu%'";
//
//        $result = $this->conn->query($sql1);
//        if ($result->num_rows > 0) {
//
//            while ($row1 = $result->fetch_assoc()) {
//                $html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
//                $summdb += $row1["db_kp_bevetel"];
//            }
//        } else {
//            $html .= "<td>Nincs rögzített adat</td>";
//        }
//        $html .= '</tr>';
        
        
        $html .= '<tr>';
        
        //átutalás forgami adaton forgalomi  adatok összesítése    
        $html .= '<td>Átutalás</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id = 'átutalás'";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
                $summbevetel += $row1["sum_kp_bevetel"] ;
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' AND "
                . "bevetel_tipusa_id = 'átutalás'";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
                $summdb += $row1["db_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        $html .= '</tr>';

        $html .= '<tr>';
        //ajándék forgami adatok összesítése    
        $html .= '<td>Ajándék</td>';

        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id = 'ajándék'";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
                $summbevetel += $row1["sum_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id = 'ajándék'";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
                $summdb +=$row1["db_kp_bevetel"];
                        
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        $html .= '</tr>';


       


        $html .='<tr>';
        // készpénz adatok összesítése    
        $html .= '<td>Készpénz partner</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND bevetel_tipusa_id = 'kp-partner'";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
                $recepciosokKpBevetel += $row1["sum_kp_bevetel"];
                $summbevetel +=  $row1["sum_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id = 'kp-partner'";

        $result = $this->conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
                $summdb += $row1["db_kp_bevetel"];
            }
        } else {
            $html .= "<td>Nincs rögzített adat</td>";
        }

        $html .= '</tr>';

        $html .= '<tr><th>Napi összes bevétel</th><th>'.$summbevetel.' FT</th><th>'.$summdb.' DB </th><tr>';

         // készpénz kivét összesítve napi szinten minden recepcióstól  
        $sql2 = "SELECT sum(kivet_osszeg) as sum_kivet FROM kp_kivet where kivet_telephely = '$this->telephely' AND kivet_torolve = '0' AND kivet_datum = '$this->date'";

        $result2 = $this->conn->query($sql2);

        if ($result2->num_rows == 1) {
            while ($row1 = $result2->fetch_assoc()) {
                $recepciosokKpKivet = $row1["sum_kivet"];
            }
        } else {
            $recepciosokKpKivet = 0;
        }

        $kpEgyenleg = $recepciosokKpBevetel - $recepciosokKpKivet;

        $html .= '<tr class=""><td>Készpénz forgalom (kp bevétel - kp kiadás)</td><td>' . $recepciosokKpBevetel . ' - ' . $recepciosokKpKivet . ' = ' . $kpEgyenleg . ' </td><td></td></tr>';
        $html .= "</tbody></table></div>";

        return ($html);
        //mysqli_close($conn);
    }

    //teljes napi pácienslista

    public function user_select_napi_all_table() {
        $conn = DbConnect();
        $this->date = date("y-m-d");

        // táblázat visszaolvasása
        $html .= '<div class="container">';
        echo'<h1> Napi összes páciens  az összes kezelőnél:</h1>';
        echo'<p>Rendelő: ' . $_SESSION['set_telephely'] . ' / ' . $date . '</p>';

        echo '<table class="table table-striped">
                <thead>
                    <tr>
                        <th>Páciens Neve</th>
                        <th>Kezelő / Orvos</th>
                        <th>Szolgáltatás típusa</th>
                        <th>Fizetés módja</th>
                        <th>EP lista</th>
                        <th>Fizetés Összege</th>
                        <th>Jutalék</th>
                        <th>Bérlet</th>
                        <th>Számlaszám</th>
                        <th>Bankkártya Slip</th>
                        <th>Rögzítő</th>
                     </tr>
                </thead>
                <tbody>';


        $date = date("Y-m-d");
        // az aktuális napi bevételek lekérdezése
        $sql = "SELECT * FROM napi_elszamolas where telephely = '$this->telephely' AND "
                . "date = '$date' AND torolt_szamla = '0' ORDER BY kezelo_orvos_id, szamlaszam ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row

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
                . $row["szamlaszam"] . "</td><td>"
                . $row["slipsz"] . "</td><td>"
                . $row["rogzito"] . "</td><td>";
            }
        } else {
            echo "0 results";
        }

        $sql = "SELECT sum(bevetel_osszeg) as sum_bevetel,sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas where telephely = '$this->telephely' AND "
                . "date = '$date' AND torolt_szamla = '0' AND kezelo_orvos_id <> '$this->MedicalPlusName'  ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo '<tr class="info"><td>
               </td><td> 
                </td><td>
                </td><td>
                </td><td>
                Összesen:</td><td>'
                . $row["sum_bevetel"] . '</td><td>'
                . $row["sum_jutalek"] . '</td><td>
                </td><td>
                </td><td>
                </td><td>
                </td><td>
                </td><td>';
            }
        } else {
            echo "<tr><td>Nincs rögzített adat</td></tr>";
        }
        echo "</tbody></table></div>";

        mysqli_close($conn);
    }

    public function user_select_kpkivet_all_table() {

        //$conn = DbConnect();
        //$date = date("y-m-d");
        $html = "";

        $sql = "SELECT * FROM kp_kivet WHERE kivet_datum = '$this->date' AND kivet_telephely ='$this->telephely' AND kivet_torolve ='0'";
        $result = $this->conn->query($sql);

        $html .= '<div class="container">
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
                $html .= "<tr><td>"
                . $row["kivet_id"] . "</td><td> "
                . $row["kivevo_neve"] . "</td><td>"
                . $row["kivet_oka"] . "</td><td>"
                . $row["kivet_osszeg"] . "</td><td>"
                . $row["kivet_atvevo"] . "</td><td>"
                . $row["kivet_megjegyzes"] . "</td></tr>"
                ;
            }
        } else {
            $html .= "<tr><td>Nincs rögzített adat</td></tr>";
        }
        // kivét napi szintű összesítése

        $sql2 = "SELECT sum(kivet_osszeg) as sum_kivet FROM kp_kivet where kivet_telephely = '$this->telephely' AND kivet_torolve = '0' AND kivet_datum = '$this->date'";

        $result2 = $this->conn->query($sql2);

        if ($result2->num_rows == 1) {
            while ($row1 = $result2->fetch_assoc()) {
                $recepcioKivet = $row1["sum_kivet"];
            }
        } else {
            $recepcioKivet = 0;
        }
        $html .= '<tr class="info"><td></td><td></td><td>Összesen: </td><td>' . $recepcioKivet . '</td><td></td><td></td></tr>';



        $html .= "</tbody></table></div>";

        return ($html);
        //mysqli_close($conn);
    }

    function user_select_szamla_table_allatvet() {
        //$conn = DbConnect();



        $sql = "SELECT * FROM szamla_befogadas WHERE szamla_atvetdate = '$this->date' AND szamla_telephely ='$this->telephely' AND szamla_torolt = '0'";
        $result = $this->conn->query($sql);

        echo'<div class="container">
                    <h2>Átvett számlák:</h2>
                <table class="table table-striped">
                <thead>
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


        //mysqli_close($conn);
    }

    public function select_orvos_naipjutaléklista() {
        $conn = DbConnect();

        echo'<div class="row" id="HiddenIfPrint">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div class="panel panel-info">    
                    <div class="panel-heading">Orvos vagy kezelő napi kimutatása egészségügyi ellátásról.</div>
                        <div class="panel-body">';


        echo '<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page29">';
        //orovos kezelő
        echo '<div class="form-group">'
        . '<label class="col-sm-3 control-label">Orvos kezelő:</label>'
        . '<div class="col-sm-7">';
        echo '<select class = "form-control" onchange="" name="kezelo_jutalek">';


        $sql = "SELECT DISTINCT * FROM `kezelok_orvosok` WHERE kezelo_telephely ='$this->telephely' ORDER BY kezelo_neve ASC";

        $result = $conn->query($sql);

        echo '<option value="NULL"> Válasszon </option>';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row[kezelo_neve] . '">' . $row[kezelo_neve] . '</option>';
            }
        } else {
            echo "Nincs eredmény!";
        }
        echo '</select></div></div>';

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
        . '<div class="col-sm-7" >'
        . '<div class="radio">';
        echo'<label><input type="radio" name="szamla_vevo" value="medportkft" checked> Medport Kft. ( Budafoki, Pannonia)</label></div>'
        . '<div class="radio"><label><input type="radio" name="szamla_vevo" value="medicalpluskft"> Medical Plus Kft. ( Óbuda )</label></div>'
        . '<div class="radio"><label><input type="radio" name="szamla_vevo" value="SalgoMovekft"> Salgó Move Kft. ( SMM )</label></div>'
        . '</div></div>';

        
         echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">Dátum:</label>'
        . '<div class="col-sm-7" >'
        . '<div class="radio">';
        echo'<input class = "form-control"  type="date" name="jutaleklista_datum" value="'.$this->date.'" ></div></div></div>';

        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label"></label>'
        . '<div class="col-sm-7">';

        echo'<div class="btn-group"><button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Jutalék</button>'
        . '<button type = "button" class = "btn btn-info" onclick="StartPrtintJutalekPage()"><i class="fa fa-print" aria-hidden="true"></i> Nyomtatás</button></div>'
        . '</div></div>';

        echo '</form>';
        echo '</div></div></div></div>';
        echo '<div class="col-sm-4"></div>
               </div>';


        mysqli_close($conn);

        $this->post_select_orvos_naipjutaléklista();
    }

    // jutalék kifizetés kifizetés és átvett számála rögzítése egyszerre
    public function jutalek_kifiz_allfunction_form() {
        $conn = DbConnect();
        echo'<div class="row" id="HiddenIfPrint">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div class="panel panel-info">    
                    <div class="panel-heading">Orvos vagy kezelő napi jutalék kifizetése és számlaátvét rögzítése.</div>
                        <div class="panel-body">';


        echo '<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page30">';
        //orovos kezelő
        echo '<div class="form-group">'
        . '<label class="col-sm-3 control-label">Orvos kezelő:</label>'
        . '<div class="col-sm-7">';
        echo '<select class = "form-control" onchange="" name="kezelo_jutalek">';


        $sql = "SELECT DISTINCT * FROM `kezelok_orvosok` WHERE kezelo_telephely ='$this->telephely'";

        $result = $conn->query($sql);

        echo '<option value="NULL"> Válasszon </option>';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row[kezelo_neve] . '">' . $row[kezelo_neve] . '</option>';
            }
        } else {
            echo "Nincs eredmény!";
        }
        echo '</select></div></div>';

        //készpénzpartner ?
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">Kp partner:</label>'
        . '<div class="col-sm-7">'
        . '<label class="checkbox-inline"> <input type="checkbox" name = "kezelo_kp-partner" value="kp-partner">kp partner </label>'
        . '</div></div>';


        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label"></label>'
        . '<div class="col-sm-7 btn-group">'
        . '<button type = "submit" value = "Submit" class = "btn btn-success">Jutalék lekérdezés</button>'
        . '<button type = "button" class = "btn btn-info" onclick="StartPrtintJutalekPage()" enable><i class="fa fa-print" aria-hidden="true"></i> Nyomtatás</button>'
        . '</div></div></form><hr>';


        //számlakibocsátó neve
        echo'<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page30">'
        . '<div class="form-group">'
        . '<label class="col-sm-3 control-label" >Szamlázó neve:</label>'
        . '<div class="col-sm-7">'
        . '<input type="text" class="form-control" name="szamla_kibocsato" id="szamla_kibocsato" placeholder="számlakibocsátó" required>'
        . '</div></div>';

        // számlaszám
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">Számla sorszáma:</label>'
        . '<div class="col-sm-7">'
        . '<input type="text" class="form-control" name="szamla_sorszam" id="szamla_szama"  placeholder="ABCDE 123456" required>'
        . '</div></div><hr>';




        //kp kivett osszeg
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">Készpénz Összege (Ft):</label>'
        . '<div class="col-sm-7">'
        . '<input type="number" class="form-control" name="kivet_osszeg" id="kp_kivet_osszeg" placeholder="" required>'
        . '</div></div>';
        //kp megjegyzes
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">Megjegyzés:</label>'
        . '<div class="col-sm-7">'
        . '<input type="text" class="form-control" name="kivet_megjegyzes" id="kivet_megjegyzes" placeholder="Megjegyzés" onkeyup="duplicate(this.value)" >'
        . '</div></div>';

        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label"></label>'
        . '<div class="col-sm-7">';

        echo'<div class="btn-group-vertical">'
        . '<button type = "submit" value = "Submit" type = "button" class = "btn btn-danger">Kp kifizetés és Átvertt számal rögzítése</button>'
        //. '<button type = "button" class = "btn btn-info" onclick="StartPrtintJutalekPage()" enable><i class="fa fa-print" aria-hidden="true"></i> Nyomtatás</button>'
        . '</div>'
        . '</div></div>';
        // hidden input kivét oka jutalék megjegyzés hiányzó adatmezők duplikálása
        echo '<input type="hidden" name="kivet_oka"  value="Jutalék" >';
        echo '<input type="hidden" name="kivet_atvevo" id="kivet_atvevo" value="" >';
        echo '<input type="hidden" name = "szamla_megjegyzes" id="szamla_megjegyzes" value="" >';
        echo '</form>';
        echo '</div>                
                    
          <div class="panel-footer">Készpénz összesen : ';

        $kpmaxkivet = new User_Select_NapiElsz;
        echo $kpmaxkivet->user_select_napikp();

        echo ' Ft</div>
        </div>
        </div>    
        </div>';
        echo '<div class="col-sm-4"></div>
               </div>';
        mysqli_close($conn);

        $this->post_select_orvos_naipjutaléklista();
    }

    public function post_select_orvos_naipjutaléklista() {

        $conn = DbConnect();
        if (isset($_POST["kezelo_jutalek"])and  isset($_POST["jutaleklista_datum"]) and  isset($_POST["szamla_vevo"]) ) {

            $kezelo = test_input($_POST["kezelo_jutalek"]);
            $selectdate=$_POST["jutaleklista_datum"];
            $szamla_vevo = $_POST["szamla_vevo"];
            
            $this->kp_kivevo_kezelo = $kezelo;

            if (isset($_POST["kezelo_kp-partner"])) {// ha  az  orvos kezelő kp partner
                $this->kp_padtner = "TRUE";

                $where = "WHERE telephely = '$this->telephely' AND "
                        . "date = '$selectdate' AND torolt_szamla = '0' AND kezelo_orvos_id  = '$kezelo' AND bevetel_tipusa_id = 'kp-partner' ";
            } else {

                $where = "WHERE telephely = '$this->telephely' AND "
                        . "date = '$selectdate' AND torolt_szamla = '0' AND kezelo_orvos_id  = '$kezelo'  AND bevetel_tipusa_id <> 'kp-partner'";
            }

            if (isset($_POST["jutaleklista_tipus"]) AND $_POST["jutaleklista_tipus"] == "all_jutalek") {

                $where = "WHERE telephely = '$this->telephely' AND "
                        . "date = '$selectdate' AND torolt_szamla = '0' AND kezelo_orvos_id  = '$kezelo'";
            } else if (isset($_POST["jutaleklista_tipus"]) AND $_POST["jutaleklista_tipus"] == "all_jutalek-kppartner") {

                $where = "WHERE telephely = '$this->telephely' AND "
                        . "date = '$selectdate' AND torolt_szamla = '0' AND kezelo_orvos_id  = '$kezelo' AND bevetel_tipusa_id <> 'kp-partner'";
            }
            
            
            if ($szamla_vevo == "medportkft"){ $where .= " AND ( telephely = 'BMM' OR telephely = 'Fizio' OR telephely = 'Lábcentrum' OR telephely = 'P70' OR telephely = 'P72' )";}
               else {$where .= "";}     
            if ($szamla_vevo == "medicalpluskft"){ $where .= " AND telephely = 'Óbuda'";}
               else {$where .= "";} 
            if ($szamla_vevo == "SalgoMovekft"){ $where .= " AND telephely = 'SMM'";}
               else {$where .= "";}    

            $sql = "SELECT * FROM napi_elszamolas " . $where;

            $result = $conn->query($sql);

            echo'<div class="container">
                                <h2>' . $kezelo . ' kimutatása egészségügyi ellátásról</h2>
                                <p>Rendelő: ' . $this->telephely . ' / ' . $selectdate . '</p>
                            <table class="table table-striped">
                            <thead>
                                <tr>
                                  <th>Páciens</th>
                                  <th>Szolgáltatás</th>
                                  <th>Szolgáltatás ára Ft</th>
                                  <th>Jutalék Ft</th>
                                  <th>Számlaszám</th>
                                </tr>
                              </thead><tbody>';

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>"
                    . $row["paciens_neve"] . "</td><td> "
                    . $row["szolgaltatas_id"] . "</td><td>"
                    . $row["bevetel_osszeg"] . "</td><td>"
                    . $row["jutalek_osszeg"] . "</td><td>"
                    . $row["szamlaszam"] . "</td><tr>"
                    ;
                }
            } else {
                echo "<tr><td>Nincs rögzített adat</td></tr>";
            }

            $sql1 = "SELECT sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas " . $where;

            $result = $conn->query($sql1);
            if ($result->num_rows > 0) {

                while ($row1 = $result->fetch_assoc()) {
                    echo '<tr><td></td><td></td><td>Összesen:  </td><td>' . $row1["sum_jutalek"] . '</td></tr>';

                    $this->kp_kivet_osszeg = $row1["sum_jutalek"];
                }
            } else {
                echo "<tr><td>Nincs rögzített adat</td></tr>";
            }
            echo'</tr>';
            echo "</tbody></table>";

            echo '<br><br><div class="col-sm-4" style="border-top: dotted 1px; text-align: center;"> ' . $selectdate . ' napi jutalék elszámolás rendben: ' . $kezelo . ' </div></div>';
        }
        mysqli_close($conn);
    }

// napi összesítő tábala új frontend     
    public function user_select_napi_all_table_v2() {

        //$conn = DbConnect();
        $html ="";    
        // táblázat visszaolvasása
        $html .= '<div class="container">';
        $html .= '<h1> Napi összes páciens  az összes kezelőnél:</h1>';
        $html .= '<p>Rendelő: ' .   $this->telephely  . ' / ' . $this->printdate . '</p>';

        $html .= '<table class="table table-bordered table-condensed">
                <thead align="center">
                    <tr>
                        <th>Páciens Neve</th>
                        <th>Orvos/terapeuta</th>
                        <th>Szolg. típ.</th>
                        <th>Számlasz.</th>

                        <th style="background-color:#ffcc00;">KP</th>
                        <th style="background-color:#c2d69b;">BK</th>
                        <th style="background-color:#ff99cc;">Bérlet</th>
                        <th style="background-color:#ffff99;">EP</th>
                        <th style="background-color:#ff8080;">TELADOC</th>
                        <th style="background-color:#ff5050;">Union-Érted</th>
                        <th style="background-color:#00ccff;">Med. +</th>
                        <th style="background-color:;"> EA Átutalás</th>    
                        <th style="background-color:;">Ajándék</th>
                        
                        <th>Jutalék</th>
                        <th>BK Slip</th>
                        <th>Rögzítő</th>
                        
                     </tr>
                </thead>
                <tbody>';



        // az aktuális napi bevételek lekérdezése
        $sql = "SELECT * FROM napi_elszamolas where telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' ORDER BY kezelo_orvos_id, date_bevetel ASC ";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row

            while ($row = $result->fetch_assoc()) {
                $html .= "<tr><td>" . $row["paciens_neve"] . "</td>
                 <td>" . $row["kezelo_orvos_id"] . "</td>
                 <td>" . $row["szolgaltatas_id"] . " ".$row["note"]."</td>
                 <td>" . $row["szamlaszam"] . "</td>";


                $MedicalPulsTrue = strpos($row["kezelo_orvos_id"], 'Medical');
                if ($MedicalPulsTrue === false) {
                    // fizetési módok szerinti csoportosítás
                    //kp
                    if ($row["bevetel_tipusa_id"] == "kp-nyugta" OR $row["bevetel_tipusa_id"] == "kp-számla" OR $row["bevetel_tipusa_id"] == "kp-partner") {

                        $html .= '<td style="background-color:#fde9d9;">' . $row["bevetel_osszeg"] . '</td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc"></td><td></td><td></td><td></td><td></td><td></td>';
                    }
                    // bankkártya
                    if ($row["bevetel_tipusa_id"] == "bankkártya-nyugta" OR $row["bevetel_tipusa_id"] == "bankkártya-számla") {

                        $html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd">' . $row["bevetel_osszeg"] . '</td><td></td><td style="background-color:#ffffcc"></td><td></td><td></td><td></td><td></td><td></td>';
                    }
                    //bérlet
                    if ($row["bevetel_tipusa_id"] == "") {

                        $html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td>' . $row["berlet_adatok"] . '</td><td style="background-color:#ffffcc"></td><td></td><td></td><td></td><td></td><td></td>';
                    }
                    //epkártya
                    if ($row["bevetel_tipusa_id"] == "egészségpénztár-kártya") {

                        $html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc">' . $row["bevetel_osszeg"] . '</td><td></td><td></td><td></td><td></td><td></td>';
                    }
                    //fizmód advance medical
                    if ($row["bevetel_tipusa_id"] == "TELADOC" ) {

                        $html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc"></td><td>' . $row["bevetel_osszeg"] . '</td><td></td><td></td><td></td><td></td>';
                    }
                     //fizmód union érted
                    if ($row["bevetel_tipusa_id"] == "Union-Érted" ) {

                        $html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc"></td><td></td><td>' . $row["bevetel_osszeg"] . '</td><td></td><td></td><td></td>';
                    }
                    //europe assistance  és átutalás
                    if ($row["bevetel_tipusa_id"] == "europe assistance" OR  $row["bevetel_tipusa_id"] == "átutalás" OR  $row["bevetel_tipusa_id"] == "szamlazz.hu-átutalás")  {

                        $html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc"></td><td></td><td></td><td></td><td>' . $row["bevetel_osszeg"] . '</td><td></td>';
                    }
                    
                    if ($row["bevetel_tipusa_id"] == "ajándék") {

                        $html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc"></td><td></td><td></td><td></td><td></td><td>' . $row["bevetel_osszeg"] . '</td>';
                    }
                    
                }
                // ha medical plussz kft eladása történt 
                //szolgáltatást medical plusz nyújtotta
                if ($MedicalPulsTrue !== false) {

                    $html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc"></td><td></td><td>' . $row["bevetel_osszeg"] . '</td><td></td><td></td>';
                }
                $time = strtotime($row["date_bevetel"]);
                $timestamp = date ("H:i",$time);
                $html .= '<td>' . $row["jutalek_osszeg"] . '</td>
                      <td>' . $row["slipsz"] . '</td>
                      <td style="font-size:10px">' . $row["rogzito"] . ' - '. $timestamp . '</td></tr>';
            }
        } else {
            $html .= "0 results";
        }


        $html .= '<tr class="info">
                <td></td>
                <td></td>
                <td></td>
                <td>Összesen:<br>Med. Plus KP:</td>
                <td>' . $this->forgalom_sum("kp") . '<br>'. $this->orvos_terapeuta_sumKPforg($this->MedicalPlusName). '</td>
                <td>' . $this->forgalom_sum("bankkártya") . '</td>
                <td></td>
                <td>' . $this->forgalom_sum("egészségpénztár") . '</td>
                <td>' . $this->forgalom_sum("advance medical") . '</td>
                <td>' . $this->forgalom_sum("Union-Érted") . '</td>
                <td>' . $this->orvos_terapeuta_sumforg($this->MedicalPlusName).'</td> 
                <td>EA:' . $this->forgalom_sum("europe assistance") .'<br>Ut:'. $this->forgalom_sum("átutalás"). '</td>
                <td>' . $this->forgalom_sum("ajándék") . '</td>
                <td>' . $this->orvos_terapeuta_sumjutalek("") . '</td>
                <td></td><td></td>';
        

        // kivétek a táblázat aljára.

        $html .= "<tr><td>Napi kiadások:</td></tr>";
        
        $sql = "SELECT * FROM kp_kivet WHERE kivet_datum = '$this->date' AND kivet_telephely ='$this->telephely' AND kivet_torolve ='0'";
        $resultkivet = $this->conn->query($sql);

        $html .= '<tr>
                  <th>Kivét Oka</th>
                  <th>Átvevő</th>
                  <th>Megjegyzés</th>
                  <th></th>
                  <th>Összeg(Ft)</th>
                  </tr>';
                            
        if ($resultkivet->num_rows > 0) {     
            while ($row = $resultkivet->fetch_assoc()) {
                $html .= "<tr><td>"
                . $row["kivet_oka"] . "</td><td>"
                . $row["kivet_atvevo"] . "</td><td>"
                . $row["kivet_megjegyzes"]  . "</td><td>"
                         . "</td><td> - "
                . $row["kivet_osszeg"] . "</td></tr>";
            }
        } else {
            //$html .= "<tr><td>Nincs rögzített adat</td></tr>";
        }
        
        // készpénz kivét összesítve napi szinten minden recepcióstól  
        $sql2 = "SELECT sum(kivet_osszeg) as sum_kivet FROM kp_kivet where kivet_telephely = '$this->telephely' AND kivet_torolve = '0' AND kivet_datum = '$this->date'";

        $result2 = $this->conn->query($sql2);

        if ($result2->num_rows == 1) {
            while ($row1 = $result2->fetch_assoc()) {
                $recepciosokKpKivet = $row1["sum_kivet"];
            }
        } else {
            $recepciosokKpKivet = 0;
        }
       
        $total = $this->forgalom_sum("kp") - $recepciosokKpKivet;
        $html .= '<tr>
                  <th>Végösszeg:</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th>'.$total.'</th>
                  </tr>';
        
        $html .= "</tbody></table></div>";
        return ($html);
    }

    public function forgalom_sum($forg_tip) {

        $sql = "SELECT sum(bevetel_osszeg) as sum_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' AND kezelo_orvos_id <> '$this->MedicalPlusName' AND bevetel_tipusa_id LIKE '%$forg_tip%' ";

        $resulforg = $this->conn->query($sql);
        if ($resulforg->num_rows > 0) {

            while ($rowbev = $resulforg->fetch_assoc()) {
                $sum = $rowbev["sum_bevetel"];
            }
        } else {
            $sum = 'null';
        }
        return ($sum);
    }

    public function orvos_terapeuta_sumKPforg($kezelo) {

        $sql = "SELECT sum(bevetel_osszeg) as sum_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' AND kezelo_orvos_id LIKE '%$kezelo%' AND bevetel_tipusa_id LIKE '%KP%'";

        $resulforg = $this->conn->query($sql);
        if ($resulforg->num_rows > 0) {

            while ($rowbev = $resulforg->fetch_assoc()) {
                $sum = $rowbev["sum_bevetel"];
            }
        } else {
            $sum = 'null';
        }
        return ($sum);
    }
    public function orvos_terapeuta_sumforg($kezelo) {

        $sql = "SELECT sum(bevetel_osszeg) as sum_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' AND kezelo_orvos_id LIKE '%$kezelo%'";

        $resulforg = $this->conn->query($sql);
        if ($resulforg->num_rows > 0) {

            while ($rowbev = $resulforg->fetch_assoc()) {
                $sum = $rowbev["sum_bevetel"];
            }
        } else {
            $sum = 'null';
        }
        return ($sum);
    }

    public function orvos_terapeuta_sumjutalek($kezelo) {

        $sql = "SELECT sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' AND kezelo_orvos_id  LIKE '%$kezelo%'";

        $resulforg = $this->conn->query($sql);
        if ($resulforg->num_rows > 0) {

            while ($rowbev = $resulforg->fetch_assoc()) {
                $sum = $rowbev["sum_jutalek"];
            }
        } else {
            $sum = 'null';
        }
        return ($sum);
    }

 public function Napizaras_Form(){
    
    $html = ""; 
    
     //$conn = DbConnect();
        $date = date("y-m-d");
              
        $html .= '<div class="panel panel-danger" class="HiddenIfPrint">';
            $html .='<div class="panel-heading">Napi zárások lekérdezése</div>';
            $html .= '<div class="panel-body">';
                $html .= '<form action="' . $_SERVER['PHP_SELF'] . '?pid=page94" method="post" >'; 
                
                //lekérdezési időszak eleje
                $html .= '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Időszak :</label>
                        <div class="col-sm-7"><input type="date" class="form-control" name="zaras_date" ></div>
                     </div>';
                                             
                //telephely
                $html .= '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Telephely :</label>
                        <div class="col-sm-7">';
                        
                        $html .='<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-building"></i></span>';
                            $html .='<select class = "form-control" name = "zaras_telephely">';
                           
                            $sql = "SELECT * FROM telephelyek";
                            $result = $this->conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $html .= '<option value="' . $row["telephely_neve"] . '">' . $row["telephely_neve"] . '</option>';
                                }
                            } else {
                                $html .= "0 results";
                            }
                            $html .= '</select></div>';
                
                        $html .='</div>
                     </div>';
                        
                    
                //gombok
                $html .= '<div class="form-group">';
                    $html .= '<label class="col-sm-3 control-label"></label>';    
                    $html .='<div class="btn-group">';
                        
                        $html .='<button type="submit" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> Lekérdez</button>';
                        //$html .='<a href="#" onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
                        $html .='<a href="#" onclick="copyClipboard()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a>'                        
                        
                        . '</div>'
                . '</div>';        
                $html .= '</form>';
            
            $html .='</div>';
            $html .='<div class="panel-footer">BMM
                </div></div>';
 
    return ($html);
    }
    
    function admin_post_zarasdate() {
        $html ="";
        if (isset($_POST["zaras_date"]) AND isset($_POST["zaras_telephely"])){
            $date =  $_POST["zaras_date"];
            $telephely = $_POST["zaras_telephely"];
            //echo $date .' - '. $telephely;
            $this->__set_Date($date);
            $this->__set_Telephely($telephely);
            
            $html .= '<div class="" id="riport">';
            $html .=  $this ->user_select_napi_all_bevetelektipusok();
           
            $html .= $this ->user_select_kpkivet_all_table();
            $html .= '<div class="container">';
            
            $szamla =  new Szamla_befogadasClass;
            $szamla->__set_Date($date);
            $szamla->__set_Telephely($telephely);
            $html .= $szamla ->Visualize_All_Szamla_Table_User("napiosszes");
           
            $html .= '</div>';
            $html .= $this->user_select_napi_all_table_v2();
            $html .= '</div>';
             
            return($html);
        }           
    }
    
    function emailreport_zarasok($date,$telephely ){
            $html = "";
            $this->__set_Date($date);
            $this->__set_Telephely($telephely);
            $html .= '<h1>Rendelő: '.$telephely.'</h1>'; 
            $html .= '<div class="" id="riport">';
            $html .=  $this ->user_select_napi_all_bevetelektipusok();
           
            $html .= $this ->user_select_kpkivet_all_table();
            $html .= '<div class="container">';
            
            $szamla =  new Szamla_befogadasClass;
            $szamla->__set_Date($date);
            $szamla->__set_Telephely($telephely);
            $html .= $szamla ->Visualize_All_Szamla_Table_User("napiosszes");
           
            $html .= '</div>';
            $html .= $this->user_select_napi_all_table_v2();
            $html .= '</div>';
             
            return($html);
        
        
    }
   
public function Check_Napi_PaciensLista(){
   
   $html = "";
   // a mai napon még nem rögzített betegek száma az aktuális rendelőben
   
   $sql = "SELECT COUNT(beteglista_id) AS paciensNo FROM napi_beteglista WHERE rogzitett_beteg = '0' and torolt_beteg = '0' AND rogzitesi_ido LIKE '%$this->date%' AND telephely = '$this->telephely'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
            
                if ($row["paciensNo"] > 0 ){
                $html .= '<div class="alert alert-danger">
                            <strong>Figyelem!</strong> A mai napra előjegyzett pacienslistáról <strong>'.$row["paciensNo"].'</strong> páciens nincs a rendelő napi elszámolásában! 
                          </div>';
            
                }
            }
        } else {
             $html .= 
           '<div class="alert alert-info alert-dismissible">
                <strong>Figyelem!</strong>napi előjegyzett paciensek - lehérdezési hiba! 
            </div>';
        }
   
   
 
    
    
   return $html; 
}    
    
}
?>

