<?php

/* 
 * Munkaiső adatok db -be
 */

include ( "../includes/DbConnect.inc.php");
include ( "../includes/SystemlogClass.php");
include ( "../includes/MunkaidoClass.php");;

if (isset($_POST["CardSerialNo"]) AND  isset($_POST["LogTelephely"]) AND isset($_POST["LogStatus"])  ){
    
    $CardSerialNo = $_POST["CardSerialNo"];
    $CardSerialNo = strtolower($CardSerialNo);
    $CardSerialNo = str_replace("ö","0",$CardSerialNo);   
    $CardSerialNo = str_replace("Ö","0",$CardSerialNo);
    
    $LogTelephely = $_POST["LogTelephely"];
    $LogStatus = $_POST["LogStatus"];
    $datetoday = date("Y-m-d");
    
    //6:30 előtt nem lehet belogoni munkaidőt
    $hour = intval(date("G"));
    $minute  =  intval(date ("i"));
    $accestime = false;
    if ($hour <= 6 AND $minute < 31){$accestime = false;} else {$accestime = true;}   
    
    
    $conn = DbConnect();
    
    //státusz ellenörzés
    if ($LogStatus != "NULL" AND $LogStatus != "Haviosszesito" AND $accestime){
    // káryta szám ellenörzés
        if (preg_match("/^[A-Fa-f0-9]*$/",$CardSerialNo) and strlen($CardSerialNo) <= 10) {
        
            
        //aktuális logok ellenörzése  ma már megéketett vagy elmet  
            $sql_0 = "SELECT * FROM munkaido_log WHERE  CardSerialNo = '$CardSerialNo' AND log_time LIKE '%$datetoday%' AND LogStatus = '$LogStatus' AND LogTelephely = '$LogTelephely' AND Torolt_log = '0' ";
            $result_0 = $conn->query($sql_0);
                if ($result_0->num_rows > 0) {
                    // ma már volt iylen log nem kell 
                    while($row = $result_0->fetch_assoc()) {
                        
                        echo'<div class="alert alert-warning alert-dismissible">
                                     <strong>Mai '.$LogStatus.' </strong> Rendelő: '. $row["LogTelephely"]. ' - '.$row["log_time"].' </br>
                                     </div>';
                    }
                // ha nincs ilyen log     
                } else {
                    // egyébként log tárolás 
           
                    // létező kiadott káryta ellenörzése    

                        $sql = "SELECT * FROM users WHERE CardSerialNo = '$CardSerialNo'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {    

                            while($row = $result->fetch_assoc()) {
                                //echo "Kedves " . $row["real_name"]. " kártyádat elfogadtuk, további szép napot!<br>";

                                // káryta log tárolása - nicsenek munkament változók
                                //$worktime = new MunkaidoClass();
                                
                                $timetamp = date("Y-m-d H:i:s");
                                
                                
                                $RoundedTime = MunkaidoClass::WorkTimeRound($timetamp,$LogStatus);
                                
                            // forras ip log
                                //whether ip is from share internet
                                
                            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                                $ip = $_SERVER['HTTP_CLIENT_IP'];
                            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];//whether ip is from proxy
                            } else {
                                $ip = $_SERVER['REMOTE_ADDR']; //whether ip is from remote address
                            }
                                
                                
                                        
                                $sql1 = "INSERT INTO munkaido_log (CardSerialNo,LogStatus,LogTelephely,RoundedTime,Source_IP,LogNote)
                                VALUES ('$CardSerialNo','$LogStatus','$LogTelephely','$RoundedTime','$ip','')";

                                if ($conn->query($sql1) === TRUE) {
                                    //echo ' Kártya tárolva :' .$row["CardReadableNo"];
                                      if ($LogStatus == 'Érkezés'){$class = 'success';} elseif ($LogStatus == 'Távozás'){$class = 'info';}else{$class = 'active';}

                                      echo'<div class="alert alert-'.$class.' alert-dismissible">
                                         <strong>'.$LogStatus.' tárolava! </strong> '. $row["real_name"]. ' - '.$row["CardReadableNo"].' - '.date("Y-m-d H:i:s").' </br>
                                         </div>';
                                      
                                            $systemlog = new SystemlogClass('Munkaidő: '.$LogStatus.'-'. $row["real_name"] ,$CardSerialNo);
                                            $systemlog->writelog();    
                                } else {
                                    echo "Error: " . $sql1 . "<br>" . $conn->error;
                                }

                            }    
                        }  else {
                            echo'<div class="alert alert-warning  alert-dismissible fade in">
                                 <strong>Munkaidő adatok ellenözése. Nem tárolódik esemény.</strong>  :-(
                                 </div>';

                            $systemlog = new SystemlogClass('Hibás munkaidő káryta!',$CardSerialNo);
                            $systemlog->writelog();


                        }
            }
            
        $conn->close();

        }else{
            echo '<div class="alert alert-danger  alert-dismissible fade in">
                     <strong> Érvénytelen kártyaszám! </strong>  :-(
                  </div>';
            
                $systemlog = new SystemlogClass('Érvénytelen kártyaszám!',$CardSerialNo);
                $systemlog->writelog();

        }
    }else{
        echo '<div class="alert alert-warning alert-dismissible fade in">
                 <strong> Káryta használatának ellenörzése - '.$hour.':'.$minute.'<br> Munkaidő kezdés 6:30 után lehet! </strong>
              </div>';
    }
    
  
  
    
}else{
    
    echo 'Nem érkezett kátryaszám';
}

