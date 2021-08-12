<?php

/**
 * Description of Psotazott_szamlakClass
 *
 * @author Andras
 */
class Postazott_szamlakClass {
    
    //put your code here
    private $conn;
    private $date;
    
    function __construct(){
         $this->conn = DbConnect();
         $this->date = date('Y-m-d');
    }
    
    function __destruct() {
        mysqli_close($this->conn);
    }
    
public function PostazandoSzamlakTable(){
   $html ="";
   
   
   return; 
}    

public function AdminSelectForm(){
    
    $html = "";
         
              
        $html .= '<div class="panel panel-danger">';
            $html .='<div class="panel-heading">Advanc Medical és Egészségpénztári számlák lekérdezése.</div>';
            $html .= '<div class="panel-body">';
                $html .= '<form  class="form-inline" action="' . $_SERVER['PHP_SELF'] . '?pid=page79" method="post" >'; 
                
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
                   
                //telephely
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Telephely :</label>
                        <div class="">';
                        
                        $html .='<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-building"></i></span>';
                            $html .='<select class = "form-control" name = "szamla_telephely">';
                            $html .= '<option value=""> Összes telephely </option>';
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
                        
                  //fizetési mód
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Fizetés módja:</label>
                        <div class="">';
                        
                        $html .='<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-money"></i></span>';
                            $html .='<select class = "form-control" name = "szamla_fizmod">';
                                $html .= '<option value=""> Összes Postázandó számla </option>';
                                $html .= '<option value="egészségpénztár-kártya"> EP kártyával </option>';
                                $html .= '<option value="europe assistance"> Europe Assistance </option>';
                                $html .= '<option value="advance medical"> Advance Medical </option>';
                                            
                            $html .= '</select></div>';
                
                        $html .='</div>
                     </div>';       
                 //számlaszám szűrés
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Számlaszám:</label>
                        <div class=""><input type="text" class="form-control"  name="szamlaszam" value = "" placeholder = "A9999/12345"></div>
                     </div>';
             
                //gombok
                $html .= '<div class="form-group" style="padding-top:20px;padding-right: 1em;">';
                    $html .= '<label class="control-label"></label>';    
                    $html .='<div class="btn-group">';
                        
                        $html .='<button type="submit" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> Lekérdez</button>';
                        $html .='<a href="#" onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
                        $html .='<a href="#" onclick="CopyClipboard()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a>'                        
                        
                        . '</div>'
                . '</div>';        
                $html .= '</form>';
            
            $html .='</div>';
            $html .='<div class="panel-footer">BMM
                </div></div>';
                
            return $html;

}
    
