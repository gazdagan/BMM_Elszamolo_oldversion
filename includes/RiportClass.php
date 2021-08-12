<?php


/**
 * Description of Riport
 * havi bontású riportok 
 * 1-telephel yszerinti bontásban 
 * 
 * 
 * 
 * @author Andras
 */
class RiportClass {
    //put your code here

    private $date; 
    private $dbconn;
    private $telephely;
    private $recepcios;
    private $color_codes ;
    private $offices;
    private $office_db;
    
   
    
    public function __construct() {
        $this->date = date("Y-m-d");  
        $this->dbconn = DbConnect();
        
        if (isset($_SESSION['set_telephely'])) {

            $this->telephely = $_SESSION['set_telephely'];
        } else {
            $this->telephely = "Error telephely";
        }
         
        if (isset($_SESSION['real_name'])) {

            $this->recepcios = $_SESSION['real_name'];
        } else {
            $this->recepcios = "Error recepcio";
        }
        $this->color_codes = ["#d99594","#c6d9f0","#8db3e2","#548dd4","#d6e3bc","#c2d69b","#e5b8b7"];
        $this->offices = ["Buda", "Pest","Óbuda","Fizio","Lábcentrum","Összesen"];
        $this->office_db = ["BMM","P7","Óbuda","Fizio","Lábcentrum",""];
        
    }
    
    public function __destruct() {
        mysqli_close($this->dbconn);
    }
    
    public function Select_month_form($tipe){
        $date = strtotime($this->date);
        $month = date("Y-m",$date);
        $action = "";
        
        if ($tipe == "1_telephely_riport" ){$action ="index.php?pid=page96";}
        if ($tipe == "2_kezelo_riport" ){$action ="index.php?pid=page97";}
        if ($tipe == "3_allin_riport" ){$action ="index.php?pid=page98";}
        if ($tipe == "4_medicalplusz_riport" ){$action ="index.php?pid=page87";}
        if ($tipe == "kppartner_riport" ){$action ="index.php?pid=page74";}
        if ($tipe == "alap_kotroll_dr" ){$action ="index.php?pid=page798";}
        
        $html = "";
        $html .= '<div class="panel panel-danger">';
        $html .= '<div class="panel-heading">Időszak kiválasztása a kívánt riporthoz.</div>';
        $html .= '<div class="panel-body">';
        $html .= '<form method="POST" action="'.$action.'" class="form-inline">';
                
                       
        $html .=  '<div class="form-group">'
                . '<label class="control-label" for="riport1_month">Keresett hónap:</label>'
                . '<input id="month" type="month" value="'.$month.'" class="form-control" name="riport1_month"></div>'
                . '<button type="submit" class="btn btn-default">Riport készítés</button>'
                .'<a type="button" onclick="copyClipboard()" class="btn btn-default">Vágólapra</a>'
                .''
                . '</form>';
        
        $html .='</div>';
        $html .='<div class="panel-footer">BMM</div></div>';
    
        
        
        return ($html);
    }    
    
    public function Admin_post_select_mounth() {
        $return = "";
        
        if (isset ($_POST["riport1_month"]) AND isset($_GET["pid"])){
            if ($_GET["pid"] =="page96" ){
                $date = test_input($_POST["riport1_month"]);
                $return .= $this->Riport_1_telephelynetto($date);
            }    
            if ($_GET["pid"] =="page97" ){
                $date = test_input($_POST["riport1_month"]);
                $return .= $this->Riport_2_Kezelok_Netto($date);
            }   
            if ($_GET["pid"] =="page98" ){
                $date = test_input($_POST["riport1_month"]);
                $return .= $this->Riport_3_Allin($date);
            }
            if ($_GET["pid"] =="page87" ){
                $date = test_input($_POST["riport1_month"]);
                $return .= $this->Riport_4_MedicalPlus($date);
            }
            if ($_GET["pid"] =="page74" ){
                $date = test_input($_POST["riport1_month"]);
                $return .= $this->Riport_5_Kppartner($date);
            }
            if ($_GET["pid"] =="page798" ){
                $date = test_input($_POST["riport1_month"]);
                $return .= $this->Riport_6_DrAlapKontroll($date);
            }
            
        }
           
        return($return);
    }    
        
