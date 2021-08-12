<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gyogytornasz_ripotrtClass
 *
 * @author Andras
 */
class gyogytornasz_ripotrtClass {
    //put your code here
    private $conn;
    private $date;
    
    function __construct(){
         $this->conn = DbConnect();
         $this->date = date('Y-m-d');
    }
    
    function __destruct() {
        mysqli_close($this->conn);
    }
    
    public function Gyt_riport_form(){
        
        $html = "";
         
              
        $html .= '<div class="panel panel-danger" id="HiddenIfPrint">';
            $html .='<div class="panel-heading"><h4>Gyógytronászok riport idöszaki bontásban.</h4></div>';
            $html .= '<div class="panel-body">';
                $html .= '<form  class="form-inline" action="' . $_SERVER['PHP_SELF'] . '?pid=page77" method="post" >'; 
                
                //lekérdezési időszak eleje
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Időszak eleje :</label>
                        <div class=""><input type="date" class="form-control" name="startdate" value = "'.$this->date.'"></div>
                     </div>';
                //lekérdezés időszak vége
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Időszak vége :</label>
                        <div class=""><input type="date" class="form-control"  name="enddate" value = "'.$this->date.'"></div>
                     </div>';
                   
                //telephely
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Gyógytornász :</label>
                        <div class="">';
                        
                        $html .='<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-user"></i></span>';
                            $html .='<select class = "form-control" name = "gyogytornasz">';
                            $html .= '<option value="Takács Viktória"> Takács Viktória </option>';
                            $html .= '<option value="Tatai Krisztina"> Tatai Krisztina </option>';
                            $html .= '<option value="Szabóné Bora Csilla"> Szabóné Bora Csilla </option>';
                            $html .= '</select></div>';
                
                        $html .='</div>
                     </div>';
                        
                     
             
                //gombok
                $html .= '<div class="form-group" style="padding-top:20px;padding-right: 1em;">';
                    $html .= '<label class="control-label"></label>';    
                    $html .='<div class="btn-group">';
                        
                        $html .='<button type="submit" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> Lekérdez</button>';
                        $html .='<a href="#" onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
                        $html .='<a href="#" onclick="copyClipboard()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a>'                        
                        
                        . '</div>'
                . '</div>';        
                $html .= '</form>';
            
            $html .='</div>';
            $html .='<div class="panel-footer">BMM
                </div></div>';
                
            return $html;

    }
        
        
      public function admin_post_gytquery(){
          
          if (isset ($_POST["startdate"]) AND isset ($_POST["enddate"]) AND isset ($_POST["gyogytornasz"]) ){
              
          
              $startdate  = $_POST["startdate"];
              $enddate  = $_POST["enddate"];
              $gyogytornasz  = $_POST["gyogytornasz"];
              $egydijutalek = 0;
              $sumjutalek = 0;
              
               $sql = "SELECT * FROM `napi_elszamolas` WHERE "
                    . "kezelo_orvos_id  = '$gyogytornasz' AND (date BETWEEN '$startdate' AND '$enddate') AND torolt_szamla = '0'";

            $result = $this->conn->query($sql);
            
                    echo'<div class="container">
                                <h2>'.$gyogytornasz.' kimutatása egészségügyi ellátásról </h2>
                                <p>Dátum : '.$startdate.' - '.$enddate.'</p>
                            <table class="table table-bordered" id="riport">
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
                            
                            // jogosultság a jutalék ekszámoláshoz
                            if ($row["jutalek_osszeg"] == 0){
                            $egydijutalek = $this->egyedijutalek($row["kezelo_orvos_id"],$row["szolgaltatas_id"], $row["berlet_adatok"]);
                            $sumjutalek += $egydijutalek;
                            }else{
                                $egydijutalek = $row["jutalek_osszeg"];
                                $sumjutalek += $egydijutalek;
                                
                            }
                            
                            
                            
                            echo "<tr><td>"
                            . $row["date"] . "</td><td> "
                            . $row["paciens_neve"] . "</td><td> "
                            . $row["kezelo_orvos_id"] . "</td><td>"
                            . $row["szolgaltatas_id"] . "</td><td>"
                            . $row["bevetel_tipusa_id"] . "</td><td>"
                            . $row["ep_tipus"] . "</td><td>"
                            . $row["bevetel_osszeg"] . "</td><td>"
                            . $egydijutalek . "</td><td>"
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
                     echo '<tr><td></td><td>Összes jutalék:</td><td></td><td></td><td></td><td></td><td></td> <td>'.$sumjutalek,'</td></tr>';

                    echo "</tbody></table>";
                  
        }            
              

      }  
    
