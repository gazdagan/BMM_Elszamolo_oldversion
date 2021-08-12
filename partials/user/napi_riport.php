<?php

/* 
 * 
 * napi írásos jelentés a rendelőkből amely naponta készül minden rendelőben egy -egy
 */

include ("./includes/NapiIrasosJelentesClass.php");
require './includes/HirlevelClass.php';
require './includes/MunkaidoClass.php';
//require './includes/BMMkartyaClass.php';
echo '<script>';
include ("./js/ajax.js");
include ("./js/napijelentes.js");
include ("./js/hirlevel.js");
include ("./js/munkaido.js");
echo '</script>';
$napiriport = new NapiIrasosJelentesClass;
$hirlevel = new HirlevelClass;
$munkaido = new MunkaidoClass;

echo '<div class="container">';


echo $hirlevel->CheckUnreadedNews();

echo '<ul class="nav nav-tabs">
        <li class="hidden"><a data-toggle="tab" href="#home">Napi jelentés</a></li>
      
        <li class="active"><a data-toggle="tab" href="#menu2">Munkaidő nyilvántartás</a></li>
        <li><a data-toggle="tab" href="#menu4">BMM kártya kezelés</a></li>  
        <li><a data-toggle="tab" href="#menu1">Meeting anyagok</a></li>
       
       

     </ul>';

echo '<div class="tab-content">
        <div id="home" class="tab-pane fade hidden"><br>';
        echo $napiriport->NapiJelentesForm();
          
echo  '</div>
        <div id="menu1" class="tab-pane fade ">';
        echo '<h1>Meeting anyagok</h1><hr>';
        echo $hirlevel->SelectNewsListForUsers();             
echo'   </div>';

echo ' <div id="menu2" class="tab-pane fade in active">';
        echo '<h1>Munkaidő nyilvántartás</h1><a href="./index.php?pid=page2031" syle="float: right;">Havi munkaidő összesítés</a><hr>';
        echo $munkaido->UserReadCard_Form();   
        echo '<div id="munkaido_log"><div class="alert alert-success">Válaszd ki az munkaidő nyivántartás státuszát,<strong> érkezés, távozás </strong> majd olvasd be a BMM kártyádat</div></div>';
          
echo' </div>';

echo ' <div id="menu4" class="tab-pane fade" >';
       
        $paciens_karyta  = new UserClass;
        $paciens_karyta->recepcio_insert_paciens();
        $paciens_karyta->recepcio_delete_user();


        echo '<script>';
        include ("./js/admin_modifi_userdata.js");
        echo '</script>';


        
echo' </div>';


//echo ' <div id="menu3" class="tab-pane fade">';
//        echo '<h1>Telefonhívások</h1><hr>
//        <iframe width="1200" height="900"  src="https://datastudio.google.com/embed/reporting/1FhNK7nLiuag2F5oWsYJoYLaaxixFvU0N/page/PHdf" frameborder="0" style="border:0" allowfullscreen></iframe>';    
//echo' </div>';


echo'  </div>';

//echo '<div class="btn-group">';
//echo '<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#napijelenets">Napi jelentés</button>';
//echo '<button type="button" class="btn btn-warning" data-toggle="collapse" data-target="#hírlevelek">Hírlevelek</button>';
//echo '</div>';
//echo '<hr>';
//echo '<div id="napijelenets" class="collapse in">';
//echo $napiriport->NapiJelentesForm();     
//echo '  </div>';
//echo '<div id="hírlevelek" class="collapse">';
//echo '<h1> BMM Hírlevelek</h1><hr>';
//echo $hirlevel->SelectNewsListForUsers();     
//echo '  </div>';





echo '</div>';