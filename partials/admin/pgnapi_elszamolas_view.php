<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include ("./includes/HaziPenztarClass.php");

if (isset($_POST["pg_zarasid"])){
echo 'Pg zárás vissza:' .$_POST["pg_zarasid"];
}
echo '<style>
    .ritz .waffle a {
	color: inherit;
}

.ritz .waffle .s1 {
	border-bottom: 1px SOLID #000000;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	font-family: "Arial";
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s10 {
        border-bottom: 1px SOLID #000000;
	border-left: none;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	font-family:"Arial";
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s9 {
        border-bottom: 1px SOLID #000000;
	border-left: none;
	border-right: none;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	font-family:"Arial";
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s3 {
	border-bottom: 1px SOLID #000000;
	border-right: 1px SOLID #000000;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	font-family: "Arial";
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 0px 0px 0px;
       
}
.ritz .waffle  input[type=number] {
	width: 100%;
        height: 100%;
        text-align:right;
        border:0px;
}
.ritz .waffle input[type=text] {
	width: 100%;
        height: 100%;
        text-align:center;
        border:0px;
}

.ritz .waffle .s5 {
	border-bottom: 2px SOLID #000000;
	border-right: 1px SOLID #000000;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	font-family: "Arial";
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s2 {
	border-right: 1px SOLID #000000;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	font-family: "Arial";
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 0px 0px 0px;
}

.ritz .waffle .s4 {
	border-right: 1px SOLID #000000;
	background-color: #ffffff;
	text-align: right;
	color: #000000;
	font-family:"Arial";
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s8 {
	border-right: none;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	font-family:"Arial";
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s7 {
	border-bottom: 2px SOLID #000000;
	border-right: 2px SOLID #000000;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	font-family: "Arial";
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 0px 0px 0px;
}

.ritz .waffle .s11 {
	border-bottom: 1px SOLID #000000;
	border-right: 2px SOLID #000000;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	font-family: "Arial";
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s0 {
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	font-family: "Arial";
	font-size: 10pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}

.ritz .waffle .s6 {
	border-right: 1px SOLID #000000;
	background-color: #ffffff;
	text-align: center;
	color: #000000;
	font-family: "Arial";
	font-size: 9pt;
	vertical-align: bottom;
	white-space: nowrap;
	direction: ltr;
	padding: 0px 3px 0px 3px;
}</style>';

$pg_elszamolas = new HaziPenztarClass();
echo '<div class = "container ritz">';
echo '<div id="HiddenIfPrint"><div class="btn-group"><a href="#"onclick="OnlyPrint()" tpye="button" class="btn btn-info" role="button"><i class="fa fa-print" aria-hidden="true"></i> Nyomtat</a>'
. '<a href="#"onclick="sum_napi_forg()" tpye="button" class="btn btn-success" role="button"><i class="fa fa-calculator" aria-hidden="true"></i> Számol</a></div></div>';
//echo '<form method="post" action="export_exel.php"> <input type="submit" name="pg_elsz" class="btn btn-success" value="EXEL" /></form>';

if (isset($_POST["pg_zarasid"])){
    
    $pg_elszamolas -> pg_napizaras_id = $_POST["pg_zarasid"];
    
    echo $pg_elszamolas -> Napi_pg_elszamolas_table();

} else {    echo 'Nincs pénztárgép zárás id megadva!';}

echo '</div>';
echo '<script>';
include './js/hazipenztar_napielsz.js';
echo '</script>';



echo '<script>
function StartPrtintPage(){

    var adatok = {
        zarasszam : "error",
        receprios : "error",
        telephely : "error",
        afa5 : "0",
        afa27 : "0",
        afaTAM : "0",
        hiba1nysz : "",
        hiba1kulcs : "",
        hiba1osszeg : "",
        hiba2nysz : "",
        hiba2kulcs : "",
        hiba2osszeg : "",
        hiba3nysz : "",
        hiba3kulcs : "",
        hiba3osszeg : "",
        kp_osszes : "",
    };    
    
adatok.zarasszam = document.getElementById("pg-zaras-szama").value;
adatok.receprios = document.getElementById("loginname").innerHTML;
adatok.telephely = document.getElementById("select_telehely").innerHTML;
adatok.afa5 = document.getElementById("afa5").value;
adatok.afa27 = document.getElementById("afa27").value;
adatok.afaTAM = document.getElementById("TAM").value;

adatok.hiba1nysz = document.getElementById("hiba_1_txt").value;
adatok.hiba1kulcs = document.getElementById("hiba_1_afa").selectedIndex;
adatok.hiba1osszeg = document.getElementById("hiba_1_osszeg").value;

adatok.hiba2nysz = document.getElementById("hiba_2_txt").value;
adatok.hiba2kulcs = document.getElementById("hiba_2_afa").selectedIndex;
adatok.hiba2osszeg = document.getElementById("hiba_2_osszeg").value;

adatok.hiba3nysz = document.getElementById("hiba_3_txt").value;
adatok.hiba3kulcs = document.getElementById("hiba_3_afa").selectedIndex;
adatok.hiba3osszeg = document.getElementById("hiba_3_osszeg").value;
adatok.kp_osszes = document.getElementById("kp_osszes").value;

postAjax("./PostGetAjax/post_pgdata.php", adatok, function(data){ console.log(data); });
    
    
    document.getElementById("HiddenIfPrint").style.display = "none"; 
    $(".hideIfPrint").hide();
    window.print();
}';   

echo'</script>';    