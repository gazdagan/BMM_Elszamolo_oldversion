/* 
 * utalasos szamlak kezelése utalás dátumámának rögzítése 
 */

/* 
*számlák postázásának rögzítése post 
*/


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

function Utalas(id){
    console.log("postazas: ",id);
    
    var adatok = {
        szamla_id:"",
        event: "add",
        date: ""
       };    
       
    utalas_date = 'utalas_date' + id;
  
    adatok.szamla_id = id;   
    adatok.date = document.getElementById(utalas_date).value;
    
    postAjax("./PostGetAjax/post_utalas.php", adatok, function(data){ console.log(data); });
   
   tabeledate = 'date' + id; 
   
   var d = new Date();
   var y = d.getFullYear();
   var m = d.getMonth()+1;
   if (m < 10) {m = '0' + m;}
   var d = d.getDate();
   
   document.getElementById(id).className = "info";
   document.getElementById(tabeledate).innerHTML = adatok.date;
   

}

function Utalas_torles (id){
    console.log("postazas_torlés: ",id);
    
    var adatok = {
        szamla_id:"",
        event: "erease"
       };    
       
    adatok.szamla_id = id;   
    postAjax("./PostGetAjax/post_utalas.php", adatok, function(data){ console.log(data); });
    
    tabeledate = 'date' + id; 

    document.getElementById(id).className = "warning";
    document.getElementById(tabeledate).innerHTML = "";
           
    // window.location.reload();
}
