<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class telephely_db{
    
    // pillanatnyilag nam használt funkció
    public function select_telephely(){
        echo '<div class"container"> <h1>Telephely kiválasztása</h1>';
        
        echo '<div class="row">
                <div class="col-sm-3">';
            echo '<form method="post" action="'.$_SERVER["PHP_SELF"].'">';

                echo '<select class = "form-control" name = "telephely">';
                $connect = DbConnect();
                $sql = "SELECT * FROM telephelyek";
                $result = $connect->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                       
                        echo '<option value="' . $row[telephely_neve] . '">' . $row[telephely_neve] . '</option>';
                    
                    }
                } else {
                    echo "0 results";
                }

                echo '</select><br>';
            echo '<button type="submit"  class="btn btn-info">Kiválaszt</button>';;
            echo '</form>';
        echo '</div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
          </div> ';
         
        echo'</div>';        
  
    }
    
  public function set_telephely(){
          
            
      
          if (isset($_POST['telephely'])){
             $_SESSION["set_telephely"] = $_POST["telephely"];
          }
//          if (!isset($_SESSION["set_telephely"])){
//              
//             // $_SESSION["set_telephely"]=  $_POST["telephely"];
//              
//              $logtxt = 'nincs telephely';
//              $user = 'error admin';
//
//              $log = new SystemlogClass($user, $logtxt);
//              $log->writelog(); 
//             // Authenticate::Logout();
//            
//          }
         
  }  
    
}