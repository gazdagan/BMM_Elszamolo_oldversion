<?php


/**
 * Description of AdminNapiRiportClass
 *
 * @author Andras
 */
class AdminNapiRiportClass {
    
    //put your code here
    private $date; 
    private $where;
       
    private $startdate;
    private $enddate;
    private $intervall;
    
    private $chart_data;
    
   function __construct(){
   
       $this->date = date("Y-m-d"); 
       $this->enddate = "null";
       $this->startdate = "null";
       $this->intervall = "null";
       $this->where = "null";
       $this->kezelo = "null";
       
   }
            
             
    
    // kezelő kiválasztás és időintervallum kiválasztása
public function SelectKezeloForm(){
    
     $conn = DbConnect();

        echo'<div class="row" id="HiddenIfPrint">
                
                <div class="col-sm-4">
                    <div class="panel panel-info">    
                    <div class="panel-heading">Orvos vagy kezelő napi teljesítmény elemzés.</div>
                        <div class="panel-body">';


        echo '<form method="POST" class= "form-horizontal" action="' . $_SERVER["PHP_SELF"] . '?pid=page94">';
        //orovos kezelő
        echo '<div class="form-group">'
        . '<label class="col-sm-3 control-label">Orvos kezelő:</label>'
        . '<div class="col-sm-7">';
        echo '<select class = "form-control" onchange="" name="riport_kezelo">';


        $sql = "SELECT DISTINCT kezelo_neve FROM `kezelok_orvosok`";

        $result = $conn->query($sql);

        echo '<option value="NULL"> Válasszon </option>';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row[kezelo_neve] . '">' . $row[kezelo_neve] . '</option>';
            }
        } else {
            echo "Nincs eredmény!";
        }
        echo '</select></div></div>';

        // idő intervallumok kiválasztása
        echo '<div class="form-group">'
        . '<label class="col-sm-3 control-label">Idő intervallum:</label>'
        . '<div class="col-sm-7">';
        echo '<select class = "form-control" onchange="" name="riportintervall">';
                  
                echo '<option value="1">Napi adatsor</option>';
                echo '<option value="7">Hét napinként a kezdő dátumtól</option>';
        
        echo '</select></div></div>';
        
        //lekérdezési időszak eleje
                echo '<div class="form-group" style="padding-bottom: 0cm;">
                        <label class="col-sm-3 control-label" >Időszak eleje :</label>
                        <div class="col-sm-7"><input type="date" class="form-control" name="riport_startdate" value="2018-01-01"></div>
                     </div>';
        //lekérdezés időszak vége
                echo '<div class="form-group" style="padding-bottom: 1cm;">
                        <label class="col-sm-3 control-label" >Időszak vége :</label>
                        <div class="col-sm-7"><input type="date" class="form-control"  name="riport_enddate" value="'.$this->date.'" ></div>
                     </div>';
        
        
        
        echo'<div class="form-group">'
        . '<label class="col-sm-3 control-label"></label>'
        . '<div class="col-sm-7">';

        echo'<div class="btn-group"><button type = "submit" value = "Submit" type = "button" class = "btn btn-success">Kimutatás</button>'
        . '<button type = "button" class = "btn btn-info" onclick="StartPrtintJutalekPage()"><i class="fa fa-print" aria-hidden="true"></i> Nyomtatás</button></div>'
        . '</div></div>';

        echo '</form>';
        echo '</div>                
                        </div>
                    </div>';
        echo '<div class="col-sm-6" id="columnchart_values" style="width: auto; height: 400px;"></div>
              
               </div>';
    
}
    
function Admin_Post_Riport_Param(){
 
          if (isset($_POST["riport_startdate"]) && isset($_POST["riport_enddate"]) && isset($_POST["riport_kezelo"]) && isset($_POST["riportintervall"]) ) {
            
            
            $this->startdate = test_input($_POST["riport_startdate"]);
            $this->enddate = test_input($_POST["riport_enddate"]);
            $this->kezelo = test_input($_POST["riport_kezelo"]);            
            $this->intervall = test_input($_POST["riportintervall"]);
      
// where paraméter at összesítő tábla számára 
        $this->where = " WHERE torolt_szamla = '0' AND  kezelo_orvos_id LIKE '%$this->kezelo%'";
              
        }

}

function add_date($givendate,$day=0,$mth=0,$yr=0) {
      $cd = strtotime($givendate);
      $newdate = date('Y-m-d', mktime(date('h',$cd),
        date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
        date('d',$cd)+$day, date('Y',$cd)+$yr));
      return $newdate;
}

function Create_Riport_Table(){
     $conn = DbConnect();
    $html  = "Nincs lekérdezés...";
    if ($this->where != "null" ){
        
        $html = '<h2>'.$this->kezelo.' ősszehasonlító riport </h2><br><p>'.$this->startdate.' - '.$this->enddate.'</p>';
        $html .= '<table class="table-bordered table-condensed"><thead><tr>';
         $html .= '<th>Dátum</th>';
        for ($date = $this->startdate;strtotime($date)<=strtotime($this->enddate);$date = $this->add_date($date,$this->intervall,0,0)){
            
            $html .= '<th>'.$date.'</th>'; 
               
        }
        $html .= '</tr></thead>';
        
        $html .='<tr>';
        // kiválasztott időpont adatainak lekérdezése bevétel összeg
         $html .= '<td>Bevétel</td>';
        for ($date  = $this->startdate;strtotime($date)<=strtotime($this->enddate);$date = $this->add_date($date,$this->intervall,0,0)){
            
    $sql1 = "SELECT sum(bevetel_osszeg) as sum_napi_bevetel FROM napi_elszamolas WHERE torolt_szamla = '0' AND  kezelo_orvos_id LIKE '%$this->kezelo%' AND date = '$date'";

                $result = $conn->query($sql1);
                if ($result->num_rows > 0) {
                    while ($row1 = $result->fetch_assoc()) {
                       $html.= '<td>'.$row1["sum_napi_bevetel"].'</td>' ;
                       $bev = $row1["sum_napi_bevetel"];
                       $this->chart_data.= "['".$date."','".$bev."','#76A7FA'],";
                    }
                } else {
                     $html .= 'null';
                }
               
        }
        $html .='</tr>';   
        
        // kiválasztott időpont adatainak lekérdezése kezelt dbszám
          $html .= '<td>Páciens db</td>';
        for ($date  = $this->startdate;strtotime($date)<=strtotime($this->enddate);$date = $this->add_date($date,$this->intervall,0,0)){
            
    $sql1 = "SELECT count(*) as napi_pacdb FROM napi_elszamolas WHERE torolt_szamla = '0' AND  kezelo_orvos_id LIKE '%$this->kezelo%' AND date = '$date'";

                $result = $conn->query($sql1);
                if ($result->num_rows > 0) {
                    while ($row1 = $result->fetch_assoc()) {
                       $html.= '<td>'.$row1["napi_pacdb"].'</td>' ;
                    }
                } else {
                     $html .= 'nincs adadt';
                }
               
        }
        $html .='</tr>';   
        
        
    }    
    mysqli_close($conn);
    return $html;
}

public function drawchart_script(){
    echo  '<script type="text/javascript">';

      // Load the Visualization API and the corechart package.
    echo "google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawChart);
          
        function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('nubers', 'Napok');
            data.addRows([";
    
            echo $this->chart_data;  
            
            echo "]);

            // Set chart options
            var options = {
            title: 'Motivation and Energy Level Throughout the Day',
             
            };


            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('columnchart_values'));
            chart.draw(data, options);
          }
          
          
        </script>";

}


}
?>
