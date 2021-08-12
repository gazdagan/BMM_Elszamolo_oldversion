<?php

/*
készletnyilvántartás
 */

class keszletnyilvantartasClass {
    //put your code here
    private $dbcon;
    private $keszlet_sor = array();
    private $total_keszlet_ertek ;
    private $sumdb_cikk;
    private $total_keszelet_db;
    private $cikk_sor_ertek;

    public function __construct() {
           $this->dbconn = DbConnect();
           $this->total_keszelet_db = 0;
           $this->total_keszlet_ertek = 0;
    }

   public function Tabmenu(){

        $html="";
      
        $html = '<ul class="nav nav-tabs" style="position: fixed; background-color: LightGrey; z-index: 100;"> 
            <li class="active"><a data-toggle="tab" href="#keszlet" onclick="select_all_table()">Aktuális készletek</a></li>
            <li><a data-toggle="tab" href="#keszletvaltozas" onclick="select_all_table()">Készlet változas</a></li>
            <li><a data-toggle="tab" href="#beszerzes" onclick="select_all_table()">Beszerzes / Ár db</a></li>
            <li><a data-toggle="tab" href="#cikktorzs" onclick="select_all_table()">Cikktörzs</a></li>
            <li><a data-toggle="tab" href="#kategoria" onclick="select_all_table()">Kategória lista</a></li>
            <li><a data-toggle="tab" href="#beszallitok" onclick="select_all_table()">Beszállítók</a></li>
            
            <li><a data-toggle="tab" href="#leltarlista" onclick=""> Leltár lista - Cikktörzs </a></li>
            <li><a data-toggle="tab" href="#szallitolevel" onclick=""> Szállítólevél rendelők között</a></li>
            <li><a data-toggle="tab" href="#selejtezes" onclick=""> Selejtezes - készlet csökkentés</a></li>
          </ul>


        <div class="tab-content" style=" padding-top: 50px">
            <div id="keszlet" class="tab-pane fade in active">
                <div class="form-inline"  style="position: fixed; z-index: 10;">
                <button class="btn btn-default" type="" onclick="insert_keszlet()"> Új készlet sor <i class="fa fa-plus" aria-hidden="true"></i></button>
                '.$this->select_cikkname_keszletre().'</div>
                <div id="keszlet_lista" style="padding-top: 40px;" >
                       <script>select_keszlet("keszlet");</script>
                </div>
            </div>

            <div id="keszletvaltozas" class="tab-pane fade">
              <div class="form-inline">
              <input class="form-control" type="date" id="date_keszlet_allapot">
              <button class="form-control" type="buttom" onclick="Select_keszlet_date()"> készlet lekérdezés <i class="fa fa-calendar" aria-hidden="true"></i></buttom></div>
              <div id="keszlet_allapot">
              </div>
            </div>

            <div id="kategoria" class="tab-pane fade">
                <button class="btn btn-default" type="" onclick="insert_kategoria()"> Új kategória létrehozás <i class="fa fa-plus" aria-hidden="true"></i></button>
                <div id="kategoria_lista">
                     <script>select_keszlet("kategoria");</script>
                </div>
            </div>

            <div id="beszallitok" class="tab-pane fade">
                <div class="form-inline">
                    <button class="btn btn-default" type="" onclick="insert_beszallito()"> Új beszállító létrehozás <i class="fa fa-plus" aria-hidden="true"></i></button>
                </div>       
                    <div id="beszallito_lista">
                        <script>select_keszlet("beszallito");</script>
                    </div>
                
            </div>

            <div id="cikktorzs" class="tab-pane fade">
                <div class="form-inline">
                    <button class="btn btn-default" type="" onclick="insert_cikktorzs()"> Új cikk létrehozás <i class="fa fa-plus" aria-hidden="true"></i></button>
                        <div class="input-group">
                        <input type="text" class="form-control" placeholder="Áru neve" id="cikktorzs_search">
                        <div class="input-group-btn">
                          <button class="btn btn-default" type="submit" onclick=select_keszlet_search("cikktorzs","cikktorzs_search")>
                            <i class="glyphicon glyphicon-search"></i>
                          </button>
                        </div>
                   </div>
                </div>

                <div id="cikktorzs_lista">
                    <script>select_keszlet("cikktorzs");</script>
                </div>
            </div>

            <div id="beszerzes" class="tab-pane fade">
                <div class="form-inline">
                    <button class="btn btn-default" type="" onclick="insert_beszerzes()"> Új beszerzes sor <i class="fa fa-plus" aria-hidden="true"></i></button>
                    '.$this->select_cikkname_beszerzes().'
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Áru neve" id="beszerzes_search">
                        <div class="input-group-btn">
                          <button class="btn btn-default" type="submit" onclick=select_keszlet_search("beszerzes","beszerzes_search")>
                            <i class="glyphicon glyphicon-search"></i>
                          </button>
                        </div>
                    </div>    
                </div>
                <div id="beszerzes_lista">
                    <script>select_keszlet("beszerzes");</script>
                </div>
            </div>
            
             <div id="leltarlista" class="tab-pane fade">
                
                
                <div id="leltar_lista">'.$this->leltar_tablazat().'</div>
                
            </div>

            <div id="szallitolevel" class="tab-pane fade">
                
                <div id="szallítolevel_rendelok_kozott" class="container">'.$this->szallitolevel_rendelok_kozott().'</div>
                
            </div>
        </div>';





        return $html;
    }

    // nem használt popúp
    public function kategoria_add_popup(){

        $html = "";

        $html = '<!-- Modal -->
                    <div id="kategoria_add_popup" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Új készlet kategótia léterhozása.</h4>
                        </div>
                        <div class="modal-body">

                            <div class="input-group">
                              <span class="input-group-addon">Készelet kategória neve:</span>
                              <input id="keszlet_kategoria" type="text" class="form-control" name="msg" placeholder="Könyökvédő">
                              <div class="input-group-btn">
                                <button class="btn btn-default" type="" onclick="insert_kategoria()">
                                  <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                              </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>

                    </div>
                  </div>
                ';
        return $html;
    }

