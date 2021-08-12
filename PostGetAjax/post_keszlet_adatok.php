<?php

/*
 * készlet kategória hozzáadása
 */

require_once ( "../includes/DbConnect.inc.php");
include ( "../includes/Inputvalidation.inc.php");
include ("../includes/keszletnyilvantartasClass.php");

session_id($_COOKIE["PHPSESSID"]);
session_start();


if (isset($_POST["kategoria_name"])){

    $kategoria_neve = test_input($_POST["kategoria_name"]);
    $conn = DbConnect();

    $sql = "INSERT INTO aru_kategoria (kategoria_neve)  VALUES ('$kategoria_neve')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }


}



if (isset($_POST["kategoria_name_update"])  AND isset($_POST["kategoria_id"]) ){

    $kategoria_neve = test_input($_POST["kategoria_name_update"]);
    $kategoria_id = test_input($_POST["kategoria_id"]);

    $conn = DbConnect();

    $sql = "UPDATE aru_kategoria SET kategoria_neve='$kategoria_neve' WHERE kategoria_id='$kategoria_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }



}

if (isset($_POST["delete_kategoria_id"])  ){

    $kategoria_id = test_input($_POST["delete_kategoria_id"]);

    $conn = DbConnect();

    $sql = "UPDATE aru_kategoria SET kategoria_torolt = '1' WHERE kategoria_id = '$kategoria_id'";
    
        if ($conn->query($sql) === TRUE) {
            echo "Record kategoria soft deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

}

if (isset($_POST["select"]) OR (isset($_POST["select"]) AND isset($_POST["query"]))){

    $select = test_input($_POST["select"]);
    $table = new keszletnyilvantartasClass();
    $query = "null";

    if (isset($_POST["query"]))  {$query = test_input($_POST["query"]);} else {$query = "";}


    if ($select == "kategoria"){

        echo $table->kategoria_lista();
    }

    if ($select == "beszallito"){

        echo $table->beszallito_lista();
    }

    if ($select == "cikktorzs"){
       
        echo $table->cikktorzs_lista($query);
    }

    if ($select == "keszlet"){

        echo $table->keszlet_lista();
    }
    if ($select == "beszerzes"){

        echo $table->beszerzes_lista($query);
    }
}


if (isset($_POST["insert_beszallito"]) AND $_POST["insert_beszallito"] == 'insert'){

    $beszallito_neve  = test_input($_POST["beszallito_name"]);
    $conn = DbConnect();

    $sql = "INSERT INTO aru_beszallito VALUES ()";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }


}


if (isset($_POST["besz_name_update"])  AND isset($_POST["besz_id"]) AND isset($_POST["besz_email"]) ){

    $besz_name_update = test_input($_POST["besz_name_update"]);
    $besz_id = test_input($_POST["besz_id"]);
    $besz_email = test_input($_POST["besz_email"]);
    
    $conn = DbConnect();

    $sql = "UPDATE aru_beszallito SET besz_neve = '$besz_name_update', besz_email = '$besz_email' WHERE besz_id = '$besz_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }



}

