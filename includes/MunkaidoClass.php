<?php

/*
 * BMM elszámoló rendszer munkaidő nyilvántartási modul
 */

/**
 * Description of MnkaidoClass
 *
 * @author Andras
 */
class MunkaidoClass {
    //put your code here
    public  $date; 
    private $dbconn;
    private $writer;
    private $newsid;
    private $user;
    private $cardSerialNo;
    private $telephely;
    private $napi_erkezes;
    private $napi_tavozas;
    private $havi_osszes_munkaora_time;
    private $havi_osszes_munkaora;
    private $havi_szabi_ora;
    private $havi_betegallomany_ora;
    private $havi_egyebtavolloet_ora;
    private $R_hour;// kerekített ídők
    private $R_minute;
    private $m_hour;
    private $m_minute;
    private $munkakozi_szunet_sec;
    private $riport_time;  // valós vagy kerekített időkkel
    private $napi_munkaido_secundum; //napi munkaidő másodpercben
    private $napi_munkaido_secundum_brutto; 
    private $havi_munkaido_szombat;
    private $szombat_m_hour;
    private $szombat_m_minute;
    private $havi_munkaido_vasarnap;
    private $vasarnap_m_hour;
    private $vasarnap_m_minute;
    private $havi_munkaido_18_utan;
    private $m_18_utan_ora;
    private $m_18_utan_minute;
    private $m_telephely;
    
function __construct() {
       
        $this->date = date("Y-m-d");  
        $this->dbconn = DbConnect();
        $this->writer = $_SESSION['real_name'];
        $this->newsid = 0;
        $this->user = $_SESSION['real_name'];
        $this->cardSerialNo = "000000";
        $this->telephely = $_SESSION['set_telephely'];
        $this->napi_erkezes = '00:00';
        $this->napi_tavozas = '00:00';
        $this->havi_osszes_munkaora = 0;
        $this->havi_osszes_munkaora_time = 0;
        $this->R_hour="0";
        $this->R_minute = "0";
        $this->m_hour="0";
        $this->m_minute = "0";
        $this->munkakozi_szunet_sec = 0;
        $this->riport_time = "kerek";
        $this->havi_szabi_ora = 0;
        $this->havi_betegallomany_ora = 0;
        $this->havi_egyebtavolloet_ora = 0;
        $this->napi_munkaido_secundum = 0;
        $this->napi_munkaido_secundum_brutto = 0;
        $this->havi_munkaido_szombat = 0;
        $this->havi_munkaido_vasarnap =0;
        $this->havi_munkaido_18_utan =0;
        $this->vasarnap_m_hour= 0;
        $this->vasarnap_m_minute = 0; 
        $this->szombat_m_hour= 0;
        $this->szombat_m_minute = 0; 
        $this->munkaido_18_utan =0;
        $this->m_18_utan_minute = 0;
        $this->m_18_utan_ora = 0;
        $this->m_telephjely = 'err';
    }
    
function __destrct(){
    mysqli_close($this->$dbconn);
    
}
    
 
public function UserReadCard_Form (){
    $html = "";
    
    $html = '<div class="form-horizontal" >
               <from> 
                <div class="form-group">
                  <label class="control-label col-sm-2" for="email">Kártya olvasás:</label>
                  
                   <div class="col-sm-2">
                    <select class="form-control" id="LogStatus" required>
                    
                        <option value="Érkezés">Érkezés</option>
                        <option value="Távozás" >Távozás</option>
                        <option value="NULL" selected>Ellenörzés</option>
                         
                    </select>
                    
                   </div>  
                   <div class="col-sm-3">
                        <input  type="text" autocomplete="off" class="form-control" placeholder="KLIKK IDE - Kártya olvasás.!" id="CarSerialNo" onchange="UserCardIsRead()" autofocus required>
                        <input  type="hidden" id="LogTelephely" value="'.$this->telephely.'" >
                  </div>
                   <div class="col-sm-5">
                        <div id="cardlog"></div>
                  </div>
                </div>
               </form>
                
            </div>';
    
    
    return $html;
}

public function MunkaidoQueryFrom(){
    $html = "";
    
    $date = strtotime($this->date);
    $month = date("Y-m",$date);
    
        $html .= '<div class="panel panel-danger" id = "HiddenIfPrint">';
        $html .= '<div class="panel-heading">Munkaidő nyilvántartás</div>';
        $html .= '<div class="panel-body">';
        $html .= '<form method="POST" action="index.php?pid=page203" class="form-inline">';
                
                       
        $html .=  '<div class="form-group" style="margin-right: 20px;">'
                . '<label class="control-label" for="month"> Keresett hónap: </label>'
                . '<input id="month" type="month" class="form-control" name="munkaido_month" value="'.$month.'"></div>'
                . '<div class="form-group" style="margin-right: 20px;"><label for="users"> Dolgozó :</label>
                    <select class="form-control" id="users" name="munkido_user">';
                    
                    $sql = "SELECT * FROM users WHERE CardSerialNo <> '' ORDER BY real_name ASC ";
                    
                    $result = $this->dbconn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                           $html .= '<option value="'.$row["real_name"].'">'.$row["real_name"].'</option>';
                        }
                    } else {
                          $html .= '<option>Nincs kiosztott kártya a rendszerben</option>';
                    }
        
        
        $html .= '</select></div>';
        $html .=  '<div class="form-group" style="margin-right: 20px;"><label class="control-label" for="riporttype">Riport címe:</label> '
                . '<label class="radio-inline"><input type="radio" name="riporttype" id="riporttype" value="teny"checked>Tény</label>'.
                 '<label class="radio-inline"><input type="radio" name="riporttype"  id="riporttype" value="terv">Terv</label></div>';
        $html .=  '<div class="form-group" style="margin-right: 20px;"><label class="control-label" for="riporttime">Időpontok:</label> '
                . '<label class="radio-inline"><input type="radio" name="riporttime" id="riporttime" value="kerek"checked>Kerekített</label>'.
                 '<label class="radio-inline"><input type="radio" name="riporttime"  id="riporttime" value="valos">Valós</label></div>';
        $html .= '<div class="btn-group"><button type="submit" class="btn btn-default">Riport készítés</button>';
        $html .='<a href="#" onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
        $html .='<a href="#" onclick="copyClipboard()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a></div>&nbsp;';                        
        
        $html .='<div class="btn-group">'
              . '<a href="#" onclick="location.reload(true);" tpye="button" class="btn btn-success" role="button" data-toggle="tooltip" title="munkaidő tábla adatit összesítve a havi nyilvántartáshoz menti"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Mentés havi adatokhoz </a>'
              . '<a href="index.php?pid=page2033" onclick="" tpye="button" class="btn btn-warning" role="button" data-toggle="tooltip" title="könyelői adatexporthoz tovább"><i class="fa fa-table" aria-hidden="true"></i> Könyvelői adatexport </a></div>';
        
        $html .= '</form>';
        
        $html .='</div>';
        
        
    // csak meghatározott user fér hozzá 
        
    if ($_SESSION['real_name'] == "Moravcsik Réka" OR $_SESSION['real_name'] == "Gazdag András" OR $_SESSION['real_name'] == "Császár Viktória" OR $_SESSION['real_name'] == "Bocskay Éva"){    
        $html .='<div class="panel-footer">';
        
        $html .= '<form class="form-inline"  method="POST" action="index.php?pid=page203&method=insert">';
                
                       
        $html .=  '<div class="form-group" style="margin-right: 20px;">'
                . '<label class="control-label" for="month">Csippantás PÓTLÁSA - időpontja: </label>'
                . '<input id="csipp_date" type="date" class="form-control" name="csipp_date" value="$month">'
                . '<input id="csipp_time" type="time" class="form-control" name="csipp_time" value="10:10"></div>'
                . '<div class="form-group" style="margin-right: 20px;"><label for="users">Dolgozó :</label>
                    <select class="form-control" id="users" name="munkido_user">';
                    
                    $sql = "SELECT * FROM users WHERE CardSerialNo <> '' ORDER BY real_name ASC ";
                    
                    $result = $this->dbconn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                           $html .= '<option value="'.$row["CardSerialNo"].'">'.$row["real_name"].'</option>';
                        }
                    } else {
                          $html .= '<option >Nincs kiosztott kártya a rendszerben</option>';
                    }
        
        
        $html .= '</select></div>'.
                              
                 '<div class="form-group" style="margin-right: 20px;"><label for="status">Státusz :</label>'.
                    ' <select class="form-control" id="status" name="status">
                            <option value="Érkezés">Érkezés</option>
                            <option value="Távozás">Távozás</option>
                                     
                     </select>
                        
                  </div>';
        $html .= '<div class="form-group" style="margin-right: 20px;"><label for="telephely">Rendelő :</label>'.
                        '<select class="form-control" id="telephely" name="LogTelephely">
                            <option value="BMM">BMM</option>
                            <option value="Fizio">Fizio</option>
                            <option value="Óbuda" >Óbuda</option>
                            <option value="P70">P70</option>
                            <option value="P72">P72</option>
                        </select>
                        
                  </div>';
               
        $html .= '<div class="form-group" style="margin-right: 20px;"><label for="potlasoka">Pótlás oka :</label>'.
                        '<select class="form-control" id="potlasoka" name="PotlasOka">
                            <option value="elfelejtett csippanatani" >Elfelejtett csippanatani</option>                            
                            <option value="késés">Késés</option>
                            <option value="kártya hiány">Kártya hiány</option>
                            <option value="egyéb ok">Egyéb ok</option>
                        </select>
                        
                  </div>';          
        
       $html .=  '<button type="submit" class="btn btn-default">ADD</button>';
       
       $html .= '</form>'
                . '</div>';
    }        
       
       $html .= '</div>';
    
         //$html .= $this->munakido_table();
    return $html;
}


