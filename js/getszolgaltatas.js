/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function showSzolgaltatas(str) {
    if (str == "") {
        document.getElementById("selectSzolg").innerHTML = "";
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
                document.getElementById("selectSzolg").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getszolgaltatas.php?kezelo_neve="+str,true);
        xmlhttp.send();
    }
}