<?php

/*
 * Budapest Mozgásszervi Begánrendelő Napi Elszámolás Projek
 * Gazdag András  * 
 * Mérnök Informatikus * 
 * Programozó Informatikus * 
 */

/**
 * Description of UserClass
 * Felhasználókat kezelő osztály
 * @author Andras
 */
class UserClass{
    public $usertype;
    
    
    //put your code here
public function admin_insert_user() {
        $conn = DbConnect();
        // tábla fejrész
        $date = date("y-m-d");

        echo'<h1>Felhasználók felvétele törlése</h1>';
        echo'<h2>BMM kártyák kezelése</h2>';
        echo '<table class="table table-striped">
                <thead>
                    <tr>
                        <th>Edit</th>
                        <th style="width:100px;">User Id</th>
                        <th>Login (email)</th>
                        <th>Jelszó</th>
                        <th>Tipus (user/admin)</th>
                        <th>Valódi név</th>
                        
                        <th>BMM ráírt szám </th>
                        <th>BMM card SerNo</th>
                        <th>Hozzáad</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                    <form action="' . $_SERVER['PHP_SELF'] . '?pid=page85" method="post">
                    <td></td>    
                    <td></td>
                    <td><input type = "email" class = "form-control" name = "user_email" placeholder="abcd@bmm.hu"></td>
                    <td><input type = "text" class = "form-control" name = "user_password" placeholder="********"></td>
                    <td> <select class="form-control" name="user_tipus">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="patient">Páciens</option>
                            <option value="jutalek">Jutalékos</option>
                         </select>
                    </td>
                    <td><input type = "text" class = "form-control" name = "user_real_name" placeholder="Abc Bmm"></td>
                   
                    <td><input type = "text" class = "form-control" name = "CardReadableNo" placeholder="2012 xxx xxx xxx"></td>
                    <td><input type = "text" class = "form-control" name = "CardSerialNo" placeholder="Olvasd ki a kártyaolvasóval"></td>                    

                    <td><button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Tárol</button></td>
                    </form></tr>';
        // echo'</tbody></table>';    

        mysqli_close($conn);
    }

    public function admin_delete_user() {
        $conn = DbConnect();

// táblázat visszaolvasása
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        echo '<form action="' . $_SERVER['PHP_SELF'] . '?pid=page85" method="post">';
        if ($result->num_rows > 0) {
// output decho "
            //echo'<table class="table table-striped"><tbody>';            
            while ($row = $result->fetch_assoc()) {
               
                if ($row["Enable_user"] == 1){$class = "success";}else{$class = "danger";}
                   
                
                echo '<tr class = "'.$class.'">'
                .'<td><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#usereditModal" onclick="edit_userdb_line('.$row["user_id"].')"><i class="fa fa-edit"></i></button></td>'
                . '<td>'.$row["user_id"] . '</td>'
                . '<td>'.$row["email"] . "</td>"
                . '<td>'.'*********' . "</td>"
                . '<td>'.$row["tipus"] . "</td>"
                . '<td>'.$row["real_name"] . "</td>"   
                . '<td>'.$row["CardReadableNo"] . "</td>"   
                . '<td>'.$row["CardSerialNo"] . "</td>"        
                . '<td>'.'<input type="radio" name="delete_user_id" value="' . $row["user_id"] . '"></td></tr>'
                ;
            }
        } else {
            echo "0 results";
        }
        echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>'
        . '<button type = "submit" value = "Submit" type = "button" class = "btn btn-warning">Töröl</button></td>';
        echo "</form></tbody></table>";

        mysqli_close($conn);
        
        echo $this->admin_update_user_access();
        
    }