    public function Riport_1_telephelynetto($riport_date) {
            
       
        //$office_db = array ("BMM","P7","Óbuda","Fizio","Lábcentrum","");
        $html = "";
        $data =""; // lekérdezett cellaérték
        $date_start = $riport_date.'-1';
        $date_end = $riport_date.'-31';
        $date ="";
        $telephely ="";      
        $netto;
        $sumnetto;
        
        //$html .= $date_start .' - '. $date_end ;
        $html .= '<table class="table table-bordered table-condensed" id="riport">';
        $html .= '<thead><tr  class="success"><th colspan="33">'.$date_start.' - '.$date_end.' Időszak nettó bevételi rendelő szerinti bontásban</th></tr></thead>';
        $html .= '<thead><tr><th>Rendelők</th>';
            
            for ($day = 1; $day < 32 ; $day++ ){
                $color = $day % 7;
                $html .= '<th style="background-color:'.$this->color_codes[$color].'; text-align:center; ">'.$day.'</th>';
            }
            $html .= '<th>Összesen</th></tr></thead>';       
            
            for ($s = 0 ; $s < 6; $s++ ){
                $telephely = $this->office_db[$s];
                $html .= '<tr><th>'.$this->offices[$s].'</th>';
                   
                for ($day = 1; $day < 32 ; $day++ ){
                        $color = $day % 7;
                        $date = $riport_date.'-'.$day;
                        // bevétel lekérdezés
                        $sql1 = "SELECT sum(bevetel_osszeg) as sum_bevetel, sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE telephely LIKE '%$telephely%' AND "
                        . "date = '$date' AND torolt_szamla = '0'";

                         $result = $this->dbconn->query($sql1);
                        if ($result->num_rows > 0) {
                            while ($row1 = $result->fetch_assoc()) {
                                $data = $row1["sum_bevetel"] ;
                                $jutalek = $row1["sum_jutalek"] ;
                            }
                        } else {
                            $data = 0;
                        }
                     
                            $netto = $data-$jutalek;


                            $html .= '<td style="background-color:'.$this->color_codes[$color].';text-align:right;">'.$netto.'</td>';
                        }
                     // summ bevétel sorok 
                        $sql1 = "SELECT sum(bevetel_osszeg) as sum_bevetel, sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE telephely LIKE '%$telephely%' AND "
                        . "(date BETWEEN '$date_start' AND '$date_end') AND torolt_szamla = '0'";

                         $result = $this->dbconn->query($sql1);
                        if ($result->num_rows > 0) {
                            while ($row1 = $result->fetch_assoc()) {
                                $row_sum = $row1["sum_bevetel"] ;
                                $sum_jutalek = $row1["sum_jutalek"] ;
                            }
                        } else {
                            $row_sum = 0;
                        }
                                                       
                        $sumnetto = $row_sum - $sum_jutalek;
                        
                        
                $html .= '<td>'.$sumnetto.'</td</tr>'  ;       
            }
            
               
      
        $html .= '</tabel>';
        return ($html);
}   
    
public function Riport_2_Kezelok_Netto($riport_date) {
    $html ="";
    $data =""; // lekérdezett cellaérték
    $date_start = $riport_date.'-1';
    $date_end = $riport_date.'-31';
    $date ="";
    $telephely ="";      
    
    $html .= '<table class="table table-bordered table-condensed" id="riport">';
        $html .= '<thead><tr  class="success"><th colspan="33">'.$date_start.' - '.$date_end.' Időszak nettó bevételi orvosok-kezelők szerinti bontásban</th></tr></thead>';
              
        // renfelők szerinti bontás
        for ($s = 0 ; $s < 5; $s++ ){    
            $telephely = $this->office_db[$s];
            $html .= '<thead><tr style="border:3px solid;"><th>'.$this->offices[$s].'</th>';
                
            for ($day = 1; $day < 32 ; $day++ ){
                    $color = $day % 7;
                    $html .= '<th style="background-color:'.$this->color_codes[$color].'; text-align:center; ">'.$day.'</th>';
                }
                $html .= '<th>Összesen</th></tr></thead>';       
        // fejléc vége 
        
        //telephelyenként kezeéő lista + adatok     
        $sql1 = "SELECT DISTINCT kezelo_neve FROM kezelok_orvosok WHERE kezelo_telephely LIKE '%$telephely%' ORDER BY kezelo_neve ASC " ;
        $result = $this->dbconn->query($sql1);
            if ($result->num_rows > 0) {
                while ($row1 = $result->fetch_assoc()) {
                    $kezelo = $row1["kezelo_neve"];
                    $html .= '<tbody><tr><td>'.$kezelo.'</td>'; 
                   
                    // kezeló napi forgalma 
                    for ($day = 1; $day < 32 ; $day++ ){
                        $color = $day % 7;
                        $date = $riport_date.'-'.$day; 
                        $jutalek = 0;
                        $netto = 0;
                        $data = 0;

                        // bevétel összesen
                        $sql2 = "SELECT sum(bevetel_osszeg) as sum_bevetel, sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE telephely LIKE '%$telephely%' AND "
                              . "date = '$date' AND torolt_szamla = '0' AND kezelo_orvos_id LIKE '%$kezelo%'" ;
                        
                        $result2 = $this->dbconn->query($sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    $data = $row2["sum_bevetel"];
                                    $jutalek = $row2["sum_jutalek"];
                                } 
                            }else {$date = "error"; }
                        //jutalék összesen
                                            
                    
                        $netto = $data - $jutalek;
                        $html .= '<td style="background-color:'.$this->color_codes[$color].'; text-align:right; ">'.$netto.'</td>';
                    }        
                    // sor összesen időszaki összesítés
                         $sql3 = "SELECT sum(bevetel_osszeg) as sum_bevetel, sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE telephely LIKE '%$telephely%' AND "
                        . "(date BETWEEN '$date_start' AND '$date_end') AND torolt_szamla = '0' AND kezelo_orvos_id LIKE '%$kezelo%'";

                        $result3 = $this->dbconn->query($sql3);
                            if ($result3->num_rows > 0) {
                                while ($row3 = $result3->fetch_assoc()) {
                                    $row_sum = $row3["sum_bevetel"] ;
                                    $sum_jutalek = $row3["sum_jutalek"] ;
                                }
                            } else {
                                $row_sum = 0;
                                $sum_jutalek =0;
                            }
                                                   
                        $sumnetto = $row_sum - $sum_jutalek;
                                                
                        $html .= '<td style="text-align:right;">'.$sumnetto.'</td</tr>'  ;   
                        
                    
                }    
            }else{$kezelo = "hiba";}    
        // oszlop összesen
        $html .= '<tr><td>Összesen:</td>';
        // összesen adatok 
        for ($day = 1; $day < 32 ; $day++ ){
            $color = $day % 7;
            $date = $riport_date.'-'.$day; 
            // bevétel lekérdezés
            $sql4 = "SELECT sum(bevetel_osszeg) as sum_bevetel, sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE telephely LIKE '%$telephely%' AND "
                  . "date = '$date' AND torolt_szamla = '0'";

            $result4 = $this->dbconn->query($sql4);
                if ($result4->num_rows > 0) {
                    while ($row4 = $result4->fetch_assoc()) {
                        $data = $row4["sum_bevetel"] ;
                        $jutalek = $row4["sum_jutalek"] ;
                    }
               } else { 
                    $data = 0;
                    $jutalek=0;
               }
            $netto = $data-$jutalek;
            $html .= '<td style="background-color:'.$this->color_codes[$color].';text-align:right;">'.$netto.'</td>';
        }       
        //mindösszesen az adott időszak és a telephely függvényében  
            $sql5 = "SELECT sum(bevetel_osszeg) as sum_bevetel, sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE telephely LIKE '%$telephely%' AND "
                  . "(date BETWEEN '$date_start' AND '$date_end') AND torolt_szamla = '0'";

            $result5 = $this->dbconn->query($sql5);
                if ($result5->num_rows > 0) {
                    while ($row5 = $result5->fetch_assoc()) {
                        $data = $row5["sum_bevetel"] ;
                        $jutalek = $row5["sum_jutalek"] ;
                    }
               } else { 
                    $data = 0;
                    $jutalek=0;
               }
            $netto = $data-$jutalek;
            $html .= '<td style="text-align:right;">'.$netto.'</td></tr>';
        
        $html .= '</tbody>';
        }
        
