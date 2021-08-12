<?php



/**
 * Description of HirlevelkClass
 * Napi meetingek anyagai a   munkahelyi utasításokat kezelő osztály 
 * Hozzáadódik a 
 * @author Andras
 */
class HirlevelClass {
    //put your code here
    public  $date; 
    private $dbconn;
    private $writer;
    private $newsid;
    private $user;
    
function __construct() {
        //print "Hirlevel class ready\n";
        $this->date = date("Y-m-d");  
        $this->dbconn = DbConnect();
        $this->writer = $_SESSION['real_name'];
        $this->newsid = 0;
        $this->user = $_SESSION['real_name'];
    }
    
function __destrct(){}

public function Create_New_Hirlevel(){
    $html = "";
    $html .='<div class="container">
             <h2>Meeting anyagok kezelése.</h2>
                <div class="panel-group">
                  <div class="panel panel-default">
                    <div class="panel-heading">Hirlevlek szerkesztése.</div>
                    <div class="panel-body">';
                    $html .= $this->Create_New_Hir_Form(0);
          $html .= '</div> <div class="panel-footer"></div>'
               . '</div>'
            . '</div>';
            
    
       //$html .= 'Elolvasta:'.$this->Users_Who_Read_News(0).
   
    

          
    return $html;
}

private function Create_New_Hir_Form($edit_id){
    $html ="";
       
                
                $html .= '<div class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="title">Hírlevél címe:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="title" placeholder="Utasítás, hírlevél címe" name="title" required>
                  </div>
                  <label class="control-label col-sm-1" for="hir_id" >No:</label>
                  <div class="col-sm-1">          
                    <input type="text" class="form-control" id="hir_id" value="0" readonly >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="publisher">Kobocsátó, jóváhagyó:</label>
                  <div class="col-sm-10">          
                    <input type="text" class="form-control" id="publisher" placeholder="Dr Moravcsik Bence Orvosigazgató" name="publisher" required>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Kadás dátuma:</label>
                  <div class="col-sm-3">          
                  <input type="date" class="form-control" id="public_date" placeholder="'.$this->date.'"  value="'.$this->date.'" name="public_date">
                  </div>
                
                  <label class="control-label col-sm-2" for="pwd">Nyilvánosságra hozva:</label>
                  <div class="col-sm-1">          
                    <input type="checkbox" name="publisd" id="publisd">
                  </div>
                  <label class="control-label col-sm-2" for="pwd">Létrehoz:</label>
                  <div class="col-sm-2">
                    <button type="" onclick="hirlevel_post()" class="btn btn-danger">OK</button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Hírlevél szövege:</label>
                  <div class="col-sm-10">          
                    <textarea id="summernote" name="editordata"></textarea>
                  </div>
                </div>
               
               
                <input type="text"  id="hir_íro" value="'.$this->writer.'"  hidden>
              </div>';
 
    
    
    
    return $html;
    
    
    
}

private function Users_Who_Read_News($news_id){
    $html = "";
    
    $html .= '<div class="alert alert-info alert-dismissible" id="readers_'.$news_id.'">';
    $html .= 'Olvasta: ';
    
    
    $sql = "SELECT reader_id FROM news_readers WHERE news_id = $news_id";
        
    $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
            $html .=  $row["reader_id"]." - ";
            }
        } else {
            //$html .= "Nem olvasta senki.";
        }

    
    $html .= '</div>';
return $html;
} 

public function SelectNewsList(){
    
    $html ='';
    $publisd = '';
    $html .= '<div class="panel-group" id="accordion">';
    $sql = "SELECT * FROM `news` WHERE news_deleted <> '1' ORDER BY news_timestamp DESC";
        $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
       
                if ($row["news_publisd"] == 1) {  $publisd = '<p class="text-success">Publikus.</p>';}
                else  {  $publisd = '<p class="text-danger">Vázlat.</p>';}
    $html .= '
                <div class="panel panel-default">
                  <div class="panel-heading">
                  <div class="row">
                    <div class="col-sm-5">
                        <h4 class="panel-title">
                             <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$row["news_id"].'"> <em id="news_id">'.$row["news_id"].'</em> - '.$row["news_title"].'</a>
                        </h4>
                    </div>
                    
                    
                    <div class="col-sm-1" >'.$row["news_publisher"].'</div>
                    <div class="col-sm-2" >Dátum:'.$row["news_date"].'</div>
                    <div class="col-sm-1" > <a onclick ="hirlevel_szerkeszt('.$row["news_id"].')">Szerkeszt</a></div>
                    <div class="col-sm-1" > <a onclick="hirlevel_delete('.$row["news_id"].')" >Töröl</a></div>
                    <div class="col-sm-2" >'.$publisd.'</div>
                  </div>
                    
                  </div>
                  <div id="collapse'.$row["news_id"].'" class="panel-collapse collapse">
                    <div class="panel-body">'.$row["news_content"].'
                    <br><hr>';
            $html .= $this->Users_Who_Read_News($row["news_id"]);
          $html .= '</div>
                  </div>
                 
                </div>
             ';
            }
            } else {
                echo "0 results";
            }
    $html.= '</div>';        
    return $html;
    
}

