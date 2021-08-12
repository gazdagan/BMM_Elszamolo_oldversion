<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NapiIJelentesClass
 *
 * @author Andras
 */
class NapiIrasosJelentesClass {
    //put your code here
    
    public  $date; 
    private $dbconn;
    public  $telephely;
    private $recepcios;
    private $paciens_varakozasiido;
    private $paciens_panasz;
    private $paciens_elegedettseg;
    private $elojegyzes_kapacitas;
    private $elojegyzes_varakozas;
    private $elojegyzes_rendeles;
    private $orvos_terapeuta;
    private $ugyfelszolgalat;
    private $meghibasodott_eszkoz;
    private $hianyzo_eszkoz;
    private $injekcio_db;
    private $jelentes_keszito;
    private $jelentes_telephely;
    private $jelenets_date;
    
    
    
    function __construct(){
        
        $this->date = date("Y-m-d");  
        $this->dbconn = DbConnect();
        
        if (isset($_SESSION['set_telephely'])) {

            $this->telephely = $_SESSION['set_telephely'];
        } else {
            $this->telephely = "Error telephely";
        }
         
        if (isset($_SESSION['real_name'])) {

            $this->recepcios = $_SESSION['real_name'];
        } else {
            $this->recepcios = "Error recepcio";
        }
          
    }
    
