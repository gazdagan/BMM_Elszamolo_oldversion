//all in form javascript könyvtára


function getpaciensnev(str){
    //console.log(str);
    if (str == "") {
        //document.getElementById("selectSzolg").innerHTML = "";
        return;
    } else {
       // document.getElementById("allinformpaciensneve").value = str;    
    }

}


function kezelo(telephely,tipus){
    
    console.log("paciens-orvoshoz");   
    
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("selectkezelo").innerHTML = this.responseText;
    }
    };
    
    xmlhttp.open("GET","./PostGetAjax/get_allinform.php?kezelo_telephely_neve="+telephely+"&kezelo_tipus="+tipus,true);
    xmlhttp.send();  
    document.getElementById("allinformCikk_id").value = "null";
} 


function szolgaltatasok_arak(kezelo_neve){
    
    console.log("paciens-orvos-szolgaltatas");   
    
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("selectszolgaltatas").innerHTML = this.responseText;
    }
    };
    
    document.getElementById("allinformkezeloneve").value = kezelo_neve; 
    document.getElementById("allinformkezeloneve_el").value = kezelo_neve; 
    
    xmlhttp.open("GET","./PostGetAjax/get_allinform.php?kezelo_neve="+kezelo_neve,true);
    xmlhttp.send();  
}

/**
 * kiválasztoot szolgáltatásokból összegzi az árakat jutalékokat
 * @returns {undefined}
 * 
 */
function szolgaltatas_modja (){
    // kiválasztott paraméterek a rögzítési formba mennek
    //id="szolg_ar_kivalaszto" radio gombok és checkbox feldolgozósa
    console.log("paciens-orvos-szolgaltatas-fizmód");   
    
    var kezelesek = document.forms[1];
    var txt = "";
    var jutalek = 0;
    var ar = 0;
    var afa = 0;
    var afakulcs = 0;
    
    var i;
    for (i = 0; i < kezelesek.length; i++) {
        
        if (kezelesek[i].checked) {
            txt = txt + kezelesek[i].dataset.kezelestipus + " ";
            jutalek = jutalek + parseFloat(kezelesek[i].dataset.kezelesjutalek);
            ar = ar + parseFloat(kezelesek[i].dataset.kezelesar);
            afakulcs = parseFloat(kezelesek[i].dataset.afa_kulcs);
            afa = afa + parseFloat(kezelesek[i].dataset.afa_tartam);
            console.log(txt, ar, jutalek, afa , afakulcs);
        
        }
    }
    document.getElementById("allinformszolgaltatas").value = txt;
    document.getElementById("allinformszolgaltatasjutalek").value = jutalek;
    document.getElementById("allinformszolgaltatasar").value = ar;
    document.getElementById("allinformaru_sell_type").value = "szolgáltatás";
    document.getElementById("allinformaru_AFA").value = afa;
    document.getElementById("allinformaru_afakulcs").value = afakulcs;
} 




/**fizetes_modja(fizmod)
 * 
 * Fizelési módok egyedegi input mezőkhöz kapcsolódó beállításai 
 *  
 */