    public function admin_post_delete_user() {
       
        if (isset($_POST['delete_user_id'])) {
           
            $deleteid = test_input($_POST['delete_user_id']);
            echo $deleteid;
            $conn = DbConnect();

            $sql = "DELETE FROM users WHERE user_id='$deleteid'";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }

    public function admin_post_insert_user() {
        
        
        if (isset($_POST['user_email']) && isset($_POST['user_password']) && 
                isset($_POST['user_tipus']) && isset($_POST['user_real_name'])) {
            
            //echo' insert user';
            $conn = DbConnect();
            // adatbázisba írás
            // tárolandó adatok bemeneti ellenörzése
            $user_email = test_input($_POST['user_email']);
            $user_password = test_input($_POST['user_password']);
            $user_tipus = test_input($_POST['user_tipus']);
            $user_real_name = test_input($_POST['user_real_name']);
            $CardReadableNo=test_input($_POST['CardReadableNo']);
            $CardSerialNo=test_input($_POST['CardSerialNo']);
            
           // $CardSerialNo = utf8_encode($CardSerialNo);
            //$CardSerialNo = iconv("UTF-8","Windows-1252",$CardSerialNo);
            
            $CardSerialNo = strtolower($CardSerialNo);
            $CardSerialNo = str_replace("ö","0",$CardSerialNo);
            $CardSerialNo = str_replace("Ö","0",$CardSerialNo);
            
            
            $sql = "INSERT INTO users (email,jelszo,tipus,real_name,CardReadableNo,CardSerialNo)
            VALUES ('$user_email','$user_password','$user_tipus','$user_real_name','$CardReadableNo','$CardSerialNo')";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }
    
    private function admin_update_user_access(){
        $html ="";
        
        $html = '<!-- Modal -->
        <div id="usereditModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update user data</h4>
              </div>
              <div class="modal-body" id="user_datas">
                <p>Nincs felhasználói adat.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>';
        
        
        
        return $html;
    } 
    
      // user update 
    public function admin_post_userupdate (){
        
        if ( isset($_POST["user_id"]) AND isset($_POST["jelszo"]) AND isset($_POST["tipus"]) AND
             isset($_POST["CardReadableNo"]) AND isset($_POST["CardSerialNo"]) AND  
             isset($_POST["Enable_user"]) AND isset($_POST["userupdate"]) ){
                
            $conn = DbConnect();
         
                $user_id=$_POST["user_id"];
                $jelszo=$_POST["jelszo"];
                $tipus=$_POST["tipus"];
                $CardReadableNo=$_POST["CardReadableNo"];
                $CardSerialNo = $_POST["CardSerialNo"];
                $CardSerialNo = strtolower($CardSerialNo);
                $CardSerialNo = str_replace("ö","0",$CardSerialNo);
                $CardSerialNo = str_replace("Ő","0",$CardSerialNo);
                $Enable_user = $_POST["Enable_user"];
                $email= $_POST["email"];
                $real_name = $_POST["real_name"];
                
                $set ="";
                
                if (empty($jelszo)){
                
                $set = "email = '$email', "
                        . "tipus = '$tipus', CardReadableNo = '$CardReadableNo',"
                        . "CardSerialNo = '$CardSerialNo', Enable_user  = '$Enable_user',real_name ='$real_name'"
                        . "WHERE user_id = '$user_id'";
                    
                }else{
                $set    ="email = '$email', jelszo = '$jelszo',tipus = '$tipus', CardReadableNo = '$CardReadableNo',"
                        . "CardSerialNo = '$CardSerialNo', Enable_user  = '$Enable_user',real_name ='$real_name'"
                        . "WHERE user_id = '$user_id'";
                }
                if ($_POST["userupdate"]=="userupdate"){

                    $sql = "UPDATE users SET ". $set;

                    if ($conn->query($sql) === TRUE) {
                        echo "Record updated successfully id:" . $user_id ;
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                
                }
            
        mysqli_close($conn);      
        }
    }    

public function recepcio_insert_paciens() {
        $conn = DbConnect();
        // tábla fejrész
        $date = date("y-m-d");

        echo'<h1>BMM Kártya felhasználók felvétele törlése</h1>';
        echo '<table class="table table-striped">
                <thead>
                    <tr>
                        <th>Edit</th>
                        <th style="width:100px;">User Id</th>
                        <th>Artéria No.</th>
                        <th>Tipus (páciens)</th>
                        <th>Valódi név</th>
                        <th>BMM ráírt szám </th>
                        <th>BMM card SerNo</th>
                        <th>Hozzáad</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                    <form action="' . $_SERVER['PHP_SELF'] . '?pid=page10&method=addpatient" method="post">
                    <td></td>    
                    <td></td>
                    <td><input type = "text" class = "form-control" name = "user_email" placeholder="607080"></td>
                    <td> <select class="form-control" name="user_tipus">
                            <option value="pacient" selected>Páciens</option>
                         </select>
                    </td>
                    <td><input type = "text" class = "form-control" name = "user_real_name" placeholder="Abc Bmm"></td>
                   
                    <td><input type = "text" class = "form-control" name = "CardReadableNo" placeholder="2012 xxx xxx xxx"></td>
                    <td><input type = "text" class = "form-control" name = "CardSerialNo" placeholder="Olvasd ki a kártyaolvasóval"></td>                    

                    <td><button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Tárol</button></td>
                    </form></tr>';
        // echo'</tbody></table>';    

        mysqli_close($conn);
    }
    
    
      public function recepcio_delete_user() {
        $conn = DbConnect();

// táblázat visszaolvasása
        $sql = "SELECT * FROM users WHERE tipus = 'patient'";
        $result = $conn->query($sql);
        echo '<form action="' . $_SERVER['PHP_SELF'] . '?pid=page10" method="post">';
        if ($result->num_rows > 0) {
// output decho "
            //echo'<table class="table table-striped"><tbody>';            
            while ($row = $result->fetch_assoc()) {
               
                if ($row["Enable_user"] == 1){$class = "success";}else{$class = "danger";}
                   
                
                echo '<tr class = "'.$class.'">'
                .'<td><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#usereditModal" onclick="edit_patinetdb_line('.$row["user_id"].')"><i class="fa fa-edit"></i></button></td>'
                . '<td>'.$row["user_id"] . '</td>'
                . '<td>'.$row["email"] . "</td>"
                . '<td>'.$row["tipus"] . "</td>"
                . '<td>'.$row["real_name"] . "</td>"   
                . '<td>'.$row["CardReadableNo"] . "</td>"   
                . "<td>********</td>"        
                . '<td>'.'<input type="radio" name="delete_user_id" value="' . $row["user_id"] . '"></td></tr>'
                ;
            }
        } else {
            echo "0 results";
        }
        echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>'
        . '<button type = "submit" value = "Submit" type = "button" class = "btn btn-warning">Töröl</button></td>';
        echo "</form></tbody></table>";

        mysqli_close($conn);
        
        echo $this->admin_update_user_access();
        
    }
    
    public function recepcio_post_insert_paciens() {
        
        
        if (isset($_POST['user_email']) && isset($_POST['user_tipus']) && isset($_POST['user_real_name']) && $_GET['method']=='addpatient') {
            
            //echo' insert user';
            $conn = DbConnect();
            // adatbázisba írás
            // tárolandó adatok bemeneti ellenörzése
            $user_email = test_input($_POST['user_email']);
           
            $user_tipus = 'patient';
            $user_real_name = test_input($_POST['user_real_name']);
            $CardReadableNo= test_input($_POST['CardReadableNo']);
            $CardSerialNo= test_input($_POST['CardSerialNo']);
            
                      
            $CardSerialNo = strtolower($CardSerialNo);
            $CardSerialNo = str_replace("ö","0",$CardSerialNo);
            $CardSerialNo = str_replace("Ö","0",$CardSerialNo);
            
            $sql = "INSERT INTO users (email,tipus,real_name,CardReadableNo,CardSerialNo)
            VALUES ('$user_email','$user_tipus','$user_real_name','$CardReadableNo','$CardSerialNo')";

            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }
    public function recepcio_post_patientupdate (){
        
        if ( isset($_POST["user_id"]) AND isset($_POST["tipus"]) AND $_POST["tipus"] == "patient" AND
             isset($_POST["CardReadableNo"]) AND isset($_POST["CardSerialNo"]) AND  
             isset($_POST["Enable_user"]) AND isset($_POST["userupdate"]) ){
                
            $conn = DbConnect();
         
                $user_id=$_POST["user_id"];
                $tipus=$_POST["tipus"];
                
                $CardReadableNo=$_POST["CardReadableNo"];
                $CardSerialNo = $_POST["CardSerialNo"];
                $CardSerialNo = strtolower($CardSerialNo);
                $CardSerialNo = str_replace("ö","0",$CardSerialNo);
                $CardSerialNo = str_replace("Ö","0",$CardSerialNo);
                
                $Enable_user = $_POST["Enable_user"];
                $email= $_POST["email"];
                $real_name = $_POST["real_name"];
                
                $set ="";
                
             
                
                $set = "email = '$email', "
                        . "tipus = '$tipus', CardReadableNo = '$CardReadableNo',"
                        . "CardSerialNo = '$CardSerialNo', Enable_user  = '$Enable_user',real_name ='$real_name'"
                        . "WHERE user_id = '$user_id'";
                    
                if ($_POST["userupdate"]=="userupdate"){

                    $sql = "UPDATE users SET ". $set;

                    if ($conn->query($sql) === TRUE) {
                        echo "Record updated successfully id:" . $user_id ;
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                
                }
            
        mysqli_close($conn);      
        }
    }    
    
    
}
