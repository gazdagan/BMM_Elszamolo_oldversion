<?php

/**
 * Description of HaziPenztarClass
 * Házipénztárt kezelő osztály  
 * @author Andras
 */
class HaziPenztarClass {
    //put your code here
    
    private $date; 
    private $dbconn;
    private $telephely;
    private $pgrendelo;
    private $recepcios;
    private $telephelycim; 
    private $bev_dbnames;
    private $kiad_dbnames;
    private $month;
    public $pg_napizaras_id;
    private $pg_afa5; 
    private $pg_afa27; 
    private $pg_TAM; 
    
    
    //időszaki pénztárjelentés alapadatok
    private $sumbevetel;
    private $sumkiadas;
    private $nyitoegyenleg;
    private $egyenleg;



    public function __construct() {
        $this->date = date("Y.m.d");  
        $this->dbconn = DbConnect();
        $this->month = date("Y-m");
        $this->sumbevetel = 0;
        $this->sumkiadas = 0;
        $this->nyitoegyenleg = 0; 
        $this->egyenleg=0;
        $this->pg_napizaras_id=0;
        $this->cegnev1 ='error 1';
        $this->cegnev2 ='error 2';
        $this->adoszam ='error 3';
        
        if (isset($_SESSION['set_telephely'])) {

            $this->telephely = $_SESSION['set_telephely'];
            
            switch ($this->telephely) {
                case "BMM":
                    $this->pgrendelo = "Buda pénztár";
                    $this->cegnev1 = 'Medport Kft.'; 
                    $this->cegnev2 = '1114 Budapest, Bartók Béla út 11-13.';
                    $this->adoszam = '22941967-2-43';
                    break;
                case "Fizio":
                    $this->pgrendelo = "Fizio pénztár";
                    $this->cegnev1 = 'Medport Kft.'; 
                    $this->cegnev2 = '1114 Budapest, Bartók Béla út 11-13.';
                    $this->adoszam = '22941967-2-43';
                    break;
                case "P70":
                    $this->pgrendelo = "Pannónia 70 pénztár";
                    $this->cegnev1 = 'Medport Kft.'; 
                    $this->cegnev2 = '1114 Budapest, Bartók Béla út 11-13.';
                    $this->adoszam = '22941967-2-43';
                    break;
                case "P72":
                    $this->pgrendelo = "Pannónia 72 pénztár";
                    $this->cegnev1 = 'Medport Kft.'; 
                    $this->cegnev2 = '1114 Budapest, Bartók Béla út 11-13.';
                    $this->adoszam = '22941967-2-43';
                    break;
                case "Óbuda":
                    $this->pgrendelo = "Óbuda pénztár";
                    $this->cegnev1 = 'Medical Plus Kft.'; 
                    $this->cegnev2 = '1037 Budapest, Bokor utca 15-21. földszint 19.';
                     $this->adoszam = '14833944-2-41';
                    break;
                case "Scolinea":
                    $this->pgrendelo = "Scolinea pénztár";
                    break;
                case "Lábcentrum":
                    $this->pgrendelo = "Lábcentrum pénztár";
                    $this->cegnev1 = 'Medport Kft.'; 
                    $this->cegnev2 = '1114 Budapest, Bartók Béla út 11-13.';
                    $this->adoszam = '22941967-2-43';
                    break;
                case "SMM":
                    $this->pgrendelo = "Salgó move pénztár";
                    $this->cegnev1 = 'Salgó-Move Kft.'; 
                    $this->cegnev2 = '1144 Budapest, Kerepesi út 96. 10. emelet 41.';
                    $this->adoszam = '27951473-2-42';
                    break;
                default:
                    $this->pgrendelo = "Medport Kft.";
            }
                   
        } else {
            $this->telephely = "Error telephely";
        }
        
//        if ($this->telephely == 'Óbuda'){
//            $this->cegnev1 = 'Medical Plus Kft.'; 
//            $this->cegnev2 = '1037 Budapest, Bokor utca 15-21. földszint 19.';
//            $this->adoszam = '14833944-2-41';
//        }
//        else {
//            $this->cegnev1 = 'Medport Kft.'; 
//            $this->cegnev2 = '1114 Budapest, Bartók Béla út 11-13.';
//            $this->adoszam = '22941967-2-43';  }
//        
    
        
        
        
        if (isset($_SESSION['real_name'])) {

            $this->recepcios = $_SESSION['real_name'];
        } else {
            $this->recepcios = "Error recepcio";
        }
        
        $this->telephelycim = array("BMM"=>"BMM - Budafoki út 15. Fsz.6.","Fizio"=>"Fizio - Budafoki út 15. 2.em","P70"=>"P70 - Pannónia utca 70.","P72"=>"P72 - Pannónia utca 72.","Óbuda"=>"Óbuda - Bokor utca 15-21.","Lábcentrum"=>"Lábcentrum - Budafoki út 15.","Scolinea"=>"Scolinea - Haris köz 6.","SMM"=>"SMM - Salgótarján Kassai út 14."); 
        $this->bev_dbnames = array("BMM"=>"bev_pbiz_Bmm","Fizio"=>"bev_pbiz_Fizio","P70"=>"bev_pbiz_P70","P72"=>"bev_pbiz_P72","Óbuda"=>"bev_pbiz_Obuda","Lábcentrum"=>"bev_pbiz_Lc","Scolinea"=>"bev_pbiz_Scolinea","SMM"=>"bev_pbiz_SMM");
        $this->kiad_dbnames = array("BMM"=>"ki_pbiz_Bmm","Fizio"=>"ki_pbiz_Fizio","P70"=>"ki_pbiz_P70","P72"=>"ki_pbiz_P72","Óbuda"=>"ki_pbiz_Obuda","Lábcentrum"=>"ki_pbiz_Lc","Scolinea"=>"ki_pbiz_Scolinea","SMM"=>"ki_pbiz_SMM");
        $this->beveteli_jogcim = array("BMM"=>"BMM orvosi kp bevétel","Fizio"=>"Fizio napi kp bevétel","P70"=>"P70 napi kp bevétel","P72"=>"P72 napi kp bevétel","Óbuda"=>"Óbudai napi kp bevétel","Lábcentrum"=>"Lábcentrum napi kp bevétel","SMM"=>"SMM napi kp bevétel");
    }
    
    function __destruct() {
        mysqli_close($this->dbconn);
    }
    private function make_soraszam($number){
        
        $sorszam = "";
        
        if (strlen($number) == 5) {$sorszam = $number;}
        if (strlen($number) == 4) {$sorszam = '0'.$number;}
        if (strlen($number) == 3) {$sorszam = '00'.$number;}
        if (strlen($number) == 2) {$sorszam = '000'.$number;}
        if (strlen($number) == 1) {$sorszam = '0000'.$number;}
        
        
        return ($sorszam);
    }
            
            
    public function Napi_pg_elszamolas_table(){
    
        $pgzars_date= "";
        $pg_zarasszam = "";
        $hiba1szam= "";
        $hiba1afa= "";
        $hiba1osszeg= 0;
        $hiba2szam= "";
        $hiba2afa= "";
        $hiba2osszeg= 0;
        $hiba3szam= "";
        $hiba3afa= "";
        $hiba3osszeg= 0;
        $kp_osszes= 0;
        $cegnev = '';
        
      
        if ($this->pg_napizaras_id != 0){
        $id = $this->pg_napizaras_id;
          $sql = "SELECT * FROM pgzarasok WHERE pgzaras_id = '$this->pg_napizaras_id'";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        
                        $pgzars_date =  $row["pgzaras_date"];
                        $pg_zarasszam = $row["pg_zarasszam"]; 
                        $this->pg_afa5 = $row["pg_afa5"]; 
                        $this->pg_afa27 = $row["pg_afa27"]; 
                        $this->pg_TAM = $row["pg_TAM"]; 
                        $hiba1szam = $row["hiba1szam"]; 
                        $hiba1afa= $row["hiba1afa"];
                        $hiba1osszeg= $row["hiba1osszeg"];
                        $hiba2szam= $row["hiba2szam"];
                        $hiba2afa= $row["hiba2afa"];
                        $hiba2osszeg= $row["hiba2osszeg"];
                        $hiba3szam= $row["hiba3szam"];
                        $hiba3afa= $row["hiba3afa"];
                        $hiba3osszeg= $row["hiba3osszeg"];
                        $kp_osszes= $row["kp_osszes"]; 
                        
                        $this->date = date("Y.m.d",strtotime($pgzars_date));
                        
                        $this->telephely = $row["pg_telephely"]; 
                        
                         switch ($this->telephely) {
                            case "BMM":
                                $this->pgrendelo = "Buda pénztár";
                                break;
                            case "Fizio":
                                $this->pgrendelo = "Fizio pénztár";
                                break;
                            case "P70":
                                $this->pgrendelo = "Pannónia 70 pénztár";
                                break;
                            case "P72":
                                $this->pgrendelo = "Pannónia 72 pénztár";
                                break;
                            case "Óbuda":
                                $this->pgrendelo = "Óbuda pénztár";
                                break;
                            case "Scolinea":
                                $this->pgrendelo = "Scolinea pénztár";
                                break;
                            case "Lábcentrum":
                                $this->pgrendelo = "Lábcentrum pénztár";
                                break;
                            default:
                                $this->pgrendelo = "Medport Kft.";
                        }
                 
                    }
                } else {
                    
                    $pg_zarasszam = "ERROR No Results /" .$id. "/";
                     
                }  
        
        }else{ $this->Napi_Afa_Sum();}
        
        if ($this->telephely == 'Óbuda'){$cegnev = 'Medical Plusz Kft.';} else {$cegnev = 'Medport Kft.';}
        
        
        $html = "";
       
        $html .='<table class="waffle" cellspacing="0" cellpadding="0">
   
   <tbody id="HTMLtoPDF">
      <tr style="height:20px;">
         <td class="s2" style="border-right:none;"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s3" colspan="3">'.$cegnev.'</td>
         
        <td class="s3" colspan="4">'.$this->pgrendelo.'</td>
         
         <td class="s3" colspan="3">Napi elszámolás</td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s0"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s1"></td>
         <td class="s3"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s2">Dátum:</td>
         <td class="s3" colspan="2"><input type="text" value="'.$this->date.'"></td>
         <td class="s0"></td>
         <td class="s2" colspan="4">Napi zárás sorszáma: </td>
         <td class="s3" colspan="2"><input type="text" name="pg-zaras-szama" id="pg-zaras-szama" placeholder="Zárás sorszáma"  style="background-color:#c2d69b;" value="'.$pg_zarasszam.'" required></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s3"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s3" colspan="10">Napi zárás összesen:</td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0">Adókulcs</td>
         <td class="s1">Összeg</td>
         <td class="s0">Tételszám:</td>
         <td class="s2" colspan="2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s4">A-04.76%</td>
         <td class="s3"><input type="number" id="afa5" name="pg-zaras-afa5" placeholder="A-04.76%" onkeyup="sum_napi_forg()" value = "'.$this->pg_afa5.'" style="background-color:#c2d69b;"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s4">C-21.26%</td>
         <td class="s3"><input type="number" id="afa27" name="pg-zaras-afa27" placeholder="C-21.26%" onkeyup="sum_napi_forg()" value = "'.$this->pg_afa27.'" style="background-color:#c2d69b;"></td>
         <td class="s0"></td>
         <td class="s0">T3851</td>
         <td class="s2">K4670</td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s4">E-AM</td>
         <td class="s3"><input type="number" id="TAM" name="pg-zaras-tam" placeholder="E-AM" onkeyup="sum_napi_forg()" value = "'.$this->pg_TAM.'" style="background-color:#c2d69b;"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">K4674</td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s6">NAPI FORGALOM</td>
         <td class="s3"><input id="sum_pg_forg" type="number" name="sum_pg_forg"  value = "0" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">K9112</td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s3">K9211</td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s3" colspan="10">Napi készpénz bevételt csökkentő tételek:</td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s3"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s3" colspan="10">(1) Hibásan rögzített tételek</td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td class="s8"></td>
         <td class="s9 softmerge">
            <div class="softmerge-inner" style="width: 118px; left: -16px;">Számlaszám</div>
         </td>
         <td class="s10"></td>
         <td class="s10">adókulcs</td>
         <td class="s0"></td>
         <td class="s1">összeg</td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td class="s2"></td>
         <td class="s3"><input id="hiba_1_txt" type="text" name="hiba_1_txt" value = "'.$hiba1szam.'" ></td>
         <td class="s2"></td>
         <td class="s3"><select id="hiba_1_afa">
                            <option value=""></option>
                            <option value="5">5 %</option>
                            <option value="27">27 %</option>
                            <option value="TAM">TAM</option>
                        </select></td>
         <td class="s2"></td>
         <td class="s3"><input type="number" id="hiba_1_osszeg" name="hiba_1_osszeg" onkeyup="sum_levonasok()" value = "'.$hiba1osszeg.'"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s0"></td>
         <td class="s2"></td>
         <td class="s3"><input id="hiba_2_txt" type="text" name="hiba_2_txt" value = "'.$hiba2szam.'"></td>
         <td class="s2"></td>
         <td class="s3"><select id="hiba_2_afa">
                            <option value=""></option>
                            <option value="5">5 %</option>
                            <option value="27">27 %</option>
                            <option value="TAM">TAM</option>
                        </select></td>
         <td class="s2"></td>
         <td class="s3"><input type="number" id="hiba_2_osszeg" name="hiba_2_osszeg" onkeyup="sum_levonasok()" value = "'.$hiba2osszeg.'"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s1"></td>
         <td class="s3"></td>
         <td class="s3"><input id="hiba_3_txt" type="text" name="hiba_3_txt" value = "'.$hiba3szam.'"></td>
         <td class="s3"></td>
         <td class="s3"><select id="hiba_3_afa">
                            <option value=""></option>    
                            <option value="5">5 %</option>
                            <option value="27">27 %</option>
                            <option value="TAM">TAM</option>
                        </select></td>
         <td class="s3"></td>
         <td class="s3"><input type="number" id="hiba_3_osszeg" name="hiba_3_osszeg" onkeyup="sum_levonasok()" value = "'.$hiba3osszeg.'"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s3"></td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s3" colspan="10">(2) Bankkártyás fizetés</td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s11"></td>
         <td class="s7"><input type="number" id="bk_fiz" name="bk_fiz" value = "'.$this->bk_fiz().'" ></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s3"></td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s3" colspan="10">(3) Egésszégkártyás fizetés</td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">Allianz</td>
         <td class="s3"><input type="number" id="ep_fiz_alliance" name="ep_fiz_alliance" value = "'.$this->ep_fiz("Allianz").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">Dimenzió</td>
         <td class="s3"><input type="number" id="ep_fiz_dimenzio" name="ep_fiz_dimenzio" value = "'.$this->ep_fiz("Dimenzió").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">Generali</td>
         <td class="s3"><input type="number" id="ep_fiz_generali" name="ep_fiz_generali" value = "'.$this->ep_fiz("Generali").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">Honvéd</td>
         <td class="s3"><input type="number" id="ep_fiz_honved" name="ep_fiz_honved" value = "'.$this->ep_fiz("Honvéd").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">Medicina</td>
         <td class="s3"><input type="number" id="ep_fiz_medicina" name="ep_fiz_medicina" value = "'.$this->ep_fiz("Medicina").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">MKB</td>
         <td class="s3"><input type="number" id="ep_fiz_MKB" name="ep_fiz_MKB" value = "'.$this->ep_fiz("MKB").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">Navosz</td>
         <td class="s3"><input type="number" id="ep_fiz_navosz" name="ep_fiz_navosz" value = "'.$this->ep_fiz("NAVOSZ").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">OTP</td>
         <td class="s3"><input type="number" id="ep_fiz_otp" name="ep_fiz_otp" value = "'.$this->ep_fiz("OTP").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">Patika</td>
         <td class="s3"><input type="number" id="ep_fiz_patika" name="ep_fiz_patika" value = "'.$this->ep_fiz("Patika").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">Prémium</td>
         <td class="s3"><input type="number" id="ep_fiz_premium" name="ep_fiz_premium" value = "'.$this->ep_fiz("Premium").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">Tempo</td>
         <td class="s3"><input type="number" id="ep_fiz_tempo" name="ep_fiz_tempo" value = "'.$this->ep_fiz("Tempo").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">Új Pillér</td>
         <td class="s3"><input type="number" id="ep_fiz_ujpiller" name="ep_fiz_ujpiller" value = "'.$this->ep_fiz("Új Pillér").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2">Vasutas</td>
         <td class="s3"><input type="number" id="ep_fiz_vasutas" name="ep_fiz_vasutas" value = "'.$this->ep_fiz("Vasutas").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s3">Vitamin</td>
         <td class="s3"><input type="number" id="ep_fiz_vitamin" name="ep_fiz_vitamin" value = "'.$this->ep_fiz("Vitamin").'" readonly></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"><input type="hidden" id="ep_fiz_all" name="ep_fiz_all" value = "'.$this->ep_fiz("all").'" readonly></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s0"></td>
         <td></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
         <td class="s3"></td>
         <td class="s3"></td>
         <td class="s0"></td>
         <td class="s0"></td>
         <td class="s2"></td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s3"></td>
         <td class="s3"></td>
         <td class="s3"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s3"></td>
      </tr>
      
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s3" colspan="10">(B) Összes levonás (1) + (2) + (3)</td>
      </tr>
      <tr style="height:20px;">
         
         <td class="s2"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s11"></td>
         <td class="s7"><input type="number" id="sum_levonas" type="number" name="sum_levonas" readonly value="0"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s3"></td>
      </tr>
      <tr style="height:20px;">
        
         <td class="s2"></td>
         <td class="s3" colspan="10"><span style="font-size:10pt;font-family:Arial;font-weight:bold;">Összes készpénz</span><span style="font-size:10pt;font-family:Arial;"> (A) - (B)</span></td>
      </tr>
      <tr style="height:20px;">
         <td class="s2"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s11"></td>
         <td class="s7"><input type="number" id="kp_osszes" type="number" name="kp_osszesen" readonly value="'.$kp_osszes.'"></td>
         <td class="s1"></td>
         <td class="s1"></td>
         <td class="s3"></td>
      </tr>
   </tbody>