    $html .= '</tabel>';    
     return($html);
    }
    
    public function Riport_3_Allin($riport_date){
       
    $html ="";
    $data =""; // lekérdezett cellaérték
    $date_start = $riport_date.'-1';
    $date_end = $riport_date.'-31';
    $date ="";
    $telephely ="";      
    
    $html .= '<table class="table table-bordered table-condensed" id="riport">';
        $html .= '<thead><tr  class="success"><th colspan="33">'.$date_start.' - '.$date_end.' Időszak bevétel, jutalék, netto bevétel, orvosok-kezelők szerinti bontásban, telephelyenként</th></tr></thead>';
              
        // renfelők szerinti bontás
        for ($s = 0 ; $s < 5; $s++ ){    
            $telephely = $this->office_db[$s];
            $html .= '<thead><tr style="border:3px solid;"><th>'.$this->offices[$s].'</th>';
                
            for ($day = 1; $day < 32 ; $day++ ){
                $color = $day % 7;
                $html .= '<th colspan="3" style= "background-color:'.$this->color_codes[$color].'; text-align:center;">'.$day.'</th>';
                               
                }
                $html .= '<th colspan="3">Összesen</th></tr>';       
                $html  .='<tr><th></th>';
            
            for ($day = 1; $day < 33 ; $day++ ){
                $color = $day % 7;    
                $html .= '<th style="background-color:'.$this->color_codes[$color].'; text-align:center; ">Bevétel</th>'
                            . '<th style="background-color:'.$this->color_codes[$color].'; text-align:center; ">Jutalék</th>'
                            . '<th style="background-color:'.$this->color_codes[$color].'; text-align:center; ">Nettó</th>';
                               
                }
                $html .= '</tr></thead>';       
            


        // fejléc vége 
        
        //telephelyenként kezeéő lista + adatok     
        $sql1 = "SELECT DISTINCT kezelo_neve FROM kezelok_orvosok WHERE kezelo_telephely LIKE '%$telephely%' ORDER BY kezelo_neve ASC " ;
        $result = $this->dbconn->query($sql1);
            if ($result->num_rows > 0) {
                while ($row1 = $result->fetch_assoc()) {
                    $kezelo = $row1["kezelo_neve"];
                    $html .= '<tbody><tr><td>'.$kezelo.'</td>'; 
                   
                    // kezeló napi forgalma 
                    for ($day = 1; $day < 32 ; $day++ ){
                        $color = $day % 7;
                        $date = $riport_date.'-'.$day; 
                        $jutalek = 0;
                        $netto = 0;
                        $data = 0;

                        // bevétel összesen
                        $sql2 = "SELECT sum(bevetel_osszeg) as sum_bevetel, sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE telephely LIKE '%$telephely%' AND "
                              . "date = '$date' AND torolt_szamla = '0' AND kezelo_orvos_id LIKE '%$kezelo%'" ;
                        
                        $result2 = $this->dbconn->query($sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    $data = $row2["sum_bevetel"];
                                    $jutalek = $row2["sum_jutalek"];
                                } 
                            }else {$date = "error"; }
                        //jutalék összesen
                                            
                    
                        $netto = $data - $jutalek;
                        $html .= '<td style="background-color:'.$this->color_codes[$color].'; text-align:right; ">'.$data.'</td>'
                                . '<td style="background-color:'.$this->color_codes[$color].'; text-align:right; ">'.$jutalek.'</td>'
                                . '<td style="background-color:'.$this->color_codes[$color].'; text-align:right; ">'.$netto.'</td>';
                    }        
                    // sor összesen időszaki összesítés
                         $sql3 = "SELECT sum(bevetel_osszeg) as sum_bevetel, sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE telephely LIKE '%$telephely%' AND "
                        . "(date BETWEEN '$date_start' AND '$date_end') AND torolt_szamla = '0' AND kezelo_orvos_id LIKE '%$kezelo%'";

                        $result3 = $this->dbconn->query($sql3);
                            if ($result3->num_rows > 0) {
                                while ($row3 = $result3->fetch_assoc()) {
                                    $row_sum = $row3["sum_bevetel"] ;
                                    $sum_jutalek = $row3["sum_jutalek"] ;
                                }
                            } else {
                                $row_sum = 0;
                                $sum_jutalek =0;
                            }
                                                   
                        $sumnetto = $row_sum - $sum_jutalek;
                                                
                        $html .= '<td style="text-align:right;">'.$row_sum.'</td>'
                                . '<td style="text-align:right;">'.$sum_jutalek.'</td>'
                                . '<td style="text-align:right;">'.$sumnetto.'</td></tr>'  ;   
                        
                    
                }    
            }else{$kezelo = "hiba";}    
        // oszlop összesen
        $html .= '<tr><td style="text-align:center">Összesen:</td>';
        // összesen adatok 
        for ($day = 1; $day < 32 ; $day++ ){
            $color = $day % 7;
            $date = $riport_date.'-'.$day; 
            // bevétel lekérdezés
            $sql4 = "SELECT sum(bevetel_osszeg) as sum_bevetel, sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE telephely LIKE '%$telephely%' AND "
                  . "date = '$date' AND torolt_szamla = '0'";

            $result4 = $this->dbconn->query($sql4);
                if ($result4->num_rows > 0) {
                    while ($row4 = $result4->fetch_assoc()) {
                        $data = $row4["sum_bevetel"] ;
                        $jutalek = $row4["sum_jutalek"] ;
                    }
               } else { 
                    $data = 0;
                    $jutalek=0;
               }
            $netto = $data-$jutalek;
            $html .= '<td style="background-color:'.$this->color_codes[$color].';text-align:right;">'.$data.'</td>'
                    . '<td style="background-color:'.$this->color_codes[$color].';text-align:right;">'.$jutalek.'</td>'
                    . '<td style="background-color:'.$this->color_codes[$color].';text-align:right;">'.$netto.'</td>';
        }       
        //mindösszesen az adott időszak és a telephely függvényében  
            $sql5 = "SELECT sum(bevetel_osszeg) as sum_bevetel, sum(jutalek_osszeg) as sum_jutalek FROM napi_elszamolas WHERE telephely LIKE '%$telephely%' AND "
                  . "(date BETWEEN '$date_start' AND '$date_end') AND torolt_szamla = '0'";

            $result5 = $this->dbconn->query($sql5);
                if ($result5->num_rows > 0) {
                    while ($row5 = $result5->fetch_assoc()) {
                        $data = $row5["sum_bevetel"] ;
                        $jutalek = $row5["sum_jutalek"] ;
                    }
               } else { 
                    $data = 0;
                    $jutalek=0;
               }
            $netto = $data-$jutalek;
            $html .= '<td style="text-align:right;">'.$data.'</td>'
                    . '<td style="text-align:right;">'.$jutalek.'</td>'
                    . '<td style="text-align:right;">'.$netto.'</td>';
        
        $html .= '</tbody>';
        }
        
    $html .= '</tabel>';    
     return($html);
     
        
    }
    
