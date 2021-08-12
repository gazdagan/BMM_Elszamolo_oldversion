<?PHP

/**
 * Kiválasztott telephely teljes napi forgama minden rögzített adattal
 * összesítő
 * napi összespaciens
 * kp kivétek
 * átvett szálák
 * 
 */
include_once ("./includes/NapiellenorzolistaClass.php");

$userselect = new User_Select_NapiOsszesito;
$szamla =  new Szamla_befogadasClass;

         echo '<div class="">';
            
            echo $userselect ->user_select_napi_all_bevetelektipusok();
           
            echo $userselect ->user_select_kpkivet_all_table();
            echo '<div class="container">';
            echo $szamla ->Visualize_All_Szamla_Table_User("napiosszes");
            echo '</div>';
            echo $userselect ->user_select_napi_all_table_v2();
         echo '</div>';
         echo '<div id="ellenorzolista" s class="container">';
         
        $checklist = new NapiellenorzolistaClass();
         echo  $checklist->ellenorzolistaCSS();
         echo  $checklist->ellenorzolista();
         echo  $checklist->muszakatatdas();
         echo '</div>';
echo '<script>
function StartPrtintPage(){
    document.getElementById("HiddenIfPrint").style.display = "none"; 
     $(".hideIfPrint").hide();
     window.print();
}';   

echo'</script>';         
?>