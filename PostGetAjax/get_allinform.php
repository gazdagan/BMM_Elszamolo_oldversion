<?php 
//orovosk lekérdezés az allin form számára az adott telephelyről

include ( "../includes/DbConnect.inc.php");
include ( "../includes/NapiElszClass.inc.php");

//kezelök listája az adot telephelyen
if (isset($_GET["kezelo_telephely_neve"]) AND isset($_GET["kezelo_tipus"])){
     
    $conn = DbConnect();
    $kezelo_telephely = $_GET["kezelo_telephely_neve"];
    $kezelo_tipus =$_GET["kezelo_tipus"];

    if($kezelo_tipus == "orvos"){
        $sql ="SELECT DISTINCT * FROM `kezelok_orvosok` WHERE kezelo_tipus = 'orvos' AND kezelo_telephely ='$kezelo_telephely' ORDER BY kezelo_neve ASC";
    } else {
        $sql ="SELECT DISTINCT * FROM `kezelok_orvosok` WHERE kezelo_tipus <> 'orvos' AND kezelo_telephely ='$kezelo_telephely' ORDER BY kezelo_neve ASC";
    }    

    $result2 = $conn->query($sql);
    echo '<label >Orvosok - kezelők:</label>';
    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
                    
                $kname=$row['kezelo_neve'];
            
                echo '<div class="radio">
                        <label><input type="radio" name="kezelo" value="'.$kname.'" onclick="szolgaltatasok_arak(this.value)">'.$kname.'</label>
                    </div>';
        }
    } else {echo "Nincs eredmény várjon...";}
      
    }   
 