public function DolgozoHavi_MunkaidoTable(){
    
     $html = "";
    
    $date = strtotime($this->date);
    $month = date("Y-m",$date);
    
        $html .= '<div class="panel panel-danger" id = "HiddenIfPrint">';
        $html .= '<div class="panel-heading">Munkaidő nyilvántartás - Havi munkaidő elszámolás nyomtatása</div>';
        $html .= '<div class="panel-body">';
        $html .= '<form method="POST" action="index.php?pid=page2031" class="form-inline">';
        
        $html .=  '<div class="form-group" style="margin-right: 20px;"><label class="control-label" for="riporttype">Riport címe:</label> '
                . '<label class="radio-inline"><input type="radio" name="riporttype" id="riporttype" value="teny"checked>Tény</label>'.
                 '<label class="radio-inline"><input type="radio" name="riporttype"  id="riporttype" value="terv">Terv</label></div>';
                       
        $html .=  '<div class="form-group" style="margin-right: 20px;">'
                . '<label class="control-label" for="month"> Keresett hónap: </label>'
                . '<input id="month" type="month" class="form-control" name="munkaido_month" value="'.$month.'"></div>'
                . '<div class="form-group" style="margin-right: 20px;"><label for="users"> Kártya csippantás :</label>
                   <input  name="Card_No" type="password" autocomplete="off" class="form-control" placeholder="KLIKK IDE - Kártya olvasás.!" id="CarSerialNo" onchange="" autofocus required>
                   </div>';
      
        
        $html .= '<input type="hidden" name="riporttime" id="riporttime" value="kerek"checked>';
//        $html .=  '<div class="form-group" style="margin-right: 20px;"><label class="control-label" for="riporttime">Időpontok:</label> '
//                .'<label class="radio-inline"><input type="radio" name="riporttime" id="riporttime" value="kerek"checked>Kerekített</label>'.
//                 '<label class="radio-inline"><input type="radio" name="riporttime"  id="riporttime" value="valos">Valós</label></div>';
//        
        $html .= '<div class="btn-group">';
      //  $html .='<a href="#" onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
        $html .='<a href="#" onclick="copyClipboard()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a></div>';                        

        $html .= '</form>';
        
        $html .='</div></div>';
        
     
         //$html .= $this->munakido_table();
    return $html;
    
    
    
}