    function __destruct(){
        
    $this->dbconn->close();
        
        
    }
    
public function NapiJelentesForm(){

        $this->SelectNapiJelentes();

        $html = "";
        $html .='<h1>'.$this->telephely.' napi jelentés</h1>
        <p>Dátum:'.$this->date.'</p>
        <p>Készítette:'.$this->recepcios.'</p>';

        $html .= $this->NapiJelentes_Paciensek();
        $html .= $this->NapiJelentes_Orvosok();
        $html .= $this->NapiJelentes_Ugyfelszlgalat();
        $html .= $this->NapiJelentesEszkozok();
        $html .= $this->NapiJelentesElojegyzes();

    return $html;
}    
    
private function NapiJelentes_Paciensek(){
    
    $html ='<div class="form-horizontal"> 
            <h2>1. Páciensek:</h2>
            <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Elégedettség:</label>
                  <div class="col-sm-10">          
                    <input type="text" class="form-control" id="paciens_elegedettseg" placeholder="" name="paciens_elegedettseg" value="'.$this->paciens_elegedettseg.'">
                  </div>
            </div>
            <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Panasz:</label>
                  <div class="col-sm-10">          
                    <input type="text" class="form-control" id="paciens_panasz" placeholder="" name="paciens_panasz" value="'.$this->paciens_panasz.'">
                  </div>
            </div>
            <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Várakozási idő:</label>
                  <div class="col-sm-10">          
                    <input type="text" class="form-control" id="paciens_varakozasiido" placeholder="" name="paciens_varakozasiido" value="'.$this->paciens_varakozasiido.'">
                  </div>
            </div>
            <div class="form-group">        
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="" class="btn btn-default"  onclick="paciensek_post()">Rendben</button>
                  </div>
            </div>
            </div>';
    return $html;
    
} 

private function NapiJelentes_Orvosok(){
    $html ="";
    $html .= '<div class="form-horizontal" >
                <h2>2. Orvosok/terapeuták:</h2>

                <table class="table table-condensed" id="napijelentes_orvosok">
                    <thead>
                      <tr >
                         <th> 
                           orvos/terapeuta
                         </th>
                         <th> 
                            elégedettség
                         </th>
                        <th> 
                            hiányosság
                         </th>
                         <th> 
                            rendelési idő betartása/eltérése
                         </th>
                         <th> 
                            elszámolás
                         </th>
                         <th> 
                            kapacitás kihasználtság
                         </th>
                      </tr>
                    <thead>  
                    <tbody>';
                $value = "";        
                $datas = array();
                $datas = explode(',', $this->orvos_terapeuta);    
                $counter =0;
                    for ($i=0;$i<=9;$i++){
                        $html .='<tr>';
                        for ($j=0;$j<=5;$j++){

                                if (isset($datas[$counter])){$value = $datas[$counter]; } else {$value="";}
                                $html .= '<td><input type="text" class="form-control" styel="width:100%;" value= "'.$value.'"></td>';
                                $counter++;
                        }                
                        $html .='</tr>';
                    }    

            $html .= '</tbody>
            </table>
            <div class="form-group">        
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default" onclick="orvosokterapeutak_post('."'napijelentes_orvosok'".')">Rendben</button>
                  </div>
            </div>
            </div>';
    return $html;
        
}
 private function NapiJelentes_Ugyfelszlgalat(){
    $html ="";
    $html .= '<div class="form-horizontal" >
                <h2>3. Ügyfélszolgálat:</h2>
                <table class="table table-condensed" id="napijelentes_ugyfelszolgalat">
                    <thead>
                      <tr >
                         <th> 
                           recepciós/CC
                         </th>
                         <th> 
                            munkaidő
                         </th>
                        <th> 
                            munkaruha
                         </th>
                         <th> 
                            elszámolás
                         </th>
                         <th> 
                            előjegyzés
                         </th>
                         <th> 
                            betegtájékoztatás
                         </th>
                         <th> 
                            problémamegoldás
                         </th>

                      </tr>
                    </thead>  
                    <tbody>';
                $value = "";   
                $datas = array();
                $datas = explode(',', $this->ugyfelszolgalat);    
                $counter =0;
                for ($i=0;$i<=5;$i++){
                    $html .='<tr>';
                    for ($j=0;$j<=6;$j++){
                             if (isset($datas[$counter])){$value = $datas[$counter]; } else {$value="";}
                            $html .= '<td><input type="text" class="form-control" styel="width:100%;" value= "'.$value.'"></td>';
                            $counter++;
                    }                
                    $html .='</tr>';
                }    

            $html .= '</tbody>
            </table>
            <div class="form-group">        
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" onclick="ugyfelszolgalat_post('."'napijelentes_ugyfelszolgalat'".')">Rendben</button>
                  </div>
            </div>
            </div>';
            
 return $html;
}

private function NapiJelentesEszkozok(){
    $html ="";
    $html .='<div class="form-horizontal" >
            <h2>4.  Eszközök:</h2>

            <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Meghibásodott eszköz:</label>
                  <div class="col-sm-10">          
                    <input type="text" class="form-control" id="meghibasodott_eszkoz" placeholder="" name="meghibasodott_eszkoz" value = "'.$this->meghibasodott_eszkoz.'">
                  </div>
            </div>
            <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Hiányzó eszköz, ill. eszköz fogyás:</label>
                  <div class="col-sm-10">          
                    <input type="text" class="form-control" id="hianyzo_eszkoz" placeholder="" name="hianyzo_eszkoz" value = "'.$this->hianyzo_eszkoz.'">
                  </div>
            </div>
            <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Meglévő injekciók darabszáma:</label>
                  <div class="col-sm-10">          

                  <table class="table table-condensed" id="napijelentes_injekciok">
                <thead>
                  <tr>
                     <th> 
                       Lidocain
                     </th>
                     <th> 
                        Naropin
                     </th>
                     <th> 
                        Diprophos
                     </th >
                     <th> 
                        Kenalog
                     </th>
                     <th> 
                        Euflexa
                     </th>
                     <th> 
                        Ostenil
                     </th>
                     <th> 
                       Xiapex
                     </th>

                  </tr>
                </thead>  
                <tbody>';
                $value ="";
                $datas = array();
                $datas = explode(',', $this->injekcio_db);    
                $counter =0;    
                for ($i=0;$i<=0;$i++){
                    $html .='<tr>';
                    for ($j=0;$j<=6;$j++){
                             if (isset($datas[$counter])){$value = $datas[$counter]; } else {$value="";}
                            $html .= '<td><input type="text" class="form-control" style="" value= "'.$value.'" ></td>';
                            $counter++;
                    }                
                    $html .='</tr>';
                }    

            $html .= '</tbody>
            </table></div>
            </div><div class="form-group">        
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" onclick="eszkozok_post('."'napijelentes_injekciok'".')">Rendben</button>
                  </div>
            </div></div>';
           

    return $html;        
            
   }

private function NapiJelentesElojegyzes(){
    $html ="";
    
    $html .= '<div class="form-horizontal">';
        $html .=' <h2>5. Előjegyzés:</h2>
        <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Szabad kapacitás: </label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="elojegyzes_kapacitas" placeholder="" name="elojegyzes_kapacitas" value = "'.$this->elojegyzes_kapacitas.'">
              </div>
        </div>
        <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Hosszú várakozási idő:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="elojegyzes_varakozas" placeholder="" name="elojegyzes_varakozas" value = "'.$this->elojegyzes_varakozas.'">
              </div>
        </div>
        <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Jövőbeni rendelési idő módosítás / szabadság:</label>
              <div class="col-sm-10">          
                <input type="text" class="form-control" id="elojegyzes_rendeles" placeholder="" name="elojegyzes_rendeles"value = "'.$this->elojegyzes_rendeles.'">
              </div>
        </div>
        <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="buttom" class="btn btn-default" onclick="elojegyzes_post()">Rendben</button>
              </div>
        </div>
        </div>';
    return $html;    
} 

public function SelectNapiJelentes(){
    
    $sql = "SELECT * FROM napi_jelentes WHERE jelentes_telephely = '$this->telephely' AND jelentes_date = '$this->date'";
    $result = $this->dbconn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $this->paciens_elegedettseg = $row["paciens_elegedettseg"];
            $this->paciens_panasz = $row["paciens_panasz"];
            $this->paciens_varakozasiido = $row["paciens_varakozasiido"];
            $this->elojegyzes_kapacitas = $row["elojegyzes_kapacitas"];
            $this->elojegyzes_rendeles = $row["elojegyzes_rendeles"];
            $this->elojegyzes_varakozas = $row["elojegyzes_varakozas"];
            $this->orvos_terapeuta = $row["orvos_terapeuta"];
            $this->ugyfelszolgalat =  $row["ugyfelszolgalat"];
            $this->meghibasodott_eszkoz =  $row["meghibasodott_eszkoz"];
            $this->hianyzo_eszkoz =  $row["hiányzo_eszkoz"];
            $this->injekcio_db =  $row["injekcio_db"];
            $this->jelenets_date = $row["jelentes_date"];
            $this->jelentes_telephely = $row["jelentes_telephely"];
            $this->jelentes_keszito = $row["jelentes_keszito"];
        }
    } else {
        echo "Nincs a ".$this->date." napra a ".$this->telephely." rendelőhöz riport készítve.";
            // ha nincs riport a változókat üríteni kell
            $this->paciens_elegedettseg = "";
            $this->paciens_panasz = "";
            $this->paciens_varakozasiido = "";
            $this->elojegyzes_kapacitas = "";
            $this->elojegyzes_rendeles = "";
            $this->elojegyzes_varakozas = "";
            $this->orvos_terapeuta = "";
            $this->ugyfelszolgalat =  "";
            $this->meghibasodott_eszkoz =  "";
            $this->hianyzo_eszkoz =  "";
            $this->injekcio_db =  "";
            $this->jelenets_date = "";
            $this->jelentes_telephely = "";
            $this->jelentes_keszito = "";
           
    }
    
}

