/*
 készletek ekzuelése és változása
 **/

 function insert_kategoria(){

    var adatok = {
        kategoria_name : "000000"

       };

    adatok.kategoria_name = document.getElementById("keszlet_kategoria").value;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){
        console.log(data);
        select_keszlet("kategoria");
    });


}
 function update_kategoria(katagoria_id){

     var adatok = {
        kategoria_name_update : "000000",
        kategoria_id : "000000"
       };

     id = 'kategoria_id_'+ katagoria_id;

     console.log("készlet kategórai update:", id );

    adatok.kategoria_name_update = document.getElementById(id).value;
    adatok.kategoria_id = katagoria_id;



    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);

        //document.getElementById("cardlog").innerHTML = data;

    });
}

function delete_kategoria(katagoria_id) {

    var adatok = {
                delete_kategoria_id : "000000"
       };
    adatok. delete_kategoria_id  = katagoria_id;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);
           //document.getElementById("cardlog").innerHTML = data;
        select_keszlet("kategoria");
    });

  

}

function select_keszlet(tipus){

     var adatok = {
                select : ""
       };
    adatok.select = tipus;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log();

        if (adatok.select === "kategoria"){
        document.getElementById("kategoria_lista").innerHTML = data;
        }

        if (adatok.select === "beszallito"){
        document.getElementById("beszallito_lista").innerHTML = data;
        }
        if (adatok.select === "cikktorzs"){
        document.getElementById("cikktorzs_lista").innerHTML = data;
        }
        if (adatok.select === "keszlet"){
        document.getElementById("keszlet_lista").innerHTML = data;
        }
        if (adatok.select === "beszerzes"){
        document.getElementById("beszerzes_lista").innerHTML = data;
        }

    });

}

function select_keszlet_search(tipus,search_id){

  var adatok = {
             select : "",
             query : ""
    };
    adatok.query = document.getElementById(search_id).value;    
    adatok.select = tipus;

         postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log();

             if (adatok.select === "kategoria"){
             document.getElementById("kategoria_lista").innerHTML = data;
             }
             if (adatok.select === "beszallito"){
             document.getElementById("beszallito_lista").innerHTML = data;
             }
             if (adatok.select === "cikktorzs"){
             document.getElementById("cikktorzs_lista").innerHTML = data;
             }
             if (adatok.select === "keszlet"){
             document.getElementById("keszlet_lista").innerHTML = data;
             }
             if (adatok.select === "beszerzes"){
             document.getElementById("beszerzes_lista").innerHTML = data;
             }

         });

}

 

function select_all_table(){

    select_keszlet("kategoria");
    select_keszlet("beszallito");
    select_keszlet("cikktorzs");
    select_keszlet("keszlet");
    select_keszlet("beszerzes");
}

function insert_beszallito(){

    var adatok = {
        insert_beszallito : "insert"

       };

    //adatok.beszallito_name = document.getElementById("beszallito_neve").value;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);
     select_keszlet("beszallito");
    });


}


function update_beszallito(besz_id){

    var adatok = {
        besz_name_update : "000000",
        besz_email : "",
        besz_id : "000000"
       };

    id = 'beszallito_id_'+ besz_id;
    id_email = 'beszallito_email_'+ besz_id;  
    console.log("beszállító update:", id );

    adatok.besz_name_update = document.getElementById(id).value;
    adatok.besz_id = besz_id;
    adatok.besz_email = document.getElementById(id_email).value;


    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);

        //document.getElementById("cardlog").innerHTML = data;

    });
}


function delete_beszallito(besz_id) {

    var adatok = {
                delete_beszallito_id : "000000"
       };
    adatok.delete_beszallito_id  = besz_id;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);
           //document.getElementById("cardlog").innerHTML = data;
           select_keszlet("beszallito");
    });



}


function insert_cikktorzs(){

      var adatok = {
        cikktorzs_insert : "ujcikk"

       };

  //  adatok.beszallito_name = document.getElementById("beszallito_neve").value;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){
        select_keszlet("cikktorzs");
        console.log(data);

    });



}

function delete_cikktorzs(cikk_id) {

    var adatok = {
                delete_cikktorzs_id : "000000"
       };
    adatok.delete_cikktorzs_id  = cikk_id;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);
           //document.getElementById("cardlog").innerHTML = data;

    });

let row_id  = 'aru_id_'+ cikk_id;

    document.getElementById(row_id).style.display = 'none';

}


