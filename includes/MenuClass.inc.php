<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menuclass
 * Menüket megjelenítő osztály 
 * @author Andras
 */
class visualize_menu {
    
    private $realname = "";
    
    public function __construct() {
        $this->realname = $_SESSION['real_name'];
    }

    function usermenu($usertype) {
        // <button class="btn btn-danger navbar-btn" data-toggle="modal" data-target="#myModal" >Rendelő kiválasztás!</button>   
        echo '<nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container-fluid">
                                                
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>                        
                        </button>

                        <a class="navbar-brand" href="./index.php?pid=page10" data-toggle="tooltip" data-placement="bottom" title="Mai napon a kiválasztot rendelőben felvett betegek listája." id = "select_telehely">' . $_SESSION['set_telephely'] . '</a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        
                        <li><a href="./index.php?pid=page26" data-toggle="tooltip" title="uj páciens érkezett">Új páciens</a></li>
                                                
                        <li class="hidden">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Bérlet - BMM kártya<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="./index.php?pid=page21" data-toggle="tooltip" data-placement="bottom" title="Gyógytorna masszázs bérletek.">Bérlet</a></li>
                                    <li><a href="./index.php?pid=page40" data-toggle="tooltip" data-placement="bottom" title="BMM ügyfélkártya kezelése">BMM ügyfélkártya</a></li>
                                </ul>
                        </li>  

                        
                        <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Kp - Számla 
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="./index.php?pid=page20" data-toggle="tooltip" data-placement="bottom" title="Készpénz kivét rögzítése">Kp kivét - számla</a></li>
                                    <li><a href="./index.php?pid=page22" data-toggle="tooltip" data-placement="bottom" title="Orvos kezelő jutalé egyéb számal átvétele">Átutalásos számlák</a></li>
                                    <li class=""><a href="./index.php?pid=page29" data-toggle="tooltip" title="Kezelők, orvosok napi tételes jutaléka." >Jutalék</a></li>
                                    <li class=""><a href="./index.php?pid=page2034" data-toggle="tooltip" title="Készlet mozgatása a rendelők között" >Készlet mozgatás</a></li>
                                </ul>
                        </li>    
              
                        <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Törlés
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li class=""><a href="./index.php?pid=page12" data-toggle="tooltip" title="Pácens törlése a mai napi listából a kiválasztott rendelőből.">Páciens törlés</a></li>                       
                                    <li><a href="./index.php?pid=page23" data-toggle="tooltip" title="Bérlet törlése.">Bérlet törlés</a></li>
                                    <li><a href="./index.php?pid=page24" data-toggle="tooltip" title="Napi kp kivet törlése.">Készpénz kivét törlése</a></li>
                                    <li><a href="./index.php?pid=page25" data-toggle="tooltip" title="Átvett számlák törlése.">Átvett számla törlése</a></li>
                                </ul>
                        </li>
                                               
                        <li><a href="./index.php?pid=page17" data-toggle="tooltip" data-placement="bottom" title="Napon belüli átadás elszámolás">Átadás</a></li>
                        <li><a href="./index.php?pid=page28" data-toggle="tooltip" data-placement="bottom" title="Napi végi összesített a kivélasztott rendelőben">Napi összesítő</a></li>
                        
                        <li class = "dropdown">
                                <a class = "dropdown-toggle" data-toggle = "dropdown" href = "#">Házi pénztár
                                    <span class = "caret"></span></a>
                                <ul class = "dropdown-menu">
                                    <li><a href = "./index.php?pid=page31" data-toggle = "tooltip" title = " Pénztárgép napi elszámolás formanyomtatvány nyomtatása">1 - Pénztárgép napi elszámolása</a></li>
                                    <li><a href = "./index.php?pid=page33" data-toggle = "tooltip" title = "Bevételi pénztárbizonylat formanyomtatvány nyomtatása.">2 - Bevételi pénztárbizonylat</a></li>
                                    <li><a href = "./index.php?pid=page32" data-toggle = "tooltip" title = "Kiadási pénztárbizonylat formanyomtatvány nyomtatása.">3 - Kiadási pénztárbizonylat</a></li>
                                    <li><a href = "./index.php?pid=page36" data-toggle = "tooltip" title = "Pénztárbizonylatok idöszaki összesítése">4 - Időszaki pénztárjelentés</a></li>
                                    <li><a href = "./index.php?pid=page37" data-toggle = "tooltip" title = "Rendelő bizonylatainka éves listája">5 - Rendelő pénztárbizonylatai</a></li>
                                   
                                </ul>
                        </li>';

        if ($usertype == "admin" ) {
             echo   '<li><a href="./index.php?pid=page2032" data-toggle="tooltip" title="uj páciens érkezett">Készlet nyilvántartás</a></li>';
             
        }
        if ($usertype == "superadmin") {
            echo '<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Adatbevitel
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="./index.php?pid=page80">Orvosok Kezelők</a></li>
                                <li><a href="./index.php?pid=page81">Szolgáltatások</a></li>
                                <li><a href="./index.php?pid=page86">Árak Jutalékok</a></li>
                                <li><a href="./index.php?pid=page83">Egészségpénztárak</a></li>
                                <li><a href="./index.php?pid=page84">Telephelyek</a></li>
                                <li><a href="./index.php?pid=page85">Felhasználók</a></li>
                                <li><a href="./index.php?pid=page95" data-toggle="tooltip" data-placement="bottom" title="páciens tetszőleges időpontra történő rögzítése">Pótrögzítés</a></li>

                            </ul>
                        </li>';
            echo '<li class="dropdown">
                               <a class="dropdown-toggle" data-toggle="dropdown" href="#">Riportok
                                   <span class="caret"></span></a>
                               <ul class="dropdown-menu">
                                   <li><a href="./index.php?pid=page90" data-toggle="tooltip" data-placement="bottom" title="időszaki forgalom lekérdezése">Időszaki összesítés</a></li>
                                   <li><a href="./index.php?pid=page91" data-toggle="tooltip" data-placement="bottom" title="2018 havi orvos kezelo jutalékok táblázata">Orvos, kezelo havi jutalékok</a></li>
                                   <li><a href="./index.php?pid=page92" data-toggle="tooltip" data-placement="bottom" title="2018 havi orvos, kezelo bevételek összesen táblázatban">Orvos, kezelo havi bevételek</a></li>
                                   <li><a href="./index.php?pid=page93" data-toggle="tooltip" data-placement="bottom" title="Időszaki orvos, kezelo jutaléklista">Jutalékelszámolás könyveléshez</a></li>
                                   <li><a href="./index.php?pid=page94">Rendelők napi forgalma</a></li>
                                   <li><a href="./index.php?pid=page96">1 - telephelyi netto </a></li>
                                   <li><a href="./index.php?pid=page97">2 - orvos kezelo netto</a></li>
                                   <li><a href="./index.php?pid=page98">3 - orvos kezelo allin</a></li>
                                   <li><a href="./index.php?pid=page87">4 - Medical Plus forgalom</a></li>
                                   <li><a href="./index.php?pid=page79">5 - Postázandók számlák</a></li>
                                   <li><a href="./index.php?pid=page78">6 - Átutalásos számlaképek</a></li>
                                   <li><a href="./index.php?pid=page77">7 - Gyógytornászok riport</a></li>
                                   <li><a href="./index.php?pid=page76">8 - Pénztárgép napi elszámolásai</a></li> 
                                   <li><a href="./index.php?pid=page799">9 - Vényes értékesítés</a></li> 
                                   <li><a href="./index.php?pid=page798">10 - Alapvizsg / konroll DR</a></li>';
                                   
                                   if ($this->realname == 'Bmm elszámoló sua' OR  $this->realname == 'Bence' OR $this->realname == "Moravcsik Miklós"){
                                       
                                    echo    '<li><a href="./index.php?pid=page74">Kp partnerek havi riport</a></li>';
                                                                     
                                   }


                        echo  '</ul>
                           </li>';
             echo '<li class="dropdown">
                               <a class="dropdown-toggle" data-toggle="dropdown" href="#">Iroda
                                   <span class="caret"></span></a>
                               <ul class="dropdown-menu">
                                   <li><a href="./index.php?pid=page200" data-toggle="tooltip" data-placement="bottom" title="Egyéb számlák feltöltése IRODÁBA.">Számlák feltöltése</a></li>
                                   <li><a href="./index.php?pid=page201" data-toggle="tooltip" data-placement="bottom" title="Irásos napi jelentések visszakeresése.">Napi irott Jelentések</a></li>
                                   <li><a href="./index.php?pid=page202" data-toggle="tooltip" data-placement="bottom" title="Hírlevelek közzététele szerkesztése.">Meeting anyagok készítése</a></li>
                                   <li><a href="./index.php?pid=page203" data-toggle="tooltip" data-placement="bottom" title="Dolgozók munkaidő nyilvántartása">Munkaidő nyilvántartás</a></li>
                                   <li><a href="./index.php?pid=page2032" data-toggle="tooltip" data-placement="bottom" title="Gyógyászati segédeszközök nyilvántartása">Készletnyilvántartás</a></li>
                                   <li><a href="./index.php?pid=page2035" data-toggle="tooltip" data-placement="bottom" title="Bejövő költség számlák nyilvántartása">Bejövő számlák nyilvántartása</a></li>
                               </ul>
                           </li>';
            
        }

        echo '</ul>';
        // jobb ldali menü
        echo'<ul class="nav navbar-nav navbar-right">';

        if ($usertype == "admin" OR $usertype == "superadmin") {
            echo '<li class="active"><a href="#" data-toggle="modal" data-target="#myModal" >Rendelők:  ' .
            '<span class="glyphicon glyphicon-home"></span>  ' . $_SESSION['set_telephely'] . '</a></li>';
        }

        echo'<li><a href="#">';
        echo'<div id="loginname">' . $_SESSION['real_name'].'</div>';
        echo'</a></li>
                        <li><a href="./index.php?pid=page99"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    </ul>
                    </div>
                </div>
            </nav> ';
        $this::echoModals();

        /*
          Régebbi lenyíló menü tartalam
          <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Új páciens
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li class=""><a href="./index.php?pid=page11&kezelo=orvos" data-toggle="tooltip" title="Új páciens rögzítése a mai napra a kiválasztott rendelőbe.">Orovshoz rendelésre</a></li>
          <li class=""><a href="./index.php?pid=page11&kezelo=terapeuta" data-toggle="tooltip" title="Új páciens rögzítése a mai napra a kiválasztott rendelőbe.">Terapeutához kezelésrte</a></li>
          <li class=""><a href="./index.php?pid=page21" data-toggle="tooltip" title="Gyógytorna masszázs bérlet kezelése." title="Eladott bérletek kezelése.">Bérletes kezelésre</a></li>
          <li class=""><a href="./index.php?pid=page19" data-toggle="tooltip" title="Medical Plus gyógyászati segédeszköz">Medical Pulsz segédeszközök</a></li>
          <li class=""><a href="./index.php?pid=page26" data-toggle="tooltip" title="uj páciens érkezett">Új páciens</a></li>
          </ul>
          </li>

          <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Napi bevétel összesítők
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="./index.php?pid=page13">Medport Kft - Szamlák</a></li>
          <li><a href="./index.php?pid=page14">Medport Kft - Bevételek</a></li>
          <li><a href="./index.php?pid=page15">Medport Kft - Jutalék elszámolás</a></li>
          <li><a href="./index.php?pid=page16">Medical Plus - Összesítő</a></li>
          </ul>
          </li>
         * 

         * 
         * <li><a href="./index.php?pid=page82">Bevétel tipusok</a></li>
         *          */



//put your code here
    }
// morvosok jutalékelszámolás egyedi menüje 
    function jutalkos_menu(){
        
      $html= "";
        
      $html .=   '<nav class="navbar navbar-default">
                    <div class="container-fluid">
                      <div class="navbar-header">
                        <a class="navbar-brand" href="#">BMM jutalék elszámolás</a>
                      </div>';
       $html .=   '<form class="navbar-form navbar-left" action="' . $_SERVER["PHP_SELF"] . '?pid=page931" method="POST" >
                        <div class="form-group">
                          <label>Összesítés hónapja : </label>
                          <input type="month" class="form-control" name="jutalek_month" value="'.date("Y-m").'">
                              
                         <div class="form-group">
                            <label for="sel1">Vevő:</label>
                            <select class="form-control" name="szamla_vevo">
                              <option  value="medportkft" selected>Medport Kft. (Budafoki, Pannónia)</option>
                              <option value="medicalpluskft" >Medical Plusz Kft. (Óbuda)</option>
                             
                            </select>
                          </div>
                          

                          <input type="hidden" name = "select_terapeuta"  value="'. $_SESSION['real_name'].'" >
                          <input type="hidden" name = "jutaleklista_tipus" value="all_jutalek" >    
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-question-circle-o" aria-hidden="true"></i> Lekérdezés kiválasztott hónapra </button>
                           
                        </div>    
                      </form>
                    ';
       $html .= '<form class="navbar-form navbar-left" action="' . $_SERVER["PHP_SELF"] . '?pid=page931" method="POST" ><div class="form-group"> '
                    . '<button type = "submit" class = "btn btn-primary" onclick=""><i class="fa fa-calendar-o" aria-hidden="true"></i> Mai napi jutalékelszámolás</button>'
                     .'   <input type="hidden" class="form-control" name="jutalek_day" value="'.date("Y-m-d").'">
                          <input type="hidden" name = "select_terapeuta"  value="'. $_SESSION['real_name'].'" >
                          <input type="hidden" name = "jutaleklista_tipus" value="all_jutalek" >    ' 
               . '</div></form>'; 
      $html .= ' <div class="navbar-form navbar-left"><button type = "button" class = "btn btn-info" onclick="StartPrtintJutalekPage()"><i class="fa fa-print" aria-hidden="true"></i> Nyomtatás</button></div>';
      $html .=  '<ul class="nav navbar-nav navbar-right">';

                $html .= '<li>';
                $html .= '<div id="loginname"> <a class="navbar-brand" href="#">' . $_SESSION['real_name'].'</a></div>';
                $html .= '</li>
                                <li><a href="./index.php?pid=page99"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                         </ul> 
               </div></nav>';
        
        return $html;
    }
    
    
    function include_partials() {

        echo '<div id="content_Container" style="margin-top:5.5em;">';
        $pageid = "page10";


        if (isset($_GET['pid'])) {

            $pageid = $_GET['pid'];
        }
        switch ($pageid) {
            case "page10":
                //include ("./partials/user/telephelyselect.php");
               if ($_SESSION['type_user'] != "jutalek"){
                include ("./partials/user/napi_riport.php");
               }
                break;
            case "page11":
                include ("./partials/user/insertdata.php");
                break;
            case "page12":
                include ("./partials/user/deleterow.php");
                break;
            case "page13":
                include ("./partials/user/selectmedportszamlak.php");
                break;
            case "page14":
                include ("./partials/user/selectbevetelek.php");
                break;
            case "page15":
                include ("./partials/user/jutalekelszamolas.php");
                break;
            case "page16":
                include ("./partials/user/medicalplusbevetelek.php");
                break;
            case "page17":
                include ("./partials/user/atadas.php");
                break;
            case "page18":
                include ("./partials/user/napi_zaras.php");
                break;
            case "page19":
                include ("./partials/user/segedeszkozeladas.php");
                break;
            case "page20":
                include ("./partials/user/kp_kivet.php");
                break;
            case "page21":
                include ("./partials/user/berletkezeles.php");
                break;
            case "page22":
                include ("./partials/user/szamla_befogadas.php");
                break;
            case "page23":
                include ("./partials/user/berlet_torles.php");
                break;
            case "page24":
                include ("./partials/user/kpkivet_torles.php");
                break;
            case "page25":
                include ("./partials/user/szamla_torles.php");
                break;
            case "page26":
                include ("./partials/user/allin_form_napielsz.php");
                break;
            case "page27":
                include ("./partials/user/print_atadas.php");
                break;
            case "page28":
                include ("./partials/user/napi_ossesíto.php");
                break;
            case "page29":
                include ("./partials/user/orvos_napijutalek.php");
                break;
            case "page30":
                include ("./partials/user/orvos_napijutalek_allfunction.php");
                break;
            
            case "page33":
                include ("./partials/user/beveteli_pbiz.php");
                break;
            case "page32":
                include ("./partials/user/kiadasi_pb_hazip.php");
                break;
            case "page31":
                include ("./partials/user/penztargep_napi_elsz.php");
                break;
            case "page34":
                include ("./partials/admin/javitas_pb_hazip.php");
                break;
            case "page35":
                include ("./partials/admin/javitas_pb_hazip_form.php");
                break;
            case "page36":
                include ("./partials/user/idoszaki_penztarjelentes.php");
                break;
            case "page37":
                include ("./partials/user/pentarbiz_eveslista.php");
                break;
            case "page40":
                include ("./partials/user/ugyfelkartya.php");
                break;
            
            
            
            
            case "page74":
                include ("./partials/admin/kppartner_riort.php");
                break;
            case "page75":
                include ("./partials/admin/pgnapi_elszamolas_view.php");
                break;
            case "page76":
                include ("./partials/admin/pgnapi_elszamolas.php");
                break; 
            case "page77":
                include ("./partials/admin/gyogytornasz_riport.php");
                break;  
            case "page78":
                include ("./partials/admin/szamlakep_kereses.php");
                break;  
            case "page79":
                include ("./partials/admin/postazott_szamlak.php");
                break;    
            case "page80":
                include ("./partials/admin/orvosok_kezelok.php");
                break;
            case "page81":
                include ("./partials/admin/szolgaltatasok.php");
                break;
            case "page82":
                include ("./partials/admin/bevetel_tipusok.php");
                break;
            case "page83":
                include ("./partials/admin/egeszsegpenztarak.php");
                break;
            case "page84":
                include ("./partials/admin/telephelyek.php");
                break;
            case "page85":
                include ("./partials/admin/users.php");
                break;
            case "page86":
                include ("./partials/admin/arakjutalek.php");
                break;
            case "page90":
                include ("./partials/admin/idoszakiosszesito.php");
                break;
            case "page91":
                include ("./partials/admin/havijutalekkifiz.php");
                break;
            case "page92":
                include ("./partials/admin/havibevetelek.php");
                break;
            case "page93":
                include ("./partials/admin/jutalekelszamolaskonyveles.php");
                break;
             case "page931":
                include ("./partials/user/jutalekorvosnak.php");
                break;
            case "page94":
                include ("./partials/admin/rendeloknapiriport.php");
                break;
            case "page95":
                include ("./partials/admin/potrogzites.php");
                break;
            case "page96":
                include ("./partials/admin/1_telepehlyi_netto.php");
                break;
            case "page97":
                include ("./partials/admin/2_orvos_kezelo_netto.php");
                break;
            case "page98":
                include ("./partials/admin/3_orvos_kezelo_allin.php");
                break;
            case "page87":
                include ("./partials/admin/MedicalPlusForgalom.php");
                break;
            
            
            
            
            
            case "page99":
                include ("./partials/Logout.php");
                break;
            case "page100":
                include ("./partials/admin/read_user_log.php");
                break;
            
            // email riportok
            case "page101":
                include ("./includes/sendmail.php");
                break;
            case "page102":
                include ("./includes/send_email_report.php");
                break;
            
            //irodai funkciók
            case "page200":
                include ("./partials/admin/uploadszamlakep.php");
                break;
            case "page201":
                include ("./partials/admin/NapIrasosJelenetes.php");
                break;
            case "page202":
                include ("./partials/admin/Hirlevelek.php");
                break;
            case "page203":
                include ("./partials/admin/Munkaido.php");
                break;
            case "page2031":
                include ("./partials/user/munkaido_haviosszesites.php");
                break;
             case "page2032":
                include ("./partials/admin/keszlet_nyilvantartas.php");
                break;
            case "page2033":
                include ("./partials/admin/munkaido_konyveloexport.php");
                break;
            case "page2034":
                include ("./partials/user/keszletmozgatas_rendelok_kozott.php");
                break;
                  
            
            case "page2035":
                include ("./partials/admin/bejovoktgszamlak.php");
                break;
            
            
            case "page799":
                include ("./partials/admin/venyes_eladas.php");
                break;
            case "page798":
                include ("./partials/admin/alap_kotroll_db.php");
                break;
            
            default:
                include ("index.php");
        }
        echo '</div>';
    }
    