function fizetes_modja(fizmod){
 
   document.getElementById("allinformszolgaltatasfizmod").value = fizmod;
   document.getElementById("allinformszolgaltatasszamalaszam").readOnly = true;
   document.getElementById("allinformszolgaltatasslipszam").readOnly = true;
   document.getElementById("allinformepvalasztas").readOnly = true;
   document.getElementById("allinformszolgaltatas").readOnly = true;
   document.getElementById("allinformszolgaltatasar").readOnly = true;
   document.getElementById("allinformszolgaltatasjutalek").readOnly = true;
   document.getElementById("allinformepvalasztas").disabled = true;
   document.getElementById("allinformszolgaltatasnyugtaszam").readOnly = true;
   
   if (fizmod === "kp-nyugta"){
    console.log ("fizetés kp-nyugat");
        document.getElementById("allinformszolgaltatasnyugtaszam").readOnly = false;
        document.getElementById("allinformszolgaltatasnyugtaszam").required = true;
   }
      
   if (fizmod === "kp-számla" || fizmod === "szamlazz.hu-átutalás" ){
    console.log ("fizetés kp-számla");  
        document.getElementById("allinformszolgaltatasszamalaszam").readOnly = false;
        document.getElementById("allinformszolgaltatasszamalaszam").required = true;
   }
   
   if(fizmod === "bankkártya-nyugta") {
    console.log ("bankkártya-nyugta");
        document.getElementById("allinformszolgaltatasslipszam").readOnly = false;
        document.getElementById("allinformszolgaltatasslipszam").required = true;
        document.getElementById("allinformszolgaltatasnyugtaszam").readOnly = false;
        document.getElementById("allinformszolgaltatasnyugtaszam").required = true;
   }
   
   if(fizmod === "bankkártya-számla"){
    document.getElementById("allinformszolgaltatasszamalaszam").readOnly = false;
    document.getElementById("allinformszolgaltatasslipszam").readOnly = false;
    document.getElementById("allinformszolgaltatasszamalaszam").required = true;
    document.getElementById("allinformszolgaltatasslipszam").required = true;
   }

   if(fizmod === "egészségpénztár-számla"){
    
        console.log("fizetés ep szamla");
        document.getElementById("allinformszolgaltatasszamalaszam").required = true;
        //document.getElementById("allinformszolgaltatasslipszam").required = true;
        document.getElementById("allinformepvalasztas").disabled = false;
        document.getElementById("allinformszolgaltatasszamalaszam").readOnly = false;
        //document.getElementById("allinformszolgaltatasslipszam").readOnly = false;
      
    }

    if(fizmod === "egészségpénztár-kártya"){
       
        console.log("fizetés ep kartya");
        document.getElementById("allinformszolgaltatasszamalaszam").required = true;
        document.getElementById("allinformszolgaltatasslipszam").required = true;
        document.getElementById("allinformepvalasztas").required = true;
        document.getElementById("allinformepvalasztas").disabled = false;
        document.getElementById("allinformszolgaltatasszamalaszam").readOnly = false;
        document.getElementById("allinformszolgaltatasslipszam").readOnly = false;
           
    
    }
     
    if ( fizmod === "átutalás" ){
        document.getElementById("allinformszolgaltatasszamalaszam").readOnly = false; 
        //document.getElementById("allinformszolgaltatasslipszam").readOnly = false;
        document.getElementById("allinformszolgaltatasszamalaszam").required = true;
        //document.getElementById("allinformszolgaltatasslipszam").required = true;
    }
    
    if(fizmod === "europe assistance" || fizmod === "TELADOC" || fizmod === "Union-Érted"){
        document.getElementById("allinformszolgaltatasszamalaszam").readOnly = false; 
        //document.getElementById("allinformszolgaltatasslipszam").readOnly = false;
        document.getElementById("allinformszolgaltatasszamalaszam").required = true;
        //document.getElementById("allinformszolgaltatasslipszam").required = true;
    
        GombID = "allinfomrOK";
        ReadonlyChange(GombID);
        html_alert = '<div class="alert alert-danger alert-dismissible">'+
                     '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                     '<strong>Figyelem!</strong> Az ambuláns lapot aláírva be kell szkennelni és FELTÖLTENI a biztosítóhoz! + Az AUTORIZÁCIÓS kódot a "Note" mezőben be kell írni!   ' + '<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#textarea" aria-expanded="true" onclick = "ReadonlyChange(GombID)">Feltöltöttem</button>' +
                     '</div>';
       
       
       document.getElementById("alertbox").innerHTML = html_alert;     
       document.getElementById("note").required = true;
    
    
    }
    
    
    
    
    if (fizmod === "ajándék"){
        document.getElementById("allinformszolgaltatasar").value = 0;
        document.getElementById("allinformszolgaltatasjutalek").value = 0;
         
     }
}   

/**
 * egyedi árak mezők engedélyezése
 * 
 */

