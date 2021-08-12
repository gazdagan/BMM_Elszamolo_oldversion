/* 
 * admin modity user data 
 */


function edit_userdb_line(user_id){
   console.log("select user id:" , user_id); 
   if ( user_id == "") {
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
                document.getElementById("user_datas").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","PostGetAjax/get_userdatas.php?user_id="+user_id,true);
        xmlhttp.send();
    }
   
}

function edit_patinetdb_line(user_id){
   console.log("select user id:" , user_id); 
   if ( user_id == "") {
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
                document.getElementById("user_datas").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","PostGetAjax/get_patientdatas.php?user_id="+user_id,true);
        xmlhttp.send();
    }
   
}