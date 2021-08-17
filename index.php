<?php
include ( "./includes/DbConnect.inc.php");
include ( "./includes/Inputvalidation.inc.php");
include ( "./includes/NapiElszClass.inc.php");
include ( "./includes/AuthenticateClass.inc.php");
include ( "./includes/MenuClass.inc.php");
include ( "./includes/TelephelyClass.inc.php");
include ("./includes/Orvosok_kezelokClass.inc.php");
include ("./includes/SzolgaltatasokClass.inc.php");
include ("./includes/Bevetel_tipusokClass.inc.php");
include ("./includes/EgeszesegpenztarakClass.inc.php");
include ("./includes/TelephelyekClass.inc.php");
include ("./includes/UserClass.inc.php");
include ("./includes/Arak_jutalekClass.inc.php");
include ("./includes/BerletClass.php");
include ("./includes/SegedeszkozClass.php");
include ("./includes/User_Select_NapiElszClass.php");
include ("./includes/User_Select_NapiOsszesitoClass.php");
include ("./includes/Keszpenz_kivetClass.php");
include ("./includes/Szamla_befogadasClass.php");
include ("./includes/AdminSelectClass.php");
include ("./includes/SystemlogClass.php");

//setcookie("valid_user", "0", time() + 14400);     // bejelentkezés érvényes ideje 4 óra 
header('Cache-Control: no cache'); //no cache
//session_cache_limiter('private_no_expire'); // works
//session_cache_limiter('public'); // works too
//tes2t//

if (isset($_COOKIE["PHPSESSID"])) {session_id($_COOKIE["PHPSESSID"]);}
session_start();

$lifetime=60*60*4;
setcookie(session_name(),session_id(),time()+$lifetime);

$telephely = new telephely_db;
$telephely->set_telephely();

$user_post = new napi_elszamolas;
$user_post->user_post_insert_db();
$user_post->user_post_delete_db_row();
$user_post->user_post_atadas();     //átadás és napvégi zárás

$admin_post_kezelo = new orvosok_kezelok;
$admin_post_kezelo->admin_post_delete_kezelo();
$admin_post_kezelo->admin_post_insert_kezelo();

$admin_post_szolgaltatas = new szolgaltatasok;
$admin_post_szolgaltatas->admin_post_delete_szolgaltatas();
$admin_post_szolgaltatas->admin_post_insert_szolgaltatas();

$admin_post_bevetel = new bevetel_tipusok;
$admin_post_bevetel->admin_post_delete_beveteltipus();
$admin_post_bevetel->admin_post_insert_beveteltipus();

$admin_post_ep = new egeszsegpenztar;
$admin_post_ep->admin_post_delete_egeszsegpenztar();
$admin_post_ep->admin_post_insert_egeszsegpenztar();

$admin_post_telephely = new telephely;
$admin_post_telephely->admin_post_delete_telephely();
$admin_post_telephely->admin_post_insert_telephely();

$admin_post_action = new UserClass;
$admin_post_action -> admin_post_delete_user();
$admin_post_action -> admin_post_insert_user();
$admin_post_action -> admin_post_userupdate();
$admin_post_action ->recepcio_post_insert_paciens();
$admin_post_action-> recepcio_post_patientupdate();

$arak = new arak_jutalek;
$arak -> admin_post_insert_arak_jutalek();
$arak -> admin_post_delete_arak_jutalek();

$berlet = new BerletClass;
$berlet->User_Post_Search_Berlet();
$berlet->User_Post_Delete_Berlet();
$berlet ->User_Post_New_BerletAlkalom();

$kpkivet = new Keszpenz_kivetClass;
$kpkivet -> User_Post_Kpkivet();
$kpkivet -> User_Post_Delete_Kpkivet();

$szamlabefogdas = new Szamla_befogadasClass;
//$szamlabefogdas->user_post_szamlabefogadas();
$szamlabefogdas->User_Post_Delete_Szamla();

header('Content-Type: text/html; charset=utf-8');
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
        <html lang="hu-HU">
        <title>BMM elszámolás</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">
        
       <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113997404-1"></script>
        
         <link href="includes/summernote/dist/summernote.css" rel="stylesheet">
        <script src="includes/summernote/dist/summernote.js"></script>
        
       
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-113997404-1');
          
          var trackOutboundLink = function(url) {
                ga('send', 'event', 'outbound', 'click', url, {
                  'transport': 'beacon',
                  'hitCallback': function(){document.location = url;}
                });
             }
          
        </script>

        
    </head>
    <body>
        <div id="allContainer">
            <?php
            
            
            
            if (isset($_SESSION['valid_user']) && isset($_COOKIE['valid_user'])) {


                if (isset($_SESSION['type_user'])) {
                    
                    //Admin felhasználó
                    if ($_SESSION['type_user'] == "superadmin") {
                        $makemenu = new visualize_menu;
                        $makemenu->usermenu("superadmin");
                        $makemenu->include_partials();
                    }
                    //Admin felhasználó
                    if ($_SESSION['type_user'] == "admin") {
                        $makemenu = new visualize_menu;
                        $makemenu->usermenu("admin");
                        $makemenu->include_partials();
                    }
                    //User felhasználó
                    if ($_SESSION['type_user'] == "user") {
                        $makemenu = new visualize_menu;
                        $makemenu->usermenu("user");
                        $makemenu->include_partials();
                    }
                    //User - jutaléékelszámoló orvos felhasználó
                    if ($_SESSION['type_user'] == "jutalek") {
                        $makemenu = new visualize_menu;
                        echo $makemenu->jutalkos_menu();
                        $makemenu->include_partials_jutalekosorvos();
                    

                    }
                }
            } else {
                $action = $_SERVER['PHP_SELF'];
                $login = new Authenticate("BMM Napi Elszámolás", $action, "post");
                $login->Validate();
                $login->VisualiseLoginForm();
            }
            ?>  

        </div>

        
        <script>
            <?php
            //include ("./js/allinform.js");
           // include ("./js/berlet_alkalmak.js");
            //include ("./js/kpkivet.js");
            ?>
        </script> 
<!--         <script>

    
     if((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) != -1 ) 
    {
        alert('Opera');
    }
    else if(navigator.userAgent.indexOf("Chrome") != -1 )
    {
        alert('Chrome');
    }
    else if(navigator.userAgent.indexOf("Safari") != -1)
    {
        alert('Safari');
    }
    else if(navigator.userAgent.indexOf("Firefox") != -1 ) 
    {
         alert('Firefox');
    }
    else if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true )) //IF IE > 10
    {
      alert('IE'); 
    }  
    else 
    {
       alert('unknown');
    }
    
    </script>-->
    </body>
</html>