public function Admin_post_munkaido_query(){
    
    $html ='';
    if (isset ($_POST["munkaido_month"]) AND isset($_POST["munkido_user"])){
   // if (isset($_POST["munkaido_users"]) AND isset($_POST["munkaido_month"])){
        $date = $_POST["munkaido_month"];
        $user = $_POST["munkido_user"];
        $type = $_POST["riporttype"];
        $this->riport_time = $_POST["riporttime"];
        $html .= '<div class="container">';       
           
        $html .= $this->munakido_table($date,$user,$type);
          
        $html .= '</div>';
    }
    // adatok pótcsippantás a mnkaidő táblába
    if (isset($_GET["method"]) AND $_GET["method"] == "insert"){
        
        $insert_date = test_input($_POST["csipp_date"]);
        $insert_time = test_input($_POST["csipp_time"]);
        $insert_CardSerialNo = test_input($_POST["munkido_user"]);
        $insert_status = test_input($_POST["status"]);
        $insert_LogTelephely = test_input($_POST["LogTelephely"]);          
        $potlas_oka = test_input($_POST["PotlasOka"]);
        
        
        $log_time = $insert_date.' '.$insert_time.':00';  
        $time = strtotime($log_time);
        $log_time = date ("Y-m-d H:i:s",$time);
        $month  = date("Y-m",$time); 
        
        $modify = $potlas_oka. " - ".$_SESSION["real_name"];
        
        $RoundedTime = $this->WorkTimeRound($log_time,$insert_status);
        
        $sql = "INSERT INTO munkaido_log (log_time, CardSerialNo, LogStatus, LogNote ,RoundedTime,LogTelephely)
        VALUES ('$log_time', '$insert_CardSerialNo', '$insert_status', '$modify', '$RoundedTime','$insert_LogTelephely')";

        if ($this->dbconn->query($sql) === TRUE) {
            //$html .= "New record created successfully";
            
            $sql = "SELECT real_name FROM users WHERE   CardSerialNo = '$insert_CardSerialNo'";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        
                        $html .= '<div class="container">';       
                        $html .= $this->munakido_table($month,$row["real_name"],"teny");
                        $html .= '</div>';
                        
                    }
                } else {
                    $html .=  "User Selection Error";
                }
        
        } else {
            
            $html .= "Error: " . $sql . "<br>" . $this->dbconn->error;
        }
        
    }
    return $html;
    
}

public function User_post_munkaido_query(){
    
  $html='';
    if (isset ($_POST["munkaido_month"]) AND isset($_POST["Card_No"])){
   // if (isset($_POST["munkaido_users"]) AND isset($_POST["munkaido_month"])){
        $date = $_POST["munkaido_month"];
        $Card_No = $_POST["Card_No"];
        $Card_No = str_replace("ö","0",$Card_No);   
        $Card_No = str_replace("Ö","0",$Card_No);
        $type = $_POST["riporttype"];
        $this->riport_time = $_POST["riporttime"];
        $user = "";
        
    //kártyaszámból felhasználót
        
        $sql = "SELECT * FROM users WHERE CardSerialNo = '$Card_No'";
                        $result = $this->dbconn->query($sql);
                        if ($result->num_rows > 0) {    
                            while($row = $result->fetch_assoc()) {
                            
                            $user = $row['real_name'];    
                            
                            $html .= '<div class="container">';       
           
                            $html .= $this->munakido_table($date,$user,$type);
          
                            $html .= '</div>';
                            
                            
                          }
                } else {
                    echo "User -> cardread error";
                }
        
       
    }
    
    
    return $html;
}




