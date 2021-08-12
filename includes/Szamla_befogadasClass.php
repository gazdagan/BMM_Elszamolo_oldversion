<?php
/**
 * Szamla_befogadasClass
 * 
 * Számlák átvételét kezelő osztály
 */

class Szamla_befogadasClass {
    
    public $szamla_szam;
    public $szamlakibocsato_neve;
    public $rogzito;
    public $conn;
    public $telephely;
    public $message;
    
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

        $this->date = date("y-m-d");
       
        $this->conn = DbConnect();
        
        $this->message= "Számal befogadása orvostól kezelőtől - átutalásos számlák feltöltése.....";
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
    
    
    /**
     * VisualizeSzamlaBefogadasForm()
     * 
     * számklák átvételét rögzítő form
     */
    public function VisualizeSzamlaBefogadasForm(){
        
        $conn = DbConnect();
        $date = date("y-m-d");
        
        echo'<div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
            <div class="panel panel-danger">
        <div class="panel-heading">Kiállított átutalásos számla átvétele. Számlakép feltöltése.</div>
        <div class="panel-body">';
        echo '<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page22"  enctype="multipart/form-data"> ';
        
        echo'<div class="form-group">'
                    . '<label class="col-sm-3 control-label">Átvevő:</label>'
                . '<div class="col-sm-7">'
                    . '<input type="text" class="form-control" name="szamla_atvevo"  placeholder="'.$_SESSION['real_name'].'" value="'.$_SESSION['real_name'].'" disabled>'
                . '</div>'
            . '</div>';
        
        echo'<div class="form-group">'
            . '<label class="col-sm-3 control-label" id="sel1">Szamlázó neve:</label>'
        . '<div class="col-sm-7">'
            . '<input type="text" class="form-control" name="szamla_kibocsato"  placeholder="Szamlakibocsátó megnevezése" required>'        
        . '</div></div>';
            
         
        echo'<div class="form-group">'
                . '<label class="col-sm-3 control-label">Számla sorszáma:</label>'
            . '<div class="col-sm-7">'
                . '<input type="text" class="form-control" name="szamla_sorszam"  placeholder="ABCDE 123456" required>'        
            . '</div></div>';  
        
        //számla tipusa
        $no_output ='<div class="form-group">'
                . '<label class="col-sm-3 control-label">Számla tipus:</label>'
            . '<div class="col-sm-7">'
                . '<label class="radio-inline"><input type="radio" name="szamla_tipus" value="utalas" onchange="upload_file_require()" required>Átutalás</label>
                   <label class="radio-inline"><input type="radio" name="szamla_tipus" value="kp"  onchange="upload_file_NOTrequire()" required>Készpénzes</label>'        
            . '</div></div>'; 
        echo '<input type="hidden" name="szamla_tipus" value="utalas">';
        
            
        //kp megjegyzes összeg
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">Számla összege:</label>'
        . '<div class="col-sm-7">'
        . '<input type="text" class="form-control" name="szamla_megjegyzes"  placeholder="987654 Ft" required >'
        . '</div></div>';
        
        //file feltöltés
        echo'<div class="form-group">'
                . '<label class="col-sm-3 control-label">Átutalásos számlaképek feltöltése:</label>'
            . '<div class="col-sm-7">'
                . '<input type="file" name="fileToUpload" id="fileToUpload" class = "form-control btn btn-success" required/> '        
            . '</div></div>';  
        
        
        
        // ok gomb
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label"></label>'
        . '<div class="col-sm-7">';
        echo'<button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Rendben</button>'
        . '</div></div>';

        echo '</form>';

        echo '</div>
        <div class="panel-footer">'.$this->message;
        
        echo '</div>
        </div></div>
        <div class="col-sm-3"></div>
        </div>';
        
       //$this->Visualize_All_Szamla_Table_User();
         
    }
    
