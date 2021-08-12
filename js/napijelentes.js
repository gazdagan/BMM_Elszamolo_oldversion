/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function paciensek_post(){
    console.log("napi jelentés páciensek post");
    
    var adatok = {
        paciens_elegedettseg : "nincs",
        paciens_panasz : "nincs",
        paciens_varakozasiido : "nincs",
        telephely : "",
        recepcios : ""
       };    
     
    
    adatok.recepcios = document.getElementById("loginname").innerHTML;
    adatok.telephely = document.getElementById("select_telehely").innerHTML;
    
    adatok.paciens_elegedettseg =  document.getElementById("paciens_elegedettseg").value;
    adatok.paciens_panasz =  document.getElementById("paciens_panasz").value;
    adatok.paciens_varakozasiido =  document.getElementById("paciens_varakozasiido").value;
    
    adatok.napijelentes_adat =  "paciensadatok";
    
    
    postAjax("./PostGetAjax/post_napijelentes.php", adatok, function(data){ console.log(data); });
   
}


function elojegyzes_post(){
    console.log("napi jelentés előjegyzés post");
    
    var adatok = {
        elojegyzes_kapacitas : "nincs",
        elojegyzes_varakozas : "nincs",
        elojegyzes_rendeles : "nincs",
        telephely : "",
        recepcios : ""
       };    
     
    
    adatok.recepcios = document.getElementById("loginname").innerHTML;
    adatok.telephely = document.getElementById("select_telehely").innerHTML;
    
    adatok.elojegyzes_kapacitas =  document.getElementById("elojegyzes_kapacitas").value;
    adatok.elojegyzes_varakozas =  document.getElementById("elojegyzes_varakozas").value;
    adatok.elojegyzes_rendeles =  document.getElementById("elojegyzes_rendeles").value;
    
    adatok.napijelentes_adat =  "elojegyzes";
    
    
    postAjax("./PostGetAjax/post_napijelentes.php", adatok, function(data){ console.log(data); });
    
    
    
}

function orvosokterapeutak_post(Table_ID){
    
        
    console.log("Orvosok_terapeuták tábla");
    
    var adatok = {
        orvos_terapeuta :"",
        telephely : "",
        recepcios : ""
       };    
     
    
    adatok.recepcios = document.getElementById("loginname").innerHTML;
    adatok.telephely = document.getElementById("select_telehely").innerHTML;
    
    adatok.orvos_terapeuta =  CollectTabeData (Table_ID);
       
    adatok.napijelentes_adat =  "orvos_terapeuta_table";
    
    
    postAjax("./PostGetAjax/post_napijelentes.php", adatok, function(data){ console.log(data); });
    
  
}

function CollectTabeData (Table_ID){
  var oTable = document.getElementById(Table_ID);
    console.log("napi jelentés orvosok post", oTable);
    //gets rows of table
    var rowLength = oTable.rows.length;
    var cellVal = "";
    //loops through rows    
    for (i = 1; i < rowLength; i++){

      //gets cells of current row  
       var oCells = oTable.rows.item(i).cells;

       //gets amount of cells of current row
       var cellLength = oCells.length;

       //loops through each cell in current row
       for(var j = 0; j < cellLength; j++){

              // get your cell info here

              cellVal += oCells.item(j).getElementsByTagName("INPUT")[0].value + ",";
              
           }
    }
     return(cellVal);
    }  
    
    
function ugyfelszolgalat_post(Table_ID){
    console.log("Ügyfélszolgálat tábla");
    
    var adatok = {
        ugyfelszolgalat :"",
        telephely : "",
        recepcios : ""
       };    
     
    
    adatok.recepcios = document.getElementById("loginname").innerHTML;
    adatok.telephely = document.getElementById("select_telehely").innerHTML;
    
    adatok.ugyfelszolgalat =  CollectTabeData (Table_ID);
       
    adatok.napijelentes_adat =  "ugyfelszolgalat_table";
    
    
    postAjax("./PostGetAjax/post_napijelentes.php", adatok, function(data){ console.log(data); });
    
}

function eszkozok_post(Table_ID){
    
    console.log("eszközök tábla");
    
    var adatok = {
        meghibasodott_eszkoz :"",
        hiányzo_eszkoz :"",
        injekcio_db :"",
        telephely : "",
        recepcios : ""
       };    
     
    
    adatok.recepcios = document.getElementById("loginname").innerHTML;
    adatok.telephely = document.getElementById("select_telehely").innerHTML;
    
    adatok.meghibasodott_eszkoz = document.getElementById("meghibasodott_eszkoz").value;
    adatok.hiányzo_eszkoz = document.getElementById("hianyzo_eszkoz").value;
    adatok.injekcio_db =  CollectTabeData (Table_ID);
       
    adatok.napijelentes_adat =  "eszkozok_table";
    
    
    postAjax("./PostGetAjax/post_napijelentes.php", adatok, function(data){ console.log(data); });
    
    
    
    
}