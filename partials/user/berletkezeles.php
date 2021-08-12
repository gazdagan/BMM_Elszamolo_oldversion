<?php

/* 
 * Bérletek és bérlet alkalmak kezelése
 *Haználatban van 
 * 
 */
$maketable = new BerletClass;
$maketable->Visualize_Check_Berlet_Form();
echo '<div class="container">';
if ($maketable->User_Post_Search_Berlet()){
    
    $maketable->Visualize_Search_Result();
    
}else{
    
echo $maketable->BerletListak();
    
      

$maketable->Visualize_Berlet_Naplo_Modal();
}
echo '</div>';
echo '<script type="text/javascript">';
include ("./js/berlet_alkalmak.js");
include ("./js/ajax.js");

echo '</script>';