    public function kategoria_lista (){

        $html ='';
        $html = '<table class="table table-striped">
            <thead>
              <tr>
                <th>No:</th>
                <th>Kategória megnevezése</th>
                <th></th>
              </tr>
            </thead>
            <tbody>';
           $sql = "SELECT * FROM aru_kategoria WHERE kategoria_torolt = '0'";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                       $html .=  '<tr id="row_id_'.$row["kategoria_id"].'">
                                    <td>'.$row["kategoria_id"].'</td>
                                    <td><input type="text" class="form-control" id="kategoria_id_'.$row["kategoria_id"].'" value="'.$row["kategoria_neve"].'"  onkeyup="update_kategoria('.$row["kategoria_id"].')"></td>
                                    <td>
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-warning" onclick="update_kategoria('.$row["kategoria_id"].')"><i class="fa fa-pencil" aria-hidden="true"></i> </button>
                                        <button type="button" class="btn btn-danger" onclick="delete_kategoria('.$row["kategoria_id"].')"><i class="fa fa-trash" aria-hidden="true"></i> </button>
                                        </div>
                                    </td>
                                </tr>';

                    }
                } else {
                    echo "0 results";
                }

        //$html = '</tbody></table>';

        return $html;

    }

    public function beszallito_lista (){

        $html ='';
        $html = '<table class="table table-striped">
            <thead>
              <tr>
                <th>No:</th>
                <th>Beszállító megnevezése</th>
                <th>Beszállító email - stb.</th>
                <th></th>
              </tr>
            </thead>
            <tbody>';
           $sql = "SELECT * FROM aru_beszallito WHERE besz_torolt = '0'";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                       $html .=  '<tr id="besz_id_'.$row["besz_id"].'">
                                    <td>'.$row["besz_id"].'</td>
                                    <td><input type="text" class="form-control" id="beszallito_id_'.$row["besz_id"].'" value="'.$row["besz_neve"].'"  onkeyup="update_beszallito('.$row["besz_id"].')"></td>
                                    <td><input type="text" class="form-control" id="beszallito_email_'.$row["besz_id"].'" value="'.$row["besz_email"].'"  onkeyup="update_beszallito('.$row["besz_id"].')"></td>
                                    <td>
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-warning" onclick="update_beszallito('.$row["besz_id"].')"><i class="fa fa-pencil" aria-hidden="true"></i> </button>
                                        <button type="button" class="btn btn-danger" onclick="delete_beszallito('.$row["besz_id"].')"><i class="fa fa-trash" aria-hidden="true"></i> </button>
                                        </div>
                                    </td>
                                </tr>';

                    }
                } else {
                    echo "0 results";
                }

        //$html = '</tbody></table>';

        return $html;

    }


       public function cikktorzs_lista ($query){

        $html ='';

        $selected = "";
       
        $html .= '<table class="table table-condensed" 
            <thead>
              <tr>
                <th>Cikk ID:</th>
                <th>Áru neve</th>
                <th>Méret</th>
                <th>Ketegória</th>
                <th>Átlag ár Ft</th>
                <th>Eladási ár Bruttó Ft</th>
                <th>Vényes ár Bruttó Ft</th>
                <th>Vény ártámogatás Ft</th>
                <th>Akciós ár Bruttó Ft</th>
                <th>ÁFA tartam</th>
               
                <th>Gombok</th>
              </tr>
            </thead>
            <tbody>';
           $sql = "SELECT * FROM aru_cikktorzs WHERE aru_name LIKE '%$query%' AND aru_torolt = '0' ORDER BY aru_id DESC";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                       $html .=  '<tr id="aru_id_'.$row["aru_id"].'">
                                    <td style="width:100px;">'.$row["aru_id"].'</td>
                                    <td>
                                        <div class="input-group" data-toggle="tooltip" title="Áru neve"><div class="input-group-btn" >
                                            <buttom class="btn btn-default" onclick = ReadonlyChange("aru_name_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                            <input type="text" class="form-control" id="aru_name_'.$row["aru_id"].'" value="'.$row["aru_name"].'"  onkeyup="update_cikkrorzs('.$row["aru_id"].')" disabled>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group" data-toggle="tooltip" title="Méret"><div class="input-group-btn">
                                              <buttom class="btn btn-default" onclick = ReadonlyChange("aru_meret_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                            <input type="text" class="form-control" id="aru_meret_'.$row["aru_id"].'" value="'.$row["aru_meret"].'"  onkeyup="update_cikkrorzs('.$row["aru_id"].')" disabled>
                                        </div>
                                    </td>

                                   
                                    <td>
                                        <div class="input-group" data-toggle="tooltip" title="Ketegória"><div class="input-group-btn">
                                            <buttom class="btn btn-default" onclick = ReadonlyChange("aru_kategoria_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                                '. $this->kategoria($row["aru_kategoria"],$row["aru_id"]).'
                                        </div>
                                    </td>

                                    <td style="width:100px;" data-toggle="tooltip" title="Átlag ár" ><input type="number" class="form-control" id="aru_beszerzesi_ar_'.$row["aru_id"].'" value="'.$row["aru_beszerzesi_ar"].'"  onkeyup="update_cikkrorzs('.$row["aru_id"].')" readonly></td>

                                    <td style="width:150px;">
                                         <div class="input-group" data-toggle="tooltip" title="Eladási ár Bruttó Ft"><div class="input-group-btn">
                                            <buttom class="btn btn-default" onclick = ReadonlyChange("aru_eladasi_ar_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                            <input type="number" class="form-control" id="aru_eladasi_ar_'.$row["aru_id"].'" value="'.$row["aru_eladasi_ar"].'"  onkeyup="update_cikkrorzs('.$row["aru_id"].')" disabled>
                                        </div>
                                    </td>
                                    <td style="width:150px;">
                                        <div class="input-group" data-toggle="tooltip" title="Vényes ár Bruttó Ft"><div class="input-group-btn">
                                            <buttom class="btn btn-default" onclick = ReadonlyChange("aru_venyes_ar_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                            <input type="number" class="form-control" id="aru_venyes_ar_'.$row["aru_id"].'" value="'.$row["aru_venyes_ar"].'"  onkeyup="update_cikkrorzs('.$row["aru_id"].')" disabled>
                                        </div>
                                    </td>
                                    <td style="width:150px;">
                                        <div class="input-group" data-toggle="tooltip" title="Vény ártámogatás Ft" ><div class="input-group-btn">
                                            <buttom class="btn btn-default" onclick = ReadonlyChange("aru_cikkszam_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                            <input type="number" class="form-control" id="aru_cikkszam_'.$row["aru_id"].'" value="'.$row["aru_cikkszam"].'"  onkeyup="update_cikkrorzs('.$row["aru_id"].')" disabled>
                                        </div>
                                    </td>
                                    <td style="width:150px;">
                                        <div class="input-group" data-toggle="tooltip" title="Akciós ár Bruttó Ft" ><div class="input-group-btn">
                                             <buttom class="btn btn-default" onclick = ReadonlyChange("aru_akcios_ar_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                            <input type="number" class="form-control" id="aru_akcios_ar_'.$row["aru_id"].'" value="'.$row["aru_akcios_ar"].'"  onkeyup="update_cikkrorzs('.$row["aru_id"].')" disabled>
                                        </div>
                                    </td>
                                    <td style="width:150px;">
                                        <div class="input-group" data-toggle="tooltip" title="ÁFA tartam" ><div class="input-group-btn">
                                              <buttom class="btn btn-default" onclick = ReadonlyChange("aru_afa_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                            '. $this->afalista($row["aru_afa"],$row["aru_id"]) .'
                                        </div>
                                    </td>
                                    <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning" onclick="update_cikkrorzs('.$row["aru_id"].')"><i class="fa fa-cloud-upload" aria-hidden="true"></i> </button>
                                        <button type="button" class="btn btn-danger" onclick="delete_cikktorzs('.$row["aru_id"].')"><i class="fa fa-trash" aria-hidden="true"></i> </button>
                                        </div>
                                    </td>
                                </tr>';

                    }
                } else {
                    echo "0 results";
                }

        //$html = '</tbody></table>';

        return $html;

    }
    
//  áru tipus                         <td style="width:150px;">
//                                        <div class="input-group" data-toggle="tooltip" title="Áru tipus"><div class="input-group-btn">
//                                              <buttom class="btn btn-default" onclick = ReadonlyChange("aru_type_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom></div>
//                                            '. $this->arutype($row["aru_type"],$row["aru_id"]) .'
//                                        </div>
//                                    </td>
//                                    <td>

private function afalista($afa_value,$id) {

    $afakey = array("0","5","18","27");
    $html ="";
    $html .= '<select  id="aru_afa_'.$id.'" class="form-control" onchange="update_cikkrorzs('.$id.')" disabled>';

        foreach ($afakey as $value ){

            if ($afa_value == $value){ $selected = "selected"; } else {$selected  = "";}

            $html.= '<option value="'.$value.'" '.$selected.'>'.$value.' %</option>';

        }

    $html .=  '</select>';

    return $html;
}

private function arutype($type_value,$id) {

    $typekey = array("---","Áru","Készlet");
    $html ="";
    $html .= '<select  id="aru_type_'.$id.'" class="form-control" onchange="update_cikkrorzs('.$id.')" disabled>';

        foreach ($typekey as $value ){

            if ($type_value == $value){ $selected = "selected"; } else {$selected  = "";}

            $html.= '<option value="'.$value.'" '.$selected.'>'.$value.' </option>';

        }

    $html .=  '</select>';

    return $html;
}



private function beszallitok($beszallitio,$id){
    $html="";
    $selected = "";
    $html .= '<select  id="besz_beszallito_'.$id.'" class="form-control" onchange="update_beszerzes('.$id.')" disabled>';
        $sql = "SELECT * FROM aru_beszallito";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                        if ($row["besz_id"] == $beszallitio){ $selected = "selected"; } else {$selected  = "";}

                        $html.= '<option value="'.$row["besz_id"].'" '.$selected.'>'.$row["besz_neve"].' </option>';

                    }
                } else {
                    echo "0 results";
                }



    $html .=  '</select>';


   return $html;
}

private function kategoria($kategoria,$id){
    $html="";
    $selected = "";
    $html .= '<select  id="aru_kategoria_'.$id.'" class="form-control" onchange="update_cikkrorzs('.$id.')" disabled>';
        $sql = "SELECT * FROM aru_kategoria";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                        if ($row["kategoria_id"] == $kategoria){ $selected = "selected"; } else {$selected  = "";}

                        $html.= '<option value="'.$row["kategoria_id"].'" '.$selected.'>'.$row["kategoria_neve"].'</option>';

                    }
                } else {
                    echo "0 results";
                }



    $html .=  '</select>';


   return $html;
}

public function keszlet_lista(){
    $cikk_id = "";
    $html = "";
    $this->total_keszlet_ertek = 0;
    $this->total_keszelet_db = 0;

    $html .= '<table class="table table-condensed">
            <thead >
              <tr style="">
                <th style="">Cikk ID:</th>
                <th style="">Cikk neve</th>
                <th style="">Cikk méret</th>
                <th style="Color:red;">Budafoki + Fizio</th>
            
                <th style="Color:red;">P70 + P72</th>
                <th style="Color:red;">Óbuda</th>
                <th style="Color:red;">Lábcentrum</th>
                <th style="Color:red;">Központi készlet</th>
                <th style="text-align:right;">Netto átlagár Ft</th>
                <th style="text-align:right;">Készlet db</th>
                <th style="text-align:right;">Készlet érték Ft</th>
                <th style="min-width:150px;">Gombok</th>
              </tr>
            </thead>
           
            <tbody >';
              
              
                $sql1 = "SELECT DISTINCT (keszlet_aru_id) as cikk_id FROM aru_keszlet INNER JOIN aru_cikktorzs  ON  aru_keszlet.keszlet_aru_id =  aru_cikktorzs.aru_id  WHERE keszlet_torolt = '0' ORDER BY aru_cikktorzs.aru_name ASC";
                $result1 = $this->dbconn->query($sql1);

                if ($result1->num_rows > 0) {
                    // output data of each row
                    while($row1 = $result1->fetch_assoc()) {

                        $cikk_id =  $row1["cikk_id"];

                            $sql = "SELECT * FROM aru_cikktorzs WHERE aru_id = '$cikk_id'";

                            $result = $this->dbconn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {

                                   $this->sumdb_cikk = 0;
                                   $this->cikk_sor_ertek = 0;
                                   
                                   
//           Fizio kivesz                         <td style="width:150px;">
//                                                    <div class="input-group" data-toggle="tooltip" title="Fizio"><div class="input-group-btn">
//                                                        <buttom class="btn btn-default" onclick = ReadonlyChange("aru_keszlet_fizio_'.$cikk_id.'")><i class="fa fa-pencil-square-o"></i></buttom></div>
//                                                        <input  type="number"  data-raktar="Fizio" data-cikkid="'.$cikk_id.'" class="form-control" id="aru_keszlet_fizio_'.$cikk_id.'" value="'.$this->cikkdb_raktar_from_cikk_id_lastone($cikk_id,'Fizio').'"  onchange="update_keszlet(this.id)"  min="0" disabled>
//                                                    </div>            
//                                                </td>

                                   $html .=  '<tr id="keszlet_id_'.$cikk_id.'">
                                                <td style="width:50px;">'.$row["aru_id"].'</td>
                                                <td style="">'.$row["aru_name"].'</td>
                                                <td style="">'.$row["aru_meret"].'</td>
                                              
                                                <td style="width:150px;">
                                                    <div class="input-group" data-toggle="tooltip" title="Budafoki" ><div class="input-group-btn">
                                                        <buttom class="btn btn-default" onclick = ReadonlyChange("aru_keszlet_BMM_'.$cikk_id.'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                                        <input  type="number" data-placement="left" data-raktar="BMM" data-cikkid="'.$cikk_id.'" class="form-control" id="aru_keszlet_BMM_'.$cikk_id.'" value="'.$this->cikkdb_raktar_from_cikk_id_lastone($cikk_id,'BMM').'" onchange="update_keszlet(this.id)" min="0" disabled>
                                                    </div>    
                                                </td>
                                               
                                                <td style="width:150px;">
                                                    <div class="input-group" data-toggle="tooltip" title="P70"><div class="input-group-btn">
                                                        <buttom class="btn btn-default" onclick = ReadonlyChange("aru_keszlet_p70_'.$cikk_id.'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                                            <input  type="number" data-placement="top" data-raktar="P70" data-cikkid="'.$cikk_id.'" class="form-control" id="aru_keszlet_p70_'.$cikk_id.'" value="'.$this->cikkdb_raktar_from_cikk_id_lastone($cikk_id,'P70').'"  onchange="update_keszlet(this.id)"  min="0" disabled>
                                                    </div>         
                                                </td>
                                                <td style="width:150px;">
                                                    <div class="input-group" data-toggle="tooltip" title="Óbuda"><div class="input-group-btn">
                                                        <buttom class="btn btn-default" onclick = ReadonlyChange("aru_keszlet_Obuda_'.$cikk_id.'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                                        <input  type="number" data-placement="top"  data-raktar="Obuda" data-cikkid="'.$cikk_id.'" class="form-control" id="aru_keszlet_Obuda_'.$cikk_id.'" value="'.$this->cikkdb_raktar_from_cikk_id_lastone($cikk_id,'Obuda').'"  onchange="update_keszlet(this.id)"  min="0" disabled>
                                                    </div>        
                                                </td>
                                                <td style="width:150px;">
                                                    <div class="input-group" data-toggle="tooltip" title="Lábcentrum"><div class="input-group-btn">
                                                        <buttom class="btn btn-default" onclick = ReadonlyChange("aru_keszlet_labcentrum_'.$cikk_id.'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                                        <input  type="number"  data-placement="top" data-raktar="Labcentrum" data-cikkid="'.$cikk_id.'" class="form-control" id="aru_keszlet_labcentrum_'.$cikk_id.'" value="'.$this->cikkdb_raktar_from_cikk_id_lastone($cikk_id,'Lábcentrum').'"  onchange="update_keszlet(this.id)"  min="0" disabled>
                                                    </div>        
                                                </td>
                                                <td style="width:150px;">
                                                    <div class="input-group" data-toggle="tooltip" title="Központi készlet" ><div class="input-group-btn">
                                                        <buttom class="btn btn-default" onclick = ReadonlyChange("aru_keszlet_kozponti_'.$cikk_id.'")><i class="fa fa-pencil-square-o"></i></buttom></div>
                                                        <input  type="number"  data-placement="top" data-raktar="Kozponti_keszlet" data-cikkid="'.$cikk_id.'" class="form-control" id="aru_keszlet_kozponti_'.$cikk_id.'" value="'.$this->cikkdb_raktar_from_cikk_id_lastone($cikk_id,'Kozponti_keszlet').'"  onchange="update_keszlet(this.id)" min="0" disabled>
                                                    </div>        
                                                </td>
                                                <td style="text-align:right; " >'.$row["aru_beszerzesi_ar"].'Ft</td>
                                                <td style="text-align:right; " >'.$this->sumdb_cikk.' DB</td>
                                                <td style="text-align:right; " >'.$this->cikk_keszlet_ertek($row["aru_beszerzesi_ar"]).' FT</td>
                                                
                                                <td style="width:150px;">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning" onclick="undo_item_from_keszlet('.$cikk_id.')"><i class="fa fa-undo" aria-hidden="true"></i></button>
                                                        <button type="button" class="btn btn-danger" onclick="delete_item_from_keszlet('.$cikk_id.')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </div>        
                                                </td>    
                                                    
                                            </tr>';
                                        $this->total_keszlet_ertek += $this->cikk_sor_ertek;
                                        $this->total_keszelet_db += $this->sumdb_cikk;
                                }
                            } else { echo "keszlet hiba"; }
                    }
                    } else {
                        echo "cikktorzs hiba";
                    }

                $html .= '<th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;">'.$this->total_keszelet_db.' DB</td><td style="text-align:right;" >'.$this->total_keszlet_ertek.' Ft</td></th>';
    $html .= '</tbody>';

    return $html;
}

private function cikkname_from_cikk_id ($aru_id){

    $html ="";

        $sql = "SELECT * FROM aru_cikktorzs  WHERE aru_id = '$aru_id'";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {



                        $html.= $row["aru_name"];

                    }
                } else {
                    echo "0 results";
                }
    return $html;

}

private function cikkmeret_from_cikk_id ($aru_id){

    $html ="";

        $sql = "SELECT * FROM aru_cikktorzs  WHERE aru_id = '$aru_id'";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                         $html.= $row["aru_meret"];
                    }
                } else {
                    echo "0 results";
                }
    return $html;

}

private function cikkszam_from_cikk_id ($aru_id){

    $html ="";

        $sql = "SELECT * FROM aru_cikktorzs  WHERE aru_id = '$aru_id'";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                         $html.= $row["aru_cikkszam"];
                    }
                } else {
                    echo "0 results";
                }
    return $html;

}