public function Riport_4_MedicalPlus($riport_date){
    
    $date_start = $riport_date.'-1';
    $date_end = $riport_date.'-31';
    
   
    $html = "";
    $html .= '<div id="riport">';
        
    $html .= '<table class="table table-bordered id="riport">
                <thead>
                    <tr>Medical Plusz Kft. havi forgalom :'.$date_start.' - '.$date_end.'</tr>
                    <tr>
                        <th>ID</th>
                        <th>Dátum</th>
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
                        <th>Pénztárgép Slip</th>
                        <th>Rögzítő</th>
                        <th>Telephely</th>
                     </tr>
                </thead>
                <tbody>';
        
    // az aktuális napi bevételek lekérdezése
        
            $sql = "SELECT * FROM napi_elszamolas WHERE (date BETWEEN '$date_start' AND '$date_end') AND torolt_szamla = '0' AND  kezelo_orvos_id = 'Medical Plus Kft.' ORDER BY telephely ";
            $result = $this->dbconn->query($sql);    

            if ($result->num_rows > 0) {
            // output data of each row
                while ($row = $result->fetch_assoc()) {
                    
                    $html .= "<tr><td>"
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
                $html .= "<tr><td>Nincs rögzített adat</td></tr>";
            }
      
        $html .= "</tbody></table></div>";
    
    return($html);    

}


// kp kartner bevételek és kiadások tétele kimutatása
public function Riport_5_kppartner($riport_date){
    
    set_time_limit(0);
    ini_set('max_execution_time', 3000);

    
    $html = "";
    $html = $riport_date .'- havi kp partnet kimutatás';
    
        
    $html ="";
    $data =""; // lekérdezett cellaérték
    $date_start = $riport_date.'-1';
    $date_end = $riport_date.'-31';
    $date ="";
    $telephely ="";      
    
    $html .= '<table class="table table-bordered table-condensed" id="riport">';
        $html .= '<thead><tr  class="success"><th colspan="33">'.$date_start.' - '.$date_end.' KP partner riport orvosok-kezelők szerinti bontásban</th></tr></thead>';
              
        // renfelők szerinti bontás
        for ($s = 0 ; $s < 5; $s++ ){    
            //$telephely = $this->office_db[$s];
            $telephely ="";
            $html .= '<thead><tr style="border:3px solid;"><th>'.$telephely.'</th>';
                
            for ($day = 1; $day < 32 ; $day++ ){
                $color = $day % 7;
                $html .= '<th colspan="3" style= "background-color:'.$this->color_codes[$color].'; text-align:center;">'.$day.'</th>';
                               
                }
                $html .= '<th colspan="3">Összesen</th></tr>';       
                $html  .='<tr><th></th>';
            
            for ($day = 1; $day < 33 ; $day++ ){
                $color = $day % 7;    
                $html .= '<th style="background-color:'.$this->color_codes[$color].'; text-align:center; ">+ Kp partner</th>'
                            . '<th style="background-color:'.$this->color_codes[$color].'; text-align:center; ">- Kp kivét</th>'
                            . '<th style="background-color:'.$this->color_codes[$color].'; text-align:center; ">= Marad</th>';
                               
                }
                $html .= '</tr></thead>';       
            


        // fejléc vége 
        
        //telephelyenként kezeéő lista + adatok     
        $sql1 = "SELECT DISTINCT kezelo_neve FROM kezelok_orvosok WHERE kezelo_telephely LIKE '%$telephely%' ORDER BY kezelo_neve ASC " ;
        $result = $this->dbconn->query($sql1);
            if ($result->num_rows > 0) {
                while ($row1 = $result->fetch_assoc()) {
                    $kezelo = $row1["kezelo_neve"];
                    $html .= '<tbody><tr><td>'.$kezelo.'</td>'; 
                    $summrow=0;
                    $sumkpkivet=0;
                    // kezeló napi forgalma 
                    for ($day = 1; $day < 32 ; $day++ ){
                        $color = $day % 7;
                        $date = $riport_date.'-'.$day; 
                        $kpkivet = 0;
                        $kpnetto = 0;
                        $kppartner = 0;
                       

                        // bevétel összesen
                        $sql2 = "SELECT sum(bevetel_osszeg) as sum_bevetel FROM napi_elszamolas WHERE telephely LIKE '%$telephely%' AND "
                              . "date = '$date' AND torolt_szamla = '0' AND kezelo_orvos_id LIKE '%$kezelo%' AND  bevetel_tipusa_id LIKE '%kp-partner%'" ;
                        
                        $result2 = $this->dbconn->query($sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    $kppartner = $row2["sum_bevetel"];
                                    $summrow += $row2["sum_bevetel"];
                                    //$jutalek = $row2["sum_jutalek"];
                                } 
                            }else {$date = "error"; }
                        //kp kive az aditt napona kiválasztott kezelőnél
                            
                         $sql3 = "SELECT sum(kivet_osszeg) as osszeg FROM kp_kivet WHERE kivet_telephely LIKE '%$telephely%' AND "
                              . "kivet_datum = '$date' AND kivet_torolve = '0' AND kivet_atvevo LIKE '%$kezelo%'" ;
                        
                        $result3 = $this->dbconn->query($sql3);
                            if($result3->num_rows > 0){
                                while($row2 = $result3->fetch_assoc()){
                                    $kpkivet = $row2["osszeg"];
                                    $sumkpkivet += $row2["osszeg"];
                                    //$jutalek = $row2["sum_jutalek"];
                                } 
                            }else {$kpkivet = "error"; }
                        //kp kive az aditt napona kiválasztott kezelőnél    
                            
                                   
                    
                        $kpnetto = $kppartner - $kpkivet;
                        $html .= '<td style="background-color:'.$this->color_codes[$color].'; text-align:right; ">'.$kppartner.'</td>'
                                . '<td style="background-color:'.$this->color_codes[$color].'; text-align:right; ">'.$kpkivet.'</td>'
                                . '<td style="background-color:'.$this->color_codes[$color].'; text-align:right; ">'.$kpnetto.'</td>';
                    }        
                    
                    // sor összesen időszaki összesítés
                                                                       
                        
                        $sumkpnetto = $summrow - $sumkpkivet;                        
                        $html .= '<td style="text-align:right;">'.$summrow.'</td>'
                                . '<td style="text-align:right;">'.$sumkpkivet.'</td>'
                                . '<td style="text-align:right;">'.$sumkpnetto.'</td>'     
                                . '<td style="text-align:right;">'.$kezelo.'</td></tr>'  ; 
                    
                }    
            }else{$kezelo = "hiba";}    
        // oszlop összesen
    
//egyéb kivétek
         $html .= '<tr><td style="text-align:center">Egyéb kivétek:</td>';
        $kpall =0;
        $sumkpall =0;
        $kpallkivet =0;
        $sumkpallkivet =0;
        $netto =0;
        
        
        for ($day = 1; $day < 32 ; $day++ ){
            $color = $day % 7;
            $date = $riport_date.'-'.$day; 
            // bevétel lekérdezés
                      
            $sql5 = "SELECT sum(kivet_osszeg) as osszeg FROM kp_kivet WHERE kivet_telephely LIKE '%$telephely%' AND kivet_datum = '$date'"
                    . " AND kivet_torolve = '0' AND kivet_atvevo LIKE '%nicsa a listan%'" ;
                        
                        $result3 = $this->dbconn->query($sql5);
                            if($result3->num_rows > 0){
                                while($row2 = $result3->fetch_assoc()){
                                    $kpallkivet = $row2["osszeg"];
                                    $sumkpallkivet += $row2["osszeg"];
                                    //$jutalek = $row2["sum_jutalek"];
                                } 
                            }else {$kpkivet = "error"; }   
               
               
               
            $kpmaradvany = $kpall-$kpallkivet;
            $html .= '<td style="background-color:'.$this->color_codes[$color].';text-align:right;">'.$kpall.'</td>'
                    . '<td style="background-color:'.$this->color_codes[$color].';text-align:right;">'.$kpallkivet.'</td>'
                    . '<td style="background-color:'.$this->color_codes[$color].';text-align:right;">'.$kpmaradvany.'</td>';
        }    

         //mindösszesen az adott időszak függvényében  
         
            $netto = $sumkpall-$sumkpallkivet;
            $html .= '<td style="text-align:right;">'.$sumkpall.'</td>'
                    . '<td style="text-align:right;">'.$sumkpallkivet.'</td>'
                    . '<td style="text-align:right;">'.$netto.'</td><td style="text-align:center">Egyéb kivétek:</td></tr>';


// összesen adatok 
        $html .= '<tr><td style="text-align:center">Összesen:</td>';
        $kpall =0;
        $sumkpall =0;
        $kpallkivet =0;
        $sumkpallkivet =0;
        $netto =0;
        for ($day = 1; $day < 32 ; $day++ ){
            $color = $day % 7;
            $date = $riport_date.'-'.$day; 
            // bevétel lekérdezés
            $sql4 = "SELECT sum(bevetel_osszeg) as sum_bevetel FROM napi_elszamolas WHERE telephely LIKE '%$telephely%' AND "
                              . "date = '$date' AND torolt_szamla = '0' AND bevetel_tipusa_id LIKE '%kp-partner%'" ;

            $result4 = $this->dbconn->query($sql4);
                if ($result4->num_rows > 0) {
                    while ($row4 = $result4->fetch_assoc()) {
                        $kpall = $row4["sum_bevetel"] ;
                        $sumkpall += $row4["sum_bevetel"] ;
                    }
               } else { 
                    $kpall = 0;
                    $sumkpall=0;
               }
            
             $sql5 = "SELECT sum(kivet_osszeg) as osszeg FROM kp_kivet WHERE kivet_telephely LIKE '%$telephely%' AND kivet_datum = '$date' AND kivet_torolve = '0'" ;
                        
                        $result3 = $this->dbconn->query($sql5);
                            if($result3->num_rows > 0){
                                while($row2 = $result3->fetch_assoc()){
                                    $kpallkivet = $row2["osszeg"];
                                    $sumkpallkivet += $row2["osszeg"];
                                    //$jutalek = $row2["sum_jutalek"];
                                } 
                            }else {$kpkivet = "error"; }   
               
               
               
            $kpmaradvany = $kpall-$kpallkivet;
            $html .= '<td style="background-color:'.$this->color_codes[$color].';text-align:right;">'.$kpall.'</td>'
                    . '<td style="background-color:'.$this->color_codes[$color].';text-align:right;">'.$kpallkivet.'</td>'
                    . '<td style="background-color:'.$this->color_codes[$color].';text-align:right;">'.$kpmaradvany.'</td>';
        }       
        //mindösszesen az adott időszak függvényében  
         
            $netto = $sumkpall-$sumkpallkivet;
            $html .= '<td style="text-align:right;">'.$sumkpall.'</td>'
                    . '<td style="text-align:right;">'.$sumkpallkivet.'</td>'
                    . '<td style="text-align:right;">'.$netto.'</td><td style="text-align:center">Összesen:</td></tr>';
        
        $html .= '</tbody>';
    
    
    
    
    return($html);    
    
}
}

