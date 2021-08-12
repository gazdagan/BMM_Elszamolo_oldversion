<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bejovoszamlaknyilvantartasClass
 *
 * @author gazda
 */
class bejovoszamlaknyilvantartasClass {
    //put your code here

     public function __construct() {
           $this->dbconn = DbConnect();
           $this->total_keszelet_db = 0;
           $this->total_keszlet_ertek = 0;
    }

   public function Tabmenu(){

        $html="";
      
        $html = '<ul class="nav nav-tabs" style="position: fixed; background-color: LightGrey; z-index: 100;"> 
                    <li class="active"><a data-toggle="tab" href="#bejovoszamlak" onclick=""> Bejövő számlák nyilvántartása </a></li>
                    <li class=""><a data-toggle="tab" href="#partnerek" onclick=""> Partnerek </a></li>
                    <li class=""><a data-toggle="tab" href="#fizetesmod" onclick=""> Fizetesmod </a></li>
                    <li class=""><a data-toggle="tab" href="#ktghelyek" onclick=""> Költség helyek </a></li>
                    <li class=""><a data-toggle="tab" href="#afakulcs" onclick=""> Áfa kulcsok </a></li>
                </ul>


        <div class="tab-content" style=" padding-top: 50px">
            <div id="bejovoszamlak" class="tab-pane fade in active">
                <div class="form-inline"  style="position: fixed; z-index: 10;">
                
                </div>
            </div>

            <div id="partnerek" class="tab-pane conatiner">
                <div class="form-inline"  style="position: fixed; z-index: 10;">
                 <div id="ktg_partner" class="container">'.$this->partner_lista().'</div>
                </div>
            </div>
            <div id="fizetesmod" class="tab-pane">
                <div class="form-inline"  style="position: fixed; z-index: 10;">
                
                </div>
            </div>
            <div id="ktghelyek" class="tab-pane">
                <div class="form-inline"  style="position: fixed; z-index: 10;">
                  

                </div>
            </div>
            <div id="afakulcs" class="tab-pane fade in active">
                <div class="form-inline"  style="position: fixed; z-index: 10;">
                
                </div>
            </div>
        </div>';





        return $html;
    }
    
    
     public function partner_lista (){

        $html ='';
        $html = '<table class="table table-striped">
            <thead>
              <tr>
                <th>No:</th>
                <th>Partner neve</th>
                <th>Partner Adószáma </th>
                <th>Partner Megjegyzés</th>
              </tr>
            </thead>
            <tbody>';
           $sql = "SELECT * FROM ktg_partner WHERE ktg_partner_torol = '0'";
                $result = $this->dbconn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                       $html .=  '<tr id="ktg_partner_id_'.$row["ktg_partner_id"].'">
                                    <td>'.$row["ktg_partner_id"].'</td>
                                    <td><input type="text" class="form-control" id="partner_name_'.$row["ktg_partner_id"].'" value="'.$row["ktg_partner_name"].'"  onkeyup="update_ktgpartner('.$row["ktg_partner_id"].')"></td>
                                    <td><input type="text" class="form-control" id="partner_adosz_'.$row["ktg_partner_id"].'" value="'.$row["ktg_partner_adosz"].'"  onkeyup="update_ktgpartner('.$row["ktg_partner_id"].')"></td>
                                    <td><input type="text" class="form-control" id="partner_note_'.$row["ktg_partner_id"].'" value="'.$row["ktg_partner_note"].'"  onkeyup="update_ktgpartner('.$row["ktg_partner_id"].')"></td>
                                    <td>
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-warning" onclick="update_ktgpartner('.$row["ktg_partner_id"].')"><i class="fa fa-pencil" aria-hidden="true"></i> </button>
                                        <button type="button" class="btn btn-danger" onclick="delete_ktgpartner('.$row["ktg_partner_id"].')"><i class="fa fa-trash" aria-hidden="true"></i> </button>
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
    
}