public function NapiJelentesSearchForm(){
    $html="";
    $html_null  = "";
    $html .= '<div class="panel panel-danger">';
            $html .='<div class="panel-heading">Napi irásos jelentések visszakeresése .</div>';
            $html .= '<div class="panel-body">';
                $html .= '<form  class="form-inline" action="' . $_SERVER['PHP_SELF'] . '?pid=page201" method="post" >'; 
                
                //lekérdezési időszak eleje
                $html .= '<div class="form-group" style="padding-right: 1em;">
                            <label class="control-label" >Jelentés napja :</label>
                            <div class=""><input type="date" class="form-control" name="jelentes_date" value = "'.$this->date.'"></div>
                         </div>';
               
                //telephely
                $html .= '<div class="form-group" style="padding-right: 1em;">
                        <label class="control-label" >Rendelő :</label>
                        <div class="">';
                        
                        $html .='<div class="input-group">'
                            . '<span class="input-group-addon"><i class="fa fa-building"></i></span>';
                            $html .='<select class = "form-control" name = "jelentes_telephely">';
                            $html_null .= '<option value=""> Válassz rendelőt </option>';
                            $sql = "SELECT * FROM telephelyek";
                            $result = $this->dbconn->query($sql);

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
                  
             
                //gombok
                $html .= '<div class="form-group" style="padding-top:20px;padding-right: 1em;">';
                    $html .= '<label class="control-label"></label>';    
                    $html .='<div class="btn-group">';
                        
                        $html .='<button type="submit" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> Lekérdez</button>';
                        $html .='<a href="#" onclick="StartPrtintPage()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>';
                        $html_null .='<a href="#" onclick="CopyClipboard()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-clipboard" aria-hidden="true"></i> Vágólapra</a>';                        
                        
                       $html .= '</div>'
                . '</div>';        
                $html .= '</form>';
            
            $html .='</div>';
            $html .='<div class="panel-footer">BMM
                </div></div>';
      
    
    return $html;
}
public function NapiJelentesQuery(){
    $html = ""; 
    if (isset($_POST["jelentes_date"]) AND isset($_POST["jelentes_telephely"])){
    
    $this->date = $_POST["jelentes_date"];
    $this->telephely = $_POST["jelentes_telephely"];
    $this->SelectNapiJelentes();
    echo '<div class="container">';
    $html .= $this->NapiJelentesRiport();
    echo '</div>';
     
    }
    return $html;
}