private function cikkbeszar_from_cikk_id ($aru_id){

    $html ="";

        $sql = "SELECT * FROM aru_cikktorzs  WHERE aru_id = '$aru_id'";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                         $html.= $row["aru_beszerzesi_ar"];
                    }
                } else {
                    echo "0 results";
                }
    return $html;

}

private function select_cikkname_keszletre(){

    $html ="";

    $html .= '<select  id="aru_cikktorzs_keszletrevetel" class="form-control">';
        $sql = "SELECT * FROM aru_cikktorzs ORDER BY aru_name ASC";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                        $html.= '<option value="'.$row["aru_id"].'" >'.$row["aru_name"].' - '.$row["aru_meret"].'</option>';

                    }
                } else {
                    echo "0 results";
                }

    $html.='</select>';
    return $html;
}

private function select_cikkname_beszerzes(){

    $html ="";

    $html .= '<select  id="aru_cikktorzs_beszerzes" class="form-control">';
        $sql = "SELECT * FROM aru_cikktorzs ORDER BY aru_name ASC";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                        $html.= '<option value="'.$row["aru_id"].'" >'.$row["aru_name"].' - '.$row["aru_meret"].'</option>';

                    }
                } else {
                    echo "0 results";
                }

    $html.='</select>';
    return $html;
}



