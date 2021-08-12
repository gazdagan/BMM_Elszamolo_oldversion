<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**HASZNÁLATON KÍVÜL
 * Description of emailreportClass
 *
 * @author Andras
 */
class emailreportClass {

    //put your code here

    public $telephely;
    private $date;
    public $html;
    public $conn;
  
    function __construct($date, $telephely) {

        $this->telephely = $telephely;
        $this->date = $date;
        $this->conn = DbConnect();
        $this->MedicalPlusName = 'Medical Plus Kft.';
        
        
    }
    
    function __destruct() {
        mysqli_close($this->conn);
    }

// összesítő tábla
    public function user_select_napi_all_bevetelektipusok() {

        $conn = DbConnect();


        // táblázat visszaolvasása
        $this->html = '<div class="">';
        $this->html .= '<h1>' . $this->telephely . ' Összesített napi adatok</h1><p>Rendelő:' . $this->telephely . ' / ' . $this->date . '</p>';
        $this->html .= '<table class="">
                <thead>
                    <tr>
                        <th>Bevétel tipusok</th>
                        <th>Összeg(HUF)</th>
                        <th>Darabszám</th>
                    </tr>
                </thead>';
        // az aktuális napi bevételek lekérdezése

        $this->html .= '<tr>';
        // készpénz adatok összesítése    
        $this->html .= '<td>Készpénz (számla + nyugat)</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND ( bevetel_tipusa_id = 'kp-nyugta' OR bevetel_tipusa_id = 'kp-számla' )";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
                $recepciosokKpBevetel = $row1["sum_kp_bevetel"];
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám

        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND ( bevetel_tipusa_id = 'kp-nyugta' OR bevetel_tipusa_id = 'kp-számla' )";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }

        $this->html .= '</tr>';
        $this->html .= '<tr>';
        // Bankkártya forgalomi  adatok összesítése    
        $this->html .= '<td>Bankkártya (számla + nyugat)</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND ( bevetel_tipusa_id = 'bankkártya-nyugta' OR bevetel_tipusa_id = 'bankkártya-számla' )";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0'"
                . "AND ( bevetel_tipusa_id = 'bankkártya-nyugta' OR bevetel_tipusa_id = 'bankkártya-számla' )";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        $this->html .= '</tr>';
        $this->html .= '<tr>';


        //Egészségpénztári forgalomi  adatok összesítése    
        $this->html .= '<td>Egészségpénztár (számla + kártya)</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id  LIKE '%egészségpénztár%'";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id LIKE '%egészségpénztár%'";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        $this->html .= '</tr>';
        $this->html .= '<tr>';



        //EuropeAssistance forgalomi  adatok összesítése    
        $this->html .= '<td>Europe Assistance</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id = 'europe assistance'";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0'  "
                . "AND  bevetel_tipusa_id = 'europe assistance'";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        $this->html .= '</tr>';
        $this->html .= '<tr>';



        //Adv Medical forgalomi  adatok összesítése    
        $this->html .= '<td>Advance Medical</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0'  "
                . "AND  bevetel_tipusa_id = 'advance medical'";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0'  "
                . "AND  bevetel_tipusa_id = 'advance medical'";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        $this->html .= '</tr>';

        $this->html .= '<tr>';
     


//átutalás forgami adaton forgalomi  adatok összesítése    
        $this->html .= '<td>Átutalás</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id = 'átutalás'";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' AND "
                . "bevetel_tipusa_id = 'átutalás'";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        $this->html .= '</tr>';

        $this->html .= '<tr>';
        


//ajándék forgami adatok összesítése    
        $this->html .= '<td>Ajándék</td>';

        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id = 'ajándék'";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id = 'ajándék'";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        $this->html .= '</tr>';


        
        // készpénz adatok összesítése    
        $this->html .= '<td>Készpénz partner</td>';
        // ósszesített összegek
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND bevetel_tipusa_id = 'kp-partner'";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["sum_kp_bevetel"] . '</td>';
               
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }
        // összesített darabszám
        $sql1 = "SELECT count(*) as db_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id = 'kp-partner'";

        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $this->html .= '<td>' . $row1["db_kp_bevetel"] . '</td>';
            }
        } else {
            $this->html .= "<td>Nincs rögzített adat</td>";
        }

        $this->html .= '</tr>';

        // készpénz kivét összesítve napi szinten minden recepcióstól  
        $sql2 = "SELECT sum(kivet_osszeg) as sum_kivet FROM kp_kivet where kivet_telephely = '$this->telephely' AND kivet_torolve = '0' AND kivet_datum = '$this->date'";

        $result2 = $conn->query($sql2);

        if ($result2->num_rows == 1) {
            while ($row1 = $result2->fetch_assoc()) {
                $recepciosokKpKivet = $row1["sum_kivet"];
            }
        } else {
            $recepciosokKpKivet = 0;
        }

        $kpEgyenleg = $recepciosokKpBevetel - $recepciosokKpKivet;

        $this->html .= '<tr class=""><td>Készpénz forgalom (kp bevétel - kp kiadás)</td><td>' . $recepciosokKpBevetel . ' - ' . $recepciosokKpKivet . ' = ' . $kpEgyenleg . ' </td><td></td><td></tr>';


        $this->html .= "</tbody></table></div>";


        mysqli_close($conn);
    }

    //készpénz kiváétek táblája
    public function user_select_kpkivet_all_table() {

        $conn = DbConnect();


        $sql = "SELECT * FROM kp_kivet WHERE kivet_datum = '$this->date' AND kivet_telephely ='$this->telephely' AND kivet_torolve ='0'";
        $result = $conn->query($sql);

        $this->html .= '<div class="container">
                <table class="">
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
                $this->html .= "<tr><td>"
                        . $row["kivet_id"] . "</td><td> "
                        . $row["kivevo_neve"] . "</td><td>"
                        . $row["kivet_oka"] . "</td><td>"
                        . $row["kivet_osszeg"] . "</td><td>"
                        . $row["kivet_atvevo"] . "</td><td>"
                        . $row["kivet_megjegyzes"] . "</td></tr>"
                ;
            }
        } else {
            $this->html .= "<tr><td>Nincs rögzített adat</td></tr>";
        }
        // kivét napi szintű összesítése

        $sql2 = "SELECT sum(kivet_osszeg) as sum_kivet FROM kp_kivet where kivet_telephely = '$this->telephely' AND kivet_torolve = '0' AND kivet_datum = '$this->date'";

        $result2 = $conn->query($sql2);

        if ($result2->num_rows == 1) {
            while ($row1 = $result2->fetch_assoc()) {
                $recepcioKivet = $row1["sum_kivet"];
            }
        } else {
            $recepcioKivet = 0;
        }
        $this->html .= '<tr class="info"><td></td><td></td><td>Összesen: </td><td>' . $recepcioKivet . '</td><td></td><td></td></tr>';



        $this->html .= "</tbody></table></div>";


        mysqli_close($conn);
    }

    
    public function Visualize_All_Szamla_Table_User() {
        $conn = DbConnect();
        
        $sql = "SELECT * FROM szamla_befogadas WHERE szamla_atvetdate = '$this->date' AND szamla_telephely ='$this->telephely' AND szamla_torolt = '0'";
        $cimsor = "Napi összes átvett számla:";

        $result = $conn->query($sql);

        $this->html .= '<div class="">
                <table class="">
                <thead>
                    <tr><th>' . $cimsor . '</th></tr>
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
                $this->html .= "<tr><td>"
                        . $row["szamla_id"] . "</td><td> "
                        . $row["szamla_atvevo"] . "</td><td>"
                        . $row["szamla_kibocsato"] . "</td><td>"
                        . $row["szamla_sorszam"] . "</td><td>"
                        . $row["szamla_megjegyzes"] . "</td></tr>"
                ;
            }
        } else {
            $this->html .= "<tr><td>Nincs rögzített adat</td></tr>";
        }
        $this->html .= "</tbody></table></div>";


        mysqli_close($conn);
    }

    public function write_report_to_file() {

        $filename = $this->telephely . '.html';

        if (file_exists($filename)) {
            // file törlése ha létezik
            unlink($filename);
        }
        //új file készítése
        $myfile = fopen($filename, "w") or die("Unable to open file!");
        echo $myfile;
        fwrite($myfile, $this->html);
        fclose($myfile);

        return ($filename);
    }
    public function user_select_napi_all_table_v2() {

        //$conn = DbConnect();
         
        // táblázat visszaolvasása
        $this->html .= '<div class="container">';
        $this->html .= '<h3> Rendelő tételes összesítése:</h3>';
        $this->html .= '<p>Rendelő: ' .   $this->telephely  . ' / ' . $this->date . '</p>';

        $this->html .= '<table class="table table-bordered table-condensed">
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
                        <th style="background-color:#ff8080;">Adv. Med.</th>
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
                $this->html .= "<tr><td>" . $row["paciens_neve"] . "</td>
                 <td>" . $row["kezelo_orvos_id"] . "</td>
                 <td>" . $row["szolgaltatas_id"] . "</td>
                 <td>" . $row["szamlaszam"] . "</td>";


                $MedicalPulsTrue = strpos($row["kezelo_orvos_id"], 'Medical');
                if ($MedicalPulsTrue === false) {
                    // fizetési módok szerinti csoportosítás
                    //kp
                    if ($row["bevetel_tipusa_id"] == "kp-nyugta" OR $row["bevetel_tipusa_id"] == "kp-számla" OR $row["bevetel_tipusa_id"] == "kp-partner") {

                        $this->html .= '<td style="background-color:#fde9d9;">' . $row["bevetel_osszeg"] . '</td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc"></td><td></td><td></td><td></td><td></td>';
                    }
                    // bankkártya
                    if ($row["bevetel_tipusa_id"] == "bankkártya-nyugta" OR $row["bevetel_tipusa_id"] == "bankkártya-számla") {

                        $this->html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd">' . $row["bevetel_osszeg"] . '</td><td></td><td style="background-color:#ffffcc"></td><td></td><td></td><td></td><td></td>';
                    }
                    //bérlet
                    if ($row["bevetel_tipusa_id"] == "") {

                        $this->html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td>' . $row["berlet_adatok"] . '</td><td style="background-color:#ffffcc"></td><td></td><td></td><td></td><td></td>';
                    }
                    //epkártya
                    if ($row["bevetel_tipusa_id"] == "egészségpénztár-kártya") {

                        $this->html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc">' . $row["bevetel_osszeg"] . '</td><td></td><td></td><td></td><td></td>';
                    }
                    //fizmód advance medical
                    if ($row["bevetel_tipusa_id"] == "advance medical") {

                        $this->html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc"></td><td>' . $row["bevetel_osszeg"] . '</td><td></td><td></td><td></td>';
                    }
                    //europe assistance 
                    if ($row["bevetel_tipusa_id"] == "europe assistance" OR  $row["bevetel_tipusa_id"] == "átutalás")  {

                        $this->html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc"></td><td></td><td></td><td>' . $row["bevetel_osszeg"] . '</td><td></td>';
                    }
                    
                    if ($row["bevetel_tipusa_id"] == "ajándék") {

                        $this->html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc"></td><td></td><td></td><td></td><td>' . $row["bevetel_osszeg"] . '</td>';
                    }
                    
                }
                // ha medical plussz kft eladása történt 
                //szolgáltatást medical plusz nyújtotta
                if ($MedicalPulsTrue !== false) {

                    $this->html .= '<td style="background-color:#fde9d9;"></td><td style="background-color:#eaf1dd"></td><td></td><td style="background-color:#ffffcc"></td><td></td><td>' . $row["bevetel_osszeg"] . '</td><td></td><td></td>';
                }

                $this->html .= "<td>" . $row["jutalek_osszeg"] . "</td>
                      <td>" . $row["slipsz"] . "</td>
                      <td>" . $row["rogzito"] . "</td></tr>";
            }
        } else {
            $this->html .= "0 results";
        }


        $this->html .= '<tr class="info">
                <td></td>
                <td></td>
                <td></td>
                <td>Összesen:</td>
                <td>' . $this->forgalom_sum("kp") . '</td>
                <td>' . $this->forgalom_sum("bankkártya") . '</td>
                <td></td>
                <td>' . $this->forgalom_sum("egészségpénztár") . '</td>
                <td>' . $this->forgalom_sum("advance medical") . '</td>
                <td>' . $this->orvos_terapeuta_sumforg($this->MedicalPlusName).'</td> 
                <td>EA:' . $this->forgalom_sum("europe assistance") .'<br>Ut:'. $this->forgalom_sum("átutalás"). '</td>
                <td>' . $this->forgalom_sum("ajándék") . '</td>
                <td>' . $this->orvos_terapeuta_sumjutalek("") . '</td>
                <td></td><td></td>';

        // kivétek a táblázat aljára.

        $this->html .= "<tr><td>Napi kiadások:</td></tr>";
        
        $sql = "SELECT * FROM kp_kivet WHERE kivet_datum = '$this->date' AND kivet_telephely ='$this->telephely' AND kivet_torolve ='0'";
        $resultkivet = $this->conn->query($sql);

        $this->html .= '<tr>
                  <th>Kivét Oka</th>
                  <th>Átvevő</th>
                  <th>Megjegyzés</th>
                  <th></th>
                  <th>Összeg(Ft)</th>
                  </tr>';
                            
        if ($resultkivet->num_rows > 0) {     
            while ($row = $resultkivet->fetch_assoc()) {
                $this->html .= "<tr><td>"
                . $row["kivet_oka"] . "</td><td>"
                . $row["kivet_atvevo"] . "</td><td>"
                . $row["kivet_megjegyzes"]  . "</td><td>"
                         . "</td><td> - "
                . $row["kivet_osszeg"] . "</td></tr>";
            }
        } else {
            //$this->html .= "<tr><td>Nincs rögzített adat</td></tr>";
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
        $this->html .= '<tr>
                  <th>Végösszeg:</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th>'.$total.'</th>
                  </tr>';
        
        $this->html .= "</tbody></table></div>";
        //return ($this->html);
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
}
