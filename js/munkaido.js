/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function UserCardIsRead(){
  
    var adatok = {
        CardSerialNo : "000000",
        LogTelephely : "",
        LogStatus : ""
       };    
     
    
    adatok.CardSerialNo = document.getElementById("CarSerialNo").value;
   
    document.getElementById("CarSerialNo").value ="";
    
    console.log("munkaidő kártya olvasás :", adatok.CardSerialNo);
    
    adatok.LogTelephely = document.getElementById("LogTelephely").value;
    adatok.LogStatus = document.getElementById("LogStatus").value;
    //új bejegyzés vagy upadte 
    postAjax("./PostGetAjax/post_munkaido.php", adatok, function(data){ console.log(data); 
    
        document.getElementById("cardlog").innerHTML = data; 
    
    });
    setTimeout('',1000);
    UserReadLog(adatok.CardSerialNo);
}

function UserReadLog(ListCardSerialNo){
    
    var adatok = {
        CardSerialNo : "000000",
        
       };  
    
    adatok.CardSerialNo = ListCardSerialNo;
    
    postAjax("./PostGetAjax/post_checkmunkido.php", adatok, function(data){ console.log(data); 
    
        document.getElementById("munkaido_log").innerHTML = data; 
    
    });
    
}

function addXtobox(ID,tavollet_oka,date){
    
    name = document.getElementById("munkavallalo_neve").innerHTML;
    
    var adatok = {
            name : "",
            tavollet_oka : "",
            date : "",
            event:"",
            user:""
           };    
    
    adatok.user = document.getElementById("loginname").innerHTML;

    // addj X -et a kiválasztott mezőbe
    if( 'X' === document.getElementById(ID).innerHTML){
          console.log (ID,tavollet_oka,date,name,'delete');
           // document.getElementById(ID).innerHTML = "";
                adatok.name = name;
                adatok.tavollet_oka = tavollet_oka;
                adatok.date = date;
                adatok.event = 'delete'; 

        postAjax("./PostGetAjax/post_munkaido_tavollet.php", adatok, function(data){ console.log(data); 

                    document.getElementById(ID).innerHTML = "";

                });
         
        }else{
            console.log (ID,tavollet_oka,date,name,'add');
            // új státusz log 
                adatok.name = name;
                adatok.tavollet_oka = tavollet_oka;
                adatok.date = date;
                adatok.event = 'add';

                postAjax("./PostGetAjax/post_munkaido_tavollet.php", adatok, function(data){ console.log(data); 

                    document.getElementById(ID).innerHTML = "X";

                });
        }
  // adatok frissítés a táblázatban
  var hour =0;
  
  var napimunkaora = 8;
  
  if (name === "Stefán Anett" ) {napimunkaora = 6;}
  if (name === "Bíró Virág" ) {napimunkaora = 6;}
  if (name === "Hegyiné S. Nagy Tímea" ) {napimunkaora = 6;}  
  
    switch   (tavollet_oka){
        case "Szabadság":
            hour = document.getElementById("havi_szabi_ora").innerHTML;
                hour = Number(hour);
                if(adatok.event === 'add'){   hour += napimunkaora;}
                if(adatok.event === 'delete'){   hour -= napimunkaora;}
           
            document.getElementById("havi_szabi_ora").innerHTML = hour;
          break;    
        
        case "Egyébtávollét":
            hour = document.getElementById("havi_egyebtavolloet_ora").innerHTML;
                hour = Number(hour);
                if(adatok.event === 'add'){   hour += napimunkaora;}
                if(adatok.event === 'delete'){   hour -= napimunkaora;}
           
            document.getElementById("havi_egyebtavolloet_ora").innerHTML = hour;
        break;
        
        case "Betegállomány":
            hour = document.getElementById("havi_betegallomany_ora").innerHTML;
                hour = Number(hour);
                if(adatok.event === 'add'){   hour += napimunkaora;}
                if(adatok.event === 'delete'){   hour -= napimunkaora;}
           
            document.getElementById("havi_betegallomany_ora").innerHTML = hour;
          break;
  }
    
}

function GetMunkaidoEvents(log_id,date,CardNo,Status){
    
     var adatok = {
            log_id : "",
            date: "",
            CardNo: "",
            Status:"",
           };   
           
    adatok.log_id = log_id;
   
    
    console.log ('napi munaido:',log_id) ; 
    postAjax("./PostGetAjax/post_napimunkidolog.php", adatok, function(data){ console.log(data); 
    
        document.getElementById("napi_munkaido_log").innerHTML = data; 
    
    });
    
}

function modifi_erase_muinkaido_log(eraselog){
    
    
    var adatok = {
            log_id : ""
            
           };   
           
    adatok.log_id = eraselog;
    
    console.log ('napi munaido log törlés:',eraselog) ; 
    postAjax("./PostGetAjax/post_napimunkidolog_toerase.php", adatok, function(data){ console.log(data); 
    
       // document.getElementById("napi_munkaido_log").innerHTML = data; 
    
    });
    
    
}