private function munakido_table($date,$user,$riport_type){
    
    $datestamp = strtotime($date);
    $year =  date('Y',$datestamp);
    $month = date('n',$datestamp);
    $honap_nevek = array ("NULL","Január","Február","Március","Április","Május","Június","Július","Augusztus","Szeptember","Október","November","December");
    $nap_nevek = array ("Vasárnap","Hétfő","Kedd","Szerda","Csütörtök","Péntek","Szombat");    
    $daysofmonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
    $CardNo = $this->UsersCardNo($user);
    $tavollet_status = array ("Egyébtávollét","Betegállomány","Szabadság");
    $riporttitle = "MUNKAIDŐ-NYILVÁNTARTÁS";
    //$breaktime = $this->SelectMunkakoziSzunet($user);
    $napi_munkaido = "";
    $napi_munkaszunket = "";
    
    if ($riport_type == "teny")   $riporttitle = "MUNKAIDŐ-NYILVÁNTARTÁS";
    if ($riport_type == "terv")   $riporttitle = "TERVEZETT MUNKAIDŐ BEOSZTÁS";
    
    $arrive = "00:00";
    $leave = "00:00";
    
    $html ="";
    $html .= '<div class="ritz grid-container" dir="ltr">';
    
    $html .= $this->munakido_table_css();
    
    $html .= '<table class="waffle" cellspacing="0" cellpadding="0" id="riport">
      
      <tbody>
         <tr style="height:24px;">
          
            <td class="s0" colspan="19" >'.$riporttitle.' ('.$date.')</td>
         </tr>
        
         
         <tr style="height:18px;">
            <td class="s1" colspan="2">Foglalkoztató neve:</td>
            <td class="s2" colspan="5"> Medport Kft. 1114 Bp Bartók Béla út 11-13</td>
            <td class="s1" colspan="2">Munkavégzés helye:</td>
            <td class="s2" colspan="5"></td>
             <td class="s0" colspan="2">Munkavállaló neve:</td>
            <td class="s2" colspan="3" id="munkavallalo_neve">'.$user.'</td>
         </tr>
         <tr style="height:18px;">
            
            <td class="s3" colspan="2" rowspan="2">'.$honap_nevek["$month"].'</td>
            <td class="s3" colspan="5">Munkaidő</td>
            <td class="s3" colspan="5">Rendkívüli munkaidő</td>
            <td class="s3" colspan="3">Készenlét</td>
            <td class="s4" dir="ltr" rowspan="3">Egyéb távollét</td>
            <td class="s4" dir="ltr" rowspan="3">'.$tavollet_status[1].'</td>
            <td class="s4" dir="ltr" rowspan="3">'.$tavollet_status[2].'</td>
            <td class="s3" rowspan="2">Munkaidő</td>
         </tr>
         <tr style="height:18px;">
            
            <td class="s5" rowspan="2">Kezd.</td>
            <td class="s6" rowspan="2">Aláírás</td>
            <td class="s5 softmerge">
               <div class="softmerge-inner" style="width:80px; left: -3px;">M. szünet</div>
            </td>
            <td class="s5" rowspan="2">Vége</td>
            <td class="s5" rowspan="2">Aláírás</td>
            <td class="s5" rowspan="2">Kezd.</td>
            <td class="s6" rowspan="2">Aláírás</td>
            <td class="s5 softmerge">
               <div class="softmerge-inner" style="width: 80px; left: -3px;">M. szünet</div>
            </td>
            <td class="s9"></td>
            <td class="s9"></td>
            <td class="s10"></td>
            <td class="s5 softmerge">
               <div class="softmerge-inner" style="width: 80px; left: -8px;">M.szünet</div>
            </td>
            <td class="s9"></td>
         </tr>
         <tr >
            
            <td class="s11">Dátum</td>
            <td class="s5">Napok</td>
            <td class="s5">perc</td>
            <td class="s5">perc</td>
            <td class="s5">Vége</td>
            <td class="s5">Aláírás</td>
            <td class="s5">Kezd.</td>
            <td class="s5">perc</td>
            <td class="s5">Vége</td>
            <td class="s3">óra</td>
         </tr>';
    
      
        for ($day = 1;$day<=$daysofmonth;$day++ ){
        
                if ($day < 10){$actualday = $date.'-0'.$day;}    
                    else { $actualday = $date.'-'.$day;}

                $actualtimestamp = strtotime($actualday);
                $daynum = date("w",$actualtimestamp);    
                
                $this->napi_munkaido_secundum = 0;
                $this->napi_munkaido_secundum_brutto = 0;
                
                if ($daynum == 0 OR $daynum == 6 ){$style = "background-color: #d9d9d9 !important;"; } else {$style = "";}

                
                //$dayid = $year.':'.$month.':'.$day;
                $dayid = $actualday;
                $napi_erkezes = $this->SelectUserDailyLog($CardNo, $actualday, "Érkezés");
                $napi_tavozas = $this->SelectUserDailyLog($CardNo, $actualday, "Távozás");
                $napi_munkaido = $this->NapiMunkaido($daynum);
                
                $this->Store_napi_munkaido($actualday, $CardNo, $this->napi_munkaido_secundum/3600 , $this->m_telephely);
                   
                $html .= '<tr style="'.$style.'" id = "'.$year.'.'.$month.'.'.$day.'">

                    <td class="s12">'.$honap_nevek["$month"].' '.$day.'</td>
                    <td class="s13">'.$nap_nevek[$daynum].'</td>
                    <td class="s14">'.$napi_erkezes.'</td>
                    <td class="s14"></td>
                    <td class="s14">'.$this->SelectMunkakoziSzunet($user).'</td>
                    <td class="s14">'.$napi_tavozas.'</td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14" onclick = addXtobox(this.id,"'.$tavollet_status[0].'","'.$dayid.'") id="egyebtavollet-'.$dayid.'">'.$this->SelectUserDailyTavollet($CardNo, $actualday,$tavollet_status[0]).'</td>
                    <td class="s14" onclick = addXtobox(this.id,"'.$tavollet_status[1].'","'.$dayid.'") id = "betegallomany-'.$dayid.'">'.$this->SelectUserDailyTavollet($CardNo, $actualday,$tavollet_status[1]).'</td>
                    <td class="s14" onclick = addXtobox(this.id,"'.$tavollet_status[2].'","'.$dayid.'") id = "szabadsag-'.$dayid.'">'.$this->SelectUserDailyTavollet($CardNo, $actualday,$tavollet_status[2]).'</td>
                    <td class="s14">'.$napi_munkaido.'</td>
                 </tr>';
               
        }
        
        $html .= '<td class="s17 softmerge">
               <div class="softmerge-inner" style="width: 140px;">Összesen</div>
            </td>
            <td class="s18"></td>
            <td class="s18"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s14" id= "havi_egyebtavolloet_ora" >'.$this->havi_egyebtavolloet_ora.'</td>
            <td class="s14" id= "havi_betegallomany_ora" >'.$this->havi_betegallomany_ora.'</td>
            <td class="s14" id = "havi_szabi_ora" >'.$this->havi_szabi_ora.'</td>
            <td class="s14">'.$this->havi_osszes_munkaora.'</td>
         </tr>
         <tr>
           
            <td class="s19" colspan="2">Áthelyezett munkanap</td>
            <td class="s12"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
         </tr>
         <tr>
          
            <td class="s20" colspan="2">Munkaszüneti nap</td>
            <td class="s12"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s21" dir="ltr" colspan="12" rowspan="2">A rendes munkaidőn felüli munkaórákat elfogadom, a munkaidő-nyilvántartásnak megfelelő adatok alapján a bérszámfejtés elkészíthető.</td>
         </tr>
         <tr>
            
            <td class="s22" colspan="2">Áthelyezett pihenőnap</td>
            <td class="s12"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
         </tr>
         <tr>
           
            <td class="s13" colspan="2">Ledolgozandó munkaórák</td>
            <td class="s12"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s15"></td>
            <td class="s13" colspan="5">munkáltató aláírása</td>
         </tr>
      </tbody>
   </table>
</div>';
 
        
    $html.='<!-- Modal -->
<div id="MunkaidoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="location.reload(true)" >&times;</button>
        <h4 class="modal-title">Munkaidő adatok kezelése</h4>
      </div>
      <div class="modal-body" id="napi_munkaido_log">
        <p>Munkaidő adatok .....</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.reload(true)">Close</button>
      </div>
    </div>

  </div>
</div>';
        
    $this->Store_havi_sum($CardNo,$date);
            
    return $html;
}