</table>';        
     return ($html);   
        
    }
    
    private function AfaCodeToTxt($code){
        $txt = "erroe afa";
        
        switch ($code) {
            case "1":
                $txt = "5 %";
                break;
            case "2":
                $txt = "27%";
                break;
            case "3":
                $txt = "TAM";
                break;
            default:
                $txt = "erroe afa";
        }
        
        
        return $txt;
    }
    
    //bankkártyás fizetési módok
    public function bk_fiz(){
        $bkfiz = 0;
        
                // ósszesített összegek
            $sql1 = "SELECT sum(bevetel_osszeg) as sum_kp_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                      . "date = '$this->date' AND torolt_szamla = '0' "
                      . "AND ( bevetel_tipusa_id = 'bankkártya-nyugta' OR bevetel_tipusa_id = 'bankkártya-számla' )";

            $result = $this->dbconn->query($sql1);
              if ($result->num_rows > 0) {

                  while ($row1 = $result->fetch_assoc()) {
                      $bkfiz = $row1["sum_kp_bevetel"];
                        if ($bkfiz == ''){$bkfiz = 0;}
                  }
              } else {
                  $bkfiz = 0;
              }
        
        return ($bkfiz);
    }
    
    public function ep_fiz($ep_tipe){
        $epfiz = 0;
        
        if ($ep_tipe == 'all'){
            
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_ep_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND  bevetel_tipusa_id  LIKE '%egészségpénztár%'";
            
        }
        else{
        $sql1 = "SELECT sum(bevetel_osszeg) as sum_ep_bevetel FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                . "date = '$this->date' AND torolt_szamla = '0' "
                . "AND ep_tipus = '$ep_tipe'";
        }
        
        $result = $this->dbconn->query($sql1);
        if ($result->num_rows > 0) {

            while ($row1 = $result->fetch_assoc()) {
                $epfiz = $row1["sum_ep_bevetel"];
                if ($epfiz == ''){$epfiz = 0;}
                
            }
        } else {
            $epfiz = 0;
        }
        
        return ($epfiz);
    }
    
    
   public function beveteli_penzterbizonylat(){
       
    
       
       $html = "";
             // csak a BMM-ben történhet több bizonylat nyomtatás 2018.06.06
			 //if ($this->check_bevpbiz_today() != 'NULL' AND $this->telephely != 'BMM' )
       if ($this->check_bevpbiz_today() != 'NULL'  ) {
           
           $html = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Figyelem!</strong>'. $this->check_bevpbiz_today().'
                    </div>';
           
       }else{
       
      
       
       $maxid =0;
       
       $sql = "SELECT max(bevpbiz_id) as maxid FROM ".$this->bev_dbnames[$this->telephely];
      // $sql = "SELECT max(bizonylat_sorszam) as maxid FROM bev_penztarbiz WHERE telephely = '$this->telephely'";
       $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $maxid = $row["maxid"]+1;
                $maxid = $this->make_soraszam($maxid);  
            }
        } else {
            $maxid = " error";
        }
       
       //kpössszesen az legutolsó pg zárás bizonylatról
       $kp_osszes = $this->Select_Pgzaras_kposszes($this->telephely);
        
       
      
       
       $html .= '<div class="ritz grid-container" >';
       $html .= $this->bev_pbiz_css(); 
       $html .= '<form>
   <table class="waffle" cellspacing="0" cellpadding="0" id ="penztar_bizonylat">
      
      <tbody>
         <tr style="height:19px;">
         
            <td class="s0"  colspan="3">'.$this->cegnev1.'</td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s2 softmerge" >
               <div class="softmerge-inner" style="width: 60px; left: -1px;">Sorszám : </div>
            </td>
            <td class="s3" dir="ltr">B<span id="bizonylat_sorszam">'.$maxid.'</span></td>
         </tr>
         <tr style="height:19px;">
           
            <td class="s4" dir="ltr" colspan="3">'.$this->cegnev2.'</td>
            <td class="s1" dir="ltr" colspan="6">BEVÉTELI PÉNZTÁRBIZONYLAT</td>
            <td class="s4"></td>
            <td class="s3"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s5" colspan="3">'.$this->adoszam.'</td>
            <td class="s6" ></td>
            <td class="s6" colspan="4">'.$this->telephelycim[$this->telephely].'</td>
            <td class="s6" ></td>
            <td class="s7" >Kelt:</td>
            <td class="s8" ><input onkeydown = "EnableWrite(event,this.id)" id="bizonylat_date" type="text" name="bizonylat_date" value="'.$this->date.'" readonly required style ="text-align:left; width:105px"></td>
         </tr>
         <tr style="height:10px;">
           
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s9"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s2" dir="ltr" colspan="3">Pénztár vételezze be az alábbiak szerint  a </td>
            <td class="s7" dir="ltr" colspan="5"><input  type="text" id="bizonylat_nev" placeholder="" value = "'.$this->recepcios.'"/></td>
            <td class="s9" dir="ltr" colspan="3">által (megbízásából) fizetett</td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s9"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s2"  colspan="2"><input type="number" placeholder="000000"/ id="bizonylat_foosszegszam"></td>
            <td class="s9 softmerge">
               <div class="softmerge-inner" style="width: 61px; left: -1px;"> Ft -t, azaz </div>
            </td>
            <td class="s10"  colspan="7"><input  type="text" id="bizonylat_foosszegszoveg" placeholder=""/></td>
            <td class="s9" dir="ltr">forint-t.</td>
         </tr>
         <tr style="height:10px;">
           
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s10"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s11" colspan="2">Készpénzforgalmi jogcím</td>
            <td class="s11" colspan="2">Bizonylatszám</td>
            <td class="s11" colspan="2">Bizonylat kelte</td>
            <td class="s11" colspan="3">Szöveg</td>
            <td class="s11" colspan="2">Összeg</td>
         </tr>';
       
        // első sor a bizonylatösszesítőn tartalmazza a pg zárás főösszegét
       $jogcim = "";
       if ($this->telephely != 'BMM'){$jogcim = $this->beveteli_jogcim[$this->telephely];} else {$jogcim = "";}
       
       
       $html .= '<tr style="height:19px;">           
            <td class="s10" colspan="2"><input  style=""  type="text" value="'.$jogcim.'"/></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" "/></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  id="date0" type="text" onfocus="today_date(this.id)"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder=""/></td>
            <td class="s10" colspan="2" style ="padding-top:4px;" onkeyup="bizonylat_kitolt()"><input style="width:152px;" type="number" placeholder="" value="'.$kp_osszes.'"/><label for="input">Ft</label></td>
        </tr>';
       
       $lines =8;
        
		if ( $this->telephely != 'Scolinea' /*AND $this->telephely != 'BMM' */){$lines =8;} else {$lines = 30;}  // ha több sor kell
        // BMM  scolinea 30 sor 
       
        for ($i=1;$i<$lines;$i++){
             $id = 'date'.$i;
         $html .= '<tr style="height:19px;">           
            <td class="s10" colspan="2"><input  style=""  type="text" placeholder=""/></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" "/></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  id="'.$id.'" type="text" onfocus="today_date(this.id)"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder=""/></td>
            <td class="s10" colspan="2" style ="padding-top:4px;" onkeyup="bizonylat_kitolt()"><input style="width:152px;" type="number" placeholder="" value=""/><label for="input">Ft</label></td>
        </tr>';
         }     
        
         $html .= '<tr style="height:25px;">
            
            <td class="s12"  colspan="2" rowspan="2">Kiállító:</td>
            <td class="s12"  colspan="2" rowspan="2">Ellenör:</td>
            <td class="s12"  colspan="2" rowspan="2">Utalványozó:</td>
            <td class="s13"  rowspan="2">Melléklet:</td>
            <td class="s14"  colspan="2" rowspan="2"><input style="width:95px;" type="number" id="bizonylat_melleklet" placeholder=""><label for="input">db</label></td>
            <td class="s15" >Kerekítés:</td>
            <td class="s16 ">
               <input style="width:93px;" type="number" id="bizonylat_kerekites" placeholder=""/><label for="input">Ft</label>
            </td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s17" >Összesen:</td>
            <td class="s16 softmerge" style="border-bottom:1px solid;">
               <input style="width:93px;" type="number"  id="bizonylat_osszesen" placeholder=""><label for="input">Ft</label>
            </td>
         </tr>
         <tr style="height:50px; padding-bottom: 30px;">
            
            <td class="s12"  colspan="2" rowspan="2" >Könyvelő:</td>
            <td class="s12"  colspan="2" rowspan="2" >Pénztáros:</td>
            <td class="s12"  colspan="2" rowspan="2" >Érvényesítő:</td>
            <td class="s12"  colspan="5" rowspan="2" >Az összeg befizetőjének aláírása:</td>
         </tr>
        
      </tbody>
   </table>