function egyedi_arak_szolg(egyedi){
    if (egyedi == "egyedi_ar"){
        
        console.log("egyedi árazás");      
        document.getElementById("allinformszolgaltatasar").readOnly = false;
        document.getElementById("allinformszolgaltatasjutalek").readOnly = false;
        document.getElementById("allinformszolgaltatasar").required = true;
        document.getElementById("allinformszolgaltatasjutalek").required = true;

        szolgtxt = document.getElementById("allinformszolgaltatas").value;
        szolgtxt = szolgtxt +' egyedi ár ';
        document.getElementById("allinformszolgaltatas").value = szolgtxt;    
    }  
    if (egyedi == "egyedi_szolg"){
        
        console.log("egyedi szolgáltatás");      
        document.getElementById("allinformszolgaltatas").readOnly = false;
      //  document.getElementById("allinformszolgaltatasjutalek").readOnly = false;
        document.getElementById("allinformszolgaltatas").required = true;
       // document.getElementById("allinformszolgaltatasslipszam").required = true;
      
    } 
    // bmm házon belüli szolg 0 ft ár
    if (egyedi == "bmmegeszseg1"){
        
        console.log("Bmm mk 1. alkalom");      
        
        document.getElementById("allinformszolgaltatasar").required = true;
        document.getElementById("allinformszolgaltatasjutalek").required = true;

        szolgtxt = document.getElementById("allinformszolgaltatas").value;
        szolgtxt = szolgtxt +' BMM mk 100% ';
        document.getElementById("allinformszolgaltatas").value = szolgtxt;    
        document.getElementById("allinformszolgaltatasar").value = 0;
        
        document.getElementById("allinformszolgaltatasfizmod").value = 'ajándék';
    }  
    
    if (egyedi == "bmmegeszseg2"){
        
        console.log("Bmm mk -20% alkalom");      
        
        document.getElementById("allinformszolgaltatasar").required = true;
        document.getElementById("allinformszolgaltatasjutalek").required = true;

        szolgtxt = document.getElementById("allinformszolgaltatas").value;
        szolgtxt = szolgtxt +' BMM mk 20% ';
        document.getElementById("allinformszolgaltatas").value = szolgtxt;    
        
        akcio = parseFloat(document.getElementById("allinformszolgaltatasar").value) * 0.8;
        
        document.getElementById("allinformszolgaltatasar").value = akcio;
    }  
    
    
   
}    
 // form adatainak kitöltöttsége  
 function checkform(){
    
//    var inputstr; 
//    document.getElementById("allinformszolgaltatasfizmod").value = inputstr;
   
     
     if(document.getElementById("allinformkezeloneve").value == ""){
         alert("Kezelő nincs kiválasztva!"); 
         location.reload(TRUE);
         return;
         //location.reload();
    }
    if(document.getElementById("allinformszolgaltatas").value == ""){
         alert("Szolgaltatas nincs kiválasztva!"); 
         location.reload(TRUE);
         return;
    }
    if(document.getElementById("allinformszolgaltatasar").value == ""){
         alert("Szolgaltatas ár nincs megadva!"); 
         location.reload(TRUE);
         return;
    }
    if(document.getElementById("allinformszolgaltatasjutalek").value == ""){
         alert("Jutalék nincs megadva!"); 
         location.reload(TRUE);
         return;
    }
     if(document.getElementById("allinformszolgaltatasfizmod").value == ""){
         alert("Fizetési mód nincs kiválasztva!");
         location.reload(TRUE);
         return;
    }
    
}
  

function paciens_elorogzites(rogzito){
    //html.id lista
    //select_telehely
    //allinformpaciensneve
    //allinformkezeloneve
    var nultxt = null;

    var telephely = document.getElementById("select_telehely").innerHTML;
    var paciens = document.getElementById("paciensneve_el").value;
    var kezelo_neve = document.getElementById("allinformkezeloneve_el").value;
    
    // tartalom ürítése
    document.getElementById("paciensneve_el").value = nultxt;
    document.getElementById("allinformkezeloneve_el").value = nultxt;
    
    console.log("előrogzítés:",telephely, paciens, kezelo_neve);

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("elorogzites_table").innerHTML = this.responseText;
    }
    };
    
    xmlhttp.open("GET","./PostGetAjax/get_allinform.php?telephely_el="+telephely+"&paciens_el="+paciens+"&kezelo_el="+kezelo_neve+"&rogzito_el="+rogzito,true);
    xmlhttp.send();  

}

// kiválasztot páciens adatainak formba visszarakása
function el_beteg_rogzitesre (paciens_neve,kezelo_neve,beteglista_id){

    document.getElementById("allinformkezeloneve").value = kezelo_neve;
    document.getElementById("allinformpaciensneve").value = paciens_neve;
    document.getElementById("allinformbeteglista_id").value = beteglista_id;
    
    szolgaltatasok_arak(kezelo_neve);    
    console.log('elr_beteg_rogzítésre:',paciens_neve,kezelo_neve);

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("elorogzites_table").innerHTML = this.responseText;
    }
    };
    
    var telephely = document.getElementById("select_telehely").innerHTML;    

    xmlhttp.open("GET","./PostGetAjax/get_allinform.php?telephely_el="+telephely+"&beteg_rogzitve_el_id="+beteglista_id,true);
    xmlhttp.send();  

}
/**
 * 
 * el_beteg_torlesre(beteglista_id)
 * 
 * előjegyzési táblából beteg törlése 
 */