// kezelőhöz rendelt szolgáltatások választása
if (isset($_GET["kezelo_neve"])){
        
        $conn = DbConnect();
        
        $gytBerlet = "";
        $gymBerlet = "";
        $fizikoBerlet = "";
        $lokesBerlet = "";
        $gytszolg = "";
        $allin ="";
        $orvosiszolg =  "";
        $orvosikieg = "";
        
        $kezelo_neve = $_GET["kezelo_neve"];
        //$sql ="SELECT DISTINCT * FROM `kezeles_arak_jutalek` INNER JOIN 'szolgaltatasok' ON szolgaltatasok.szolg_neve = kezeles_arak_jutalek.kezeles_tipus WHERE kezelo_neve = '$kezelo_neve' ORDER BY szolgaltatasok.szolg_tipus ASC";
        $sql ="SELECT DISTINCT * FROM `kezeles_arak_jutalek` INNER JOIN szolgaltatasok ON szolg_neve = kezeles_arak_jutalek.kezeles_tipus WHERE kezeles_arak_jutalek.kezelo_neve = '$kezelo_neve' ORDER BY szolgaltatasok.szolg_tipus ASC ";
       
        $result2 = $conn->query($sql);
        echo '<label >Szolgáltatások: '.$kezelo_neve.'</label><form id="szolg_ar_kivalaszto">';
            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {

                       $kezeles_tipus = $row["kezeles_tipus"];
                       $kezeles_ar = $row["kezeles_ar"];
                    //  $kezeles_ar_param = "'". $row['kezeles_ar']."'";
                       $kezeles_jutalek = $row["kezelo_jutalek"];
                       $szolg_tipus = $row["szolg_tipus"];
                       
                       $afa_tartam  = intval($row["kezeles_ar"] - ( $row["kezeles_ar"] / (($row["afa_kulcs"]+100)/100)));
                       
                       //$allin .= ' <div class="radio"><label><input type="checkbox" name="kezeles"  data-kezelesjutalek = "'.$kezeles_jutalek.'" data-kezelesar = "'.$kezeles_ar.'"  data-kezelestipus="'.$kezeles_tipus.'"   value = "'.$kezeles_tipus.'" onclick="szolgaltatas_modja()">'.$kezeles_tipus. ' -  '.$kezeles_ar .' Ft / '.$kezeles_jutalek.' Ft </label></div>';            
                       
                    // orvosi szolgáltatások
                       if ($szolg_tipus == "Orvosi / kiegészítő"){
                       
                            $orvosikieg .= ' <div class="checkbox"><label><input type="checkbox" name="kezeles"  data-afa_kulcs = "'.$row["afa_kulcs"].'" data-afa_tartam = "'.$afa_tartam.'" data-sell_type = "szolgáltás" data-kezelesjutalek = "'.$kezeles_jutalek.'" data-kezelesar = "'.$kezeles_ar.'"  data-kezelestipus="'.$kezeles_tipus.'"  value = "'.$kezeles_tipus.'" onclick="szolgaltatas_modja()">'.$kezeles_tipus. ' -  '.$kezeles_ar .' Ft </label></div>';
                                                 
                           
                       }else  if ($szolg_tipus == "Orvos"){
                      
                            $orvosiszolg .= ' <div class="radio"><label><input type="radio" name="kezeles" data-sell_type = ""szolgáltás" data-afa_kulcs = "'.$row["afa_kulcs"].'" data-afa_tartam = "'.$afa_tartam.'" data-kezelesjutalek = "'.$kezeles_jutalek.'" data-kezelesar = "'.$kezeles_ar.'"  data-kezelestipus="'.$kezeles_tipus.'"   value = "'.$kezeles_tipus.'" onclick="szolgaltatas_modja()">'.$kezeles_tipus. ' -  '.$kezeles_ar .' Ft </label></div>';
                      
                       }
                       
                       // gyógytorna fizio és egyéb szolgáltatások csoportosítva
                       
                       if ($szolg_tipus == "Gyógytorna"){
            
                           $gytszolg .= '<div class="radio"><label><input type="radio" name="kezeles" data-sell_type = ""szolgáltás" data-afa_kulcs = "'.$row["afa_kulcs"].'" data-afa_tartam = "'.$afa_tartam.'" data-kezelesjutalek = "'.$kezeles_jutalek.'" data-kezelesar = "'.$kezeles_ar.'"  data-kezelestipus="'.$kezeles_tipus.'"   value = "'.$kezeles_tipus.'" onclick="szolgaltatas_modja()">'.$kezeles_tipus. ' -  '.$kezeles_ar .' Ft </label></div>';
                                                  
                       }
                       
                       if ($szolg_tipus == "Bérlet"){
                           
                           if (strpos($kezeles_tipus, 'Gyógytorna') !== FALSE){
                               
                               $gytBerlet .= '<div class="radio"><label><input type="radio" name="kezeles" data-sell_type = szolgáltás" data-afa_kulcs = "'.$row["afa_kulcs"].'" data-afa_tartam = "'.$afa_tartam.'" data-kezelesjutalek = "'.$kezeles_jutalek.'" data-kezelesar = "'.$kezeles_ar.'"  data-kezelestipus="'.$kezeles_tipus.'"   value = "'.$kezeles_tipus.'" onclick="szolgaltatas_modja()">'.$kezeles_tipus. ' -  '.$kezeles_ar .' Ft </label></div>';
                               
                           }
                           
                           if (strpos($kezeles_tipus, 'Gyógymasszázs') !== FALSE OR  strpos($kezeles_tipus, 'Nyirokmasszázs') !== FALSE){
                               
                               $gymBerlet .= '<div class="radio"><label><input type="radio" name="kezeles" data-sell_type = "szolgaltats" data-afa_kulcs = "'.$row["afa_kulcs"].'" data-afa_tartam = "'.$afa_tartam.'" data-kezelesjutalek = "'.$kezeles_jutalek.'" data-kezelesar = "'.$kezeles_ar.'"  data-kezelestipus="'.$kezeles_tipus.'"   value = "'.$kezeles_tipus.'" onclick="szolgaltatas_modja()">'.$kezeles_tipus. ' -  '.$kezeles_ar .' Ft </label></div>';
                               
                           }
                           
                           if (strpos($kezeles_tipus, 'Fizikoterápia') !== FALSE){
                               
                               $fizikoBerlet .= '<div class="radio"><label><input type="radio" name="kezeles" data-sell_type = "szolgaltats" data-afa_kulcs = "'.$row["afa_kulcs"].'" data-afa_tartam = "'.$afa_tartam.'" data-kezelesjutalek = "'.$kezeles_jutalek.'" data-kezelesar = "'.$kezeles_ar.'"  data-kezelestipus="'.$kezeles_tipus.'"   value = "'.$kezeles_tipus.'" onclick="szolgaltatas_modja()">'.$kezeles_tipus. ' -  '.$kezeles_ar .' Ft  </label></div>';
                               
                           }
                           
                           if (strpos($kezeles_tipus, 'Lökéshullám') !== FALSE){
                               
                               $lokesBerlet .= '<div class="radio"><label><input type="radio" name="kezeles" data-sell_type = "szolgaltats" data-afa_kulcs = "'.$row["afa_kulcs"].'" data-afa_tartam = "'.$afa_tartam.'" data-kezelesjutalek = "'.$kezeles_jutalek.'" data-kezelesar = "'.$kezeles_ar.'"  data-kezelestipus="'.$kezeles_tipus.'"   value = "'.$kezeles_tipus.'" onclick="szolgaltatas_modja()">'.$kezeles_tipus. ' -  '.$kezeles_ar .' Ft  </label></div>';
                               
                           }
                           
                           
                       }
                       
                       

                }
           } else {
           echo "Nincs eredmény ....!";
    }
    
    echo '<ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Kezelés</a></li>
            <li><a data-toggle="tab" href="#menu1">Gyógytorna</a></li>
            <li><a data-toggle="tab" href="#menu2">Masszázs</a></li>
            <li><a data-toggle="tab" href="#menu3">Fizikoterápia</a></li>
            <li><a data-toggle="tab" href="#menu4">Lökéshullám</a></li>
            
          </ul>

          <div class="tab-content" style="border: solid 1px lightgrey; padding: 10px; border-radius: 5px;">
            <div id="home" class="tab-pane fade in active">   
            <h4>Egy alkalmas kezelések</h4>
              '.$orvosiszolg.' '.$orvosikieg.' '.$gytszolg.'
            </div>
            <div id="menu1" class="tab-pane fade">
              <h4>Gyógytorna bérletek</h4>
              '.$gytBerlet.'
            </div>
            <div id="menu2" class="tab-pane fade">
              <h4>Masszázs bérletek</h4>
              '.$gymBerlet.'
            </div>
            <div id="menu3" class="tab-pane fade">
              <h4>Fizikoterápia bérletek</h4>
               '.$fizikoBerlet.'
            </div>
            <div id="menu4" class="tab-pane fade">
              <h4>Lökéshullám bérletek</h4>
               '.$lokesBerlet.'
            </div>
           
          </div>';
    
    
    
    echo '</form>';
    echo '<br><div class="btn-group-vertical"><button type="button" class="btn btn-warning btn-xs"  value ="egyedi_ar" onclick="egyedi_arak_szolg(this.value)" ><i class="fa fa fa-money" aria-hidden="true"></i>  Egyedi árazás       </button>';
    echo '<button type="button" class="btn btn-warning btn-xs"  value ="egyedi_szolg" onclick="egyedi_arak_szolg(this.value)"><i class="fa fa-product-hunt" aria-hidden="true"></i>   Egyedi szolgáltatás </button></div><br>';
    echo '<label>Dolgozói kedvezmények:</label>';
    echo '<br><div class="btn-group-vertical">'
    . '<button type="button" class="btn btn-info btn-xs"  value ="bmmegeszseg1" onclick="egyedi_arak_szolg(this.value)"><i class="fa fa-gift" aria-hidden="true" ></i> BMM mk 100% 1. alkalom  </button>';
    echo '<button type="button" class="btn btn-info btn-xs"  value ="bmmegeszseg2" onclick="egyedi_arak_szolg(this.value)"><i class="fa fa-gift" aria-hidden="true" ></i> BMM mk 20%   </button></div>';
