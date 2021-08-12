/* *
 * bérletekhez tartozó js AJAX 
 * 
 * 
 */

function berlet_felhasznalasok(berlet_id){
   console.log("select berlet alkalmak:" , berlet_id); 
   if (berlet_id == "") {
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
                document.getElementById("berlet_naplo").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","PostGetAjax/get_berlet_alkalmak.php?berlet_id="+berlet_id,true);
        xmlhttp.send();
    }
  
    
}

function berlet_patient_connect(berlet_id){
   console.log("bérlet paciens kapcsolat:" , berlet_id); 
   if (berlet_id == "") {
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
                document.getElementById("berlet_connect").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","PostGetAjax/get_patient_connect_berlet.php?berlet_id="+berlet_id,true);
        xmlhttp.send();
    }
  
    
}
function berlet_patient_list(berlet_id){
   console.log("bérlet paciens kapcsolat:" , berlet_id); 
   if (berlet_id == "") {
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
                document.getElementById("berlet_connect").innerHTML = this.responseText;
            }
        };
        Pacname = document.getElementById("PacName").value;
        AID = document.getElementById("AID").value;
        
        xmlhttp.open("GET","PostGetAjax/get_patient_connect_berlet.php?berlet_id="+berlet_id+"&PacName="+Pacname+"&ArteriaID="+AID,true);
        xmlhttp.send();
    }
  
    
}




function berlet_patient_connect_create(berlet_id,kartya_id){
   console.log("bérlet -> bmmkártya kapcsolat:" , berlet_id, kartya_id); 
   
   //var berlet_id;
   //var kartya_id;
   
    if (berlet_id == "" || kartya_id == "") {
        //document.getElementById("berlet_naplo").innerHTML = "";
        return;
    } else {
     
    var adatok = {
        berlet_id : "nincs",
        kartya_id : "nincs"
      
       };    
     

    adatok.berlet_id = berlet_id;
    adatok.kartya_id = kartya_id;

           
    
    postAjax("./PostGetAjax/post_berlet_kartya_connect.php", adatok, function(data){ console.log(data); });
    }
    location.reload();
  
    
}

function berlet_patient_connect_delete(berlet_id){
   console.log("bérlet -> bmmkártya kapcsolat törlés:" , berlet_id); 
   
   
   
     
    var adatok = {
        berlet_id : "nincs",
        kartya_id : "nincs"
      
       };    
     

    adatok.berlet_id = berlet_id;
    adatok.kartya_id = '';

           
    
    postAjax("./PostGetAjax/post_berlet_kartya_connect.php", adatok, function(data){ console.log(data); });
    location.reload();
  
    
}