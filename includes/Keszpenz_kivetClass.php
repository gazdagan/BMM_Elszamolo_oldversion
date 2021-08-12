<?php



/**
 * Keszpenz_kivetClass
 *
 * Képszénz kivét házi pénztárból a meglévő kp állomány terhére lehetséges
 * @author Andras
 */
class Keszpenz_kivetClass {
   /**
    * Visualize_Kpkivet_Form()
    * használatban
    * készpénz kivételi form 
    */ 
  public function Visualize_Kpkivet_Form() {
        $conn = DbConnect();
        // form kp kivéthez
        $date = date("y-m-d");
        
        echo'<div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
            <div class="panel panel-danger">
        <div class="panel-heading">Készpénz kivét és számlakép feltöltés</div>
        <div class="panel-body">';
        echo '<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page20" enctype="multipart/form-data">';
                      
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label" >Kivét oka:</label>'
        . '<div class="col-sm-7">'
            .  '<select class="form-control"   name="kivet_oka" id="kifizetes_oka" >
                    <option value="Egyéb">Egyéb</option>        
                    <option value="Jutalék">Jutalék kifizetés</option>
                </select>'
        . '</div></div>';
       
       $kezelo_telephely = $_SESSION['set_telephely'];
        //orovos kezelő
        echo'<div class="form-group">'
                . '<label class="col-sm-3 control-label">Orvos kezelő:</label>'
                . '<div class="col-sm-7">'
                . '<select class = "form-control" name = "kivet_atvevo"  id="kezelo_neve" onchange="kezelo_jutalek(this.value,'."'".$kezelo_telephely."'".')">';
               
                
//,'.'"'.$kezelo_telephely.'"'.'
                $sql = "SELECT DISTINCT * FROM `kezelok_orvosok` WHERE (kezelo_tipus = 'Orvos'  OR kezelo_tipus = 'Masszőr' OR kezelo_tipus = 'Gyógytornász') "
                        . "AND kezelo_telephely ='$kezelo_telephely'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="'.$row[kezelo_neve].'">'.$row[kezelo_neve].'</option>';
                    }
                } else {
                    echo "0 results";
                }
        echo '<option value="nincs a listán">Nincs a listában</option>';
        echo '</select></div></div>';        
        
        //számalkép feltöltés
        echo '<div class="form-group">'
        . '<label class="col-sm-3 control-label">Számla tipus:</label>'
        . '<div class="col-sm-7">'
        . '<label class="radio-inline"><input type="radio" name="szamla_kep" value="szamlakeppel" onchange="upload_file_require()" required>Számlával képfelötlés</label>
           <label class="radio-inline" style="margin-left: 0px;"><input type="radio" name="szamla_kep" value="szamlanelkul"  onchange="upload_file_NOTrequire()" required>Számlakép nélkül</label>'        
        . '</div></div>'; 


        //kp megjegyzes
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">Megjegyzés:</label>'
        . '<div class="col-sm-7">'
        . '<input type="text" class="form-control" name="kivet_megjegyzes"  placeholder="Megjegyzés" >'
        . '</div></div>';

        //kp kivett osszeg
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">Készpénz Összege (Ft):</label>'
        . '<div class="col-sm-7">'
        . '<input type="number" class="form-control" name="kivet_osszeg" id="kp_kivet_osszeg" placeholder="1000" required>'
        . '</div></div>';
        
        //számalkép feltöltés