</div>';
       }
  return($html);     
   }
   

   // módosítoot kiadási pénztárbizonylat forma
public function  kiadasi_penztarbizonylat(){
        $html = "";
       // ellenörzés a mai napra készült -e már kiadási pénztárbizonylat bmm kivételi biz lehet több.
       //if ($this->check_kiadpbiz_today() != 'NULL' AND $this->telephely != 'BMM') {
       if ($this->check_kiadpbiz_today() != 'NULL') {
           $html = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Figyelem!</strong>'. $this->check_kiadpbiz_today().'
                    </div>';
       }else{
//             if ($this->telephely == "P72"){
//            // p72 figyelmeztető üzenet
//            $html .= '<div class="alert alert-danger alert-dismissible">
//                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
//                    <strong>Figyelem!</strong> A bizonylaton előre kitöltött összeg tartalmat ellenőrizni kell.
//                    A mai bevételi bizonylatok alapján kell kitölteni ezt a bizonylatot! Nyomtatás előtt X zárd be ezt az ablakot.
//                    </div>';
//            
//       }   
           
       $maxid =0;
       
       $sql = "SELECT max(kiadpbiz_id) as maxid FROM ".$this->kiad_dbnames[$this->telephely];
      // $sql = "SELECT max(bizonylat_sorszam) as maxid FROM kiadasi_penztarbiz WHERE telephely = '$this->telephely'";
       $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $maxid = $row["maxid"]+1;
                $maxid = $this->make_soraszam($maxid); 
            }
        } else {
            $maxid = " error";
        }
       
       $bevetel_osszesen = $this->Select_bevetelipbiz_kposszes($this->telephely);
       
       
     
       
        $html.= '<div class="ritz grid-container">';
        $html .= $this->bev_pbiz_css();
    
      $html .= '<form>
   <table class="waffle" cellspacing="0" cellpadding="0" id ="penztar_bizonylat">
      
      <tbody>
         <tr style="height:19px;">
         
            <td class="s0"  colspan="3">'.$this->cegnev1.'</td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s2 softmerge" >
               <div class="softmerge-inner" style="width: 60px; left: -1px;">Sorszám : </div>
            </td>
            <td class="s3" dir="ltr">K<span id="bizonylat_sorszam">'.$maxid.'</span></td>
         </tr>
         <tr style="height:19px;">
           
            <td class="s4" dir="ltr" colspan="3">'.$this->cegnev2.'</td>
            <td class="s1" dir="ltr" colspan="6">KIADÁSI PÉNZTÁRBIZONYLAT</td>
            <td class="s4"></td>
            <td class="s3"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s5" colspan="3">'.$this->adoszam.'</td>
            <td class="s6" ></td>
            <td class="s6" colspan="4">'.$this->telephelycim[$this->telephely].'</td>
            <td class="s6" ></td>
            <td class="s7" >Kelt:</td>
            <td class="s8" ><input onkeydown = "EnableWrite(event,this.id)" id="bizonylat_date" type="text" name="bizonylat_date" value="'.$this->date.'" readonly required style ="text-align:left; width:105px"></td>
         </tr>
         <tr style="height:10px;">
           
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s9"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s2" dir="ltr" colspan="3">Pénztár fizessen az alábbiak szerint</td>
            <td class="s7" dir="ltr" colspan="5"><input  type="text" id="bizonylat_nev" placeholder="" value = "'.$this->recepcios.'"/></td>
            <td class="s9" dir="ltr" colspan="3">-nak</td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s9"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s2"  colspan="2"><input type="number" placeholder="000000"/ id="bizonylat_foosszegszam"></td>
            <td class="s9 softmerge">
               <div class="softmerge-inner" style="width: 61px; left: -1px;"> Ft -t, azaz </div>
            </td>
            <td class="s10"  colspan="7"><input  type="text" id="bizonylat_foosszegszoveg" placeholder=""/></td>
            <td class="s9" dir="ltr">forint-t.</td>
         </tr>
         <tr style="height:10px;">
           
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s10"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s11" colspan="2">Készpénzforgalmi jogcím</td>
            <td class="s11" colspan="2">Bizonylatszám</td>
            <td class="s11" colspan="2">Bizonylat kelte</td>
            <td class="s11" colspan="3">Szöveg</td>
            <td class="s11" colspan="2">Összeg</td>
         </tr>';
       
        // első sor a bizonylatösszesítőn tartalmazza a pg zárás főösszegét
        $jogcim = 'Átvezetés a főpénztárba';
     
       
       
       $html .= '<tr style="height:19px;">           
            <td class="s10" colspan="2"><input  style=""  type="text" value="'.$jogcim.'"/></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" "/></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  id="date0" type="text" onfocus="today_date(this.id)"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder=""/></td>
            <td class="s10" colspan="2" style ="padding-top:4px;" onkeyup="bizonylat_kitolt()"><input style="width:152px;" type="number" placeholder="" value="'.$bevetel_osszesen.'"/><label for="input">Ft</label></td>
        </tr>';
       
       $lines =8;
       //if ($this->telephely != 'P72'){$lines =8;} else {$lines = 20;}
       // p72 20 sor 
       
        for ($i=1;$i<$lines;$i++){
             $id = 'date'.$i;
         $html .= '<tr style="height:19px;">           
            <td class="s10" colspan="2"><input  style=""  type="text" placeholder=""/></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" "/></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  id="'.$id.'" type="text" onfocus="today_date(this.id)"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder=""/></td>
            <td class="s10" colspan="2" style ="padding-top:4px;" onkeyup="bizonylat_kitolt()"><input style="width:152px;" type="number" placeholder="" value=""/><label for="input">Ft</label></td>
        </tr>';
         }     
        
         $html .= '<tr style="height:25px;">
            
            <td class="s12"  colspan="2" rowspan="2">Kiállító:</td>
            <td class="s12"  colspan="2" rowspan="2">Ellenör:</td>
            <td class="s12"  colspan="2" rowspan="2">Utalványozó:</td>
            <td class="s13"  rowspan="2">Melléklet:</td>
            <td class="s14"  colspan="2" rowspan="2"><input style="width:95px;" type="number" id="bizonylat_melleklet" placeholder=""><label for="input">db</label></td>
            <td class="s15" >Kerekítés:</td>
            <td class="s16 ">
               <input style="width:93px;" type="number" id="bizonylat_kerekites" placeholder=""/><label for="input">Ft</label>
            </td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s17" >Összesen:</td>
            <td class="s16 softmerge" style="border-bottom:1px solid;">
               <input style="width:93px;" type="number"  id="bizonylat_osszesen" placeholder=""><label for="input">Ft</label>
            </td>
         </tr>
         <tr style="height:50px;">
            
            <td class="s12"  colspan="2" rowspan="2">Könyvelő:</td>
            <td class="s12"  colspan="2" rowspan="2">Pénztáros:</td>
            <td class="s12"  colspan="2" rowspan="2">Érvényesítő:</td>
            <td class="s12"  colspan="5" rowspan="2">Az összeg átvevőjének aláírása:</td>
         </tr>
        
      </tbody>
   </table>
</div>';    
        
        
    }
   return ($html);  
}   
   
   public function kiadasi_penztarbizonylat_old(){
       $html = "";
       
       // ellenörzés a mai napra készült -e már kiadási pénztárbizonylat
       if ($this->check_kiadpbiz_today() != 'NULL') {
           
           $html = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Figyelem!</strong>'. $this->check_kiadpbiz_today().'
                    </div>';
           
       }else{
       
        if ($this->telephely == "P72"){
            // p72 figyelmeztető üzenet
            $html .= '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Figyelem!</strong> A bizonylaton előre kitöltött összeg tartalmat ellenőrizni kell.
                    A mai bevételi bizonylatok alapján kell kitölteni ezt a bizonylatot! Nyomtatás előtt X zárd be ezt az ablakot.
                    </div>';
            
        }   
           
       $maxid =0;
       
       $sql = "SELECT max(kiadpbiz_id) as maxid FROM ".$this->kiad_dbnames[$this->telephely];
      // $sql = "SELECT max(bizonylat_sorszam) as maxid FROM kiadasi_penztarbiz WHERE telephely = '$this->telephely'";
       $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $maxid = $row["maxid"]+1;
                $maxid = $this->make_soraszam($maxid); 
            }
        } else {
            $maxid = " error";
        }
       
       $befetel_osszesen = $this->Select_bevetelipbiz_kposszes($this->telephely);
       
        $html.= '<div class="ritz grid-container">';
        $html .= $this->bev_pbiz_css();
        $html .= '<table class="waffle" cellspacing="0" cellpadding="0" id ="penztar_bizonylat">
        <tbody>
         <tr style="height:20px;">
          
            <td class="s0" colspan="3">Medpot Kft. - Budafoki út.</td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s2 softmerge" >
               <div class="softmerge-inner" style="width: 65px; left: -13px;">Sorszám:</div>
            </td>
            <td class="s4" >K<span id="bizonylat_sorszam">'.$maxid.'</span></td>
         </tr>
         <tr style="height:20px;">
           
            <td class="s5"  colspan="3">1114 Budapest, Bartók Béla út 11-13.</td>
            <td class="s1"  colspan="6">KIADÁSI PÉNZTÁRBIZONYLAT</td>
            <td class="s6"></td>
            <td class="s7"></td>
         </tr>
         <tr style="height:20px;">
            
            <td class="s8"  colspan="3">22941967-2-43</td>
            <td class="s9" ></td>
            <td class="s9" colspan="4">'.$this->telephelycim[$this->telephely].'</td>
            <td class="s9" ></td>
            <td class="s77" >Kelt:</td>
            <td class="s11" ><input onkeydown = "EnableWrite(event,this.id)" id="bizonylat_date" type="text" name="bizonylat_date" value="'.$this->date.'" readonly style ="text-align:left; width:105px" required></td>
         </tr>
         <tr style="height:10px;">
            
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s13"></td>
         </tr>
         <tr style="height:20px;">
          
            <td class="s14"  colspan="3">Pénztár fizessen az alábbiak szerint</td>
            <td class="s15"  colspan="5"><input  type="text"  id="bizonylat_nev" placeholder="" value="'.$this->recepcios.'"/></td>
            <td class="s16"  colspan="3">-nak</td>
         </tr>
         <tr style="height:20px;">
          
            <td class="s14"></td>
            <td class="s14"></td>
            <td class="s14"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s16"></td>
         </tr>
         <tr style="height:20px;">
          
            <td class="s17"  colspan="2"><input type="number" placeholder="000000"/ id="bizonylat_foosszegszam"></td>
            <td class="s16 softmerge" >
               <div class="softmerge-inner" style="width: 51px; left: -1px;" id="bizonylat_foosszegszam">Ft -t, azaz </div>
            </td>
            <td class="s18"  colspan="7"><input type="text" id="bizonylat_foosszegszoveg" placeholder=""/></td>
            <td class="s16" >forint-t.</td>
         </tr>
         <tr style="height:10px;">
          
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s20" ></td>
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s21" ></td>
         </tr>
         <tr style="height:20px;">
           
            <td class="s22" colspan="2">Készpénzforgalmi jogcím</td>
            <td class="s22" colspan="2">Bizonylatszám</td>
            <td class="s22" colspan="2">Bizonylat kelte</td>
            <td class="s22" colspan="3">Szöveg</td>
            <td class="s22" colspan="2">Összeg</td>
         </tr>';
        
        $jogcim = 'Átvezetés a főpénztárba';
        $html .= '<tr style="height:19px;">           
            <td class="s10" colspan="2"><input  style=""  type="text" value="'.$jogcim.'"/></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" "/></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  id="date0" type="text" onclick="today_date(this.id)"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder=""/></td>
            <td class="s10" colspan="2" style ="padding-top:4px;" onkeyup="bizonylat_kitolt()"><input style="width:auto;" type="number" placeholder="" value ="'.$befetel_osszesen.'"/><label for="input">Ft</label></td>
         </tr>';
       
        for ($i=1;$i<8;$i++){
         $id = 'date'.$i;
         $html .= '<tr style="height:19px;">           
            <td class="s10" colspan="2"><input  style=""  type="text" placeholder=""/></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" "/></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  id="'.$id.'" type="text" onclick="today_date(this.id)"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder=""/></td>
            <td class="s10" colspan="2" style ="padding-top:4px;" onkeyup="bizonylat_kitolt()"><input style="width:auto;" type="number" placeholder=""/><label for="input">Ft</label></td>
         </tr>';
        
         }     

         
       $html .= '<tr style="height:25px;">
            
            <td class="s23" colspan="2" rowspan="2">Kiállító:</td>
            <td class="s23" colspan="2" rowspan="2">Ellenör:</td>
            <td class="s23" colspan="2" rowspan="2">Utalványozó:</td>
            <td class="s24"  rowspan="2">Melléklet:</td>
            <td class="s25"  colspan="2" rowspan="2"><input style="width:100px;" type="number" id="bizonylat_melleklet" placeholder=""><label for="input">db</label></td>
            <td class="s26"> Kerekítés:</td>
            <td class="s13" ><input style="width:95px;" type="number" id="bizonylat_kerekites" placeholder=""/><label for="input">Ft</label></td>
         </tr>
         <tr style="height:20px;">
            
            <td class="s27" >Összesen:</td>
            <td class="s21" ><input style="width:95px;" type="number" id="bizonylat_osszesen" placeholder=""><label for="input">Ft</label></td>
         </tr>
         <tr style="height:50px;">
          
            <td class="s23"  colspan="2" rowspan="2">Könyvelő:</td>
            <td class="s23"  colspan="2" rowspan="2">Pénztáros:</td>
            <td class="s23"  colspan="2" rowspan="2">Érvényesítő:</td>
            <td class="s28"  colspan="3" rowspan="2">Az összeg átvevőjének aláírása:</td>
            <td class="s29"  colspan="2" rowspan="2">Személyi azonosító száma :</td>
         </tr>
        
      </tbody>
   </table></form>