    public function AdminPostQuery(){
        
        if (isset($_POST["szamla_telephely"]) AND isset($_POST["szamla_fizmod"]) AND isset($_POST["startdate"]) AND isset($_POST["enddate"]) AND isset($_POST["szamlaszam"])){
            // van post lekérdezés paraméterei
            //echo 'post OK';
            
            $telephely = $_POST["szamla_telephely"];
            $fizmod = $_POST["szamla_fizmod"];
            $startdate = $_POST["startdate"];
            $enddate = $_POST["enddate"];
            $szamlaszam = $_POST["szamlaszam"]; 
            
            if ($startdate == ""){$startdate = '1970-01-01';}
            if ($enddate == ""){$enddate = '2100-01-01';}
            
            
            if ($fizmod == ""){
                
                $sql = "SELECT * FROM napi_elszamolas WHERE (date BETWEEN '$startdate' AND '$enddate') AND szamlaszam LIKE '%$szamlaszam%' AND telephely LIKE '%$telephely%' AND (bevetel_tipusa_id = 'egészségpénztár-kártya' OR bevetel_tipusa_id = 'europe assistance' OR bevetel_tipusa_id = 'advance medical') AND torolt_szamla = '0' ";
            }
            else{
                $sql = "SELECT * FROM napi_elszamolas WHERE (date BETWEEN '$startdate' AND '$enddate')  AND szamlaszam LIKE '%$szamlaszam%' AND telephely LIKE '%$telephely%' AND bevetel_tipusa_id LIKE '%$fizmod%' AND torolt_szamla = '0'";
            }
            
            $result = $this->conn->query($sql);
            $this->Create_Postazando_Table($result);
       }
    }
    
    
    public function Create_Postazando_Table($result) {
    
    $html = "";    
           
        $html .= '<table class="table table-bordered">
                <thead>
                    <tr>
                        
                        <th>ID</th>
                        <th>Dátum</th>
                        <th>Páciens Neve</th>
                        <th>Fizetés módja</th>
                        <th>EP lista</th>
                        <th>Fizetés Összege</th>
                        <th>Számlaszám</th>
                        <th>Telephely</th>
                        <th>Postázás dátuma</th>
                        <th class="HiddenIfPrint">Postázás beállítása</th>
                        <th>Banki utalás dátuma</th>
                        <th class="HiddenIfPrint">Banki utalás beállítása</th>
                     </tr>
                </thead>
                <tbody>';        
    
    
    if ($result->num_rows > 0) {
                
        while($row = $result->fetch_assoc()) {
            $class = "warning";
            if ($row["szamla_postazas"] != "")
                {$class ="success";} 
            
            $id = $row["id_szamla"];            
            $html .= '<tr class ="'.$class.'" id = "'.$row["id_szamla"].'"><td>' . $row["id_szamla"]. '</td>';
            $html .= "<td>" . $row["date"]. "</td>";
            $html .= "<td>" . $row["paciens_neve"]. "</td>";
            $html .= "<td>" . $row["bevetel_tipusa_id"]. "</td>";
            $html .= "<td>" . $row["ep_tipus"]. "</td>";
            $html .= "<td>" . $row["bevetel_osszeg"]. "</td>";
            $html .= "<td>" . $row["szamlaszam"]. "</td>";
            $html .= "<td>" . $row["telephely"]. "</td>";
            $html .= '<td id = "date'.$row["id_szamla"].'">' . $row["szamla_postazas"]. '</td>';
            $html .= '<td class="HiddenIfPrint"> '
                    . '<input type ="date" value="'.$this->date.'" id = "postazas_date'.$id.'">'
                    . '<button onclick = "Postazas(this.id)" id = "'.$row["id_szamla"].'" style="font-size:1em"><i class="fa fa-envelope"></i></button>'
                    . '<button onclick = "Postazas_torles(this.id)" id = "'.$row["id_szamla"].'" style="font-size:1em"><i class="fa fa-eraser"></i></button></td>';
            $html .= '<td id = "bank'.$row["id_szamla"].'">' . $row["banki_utalas"]. '</td>';
            $html .= '<td class="HiddenIfPrint"> '
                    . '<input type ="date" value="'.$this->date.'" id = "bank_date'.$id.'">'
                    . '<button onclick = "Bank_date(this.id)" id = "'.$row["id_szamla"].'" style="font-size:1em"><i class="fa fa-money"></i></button>'
                    . '<button onclick = "Bank_torles(this.id)" id = "'.$row["id_szamla"].'" style="font-size:1em"><i class="fa fa-eraser"></i></button></td></tr>';       
        }
        
    } else {
        $html .= "Nincs eredménye a lekérdezésnek";
    }
        $html .= '</tbody></table>';   
        
        echo $html;
        
    }
    
    
    public function AdminSelectVenyForm(){
    
    $html = "";
         
              
        $html .= '<div class="panel panel-danger">';
            $html .='<div class="panel-heading">Vények lekérdetése.</div>';
            $html .= '<div class="panel-body">';
                $html .= '<form  class="form-inline" action="' . $_SERVER['PHP_SELF'] . '?pid=page799" method="post" >'; 
                
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
                   
                //telephely
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Telephely :</label>
                        <div class="">';
                        
                        $html .='<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-building"></i></span>';
                            $html .='<select class = "form-control" name = "szamla_telephely">';
                            $html .= '<option value=""> Összes telephely </option>';
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
                        
                
                //számlaszám szűrés
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Vényazonsító:</label>
                        <div class=""><input type="text" class="form-control"  name="recept_id" value = "" placeholder = "Vényazonosító"></div>
                     </div>';
             
                //gombok
                $html .= '<div class="form-group" style="padding-top:20px;padding-right: 1em;">';
                    $html .= '<label class="control-label"></label>';    
                    $html .='<div class="btn-group">';
                        
                        $html .='<button type="submit" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> Lekérdez</button>';
                        //$html .='<a href="#" onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
                        $html .='<a href="#" id="dwn-btn" onclick="download_table_as_csv('."'riport'".')" tpye="button" class="btn btn-info" role="button"><i class="fa fa-download" aria-hidden="true"></i> Letöltés</a>'                        
                        
                        . '</div>'
                . '</div>'
                . '<input type="text" value="venylekerdezes" name="veny" hidden>';   
                        
                $html .= '</form>';
            
            $html .='</div>';
            $html .='<div class="panel-footer">BMM
                </div></div>';
                
            return $html;

}
    
public function AdminPostVenyQuery(){
        
        if (isset($_POST["szamla_telephely"]) AND isset($_POST["veny"]) AND isset($_POST["startdate"]) AND isset($_POST["enddate"]) AND isset($_POST["recept_id"])){
            // van post lekérdezés paraméterei
            //echo 'post OK';
            
            $telephely = $_POST["szamla_telephely"];
            $startdate = $_POST["startdate"];
            $enddate = $_POST["enddate"];
            $recept_id = $_POST["recept_id"]; 
            
            if ($startdate == ""){$startdate = '1970-01-01';}
            if ($enddate == ""){$enddate = '2100-01-01';}
            
            $sql = "SELECT * FROM napi_elszamolas WHERE (date BETWEEN '$startdate' AND '$enddate') AND recept_id LIKE '%$recept_id%' AND telephely LIKE '%$telephely%' AND torolt_szamla = '0' AND (Sell_type = 'keszlet_venyes' OR recept_id  <> '')  ORDER BY date DESC";
                    
            $result = $this->conn->query($sql);
            $this->Create_Venyek_Table($result);
       }
    }

private function Create_Venyek_Table($result){
    
     $html = "";    
           
        $html .= '<table class="table table-bordered" id="riport">
                <thead>
                    <tr>
                        <th>Páciens Neve</th>
                        <th>Telephely</th>
                        <th>Dátum</th>
                        <th>Számlaszám</th>
                        <th>Cikk neve</th>
                        <th>Vény azonosító</th>
                        <th style="width:200px;">Ártámogatás FT</th>
                        <th>NEAK lejelentés</th>
                        <th>Ártámogatás beérkezett dátum</th>
                        
                     </tr>
                </thead>
                <tbody>';        
    
    
    if ($result->num_rows > 0) {
                
        while($row = $result->fetch_assoc()) {
          
          
            $html .= "<tr><td>" . $row["paciens_neve"]. "</td>";
            $html .= "<td>" . $row["telephely"]. "</td>";
            $html .= "<td>" . $row["date"]. "</td>";
            $html .= "<td>" . $row["szamlaszam"]. "</td>";
            $html .= "<td>" . $row["szolgaltatas_id"]. "</td>";
            
            
            
            $html .= '<td>  <div class="input-group">
                            <div class="input-group-btn">
                                <buttom class="btn btn-default" onclick = ReadonlyChange("receptid_'.$row["id_szamla"].'")><i class="fa fa-pencil-square-o"></i></buttom>
                                    
                                    </div>
                                        <input type="text" class="form-control" id="receptid_'.$row["id_szamla"].'" value="'.$row["recept_id"].'" onchange="update_venyid('.$row["id_szamla"].')" disabled>
                                    </div> 
                     </td>';
            $html .= "<td>" .$row["recept_artam"]. "</td>";
            
//            $html .= '<td style="width:200px;"> 
//                        <div class="input-group">
//                                <div class="input-group-btn">
//                                    <buttom class="btn btn-default" onclick = ReadonlyChange("venytamogatas_'.$row["id_szamla"].'")><i class="fa fa-pencil-square-o"></i></buttom>
//                                    
//                                    </div>
//                                        <input type="number" class="form-control" id="venytamogatas_'.$row["id_szamla"].'" value="'.$row["recept_artam"].'" onchange="update_venyartamogatas('.$row["id_szamla"].')" disabled>
//                                    </div> 
//                                      
//                      </td>'; 
                    
            $html .= '<td> 
                        <div class="input-group">
                                <div class="input-group-btn">
                                    <buttom class="btn btn-default" onclick = ReadonlyChange("benyujta_date_'.$row["id_szamla"].'")><i class="fa fa-pencil-square-o"></i></buttom>
                                    <buttom class="btn btn-warning" onclick = "erease_benyujta_date('.$row["id_szamla"].')"><i class="fa fa-trash" aria-hidden="true" ></i></buttom>  
                                          </div>
                                              <input type="date" class="form-control" id="benyujta_date_'.$row["id_szamla"].'" value="'.$row["recept_feladas"].'" onchange="update_benyujta_date('.$row["id_szamla"].')" disabled>
                                          </div> 
                                      
                      </td>';
            $html .= '<td>  <div class="input-group">
                                <div class="input-group-btn">
                                    <buttom class="btn btn-default" onclick = ReadonlyChange("berkezes_date_'.$row["id_szamla"].'")><i class="fa fa-pencil-square-o"></i></buttom>
                                     <buttom class="btn btn-warning" onclick = "erease_beerkezes_date('.$row["id_szamla"].')")><i class="fa fa-trash" aria-hidden="true" disbled></i></buttom>  
                                          </div>
                                              <input type="date" class="form-control" id="berkezes_date_'.$row["id_szamla"].'" value="'.$row["recept_tam_be"].'" onchange="update_beerkezes_date('.$row["id_szamla"].')" disabled>
                                          </div> 
                      </td></tr>';
            
            
            
            
  
        }
        
    } else {
        $html .= "Nincs eredménye a lekérdezésnek";
    }
        $html .= '</tbody></table>';   
        
        echo $html;
        
    
    
    
}


}