private function cikkdb_raktar_from_cikk_id_lastone ($aru_id,$raktar)
{

    $html ="";

        $sql = "SELECT * FROM aru_keszlet WHERE keszlet_aru_id = '$aru_id' AND keszlet_raktar = '$raktar'  AND keszlet_torolt = '0' ORDER BY keszlet_id DESC LIMIT 1";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                         $html.= $row["keszlet_db"];

                         $this->sumdb_cikk +=  $html;
                    }
                } else {
                    //echo "0 results";
                }
    return $html;

}





private function cikk_keszlet_ertek($cikk_ar){



  $this->cikk_sor_ertek = $cikk_ar * $this->sumdb_cikk;

   return $this->cikk_sor_ertek;
}

public function beszerzes_lista ($query1){

$html = "";
$checked_atlagar = "";
$checked_beszalatt = "";   
$atvezetes_disabled = "";
    $html .= '<table class="table table-condensed">
            <thead>
              <tr>
                <th>Cikk ID:</th>
                <th>Áru neve</th>
                <th>Áru méret</th>
                <th>Beszerzés Dátum</th>
                <th style="Color:red;">Beszerzés 1db<br>Nettó Ár  FT</th>
                <th style="Color:red;">Beszerzes DB</th>
                <th style="Color:red;">Átlagárba<br>beszámol</th>
                <th style="Color:red;">Megrendelve<br>beszerzés alatt</th>
                <th>Beszerzés Számlaszám</th>
                <th>Beszállító</th>
                <th>Értékesítve</th>
                <th>Átvezet Készletre / Ment / Töröl</th>
              </tr>
            </thead>
            <tbody>';
     //$sql = "SELECT * FROM aru_beszerzes WHERE besz_aru_id LIKE '%$query1%'  AND besz_torolt = '0' ORDER BY besz_aru_id ASC, besz_id DESC";
        $sql = "SELECT * FROM aru_beszerzes INNER JOIN aru_cikktorzs ON aru_beszerzes.besz_aru_id = aru_cikktorzs.aru_id WHERE aru_cikktorzs.aru_name LIKE '%$query1%' AND besz_torolt = '0' ORDER BY besz_id DESC, besz_aru_id ASC"  ;       
              
        $result = $this->dbconn->query($sql);
        
        if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                    if ($row["besz_atlagarkalk"] == 1){$checked_atlagar = "checked";} else {$checked_atlagar = "";}
                    if ($row["besz_beszerzes_alatt"] == 1){$checked_beszalatt = "checked";} else {$checked_beszalatt = "";}
                    if ($row["besz_keszletre_atvezet"] == 1){$atvezetes_disabled = "disabled"; } else {$atvezetes_disabled = "";}
                       
                    $html .=  $query1.'<tr id="besz_id_'.$row["besz_id"].'">
                                    <td>'.$row["besz_aru_id"].'</td>
                                 
                                    <td>'.$this->cikkname_from_cikk_id($row["besz_aru_id"]).'</td>
                                    <td>'.$this->cikkmeret_from_cikk_id($row["besz_aru_id"]).'</td>
                                    
                                    <td  style="width:150px;"> 
                                        <div class="input-group" data-toggle="tooltip" title="Beszerzés Dátum">
                                            <div class="input-group-btn">
                                                <buttom class="btn btn-default" onclick = ReadonlyChange("besz_real_date_'.$row["besz_id"].'")><i class="fa fa-pencil-square-o"></i></buttom>
                                            </div>
                                                <input type="date" class="form-control" id="besz_real_date_'.$row["besz_id"].'" value="'.$row["besz_real_date"].'" onchange="update_beszerzes('.$row["besz_id"].')" disabled>
                                        </div>            
                                    </td>
                                    <td  style="width:150px;">
                                        <div class="input-group" data-toggle="tooltip" title="Beszerzes FT">
                                            <div class="input-group-btn">
                                                <buttom class="btn btn-default" onclick = ReadonlyChange("besz_ar_'.$row["besz_id"].'")><i class="fa fa-pencil-square-o"></i></buttom>
                                            </div>
                                            <input type="number" class="form-control" id="besz_ar_'.$row["besz_id"].'" value="'.$row["besz_ar"].'"   onfocusout="update_beszerzes('.$row["besz_id"].')" disabled>
                                        </div>        
                                    </td>
                                    <td  style="width:150px;">
                                        <div class="input-group" data-toggle="tooltip" title="Beszerzes DB">
                                            <div class="input-group-btn">
                                                <buttom class="btn btn-default" onclick = ReadonlyChange("besz_db_'.$row["besz_id"].'")><i class="fa fa-pencil-square-o"></i></buttom>
                                            </div>
                                                <input type="number" class="form-control" id="besz_db_'.$row["besz_id"].'" value="'.$row["besz_db"].'"  onfocusout="update_beszerzes('.$row["besz_id"].')" disabled>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="input-group" data-toggle="tooltip" title="Átlagárba beszámol">
                                            <div class="input-group-btn" >
                                                <buttom class="btn btn-default" onclick = ReadonlyChange("besz_altagarkal_'.$row["besz_id"].'")><i class="fa fa-pencil-square-o"></i></buttom>
                                            </div>
                                        <input type="checkbox" class="" id="besz_altagarkal_'.$row["besz_id"].'" value="'.$row["besz_atlagarkalk"].'" style="height: 29px;width: 29px;"  '.$checked_atlagar.'  disabled onchange="update_beszerzes('.$row["besz_id"].')"> 
                                        </div>
                                    </td>
                                    
                                    <td>
                                       <div class="input-group">
                                            <div class="input-group-btn" data-toggle="tooltip" title="Rendelés alatt">
                                                <buttom class="btn btn-default" onclick = ReadonlyChange("besz_beszerzes_alatt_'.$row["besz_id"].'")><i class="fa fa-pencil-square-o"></i></buttom>
                                            </div>
                                            <input type="checkbox" class="" id="besz_beszerzes_alatt_'.$row["besz_id"].'" value="'.$row["besz_beszerzes_alatt"].'"  style="height: 29px;width: 29px;" '.$checked_beszalatt.' disabled onchange="update_beszerzes('.$row["besz_id"].')">
                                        </div>
                                    </td>
                                    
                                  
                                     <td  style="width:200px;">
                                        <div class="input-group">
                                            <div class="input-group-btn"  data-toggle="tooltip" title="Beszerzés Számlaszám">
                                                <buttom class="btn btn-default" onclick = ReadonlyChange("besz_szamlasz_'.$row["besz_id"].'")><i class="fa fa-pencil-square-o"></i></buttom>
                                            </div>
                                                <input type="text" class="form-control" id="besz_szamlasz_'.$row["besz_id"].'" value="'.$row["besz_szamlasz"].'" disabled  onfocusout="update_beszerzes('.$row["besz_id"].')">
                                        </div>                
                                    </td>

                                    <td>
                                        <div class="input-group" >
                                            <div class="input-group-btn" data-toggle="tooltip" title="Beszállító">
                                                <buttom class="btn btn-default" onclick = ReadonlyChange("besz_beszallito_'.$row["besz_id"].'")><i class="fa fa-pencil-square-o"></i></buttom>
                                            </div>'.$this->beszallitok($row["besz_beszallito_id"],$row["besz_id"]).'
                                        </div>
                                    </td>
                                    <td style="text-align:center"> '.$row["besz_eladva_db"].' db</td>
                                    <td>
                                        <div class="btn-group">
                                        <buttom class="btn btn-danger" data-beszid="'.$row["besz_id"].'" data-raktar="Kozponti_keszlet" data-cikkid="'.$row["besz_aru_id"].'" data-cikkdb="'.$row["besz_db"].'" id="besz_beszerzes_atvezetes_'.$row["besz_id"].'" onclick="update_keszlet_from_beszerzes(this.id)" '.$atvezetes_disabled.' >Átvezetés <i class="fa fa-plus" aria-hidden="true" ></i> '.$row["besz_db"].' </buttom>
                                        <button type="button" class="btn btn-warning" onclick="update_beszerzes('.$row["besz_id"].')"><i class="fa fa-pencil" aria-hidden="true"></i> </button>
                                        <button type="button" class="btn btn-danger" onclick="delete_beszerzes('.$row["besz_id"].')"><i class="fa fa-trash" aria-hidden="true"></i> </button>
                                        </div>
                                    </td>
                                </tr>';

                    }
                } else {
                    echo "nincs eredmény -> beszerések select";
                }
            $html .= '</tbody></table>';
   return $html;
}