</div>';
       }
       return ($html);
   }
   
   public function user_post_pbizid_jav(){
       
       if (isset($_POST["jav_biz_tipus"]) AND isset($_POST["jav_biz_id"])){
       
       $jav_biz_tipus = test_input($_POST["jav_biz_tipus"]);
       $jav_biz_id = test_input($_POST["jav_biz_id"]);
       
       if ($jav_biz_tipus == "kiadas"){
           
           
           echo $this->jav_kiadas_pbiz($jav_biz_id);
       }       
        if ($jav_biz_tipus == "bevetel"){
           
           
           echo $this->jav_bev_pbiz($jav_biz_id);
       }  
               
           
       }
       
   }

public function jav_bev_pbiz($id){
       $html = "";      
       $date = "";
       $bizonylat_adatok = "";
       $bizonylat_nev = "NINCS ILYEN BIZONYLAT";
       $bizonylat_foosszeg = "";
       $bizonylat_foosszegszoveg = "";
       $bizonylat_kerekites = "";
       $bizonylat_melleklet = "";
       $bizonylat_osszesen = "";
       $bizonylat_sorszam = "";         
       $datas = array();  
      
       
       $sql = "SELECT * FROM ".$this->bev_dbnames[$this->telephely]." WHERE bevpbiz_id = '$id' ";
       
       $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $date =$row["datetime"];
                $date = strtotime($date);
                $date = date("Y.m.d",$date);
                $bizonylat_adatok =  $row["bizonylat_adatok"];
                $bizonylat_nev = $row["bizonylat_nev"];
                $bizonylat_foosszeg = $row["bizonylat_foosszegszam"];
                $bizonylat_foosszegszoveg = $row["bizonylat_foosszegszoveg"];
                $bizonylat_kerekites = $row["bizonylat_kerekites"];
                $bizonylat_melleklet = $row["bizonylat_melleklet"];
                $bizonylat_osszesen = $row["bizonylat_osszesen"];
                $bizonylat_sorszam = $row["bevpbiz_id"] ;    
                $bizonylat_sorszam = $this->make_soraszam($bizonylat_sorszam);     
                
               
            }
        } else {
            $html = "Nincs ilyen bevételi pénztárbizonylat!" .$id ;
        }
        
      
        //adatmezők feldolgozása
        $datas = array();
        $datas = explode(',', $bizonylat_adatok);
       
    $html .= '<div class="ritz grid-container" >
             <form>
            <table class="waffle" cellspacing="0" cellpadding="0" id ="penztar_bizonylat">';
    $html .= $this->bev_pbiz_css(); 
    $html .=  '<tbody>
         <tr style="height:19px;">
         
            <td class="s0"  colspan="3">'.$this->cegnev1.'</td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s2 softmerge" >
               <div class="softmerge-inner" style="width: 60px; left: -1px;">Sorszám:</div>
            </td>
            <td class="s3" >B<span id="bizonylat_sorszam">'. $bizonylat_sorszam.'</span></td>
         </tr>
         <tr style="height:19px;">
           
            <td class="s4" dir="ltr" colspan="3">'.$this->cegnev2.'</td>
            <td class="s1" dir="ltr" colspan="6">BEVÉTELI PÉNZTÁRBIZONYLAT</td>
            <td class="s4"></td>
            <td class="s3"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s5" colspan="3">'.$this->adoszam.'</td>
            <td class="s6" ></td>
            <td class="s6" colspan="4">'.$this->telephelycim[$this->telephely].'</td>
            <td class="s6" ></td>
            <td class="s7" >Kelt:</td>
            <td class="s8" ><input onkeydown = "EnableWrite(event,this.id)" id="bizonylat_date" type="text" name="bizonylat_date" value="'.$date.'" readonly required style ="text-align:left; width:105px"></td>
         </tr>
         <tr style="height:10px;">
           
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s9"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s2" dir="ltr" colspan="3">Pénztár vételezze be az alábbiak szerint  a </td>
            <td class="s7" dir="ltr" colspan="5"><input  type="text" id="bizonylat_nev" placeholder="" value="'.$bizonylat_nev.'"/></td>
            <td class="s9" dir="ltr" colspan="3">által (megbízásából) fizetett</td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s9"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s2"  colspan="2"><input type="number" placeholder="000000"/ id="bizonylat_foosszegszam" value = "'.$bizonylat_foosszeg.'"></td>
            <td class="s9 softmerge">
               <div class="softmerge-inner" style="width: 61px; left: -1px;"> Ft -t, azaz </div>
            </td>
            <td class="s10"  colspan="7"><input  type="text" id="bizonylat_foosszegszoveg" placeholder="" value = "'.$bizonylat_foosszegszoveg.'"/></td>
            <td class="s9" dir="ltr">forint-t.</td>
         </tr>
         <tr style="height:10px;">
           
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s10"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s11" colspan="2">Készpénzforgalmi jogcím</td>
            <td class="s11" colspan="2">Bizonylatszám</td>
            <td class="s11" colspan="2">Bizonylat kelte</td>
            <td class="s11" colspan="3">Szöveg</td>
            <td class="s11" colspan="2">Összeg</td>
         </tr>';
          
          $lines=0;
          if ($this->telephely != 'Scolinea' /*AND $this->telephely != 'BMM'*/){$lines =8;} else {$lines = 30;} // ha x telephelyre több sor kell
          
          $adatok = array();     
          $counter = 0;
                        for ($i=0;$i<$lines;$i++){       //sor
                            for ($j=0;$j<5;$j++){   // oszlop
                                if(isset($datas[$counter])){
                                    $adatok[$i][$j] = $datas[$counter];
                                }
                                else{$adatok[$i][$j] = ""; }
                                
                                $counter ++;
                            
                                       
                            }
                                      
                        $html .= '<tr style="height:19px;">
                               <td class="s10" colspan="2"><input  style=""  type="text" placeholder="" value="'.$adatok[$i][0].'"></td>
                               <td class="s10" colspan="2"><input  style="width:100px;" type="text" value="'.$adatok[$i][1].'"></td>
                               <td class="s10" colspan="2"><input  style="width:100px;"  type="text" onclick="" value="'.$adatok[$i][2].'"></td>
                               <td class="s10" colspan="3"><input  style="" type="text" placeholder="" value="'.$adatok[$i][3].'"></td>
                               <td class="s10" colspan="2" style ="padding-top:4px;"><input style="width:152px;" type="number" placeholder="" value="'.$adatok[$i][4].'"><label for="input">Ft</label></td>
                            </tr>';
                        }
                               


        
    $html .= '<tr style="height:25px;">
            <td class="s12"  colspan="2" rowspan="2">Kiállító:</td>
            <td class="s12"  colspan="2" rowspan="2">Ellenör:</td>
            <td class="s12"  colspan="2" rowspan="2">Utalványozó:</td>
            <td class="s13"  rowspan="2">Melléklet:</td>
            <td class="s14"  colspan="2" rowspan="2"><input style="width:95px;" type="number" id="bizonylat_melleklet" placeholder="" value = "'.$bizonylat_melleklet.'"><label for="input">db</label></td>
            <td class="s15" >Kerekítés:</td>
            <td class="s16 ">
               <input style="width:92px;" type="number" id="bizonylat_kerekites" placeholder=""/ value = "'.$bizonylat_kerekites.'"><label for="input">Ft</label>
            </td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s17" >Összesen:</td>
            <td class="s16 softmerge" >
               <input style="width:92px;" type="number"  id="bizonylat_osszesen" placeholder="" value = "'.$bizonylat_osszesen.'"><label for="input">Ft</label>
            </td>
         </tr>
         <tr style="height:50px;">
            
            <td class="s12"  colspan="2" rowspan="2">Könyvelő:</td>
            <td class="s12"  colspan="2" rowspan="2">Pénztáros:</td>
            <td class="s12"  colspan="2" rowspan="2">Érvényesítő:</td>
            <td class="s12"  colspan="5" rowspan="2">Az összeg befizetőjének aláírása:</td>
         </tr>
           
      </tbody>
   </table>
</div>';
     if ($_SESSION['type_user'] == "superadmin"){  
         
        $html .='<div class="container">';
        $html .='<div id="HiddenIfPrint"><div class="btn-group"><div class="alert alert-warning">A bizonylat úra nyomatatható, és javítható, de nincs összegző számoló segítség ! <a href="#"onclick="  StartPrtintPage('."'bevetel_javbiz'".')" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a></div>'
                    . '</div></div>';   
                    
     }else{
         $html .='<div class="container">';
        $html .='<div id="HiddenIfPrint"><div class="btn-group"><div class="alert alert-warning">A bizonylat úra nyomatatható, de nem javítható! <a href="#" onclick="OnlyPrint()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a></div>'
                    . '</div></div>';   
         
     }
     
     
     
  return($html);     
}