    // jutalékolási szabályok szolgáltatás cimkék alapján  
    private function egyedijutalek($kezelo,$szolgaltatas,$berlet){
        $jutalek = 0;
       // $gym60 = "Gyógymasszázs 60 perc";
        
        
        if ($kezelo == 'Takács Viktória'){
            //jutalék kiszámítás
            if (strpos($szolgaltatas,"Gyógymasszázs 60 perc") !== FALSE) {$jutalek = 1000;}
            if (strpos($szolgaltatas,"Gyógymasszázs 50 perc") !== FALSE) {$jutalek = 1000;}
            if (strpos($szolgaltatas,"Gyógymasszázs 30 perc") !== FALSE) {$jutalek = 500;} 
            if (strpos($szolgaltatas,"Gyógymasszázs 25 perc") !== FALSE) {$jutalek = 500;}
            if (strpos($szolgaltatas,"90 perc") !== FALSE) {$jutalek = 1500;}
          
            if (strpos($szolgaltatas,"1 alk 55 perc") !== FALSE) {$jutalek = 1000;}
            if (strpos($szolgaltatas,"1 alk 25 perc") !== FALSE) {$jutalek = 500;}
        
            // bérlet felhazsnáls 
            if (strpos($szolgaltatas,"No.:") !== FALSE AND strpos($szolgaltatas,"60 perc") !== FALSE) {$jutalek = 1000;}
            if (strpos($szolgaltatas,"No.:") !== FALSE AND strpos($szolgaltatas,"50 perc") !== FALSE) {$jutalek = 1000;}
            if (strpos($szolgaltatas,"No.:") !== FALSE AND strpos($szolgaltatas,"55 perc") !== FALSE) {$jutalek = 1000;}
            if (strpos($szolgaltatas,"No.:") !== FALSE AND strpos($szolgaltatas,"30 perc") !== FALSE) {$jutalek = 500;}
            if (strpos($szolgaltatas,"No.:") !== FALSE AND strpos($szolgaltatas,"25 perc") !== FALSE) {$jutalek = 500;}
            // bérlet Eladás nicsn jutaléka 
            if (strpos($szolgaltatas,"Eladás") !== FALSE) {$jutalek = 0;}
            // fizikoterápia
            if (strpos($szolgaltatas,"Fizikoterápia 30 perc") !== FALSE) {$jutalek = 1000;}
            if (strpos($szolgaltatas,"Fizikoterápia 25 perc") !== FALSE) {$jutalek = 1000;}
        }
        
        
      
            
         if ($kezelo == 'Tatai Krisztina'){
            //jutalék kiszámítás
            if (strpos($szolgaltatas,"15 perc") !== FALSE) {$jutalek = 500;}
            if (strpos($szolgaltatas,"25 perc") !== FALSE) {$jutalek = 1000;}  
            if (strpos($szolgaltatas,"30 perc") !== FALSE) {$jutalek = 1000;}  
            if (strpos($szolgaltatas,"50 perc") !== FALSE) {$jutalek = 2000;}
            if (strpos($szolgaltatas,"60 perc") !== FALSE) {$jutalek = 2000;}
            
            if (strpos($szolgaltatas,"1 alk 55 perc") !== FALSE) {$jutalek = 2000;}
            if (strpos($szolgaltatas,"1 alk 25 perc") !== FALSE) {$jutalek = 1000;}
            if (strpos($szolgaltatas,"1 alk 15 perc") !== FALSE) {$jutalek = 500;}
            // bérlet felhazsnáls 
            if (strpos($szolgaltatas,"No.:") !== FALSE AND strpos($szolgaltatas,"60 perc") !== FALSE) {$jutalek = 2000;}
            if (strpos($szolgaltatas,"No.:") !== FALSE AND strpos($szolgaltatas,"55 perc") !== FALSE) {$jutalek = 2000;}
            if (strpos($szolgaltatas,"No.:") !== FALSE AND strpos($szolgaltatas,"50 perc") !== FALSE) {$jutalek = 2000;}
            if (strpos($szolgaltatas,"No.:") !== FALSE AND strpos($szolgaltatas,"30 perc") !== FALSE) {$jutalek = 1000;}
            if (strpos($szolgaltatas,"No.:") !== FALSE AND strpos($szolgaltatas,"25 perc") !== FALSE) {$jutalek = 1000;}
            // bérlet Eladás nicsn jutaléka 
            if (strpos($szolgaltatas,"Eladás") !== FALSE) {$jutalek = 0;}
               
            }    
        
         if ($kezelo == 'Szabóné Bora Csilla'){
            //jutalék kiszámítás
            //if (strpos($szolgaltatas,"Gyógytorna 1 alk 55 perc") !== FALSE) {$jutalek = 7000;}
                 
            if (strpos($szolgaltatas,"Gyógytorna 1 alk Online 55 perc") !== FALSE) {$jutalek = 4500;}
           
            
            // bérlet felhazsnáls 
            if (strpos($szolgaltatas,"No.:") !== FALSE AND strpos($szolgaltatas,"Gyógytorna bérlet 3 alk Online 55 perc") !== FALSE) {$jutalek = 4000;}
            if (strpos($szolgaltatas,"No.:") !== FALSE AND strpos($szolgaltatas,"Gyógytorna bérlet 8 alk Online 55 perc") !== FALSE) {$jutalek = 3500;}
            
            // bérlet Eladás nicsn jutaléka 
            if (strpos($szolgaltatas,"Eladás") !== FALSE) {$jutalek = 0;}
               
            }        
       
        
        
        return $jutalek;
    }
       
    
}
