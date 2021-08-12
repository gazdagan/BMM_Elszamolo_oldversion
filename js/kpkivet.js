/**
 * Készpénz kivét 
 * kezelő jutalék kiszámítása  formba visszatöltése
 * 
 */


function kezelo_jutalek(kezelo_neve,telephely){
    
    if (document.getElementById("kifizetes_oka").value === "Jutalék"){

        if (kezelo_neve.length === 0) {
        //document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("kp_kivet_osszeg").value= this.responseText;
                    document.getElementById("kp_kivet_osszeg").readOnly = true;
                    document.getElementById("kp_kivet_osszeg").placehoder = "";
                }
            };
            xmlhttp.open("GET", "./PostGetAjax/get_kpkivet.php?kivet_kezelo=" + kezelo_neve+"&telephely="+telephely, true);
            xmlhttp.send();
        }

    }else{

        document.getElementById("kp_kivet_osszeg").readOnly = false;
        document.getElementById("kp_kivet_osszeg").value = 0;
        document.getElementById("kp_kivet_osszeg").placehoder = "";

    }

}

function kp_kivetoka(){



}