function keszlet_lista_date($keszlet_datum){
    
    $cikk_id = "";
    $html = "";
    $this->total_keszlet_ertek = 0;
    $this->total_keszelet_db = 0;

    $html .= '<h4>Készletek lekérdezése:'.$keszlet_datum. ' dátumig</h4> 
            <table class="table table-condensed">
            <thead>
              <tr>
                <th>Cikk ID:</th>
                <th>Cikk neve</th>
                <th>Cikk méret</th>
              
                <th style="Color:red; text-align:center;">Budafoki + Fizio</th>
                
                <th style="Color:red; text-align:center;">P70 + P72</th>
                <th style="Color:red; text-align:center;">Óbuda</th>
                <th style="Color:red; text-align:center;">Lábcentrum</th>
                <th style="Color:red; text-align:center;">Központi készlet</th>
                <th style="text-align:right;">Netto átlagár Ft</th>
                <th style="text-align:right;">Készlet db</th>
                <th style="text-align:right;">Készlet érték Ft</th>
               
              </tr>
            </thead>
            <tbody>';
// törölt készletállapotokat is beszámítja
               //    $sql1 = "SELECT DISTINCT (keszlet_aru_id) as cikk_id FROM aru_keszlet INNER JOIN aru_cikktorzs  ON  aru_keszlet.keszlet_aru_id =  aru_cikktorzs.aru_id  WHERE keszlet_torolt = '0' ORDER BY aru_cikktorzs.aru_name ASC";
                $sql1 = "SELECT DISTINCT (keszlet_aru_id) as cikk_id FROM aru_keszlet INNER JOIN aru_cikktorzs  ON  aru_keszlet.keszlet_aru_id =  aru_cikktorzs.aru_id  WHERE keszlet_torolt = '0' ORDER BY aru_cikktorzs.aru_name ASC";
                $result1 = $this->dbconn->query($sql1);

                if ($result1->num_rows > 0) {
                    // output data of each row
                    while($row1 = $result1->fetch_assoc()) {

                        $cikk_id =  $row1["cikk_id"];

                            $sql = "SELECT * FROM aru_cikktorzs WHERE aru_id = '$cikk_id'";

                            $result = $this->dbconn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {

                                   $this->sumdb_cikk = 0;
                                   $this->cikk_sor_ertek = 0;

                                   $html .=  '<tr id="keszlet_id_'.$cikk_id.'">
                                                <td style="width:50px;">'.$row["aru_id"].'</td>
                                                <td>'.$row["aru_name"].'</td>
                                                <td>'.$row["aru_meret"].'</td>
                                                <td style="width:150px; text-align:center;">
                                                   
                                                    '.$this->cikkdb_raktar_from_cikk_id_date($cikk_id,'BMM',$keszlet_datum).'
                                                        
                                                </td>
                                              
                                                <td style="width:150px; text-align:center;">
                                                   
                                                     '.$this->cikkdb_raktar_from_cikk_id_date($cikk_id,'P70',$keszlet_datum).'
                                                      
                                                </td>
                                                <td style="width:150px; text-align:center;">
                                                    '.$this->cikkdb_raktar_from_cikk_id_date($cikk_id,'Obuda',$keszlet_datum).'
                                                    
                                                </td>
                                                <td style="width:150px; text-align:center;">
                                                   
                                                    '.$this->cikkdb_raktar_from_cikk_id_date($cikk_id,'Lábcentrum',$keszlet_datum).'
                                                   
                                                </td>
                                                <td style="width:150px; text-align:center;">
                                                    
                                                    '.$this->cikkdb_raktar_from_cikk_id_date($cikk_id,'Kozponti_keszlet',$keszlet_datum).'
                                                        
                                                </td>
                                                <td style="text-align:right;" >'.$row["aru_beszerzesi_ar"].'Ft</td>
                                                <td style="text-align:right;" >'.$this->sumdb_cikk.' DB</td>
                                                <td style="text-align:right;" >'.$this->cikk_keszlet_ertek($row["aru_beszerzesi_ar"]).' FT</td>
                                                
                                               
                                                    
                                            </tr>';
                                        $this->total_keszlet_ertek += $this->cikk_sor_ertek;
                                        $this->total_keszelet_db += $this->sumdb_cikk;
                                }
                            } else { echo "keszlet hiba"; }
                    }
                    } else {
                        echo "cikktorzs hiba";
                    }

                $html .= '<th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;">'.$this->total_keszelet_db.' DB</td><td style="text-align:right;" >'.$this->total_keszlet_ertek.' Ft</td></th>';
    $html .= '</tbody>';

    return $html;
}
    
