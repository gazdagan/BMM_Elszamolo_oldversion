<?php

/* 
 készlet adatok lekérdezése eladéskor
 */

require_once ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");
include ("../includes/keszletnyilvantartasClass.php");


// azok a termékkategóriák amelyek az adott telephelyen elérhetőek
if (isset($_GET["keszlet_telephely_neve"])){
$html="";
$conn = DbConnect();
$html ='<div class="form-group" id="selectkeszletkategoria"><label>Készlet kategóriák:</label>';

$telephely = $_GET["keszlet_telephely_neve"];


$sql1 = "SELECT * FROM aru_kategoria";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
    // output data of each row
    while($row = $result1->fetch_assoc()) {
          $html .= '<div class="radio"><label><input type="radio" name="kategoria" id="kat_id'.$row["kategoria_id"].'" date-telephely = "'.$telephely.'"  date-kategorianame="'.$row["kategoria_neve"].'" data-kategoriaid="'.$row["kategoria_id"].'" onclick="keszlet_tetelek(this.id)">' .$row["kategoria_neve"].'</label></div>';
    }
    $html .= "</div>";
    echo $html;
} else {
    echo "0 results";
}

$conn->close();
   
}

if (isset($_GET["kategoria_id"]) AND isset($_GET["keszlet_raktar"])){
$html="";
$conn = DbConnect();
$html ='<div class="form-group" id="selectkeszlettetelek"><label>Készlet tételek:</label>';

$kategoria_id =  $_GET["kategoria_id"];
$keszlet_raktar = $_GET["keszlet_raktar"];


$html .= '<table class="table table-hover">
                        <thead>
                        <tr>
                          <th>Áru neve / Méret</th>
                          <th>Eladás DB</th>
                          <th>Eladási Ár</th>
                          <th style="text-align:right;">Készlet db</th>
                        </tr>
                      </thead><tbody>';

//<th>Vényes Ár</th><th>Akciós Ár</th>

$sql = "SELECT * FROM aru_cikktorzs WHERE aru_kategoria = '$kategoria_id' ORDER BY aru_name";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
              
            $aru_id = $row["aru_id"];
            
            //$sql1 = "SELECT * FROM aru_keszlet INNER JOIN aru_cikktorzs ON aru_cikktorzs.aru_id = aru_keszlet.keszlet_aru_id WHERE keszlet_aru_id = '$aru_id' AND keszlet_raktar = '$keszlet_raktar' ORDER BY keszlet_id DESC LIMIT 1";
            $sql1 = "SELECT * FROM aru_keszlet INNER JOIN aru_cikktorzs ON aru_cikktorzs.aru_id = aru_keszlet.keszlet_aru_id WHERE keszlet_aru_id = '$aru_id' AND keszlet_raktar = '$keszlet_raktar' AND aru_torolt = '0' ORDER BY keszlet_id DESC LIMIT 1 ";
        
            $result1 = $conn->query($sql1);
          
            if ($result1->num_rows > 0) {
                // output data of each row
                while($row1 = $result1->fetch_assoc()) {
                   
                    if ($row1["keszlet_db"] <= 0){$class="danger";}else{$class="";}
                    $afa_eladas = intval($row1["aru_eladasi_ar"]- ( $row1["aru_eladasi_ar"] / (($row1["aru_afa"]+100)/100)));
                    $afa_venyes = intval($row1["aru_venyes_ar"]- ( $row1["aru_venyes_ar"] / (($row1["aru_afa"]+100)/100)));
                    $afa_akcios = intval($row1["aru_akcios_ar"]- ( $row1["aru_akcios_ar"] / (($row1["aru_afa"]+100)/100)));
                    $db_id = "'".$row1["keszlet_id"]."edb'";
                    $ar_id = "'".$row1["keszlet_id"]."ear'";
                    $html .= '<tr class="'.$class.'">'
                               .'<td>'.$row1["aru_name"].' / '.$row1["aru_meret"].'</td>'.
                               '<td style="width:100px"><label><input name="cikk" type="number" id="'.$row1["keszlet_id"].'edb" class="form-control" value=1 placeholder = "1 darab" min=1 onchange="ClicktoKeszletAr('.$ar_id.')" onclick="ClicktoKeszletAr('.$ar_id.')"></label></td>'.
                               '<td><label><input name="cikk" type="radio" id="'.$row1["keszlet_id"].'ear"  data-sell_type = "keszlet_norm" data-veny_artam="0"  data-ar="'.$row1["aru_eladasi_ar"].'" data-afa="'.$afa_eladas.'" data-afakulcs = "'.$row1["aru_afa"].'" data-cikk="'.$row1["aru_name"].' / '.$row1["aru_meret"].'" data-cikkid="'.$aru_id.'" onclick="keszlet_eladas('.$db_id.',this.id)"> '.$row1["aru_eladasi_ar"].' Ft </label></td>'.
                            //   '<td><label><input name="cikk" type="radio"  id="'.$row1["keszlet_id"].'var" data-sell_type = "keszlet_venyes" data-veny_artam="'.$row1["aru_cikkszam"].'" data-ar="'.$row1["aru_venyes_ar"].'"  data-afa="'.$afa_venyes.'" data-afakulcs = "'.$row1["aru_afa"].'" data-cikk="'.$row1["aru_name"].' / '.$row1["aru_meret"].'"  data-cikkid="'.$aru_id.'" onclick="keszlet_eladas('.$db_id.',this.id)"> '.$row1["aru_venyes_ar"].' Ft </label></td>'.
                            //   '<td><label><input name="cikk" type="radio"  id="'.$row1["keszlet_id"].'aar" data-sell_type = "keszlet_akcio" data-veny_artam="0"  data-ar="'.$row1["aru_akcios_ar"].'"  data-afa="'.$afa_akcios.'" data-afakulcs = "'.$row1["aru_afa"].'" data-cikk="'.$row1["aru_name"].' / '.$row1["aru_meret"].'"  data-cikkid="'.$aru_id.'" onclick="keszlet_eladas('.$db_id.',this.id)"> '.$row1["aru_akcios_ar"].' Ft </label></td>'.
                               '<td style="text-align:right;">'.$row1["keszlet_db"].' db</td>'.
                            '</tr>';
                    
                    
                }
            } else {
               // $html .= "<tr> nincs készleten Aru ID: " .$aru_id."</tr>";
            }  
            
         
           
        }
    } else {
        // $html .= "<tr> nincs készleten Kat ID: " .$kategoria_id."</tr>";
    }
 $html .= "</table></div>";
 $html .='<div class="btn-group-vertical"><button type="button" class="btn btn-warning btn-xs" value="egyedi_ar" onclick="egyedi_arak_szolg(this.value)"><i class="fa fa fa-money" aria-hidden="true"></i>  Egyedi árazás       </button><button type="button" class="btn btn-warning btn-xs" value="egyedi_szolg" onclick="egyedi_arak_szolg(this.value)"><i class="fa fa-product-hunt" aria-hidden="true"></i>   Egyedi szolgáltatás </button></div>';    

 echo $html;
$conn->close();
   
}