private function UsersCardNo($user){
    $CardNo = "error";
    
    $sql = "SELECT * FROM users WHERE real_name = '$user'";
        $result = $this->dbconn->query($sql);

        if ($result->num_rows == 1) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $CardNo = $row["CardSerialNo"];
                $this->munkakozi_szunet_sec = $row["MK_szunet"];
            }
        } else {
            $CardNo = "Invalid user";
        }
   
    return $CardNo;
}

private function SelectUserDailyLog($CardNo,$day,$status){
    
    $time = "";
    $log_event = "ERR--Nincs adat";
    $RoundedTime = "--:--";
    $LogTime = "--:--";
    $log_id = 0;
    
  if ($status == "Érkezés"){
       // $sql = "SELECT * FROM munkaido_log WHERE LogStatus = '$status' AND CardSerialNo = '$CardNo' AND log_time LIKE '%$day%' ORDER BY log_id ASC LIMIT 1";
       $sql = "SELECT * FROM munkaido_log WHERE LogStatus = '$status' AND CardSerialNo = '$CardNo' AND log_time LIKE '%$day%' AND Torolt_log = '0' ORDER BY log_id DESC LIMIT 1";
  }
  if ($status == "Távozás"){
        $sql = "SELECT * FROM munkaido_log WHERE LogStatus = '$status' AND CardSerialNo = '$CardNo' AND log_time LIKE '%$day%' AND Torolt_log = '0' ORDER BY log_id DESC LIMIT 1";
  }
  
        $result = $this->dbconn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    
                    $log_id = $row["log_id"];
                    $time = $row["log_time"];
                    $timestamp = strtotime($time);
                    $time = date("H:i",$timestamp);
                    $this->m_telephely = $row["LogTelephely"];
                    
                    $log_event = $row["log_time"].' - '.$row["LogTelephely"] .' - '.$row["LogNote"];  
                    $RoundedTime = $row["RoundedTime"];
                    
                    if ( empty( $RoundedTime)== TRUE ){$RoundedTime = $time;}
                    
                    // napi munakidő kiszámítása csippantás időpontjával
                     if ($this->riport_time == "valos"){
                        if ($status == "Érkezés") {$this->napi_erkezes = $time;} //else {$this->napi_erkezes = '00:00';}
                        if ($status == "Távozás") {$this->napi_tavozas = $time;} //else {$this->napi_tavozas = '00:00';}
                        $LogTime = $time;
                         
                     }
                    // napi munakidő kiszámítása csippantás KEREKÍTETT időpontjával
                    if ($this->riport_time == "kerek"){
                        if ($status == "Érkezés") {$this->napi_erkezes = $RoundedTime ;} //else {$this->napi_erkezes = '00:00';}
                        if ($status == "Távozás") {$this->napi_tavozas = $RoundedTime ;} //else {$this->napi_tavozas = '00:00';}
                        $LogTime = $RoundedTime;
                    }    
                }
            } else {
                $time = "--:--";
                $this->napi_erkezes = '00:00';
                $this->napi_tavozas = '00:00';
            }
   
    $logback = '<span data-toggle="modal" title="'.$log_event.'" onclick = "GetMunkaidoEvents('.$log_id.')"  data-toggle="modal" data-target="#MunkaidoModal" >'.$LogTime.'</span>';// kerekített ídővel
    return $logback;
}

private function SelectUserDailyTavollet($CardNo,$day,$tavolletoka){
    
    //$log_event = "ERR--Nincs adat";
    // 8 órás alkalmazott
    //$napi_munkado = 8           ;
    // if ($CardNo == "89bd0941"){$napi_munkado = 6;} else {$napi_munkado = 8;}
    
    $napi_munkado = $this->User_napi_munkaora($CardNo);
    
        $sql = "SELECT * FROM munkaido_log WHERE CardSerialNo = '$CardNo' AND log_time LIKE '%$day%' AND Tavollet_oka = '$tavolletoka'";
  
        $result = $this->dbconn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                
                    $logback = 'X';
                    // stefán anett 6 órában 
                   
                    
                    switch ($tavolletoka){
                        
                        case "Szabadság":
                            $this->havi_szabi_ora += $napi_munkado;
                        break;
                        case "Egyébtávollét":
                            $this->havi_egyebtavolloet_ora += $napi_munkado;
                        break;
                        case "Betegállomány":
                             $this->havi_betegallomany_ora += $napi_munkado;
                        break;
                        default:
                        break;    
                    }
                    
                    
                }
            } else {
                 $logback = '';
            }
    
     
    
    return $logback;
}



public static function WorkTimeRound($TimeString, $Status){
    
    $RoundedWorkTime = "";
    $R_minute = "??";
    $R_hour = "??";
    
    $timestamp = strtotime($TimeString);
 
    $hour = date("G",$timestamp);
    $minute = date("i",$timestamp);
  
    if($Status == "Érkezés"){
    
        if ($minute <= 30) {$R_minute = '30'; $R_hour = $hour;}
        if ($minute > 30) {$R_minute = '00'; $R_hour = $hour + 1;}
    
//    if ($minute < 20) {$R_minute = '00'; $R_hour =  $hour;}
//    if ($minute >=20 AND $minute <= 40) {$R_minute = '30'; $R_hour =  $hour;}
//    if ($minute >40) {$R_minute = '00'; $R_hour =  $hour + 1 ;}
       
    }
   
   if($Status == "Távozás"){
       
       if ($minute <= 20) {$R_minute = '00'; $R_hour =  $hour;}
       if ($minute > 20 AND $minute <= 50) {$R_minute = '30'; $R_hour =  $hour;}
       if ($minute > 50) {$R_minute = '00'; $R_hour =  $hour + 1 ;}
       
//   if ($minute < 20) {$R_minute = '00'; $R_hour =  $hour;}
//   if ($minute >=20 AND $minute <= 40) {$R_minute = '30'; $R_hour =  $hour;}
//   if ($minute >40) {$R_minute = '00'; $R_hour =  $hour + 1 ;}
       
   }
   
//   $this->R_hour =  $R_hour;
//   $this->R_minute = $R_minute;
   
   $RoundedWorkTime = $R_hour.':'.$R_minute; 
   return $RoundedWorkTime;
}

