<?php

/**
 * Description of BerletClass
 *
 *  @author Andras/**
 *  @file BerletClass.php
 *  @brief Bérlet felhasználásokat kezelő osztály
 * 
 */
class BerletClass extends napi_elszamolas {

    public $searchresult = "NULL";
    public $rogzito; 
    public $telephely;
    public $beteglista_id;
    public $datetoday;
 
    function __construct() {
     
             if (isset($_SESSION['real_name'])){
                 
                 $this->rogzito = $_SESSION['real_name'];
                 
             }else{
                 $this->rogzito="Error rogzito name";
             }
     
             if (isset($_SESSION['set_telephely'])){
                 
                 $this->telephely = $_SESSION['set_telephely'];
                 
             }else{
                 $this->telephely="Error telephely";
             }
             
             
            // beteglista id érkezik paraméterként 
            if(isset($_GET["beteglista_id"])){
            
            $this->beteglista_id = $_GET["beteglista_id"];
            
                }else{

                    $this->beteglista_id = 'NULL';
                }
             
            $this->datetoday = date("Y-m-d");    
        }
    
    
    
    /**
     * Visualize_New_Berlet_Form()
     * 
     * használaton kívüli bérlet form
     */
     
 
	function Visualize_New_Berlet_Form() {
        $conn = DbConnect();

        echo'<div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
            <div class="panel panel-success">
        <div class="panel-heading">Ăšj bĂ©rlet Ă©rtĂ©kesĂ­tĂ©s</div>
        <div class="panel-body">';
        echo '<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page21">';
        //beteg neve
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">Paciens neve:</label>'
        . '<div class="col-sm-7">'
        . '<input type="text" class="form-control" name="paciensneve"  placeholder="Paciens neve" required>'
        . '</div>'
        . '</div>';

        //terapeuta kezelĹ‘
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">Terapeuta kezelĹ‘:</label>'
        . '<div class="col-sm-7">'
        . '<select class = "form-control" name = "kezelo" onchange="showBerletesSzolgaltatas(this.value)">';
        ;
       
        
        $sql = "SELECT * FROM `kezelok_orvosok` WHERE (kezelo_tipus = 'GyĂłgytornĂˇsz' OR kezelo_tipus = 'MasszĹ‘r') AND kezelo_telephely ='$this->telephely' ";
        $result = $conn->query($sql);
        $row[kezelo_neve] = 'Nincs kezelo';
                echo '<option value="NULL"> VĂˇlasszon </option>';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row[kezelo_neve] . '">' . $row[kezelo_neve] . '</option>';
            }
        } else {
            echo "0 results";
        }
        echo '</select></div></div>';

        // szoláltatások

        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">SzolgĂˇltatĂˇs:</label>'
        . '<div class="col-sm-7" id="selectBerletSzolg">';
        echo'<select class = "form-control" name = "szolg">';
        $sql = "SELECT DISTINCT  szolg_neve FROM szolgaltatasok WHERE szolg_tipus='BĂ©rlet'";
        $result2 = $conn->query($sql);

        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                echo '<option value="' . $row[szolg_neve] . '">' . $row[szolg_neve] . '</option>';
            }
        } else {
            echo "0 results";
        }
        echo'</select></div></div>';

        // bĂ©rlet eladĂˇs checkbox
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">Alkalmak:</label>'
        . '<div class="col-sm-7">';
        echo '<input type="radio" name="berlet_alkalom" value="5" required> 5 vagy '
        . '<input type="radio" name="berlet_alkalom" value="10" required> 10 alkalom'
        . '</div>'
        . '</div>';



        // fizetĂ©si mĂłdok select
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">FizetĂ©s:</label>'
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
        . '<label class="col-sm-3 control-label">EgĂ©szsĂ©gpĂ©ztĂˇr:</label>'
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

        // szĂˇmlaszĂˇm
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">SzĂˇmlaszĂˇm:</label>'
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
        <div class="panel-footer">Eladott Ăşj bĂ©rlet szĂˇmĂˇt a bĂ©rleten fel kell tĂĽntetni! </div>
        </div></div>';
        
        //$this->Visualize_Check_Berlet_Form();
        echo '<div class="col-sm-2"></div></div>';
    }

    /**
     * Create_Berlet($paciens,$gyogytornasz,$berlet_alkalom,$szolgaltatas,$telephely)
     * @param type $paciens
     * @param type $gyogytornasz
     * @param type $berlet_alkalom
     * @param type $szolgaltatas
     * @param type $telephely
     * 
     * Bérlet létrehozása a napi elszámolás user_post_insert metódusból meghíva fult
     */
    function Create_Berlet($paciens,$gyogytornasz,$berlet_alkalom,$szolgaltatas,$telephely,$berlet_lejarat,$bevosszeg) {

        $conn = DbConnect();

        $sql = "INSERT INTO berlet_kezeles (berlet_vevo, berlet_gyogytornasz, berlet_tipus, berlet_alkalom, berlet_neve, berlet_telephely, berlet_lejar, berlet_ar) "
                . "VALUES ('$paciens','$gyogytornasz','$berlet_alkalom','0','$szolgaltatas','$telephely','$berlet_lejarat','$bevosszeg')";

        if (mysqli_query($conn, $sql)) {
            // echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        //utoljĂˇra kiadott bĂ©rlet szĂˇm visszadĂˇsa 
    }
/**
 * Visualize_Check_Berlet_Form()
 * 
 * Bérlet form használatban
 */
    function Visualize_Check_Berlet_Form() {
    
    echo '<div class="container">';  
        
        echo '<div class="col-sm-4">
                <div class="panel panel-success">
                <div class="panel-heading">Keresés bérlet száma szerint.</div>
                <div class="panel-body">';
                echo '<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page21&beteglista_id='.$this->beteglista_id.'">';
                //bĂ©rlet szĂˇma
                echo'<div class="form-group">'
                . '<label class="col-sm-3 control-label">Bérlet száma:</label>'
                . '<div class="col-sm-7">'
                . '<input type="number" class="form-control" name="berlet_id_search"  placeholder="123456" required>'
                . '</div>'
                . '</div>';

                // ok gomb
                echo'<div class="form-group">'
                . '<label class="col-sm-3 control-label"></label>'
                . '<div class="col-sm-7">';
                echo'<button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Keresés</button>'
                . '</div></div>';
                echo '</form>';
                echo '</div>
            <div class="panel-footer">BMM</div>
            </div>
        </div>';
                
         echo '<div class="col-sm-4">
                <div class="panel panel-success">
                <div class="panel-heading">Keresés BMM kártyával</div>
                <div class="panel-body">';
                echo '<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page21&beteglista_id='.$this->beteglista_id.'">';
                //bĂ©rlet szĂˇma
                echo'<div class="form-group">'
                . '<label class="col-sm-3 control-label">BMM kártya:</label>'
                . '<div class="col-sm-7">'
                . '<input type="text" class="form-control" name="BMM_cardSN_search"  placeholder="csipp" required autoficus>'
                . '</div>'
                . '</div>';

                // ok gomb
                echo'<div class="form-group">'
                . '<label class="col-sm-3 control-label"></label>'
                . '<div class="col-sm-7">';
                echo'<button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Keresés</button>'
                . '</div></div>';
                echo '</form>';
                echo '</div>
            <div class="panel-footer">BMM</div>
            </div>
        </div>';        
            
        echo '<div class="col-sm-4">';
            echo '<div class="panel panel-success">
                <div class="panel-heading">Keresés név szerint.</div>
                <div class="panel-body">';
                echo '<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page21&beteglista_id='.$this->beteglista_id.'">';
                //beteg neve
                echo'<div class="form-group">'
                . '<label class="col-sm-3 control-label">Páciens neve:</label>'
                . '<div class="col-sm-7">'
                . '<input type="text" class="form-control" name="pname_search"  placeholder="páciens neve" required>'
                . '</div>'
                . '</div>';

                // ok gomb
                echo'<div class="form-group">'
                . '<label class="col-sm-3 control-label"></label>'
                . '<div class="col-sm-7">';
                echo'<button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Keresés</button>'
                . '</div></div>';
                echo '</form>';
                echo '</div>
            <div class="panel-footer">BMM</div>
            </div>
        </div>
    </div>';
            
    
    }

 /**
 * Visualize_All_Berlet_FromBD()
 * Bérletek megjelenítése 
  *Használatban
 */    
    public function Visualize_All_Berlet_FromBD($alkszam) {
        // előjegyzési szám érkezett get paraméterként
        
      $html = "";
        
        $conn = DbConnect();
        $sql = "SELECT * FROM berlet_kezeles WHERE berlet_alkalom < berlet_tipus AND berlet_tipus = '$alkszam'  AND berlet_torolt = 0 AND (berlet_lejar >= '$this->datetoday' OR berlet_lejar = '0000-00-00') ORDER BY berlet_new DESC";

		
		$result = $conn->query($sql);

        $html .= '<form action="'. $_SERVER['PHP_SELF'].'?pid=page21&beteglista_id='.$this->beteglista_id.'" method="post">';
        
            $html .='
                    <h2>Összes '. $alkszam. ' alkalmas bérlet</h2>
                <table class="table table-hover">
                <thead>
                    <tr>
                      <th>No.:</th>
                      <th>Páciens</th>
                      <th>BMM kártyaszám</th>
                      <th>Gyógytornász</th>
                      <th>Típus</th>
                      <th>Alkalmak</th>
                      <th>Felh.</th>
                      <th>Lejárat</th>
                      <th>Új alkalom</th>
                      <th>Napló</th>
                      <th>Kártyat kapcsolat</th>
                    </tr>
                  </thead><tbody>';
        if ($result->num_rows > 0) {    
            while ($row = $result->fetch_assoc()) {
                 $berletid = $row["berlet_id"];
                 $felh_berlet_id = "'" . $row["berlet_id"] . "'";
                $html .=  "<tr><td>"
                . $row["berlet_id"] . "</td><td> "
                . $row["berlet_vevo"] . "</td><td>"
                . $row["user_id"] . "</td><td>"
                . $row["berlet_gyogytornasz"] . "</td><td>"
                . $row["berlet_neve"] . "</td><td>"        
                . $row["berlet_tipus"] . "</td><td>"
                . $row["berlet_alkalom"] . "</td><td>"
                . $row["berlet_lejar"] . "</td><td>"
                . '<input type="radio" name="berlet_alkalom_id" value="' . $row["berlet_id"] . '"></td><td >'
                . '<button  type="button" onclick="berlet_felhasznalasok('.$felh_berlet_id.')"  data-toggle="modal" data-target="#berlet_naplo">'
                . '<i class="fa fa-calendar-check-o"></i></button></td>'
                . '<td><button  type="button" onclick="berlet_patient_connect('.$felh_berlet_id.')"  data-toggle="modal" data-target="#berlet_connect"><i class="fa fa-plug" aria-hidden="true"></i></button></td></tr>';
                  
            }
        } else {
             $html .=  "<tr><td>Nincs rögzített adat</td></tr>";
        }
        $html .=  '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>'
        . '<td colspan="2"><button type = "submit" value = "Submit" type = "button" class = "btn btn-warning"><i class="fa fa-ticket" aria-hidden="true"></i> Felhasználás</button></td><td></td></tr>';
        $html .=  "</tbody></table></form>";
        
        return $html;     
       // $this->Visualize_Berlet_Naplo_Modal();
        
         mysqli_close($conn);
    }
        // bérlet alkalmak post
        
    public function User_Post_New_BerletAlkalom() {
                
        if (isset($_POST["berlet_alkalom_id"])) {
            
                                  
            $conn = DbConnect();
            // adatbĂˇzisba Ă­rĂˇs
            // tĂˇrolandĂł adatok bemeneti ellenĂ¶rzĂ©se
            $berlet_id = test_input($_POST["berlet_alkalom_id"]);
            $sql = "SELECT * FROM berlet_kezeles WHERE berlet_id = '$berlet_id' AND berlet_torolt = 0";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                   $alkalomszam = $row["berlet_alkalom"];
                   $berlettipus = $row["berlet_tipus"];
                   $pname = $row["berlet_vevo"];
                   $kezelo_orvos = $row["berlet_gyogytornasz"];
                   $berlet_neve = $row["berlet_neve"];
                }
            } else {
                echo "0 results";
            }
			
			// csak ha a bérlet mégnem járt le
            if ($alkalomszam < $berlettipus) 
                {
                $alkalomszam++;

                    $sql = "UPDATE berlet_kezeles SET berlet_alkalom='$alkalomszam' WHERE berlet_id = '$berlet_id'";

                    if (mysqli_query($conn, $sql)) {
                        // echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }

                    // napi elszámolásban szerepeltetni kell a bérlet gyógytorna stb - bérlethasználatot
                    
                    
                    $date = date("Y-m-d");

                    $sql = "INSERT INTO napi_elszamolas (paciens_neve , kezelo_orvos_id, szolgaltatas_id
                            ,bevetel_tipusa_id,ep_tipus, bevetel_osszeg,jutalek_osszeg, szamlaszam, berlet_adatok, rogzito, telephely, date,el_beteglista_id)
                            VALUES ('$pname','$kezelo_orvos','$berlet_neve No.: $berlet_id','','','','','','$berlettipus/$alkalomszam','$this->rogzito','$this->telephely','$date','$this->beteglista_id')";

                            if (mysqli_query($conn, $sql)) {
                                // echo "New record created successfully";
                            } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }
                    //bérlet felhasználása a berlet_felh táblába rögzítésre kerül
                    $sql = "INSERT INTO berlet_felh (felh_berlet_id , felh_berlet_alkalom)
                            VALUES ('$berlet_id','$alkalomszam')";

                            if (mysqli_query($conn, $sql)) {
                                // echo "New record created successfully";
                            } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }
                    // visszírása az előjegyzési táblára hogy kizöldüljön a bérlet felhasználás
                    
                            
                     $elojegyzes_check = new napi_elszamolas();       
                     $elojegyzes_check->elojezses_azonositas($this->beteglista_id)  ;     
                        


                }
            mysqli_close($conn);
        
        }
    }

    public function User_Post_Search_Berlet(){
        
       
            $conn = DbConnect();
            
            $this->berlet_search = TRUE;
            
            if (isset($_POST["berlet_id_search"])){
            
                $berlet_id = $_POST["berlet_id_search"];
                             
                $sql = "SELECT * FROM berlet_kezeles WHERE berlet_id = '$berlet_id'  AND berlet_torolt = 0";
                $this->searchresult = $conn->query($sql);
                return TRUE;
            }
            if (isset($_POST["pname_search"])){
               
                $berlet_vevo = $_POST["pname_search"];
                                   
                $sql = "SELECT * FROM berlet_kezeles WHERE berlet_vevo LIKE '%$berlet_vevo%'  AND berlet_torolt = 0 ORDER BY berlet_vevo";
                $this->searchresult = $conn->query($sql);
                return TRUE;
            }
            
            if (isset($_POST["BMM_cardSN_search"])){
               
                $BMMCardSerialNo = $_POST["BMM_cardSN_search"];
                $BMM_kartyaszam = '0000';                   
                
                $sql = "SELECT * FROM users WHERE CardSerialNo = '$BMMCardSerialNo'";
                
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                             $BMM_kartyaszam = $row["CardReadableNo"];
                        }
                    } else {
                        echo "0 results";
                    }
                        
                $sql = "SELECT * FROM berlet_kezeles WHERE user_id = '$BMM_kartyaszam' ORDER BY berlet_vevo";        
                $this->searchresult = $conn->query($sql);
                return TRUE;
            }
            
            
            mysqli_close($conn);
           
                 
    }                
     
    public function Visualize_Search_Result(){
       // echo 'KeresĂ©s eredmĂ©nye'. (string)$this->searchresult;
        $felh_berlet_id = '00000';
        
       echo '<form action="'. $_SERVER['PHP_SELF'].'?pid=page21&beteglista_id='.$this->beteglista_id.'" method="post">';
       echo'<div class="container">
                    <h2>Keresés esrménye</h2>
                <table class="table table-hover">
                <thead>
                    <tr>
                       <th>No.:</th>
                      <th>Páciens</th>
                      <th>BMM kártyaszám</th>
                      <th>Gyógytornász</th>
                      <th>Típus</th>
                      <th>Alkalmak</th>
                      <th>Felh.</th>
                      <th>Lejárat</th>
                      <th>Új alkalom</th>
                      <th>Napló</th>
                      <th>Kártyat kapcsolat</th>
                    </tr>
                  </thead><tbody>';
         
         if ($this->searchresult->num_rows > 0) {
           
            while ($row = $this->searchresult->fetch_assoc()) {
                $berletid = $row["berlet_id"];
                $felh_berlet_id = $row["berlet_id"];
                echo "<tr><td>"
                . $row["berlet_id"] . "</td><td> "
                . $row["berlet_vevo"] . "</td><td>"
                . $row["user_id"] . "</td><td>"
                . $row["berlet_gyogytornasz"] . "</td><td>"
                . $row["berlet_neve"] . "</td><td>"        
                . $row["berlet_tipus"] . "</td><td>"
                . $row["berlet_alkalom"] . "</td><td>"
                . $row["berlet_lejar"] . "</td><td>"
                . '<input type="radio" name="berlet_alkalom_id" value="' . $row["berlet_id"] . '"></td><td >'
                . '<button  type="button" onclick="berlet_felhasznalasok('.$felh_berlet_id.')"  data-toggle="modal" data-target="#berlet_naplo">'
                . '<i class="fa fa-calendar-check-o"></i></button></td>'
                . '<td><button  type="button" onclick="berlet_patient_connect('.$felh_berlet_id.')"  data-toggle="modal" data-target="#berlet_connect"><i class="fa fa-plug" aria-hidden="true"></i></button></td></tr>';
                  
            }
        } else {
            echo "<tr><td>Nincs rögzített adat</td></tr>";
        }
        echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>'
        . '<td colspan="2"><button type = "submit" value = "Submit" type = "button" class = "btn btn-warning">Új alkalom</button></td>';
        echo "</tbody></table></div></form>";
        
        $this->Visualize_Berlet_Naplo_Modal();
    }

    public function Visualize_Delete_Berlet_FromBD(){
        $conn = DbConnect();
        $sql = "SELECT * FROM berlet_kezeles WHERE ("
                . "(berlet_alkalom <> 10 AND berlet_tipus = 10) OR (berlet_alkalom <> 5 AND berlet_tipus = 5) OR (berlet_alkalom <> 8 AND berlet_tipus = 8)  OR (berlet_alkalom <> 3 AND berlet_tipus = 3)  OR (berlet_alkalom <> 20 AND berlet_tipus = 20)  OR (berlet_alkalom <> 30 AND berlet_tipus = 30)"
                . ")"
                . " AND berlet_torolt = 0 ORDER BY berlet_new DESC";
        $result = $conn->query($sql);

        echo '<form action="'. $_SERVER['PHP_SELF'].'?pid=page23" method="post">';
        
            echo'<div class="container">
                    <h2>Összes érvényes bérlet:</h2>
                <table class="table table-hover">
                <thead>
                    <tr>
                      <th>No.:</th>
                      <th>Páciens</th>
                      <th>Gyógytornász</th>
                      <th>Típus</th>
                      <th>Alkalmak</th>
                      <th>Felhasználva</th>
                      <th>Törlésre kijelölve</th>
                    </tr>
                  </thead><tbody>';
        if ($result->num_rows > 0) {    
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>"
                . $row["berlet_id"] . "</td><td> "
                . $row["berlet_vevo"] . "</td><td>"
                . $row["berlet_gyogytornasz"] . "</td><td>"
                . $row["berlet_neve"] . "</td><td>"        
                . $row["berlet_tipus"] . "</td><td>"
                . $row["berlet_alkalom"] . "</td><td>"
                . '<input type="radio" name="delete_berlet_id" value="' . $row["berlet_id"] . '"></td></tr>';
            }
        } else {
             echo "<tr><td>Nincs rögzített adat</td></tr>";
        }
        echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td>'
        . '<td><button type = "submit" value = "Submit" type = "button" class = "btn btn-danger">Törlés</button></td>';
        echo "</tbody></table></div></form>";
        
        mysqli_close($conn);
    }

    public function User_Post_Delete_Berlet(){
        
        if (isset($_POST['delete_berlet_id'])) {
            $deleteid = $_POST['delete_berlet_id'];
            $conn = DbConnect();

            $sql = "UPDATE berlet_kezeles SET berlet_torolt=1 WHERE berlet_id='$deleteid'";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

    /**
     * Visualize_Berlet_Naplo_Modal()
     * 
     * bérlet naplót megjelenítő modális ablak
     */
    
    function Visualize_Berlet_Naplo_Modal(){

        echo '<div class="modal fade" id="berlet_naplo" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content" >
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Bérletfelhsználások</h4>
            </div>
            <div class="modal-body">
              <p>Nincs alkalom, hibás lekérdezés!</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>';
        
          echo '<div class="modal fade" id="berlet_connect" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content" >
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Bérlet pácienshez kapcsolása</h4>
            </div>
            <div class="modal-body">
              <p>Valami nem OK!</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>';
          
    }

public function BerletListak(){
    $html = "";
    
 $html .= '<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#mneu">5 alk</a></li>
    <li><a data-toggle="tab" href="#menu1">10 alk</a></li>
    <li><a data-toggle="tab" href="#menu2">Gyakorló 3 alk</a></li>
    <li><a data-toggle="tab" href="#menu3">Gondoskodó 8 alk</a></li>
    <li><a data-toggle="tab" href="#menu4">Tudatos 20 alk</a></li>
    <li><a data-toggle="tab" href="#menu5">Elhivatott 30 alk</a></li>
  </ul>

  <div class="tab-content">
    <div id="mneu" class="tab-pane fade in active">
      '.$this->Visualize_All_Berlet_FromBD(5).'
    </div>
    <div id="menu1" class="tab-pane fade">
      '.$this->Visualize_All_Berlet_FromBD(10).'
    </div>
    <div id="menu2" class="tab-pane fade">
      '.$this->Visualize_All_Berlet_FromBD(3).'
    </div>
    <div id="menu3" class="tab-pane fade">
      '.$this->Visualize_All_Berlet_FromBD(8).'
    </div>
    <div id="menu4" class="tab-pane fade">
      '.$this->Visualize_All_Berlet_FromBD(20).'
    </div>
    <div id="menu5" class="tab-pane fade">
      '.$this->Visualize_All_Berlet_FromBD(30).'
    </div>
  </div>';

    return $html;
}
}