function el_beteg_torlesre(beteglista_id){

    console.log("elr_beteg_torlés:",beteglista_id);
    
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           document.getElementById("elorogzites_table").innerHTML = this.responseText;
        }
        };
        
    var telephely = document.getElementById("select_telehely").innerHTML;    

        xmlhttp.open("GET","./PostGetAjax/get_allinform.php?telephely_el="+telephely+"&beteg_torles_el="+beteglista_id,true);
        xmlhttp.send();  

}
// felyamat atirányatása gérlet kezeléshez az előrögzítés id felhasználásával
function berletes_paciens(){
    
    var beteglista_id = document.getElementById("allinformbeteglista_id").value;
    var berlet_page =  'index.php?pid=page21&beteglista_id=' + beteglista_id; 
    console.log ('bérletes páciens: ' , beteglista_id ,berlet_page);
    document.location.replace(berlet_page);
    
}

// készlet kategóriák lekérdezése
function keszlet_kategoriak(telephely){
    console.log ("keszlet kategoriak");
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("selectkezelo").innerHTML = this.responseText;
    }
    };
    
    // raktárak közötti összevonás -----ITT KELL ------
    if (telephely == "BMM" || telephely == "Fizio" || telephely == "Lábcentrum"){telephely = "BMM";}
    if (telephely == "P70" || telephely == "P72"){telephely = "P70";}
    if (telephely == "Óbuda" ){telephely = "Óbuda";}
   // if (telephely == "Lábcentrum" ){telephely = "Lábcentrum";}
    
    xmlhttp.open("GET","./PostGetAjax/get_keszelet.php?keszlet_telephely_neve="+telephely,true);
    xmlhttp.send();  
    
    
}


function keszlet_tetelek(id){
    
    
     console.log ("keszlet tetelek");
     
      
    const kategoria_datas = document.getElementById(id);
    var kategoria_id = kategoria_datas.getAttribute('data-kategoriaid');
    var kategoria_name = kategoria_datas.getAttribute('date-kategorianame');
    var keszlet_raktar = kategoria_datas.getAttribute('date-telephely');
    
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("selectszolgaltatas").innerHTML = this.responseText;
       
        }
    };
    
    document.getElementById("allinformkezeloneve").value = "Medport Kft. Kat: " + kategoria_name;
    xmlhttp.open("GET","./PostGetAjax/get_keszelet.php?kategoria_id="+kategoria_id+"&keszlet_raktar="+keszlet_raktar,true);
    xmlhttp.send();  
    
    
}


function keszlet_eladas(dbid,id){
     // kiválasztott paraméterek a rögzítési formba mennek - készlet értékesítés rögzítése
   
    console.log("készlet értékesítés ár termék:", id);   
    
    const cikk_datas = document.getElementById(id);
    var db = document.getElementById(dbid).value; 
    var txt = 'Cikk: ' + cikk_datas.getAttribute('data-cikk') + ' db: ' + db;
    var jutalek = 0;
    var ar = cikk_datas.getAttribute('data-ar');
    var afa = cikk_datas.getAttribute('data-afa');
    var afakulcs = cikk_datas.getAttribute('data-afakulcs');
    var db = document.getElementById(dbid).value; 
    var veny_artam = cikk_datas.getAttribute('data-veny_artam');
        
    ar = ar * db;
    afa = afa * db;
    veny_artam = veny_artam * db;
    
    document.getElementById("allinformszolgaltatas").value = txt;
    document.getElementById("allinformszolgaltatasjutalek").value = jutalek;
    document.getElementById("allinformszolgaltatasar").value = ar;
    document.getElementById("allinformCikk_id").value = cikk_datas.getAttribute('data-cikkid');
    document.getElementById("allinformaru_AFA").value = afa;
    document.getElementById("allinformaru_afakulcs").value = afakulcs;
    document.getElementById("allinformaru_eladasdb").value = db;
    document.getElementById("allinformaru_artam").value = veny_artam;
    document.getElementById("allinformaru_sell_type").value = cikk_datas.getAttribute('data-sell_type');
    
}



function ReadonlyChange(id){
var readonly = document.getElementById(id).disabled;

console.log ("readonly cahange ID:", id, readonly);


    if (readonly === true){
        document.getElementById(id).disabled = false;
     
    }else{
        document.getElementById(id).disabled = true;
    }
}

function ClicktoKeszletAr(id) {
  
  console.log ("ClicktoKeszletAr:", id);  
  document.getElementById(id).click();
 
}