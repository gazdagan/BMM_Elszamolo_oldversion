<?php

/* 
 *Napon belüli átadás frontend 
 *
 */
$atadas = new napi_elszamolas;
$userselect = new User_Select_NapiElsz;
$szamla =  new Szamla_befogadasClass;

echo '<div class="container">'
. '<div class="row"  id="HiddenIfPrint">';
  echo '<div class="col-sm-3">';
  echo '</div>';
  echo '<div class="col-sm-6">';
     $atadas ->atadas();
  echo '</div>';
  echo '<div class="col-sm-3">';
  echo '</div>';
 
echo '</div>'; 
$userselect ->user_select_all_bevetelektipusok();

$userselect ->user_select_kpkivet_table();
$szamla ->Visualize_All_Szamla_Table_User("NULL");
$userselect -> user_select_napiadat_table();
echo '</div>';

echo '<script>
function StartPrtintPage(){
    document.getElementById("HiddenIfPrint").style.display = "none"; 
    $(".hideIfPrint").hide();
    //$(".container").css("margin")="10px";
    window.print();
}';   
include ('./js/tablarendezes.js')  ; 

echo'</script>';

?>