if (isset($_POST["delete_beszallito_id"])  ){

    $besz_id = test_input($_POST["delete_beszallito_id"]);

    $conn = DbConnect();
      
    
    $sql = "UPDATE aru_beszallito SET besz_torolt = '1' WHERE besz_id = '$besz_id'";
    
        if ($conn->query($sql) === TRUE) {
            echo "Record beszállító soft deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

}

if (isset($_POST["cikktorzs_insert"])  ){

    //$besz_id = test_input($_POST["delete_beszallito_id"]);

    $conn = DbConnect();

    $sql = "INSERT INTO aru_cikktorzs VALUES ()";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

}

if (isset($_POST["delete_cikktorzs_id"])  ){

    $aru_id = test_input($_POST["delete_cikktorzs_id"]);

    $conn = DbConnect();

    //$sql = "DELETE FROM aru_cikktorzs WHERE aru_id='$aru_id'";
    $sql = "UPDATE aru_cikktorzs SET aru_torolt = '1' WHERE aru_id='$aru_id'";
    
        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

}


if (isset($_POST["aru_update"])  AND isset($_POST["aru_id"]) ){


    $aru_id = test_input($_POST["aru_id"]);
    $aru_name = test_input($_POST["aru_name"]);
    $aru_beszerzesi_ar = test_input($_POST["aru_beszerzesi_ar"]);
    $aru_be_szamlaszam = test_input($_POST["aru_be_szamlaszam"]);
    $aru_beszallito = test_input($_POST["aru_beszallito"]);
    $aru_kategoria  = test_input($_POST["aru_kategoria"]);
    $aru_eladasi_ar = test_input($_POST["aru_eladasi_ar"]);
    $aru_venyes_ar = test_input($_POST["aru_venyes_ar"]);
    $aru_afa = test_input($_POST["aru_afa"]);
    $aru_cikkszam =  test_input($_POST["aru_cikkszam"]);
    $aru_akcios_ar = test_input($_POST["aru_akcios_ar"]);
    $aru_meret = test_input($_POST["aru_meret"]);
    //$aru_type = test_input($_POST["aru_type"]);
    $conn = DbConnect();

    $sql = "UPDATE aru_cikktorzs SET "
            . "aru_name = '$aru_name', "
            . "aru_cikkszam = '$aru_cikkszam', "
            . "aru_meret = '$aru_meret', "
            . "aru_beszerzesi_ar = '$aru_beszerzesi_ar',"
            . "aru_be_szamlaszam = '$aru_be_szamlaszam', "
            . "aru_beszallito = '$aru_beszallito', "
            . "aru_kategoria = '$aru_kategoria', "
            . "aru_eladasi_ar = '$aru_eladasi_ar', "
            . "aru_venyes_ar = '$aru_venyes_ar', "
            . "aru_akcios_ar = '$aru_akcios_ar', "
            . "aru_afa = '$aru_afa'" 
            //. "aru_type = '$aru_type'" 
            . "WHERE aru_id = '$aru_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

}


if (isset($_POST["keszlet"])  AND isset($_POST["aru_id"]) AND $_POST["keszlet"] == "insert"){

    $conn = DbConnect();
    $aru_id = test_input($_POST["aru_id"]);
    $usename = $_SESSION['real_name'];

        // ha nincs készlten készletre vasszük
        $sql1 = "INSERT INTO aru_keszlet (keszlet_aru_id,keszlet_log) VALUES ('$aru_id','$usename')";

            if ($conn->query($sql1) === TRUE) {
                echo "New record created successfully". $username;
            } else {
                echo "Error: " . $sql1 . "<br>" . $conn->error;
            }



}



if (isset($_POST["delete_aru_keszlet_id"])  ){

    $keszlet_id = test_input($_POST["delete_aru_keszlet_id"]);

    $conn = DbConnect();

    $sql = "DELETE FROM aru_keszlet WHERE keszlet_id='$keszlet_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

}


if (isset($_POST["keszlet_insert"])  AND isset($_POST["keszlet_cikk_id"]) ){


    $keszlet_aru_id = test_input($_POST["keszlet_cikk_id"]);
    $keszlet_db = test_input($_POST["keszlet_db"]);
    $keszlet_raktar = test_input($_POST["keszlet_raktar"]);
    $usename = $_SESSION['real_name'];
    
    $conn = DbConnect();
    if ($keszlet_db >=0){
    $sql = "INSERT INTO aru_keszlet (keszlet_aru_id, keszlet_db, keszlet_raktar, keszlet_log)
        VALUES ('$keszlet_aru_id', '$keszlet_db', '$keszlet_raktar','$usename')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }else{ echo "Keszlet db < 0 ";}
}



if (isset($_POST["beszerzes"])  AND isset($_POST["aru_id"]) AND $_POST["beszerzes"] == "insert"){

    $conn = DbConnect();
    $aru_id = test_input($_POST["aru_id"]);


        // ha nincs készlten készletre vasszük
        $sql1 = "INSERT INTO aru_beszerzes (besz_aru_id) VALUES ('$aru_id')";

            if ($conn->query($sql1) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql1 . "<br>" . $conn->error;
            }


}


if (isset($_POST["besz_ar"])  AND isset($_POST["besz_db"]) AND isset($_POST["besz_szamlaszam"]) AND isset($_POST["besz_id"])){

    $besz_ar = test_input($_POST["besz_ar"]);
    $besz_db = test_input($_POST["besz_db"]);
    $besz_szamlaszam = test_input($_POST["besz_szamlaszam"]);
    $besz_id =  test_input($_POST["besz_id"]);
    $besz_beszallito_id = test_input($_POST["besz_beszallito_id"]);
    $bezs_real_date = test_input($_POST["besz_real_date"]);
    $besz_atlagarkalk = test_input($_POST["besz_atlagarkalk"]);
    $besz_beszerzes_alatt = test_input($_POST["besz_beszerzes_alatt"]);
   
    $conn = DbConnect();

    $sql = "UPDATE aru_beszerzes SET "
            . "besz_ar = '$besz_ar', "
            . "besz_db = '$besz_db', "
            . "besz_szamlasz = '$besz_szamlaszam', "
            . "besz_beszallito_id = '$besz_beszallito_id',"
            . "besz_beszerzes_alatt = '$besz_beszerzes_alatt',"
            . "besz_atlagarkalk = '$besz_atlagarkalk', "
            . "besz_real_date =  '$bezs_real_date'"
            . "WHERE besz_id = '$besz_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully:";
                      
            Avg_PriceCalac($besz_id);


        } else {
            echo "Error updating record: " . $conn->error;
        }


}


