<?php

/* 
 * Számla átvétel form frontendre
 */

$szamla =  new Szamla_befogadasClass;
$szamla->user_post_szamlabefogadas();
$szamla->VisualizeSzamlaBefogadasForm();
echo '<div class="container">';

echo $szamla->Visualize_All_Szamla_Table_User("napiosszes");
echo '</div>';

echo '<script>
function upload_file_require(){
    
    document.getElementById("fileToUpload").required = true;
    
}        
function upload_file_NOTrequire(){

    document.getElementById("fileToUpload").required = false;
}

</script>';