private function cikkdb_raktar_from_cikk_id_date ($aru_id,$raktar,$date)
{
$style='style="color:black"';
    $html ="";
// törölt készletelemeket is listáz
        $sql = "SELECT * FROM aru_keszlet WHERE keszlet_aru_id = '$aru_id' AND keszlet_raktar = '$raktar' AND keszlet_torolt = '0' AND keszlet_datum < '$date' ORDER BY keszlet_id DESC LIMIT 1";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    
                    while($row = $result->fetch_assoc()) {
                        
                        // törölt listaelemek kiemelése
                        if ($row["keszlet_torolt"] == '1'){$style='red';} else {$style='black';}
                            
                            $html .= '<span style="color:'.$style.';">'.$row["keszlet_db"].' db</span>';

                         $this->sumdb_cikk +=  $row["keszlet_db"];
                    }
                } else {
                    //echo "0 results";
                }
    return $html;

} 

public function leltar_tablazat(){
    $html = "";
         
        $html .= '<h4>Készlet leltár </h4> 
            <table class="table table-condensed">
            <thead>
              <tr>
               
                <th>Cikk neve</th>
                <th>Cikk méret</th>
                <th>Cikkszám</th>
                <th style="Color:red; text-align:center;">Budafoki db</th>
                <th style="Color:red; text-align:center;">Fizio db</th>
                <th style="Color:red; text-align:center;">P70 db</th>
                <th style="Color:red; text-align:center;">Óbuda db </th>
                <th style="Color:red; text-align:center;">Lábcentrum db</th>
               
              </tr>
            </thead>
            </tbody>';
    
      $sql = "SELECT DISTINCT * FROM aru_cikktorzs ORDER BY aru_name ASC";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    
                    while($row = $result->fetch_assoc()) {
                        
                        $html.= '<tr>'
                                . '<td>'.$row["aru_name"].'</td>'
                                . '<td>'.$row["aru_meret"].'</td>'
                                . '<td>'.$row["aru_cikkszam"].'</td><td></td><td></td><td></td><td></td><td></td></tr>';
//                                . '<td>
////                                        <div class="input-group">
////                                            <div class="input-group-btn">
////                                                <buttom class="btn btn-default" onclick = ReadonlyChange("budafoki_leltar_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom>
////                                            </div>
////                                                <input type="number" class="form-control" id="budafoki_leltar_'.$row["aru_id"].'" value="" disabled  onchange="" >
////                                        </div>   
//                                  </td>'
//                                . '<td>
//                                    <div class="input-group">
//                                            <div class="input-group-btn">
//                                                <buttom class="btn btn-default" onclick = ReadonlyChange("fizio_leltar_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom>
//                                            </div>
//                                                <input type="number" class="form-control" id="fizio_leltar_'.$row["aru_id"].'" value="" disabled  onchange="" >
//                                        </div> 
//                                  </td>'
//                                . '<td>
//                                    <div class="input-group">
//                                            <div class="input-group-btn">
//                                                <buttom class="btn btn-default" onclick = ReadonlyChange("p70_leltar_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom>
//                                            </div>
//                                                <input type="number" class="form-control" id="p70_leltar_'.$row["aru_id"].'" value="" disabled  onchange="" >
//                                        </div>
//                                    </td>'
//                                . '<td>'
//                                . '<div class="input-group">
//                                            <div class="input-group-btn">
//                                                <buttom class="btn btn-default" onclick = ReadonlyChange("obuda_leltar_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom>
//                                            </div>
//                                                <input type="number" class="form-control" id="obuda_leltar_'.$row["aru_id"].'" value="" disabled  onchange="" >
//                                        </div>'
//                                    
//                                . '</td>'  
//                                . '<td>'
//                                . '<div class="input-group">
//                                            <div class="input-group-btn">
//                                                <buttom class="btn btn-default" onclick = ReadonlyChange("labcentrum_leltar_'.$row["aru_id"].'")><i class="fa fa-pencil-square-o"></i></buttom>
//                                            </div>
//                                                <input type="number" class="form-control" id="labcentrum_leltar_'.$row["aru_id"].'" value="" disabled  onchange="" >
//                                        </div>'
//                                . '</td>'
//                                . '</tr>';
                        
                    }
                } else {
                    //echo "0 results";
                }
    
    
       $html .= '</tbody></table>';
    return $html;
}