public function RoundDBLogTime(){
    // korábbi logok kerekítése 1* fot
    
$sql = "SELECT * FROM munkaido_log";
$result = $this->dbconn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
        
            $logtime = $row["log_time"];
            $log_id = $row["log_id"];
            $status = $row["LogStatus"];

            $roudndedtime = $this->WorkTimeRound($logtime,$status);       

            $sql = "UPDATE munkaido_log SET RoundedTime ='$roudndedtime' WHERE log_id = '$log_id'";

                if ($this->dbconn->query($sql) === TRUE) {
                    echo "Record updated successfully<br>";
                } else {
                    echo "Error updating record: " . $this->dbconn->error;
                }

        }
    } else {
        echo "0 results";
    }   
}    

private function NapiMunkaido($daynum){
    
    
    $munkaidő = "Nincs adat";
   //$thsi->munkakozi_szunet_sec = 1800;
    $logback = '--:--';
    if ($this->napi_erkezes != "00:00" AND $this->napi_tavozas != "00:00" ){
    
   // $munkaido_secundum = (strtotime($this->napi_tavozas) - strtotime($this->napi_erkezes)-$this->munkakozi_szunet_sec); 
    $this->napi_munkaido_secundum_brutto = strtotime($this->napi_tavozas) - strtotime($this->napi_erkezes);
   
    // 4óra munkaidő felett jár 30 p munkaszünet 
    if ($this->napi_munkaido_secundum_brutto > 14400) {$this->napi_munkaido_secundum = $this->napi_munkaido_secundum_brutto - $this->munkakozi_szunet_sec;}
    else {$this->napi_munkaido_secundum = $this->napi_munkaido_secundum_brutto;}
    
    $init = $this->napi_munkaido_secundum;
        $hour = floor($init / 3600);
        $minute = floor(($init / 60) % 60);
        $seconds = $init % 60;

    $munkaidő = "$hour:$minute:$seconds";   
       
  
    
        $this->R_hour =  $hour;
        $this->R_minute = $minute;
        
    if ($hour <= 9){$hour = "0".$hour;}    
    
    if ($minute <= 9) {$minute = "0".$minute; }
    
    $this->HaviSummMuinkaido($daynum);   
    
    $this->napi_erkezes = '00:00';
    $this->napi_tavozas = '00:00';
    
    
    
    $logback = '<span data-toggle="tooltip" title="Jelenlét ('.$munkaidő.')">'.$hour.':'.$minute.'</span>';
    }
    return $logback;
   
   
    
}    


private function HaviSummMuinkaido($daynum){
    
   $this->m_hour += $this->R_hour;
   $this->m_minute += $this->R_minute;
   
   //vasárnap
   if($daynum == 0) {
       $this->vasarnap_m_hour += $this->R_hour;
       $this->vasarnap_m_minute += $this->R_minute;
   
       $this->havi_munkaido_vasarnap = $this->vasarnap_m_hour + ($this->vasarnap_m_minute/60);
   }
   //szombat
   if($daynum == 6) {
       $this->szombat_m_hour += $this->R_hour;
       $this->szombat_m_minute += $this->R_minute;
   
       $this->havi_munkaido_szombat = $this->szombat_m_hour + ($this->szombat_m_minute/60);
   }
   // hétköznap 18:00 után munkaidő összesítés havi szinten
   if($daynum > 0 AND $daynum < 6) {
       
       $tavozas_time = strtotime($this->napi_tavozas);
       $tavozas_hour = date("G",$tavozas_time);
       //echo $this->napi_tavozas;
       if ($tavozas_hour >= 18){
           
            $napi_munkaido_secundum_18utan = strtotime($this->napi_tavozas) - strtotime("18:00");
            $init = $napi_munkaido_secundum_18utan;
            $hour = floor($init / 3600);
            $minute = floor(($init / 60) % 60);
           
            $this->m_18_utan_minute += $minute;
            $this->m_18_utan_ora += $hour;
            
            $this->havi_munkaido_18_utan =  $this->m_18_utan_ora + ($this->m_18_utan_minute/60);
       }
     
   }
   
  // $this->havi_osszes_munkaora = round($this->m_hour + ($this->m_minute/60),0,PHP_ROUND_HALF_UP);
     $this->havi_osszes_munkaora = $this->m_hour + ($this->m_minute/60);
}
    
    
private function SelectMunkakoziSzunet($user) {
    
    $breaktime = "";
    
    //munkaidő hosszától függ a munkaközi szünet  4 h -ig 0 felette 30 perc
    
    if ($this->napi_munkaido_secundum_brutto != 0){$breaktime = 0; }
    
    if ($this->napi_munkaido_secundum_brutto > 14400){ 
        
        $sql = "SELECT MK_szunet FROM users where real_name='$user'";
        
        $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $breaktime = $row["MK_szunet"]/60;
            }
        } else {
           $breaktime = "err";
        }
    
    }
  
    
    return $breaktime;
}    
    