public function jav_kiadas_pbiz($id){
     
    $date = "";
       $bizonylat_adatok = "";
       $bizonylat_nev = "NINCS ILYEN BIZONYLAT";
       $bizonylat_foosszeg = "";
       $bizonylat_foosszegszoveg = "";
       $bizonylat_kerekites = "";
       $bizonylat_melleklet = "";
       $bizonylat_osszesen = "";
       $bizonylat_sorszam = "";         
       $datas = array();  
    
    $sql = "SELECT * FROM ".$this->kiad_dbnames[$this->telephely] ." WHERE kiadpbiz_id = '$id' ";
       
       $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $date =$row["datetime"];
                $date = strtotime($date);
                $date = date("Y.m.d",$date);
                $bizonylat_adatok =  $row["bizonylat_adatok"];
                $bizonylat_nev = $row["bizonylat_nev"];
                $bizonylat_foosszeg = $row["bizonylat_foosszegszam"];
                $bizonylat_foosszegszoveg = $row["bizonylat_foosszegszoveg"];
                $bizonylat_kerekites = $row["bizonylat_kerekites"];
                $bizonylat_melleklet = $row["bizonylat_melleklet"];
                $bizonylat_osszesen = $row["bizonylat_osszesen"];
                $bizonylat_sorszam = $row["kiadpbiz_id"] ;         
                $bizonylat_sorszam = $this->make_soraszam($bizonylat_sorszam);     
            }
        } else {
            $html = "Nincs ilyen bevételi pénztárbizonylat!" .$id ;
        }
        
       
       
        //adatmezők feldolgozása
        $datas = array();
        $datas = explode(',', $bizonylat_adatok);
      
   $html=""; 
   $html .= '<div class="ritz grid-container" >
             <form>
            <table class="waffle" cellspacing="0" cellpadding="0" id ="penztar_bizonylat">';
    $html .= $this->bev_pbiz_css(); 
    $html .=  '<tbody>
         <tr style="height:19px;">
         
            <td class="s0"  colspan="3">'.$this->cegnev1.'</td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s2 softmerge" >
               <div class="softmerge-inner" style="width: 60px; left: -1px;">Sorszám:</div>
            </td>
            <td class="s3" >K<span id="bizonylat_sorszam">'. $bizonylat_sorszam.'</span></td>
         </tr>
         <tr style="height:19px;">
           
            <td class="s4" dir="ltr" colspan="3">'.$this->cegnev2.'</td>
            <td class="s1" dir="ltr" colspan="6">KIADÁSI PÉNZTÁRBIZONYLAT</td>
            <td class="s4"></td>
            <td class="s3"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s5" colspan="3">'.$this->adoszam.'</td>
            <td class="s6" ></td>
            <td class="s6" colspan="4">'.$this->telephelycim[$this->telephely].'</td>
            <td class="s6" ></td>
            <td class="s7" >Kelt:</td>
            <td class="s8" ><input onkeydown = "EnableWrite(event,this.id)" id="bizonylat_date" type="text" name="bizonylat_date" value="'.$date.'" readonly required style ="text-align:left; width:105px"></td>
         </tr>
         <tr style="height:10px;">
           
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s9"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s2" dir="ltr" colspan="3">Pénztár fizessen az alábbiak szerint</td>
            <td class="s7" dir="ltr" colspan="5"><input  type="text" id="bizonylat_nev" placeholder="" value="'.$bizonylat_nev.'"/></td>
            <td class="s9" dir="ltr" colspan="3">-nak</td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s2"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s9"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s2"  colspan="2"><input type="number" placeholder="000000"/ id="bizonylat_foosszegszam" value = "'.$bizonylat_foosszeg.'"></td>
            <td class="s9 softmerge">
               <div class="softmerge-inner" style="width: 61px; left: -1px;"> Ft -t, azaz </div>
            </td>
            <td class="s10"  colspan="7"><input  type="text" id="bizonylat_foosszegszoveg" placeholder="" value = "'.$bizonylat_foosszegszoveg.'"/></td>
            <td class="s9" dir="ltr">forint-t.</td>
         </tr>
         <tr style="height:10px;">
           
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s7"></td>
            <td class="s10"></td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s11" colspan="2">Készpénzforgalmi jogcím</td>
            <td class="s11" colspan="2">Bizonylatszám</td>
            <td class="s11" colspan="2">Bizonylat kelte</td>
            <td class="s11" colspan="3">Szöveg</td>
            <td class="s11" colspan="2">Összeg</td>
         </tr>';
          
          $lines=8;
          //if ($this->telephely != 'P72'){$lines =8;} else {$lines =20;}
          
          $adatok = array();     
          $counter = 0;
                        for ($i=0;$i<$lines;$i++){       //sor
                            for ($j=0;$j<5;$j++){   // oszlop
                               $adatok[$i][$j] = $datas[$counter];
                               $counter ++;
                            
                                       
                            }
                                      
                        $html .= '<tr style="height:19px;">
                               <td class="s10" colspan="2"><input  style=""  type="text" placeholder="" value="'.$adatok[$i][0].'"></td>
                               <td class="s10" colspan="2"><input  style="width:100px;" type="text" value="'.$adatok[$i][1].'"></td>
                               <td class="s10" colspan="2"><input  style="width:100px;"  type="text" onclick="" value="'.$adatok[$i][2].'"></td>
                               <td class="s10" colspan="3"><input  style="" type="text" placeholder="" value="'.$adatok[$i][3].'"></td>
                               <td class="s10" colspan="2" style ="padding-top:4px;"><input style="width:152px;" type="number" placeholder="" value="'.$adatok[$i][4].'"><label for="input">Ft</label></td>
                            </tr>';
                        }
                               


        
    $html .= '<tr style="height:25px;">
            <td class="s12"  colspan="2" rowspan="2">Kiállító:</td>
            <td class="s12"  colspan="2" rowspan="2">Ellenör:</td>
            <td class="s12"  colspan="2" rowspan="2">Utalványozó:</td>
            <td class="s13"  rowspan="2">Melléklet:</td>
            <td class="s14"  colspan="2" rowspan="2"><input style="width:95px;" type="number" id="bizonylat_melleklet" placeholder="" value = "'.$bizonylat_melleklet.'"><label for="input">db</label></td>
            <td class="s15" >Kerekítés:</td>
            <td class="s16 ">
               <input style="width:92px;" type="number" id="bizonylat_kerekites" placeholder=""/ value = "'.$bizonylat_kerekites.'"><label for="input">Ft</label>
            </td>
         </tr>
         <tr style="height:19px;">
            
            <td class="s17" >Összesen:</td>
            <td class="s16 softmerge" >
               <input style="width:92px;" type="number"  id="bizonylat_osszesen" placeholder="" value = "'.$bizonylat_osszesen.'"><label for="input">Ft</label>
            </td>
         </tr>
         <tr style="height:50px;">
            
            <td class="s12"  colspan="2" rowspan="2">Könyvelő:</td>
            <td class="s12"  colspan="2" rowspan="2">Pénztáros:</td>
            <td class="s12"  colspan="2" rowspan="2">Érvényesítő:</td>
            <td class="s12"  colspan="5" rowspan="2">Az összeg átvevőjének aláírása:</td>
         </tr>
           
      </tbody>
   </table>
</div>';
     if ($_SESSION['type_user'] == "superadmin"){  
         
        $html .='<div class="container">';
        $html .='<div id="HiddenIfPrint"><div class="btn-group"><div class="alert alert-warning">A bizonylat úra nyomatatható, és javítható, de nincs összegző számoló segítség ! <a href="#"onclick="  StartPrtintPage('."'kiadasi_javbiz'".')" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a></div>'
                    . '</div></div>';   
                    
     }else{
         $html .='<div class="container">';
        $html .='<div id="HiddenIfPrint"><div class="btn-group"><div class="alert alert-warning">A bizonylat úra nyomatatható, de nem javítható! <a href="#" onclick="OnlyPrint()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a></div>'
                    . '</div></div>';   
         
     }
     
     
     
  return($html);     
}
       
       


public function jav_kiadas_pbiz_old($id){
    
    $date = "";
       $bizonylat_adatok = "";
       $bizonylat_nev = "NINCS ILYEN BIZONYLAT";
       $bizonylat_foosszeg = "";
       $bizonylat_foosszegszoveg = "";
       $bizonylat_kerekites = "";
       $bizonylat_melleklet = "";
       $bizonylat_osszesen = "";
       $bizonylat_sorszam = "";         
       $datas = array();  
    
    $sql = "SELECT * FROM ".$this->kiad_dbnames[$this->telephely] ." WHERE kiadpbiz_id = '$id' ";
       
       $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $date =$row["datetime"];
                $date = strtotime($date);
                $date = date("Y.m.d",$date);
                $bizonylat_adatok =  $row["bizonylat_adatok"];
                $bizonylat_nev = $row["bizonylat_nev"];
                $bizonylat_foosszeg = $row["bizonylat_foosszegszam"];
                $bizonylat_foosszegszoveg = $row["bizonylat_foosszegszoveg"];
                $bizonylat_kerekites = $row["bizonylat_kerekites"];
                $bizonylat_melleklet = $row["bizonylat_melleklet"];
                $bizonylat_osszesen = $row["bizonylat_osszesen"];
                $bizonylat_sorszam = $row["kiadpbiz_id"] ;         
                $bizonylat_sorszam = $this->make_soraszam($bizonylat_sorszam);     
            }
        } else {
            $html = "Nincs ilyen bevételi pénztárbizonylat!" .$id ;
        }
       
        //adatmezők feldolgozása
        $datas = array();
        $datas = explode(',', $bizonylat_adatok);
         
       $html ="";
       $html .= '<div class="ritz grid-container">';
       $html .= $this->bev_pbiz_css();
       $html .= '<table class="waffle" cellspacing="0" cellpadding="0" id ="penztar_bizonylat">
        <tbody>
         <tr style="height:20px;">
          
            <td class="s0" colspan="3">Medpot Kft. - Budafoki út.</td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s1" ></td>
            <td class="s2" ></td>
            <td class="s3 softmerge" >
               <div class="softmerge-inner" style="width: 65px; left: -13px;">Sorszám:</div>
            </td>
            <td class="s4" >K<span id="bizonylat_sorszam">'.$bizonylat_sorszam.'</span></td>
         </tr>
         <tr style="height:20px;">
           
            <td class="s5"  colspan="3">1114 Budapest, Bartók Béla út 11-13.</td>
            <td class="s1"  colspan="6">KIADÁSI PÉNZTÁRBIZONYLAT</td>
            <td class="s6"></td>
            <td class="s7"></td>
         </tr>
         <tr style="height:20px;">
            
            <td class="s8"  colspan="3">22941967-2-43</td>
            <td class="s9" ></td>
            <td class="s9" colspan="4">'.$this->telephelycim[$this->telephely].'</td>
            <td class="s9" ></td>
            <td class="s77" >Kelt:</td>
            <td class="s11" ><input onkeydown = "EnableWrite(event,this.id)" id="bizonylat_date" type="text" name="bizonylat_date" value="'.$date.'" readonly required style ="text-align:left; width:105px"></td>
         </tr>
         <tr style="height:10px;">
            
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s12"></td>
            <td class="s13"></td>
         </tr>
         <tr style="height:20px;">
          
            <td class="s14"  colspan="3">Pénztár fizessen az alábbiak szerint</td>
            <td class="s15"  colspan="5"><input  type="text"  id="bizonylat_nev" placeholder="" value ="'.$bizonylat_nev.'"/></td>
            <td class="s16"  colspan="3">-nak</td>
         </tr>
         <tr style="height:20px;">
          
            <td class="s14"></td>
            <td class="s14"></td>
            <td class="s14"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s16"></td>
         </tr>
         <tr style="height:20px;">
          
            <td class="s17"  colspan="2"><input type="number" id="bizonylat_foosszegszam" placeholder="000000" value ="'.$bizonylat_foosszeg.'"/></td>
            <td class="s16 softmerge" >
               <div class="softmerge-inner" style="width: 51px; left: -1px;" id="bizonylat_foosszegszam">Ft -t, azaz </div>
            </td>
            <td class="s18"  colspan="7"><input type="text" id="bizonylat_foosszegszoveg" placeholder="" value ="'.$bizonylat_foosszegszoveg.'"/></td>
            <td class="s16" >forint-t.</td>
         </tr>
         <tr style="height:10px;">
          
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s20" ></td>
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s19" ></td>
            <td class="s21" ></td>
         </tr>
         <tr style="height:20px;">
           
            <td class="s22" colspan="2">Készpénzforgalmi jogcím</td>
            <td class="s22" colspan="2">Bizonylatszám</td>
            <td class="s22" colspan="2">Bizonylat kelte</td>
            <td class="s22" colspan="3">Szöveg</td>
            <td class="s22" colspan="2">Összeg</td>
         </tr>
         
            <tr style="height:19px;">
            <td class="s10" colspan="2"><input  style=""  type="text" placeholder="" value="'.$datas[0].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" value="'.$datas[1].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  type="text" onclick="" value="'.$datas[2].'"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder="" value="'.$datas[3].'"></td>
            <td class="s10" colspan="2" style ="padding-top:4px;"><input style="width:auto;" type="number" placeholder="" value="'.$datas[4].'"><label for="input">Ft</label></td>
         </tr>
          <tr style="height:19px;">
            <td class="s10" colspan="2"><input  style=""  type="text" placeholder="" value="'.$datas[5].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" value="'.$datas[6].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  type="text" onclick="" value="'.$datas[7].'"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder="" value="'.$datas[8].'"></td>
            <td class="s10" colspan="2" style ="padding-top:4px;"><input style="width:auto;" type="number" placeholder="" value="'.$datas[9].'"><label for="input">Ft</label></td>
         </tr>
          <tr style="height:19px;">
            <td class="s10" colspan="2"><input  style=""  type="text" placeholder="" value="'.$datas[10].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" value="'.$datas[11].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  type="text" onclick="" value="'.$datas[12].'"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder="" value="'.$datas[13].'"></td>
            <td class="s10" colspan="2" style ="padding-top:4px;"><input style="width:auto;" type="number" placeholder="" value="'.$datas[14].'"><label for="input">Ft</label></td>
         </tr>
            <tr style="height:19px;">
            <td class="s10" colspan="2"><input  style=""  type="text" placeholder="" value="'.$datas[15].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" value="'.$datas[16].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  type="text" onclick="" value="'.$datas[17].'"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder="" value="'.$datas[18].'"></td>
            <td class="s10" colspan="2" style ="padding-top:4px;"><input style="width:auto;" type="number" placeholder="" value="'.$datas[19].'"><label for="input">Ft</label></td>
         </tr>
          <tr style="height:19px;">
            <td class="s10" colspan="2"><input  style=""  type="text" placeholder="" value="'.$datas[20].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" value="'.$datas[21].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  type="text" onclick="" value="'.$datas[22].'"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder="" value="'.$datas[23].'"></td>
            <td class="s10" colspan="2" style ="padding-top:4px;"><input style="width:auto;" type="number" placeholder="" value="'.$datas[24].'"><label for="input">Ft</label></td>
         </tr>
          <tr style="height:19px;">
            <td class="s10" colspan="2"><input  style=""  type="text" placeholder="" value="'.$datas[25].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" value="'.$datas[26].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  type="text" onclick="" value="'.$datas[27].'"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder="" value="'.$datas[28].'"></td>
            <td class="s10" colspan="2" style ="padding-top:4px;"><input style="width:auto;" type="number" placeholder="" value="'.$datas[29].'"><label for="input">Ft</label></td>
         </tr>   
          <tr style="height:19px;">
            <td class="s10" colspan="2"><input  style=""  type="text" placeholder="" value="'.$datas[30].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" value="'.$datas[31].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  type="text" onclick="" value="'.$datas[32].'"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder="" value="'.$datas[33].'"></td>
            <td class="s10" colspan="2" style ="padding-top:4px;"><input style="width:auto;" type="number" placeholder="" value="'.$datas[34].'"><label for="input">Ft</label></td>
         </tr>
          <tr style="height:19px;">
            <td class="s10" colspan="2"><input  style=""  type="text" placeholder="" value="'.$datas[35].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;" type="text" value="'.$datas[36].'"></td>
            <td class="s10" colspan="2"><input  style="width:100px;"  type="text" onclick="" value="'.$datas[37].'"></td>
            <td class="s10" colspan="3"><input  style="" type="text" placeholder="" value="'.$datas[38].'"></td>
            <td class="s10" colspan="2" style ="padding-top:4px;"><input style="width:auto;" type="number" placeholder="" value="'.$datas[39].'"><label for="input">Ft</label></td>
         </tr>';    
       
       $html .= '<tr style="height:25px;">
            
            <td class="s23" colspan="2" rowspan="2">Kiállító:</td>
            <td class="s23" colspan="2" rowspan="2">Ellenör:</td>
            <td class="s23" colspan="2" rowspan="2">Utalványozó:</td>
            <td class="s24"  rowspan="2">Melléklet:</td>
            <td class="s25"  colspan="2" rowspan="2"><input style="width:100px;" type="number" id="bizonylat_melleklet" placeholder="" value="'.$bizonylat_melleklet.'"><label for="input">db</label></td>
            <td class="s26"> Kerekítés:</td>
            <td class="s13" ><input style="width:95px;" type="number" id="bizonylat_kerekites" placeholder=""  value="'.$bizonylat_kerekites.'" /><label for="input">Ft</label></td>
         </tr>
         <tr style="height:20px;">
            
            <td class="s27" >Összesen:</td>
            <td class="s21" ><input style="width:95px;" type="number" id="bizonylat_osszesen" placeholder=""  value="'.$bizonylat_osszesen.'" ><label for="input">Ft</label></td>
         </tr>
         <tr style="height:50px;">
          
            <td class="s23"  colspan="2" rowspan="2">Könyvelő:</td>
            <td class="s23"  colspan="2" rowspan="2">Pénztáros:</td>
            <td class="s23"  colspan="2" rowspan="2">Érvényesítő:</td>
            <td class="s28"  colspan="3" rowspan="2">Az összeg átvevőjének aláírása:</td>
            <td class="s29"  colspan="2" rowspan="2">Személyi azonosító száma :</td>
         </tr>
         
      </tbody>
   </table></form>