//        echo '<div class="form-group">'
//        . '<label class="col-sm-3 control-label">Számla tipus:</label>'
//        . '<div class="col-sm-7">'
//        . '<label class="radio-inline"><input type="radio" name="szamla_kep" value="szamlakeppel" onchange="upload_file_require()" required>Számlával képfelötlés</label>
//           <label class="radio-inline" style="margin-left: 0px;"><input type="radio" name="szamla_kep" value="szamlanelkul"  onchange="upload_file_NOTrequire()" required>Számlakép nélkül</label>'        
//        . '</div></div>'; 
        
        //számal kibocsátó
        echo'<div id="szamlakep" style="display:none">'
            . '<div class="form-group" >'
            . '<label class="col-sm-3 control-label" id="sel1">Szamlázó neve:</label>'
            . '<div class="col-sm-7">'
            . '<input type="text" class="form-control" name="szamla_kibocsato" id="szamla_kibocsato" placeholder="Szamlakibocsátó megnevezése">'        
            . '</div></div>';
            
        //számal sorszám 
        echo'<div class="form-group" >'
            . '<label class="col-sm-3 control-label">Számla sorszáma:</label>'
            . '<div class="col-sm-7">'
            . '<input type="text" class="form-control" name="szamla_sorszam" id="szamla_sorszam" placeholder="ABCDE 123456">'        
            . '</div></div>';  
        
          //file feltöltés
        echo'<div class="form-group" >'
            . '<label class="col-sm-3 control-label">Készpénzes számlaképek feltöltése:</label>'
            . '<div class="col-sm-7">'
            . '<input type="file" name="fileToUpload" id="fileToUpload" class = "form-control btn btn-success"> '        
            . '</div></div>'
            . '</div>';  
        echo '<input type="hidden" name="szamla_tipus" value="kp">';  
        
        // ok gomb
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label"></label>'
        . '<div class="col-sm-7">';
        echo'<button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Rendben</button>'
        . '</div></div>';

        echo '</form>';

        echo '</div>
        <div class="panel-footer">Készpénz összesen : '; 
        
        $kpmaxkivet = new User_Select_NapiElsz;
        echo $kpmaxkivet->user_select_napikp();
        
        echo ' Ft</div>
        </div></div>
        <div class="col-sm-4"></div>
        </div>';
        
        $this ->Visualize_All_Kpkivet_Table_User();
    }

    public function User_Post_Kpkivet(){
         
        if (isset($_POST["kivet_oka"]) && isset($_POST["kivet_atvevo"])&& isset($_POST["kivet_osszeg"]) and isset($_POST["szamla_kep"])) {
                  
            $kpkeszlet = new User_Select_NapiElsz;
            $kpvan = $kpkeszlet->user_select_napikp();
            
            $date = $date = date("y-m-d");
            $conn = DbConnect();
            $kivevo_neve = $_SESSION['real_name'];
            
            $kivet_oka = test_input($_POST["kivet_oka"]);
            $kivet_osszeg = test_input($_POST["kivet_osszeg"]);
            $kivet_megjegyzes = test_input($_POST["kivet_megjegyzes"]);
            $kivet_atvevo = test_input($_POST["kivet_atvevo"]);
            
            $kivet_telephely = $_SESSION['set_telephely'];
            
            if ($kpvan >= $kivet_osszeg){
                
                $sql = "INSERT INTO kp_kivet (kivevo_neve, kivet_oka,kivet_osszeg,kivet_datum,kivet_telephely,kivet_megjegyzes,kivet_atvevo,kivet_torolve)
                               VALUES ('$kivevo_neve','$kivet_oka','$kivet_osszeg','$date','$kivet_telephely','$kivet_megjegyzes','$kivet_atvevo','0')";

                if (mysqli_query($conn, $sql)) {
                    // echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }else{
                
                echo'<div class="alert alert-warning alert-dismissable fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Figyelem!</strong> Nincs ennyi kiadható készpénz a kasszában.
                    </div>';
         
            }
            
            echo '<script> console.log("'.$_POST["szamla_kep"].'");</script>';
            // számlafeltölés is van
            if ( $_POST["szamla_kep"] === "szamlakeppel"){
                
                $szamlakep = new Szamla_befogadasClass();
                $szamlakep->user_post_szamlabefogadas();

            
            }
            mysqli_close($conn);
          
        }
             
    }
    /***
     *  Visualize_All_Kpkivet_Table_User()
     * 
     * Kp kivét form megjelenítése
     * hazsnálatban
     */
    function Visualize_All_Kpkivet_Table_User() {
        $conn = DbConnect();
        
        $kivevo_neve = $_SESSION['real_name'];
        $kivet_telephely = $_SESSION['set_telephely'];
        $date = date("y-m-d");
        
        $sql = "SELECT * FROM kp_kivet WHERE kivet_datum = '$date' AND kivet_telephely ='$kivet_telephely' AND kivet_torolve ='0'";
        $result = $conn->query($sql);

      
            echo'<div class="container">
                    <h2>Készpénz kivétek a mai napon:</h2>
                <table class="table table-striped">
                <thead>
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
                echo "<tr><td>"
                . $row["kivet_id"] . "</td><td> "
                . $row["kivevo_neve"] . "</td><td>"
                . $row["kivet_oka"] . "</td><td>"
                . $row["kivet_osszeg"] . "</td><td>"   
                . $row["kivet_atvevo"] . "</td><td>"
                . $row["kivet_megjegyzes"] . "</td><td></tr>"
               ;
            }
        } else {
            echo "<tr><td>Nincs rögzített adat</td></tr>";
        }
        echo "</tbody></table></div>";
        
       
        mysqli_close($conn);
    }
 
    public function Visualize_Delete_Kpkivet_Table(){

        $conn = DbConnect();
        
        $kivevo_neve = $_SESSION['real_name'];
        $kivet_telephely = $_SESSION['set_telephely'];
        $date = $date = date("y-m-d");
        
        $sql = "SELECT * FROM kp_kivet WHERE kivet_datum = '$date' AND kivet_telephely ='$kivet_telephely' AND kivet_torolve ='0'";
        $result = $conn->query($sql);

        echo '<form action="' . $_SERVER['PHP_SELF'] . '?pid=page24" method="post">';
            echo'<div class="container">
                    <h2>Készpénz kivétek törlése:</h2>
                <table class="table table-striped">
                <thead>
                    <tr>
                      <th>No.:</th>
                      <th>Kiadó</th>
                      <th>Kivet Oka</th>
                      <th>Kivet Összege(Ft)</th>
                      <th>Kivet Átvevő</th>
                      <th>Megjegyzés</th>
                      <th>Törlésre kijelöl</th>
                    </tr>
                  </thead><tbody>';
            
        if ($result->num_rows > 0) {     
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>"
                . $row["kivet_id"] . "</td><td> "
                . $row["kivevo_neve"] . "</td><td>"
                . $row["kivet_oka"] . "</td><td>"
                . $row["kivet_osszeg"] . "</td><td>"   
                . $row["kivet_atvevo"] . "</td><td>"
                . $row["kivet_megjegyzes"] . "</td><td>"
                . '<input type="radio" name="delete_kpkivet_id" value="' . $row["kivet_id"] . '"></td></tr>'
               ;
            }
        } else {
            echo "<tr><td>Nincs rögzített adat</td></tr>";
        }
       echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td><button type = "submit" value = "Submit" type = "button" class = "btn btn-danger">Töröl</button></td></tr>';
        echo "</tbody></table></form>";
   
        mysqli_close($conn);
    }

    function User_Post_Delete_Kpkivet()
    {
        if (isset($_POST['delete_kpkivet_id'])) {
            $deleteid = $_POST['delete_kpkivet_id'];
            $conn = DbConnect();

            $sql = "UPDATE kp_kivet SET kivet_torolve=1 WHERE kivet_id='$deleteid'";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

}