     function include_partials_jutalekosorvos() {

        echo '<div id="content_Container" style="margin-top:5.5em;">';
        $pageid = "page931";


        if (isset($_GET['pid'])) {

            $pageid = $_GET['pid'];
        }
        switch ($pageid) {
           
            case "page931":
                include ("./partials/user/jutalekorvosnak.php");
                break;
          
            case "page99":
                include ("./partials/Logout.php");
                break;
            case "page100":
                include ("./partials/admin/read_user_log.php");
                break;
        
      
            default:
                include ("index.php");
        }
        echo '</div>';
    }

    function echoModals() {
        // rendelö kiválasztás mpodális ablak
        echo'
        <!--Modal -->
        <div id = "myModal" class = "modal fade" role = "dialog">
            <div class = "modal-dialog">

                <!--Modal content-->
                <div class = "modal-content">
                <div class = "modal-header">
                <button type = "button" class = "close" data-dismiss = "modal">&times;
                </button>
                <h4 class = "modal-title">Telephely kiválasztása</h4>
                </div>
                <div class = "modal-body">
                <p>BMM telephelyek</p>
                <form method="post" action="' . $_SERVER["PHP_SELF"] . '">';

        echo'<select class = "form-control" name = "telephely">';
        $conn = DbConnect();
        $sql = "SELECT * FROM telephelyek";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["telephely_neve"] . '">' . $row["telephely_neve"] . '</option>';
            }
        } else {
            echo "0 results";
        }
        echo '</select><br>';
        echo '<button type="submit"  class="btn btn-info">Kiválaszt</button>';
        echo '</form>    
                </div>
                <div class = "modal-footer">
                <button type = "button" class = "btn btn-default" data-dismiss = "modal">Close</button>
                </div>
                </div>

            </div>
        </div>';
    }

 
    
    
}

?>