public function Riport_6_DrAlapKontroll($date){
    
    $html = "";
    $html .= '<div class="container"><table class="table table-condensed" id="riport">
    <thead>
      <tr><td colspan="3"><h2>Orvosok ' .$date. ' alapvizsgálat / kotrollvizsgálat db</h2></td></tr>  
      <tr>
        <th>Orvos neve</th>
        <th>Alapvizsgálatok száma</th>
        <th>Kontrollvizsgálatok száma</th>
      </tr>
    </thead> 
    <tbody>';
     
    $sql = "SELECT DISTINCT kezelo_neve  FROM kezelok_orvosok WHERE kezelo_tipus LIKE 'Orvos' ORDER BY kezelo_neve ASC";
    $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $name = $row["kezelo_neve"];
                $html .= '<tr><td>'.$name.' </td><td>'.$this->dr_havi_vizsgalat($name,$date,"alapvizsgálat").'</td><td>'.$this->dr_havi_vizsgalat($name,$date,"kontroll").'</td></tr>';
            }
        } else {
            $html .= "0 results";
        }
        
    $html .= '</tbody>
            </table></div>';
       
    return $html;
}

public function dr_havi_vizsgalat($name,$date,$type){
    
    $html = "";
    $sql = "SELECT COUNT(id_szamla) as ellatas FROM `napi_elszamolas` WHERE kezelo_orvos_id LIKE '$name' AND date LIKE '%$date%' AND torolt_szamla = '0' AND szolgaltatas_id LIKE '%$type%'";
    $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
               
                $html .= $row["ellatas"];
            }
        } else {
            $html .= "NULL";
        }
    return $html;  
}

//END CLASS
}