public function SelectNewsListForUsers(){
    
    $html ='';
    $readedstatus = '';
    
    $html .= '<div class="panel-group" id="accordion">';
    $sql = "SELECT * FROM `news` WHERE news_deleted <> '1' and news_publisd = '1' AND news_date <= '$this->date' ORDER BY news_date DESC";
        
        $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $news_id = $row["news_id"];
                $sql2 = "SELECT * FROM `news_readers` WHERE  news_id = '$news_id' AND reader_id = '$this->user'";
        
                $result2 = $this->dbconn->query($sql2);
                
                if ($result2->num_rows > 0) {
                    //aktuális hír olvasott a felhasználó által
                    $readedstatus = 'panel panel-success';
                }else{
                    //nincs az olvasott listában
                   $readedstatus = 'panel panel-warning';
                }
    
        $html .= '
                <div class="'.$readedstatus.' " id="news_panel_'.$row["news_id"].'">
                  <div class="panel-heading">
                  <div class="row">
                    <div class="col-sm-6">
                        <h4 class="panel-title">
                             <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$row["news_id"].'"> <em id="news_id">'.$row["news_id"].'</em> - '.$row["news_title"].'</a>
                        </h4>
                    </div>
                             
                    <div class="col-sm-3" >'.$row["news_publisher"].'</div>
                    <div class="col-sm-3" >Kiadás dátuma : '.$row["news_date"].'</div>
                    
                  </div>
                    
                  </div>
                  <div id="collapse'.$row["news_id"].'" class="panel-collapse collapse">
                    <div class="panel-body">'.$row["news_content"].'
                    <br><hr><button type="button" class="btn btn-primary" onclick="olvastam('."'".$this->user."'".','."'".$row["news_id"]."'".' )" >Olvastam</button>';
            $html .= $this->Users_Who_Read_News($row["news_id"]);
          $html .= '</div>
                  </div>
                 
                </div>
             ';
            }
            } else {
                $html.= "Nincs hírlevél a rendszerben!";
            }
    $html.= '</div>';        
    return $html;
    
}

public function CheckUnreadedNews(){
    $html ='';
    $UnreaderNewsNo =0;
    $news_id =0;
    $unreaded =0;
    $readed =0;
    $allnews =0;
    
    $sql = "SELECT news_id FROM `news` WHERE news_deleted <> '1' and news_publisd = '1' AND news_date <= '$this->date' ORDER BY news_date DESC";
        
        $result = $this->dbconn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $news_id = $row["news_id"];
                $allnews ++;
                $sql2 = "SELECT * FROM `news_readers` WHERE  news_id = '$news_id' AND reader_id = '$this->user'";
        
                $result2 = $this->dbconn->query($sql2);
                
                if ($result2->num_rows > 0) {
                    //aktuális hír olvasott a felhasználó által
                    $readed ++;
                }else{
                    //nincs az olvasott listában
                   $unreaded ++ ;
                }
                       
            }
        } else {
//            $html .='<div class="alert alert-danger alert-dismissible fade in">
//            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
//            <strong>Nincs publikált hírlevél!</strong> Kedves '.$this->user.' 0 db olvasatlan hírleveled !
//            </div>';
        }
        
    if ( $unreaded > 0){
        $html .='<div class="alert alert-danger alert-dismissible fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Olvasatlan hírleveled van!</strong> Kedves '.$this->user.' '. $unreaded .' db olvasatlan hírlevéled van. Nyisd meg a meeting anyagok részt és elolvasás után alul jelölt olvasottra!
        </div>';
    }else{
//        $html .='<div class="alert alert-success alert-dismissible fade in">
//        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
//        <strong>Nincs olvasatlan hírlevled!</strong> Kedves '.$this->user.' '.$readed.' db olvasott hírleveled van!
//        </div>';
          
    }
    //$html .= $allnews .'='. $readed. ' + '.$unreaded;
    return $html;
}
}
