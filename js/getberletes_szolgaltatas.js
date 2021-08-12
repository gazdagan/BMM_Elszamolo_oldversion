/* 
 * AJAX lekérdezés bérlet szolgáltatások 
 * használaton kívül
 */


function showBerletesSzolgaltatas(str) {
    if (str == "") {
        document.getElementById("selectBerletSzolg").innerHTML = "";
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
                document.getElementById("selectBerletSzolg").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","get_berletes_szolgaltatas.php?kezelo_neve="+str,true);
        xmlhttp.send();
    }
    console.log('xmlhttp-send');
}