private function munakido_table_css(){

$css = ' <style type="text/css">

table{

border: 1px SOLID #999999;
}
.ritz .waffle a {
	color: inherit;
}

.ritz .waffle .s13 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s5 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #d9d9d9;
	text-align: center;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s16 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #d9d9d9;
	text-align: left;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s4 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #d9d9d9;
	text-align: center;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: middle;
	white-space: normal;
	overflow: hidden;
	word-wrap: break-word;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s9 {
        border-right: 1px SOLID #999999;
	border-left: none;
	background-color: #d9d9d9;
	text-align: center;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s11 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #d9d9d9;
	text-align: left;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s17 {
        border-bottom: 1px SOLID #999999;
	border-right: none;
	background-color: #ffffff;
	text-align: left;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s21 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: middle;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s14 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s18 {
	border:  1px SOLID #999999;
	background-color: #ffffff;
	text-align: left;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s6 {
	border:1px SOLID #999999;
	background-color: #d9d9d9;
	text-align: center;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s0 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #ffffff;
	text-align: center;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: middle;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s2 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #ffffff;
	text-align: left;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s19 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #b6d7a8;
	text-align: center;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s7 {
	border-left: none;
	background-color: #d9d9d9;
	text-align: center;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s12 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #ffffff;
	text-align: left;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s22 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #fce5cd;
	text-align: center;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s1 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #ffffff;
	text-align: left;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s3 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #d9d9d9;
	text-align: center;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: middle;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s10 {
	border-right: 1px SOLID #999999;
	background-color: #d9d9d9;
	text-align: center;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s8 {
	border-left: none;
	border-right: none;
	background-color: #d9d9d9;
	text-align: center;
	font-weight: bold;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s15 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #ffffff;
	text-align: left;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s20 {
	border-bottom: 1px SOLID #999999;
	border-right: 1px SOLID #999999;
	background-color: #a4c2f4;
	text-align: center;
	color: #000000;
	
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

</style>';
 
return $css;    
    
}


public function munkaido_konyveles_havi_queryform(){
    $html = "";
    $date = strtotime($this->date);
    $month = date("Y-m",$date);
    
        $html .= '<div class="panel panel-danger" id = "HiddenIfPrint">';
        $html .= '<div class="panel-heading">Munkaidő nyilvántartás - havi könyvelői adatösszesítés</div>';
        $html .= '<div class="panel-body">';
        $html .= '<form method="POST" action="index.php?pid=page2033" class="form-inline">';
                
                       
        $html .=  '<div class="form-group" style="margin-right: 20px;">'
                . '<label class="control-label" for="month"> Keresett hónap : </label>'
                . '<input type="month" id="konyveles_month" class="form-control" name="munkaido_month" value="'.$month.'">'
                . '<input type="hidden" name="munkaido_konyveles_export" value="konyveles_all_table">'
                . '</div>';
               
     
        $html .= '<div class="btn-group"><button type="submit" class="btn btn-default">Riport készítés</button>';
        $html .='<a href="#" onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
        $html .='<a href="#" onclick="copyClipboard()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a>'
              . '<a href="index.php?pid=page203" onclick="" tpye="button" class="btn btn-warning" role="button" data-toggle="tooltip" title="vissza a havi munkaidő táblákhoz"><i class="fa fa-table" aria-hidden="true"></i> Munkaidő nyilvántartás </a>';                        
        $html .= '</form>';
        
        $html .='</div></div></div>';
    
    
    
    return $html;
}    


public function Admin_post_munkaido_havikonyeloiexpotrt_query(){
   $html = ""; 
    
   if(isset($_POST["munkaido_month"]) AND isset($_POST["munkaido_konyveles_export"]) AND $_POST["munkaido_konyveles_export"] == "konyveles_all_table" ){
        
    $mounth =  $_POST["munkaido_month"];
       
    $html = '<div class="container" id="riport"><table class="table table-bordered" id="riport">
        <thead >
            <tr><th colspan="10" style="text-align:center;"><h2>Medport kft. - '.$mounth.' havi munkaidő összesítés</h2></th></tr>
            <tr>
                <th>Munkavállaló<br> néve</th>
                <th>Munkakör <br> Státusz</th>
                <th>Napi<br> munkaidő <br>óra</th>
                <th>Munkaórák <br>száma összesen</th>
                <th>Munkaórák<br> hétköznap<br>18:00 után</th>
                <th>Munkaórák <br>szombaton</th>
                <th>Munkaórák <br>vasárnap</th>
                <th>Szabadság <br>napok </th>
                <th>Betegállomány<br>táppénz <br>napok</th>
                <th>Egyéb <br>távollet <br>napok</th>
            </tr>
        </thead>
        <tbody>';
         
    $sql = "SELECT * FROM users WHERE CardSerialNo != '' AND MK_szunet != '0' ORDER BY real_name ASC ";
    $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                
                $CardSerialNo = $row["CardSerialNo"];
                $mk_ora = $row["MK_ora"];
                $this->munkakozi_szunet_sec = $row["MK_szunet"];
                
                $html .= '<tr><td>'.$row["real_name"].'</td><td>'.$row["MK_info"].'</td><td>'.$row["MK_ora"].'</td>';
                $html .= $this->havi_muakora_user($CardSerialNo, $mounth, $mk_ora); 
                
                $html .= '</tr>';
            }
        } else {
        echo "0 results";
        }
   
    $html .= '</tbody>
        </table>';
    
    // második tábla telephelyi bontásban 
    $html .= $this->Munkaido_telephelyi_bontasban($mounth);
    
    }
    
    
  
  return $html;  
}

private function havi_muakora_user($CardNo,$date,$mk_ora){
    $html = "";
    $summ_havi_munkaora = 0;
    $munkaora_1800_utan = 0;
    $munkaora_szombaton = 0;
    $munkaora_vasarnap = 0;
    $munkanap_szabi  = 0;
    $munkanap_beteg = 0;
    $munkanap_egyeb = 0;
    
    $sql = "SELECT * FROM munkaido_havi_sum WHERE havisum_CardSerNo = '$CardNo'  AND havisum_honap LIKE '%$date%' ORDER BY havisum_id DESC LIMIT 1";
    $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                
                $summ_havi_munkaora = $row["havisum_ora"];
                if ($row["havisum_szabi"] != 0) {$munkanap_szabi = $row["havisum_szabi"] / $mk_ora;} else {$munkanap_szabi = 0;}
                if ($row["havisum_beteg"] != 0) {$munkanap_beteg = $row["havisum_beteg"] / $mk_ora;} else {$munkanap_beteg = 0;}
                if ($row["havisum_egyeb"] != 0) {$munkanap_egyeb = $row["havisum_egyeb"] / $mk_ora;} else {$munkanap_egyeb = 0;}
                $munkaora_vasarnap = $row["havisum_vas"];
                $munkaora_szombaton = $row["havisum_szom"];
                $munkaora_1800_utan = $row["havisum_6"];
                
            }
        } else {
        $summ_havi_munkaora = 'nincs havi összesítés';
        }
    
                        
    $html .= '<td>'.$summ_havi_munkaora.'</td><td>'.$munkaora_1800_utan.'</td><td>'.$munkaora_szombaton.'</td><td>'.$munkaora_vasarnap.'</td><td>'.$munkanap_szabi.'</td><td>'.$munkanap_beteg.'</td><td>'.$munkanap_egyeb.'</td>';
    return $html;
}
 
private function Store_havi_sum($CardNo,$date){
    
        
    $sql = "INSERT INTO munkaido_havi_sum (havisum_CardSerNo, havisum_ora, havisum_szabi, havisum_beteg, havisum_egyeb,havisum_vas, havisum_szom, havisum_6, havisum_honap)
            VALUES ('$CardNo', '$this->havi_osszes_munkaora', '$this->havi_szabi_ora','$this->havi_betegallomany_ora','$this->havi_egyebtavolloet_ora','$this->havi_munkaido_vasarnap','$this->havi_munkaido_szombat','$this->havi_munkaido_18_utan','$date')";

            if ($this->dbconn->query($sql) === TRUE) {
                //echo "Havi adattábla frissítve";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    
    
}

private function User_napi_munkaora($CardNo){
    
    $munkaora = 8;
    
        $sql = "SELECT * FROM users WHERE CardSerialNo = '$CardNo'";
                    
                    $result = $this->dbconn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $munkaora = $row["MK_ora"];
                        }
                    } else {
                          $munkaora = 8;
                    }
    return $munkaora;
}

private function Munkaido_telephelyi_bontasban ($mounth){
    $html='';
    
    
     $html = '<table class="table table-bordered" >
        <thead >
            <tr><th colspan="10" style="text-align:center;"><h2>Medport kft. - '.$mounth.' havi munkaidő összesítés telephelyi bontásban</h2></th></tr>
            <tr>
                
                <th>Munkavállaló néve</th>
                <th>Munkakör <br> Státusz</th>
                <th>Budafoki</th>
                <th>Fizio</th>
                <th>P70</th>
                <th>P72</th>
                <th>Óbuda</th>
                <th>Összesen</th>
                
            </tr>
        </thead>
        <tbody>';
         
    $sql = "SELECT * FROM users WHERE CardSerialNo != '' AND (MK_info LIKE '%alk%' OR  MK_info LIKE '%efo%') ORDER BY real_name ASC ";
    $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                
                $CardNo = $row["CardSerialNo"];
                //$mk_ora = $row["MK_ora"];
                //$this->munkakozi_szunet_sec = $row["MK_szunet"];
                
                
                
                
                $html .= '<tr><td>'.$row["real_name"].'</td><td>'.$row["MK_info"].'</td>';
                $html .= '<td>'. $this->Munkaido_telephelyi_bontasban_SelectCount($CardNo, $mounth, 'BMM').'</td>';
                $html .= '<td>'. $this->Munkaido_telephelyi_bontasban_SelectCount($CardNo, $mounth, 'Fizio').'</td>';
                $html .= '<td>'. $this->Munkaido_telephelyi_bontasban_SelectCount($CardNo, $mounth, 'P70').'</td>';
                $html .= '<td>'. $this->Munkaido_telephelyi_bontasban_SelectCount($CardNo, $mounth, 'P72').'</td>';
                $html .= '<td>'. $this->Munkaido_telephelyi_bontasban_SelectCount($CardNo, $mounth, 'Óbuda').'</td>';
                $html .= '<td>'. $this->Munkaido_telephelyi_bontasban_SelectCount($CardNo, $mounth, '').'</td>';
                $html .= '</tr>';
            }
        } else {
        echo "0 results";
        }
   
         $html .= '<tr><th>Összesen</th><td></td>';
                $html .= '<td>'. $this->Munkaido_telephelyi_bontasban_SelectCount('', $mounth, 'BMM').'</td>';
                $html .= '<td>'. $this->Munkaido_telephelyi_bontasban_SelectCount('', $mounth, 'Fizio').'</td>';
                $html .= '<td>'. $this->Munkaido_telephelyi_bontasban_SelectCount('', $mounth, 'P70').'</td>';
                $html .= '<td>'. $this->Munkaido_telephelyi_bontasban_SelectCount('', $mounth, 'P72').'</td>';
                $html .= '<td>'. $this->Munkaido_telephelyi_bontasban_SelectCount('', $mounth, 'Óbuda').'</td>';
                $html .= '<td>'. $this->Munkaido_telephelyi_bontasban_SelectCount('', $mounth, '').'</td>';
                $html .= '</tr>';
        
        
    $html .= '</tbody>
        </table></div>';
    
    return $html;
}

private function Munkaido_telephelyi_bontasban_SelectCount($CardNo,$date,$telephely){
    $html ="";
    
    $sql = "SELECT SUM(mk_ora) AS sum_mk_ora FROM munkaido_telephely_sum WHERE date LIKE '%$date%' AND telephely LIKE '%$telephely%' AND CardNo LIKE '%$CardNo%'";
            
            $result = $this->dbconn->query($sql);

            if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                $html = $row["sum_mk_ora"];
              }
            } else {
              $html = 0;
            }
        
    return $html;
}


private function Store_napi_munkaido($date,$CardNo,$mk_ora,$telephely){
    // havi munaidő tárolása telephelyi bontásban 
    $sql = "SELECT * FROM munkaido_telephely_sum WHERE date = '$date' AND CardNo = '$CardNo' AND telephely = '$telephely'";
    $result = $this->dbconn->query($sql);
    $id = "";
    
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
              // van ilyen log update
            $id = $row["id"];
                $sql = "UPDATE munkaido_telephely_sum SET mk_ora='$mk_ora' WHERE id='$id'";

                    if ($this->dbconn->query($sql) === TRUE) {
                    //  echo "Record updated successfully";
                    } else {
                      echo "Error updating record: " . $this->dbconn->error;
                    }
            
          }
        } else {
             // nincs ilyen log insert    
                $sql = "INSERT INTO munkaido_telephely_sum (date, CardNo, mk_ora,telephely)
                        VALUES ('$date', '$CardNo', '$mk_ora', '$telephely')";

                        if ($this->dbconn->query($sql) === TRUE) {
                        //  echo "New record created successfully";
                        } else {
                          echo "Error: " . $sql . "<br>" . $this->dbconn->error;
                        }
          
        }
}

}
