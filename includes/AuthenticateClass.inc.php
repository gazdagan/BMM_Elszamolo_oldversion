<?php

class Authenticate {

    private $formtitle;
    private $action;
    private $method;
    private $ip;

    function __construct($formtitle, $actionfile, $method) {
        $this->formtitle = $formtitle;
        $this->action = $actionfile;
        $this->method = $method;
        
        $this->ip = 'Null' ;
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $this->ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];//whether ip is from proxy
            } else {
                $this->ip = $_SERVER['REMOTE_ADDR']; //whether ip is from remote address
                }
    }

    function VisualiseLoginForm() {
        // BOOTSTRAP FORM
        echo '<div class="container"><div class="row"><div class="col-sm-4"></div><div class="col-sm-4">';
        echo '<form class="form-signin" action="' . $this->action . '" method="' . $this->method . '" >';
        echo '<h2 class="form-signin-heading">' . $this->formtitle . '</h2>';
        echo '<label for="inputEmail" class="sr-only">Email address</label>
                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                </div>
                <br>
                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div><br>';
             
        $this->Visualize_Telephely_Radio();   
                    
        echo'<div class="checkbox">
                  <label>
                    <input type="checkbox" value="remember-me"> Remember me
                  </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
              </form>';
    }

    function Validate() {

        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['telephely'])) {
            $user_email = test_input($_POST['email']);
            $user_password = test_input($_POST['password']);
            $telephely = test_input($_POST['telephely']); 
              
//            // scolinea kizárás egyéb telepelyekről
                if($user_email == 'scolinea@bmm.hu' AND $telephely <> "Scolinea" ){ exit('<div class="container">
                         <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <div class="alert alert-danger">
                                <strong>Access denied!</strong>Login Disable Érvénytelen Telephely
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                        </div> 
                    </div>');}
                        
           
            $CardSerialNo  =  str_replace("ö","0",$user_password);
                    
            $db_connect = DbConnect();
            $sql_query = "SELECT * FROM users WHERE email = '$user_email' AND (jelszo = '$user_password' OR CardSerialNo = '$CardSerialNo') AND Enable_user = '1' AND tipus != 'patient' ";
            $query_result = $db_connect->query($sql_query);

           
            // újj ellenőrzés kell 
            if ($query_result->num_rows) {
//                $_SESSION['valid_user'] = $user_email;
//                $_COOKIE['valid_user'] = $user_email;
               
                if ($query_result->num_rows == 1) {
                    // output data of each row
                    while ($row = $query_result->fetch_assoc()) {
                        
                      
                        $_SESSION['valid_user'] = $row["email"];
                        $_SESSION['type_user'] = $row["tipus"];
                        $_SESSION['real_name'] = $row["real_name"];
                        $_SESSION['set_telephely'] = $telephely;
                        //$_COOKIE['valid_user'] = $row["email"];
                        $realname = $row["real_name"];
                        
                        // log írása user-log db-be
                        $logtxt = 'login: '. $telephely .' ip: '. $this->ip ;
                        $log = new SystemlogClass($realname, $logtxt);
                        $log->writelog(); 
                        
                                           
                    setcookie("valid_user", $realname, time() + 14400, "/");     // bejelentkezés érvényes ideje 4 óra 
                        
                    }
                } else {
                    echo "0 results";
                }




                echo '<div class="container">
                         <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <div class="alert alert-success">
                                <strong>Success!</strong>Login Enable
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                        </div> 
                    </div>';
                header('Refresh: 1; url=index.php');
            } else {
                echo '<div class="container">
                         <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <div class="alert alert-danger">
                                <strong>Access denied!</strong>Login Disable
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                        </div> 
                    </div>';
                //érvénytelen belépés logolása
                          
                $logtxt = 'u: '.$user_email.' p: '.$user_password.' ip: '. $this->ip ;;
                $log = new SystemlogClass('invalid login', $logtxt);
                $log->writelog(); 
                
            }
            $db_connect->close();
        }
    }

    function Logout() {
         
        $logtxt = 'logout: '.$_SESSION['set_telephely'] .' ip: '.$this->ip ;
        $user = $_SESSION['real_name'];
               
        $log = new SystemlogClass($user, $logtxt);
        $log->writelog(); 
       
        unset($_SESSION['valid_user']);
        //unset($_SESSION['type_user']);
        unset($_SESSION['real_name']);
        unset($_COOKIE['valid_user']);
        session_destroy();
    }
    
    function Visualize_Telephely_Select(){
      
        
        echo'<div class="input-group">'
        . '<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>';
        echo'<select class = "form-control" name = "telephely">';
        $conn = DbConnect();
        $sql = "SELECT * FROM telephelyek";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["telephely_neve"] . '">' . $row["telephely_neve"] . '</option>';
            }
        } else {
            echo "0 results";
        }
        echo '</select></div>';
        
        
    }
    
    function Visualize_Telephely_Radio(){
        echo'<div class="input-group">';
        
        $conn = DbConnect();
        $sql = "SELECT * FROM telephelyek";
        $result = $conn->query($sql);
            echo '<div class="col-xs-4"></div>'
            . '<div class="col-xs-4">';
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<label class="radio"><input type="radio" name = "telephely" value="' . $row["telephely_neve"] . '" required>' . $row["telephely_neve"] . '</label>';
                }
            } else {
                echo "0 results";
            }
            echo '</div>';
            echo '<div class="col-xs-4"></div>';
        echo '</div>';
        
        
    }
}

?>