function update_cikkrorzs(cikk_id){

    var adatok = {
        aru_update :"update",
        aru_name : "",
        aru_id : "err",
        aru_meret : "",
        aru_beszerzesi_ar : "",
        aru_be_szamlaszam : "null",
        aru_beszallito : "null",
        aru_kategoria : "",
        aru_eladasi_ar: "",
        aru_venyes_ar : "",
        aru_akcios_ar : "",
        aru_afa : "" ,
        aru_cikkszam : "" 
    };
       // aru_type: ""
     

    //id = 'aru_id_'+ cikk_id;

    adatok.aru_id = cikk_id;
    adatok.aru_name = document.getElementById('aru_name_'+ cikk_id).value;
    adatok.aru_beszerzesi_ar = document.getElementById('aru_beszerzesi_ar_'+ cikk_id).value;
//    adatok.aru_be_szamlaszam = document.getElementById('aru_be_szamlaszam_'+ cikk_id).value;
//    adatok.aru_beszallito = document.getElementById('aru_beszallito_'+ cikk_id).value;
    adatok.aru_kategoria = document.getElementById('aru_kategoria_'+ cikk_id).value;
    adatok.aru_eladasi_ar = document.getElementById('aru_eladasi_ar_'+ cikk_id).value;
    adatok.aru_venyes_ar = document.getElementById('aru_venyes_ar_'+ cikk_id).value;
    adatok.aru_venyes_ar = document.getElementById('aru_venyes_ar_'+ cikk_id).value;
    adatok.aru_afa = document.getElementById('aru_afa_'+ cikk_id).value;
    adatok.aru_cikkszam = document.getElementById('aru_cikkszam_'+ cikk_id).value;
    adatok.aru_meret = document.getElementById('aru_meret_'+ cikk_id).value;
    adatok.aru_akcios_ar = document.getElementById('aru_akcios_ar_'+ cikk_id).value;
//    adatok.aru_type = document.getElementById('aru_type_'+ cikk_id).value;
    
    console.log("beszállító update:", adatok.aru_name );
    
    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);

        //document.getElementById("cardlog").innerHTML = data;

    });

}


function insert_keszlet(){

  var adatok = {
                aru_id : "ERR",
                keszlet : "insert"
          };

     adatok.aru_id = document.getElementById("aru_cikktorzs_keszletrevetel").value;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){
        select_keszlet("keszlet");
        console.log(data);

    });



}


function update_keszlet(id){

    var adatok = {
        keszlet_insert : "insert",
        keszlet_cikk_id : "",
        keszlet_raktar : "",
        keszlet_db : ""
        };

    const cikk_datas = document.getElementById(id);
    adatok.keszlet_raktar = cikk_datas.getAttribute('data-raktar');
    adatok.keszlet_cikk_id = cikk_datas.getAttribute('data-cikkid');
    adatok.keszlet_db =  cikk_datas.value;

    console.log("keszlet insert:");
    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);

        select_keszlet("keszlet");

    });

}


function  Select_keszlet_date(){

      var adatok = {
        
        keszlet_select_datum: ""
        
    };

    adatok.keszlet_select_datum = document.getElementById("date_keszlet_allapot").value + " 23:59:59" ;


    console.log("keszlet allapot:", adatok.keszlet_select_datum);
    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);

    //keszlet_allapot
    document.getElementById("keszlet_allapot").innerHTML = data;
    
    
    });

}


function insert_beszerzes(){

    var adatok = {
                aru_id : "ERR",
                beszerzes : "insert"
          };

     adatok.aru_id = document.getElementById("aru_cikktorzs_beszerzes").value;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){
        select_keszlet("beszerzes");
        console.log(data);

    });
}

function update_beszerzes(besz_id){

    var adatok = {
        besz_db : "null",
        besz_ar : "null",
        besz_szamlaszam : "null",
        besz_id : "ERR",
        besz_beszallito_id : "ERR",
        besz_atlagarkalk : "ERR",
        besz_real_date : "ERR",
        besz_beszerzes_alatt : "ERR" 
    };


    console.log("beszerzes update: ", besz_id );
    adatok.besz_id = besz_id;
    adatok.besz_db = document.getElementById("besz_db_"+besz_id).value;
    adatok.besz_ar = document.getElementById("besz_ar_"+besz_id).value;
    adatok.besz_szamlaszam = document.getElementById("besz_szamlasz_"+besz_id).value;
    adatok.besz_beszallito_id = document.getElementById("besz_beszallito_"+besz_id).value;
    adatok.besz_real_date = document.getElementById("besz_real_date_"+besz_id).value;
    
//    adatok.besz_beszerzes_alatt = document.getElementById("besz_beszerzes_alatt_"+besz_id).value;
//    adatok.besz_atlagarkalk = document.getElementById("besz_altagarkal_"+besz_id).value;   
    
    if( document.getElementById("besz_altagarkal_"+besz_id).checked ){adatok.besz_atlagarkalk = 1;} else {adatok.besz_atlagarkalk = 0;}
    if( document.getElementById("besz_beszerzes_alatt_"+besz_id).checked ){adatok.besz_beszerzes_alatt = 1;} else {adatok.besz_beszerzes_alatt = 0;}
    
    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);

        select_keszlet("beszerzes");

    });

}