public function szallitolevel_rendelok_kozott(){
    
    $html ="";
    
   $html .=  '<h1> Készletmozgatás rendelők között </h1>
                <div class="row">
                <div class="col-sm-6">
                <div class="form-group">
                    <label for="sel1">Szállító:</label>
                    <select class="form-control" id="keszlet_szallito" name="keszlet_szallito">
                      <option value="BMM">Buda</option>
                      <option value="P70">P70</option>
                    
                      <option value="Obuda">Óbuda</option>
                      <option value="Labcentrum">Lábcentrum</option>
                      <option value="Kozponti_keszlet">Központi készlet</option>
                    </select>
                  </div>
                  
                </div>
                <div class="col-sm-6">
                    
                    <div class="form-group">
                        <label for="sel1">Átvevő:</label>
                        <select class="form-control" id="keszlet_atvevo" name="keszlet_atvevo">
                          <option value="BMM">Buda</option>
                          <option value="P70">P70</option>
                        
                          <option value="Obuda">Óbuda</option>
                          <option value="Labcentrum">Lábcentrum</option>
                          <option value="Kozponti_keszlet">Központi készlet</option>
                        </select>
                    </div>
                  
                </div>
                   
            </div>';
   $html .= '<div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="usr">Cikk neve - méret :</label>
                        '.$this->select_cikkname_szallitora().'
                    </div>
                </div>
                
                <div class="col-sm-1">
                    <div class="form-group">
                        <label for="usr">Cikk db :</label>
                        <input type="number" class="form-control" id="szallito_cikkdb" name="szallito_cikkdb" min="1">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="usr">Megjegyzés :</label>
                        <input type="text" class="form-control" id="szallito_cikknote" name="szallito_cikknote" placeholder="szállító szám, számlaszám stb..." >
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="usr"> OK :</label>
                        <div class=""> 
                           
                            <button type="button" class="btn btn-success" onclick="keszletmozgas()"><i class="fa fa-check" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
                
            </div>    
            ';
    $html .= '<div id="keszletmozgas"></div>' ; 
    $html .= '<div id="keszletdb"></div>' ;      
     
    return $html ;
}