function Avg_PriceCalac($besz_id){
    // besz cikkszam aru_id
$aru_id = "null";
$aru_avgprice = 0;
$sum_db = 0 ;
$sum_arxdb = 0;
$conn = DbConnect();

$sql = "SELECT * FROM aru_beszerzes WHERE besz_id = '$besz_id'";
$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
           $aru_id = $row["besz_aru_id"];
           //
           $sql1 = "SELECT * FROM aru_beszerzes WHERE besz_aru_id = '$aru_id' AND besz_atlagarkalk = '1'  AND besz_torolt = '0'";
                $result1 = $conn->query($sql1);

                if ($result1->num_rows > 0) {
                    // output data of each row
                    while($row = $result1->fetch_assoc()) {

                        $sum_arxdb += $row["besz_ar"] * $row["besz_db"];
                        $sum_db += $row["besz_db"];

                    }
                } else {
                    echo "átlagár kalkulácó lekérdezés hiba";
                }
        }
    } else {
        echo "nincs ilyen beszezés az átlagár kalkulációhoz";
    }
    
    if ($sum_db != 0){$aru_avgprice = $sum_arxdb / $sum_db; } else {$aru_avgprice=$sum_arxdb;}

    echo $aru_id + ' AVG price : ' + $aru_avgprice;
    // update cikkrzs

      $sql1 = "UPDATE aru_cikktorzs SET aru_beszerzesi_ar = '$aru_avgprice' WHERE aru_id = '$aru_id'";

        if ($conn->query($sql1) === TRUE) {
            echo "Cikktörzs átlagár Record updated successfully";

        } else {
            echo "Error updating record: " . $conn->error;
        }

}




if (isset($_POST["delete_beszerzes_id"])  ){

    $besz_id = test_input($_POST["delete_beszerzes_id"]);

    $conn = DbConnect();

   // $sql = "DELETE FROM aru_beszerzes WHERE besz_id='$besz_id'";
   $sql = "UPDATE aru_beszerzes SET besz_torolt = '1' WHERE besz_id = '$besz_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

}

if (isset($_POST["besz_keszletre_atvezet"]) AND  isset($_POST["besz_id"]) ){
  
    $besz_id =  test_input($_POST["besz_id"]);
    $besz_keszletre_atvezet =  test_input($_POST["besz_keszletre_atvezet"]);
       
    $conn = DbConnect();

    $sql = "UPDATE aru_beszerzes SET besz_keszletre_atvezet = '$besz_keszletre_atvezet' WHERE besz_id = '$besz_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully: besz_készletrevétel";
               
           } else {
            echo "Error updating record: " . $conn->error;
           }

}


