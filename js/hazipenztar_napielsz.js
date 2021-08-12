/* 
 * Pénztárgép napi elszámolás táblát kezeló js kódók
 * 
 */

//napi forgalom összesítése
function sum_napi_forg(){
    
    var afa5=0;
    var afa27=0;
    var TAM =0;
    
    afa5 =  document.getElementById("afa5").value;
    afa27 = document.getElementById("afa27").value;
    TAM =  document.getElementById("TAM").value;
    
    if (afa5 === '') {afa5 = 0;}
    if (afa27 === '') {afa27 = 0;}
    if (TAM === '') {TAM = 0;}
    
    var Napiforg = parseFloat(afa5) + parseFloat(afa27) + parseFloat(TAM); 
    
    console.log ('sum forg',Napiforg );
    document.getElementById("sum_pg_forg").value = Napiforg;
    
    sum_levonasok();
 }
 
 function sum_levonasok(){
    
    var kp_osszes = 0;
    var sum_levonas = 0;
    let hiba = new Array();
    
    var bk_fizetes = document.getElementById("bk_fiz").value;
    var sum_pg_forg =document.getElementById("sum_pg_forg").value;
    var ep_fiz_all = document.getElementById("ep_fiz_all").value;
    
   
          
    hiba[0] = document.getElementById("hiba_1_osszeg").value;
    hiba[1] = document.getElementById("hiba_2_osszeg").value;
    hiba[3] = document.getElementById("hiba_3_osszeg").value;
   
          
    var sum_levonas = parseFloat(hiba[0]) + parseFloat(hiba[1]) + parseFloat(hiba[3]) +  parseFloat(ep_fiz_all) + parseFloat(bk_fizetes) ;
     
    var kp_osszes = parseFloat(sum_pg_forg) - parseFloat(sum_levonas);
   
      
    document.getElementById("sum_levonas").value = sum_levonas; 
    document.getElementById("kp_osszes").value =  parseFloat(kp_osszes); 
   
    console.log (sum_pg_forg,sum_levonas,kp_osszes);

     
 }
 
 function postAjax(url, data, success) {
    
     var params = typeof data == 'string' ? data : Object.keys(data).map(
            function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
        ).join('&');

    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xhr.open('POST', url);
    xhr.onreadystatechange = function() {
        if (xhr.readyState>3 && xhr.status==200) { success(xhr.responseText); 
        
        }
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    return xhr;
}


function getAjax(url, success) {
    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    xhr.open('GET', url);
    xhr.onreadystatechange = function() {
        if (xhr.readyState>3 && xhr.status==200) success(xhr.responseText);
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send();
    return xhr;
}

function StartPrtintPage(tipus){
    
     var adatok = {
        receprios : "error",
        telephely : "error",
        bizonylat_nev : "nincs név",
        bizonylat_foosszegszam : "0",
        bizonylat_foosszegszoveg : "nincs szoveg",
        bizonylat_melleklet : "",
        bizonylat_kerekites : "",
        bizonylat_osszesen : "",
        bizonylat_adatok : "",
        tipus : "",
        bizonylat_id : "",
        bizonylat_datum : ""
       };    
    
    // form adatbegyüjés 
    var table_datas = "";
    var table = document.getElementById("penztar_bizonylat");
    var rows  = table.getElementsByTagName("TR");
        
    for (tr = 9; tr < rows.length - 3; tr++ ){
        
        for (td = 0; td < 5;td++)
        {
            table_datas += rows[tr].getElementsByTagName("TD")[td].getElementsByTagName("INPUT")[0].value + ",";
             
        }
         
     }
      
    // adatsokaok begyüjtés vége 
      
    adatok.tipus = tipus;
    adatok.receprios = document.getElementById("loginname").innerHTML;
    adatok.telephely = document.getElementById("select_telehely").innerHTML;
    adatok.bizonylat_nev = document.getElementById("bizonylat_nev").value;
    adatok.bizonylat_foosszegszam = document.getElementById("bizonylat_foosszegszam").value;
    adatok.bizonylat_foosszegszoveg = document.getElementById("bizonylat_foosszegszoveg").value;
    adatok.bizonylat_melleklet = document.getElementById("bizonylat_melleklet").value;
    adatok.bizonylat_kerekites = document.getElementById("bizonylat_kerekites").value;
    adatok.bizonylat_osszesen = document.getElementById("bizonylat_osszesen").value;
    adatok.bizonylat_adatok = table_datas;
    adatok.bizonylat_id = document.getElementById("bizonylat_sorszam").innerHTML;
    adatok.bizonylat_datum = document.getElementById("bizonylat_date").value;
    console.log(adatok);
    
    postAjax("./PostGetAjax/post_pbiz.php", adatok, function(data){ console.log(data); });
   
    document.getElementById("HiddenIfPrint").style.display = "none"; 
    $(".hideIfPrint").hide();
    window.print();
    //window.location.assign("index.php");
}  

function EnableWrite(event,id){
    var key = event.which || event.keyCode; 
    //console.log (key);
    //f9 lenyomva
    if (key === 120){   
            document.getElementById(id).readOnly = false;
    }
}

function OnlyPrint(){
   
    document.getElementById("HiddenIfPrint").style.display = "none"; 
    $(".hideIfPrint").hide();
    window.print();
    
}