public function NapiJelentesRiport(){
        //$this->SelectNapiJelentes();
        $html = "";
        $html .='<h2>'.$this->jelentes_telephely.' napi jelentés</h2>
        <p>Dátum:'.$this->jelenets_date.'</p>
        <p>Készítette:'.$this->jelentes_keszito.'</p>';

        $html .= $this->NapiJelentes_PaciensekRiport();
        $html .= $this->NapiJelentes_OrvosokRiport();
        $html .= $this->NapiJelentes_UgyfelszlgalatRiport();
        $html .= $this->NapiJelentesEszkozokRiport();
        $html .= $this->NapiJelentesElojegyzesRiport();
    return $html;
    
    
}

private function NapiJelentes_PaciensekRiport(){
    
    $html ='<div class="form-horizontal"> 
            <h2>1. Páciensek:</h2>
            <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Elégedettség:</label>
                  <div class="col-sm-10">          
                    '.$this->paciens_elegedettseg.'
                  </div>
            </div>
            <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Panasz:</label>
                  <div class="col-sm-10">          
                    '.$this->paciens_panasz.'
                  </div>
            </div>
            <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Várakozási idő:</label>
                  <div class="col-sm-10">          
                    '.$this->paciens_varakozasiido.'
                  </div>
            </div>
            
            </div>';
    return $html;
   
}
private function NapiJelentes_OrvosokRiport(){
    $html ="";
    $html .= '<div class="form-horizontal" >
                <h2>2. Orvosok/terapeuták:</h2>

                <table class="table" id="napijelentes_orvosok">
                    <thead>
                      <tr>
                         <th> 
                           orvos/terapeuta
                         </th>
                         <th> 
                            elégedettség
                         </th>
                        <th> 
                            hiányosság
                         </th>
                         <th> 
                            rendelési idő betartása/eltérése
                         </th>
                         <th> 
                            elszámolás
                         </th>
                         <th> 
                            kapacitás kihasználtság
                         </th>
                      </tr>
                    </thead>  
                    <tbody>';
                $value = "";        
                $datas = array();
                $datas = explode(',', $this->orvos_terapeuta);    
                $counter =0;
                    for ($i=0;$i<=9;$i++){
                        $html .='<tr>';
                        for ($j=0;$j<=5;$j++){

                                if (isset($datas[$counter])){$value = $datas[$counter]; } else {$value="&ensp;";}
                                $html .= '<td>'.$value.'</td>';
                                $counter++;
                        }                
                        $html .='</tr>';
                    }    

            $html .= '</tbody>
            </table>
            
            </div>';
    return $html;
}