if (isset($_POST["keszlet_update_from_beszerzes"])  AND isset($_POST["keszlet_cikk_id"]) ){


    $keszlet_aru_id = test_input($_POST["keszlet_cikk_id"]);
    $keszlet_db = test_input($_POST["keszlet_db"]);
    $keszlet_raktar = test_input($_POST["keszlet_raktar"]);
    $usename = $_SESSION['real_name'];
    $conn = DbConnect();
    
    
            $sql1 = "SELECT * FROM aru_keszlet WHERE keszlet_raktar = '$keszlet_raktar'  AND keszlet_aru_id = '$keszlet_aru_id' ORDER BY keszlet_id DESC LIMIT 1";
            $result1 = $conn->query($sql1);

            if ($result1->num_rows > 0) {
                // output data of each row
                while($row = $result1->fetch_assoc()) {
                    $keszlet_db = $row["keszlet_db"] + $keszlet_db;
                    echo "keszlett db raktáron: ".$row["keszlet_db"]. " keszlet_id: ".$row["keszlet_id"]; 
                }
            } else {
                echo "keszlett update hiba: ". $keszlet_aru_id ; 
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
  
            // készletre vétel növelt db számmal vagy újként
                if ($keszlet_db >=0){
                        $sql = "INSERT INTO aru_keszlet (keszlet_aru_id, keszlet_db, keszlet_raktar, keszlet_log)
                            VALUES ('$keszlet_aru_id', '$keszlet_db', '$keszlet_raktar','$username')";

                            if ($conn->query($sql) === TRUE) {
                                echo "New record created successfully" .$username ;
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                        }else{ echo "Keszlet db < 0 ";}   
            
            // beszerzés alatt pipa kivesz besz_id kell
        
}


if (isset($_POST["undo_item_from_keszlet"]) AND isset($_POST["keszlet_aru_id"]) ){

    $keszlet_aru_id = test_input($_POST["keszlet_aru_id"]);

    $conn = DbConnect();

    $sql = "UPDATE aru_keszlet SET keszlet_torolt = '1' WHERE keszlet_aru_id = '$keszlet_aru_id'  AND keszlet_torolt = '0' ORDER BY keszlet_id DESC LIMIT 1";
    
        if ($conn->query($sql) === TRUE) {
            echo "Record soft deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

}


if (isset($_POST["delete_item_from_keszlet"]) AND isset($_POST["keszlet_aru_id"]) ){

    $keszlet_aru_id = test_input($_POST["keszlet_aru_id"]);

    $conn = DbConnect();

    $sql = "UPDATE aru_keszlet SET keszlet_torolt = '1' WHERE keszlet_aru_id = '$keszlet_aru_id'  AND keszlet_torolt = '0'";
    
        if ($conn->query($sql) === TRUE) {
            echo "Record soft deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

}



if (isset($_POST["keszlet_select_datum"])){
    
    $keszlet_datum = test_input($_POST["keszlet_select_datum"]);
    
    $table = new keszletnyilvantartasClass();
   
    echo $table->keszlet_lista_date($keszlet_datum);
    
    
}


if (isset($_POST["get_item_db_keszlet"]) AND isset($_POST["keszlet_aru_id"])){

    $bmmdb="";
    $fiziodb="";
    $obudadb="";
    $p70db ="";
    $labcentrumdb="";
    $kozpontidb="";

    $keszlet_aru_id = test_input($_POST["keszlet_aru_id"]);

    $conn = DbConnect();
    
    $sql1 = "SELECT * FROM aru_keszlet WHERE keszlet_raktar = 'BMM'  AND keszlet_aru_id = '$keszlet_aru_id' AND keszlet_torolt = '0' ORDER BY keszlet_id DESC LIMIT 1";
    $result = $conn->query($sql1);
    
    if ($result->num_rows > 0) {
    // output data of each row
            while($row = $result->fetch_assoc()) {
            $bmmdb = $row["keszlet_db"];
            }
        } else {
            $bmmdb = 'null';
        }
    
        
    $sql2 = "SELECT * FROM aru_keszlet WHERE keszlet_raktar = 'Fizio'  AND keszlet_aru_id = '$keszlet_aru_id' AND keszlet_torolt = '0'  ORDER BY keszlet_id DESC LIMIT 1";
    $result2 = $conn->query($sql2);
    
    if ($result2->num_rows > 0) {
    // output data of each row
            while($row2 = $result2->fetch_assoc()) {
            $fiziodb = $row2["keszlet_db"];
            }
        } else {
            $fiziodb = 'null';
        }    
    
    $sql3 = "SELECT * FROM aru_keszlet WHERE keszlet_raktar = 'Obuda'  AND keszlet_aru_id = '$keszlet_aru_id'  AND keszlet_torolt = '0' ORDER BY keszlet_id DESC LIMIT 1";
    $result3 = $conn->query($sql3);
    
    if ($result3->num_rows > 0) {
    // output data of each row
            while($row3 = $result3->fetch_assoc()) {
           $obudadb = $row3["keszlet_db"];
            }
        } else {
           $obudadb = 'null';
        }       
    
    $sql4 = "SELECT * FROM aru_keszlet WHERE keszlet_raktar = 'P70'  AND keszlet_aru_id = '$keszlet_aru_id'  AND keszlet_torolt = '0' ORDER BY keszlet_id DESC LIMIT 1";
    $result4 = $conn->query($sql4);
    
    if ($result4->num_rows > 0) {
    // output data of each row
            while($row4 = $result4->fetch_assoc()) {
           $p70db = $row4["keszlet_db"];
            }
        } else {
           $p70db = 'null';
        }       
        
    $sql5 = "SELECT * FROM aru_keszlet WHERE keszlet_raktar = 'Labcentrum'  AND keszlet_aru_id = '$keszlet_aru_id'  AND keszlet_torolt = '0' ORDER BY keszlet_id DESC LIMIT 1";
    $result5 = $conn->query($sql5);
    
    if ($result5->num_rows > 0) {
    // output data of each row
            while($row5 = $result5->fetch_assoc()) {
           $labcentrumdb = $row5["keszlet_db"];
            }
        } else {
           $labcentrumdb = 'null';
        }       
    
    $sql6 = "SELECT * FROM aru_keszlet WHERE keszlet_raktar = 'Kozponti_keszlet' AND keszlet_aru_id = '$keszlet_aru_id'  AND keszlet_torolt = '0' ORDER BY keszlet_id DESC LIMIT 1";
    $result6 = $conn->query($sql6);
    
    if ($result6->num_rows > 0) {
    // output data of each row
            while($row6 = $result6->fetch_assoc()) {
            $kozpontidb = $row6["keszlet_db"];
            }
        } else {
            $kozpontidb = 'null';
        }       
        
        
        
      $html = 'Aktuális állapot:<div class="row"> 
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="usr">Buda :</label>
                        '.$bmmdb.' db 
                    </div>
                </div>
                
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="usr">Fizio :</label>
                        '.$fiziodb.' db 
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="usr">P70 :</label>
                         '.$p70db.' db
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="usr">Óbuda :</label>
                        '.$obudadb.' db
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="usr">Lábcentrum :</label>
                         '.$labcentrumdb.' db
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="usr">Központi készlet :</label>
                        '.$kozpontidb.' db
                    </div>
                </div>
                
            </div> <hr>   
            ';    
      
    $html .='';   
    $history = new keszletnyilvantartasClass();
    $html .=  $history -> select_keszelt_history($keszlet_aru_id);
      
    echo $html;    
}


// szállítólevél rendelő közötti mozgatás
if (isset($_POST["keszlet_mozgas"]) AND $_POST["keszlet_mozgas"] = "készlet mozgatas"){
    
    $html ="";
    
    $keszlet_aru_id = test_input($_POST["keszlet_aru_id"]);
    $keszlet_db_mozgas = test_input($_POST["keszlet_db_mozgas"]);
    $keszlet_szallito = test_input($_POST["keszlet_szallito"]);
    $keszlet_atvevo = test_input($_POST["keszlet_atvevo"]);
    $keszlet_log = $_SESSION['real_name'].' - '. test_input($_POST["keszlet_log"]).' - ' ;
    
    $conn = DbConnect();
    // pillanatnyi készlet szállítónál
    $sql1 = "SELECT * FROM aru_keszlet WHERE keszlet_raktar = '$keszlet_szallito'  AND keszlet_aru_id = '$keszlet_aru_id' AND keszlet_torolt = '0' ORDER BY keszlet_id DESC LIMIT 1";
    $result = $conn->query($sql1);
    
        if ($result->num_rows > 0) {
        // output data of each row
                while($row = $result->fetch_assoc()) {
                $szallito_db = $row["keszlet_db"];
               // $html .= "Készlet: ".$keszlet_szallito.' aktuális keszlet db: '. $szallito_db .' / ';
                // készlet szállító db nem 0

                }
        } else {
            $szallito_db = 'NULL';
            $html .='<div class="alert alert-danger"> Szállító: '.$keszlet_szallito.' aktuális keszlet db: '. $szallito_db .' NEM MOZGATHATÓ </div>';
        }

      // pillanatnyi készlet átvevőnél
        
    $sql2= "SELECT * FROM aru_keszlet WHERE keszlet_raktar = '$keszlet_atvevo'  AND keszlet_aru_id = '$keszlet_aru_id' AND keszlet_torolt = '0' ORDER BY keszlet_id DESC LIMIT 1";
    $result1 = $conn->query($sql2);
    
        if ($result1->num_rows > 0) {
        // output data of each row
                while($row = $result1->fetch_assoc()) {
                $atvevo_db = $row["keszlet_db"];
               // $html .= "Készlet: ".$keszlet_atvevo.' aktuális keszlet db: '. $atvevo_db.' / ';
                

                }
        } else {
            $atvevo_db = NULL;
            //$html .= '<div class="alert alert-danger"> Készlet: '.$keszlet_atvevo.' Nincs készlezten.';
        } 
        
        // készlet mozgás
        if ($szallito_db  > 0 AND $szallito_db  >= $keszlet_db_mozgas AND $keszlet_szallito != $keszlet_atvevo AND $keszlet_db_mozgas > 0) {

            // készlet áétvezetés meglévő db csökkentése
            $szallito_keszlet_db = $szallito_db - $keszlet_db_mozgas;
            $atvevo_keszlet_db = $atvevo_db + $keszlet_db_mozgas;
            
            $sql = "INSERT INTO aru_keszlet (keszlet_aru_id, keszlet_db, keszlet_raktar, keszlet_log) VALUES ('$keszlet_aru_id', '$szallito_keszlet_db', '$keszlet_szallito','$keszlet_log keszlet csökken -> $keszlet_atvevo')";

                if ($conn->query($sql) === TRUE) {
                    //$html .= "Csökken: ".$keszlet_szallito.' aktuális keszlet db: '.$szallito_keszlet_db.' / ';
                
                        
                        $sql = "INSERT INTO aru_keszlet (keszlet_aru_id, keszlet_db, keszlet_raktar, keszlet_log) VALUES ('$keszlet_aru_id', '$atvevo_keszlet_db', '$keszlet_atvevo','$keszlet_log $keszlet_szallito -> készlet nő')";

                        if ($conn->query($sql) === TRUE) {
                        //    $html .= "Nö: ".$keszlet_atvevo.' aktuális keszlet db: '.$atvevo_keszlet_db .' / ';
                            
                        $html .= '<div class="alert alert-success"> Átadó: '.$keszlet_szallito.' Átvevő: '.$keszlet_atvevo.' db: '.$keszlet_db_mozgas.' CikkID: '.$keszlet_aru_id.' MOZGATÁS OK</div>' ;   
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        } 
                    
                    
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            // készlet nő átvett db   
               
        } else {

             $html .= '<div class="alert alert-danger"> Átadó: '.$keszlet_szallito.' Átvevő: '.$keszlet_atvevo.' CikkID: '.$keszlet_aru_id.' db: '.$keszlet_db_mozgas.'  NEM MOZGATHATÓ pl: nincs készleten </div>';

        }
        
   
    echo $html;
}