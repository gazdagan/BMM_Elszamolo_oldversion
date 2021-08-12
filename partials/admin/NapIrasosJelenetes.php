<?php

/* 
 *Napi írásos jelentések visszakeresése form + view
 */
//include ( "./includes/Inputvalidation.inc.php");
include ("./includes/NapiIrasosJelentesClass.php");

//echo '<script>';
//include ("./js/ajax.js");
//include ("./js/napijelentes.js");
//echo '</script>';

 $jelentes = new NapiIrasosJelentesClass();
 echo '<div id="HiddenIfPrint">';
 echo $jelentes->NapiJelentesSearchForm();
 echo '</div>';
 echo '<div class="container">';
 echo $jelentes->NapiJelentesQuery();
 echo '</div>';

echo '<script>
function StartPrtintPage(){
    document.getElementById("HiddenIfPrint").style.display = "none"; 
    $(".HideIfPrint").hide();
    window.print();
}';
echo'</script>';   