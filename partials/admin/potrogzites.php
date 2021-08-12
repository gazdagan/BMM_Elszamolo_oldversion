<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo '<h1> Új páciens rögzítése a megadott dátumra! </h1>
<p class="bg-warning">Kivételes esetben rögzíthető a páciens a mai naptól eltérő időpontra.
Ehhez a páciens kezelésének rögzítése alatti dátummezőben kell kiválasztani az időpontot ahová a rögzítés kerül.</p>';
$maketable = new napi_elszamolas;
$maketable->Visualize_New_Allin_Szolgaltatas_Form('potrogzites');


echo '<script type="text/javascript">';
include ("./js/allinform.js");
echo '</script>';