      public function VisualizeSzamlaBefogadasForm_Admin(){
        
        $conn = DbConnect();
        $date = date("y-m-d");
        
        echo'<div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
            <div class="panel panel-danger">
        <div class="panel-heading">Irodai számlaképek feltöltése. (nem jelennek meg a rendelők napi elszámolásában)</div>
        <div class="panel-body">';
        echo '<form method="post" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page200"  enctype="multipart/form-data"> ';
        
       
        echo'<div class="form-group">'
            . '<label class="col-sm-3 control-label" id="sel1">Szamlázó neve:</label>'
        . '<div class="col-sm-7">'
            . '<input type="text" class="form-control" name="szamla_kibocsato"  placeholder="Szamlakibocsátó megnevezése" required>'        
        . '</div></div>';
            
         
        echo'<div class="form-group">'
                . '<label class="col-sm-3 control-label">Számla sorszáma:</label>'
            . '<div class="col-sm-7">'
                . '<input type="text" class="form-control" name="szamla_sorszam"  placeholder="ABCDE 123456" required>'        
            . '</div></div>';  
        
        //számla tipusa
        echo '<div class="form-group">'
                . '<label class="col-sm-3 control-label">Számla tipus:</label>'
            . '<div class="col-sm-7">'
                . '<label class="radio-inline"><input type="radio" name="szamla_tipus" value="utalas" onchange="upload_file_require()" required>Átutalás</label>
                   <label class="radio-inline"><input type="radio" name="szamla_tipus" value="kp"  onchange="upload_file_NOTrequire()" required>Készpénzes</label>'        
            . '</div></div>'; 
        
                  
        //kp megjegyzes összeg
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label">Számla összege negjegyzés:</label>'
        . '<div class="col-sm-7">'
        . '<input type="text" class="form-control" name="szamla_megjegyzes"  placeholder="987654 Ft" required >'
        . '</div></div>';
        
        //file feltöltés
        echo'<div class="form-group">'
                . '<label class="col-sm-3 control-label">Átutalásos számlaképek feltöltése:</label>'
            . '<div class="col-sm-7">'
                . '<input type="file" name="fileToUpload" id="fileToUpload" class = "form-control btn btn-success" required/> '        
            . '</div></div>';  
        
        //telephely
        
        echo '<input type="hidden" name="szamla_telephely" value="iroda">';
        
        // ok gomb
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label"></label>'
        . '<div class="col-sm-7">';
        echo'<button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Rendben</button>'
        . '</div></div>';

        echo '</form>';

        echo '</div>
        <div class="panel-footer">BMM Iroda telephely';
        
        echo '</div>
        </div></div>
        <div class="col-sm-3"></div>
        </div>';
        
       //$this->Visualize_All_Szamla_Table_User();
       //$this->telephely = "iroda";  
    }
    
    
    
    
    public function user_post_szamlabefogadas (){
         
        if (isset($_POST["szamla_kibocsato"]) && isset($_POST["szamla_sorszam"])) {
                     
            $conn = DbConnect();
            
            $szamla_atvevo = $_SESSION['real_name'];
            
            if (isset($_POST["szamla_telephely"]) AND $_POST["szamla_telephely"] == "iroda"){$szamla_telphely  =  "iroda";}
            else{
            $szamla_telphely  = $_SESSION['set_telephely'];
            }
            $szamla_atvetdate = $date = date("y-m-d");
            $szamla_kibocsato = test_input($_POST["szamla_kibocsato"]);
            $szamla_sorszam = test_input($_POST["szamla_sorszam"]);
            $szamla_megjegyzes = "nincs??";
            if(isset($_POST["szamla_megjegyzes"])){ 
            $szamla_megjegyzes = test_input($_POST["szamla_megjegyzes"]);
                        
            }
            if (isset($_POST["kivet_osszeg"]) AND isset($_POST["kivet_megjegyzes"])){
                
            $szamla_megjegyzes = test_input($_POST["kivet_osszeg"]) .' - ' . test_input($_POST["kivet_megjegyzes"]);    
            }
            
            $szamla_torolt =  0;
            $szamla_img_name = "";
            $szamla_tipus = $_POST["szamla_tipus"]; 
            
           
            if (!file_exists($_FILES['fileToUpload']['tmp_name']) || !is_uploaded_file($_FILES['fileToUpload']['tmp_name']))
            { 
               $szamla_img_name = "";   
               //print_r ($_FILES["fileToUpload"]); 

            }else{
                $target_file = basename($_FILES["fileToUpload"]["name"]);
                
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
                
                $szamla_img_name = $szamla_kibocsato.'_'.$szamla_sorszam.'_'.$this->generateRandomString();
                
                $szamla_img_name = preg_replace('/[^a-zA-Z0-9]/','',  $szamla_img_name).'.'.$imageFileType;
                
                
                $this->szamla_img_uploda($szamla_img_name);

            }
           
          
                $sql = "INSERT INTO szamla_befogadas (szamla_telephely, szamla_atvevo,szamla_atvetdate,szamla_kibocsato,szamla_sorszam,szamla_megjegyzes,szamla_torolt,szamla_img_name,szamla_tipus)
                                            VALUES ('$szamla_telphely','$szamla_atvevo','$szamla_atvetdate','$szamla_kibocsato','$szamla_sorszam','$szamla_megjegyzes','$szamla_torolt','$szamla_img_name','$szamla_tipus')";

                if (mysqli_query($conn, $sql)) {
                    // echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                          
            mysqli_close($conn);
        }
        
       
    }
    
    private function szamla_img_uploda($szamla_img_name){
            
        $target_dir = "img/uploads/";
        $destination = $target_dir.$szamla_img_name;
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $this->message = "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
               $this->message = "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $this->message = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 2000000) {
            $this->message = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "pdf" ) {
            $this->message = "Sorry, only JPG, JPEG, PNG & PDF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
             $this->message = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $destination)) {
               // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                $this->message = "Számla kép sikeresen feltöltve:". basename( $_FILES["fileToUpload"]["name"]);
                
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    
    function Visualize_All_Szamla_Table_User($user) {
        //$conn = DbConnect();
        
          $atvevo_neve = $this->rogzito;
          $szamla_telephely = $this->telephely;
          $today_date = $this->date;
          $cimsor; 
          $szamlatipus = "nincs";
          $html ="";
        if($user == "napiosszes"){
        
        $sql = "SELECT * FROM szamla_befogadas WHERE szamla_atvetdate = '$today_date' AND szamla_telephely ='$szamla_telephely' AND szamla_torolt = '0'";
        $cimsor = "Napi összes átvett számla (kp és utalás):";
        }else{
        $sql = "SELECT * FROM szamla_befogadas WHERE szamla_atvetdate = '$today_date' AND szamla_telephely ='$szamla_telephely' AND szamla_torolt = '0' AND szamla_atvevo = '$atvevo_neve'";
        $cimsor = "$atvevo_neve   átvett számlái:";
               
        }
        $result = $this->conn->query($sql);

        $html .='<div class="">
                <table class="table table-striped">
                <thead>
                    <tr><th  colspan="3">'.$cimsor.'</th></tr>
                    <tr>
                      <th>No.:</th>
                      <th>Kp / Utalás</th>
                      <th>Átvevő</th>
                      <th>Kibocsátó</th>
                      <th>Számla sorszám</th>
                      <th>Megjegyzés</th>
                      <th>Számlakép</th>
                    </tr>
                  </thead><tbody>';
            
          if ($result->num_rows > 0) {    
            while ($row = $result->fetch_assoc()) {
                if ($row["szamla_tipus"] === "kp"){$szamlatipus = "készpénzes";}
                if ($row["szamla_tipus"] === "utalas"){$szamlatipus = "átutalásos";}
                
                $html .= '<tr>'
                        . '<td>'.$row["szamla_id"] . '</td>'
                        . '<td>'.$szamlatipus. '</td>'
                        . '<td>'.$row["szamla_atvevo"] . '</td>'
                        . '<td>'. $row["szamla_kibocsato"] . '</td>'
                        . '<td>'. $row["szamla_sorszam"] . '</td>'   
                        . '<td>'. $row["szamla_megjegyzes"] . '</td>' 
                        . '<td><a href="img/uploads/'. $row["szamla_img_name"] .'" target="_blank">'. $row["szamla_img_name"] . '</a></td>'
                        . '</tr>';
            }
        } else {
            $html .= "<tr><td>Nincs rögzített adat</td></tr>";
        }
        $html .= "</tbody></table></div>";
        
       return($html);
       // mysqli_close($conn);
    }
    
    
    //átvett számlák törlése használatbna  van 
    public function Visualize_Delete_Szamla_Table(){
        $conn = DbConnect();
        
          $atvevo_neve = $_SESSION['real_name'];
          $szamla_telephely = $_SESSION['set_telephely'];
          $today_date = date("y-m-d");
        
        $sql = "SELECT * FROM szamla_befogadas WHERE szamla_atvetdate = '$today_date' AND szamla_telephely ='$szamla_telephely' AND szamla_torolt = '0' AND szamla_atvevo = '$atvevo_neve'";
        $result = $conn->query($sql);

        echo '<form action="' . $_SERVER['PHP_SELF'] . '?pid=page25" method="post">';
            echo'<div class="container">
                    <h2>Átvett számlák törlése:</h2>
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.:</th>
                        <th>Átvevő</th>
                        <th>Kibocsátó</th>
                        <th>Számla sorszám</th>
                        <th>Megjegyzés</th>
                        <th>Törlésre kijelölt</th>
                    </tr>
                  </thead><tbody>';
            
          if ($result->num_rows > 0) {    
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>"
                . $row["szamla_id"] . "</td><td> "
                . $row["szamla_atvevo"] . "</td><td>"
                . $row["szamla_kibocsato"] . "</td><td>"
                . $row["szamla_sorszam"] . "</td><td>"   
                . $row["szamla_megjegyzes"] . "</td><td>" 
                . '<input type="radio" name="delete_szamla_id" value="' . $row["szamla_id"] . '"></td></tr>'
                ;
            }
        } else {
            echo "<tr><td>Nincs rögzített adat</td></tr>";
        }
        echo '<tr><td></td><td></td><td></td><td></td><td></td><td><button type = "submit" value = "Submit" type = "button" class = "btn btn-danger">Töröl</button></td></tr>';
        echo "</tbody></table></form>";
        
       
        mysqli_close($conn);
    }
    