//    echo '<div class="radio">
//                 <label><input type="radio" name="fizmod"  value ="egyedi" onclick="fizetes_modja(this.value)">Egyedi árazás</label>
//        </div>';
}
/**
 * előrögzítéses adatok mentése a beteglista táblába 
 * onnan visszaolvas és táblázatban visszaadja az adatrözzítési form alá
 *
*/

if (isset($_GET["telephely_el"]) AND isset($_GET["paciens_el"]) AND isset($_GET["kezelo_el"]) AND isset($_GET["rogzito_el"])) {
    
    // előrogzítés adatai insert db table
    
    $telehely_el = $_GET["telephely_el"];
    $paciens_el = $_GET["paciens_el"];
    $kezelo_el = $_GET["kezelo_el"];
    $date_el = date("y-m-d");
    $rogzito = $_GET["rogzito_el"];

    $conn = DbConnect();
    if($paciens_el != ""){
        
        $sql = "INSERT INTO napi_beteglista (beteg_neve,kezelo_neve,telephely,date_el,rogzito)
                                 VALUES ('$paciens_el','$kezelo_el','$telehely_el','$date_el','$rogzito')";
            
            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
    }
   
    $bteg_el_tebale =new napi_elszamolas;
    $bteg_el_tebale -> VisualizeNapiElőjegyzésTable($telehely_el); 
}

/**
 * Beteglistáról beteglista id érkezett törlésre
 * 
 *
 */
if (isset($_GET["beteg_torles_el"]) AND isset($_GET["telephely_el"])){
    
    $conn = DbConnect();
   
    $beteglista_id = $_GET["beteg_torles_el"];
    $telehely_el = $_GET["telephely_el"];
    $sql = "UPDATE napi_beteglista  SET torolt_beteg = '1' WHERE beteglista_id = '$beteglista_id'"; 

        if (mysqli_query($conn, $sql)) {
            // echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        $bteg_el_tebale =new napi_elszamolas;
        $bteg_el_tebale -> VisualizeNapiElőjegyzésTable($telehely_el); 
    

}

/**
 * beteglistáról a páciens rögzítésre került 
 */

if (isset($_GET["beteg_rogzitve_el_id"]) AND isset($_GET["telephely_el"])){
    
    $conn = DbConnect();
    
    $beteglista_id = $_GET["beteg_rogzitve_el_id"];
    $telehely_el = $_GET["telephely_el"];
    $sql = "UPDATE napi_beteglista  SET rogzitett_beteg = '1' WHERE beteglista_id = '$beteglista_id'"; 

        if (mysqli_query($conn, $sql)) {
            // echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        $bteg_el_tebale =new napi_elszamolas;
        $bteg_el_tebale -> VisualizeNapiElőjegyzésTable($telehely_el); 
}


?>