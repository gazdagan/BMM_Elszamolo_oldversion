/* 
 * Pénztárgép napi elszámolás táblát kezeló js kódók
 * 
 */

//napi forgalom összesítése
function sum_napi_forg(){
   
    var afa5 =  document.getElementById("afa5").value;
    var afa27 = document.getElementById("afa27").value;
    var TAM =  document.getElementById("TAM").value;
    
  
    
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
