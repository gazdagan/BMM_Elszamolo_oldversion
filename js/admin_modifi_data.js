/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function edit_db_line(szamla_id){
   console.log("select napi tetel id:" , szamla_id); 
   if ( szamla_id == "") {
        //document.getElementById("berlet_naplo").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("edit_napiadat").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","PostGetAjax/get_napidb_alkalmak.php?napi_tetel_id="+szamla_id,true);
        xmlhttp.send();
    }
   
}