private function select_cikkname_szallitora(){

    $html ="";

    $html .= '<select id="aru_cikktorzs_szallitora" class="form-control" onchange="getkeszletdb(this.id)">';
    $html .= '<option value="0" >Válassz terméket</option>';
    
    $sql = "SELECT * FROM aru_cikktorzs WHERE aru_torolt = '0' ORDER BY aru_name ASC";
                
            $result = $this->dbconn->query($sql);
                
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                        $html.= '<option value="'.$row["aru_id"].'" >'.$row["aru_name"].' - '.$row["aru_meret"].'</option>';

                    }
                } else {
                    echo "0 results";
                }

    $html.='</select>';
    return $html;
}

public function select_keszelt_history($keszlet_aru_id){
    
    $html = '';
    $html .= '<table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Cikk neve:</th>
                        <th>Dátum</th>
                        <th>Raktár</th>
                        <th>DB</th>
                        <th>Megjegyzés</th>
                      </tr>
                    </thead>
                    <tbody>';
                     
    
     $sql = "SELECT * FROM aru_keszlet INNER JOIN aru_cikktorzs ON aru_keszlet.keszlet_aru_id = aru_cikktorzs.aru_id WHERE aru_keszlet.keszlet_aru_id = '$keszlet_aru_id' AND aru_keszlet.keszlet_torolt = '0' ORDER BY aru_keszlet.keszlet_id DESC LIMIT 10"  ;   
    $result = $this->dbconn->query($sql);
     if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                        $html.= '<tr><td style="">'.$row["aru_name"].'</td>';
                        $html.= '<td style="">'.$row["keszlet_datum"].'</td>';
                        $html.= '<td style="">'.$row["keszlet_raktar"].'</td>';
                        $html.= '<td style="">'.$row["keszlet_db"].'</td>';
                        $html.= '<td style="">'.$row["keszlet_log"].'</td></tr>';
                    }
                } else {
                    echo "0 results";
                }
    
    $html .= '</tbody></table>';
    return $html;
}



}