function delete_beszerzes(besz_id){

     var adatok = {
                delete_beszerzes_id : "000000"
       };
    adatok.delete_beszerzes_id  = besz_id;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);

        select_keszlet("beszerzes");

    });




}

function ReadonlyChange(id){
var readonly = document.getElementById(id).disabled;

console.log ("readonly cahange ID:", id, readonly);


    if (readonly === true){

        document.getElementById(id).disabled = false;
        document.getElementById(id).style.borderColor = "blue";
       // document.getElementById(id).style.boxShadow = "inset 0 0 5px 5px #FF0000;";

    }else{

        document.getElementById(id).disabled = true;
        document.getElementById(id).style.borderColor = "red";
    }
}


function update_keszlet_from_beszerzes(id){

    var adatok = {
        keszlet_update_from_beszerzes : "update",
        keszlet_cikk_id : "",
        keszlet_raktar : "",
        keszlet_db : ""
        
        };
    
    var datas = {
        besz_keszletre_atvezet : "1",
        besz_id : "ERR"
    } 
    
    const cikk_datas = document.getElementById(id);
    adatok.keszlet_raktar = cikk_datas.getAttribute('data-raktar');
    adatok.keszlet_cikk_id = cikk_datas.getAttribute('data-cikkid');
    adatok.keszlet_db =  cikk_datas.getAttribute('data-cikkdb');
    
    datas.besz_id =  cikk_datas.getAttribute('data-beszid');

    console.log("keszlet insert:");
    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);

        select_keszlet("keszlet");
        
        postAjax("./PostGetAjax/post_keszlet_adatok.php", datas, function(data){ console.log(data);
           
        select_keszlet("beszerzes");
        });
    });
}


function undo_item_from_keszlet (cikk_id){
    
       var adatok = {
            undo_item_from_keszlet : "keszlet utolso esemény vissza",
            keszlet_aru_id: "ERR"     
        };
    
    adatok.keszlet_aru_id  = cikk_id;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);
        select_keszlet("keszlet");
    });
    
    
}

function delete_item_from_keszlet (cikk_id){
    
     
       var adatok = {
            delete_item_from_keszlet : "keszlet cikk tolrese",
            keszlet_aru_id: "ERR"     
        };
    
    adatok.keszlet_aru_id  = cikk_id;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);
        select_keszlet("keszlet");
    });
    
    
    
}

function getkeszletdb (id){
    
 
       var adatok = {
            get_item_db_keszlet : "készlet szallito",
            keszlet_aru_id: "ERR"     
        };
    
    adatok.keszlet_aru_id  = document.getElementById(id).value;

    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);
       
    document.getElementById("keszletdb").innerHTML = data;
    
    });
    
   
}

function keszletmozgas(){
    
    var adatok = {
            keszlet_mozgas : "készlet mozgatas",
            keszlet_aru_id: "",
            keszlet_db_mozgas:"",
            keszlet_szallito:"",
            keszlet_atvevo:"",
            keszlet_log:""
        };
    
    adatok.keszlet_szallito  = document.getElementById("keszlet_szallito").value;
    adatok.keszlet_atvevo = document.getElementById("keszlet_atvevo").value;
    adatok.keszlet_aru_id = document.getElementById("aru_cikktorzs_szallitora").value;
    adatok.keszlet_db_mozgas = document.getElementById("szallito_cikkdb").value;
    adatok.keszlet_log = document.getElementById("szallito_cikknote").value;
    
    //új bejegyzés vagy upadte
    postAjax("./PostGetAjax/post_keszlet_adatok.php", adatok, function(data){ console.log(data);
        document.getElementById("keszletmozgas").innerHTML = data;
        getkeszletdb ("aru_cikktorzs_szallitora");
    });
  
}