    function User_Post_Delete_Szamla()
    {
        if (isset($_POST['delete_szamla_id'])) {
            $deleteid = $_POST['delete_szamla_id'];
            $conn = DbConnect();

            $sql = "UPDATE szamla_befogadas SET szamla_torolt=1 WHERE szamla_id='$deleteid'";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

    public function Szamlakekek_Keres_Form(){
      
    
    $html = "";
         
              
        $html .= '<div class="panel panel-danger">';
            $html .='<div class="panel-heading">Szeknnelt számlák számlaképek keresése.</div>';
            $html .= '<div class="panel-body">';
                $html .= '<form  class="form-inline" action="' . $_SERVER['PHP_SELF'] . '?pid=page78" method="post" >'; 
                
                //lekérdezési időszak eleje
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Időszak eleje :</label>
                        <div class=""><input type="date" class="form-control" name="startdate" value = ""></div>
                     </div>';
                //lekérdezés időszak vége
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Időszak vége :</label>
                        <div class=""><input type="date" class="form-control"  name="enddate" value = ""></div>
                     </div>';
                   
                 
                //szamla tipus
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Számla tipus:</label>
                        <div class="" style="margin-top:12px;">
                        <label class="radio-inline"><input type="radio" name="szamla_tipus" value="utalas">Utalás</label>
                        <label class="radio-inline"><input type="radio" name="szamla_tipus" value="kp">Kp.</label></div>
                     </div>';

                //telephely
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Rendelő :</label>
                        <div class="">';
                        
                        $html .='<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-building"></i></span>';
                            $html .='<select class = "form-control" name = "szamla_telephely">';
                            $html .= '<option value=""> Összes telephely </option>';
                             $html .= '<option value="iroda">Iroda</option>';
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
                
                 //kibocsátó
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Kibocsátó neve:</label>
                        <div class="">';
                        
                        $html .='<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-user-md" aria-hidden="true"></i></span>';
                            $html .='<input class="form-control" name="szamla_kibocsato" type="text" placeholder="Dr. XY kft.">';
                                            
                            $html .= '</div>';
                
                        $html .='</div>
                     </div>';           
                        
                //számlaszám
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Számlaszám :</label>
                        <div class="">';
                        
                        $html .='<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>';
                            $html .='<input class="form-control" name="szamlaszam" type="text" placeholder="ABCF1234">';
                                            
                            $html .= '</div>';
                
                        $html .='</div>
                     </div>';            
                        
                //fileneve
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >File neve:</label>
                        <div class="">';
                        
                        $html .='<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-file" aria-hidden="true"></i></span>';
                            $html .='<input class="form-control" name="filename" type="text" placeholder="file neve">';
                                            
                            $html .= '</div>';
                
                        $html .='</div>
                     </div>';       
                
             
                //gombok
                $html .= '<div class="form-group" style="padding-top:20px;padding-right: 1em;">';
                    $html .= '<label class="control-label"></label>';    
                    $html .='<div class="btn-group">';
                        
                        $html .='<button type="submit" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> Lekérdez</button>';
                        //$html .='<a href="#" onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
                        //$html .='<a href="#" onclick="CopyClipboard()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a>';                        
                        
                        $html .= '</div>'
                . '</div>';        
                $html .= '</form>';
            
            $html .='</div>';
            $html .='<div class="panel-footer">BMM
                </div></div>';
                
            return $html;
        
    }
    
    public function AdminPostSzamlaKereses(){
        $html ="";
        $cimsor = "";
        $szamla_tipus = NULL;
        
        if (isset($_POST["startdate"]) AND isset($_POST["enddate"]) AND  isset($_POST["szamla_telephely"]) AND isset($_POST["filename"]) AND isset($_POST["szamlaszam"]) AND isset($_POST["szamla_kibocsato"])){
            
        $startdate = $_POST["startdate"];
        $enddate =  $_POST["enddate"];
        $telephely = $_POST["szamla_telephely"];       
        $filename = $_POST["filename"];
        $szamlaszam = $_POST["szamlaszam"];
        $szamla_kibocsato = $_POST["szamla_kibocsato"];
        
              
        
        if (isset($_POST["szamla_tipus"])){
            $szamla_tipus = $_POST["szamla_tipus"];
        }else{
            $szamla_tipus = NULL;
        }
        
        if ($startdate != "" AND $enddate != "" ){
       
                $sql = "SELECT * FROM szamla_befogadas WHERE (szamla_atvetdate BETWEEN '$startdate' AND '$enddate') AND szamla_telephely LIKE'%$telephely%' AND szamla_img_name LIKE '%$filename%' AND szamla_torolt = '0' AND szamla_sorszam LIKE '%$szamlaszam%' AND szamla_kibocsato LIKE '%$szamla_kibocsato%' AND szamla_tipus LIKE '%$szamla_tipus%' ";
                        
        }else{
                $sql = "SELECT * FROM szamla_befogadas WHERE szamla_telephely LIKE'%$telephely%' AND szamla_img_name LIKE '%$filename%' AND szamla_torolt = '0' AND szamla_sorszam LIKE '%$szamlaszam%' AND szamla_kibocsato LIKE '%$szamla_kibocsato%' AND szamla_tipus LIKE '%$szamla_tipus%' ";
            
            
        }
        
        //echo $sql;
        
        
        $cimsor = $startdate.' - '.$enddate. ' Rendelő  : '.$telephely.' Szamalszam : '.$szamlaszam.' Név : '.$szamla_kibocsato.' tipus  : '.$szamla_tipus;
        
        $result = $this->conn->query($sql);

        $html .='<div class="">
                <table class="table table-striped">
                <thead>
                    <tr><th colspan="6" >'.$cimsor.'</th></tr>
                    <tr>
                      <th>No.:</th>
                      <th>Kp / Utalás</th>
                      <th>Rendelő</th>
                      <th>Átvevő</th>
                      <th>Kibocsátó</th>
                      <th>Számla sorszám</th>
                      <th>Megjegyzés</th>
                      <th>Számlakép</th>
                      <th>Utalás dátuma</th>
                      <th class="HiddenIfPrint">Utalás beállítása</th>
                    </tr>
                  </thead><tbody>';
        
        $szamlatipus = "Nincs!";
            
          if ($result->num_rows > 0) {    
            while ($row = $result->fetch_assoc()) {
                $id = $row["szamla_id"];   
                    
                if ($row["szamla_tipus"] === "kp"){$szamlatipus = "készpénzes";}
                if ($row["szamla_tipus"] === "utalas"){$szamlatipus = "átutalásos";}
                
                
                if ($row["szamla_utalas_date"] != NULL AND $row["szamla_tipus"] === "utalas" )
                {$class ="success";} else {$class ="warning";}
                
                
                    $html .= '<tr class ="'.$class.'" id = "'.$id.'">'
                        . '<td>'.$row["szamla_id"] . '</td>'
                        . '<td>'.$szamlatipus . '</td>'
                        . '<td>'.$row["szamla_telephely"] . '</td>'
                        . '<td>'.$row["szamla_atvevo"] . '</td>'
                        . '<td>'. $row["szamla_kibocsato"] . '</td>'
                        . '<td>'. $row["szamla_sorszam"] . '</td>'   
                        . '<td>'. $row["szamla_megjegyzes"] . '</td>' 
                        . '<td><a href="img/uploads/'. $row["szamla_img_name"] .'" target="_blank">'. $row["szamla_img_name"] . '</a></td>';
                        $html .= '<td id = "date'.$id.'">' . $row["szamla_utalas_date"]. '</td>';
                        $html .= '<td class="HiddenIfPrint"> '
                                . '<input  type ="date" value="'.$row["szamla_utalas_date"].'" id = "utalas_date'.$id.'">'
                                . '<button onclick = "Utalas(this.id)" id = "'.$id.'" style="font-size:1em"><i class="fa fa-check-circle"></i></button>'
                                . '<button onclick = "Utalas_torles(this.id)" id = "'.$id.'" style="font-size:1em"><i class="fa fa-eraser"></i></button></td></tr>';    
                        $html .= '</tr>';
            }
        } else {
            $html .= "<tr><td>Nincs rögzített adat</td></tr>";
        }
        $html .= "</tbody></table></div>";
        
       return($html);
            
            
        }
        
        
        
    }
    // random string a flie végére
private function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }
}