</div>';
     
    if ($_SESSION['type_user'] == "superadmin"){  
         
        $html .='<div class="container">';
        $html .='<div id="HiddenIfPrint"><div class="btn-group"><div class="alert alert-warning">A bizonylat úra nyomatatható, és javítható, de nincs összegző számoló segítség!<a href="#"onclick="  StartPrtintPage('."'kiadasi_javbiz'".')" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a></div>'
                    . '</div></div>';   
                    
     }else{
         $html .='<div class="container">';
        $html .='<div id="HiddenIfPrint"><div class="btn-group"><div class="alert alert-warning">A bizonylat úra nyomatatható, de nem javítható! <a href="#" onclick="OnlyPrint()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a></div>'
                    . '</div></div>';   
         
     }
   return ($html);
   
}

public function bev_pbiz_css(){
   $css = '<style type="text/css">.ritz .waffle a {
     color: inherit;
}
.ritz table{
    border: 3px solid black;
    margin-bottom:2em;
    padding-bottom:3px;
}

.ritz .waffle .s18{
    background-color:#ffffff;
    text-align:right;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s15{
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:7pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s22{
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:7pt;
    vertical-align:top;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s13{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:7pt;
    vertical-align:middle;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s17{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:7pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s2{
    background-color:#ffffff;
    text-align:center;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 0px 0px 0px;
}
.ritz .waffle .s4{
    background-color:#ffffff;
    text-align:left;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 0px 0px 0px;
}
.ritz .waffle .s10{
    border-bottom:1px SOLID #000000;
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:middle;
    white-space:nowrap;
    direction:ltr;
    padding:0px 0px 0px 0px;
}
.ritz .waffle .s8{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s12{
    border-bottom:1px SOLID #000000;
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:7pt;
    vertical-align:top;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s0{
    background-color:#ffffff;
    text-align:left;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:14pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s24{
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:8pt;
    vertical-align:top;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s3{
    background-color:#ffffff;
    text-align:left;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s5{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s23{
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:7pt;
    vertical-align:middle;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s16{
    border-right: none;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 0px 0px 0px;
    
}
.ritz .waffle .s1{
    background-color:#ffffff;
    
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:14pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s7{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s9{
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s11{
    border-bottom:1px SOLID #000000;
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:center;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s20{
    background-color:#ffffff;
    text-align:center;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s14{
    
    border-bottom:1px SOLID #000000;
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:middle;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s6{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:center;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:14pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s21{
    background-color:#ffffff;
    text-align:center;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s19{
    background-color:#ffffff;
    text-align:right;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}

.ritz .waffle  input[type=number] {
	width: 100%;
        height: 100%;
        text-align:right;
        border:0px;
        paddign:opx;
}
.ritz .waffle input[type=text] {
	width: 100%;
        height: 100%;
        text-align:center;
        border:0px;
        padding:0px;
}


</style>';

return ($css);    
} 

public function kiadasi_pbiz_css(){
    $css = "";
    $css .= '<style type="text/css">
    
.ritz .waffle a {
     color: inherit;
}

.ritz table{
    border: 3px solid black;
    margin-bottom:2em;
    border-collapse: collapse;
    
   
}
.ritz .waffle .s29{
    border-bottom:1px SOLID #000000;
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:8pt;
    vertical-align:top;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s26{
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:7pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s24{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:7pt;
    vertical-align:middle;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s3{
    border-left: none;
    background-color:#ffffff;
    text-align:right;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s27{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:7pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s12{
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s5{
    background-color:#ffffff;
    text-align:left;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s21{
    border-bottom:1px SOLID #000000;
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
    text-align: right;
}
.ritz .waffle .s11{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s14{
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s23{
    border-bottom:1px SOLID #000000;
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:7pt;
    vertical-align:top;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s0{
    background-color:#ffffff;
    text-align:left;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:14pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s7{
    background-color:#ffffff;
    text-align:left;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s8{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s10{
    border-bottom:1px SOLID #000000;
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:right;
    color:#000000;
    font-family:"Times New Roman";
    font-size:14pt;
    vertical-align:right;
    white-space:nowrap;
    direction:ltr;
    padding:0px 2px 0px 0px;
     
}
.ritz .waffle .s15{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s16{
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s1{
    background-color:#ffffff;
    text-align:center;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:14pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s18{
     border-bottom:1px SOLID #000000;
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:middle;
    white-space:nowrap;
    direction:ltr;
    padding:0px 0px 0px 0px;
}
.ritz .waffle .s20{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s13{
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
    text-align: right;
}
.ritz .waffle .s17{
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 0px 0px 0px;
}
.ritz .waffle .s2{
    border-right: none;
    background-color:#ffffff;
    text-align:center;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:14pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
   
}
.ritz .waffle .s22{
    border-bottom:1px SOLID #000000;
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:center;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s25{
    border-bottom:1px SOLID #000000;
    border-right:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:middle;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
    text-align: right;
}
.ritz .waffle .s28{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:left;
    color:#000000;
    font-family:"Times New Roman";
    font-size:7pt;
    vertical-align:top;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s4{
    border-left: none;
    background-color:#ffffff;
    text-align:left;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:12pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s19{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:center;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s9{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:center;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:14pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}
.ritz .waffle .s6{
    background-color:#ffffff;
    text-align:right;
    font-weight:bold;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}

.ritz .waffle  input[type=number] {
	width: 100%;
        height: 100%;
        text-align:right;
        border:0px;
        paddign:opx;
}
.ritz .waffle input[type=text] {
	width: 100%;
        height: 100%;
        text-align:center;
        border:0px;
        padding:0px;
}

.ritz .waffle .s77{
    border-bottom:1px SOLID #000000;
    background-color:#ffffff;
    text-align:right;
    color:#000000;
    font-family:"Times New Roman";
    font-size:10pt;
    vertical-align:bottom;
    white-space:nowrap;
    direction:ltr;
    padding:0px 3px 0px 3px;
}

</style>';
    
 return ($css);   
    
}   
   
private function Select_Pgzaras_kposszes ($telephely) {
    $kp_osszesen = 0;
    
    // utolsó telehelyi pg zárás főösszege
    $sql = "SELECT kp_osszes FROM pgzarasok WHERE pg_telephely = '$telephely' ORDER BY pgzaras_date DESC LIMIT 1";
    
    $result = $this->dbconn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $kp_osszesen = $row["kp_osszes"];
        }
    } else {
       $kp_osszesen = 0;
    }
    
    
    return $kp_osszesen; 
}


private function Select_bevetelipbiz_kposszes ($telephely) {
    $kp_osszesen = 0;
    
    // utolsó telehelyi pg zárás főösszege
    $sql = "SELECT bizonylat_osszesen FROM ".$this->bev_dbnames[$telephely]." WHERE 1 ORDER BY datetime DESC LIMIT 1";
    
    $result = $this->dbconn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $kp_osszesen = $row["bizonylat_osszesen"];
        }
    } else {
       $kp_osszesen = 0;
    }
    
    
    return $kp_osszesen; 
}

public function idoszaki_penztarjelentes_form(){
    
    
    $html = "";
         
              
        $html .= '<div class="panel panel-danger">';
            $html .='<div class="panel-heading">Időszaki pénztárjelentés készítése</div>';
            $html .= '<div class="panel-body">';
                $html .= '<form  class="form-inline" action="' . $_SERVER['PHP_SELF'] . '?pid=page36" method="post" >'; 
                
                //lekérdezési időszak eleje
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Összesítendő hónap :</label>
                        <div class=""><input type="month" class="form-control" name="startdate" value = "'.$this->month.'"></div>
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

    public function UserPostQuery_IdőszakiPenztarjelentesTable(){
        
        $html = "";
        $datas = array();
        $adatok = array(); // ide kerül a bizonylat két dim tömb adattartama
        
        if (isset($_POST["startdate"])){
            // van post lekérdezés paraméterei
            
            
            $reportdate = $_POST["startdate"];
            $startdate = $_POST["startdate"].-1;
            $enddate = date("Y-m-t", strtotime($startdate));
            $year = date("Y", strtotime($startdate));
            $month = date("m", strtotime($startdate));                             
            // táblázat fejléc része
                      
            $html .= '<table class="table" id="riport">
            <thead>
              
              <tr>
              <th colspan="3" style="border:none;">Medport Kft. - Budafoki út.</th>
              <th colspan="4"style="border:none;">IDŐSZAKI PÉNZTÁRJELENTÉS</th>
              <th colspan="3"style="border:none;">nyomtatás napja : '.$this->date.'</th>
              </tr>
              <tr>
              <th colspan="3" style="border:none;">1114 Budapest, Bartók Béla út 11-13</th>
              <th colspan="4" style="border:none;">'.$startdate.' - '.$enddate.'</th>
              <th colspan="3" style="border:none;">Pénznem : forint</th>
              </tr>
               <tr>
              <th colspan="3" style="border:none;">'.$this->telephelycim[$this->telephely].'</th>
              <th style="border:none;"> Nyitó egyenleg : </th>
              <th style="border:none;text-align:center;"> '.$this->hazipenztar_indulo_egyenleg($startdate).' Ft </th>
              <th colspan="5" style="border:none;"></th>
              </tr>
              
              <tr>
                <th>Dátum</th>
                <th>Sorszám</th>
                <th style="text-align:center;">Bevétel</th>
                <th style="text-align:center;">Kiadás</th>
                <th style="text-align:center;">Egyenleg</th>
                <th>Név/Biz.szám</th>
                <th>Jogcím/Szöveg</th>
                <th>Bevétel</th>
                <th>Kiadás</th>
                <th>Mell.</th>
                </tr>
            </thead>
            <tbody>';
            
            
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);  
              
            for ($day = 1 ; $day <= $days_in_month; $day ++){  
                
                if ($day < 10){
                $report_day = $reportdate.'-0'.$day;
                }else{
                $report_day = $reportdate.'-'.$day;    
                }
                // bevételi bizonylatok
                $sql = "SELECT * FROM ".$this->bev_dbnames[$this->telephely]." WHERE datetime LIKE '%$report_day%'"; 
       
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    $recepcios ="";
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        $recepcios = $row["recepcio"];
                        //$style = "";
                        $bizonylat_adatok =  $row["bizonylat_adatok"];
                        //adatmezők feldolgozása
                        $datas = explode(',', $bizonylat_adatok);
                        $counter = 0;
                        for ($i=0;$i<8;$i++){       //sor
                            for ($j=0;$j<5;$j++){   // oszlop
                               $adatok[$i][$j] = $datas[$counter];
                               $counter ++;
                            }
                        } 
                        // következősor nem üres a sorokat szaggatott vonal választja el
                        if ($adatok[1][0] != "") {
                            $style = 'border-bottom-width:3px; border-bottom-style:dotted;border-bottom-color: #ddd;';
                           
                            
                        }
                        else {
                            $style = '';
                        }
                        $html .= '<tr><td style="'.$style.'">'.$report_day.'</td>'
                                . '<td style="'.$style.'">B'.$this->make_soraszam($row["bevpbiz_id"]).'</td>'
                                . '<td style="'.$style.' text-align:center;">'.$row["bizonylat_foosszegszam"].'</td>'
                                . '<td style="'.$style.'"></td>'
                                . '<td style="'.$style.' text-align:center;">'.$this->pj_egyenleg('bev',$row["bizonylat_foosszegszam"]).'</td>'
                                . '<td style="'.$style.'">'.$row["bizonylat_nev"].'<br>'.$adatok[0][1].'</td>'
                                . '<td style="'.$style.'">'.$adatok[0][0].'<br>'.$adatok[0][3].'</td>'
                                . '<td style="'.$style.'">'.$adatok[0][4].'</td>'
                                . '<td style="'.$style.'"></td>'
                                . '<td style="'.$style.' text-align:center;">'.$row["bizonylat_melleklet"].'</td>'
                                . '</tr>';
                    
                    // adatok további feldolgozása soronként
                        for ($i = 1; $i < 8;$i++){

                            if ($adatok[$i][0] != ""){

                                $html .= '<tr><td></td><td></td>'
                                        . '<td></td>'
                                        . '<td></td>'
                                        . '<td></td>'
                                        . '<td>'.$recepcios.'<br>'.$adatok[$i][1].'</td>'
                                        . '<td>'.$adatok[$i][0].'<br>'.$adatok[$i][3].'</td>'
                                        . '<td>'.$adatok[$i][4].'</td>'
                                        . '<td></td>'
                                        . '<td></td>'
                                        . '</tr>';

                            }
                        }
                    }
                } else {
                   // $html .= "<tr><td>".$report_day."- Bevetel: Nincs bizonylat</td></tr>";
                }
                
                // kiadási bizonylatok
                $sql = "SELECT * FROM ".$this->kiad_dbnames[$this->telephely]." WHERE datetime LIKE '%$report_day%'"; 
       
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    $recepcios ="";
                    while($row = $result->fetch_assoc()) {
                        $recepcios = $row["recepcio"];
                        $bizonylat_adatok =  $row["bizonylat_adatok"];
                        //adatmezők feldolgozása
                        $datas = explode(',', $bizonylat_adatok);
                        $counter = 0;
                        for ($i=0;$i<8;$i++){       //sor
                            for ($j=0;$j<5;$j++){   // oszlop
                               $adatok[$i][$j] = $datas[$counter];
                               $counter ++;
                            }
                        } 
                        // következősor nem üres a sorokat szaggatott vonal választja el
                        if ($adatok[1][0] != "") {$style = 'border-bottom-width:3px; border-bottom-style:dotted;border-bottom-color: #ddd;';}
                        else {
                            $style = '';
                        }
                        
                        $html .= '<tr><td style="'.$style.'">'.$report_day.'</td>'
                                . '<td style="'.$style.'">K'.$this->make_soraszam($row["kiadpbiz_id"]).'</td>'
                                . '<td style="'.$style.'"></td>'
                                . '<td style="'.$style.' text-align:center;">'.$row["bizonylat_foosszegszam"].'</td>'
                                . '<td style="'.$style.' text-align:center;">'.$this->pj_egyenleg('ki',$row["bizonylat_foosszegszam"]).'</td>'
                                . '<td style="'.$style.'">'.$row["bizonylat_nev"].'<br>'.$adatok[0][1].'</td>'
                                . '<td style="'.$style.'">'.$adatok[0][0].'<br>'.$adatok[0][3].'</td>'
                                . '<td style="'.$style.'"></td>'
                                . '<td style="'.$style.'">'.$adatok[0][4].'</td>'
                                . '<td style="'.$style.' text-align:center;">'.$row["bizonylat_melleklet"].'</td>'
                                . '</tr>';
                    
                    // adatok további feldolgozása soronként
                        for ($i = 1; $i < 8;$i++){

                            if ($adatok[$i][0] != ""){

                                $html .= '<tr><td></td><td></td>'
                                        . '<td></td>'
                                        . '<td></td>'
                                        . '<td></td>'
                                        . '<td>'.$recepcios.'<br>'.$adatok[$i][1].'</td>'
                                        . '<td>'.$adatok[$i][0].'<br>'.$adatok[$i][3].'</td>'
                                        . '<td></td>'
                                        . '<td>'.$adatok[$i][4].'</td>'
                                        . '<td></td>'
                                        . '</tr>';

                            }
                        }    
                        
                    }
                    
                } else {
                   // $html .= "<tr><td>".$report_day."- Kiadás: Nincs bizonylat</td></tr>";
                }     
                
                // összesítés adatai
            }    
                $html .=  '<tr><td></td><td></td><th>Bevétel</th><th>Kiadás</th><th>Egyenleg</th></tr>'
                        . '<tr><td></td><th>Összesen:</th><td>'.$this->sumbevetel.' Ft</td><td>'.$this->sumkiadas.' Ft<td></td></tr>'
                        . '<tr><td></td><th>Záró egyenleg:</th><td></td><td></td><td>'.$this->egyenleg.' Ft</td></tr>';
                
                
            
       $html .= '</tbody>
          </table>';
          
        }
      
    return $html;   
    }
    
private function pj_egyenleg($tipus,$osszeg){
    
    if ($tipus == 'bev'){
        $this->sumbevetel += $osszeg;
    }
    if  ($tipus == 'ki'){
        $this->sumkiadas += $osszeg;
    }
    
    $this->egyenleg = $this->nyitoegyenleg + $this->sumbevetel - $this->sumkiadas;
    return $this->egyenleg;
}

private function hazipenztar_indulo_egyenleg($date){
    // ödőszak előtti kp kifizetés és bevétek összesen pénztárbizonylatokról
    
    $summkiadas = 0;
    $summbevetel = 0;
    
    $sql = "SELECT SUM(bizonylat_foosszegszam) AS kivet_osszes FROM ".$this->kiad_dbnames[$this->telephely]." WHERE datetime < '$date'"; 
    
    $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $summkiadas = $row["kivet_osszes"];
            }
        } else {
            $summkiadas = "hiba";
        }
    
    $sql = "SELECT SUM(bizonylat_foosszegszam) AS bevet_osszes FROM ".$this->bev_dbnames[$this->telephely]." WHERE datetime < '$date'"; 
    
    $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $summbevetel = $row["bevet_osszes"];
            }
        } else {
            $summbevetel = "hiba";
        }
  
    $egyenleg = $summbevetel - $summkiadas;
    
    $this->nyitoegyenleg = $egyenleg;
    
    return $egyenleg;
}

public function hazip_bizonylat_keres_form(){
    
    $month_ini = new DateTime("first day of last month");
    $today =  new DateTime("today");
    $html = "";
         
              
        $html .= '<div class="panel panel-danger">';
            $html .='<div class="panel-heading">Házipénztár bizonylatok keresése.</div>';
            $html .= '<div class="panel-body">';
                $html .= '<form  class="form-inline" action="' . $_SERVER['PHP_SELF'] . '?pid=page37" method="post" >'; 
                
                //lekérdezési időszak eleje
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Időszak eleje hónap :</label>
                        <div class=""><input type="date" class="form-control" name="startdate" value = "'.date("Y").'-01-01"></div>
                     </div>';
//              //lekérdezés időszak vége
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Időszak vége hónap:</label>
                        <div class=""><input type="date" class="form-control"  name="enddate" value = "'.date("Y-m-d").'"></div>
                     </div>';
         
                //gombok
                $html .= '<div class="form-group" style="padding-top:20px;padding-right: 1em;">';
                    $html .= '<label class="control-label"></label>';    
                    $html .='<div class="btn-group">';
                        
                        $html .='<button type="submit" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> Lekérdez</button>';
                        //$html .='<a href="#" onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
                        //$html .='<a href="#" onclick="copyClipboard()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a>';                   
                        
                        $html .= '</div>'
                . '</div>';        
                $html .= '</form>';
            
            $html .='</div>';
            $html .='<div class="panel-footer">BMM
                </div></div>';
                
            return $html;
    
}

public function UserPostQuery_Penztarbiz_kereses(){
    
    
     $html = "";
        $datas = array();
        $adatok = array(); // ide kerül a bizonylat két dim tömb adattartama
        
       if (isset($_POST["startdate"]) AND isset($_POST["enddate"])){
       // if (TRUE){
            // van post lekérdezés paraméterei
            
            
            $startdate =$_POST["startdate"];
            $enddate =$_POST["enddate"];
            
            $year = date("Y", strtotime($startdate));
            $month = date("m", strtotime($startdate));                             
            // táblázat fejléc része
            
            $html .= 'Nyitó egyenleg : '.$startdate.' - '.$this->hazipenztar_indulo_egyenleg($startdate).' Ft<br>';
            
            $html .= '<table class="table" id="riport">
            <thead>
                            
              <tr>
                <th>Gombok</th>
                <th>Dátum</th>
                <th>Sorszám</th>
                <th style="text-align:center;">Bevétel</th>
                <th style="text-align:center;">Kiadás</th>
                <th style="text-align:center;">Egyenleg</th>
                <th>Név/Biz.szám</th>
                <th>Jogcím/Szöveg</th>
                <th>Bevétel</th>
                <th>Kiadás</th>
                <th>Mell.</th>
                </tr>
            </thead>
            <tbody>';
            
            $begin = new DateTime( $startdate );
            $end   = new DateTime( $enddate );
            
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);
             
            foreach ($period as $i){
                
                $i->modify('+1 day');                
                $report_day = $i->format("Y-m-d");
                
                // bevételi bizonylatok
                $sql = "SELECT * FROM ".$this->bev_dbnames[$this->telephely]." WHERE datetime LIKE '%$report_day%'"; 
       
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    $recepcios ="";
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        $recepcios = $row["recepcio"];
                        //$style = "";
                        $bizonylat_adatok =  $row["bizonylat_adatok"];
                        //adatmezők feldolgozása
                        $datas = explode(',', $bizonylat_adatok);
                        
                        $lines =8;
                        //if ($this->telephely != 'P72'){$lines =8;} else {$lines = 20;}                        
                        $counter = 0;
                        for ($i=0;$i<$lines;$i++){       //sor
                            for ($j=0;$j<5;$j++){   // oszlop
                               $adatok[$i][$j] = $datas[$counter];
                               $counter ++;
                            }
                        } 
                        // következősor nem üres a sorokat szaggatott vonal választja el
                        if ($adatok[1][0] != "") {
                            $style = 'border-bottom-width:3px; border-bottom-style:dotted;border-bottom-color: #ddd;';
                           
                            
                        }
                        else {
                            $style = '';
                        }
                        $html .= '<tr><td>'
                                . '<form action="index.php?pid=page35"  method="post"><input type="text" name="jav_biz_tipus" value="bevetel" hidden ><input type="text" name="jav_biz_id" value="'.$row["bevpbiz_id"].'" hidden >'
                                . '<button class="btn btn-info" type="submitt"><i class="fa fa-eye" aria-hidden="true"></i></button></form></td>'
                                . '<td style="'.$style.'">'.$report_day.'</td>'
                                . '<td style="'.$style.'">B'.$this->make_soraszam($row["bevpbiz_id"]).'</td>'
                                . '<td style="'.$style.' text-align:center;">'.$row["bizonylat_foosszegszam"].'</td>'
                                . '<td style="'.$style.'"></td>'
                                . '<td style="'.$style.' text-align:center;">'.$this->pj_egyenleg('bev',$row["bizonylat_foosszegszam"]).'</td>'
                                . '<td style="'.$style.'">'.$row["bizonylat_nev"].'<br>'.$adatok[0][1].'</td>'
                                . '<td style="'.$style.'">'.$adatok[0][0].'<br>'.$adatok[0][3].'</td>'
                                . '<td style="'.$style.'">'.$adatok[0][4].'</td>'
                                . '<td style="'.$style.'"></td>'
                                . '<td style="'.$style.' text-align:center;">'.$row["bizonylat_melleklet"].'</td>'
                                . '</tr>';
                    
                    // adatok további feldolgozása soronként
                        for ($i = 1; $i < $lines;$i++){

                            if ($adatok[$i][0] != ""){

                                $html .= '<tr><td></td><td></td><td></td>'
                                        . '<td></td>'
                                        . '<td></td>'
                                        . '<td></td>'
                                        . '<td>'.$recepcios.'<br>'.$adatok[$i][1].'</td>'
                                        . '<td>'.$adatok[$i][0].'<br>'.$adatok[$i][3].'</td>'
                                        . '<td>'.$adatok[$i][4].'</td>'
                                        . '<td></td>'
                                        . '<td></td>'
                                        . '</tr>';

                            }
                        }
                    }
                } else {
                   // $html .= "<tr><td>".$report_day."- Bevetel: Nincs bizonylat</td></tr>";
                }
                
                // kiadási bizonylatok
                $sql = "SELECT * FROM ".$this->kiad_dbnames[$this->telephely]." WHERE datetime LIKE '%$report_day%'"; 
       
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    $recepcios ="";
                    while($row = $result->fetch_assoc()) {
                        $recepcios = $row["recepcio"];
                        $bizonylat_adatok =  $row["bizonylat_adatok"];
                        //adatmezők feldolgozása
                        $datas = explode(',', $bizonylat_adatok);
                        $counter = 0;
                        for ($i=0;$i<8;$i++){       //sor
                            for ($j=0;$j<5;$j++){   // oszlop
                               $adatok[$i][$j] = $datas[$counter];
                               $counter ++;
                            }
                        } 
                        // következősor nem üres a sorokat szaggatott vonal választja el
                        if ($adatok[1][0] != "") {$style = 'border-bottom-width:3px; border-bottom-style:dotted;border-bottom-color: #ddd;';}
                        else {
                            $style = '';
                        }
                        
                        $html .= '<tr><td><form action="index.php?pid=page35"  method="post">'
                                . '<input type="text" name="jav_biz_tipus" value="kiadas" hidden ><input type="text" name="jav_biz_id" value="'.$row["kiadpbiz_id"].'" hidden >'
                                . '<button class="btn btn-warning" type="submitt"><i class="fa fa-eye" aria-hidden="true"></i></button></form></td>'
                                . '<td style="'.$style.'">'.$report_day.'</td>'
                                . '<td style="'.$style.'">K'.$this->make_soraszam($row["kiadpbiz_id"]).'</td>'
                                . '<td style="'.$style.'"></td>'
                                . '<td style="'.$style.' text-align:center;">'.$row["bizonylat_foosszegszam"].'</td>'
                                . '<td style="'.$style.' text-align:center;">'.$this->pj_egyenleg('ki',$row["bizonylat_foosszegszam"]).'</td>'
                                . '<td style="'.$style.'">'.$row["bizonylat_nev"].'<br>'.$adatok[0][1].'</td>'
                                . '<td style="'.$style.'">'.$adatok[0][0].'<br>'.$adatok[0][3].'</td>'
                                . '<td style="'.$style.'"></td>'
                                . '<td style="'.$style.'">'.$adatok[0][4].'</td>'
                                . '<td style="'.$style.' text-align:center;">'.$row["bizonylat_melleklet"].'</td>'
                                . '</tr>';
                    
                    // adatok további feldolgozása soronként
                        for ($i = 1; $i < 8;$i++){

                            if ($adatok[$i][0] != ""){

                                $html .= '<tr><td></td><td></td><td></td>'
                                        . '<td></td>'
                                        . '<td></td>'
                                        . '<td></td>'
                                        . '<td>'.$recepcios.'<br>'.$adatok[$i][1].'</td>'
                                        . '<td>'.$adatok[$i][0].'<br>'.$adatok[$i][3].'</td>'
                                        . '<td></td>'
                                        . '<td>'.$adatok[$i][4].'</td>'
                                        . '<td></td>'
                                        . '</tr>';

                            }
                        }    
                        
                    }
                    
                } else {
                   // $html .= "<tr><td>".$report_day."- Kiadás: Nincs bizonylat</td></tr>";
                }     
                
                // összesítés adatai
            }    
                              
            
       $html .= '</tbody>
          </table>';
          
        }
      
    return $html;   
    }

    private function check_bevpbiz_today(){
       $html = "";
        
       $sql = "SELECT * FROM ".$this->bev_dbnames[$this->telephely]." WHERE datetime = '$this->date'";
       //echo $sql;
       $result = $this->dbconn->query($sql);
       
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $id = $this->make_soraszam($row["bevpbiz_id"]);
                $html = ' B'.$id.' bevételi bizonylat a mai napra már elkészült. Ha ezt a bizonylatot kell újra nyomtatni vagy javítani a <a href="./index.php?pid=page37">Rendelő pénztárbizonylatai</a> menűből újra nyomtatható.';  
            }
        } else {
            $html = "NULL";
        }
       
       return $html; 
        
        
    }

    private function check_kiadpbiz_today(){
       $html = "";
        
       $sql = "SELECT * FROM ".$this->kiad_dbnames[$this->telephely]." WHERE datetime = '$this->date'";
       //echo $sql;
       $result = $this->dbconn->query($sql);
       
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $id = $this->make_soraszam($row["kiadpbiz_id"]);
                $html = ' K'.$id.' kiadási bizonylat a mai napra már elkészült. Ha ezt a bizonylatot kell újra nyomtatni vagy javítani a <a href="./index.php?pid=page37">Rendelő pénztárbizonylatai</a> menűből újra nyomtatható.';  
            }
        } else {
            $html = "NULL";
        }
       
       return $html; 
        
        
    }
    
public function PenztargepZarasokForm(){
    $html = "";
    
    $html .= '<div class="panel panel-danger">';
            $html .='<div class="panel-heading">Napi pénztárgáp zárások visszakeresése rendelőnként.</div>';
            $html .= '<div class="panel-body">';
                $html .= '<form  class="form-inline" action="' . $_SERVER['PHP_SELF'] . '?pid=page76" method="post" >'; 
                
                //lekérdezési időszak eleje
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Időszak eleje :</label>
                        <div class=""><input type="date" class="form-control" name="pgzaras_startdate" value = "'.$this->date.'"></div>
                     </div>';
                //lekérdezés időszak vége
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Időszak vége :</label>
                        <div class=""><input type="date" class="form-control"  name="pgzaras_enddate" value = "'.$this->date.'"></div>
                     </div>';
                   
                //telephely
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Telephely :</label>
                        <div class="">';
                        
                        $html .='<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-building"></i></span>';
                            $html .='<select class = "form-control" name = "pgzaras__telephely">';
                            $html .= '<option value=""> Összes telephely </option>';
                            $sql = "SELECT * FROM telephelyek";
                            $result = $this->dbconn->query($sql);

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
                $html .= '<div class="form-group" style="padding-top:20px;padding-right: 1em;">';
                    $html .= '<label class="control-label"></label>';    
                    $html .='<div class="btn-group">';
                        
                        $html .='<button type="submit" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> Lekérdez</button>';
                        $html .='<a href="#" onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
                        $html .='<a href="#" onclick="CopyClipboard()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a>'                        
                        
                        . '</div>'
                . '</div>';        
                $html .= '</form>';
            
            $html .='</div>';
            $html .='<div class="panel-footer">BMM
                </div></div>';
    
    
    
    $html .= $this->AdminPostPgZarasQuery();
    
    return $html;
}    

public function AdminPostPgZarasQuery(){
    $html = "";
    
    if(isset($_POST["pgzaras__telephely"]) AND $_POST["pgzaras_startdate"] AND $_POST["pgzaras_enddate"]){
    
        $html = '<div class="container"><h3>'.$_POST["pgzaras__telephely"].' Pénztárgép zárásai '. $_POST["pgzaras_startdate"].' - '.$_POST["pgzaras_enddate"].'</h3>'; 
        
        $startdate = $_POST["pgzaras_startdate"];
        $enddate = $_POST["pgzaras_enddate"];
        $telephely = $_POST["pgzaras__telephely"];
        
        $html .= '<table class="table" id="riport">
            <thead>
                            
              <tr>
                <th>Megtekint</th>
                <th>Dátum</th>
                <th>Pénztárgép Zárás szám</th>
                <th>Recepcio</th>
                <th>Rendelő</th>
                <th>Kp összesen</th>
                </tr>
            </thead>
            <tbody>';
        
        $sql = "SELECT * FROM pgzarasok WHERE pg_telephely LIKE '%$telephely%' AND (pgzaras_date BETWEEN '$startdate 00:00:00' AND '$enddate 23:59:59')"; 
         echo $sql;   
        $result = $this->dbconn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $html .= '<tr>'
                         .'<td><form action="index.php?pid=page75" method="post">'
                        . '<input type="text" name="pg_zarasid" value="'.$row["pgzaras_id"].'" hidden><button class="btn btn-warning" type="submitt"><i class="fa fa-eye" aria-hidden="true"></i></button></form></td>'
                         .'<td>'.$row["pgzaras_date"].'</td>'
                         .'<td>'.$row["pg_zarasszam"].'</td>'
                         .'<td>'.$row["recepcio"].'</td>'
                         .'<td>'.$row["pg_telephely"].'</td>'
                         .'<td>'.$row["kp_osszes"].' Ft</td>'
                        .'</tr>';
                }
                
        } else {
           $html .= "Nincs eredmény! ";
        }
        $html .= '</table></div>';
    }

    return $html;
}   



private function Napi_Afa_Sum(){
   // bevétele summ afa kategoria szerint 
   $this->pg_afa27 = 0;
   $this->pg_afa5 = 0;
   $this->pg_TAM = 0;
    
   // nincs benne a kp partner  az afa kulcsos össesítéasben
        
                // összesített összegek 27 % afa
                $sql1 = "SELECT sum(bevetel_osszeg) as sum_afa FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                          . "date = '$this->date' AND torolt_szamla = '0' AND (bevetel_tipusa_id = 'kp-számla' OR bevetel_tipusa_id LIKE '%bankkártya%' OR  bevetel_tipusa_id LIKE '%egészségpénztár%')"
                          . "AND bevetel_afakulcs = '27'";

                $result1 = $this->dbconn->query($sql1);
                if ($result1->num_rows > 0) {
                      
                      while ($row1 = $result1->fetch_assoc()) {
                           $this->pg_afa27 = $row1["sum_afa"];
                           
                      }
                  } else {
                      $this->pg_afa27 = 0;
                  }

                // összesített összegek 5 % afa
                $sql2 = "SELECT sum(bevetel_osszeg) as sum_afa FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                          . "date = '$this->date' AND torolt_szamla = '0'  AND (bevetel_tipusa_id = 'kp-számla' OR bevetel_tipusa_id LIKE '%bankkártya%' OR  bevetel_tipusa_id LIKE '%egészségpénztár%') "
                          . "AND bevetel_afakulcs = '5' ";

                $result2 = $this->dbconn->query($sql2);
                if ($result2->num_rows > 0) {
                      
                      while ($row12 = $result2->fetch_assoc()) {
                           $this->pg_afa5 = $row12["sum_afa"];
                           
                      }
                  } else {
                      $this->pg_afa5 = 0;
                  }
               
                  
                // összesített összegek 0 % afa - rec kp kivét
                $sql3 = "SELECT sum(bevetel_osszeg) as sum_afa FROM napi_elszamolas WHERE telephely = '$this->telephely' AND "
                          . "date = '$this->date' AND torolt_szamla = '0'   AND (bevetel_tipusa_id = 'kp-számla' OR bevetel_tipusa_id LIKE '%bankkártya%' OR  bevetel_tipusa_id LIKE '%egészségpénztár%')"
                          . "AND bevetel_afakulcs = '0' ";

                $result3 = $this->dbconn->query($sql3);
                if ($result3->num_rows > 0) {
                      
                      while ($row13 = $result3->fetch_assoc()) {
                           $this->pg_TAM = $row13["sum_afa"];
                           
                      }
                  } else {
                      $this->pg_TAM = 0;
                  }
   
}
    
}


?>
