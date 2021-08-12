<?php

/* 
 * időszaki adatok összesítésa nyomtatható formában
 * 
 * 
 */
echo'<script type="text/javascript">';
require ("./js/copyclipboard.js");
echo'</script>';

echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';


$form = new AdminSelectClass();
$form->admin_post_elszupdate(); 
$form->admin_post_select_query(); //SQL feldolgozása


echo '<div class="">'
. '<div class="row"  id="HiddenIfPrint">';
  echo '<div class="col-sm-4">';
       $form->AdminSelectQueryForm();

  echo '</div>';
  echo '<div class="col-sm-8">';
    
    echo '<div class="col-sm-6" id="DB_chart_div" ></div>';
    echo '<div class="col-sm-6" id="FT_chart_div" ></div>';
   
  echo '</div>';
  
 
echo '</div>'; 
echo '</div>';
echo '<div class="container"><div class="row" >';
  if (   $_SESSION['type_user'] != 'user'){
           $form->admin_osszesített_query();
           $form->draw_double_chart();
          }
echo '</div></div>';
$form->create_table();

echo '<script>';
include ("./js/admin_modifi_data.js");
echo '</script>'






?>