private function NapiJelentes_UgyfelszlgalatRiport(){
    $html ="";
    $html .= '<div class="form-horizontal" >
                <h2>3. Ügyfélszolgálat:</h2>
                <table class="table" id="napijelentes_ugyfelszolgalat">
                    <thead>
                      <tr>
                         <th> 
                           recepciós/CC
                         </th>
                         <th> 
                            munkaidő
                         </th>
                        <th> 
                            munkaruha
                         </th>
                         <th> 
                            elszámolás
                         </th>
                         <th> 
                            előjegyzés
                         </th>
                         <th> 
                            betegtájékoztatás
                         </th>
                         <th> 
                            problémamegoldás
                         </th>

                      </tr>
                    </thead>  
                    <tbody>';
                $value = "";   
                $datas = array();
                $datas = explode(',', $this->ugyfelszolgalat);    
                $counter =0;
                for ($i=0;$i<=5;$i++){
                    $html .='<tr>';
                    for ($j=0;$j<=6;$j++){
                             if (isset($datas[$counter])){$value = $datas[$counter]; } else {$value="&ensp;";}
                            $html .= '<td>'.$value.'</td>';
                            $counter++;
                    }                
                    $html .='</tr>';
                }    

            $html .= '</tbody>
            </table>
           
            </div>';
            
 return $html;
}
private function NapiJelentesEszkozokRiport(){
    $html ="";
    $html .='<div class="form-horizontal" >
            <h2>4.  Eszközök:</h2>

            <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Meghibásodott eszköz:</label>
                  <div class="col-sm-10">          
                    '.$this->meghibasodott_eszkoz.'
                  </div>
            </div>
            <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Hiányzó eszköz, ill. eszköz fogyás:</label>
                  <div class="col-sm-10">          
                    '.$this->hianyzo_eszkoz.'
                  </div>
            </div>
            <div class="form-group">
                  <label class="control-label col-sm-2" for="pwd">Meglévő injekciók darabszáma:</label>
                  <div class="col-sm-10">          

                  <table class="table" id="napijelentes_injekciok">
                <thead>
                  <tr>
                     <th> 
                       Lidocain
                     </th>
                     <th> 
                        Naropin
                     </th>
                     <th> 
                        Diprophos
                     </th >
                     <th> 
                        Kenalog
                     </th>
                     <th> 
                        Euflexa
                     </th>
                     <th> 
                        Ostenil
                     </th>
                     <th> 
                       Xiapex
                     </th>

                  </tr>
                <thead>  
                <tbody>';
                $value ="";
                $datas = array();
                $datas = explode(',', $this->injekcio_db);    
                $counter =0;    
                for ($i=0;$i<=0;$i++){
                    $html .='<tr>';
                    for ($j=0;$j<=6;$j++){
                             if (isset($datas[$counter])){$value = $datas[$counter]; } else {$value="&ensp;";}
                            $html .= '<td>'.$value.'</td>';
                            $counter++;
                    }                
                    $html .='</tr>';
                }    

            $html .= '</tbody>
            </table></div>
           </div>';
           

    return $html;        
            
   }

private function NapiJelentesElojegyzesRiport(){
    $html ="";
    
    $html .= '<div class="form-horizontal">';
        $html .=' <h2>5. Előjegyzés:</h2>
        <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Szabad kapacitás: </label>
              <div class="col-sm-10">          
                '.$this->elojegyzes_kapacitas.'
              </div>
        </div>
        <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Hosszú várakozási idő:</label>
              <div class="col-sm-10">          
                '.$this->elojegyzes_varakozas.'
              </div>
        </div>
        <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Jövőbeni rendelési idő módosítás / szabadság:</label>
              <div class="col-sm-10">          
                '.$this->elojegyzes_rendeles.'
              </div>
        </div>
        
        </div>';
    return $html;    
} 

}