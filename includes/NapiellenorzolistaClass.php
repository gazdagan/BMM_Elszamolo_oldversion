<?php


/**
 * Description of NapiellenorzolistaClass
 * Napi ellenorző lista a napi zárás végére kerül kinyomtatásra
 * @author Andras
 */
class NapiellenorzolistaClass {
     
 
    public $rogzito;
    public $telephely;
    public $date;
    public $conn;

    function __construct() {

        if (isset($_SESSION['real_name'])) {

            $this->rogzito = $_SESSION['real_name'];
        } else {
            $this->rogzito = "Error rogzito name";
        }

        if (isset($_SESSION['set_telephely'])) {

            $this->telephely = $_SESSION['set_telephely'];
        } else {
            $this->telephely = "Error telephely";
        }

        $this->date = date("Y-m-d");
        
        $this->conn = DbConnect();
    }

    function __destruct() {
        mysqli_close($this->conn);
    }
    
    
public function ellenorzolista(){ 
    $html="";   
//    <p class="c1"><span class="c2"></span></p>
//    <ul class="c0 lst-kix_list_1-0">
//        <li class="c3"><span class="c2">&hellip;.. db Eg&eacute;szs&eacute;gp&eacute;nzt&aacute;ri sz&aacute;mla, mindegyik az Eg&eacute;szs&eacute;gp&eacute;nzt&aacute;r nev&eacute;re ki&aacute;ll&iacute;tva, tagi azonos&iacute;t&oacute;val ell&aacute;tva</span></li>
//    </ul>
//    <p class="c1"><span class="c2"></span></p>
//    <ul class="c0 lst-kix_list_1-0">
//        <li class="c3"><span class="c2">&hellip;..db Europ Assistance sz&aacute;mla Gener&aacute;li Biztos&iacute;t&oacute; nev&eacute;re ki&aacute;ll&iacute;tva, referencia k&oacute;ddal ell&aacute;tva</span></li>
//    </ul>
//    <p class="c1"><span class="c2"></span></p>
//    <ul class="c0 lst-kix_list_1-0">
//        <li class="c3"><span class="c2">&hellip;. db Teladoc sz&aacute;mla p&aacute;ciens nev&eacute;re ki&aacute;ll&iacute;tva, autoriz&aacute;ci&oacute;s k&oacute;ddal ell&aacute;tva</span></li>
//    </ul>
    $html .='
  <div class="page_break"></div>      
  <div class="c7" styel="">
  <br> <br>
    <p class="c10"><span class="c6">Z&aacute;r&aacute;si ellen&#337;rz&eacute;si seg&eacute;dlet</span></p>
    <p class="c5"><span class="c2"></span></p>
    <ul class="c0 lst-kix_list_1-0 start">
        <li class="c3"><span class="c2">Sz&aacute;ml&aacute;k &hellip;&hellip;&hellip;&hellip;&hellip;2020/&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..-t&oacute;l &hellip;&hellip;&hellip;&hellip;..2020/&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;-ig sorba rendezve, nincs hi&aacute;nyz&oacute; sz&aacute;mla.</span></li>
    </ul>
    <ul class="c0 lst-kix_list_1-0 start">
        <li class="c3"><span class="c2">Sz&aacute;ml&aacute;k  &hellip;&hellip;&hellip;&hellip;&hellip;2020/&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..-t&oacute;l &hellip;&hellip;&hellip;&hellip;..2020/&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;-ig sorba rendezve, nincs hi&aacute;nyz&oacute; sz&aacute;mla.</span></li>
    </ul>
    <p class="c1" id="h.gjdgxs"><span class="c2"></span></p>
    <ul class="c0 lst-kix_list_1-0">
        <li class="c3"><span class="c2">(&hellip;. db hi&aacute;nyz&oacute; sz&aacute;mla van, mert &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..)</span></li>
    </ul>
    <ul class="c0 lst-kix_list_1-0">
        <li class="c3"><span class="c2">&hellip;. db &aacute;tvett sz&aacute;mla, ebb&#337;l &hellip;. db felt&ouml;ltve, telephely k&oacute;d r&aacute;&iacute;rva, term&eacute;kr&#337;l sz&oacute;l&oacute; sz&aacute;ml&aacute;n &bdquo;&Aacute;RU&rdquo; felt&uuml;ntetve</span></li>
    </ul>
   
    <ul class="c0 lst-kix_list_1-0">
        <li class="c3"><span class="c2">&hellip;. db ajánlást a Monday AJÁNLÁS_léc táblába beírtam.</span></li>
    </ul>
    <p class="c1"><span class="c2"></span></p>
    <ul class="c0 lst-kix_list_1-0">
        <li class="c3"><span class="c2">Dr. &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;-t&oacute;l &aacute;tvett napi/havi jutal&eacute;k lista/sz&aacute;mla + mai d&aacute;tum r&aacute;&iacute;rva</span></li>
        <li class="c3"><span class="c2">Dr. &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;-t&oacute;l &aacute;tvett napi/havi jutal&eacute;k lista/sz&aacute;mla + mai d&aacute;tum r&aacute;&iacute;rva</span></li>
        <li class="c3"><span class="c2">Dr. &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;-t&oacute;l &aacute;tvett napi/havi jutal&eacute;k lista/sz&aacute;mla + mai d&aacute;tum r&aacute;&iacute;rva</span></li>
        <li class="c3"><span class="c2">Dr. &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;-t&oacute;l &aacute;tvett napi/havi jutal&eacute;k lista/sz&aacute;mla + mai d&aacute;tum r&aacute;&iacute;rva</span></li>
        <li class="c9"><span class="c2">Dr. &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;-t&oacute;l &aacute;tvett napi/havi jutal&eacute;k lista/sz&aacute;mla + mai d&aacute;tum r&aacute;&iacute;rva</span></li>
    </ul>
    <p class="c1"><span class="c2">Mai napon zárásba került postázandó küldemények:</span></p><br>
    <ul class="c0 lst-kix_list_1-0">
        <li class="c3"><span class="c2">Címzett: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip; Megjegyzés:&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span></li>
        <li class="c3"><span class="c2">Címzett: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip; Megjegyzés:&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span></li>
        <li class="c3"><span class="c2">Címzett: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip; Megjegyzés:&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span></li>
        <li class="c3"><span class="c2">Címzett: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip; Megjegyzés:&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span></li>
    </ul>
    <p class="c5"><span class="c2"></span></p>
    <p class="c10"><span class="c2">A napi z&aacute;r&aacute;st k&eacute;sz&iacute;tette: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.</span></p>
    <p class="c8"><span class="c2">(olvashat&oacute; al&aacute;&iacute;r&aacute;s)</span></p>
    
</div>';    
   return ($html);   
        
        
}           
 
public function ellenorzolistaCSS (){
    $css = "";
    
    $css .= '<style type="text/css">
        
@media print {
  .page_break {page-break-after: auto;}
}

ul.lst-kix_list_1-3 {
	list-style-type: none
}



ul.lst-kix_list_1-4 {
	list-style-type: none
}



ul.lst-kix_list_1-1 {
	list-style-type: none
}

ul.lst-kix_list_1-2 {
	list-style-type: none
}

ul.lst-kix_list_1-7 {
	list-style-type: none
}


ul.lst-kix_list_1-8 {
	list-style-type: none
}

ul.lst-kix_list_1-5 {
	list-style-type: none
}

ul.lst-kix_list_1-6 {
	list-style-type: none
}

ol {
	margin: 0;
	padding: 0
}

table td,
table th {
	padding: 0
}

.c1 {
	margin-left: 36pt;
	padding-top: 0pt;
	text-indent: -36pt;
	padding-bottom: 0pt;
	line-height: 1.0791666666666666;
	orphans: 2;
	widows: 2;
	text-align: left;
	height: 11pt
}

.c9 {
	margin-left: 36pt;
	padding-top: 0pt;
	padding-left: 0pt;
	padding-bottom: 8pt;
	line-height: 1.0791666666666666;
	orphans: 2;
	widows: 2;
	text-align: left
}

.c3 {
	margin-left: 36pt;
	padding-top: 0pt;
	padding-left: 0pt;
	padding-bottom: 0pt;
	line-height: 1.0791666666666666;
	orphans: 2;
	widows: 2;
	text-align: left
}

.c8 {
	margin-left: 70.8pt;
	padding-top: 0pt;
	text-indent: 35.4pt;
	padding-bottom: 8pt;
	line-height: 1.0791666666666666;
	orphans: 2;
	widows: 2;
	text-align: center
}

.c6 {
	color: #000000;
	font-weight: 400;
	text-decoration: none;
	vertical-align: baseline;
	font-size: 24pt;
	font-family: "Times New Roman";
	font-style: normal
}

.c4 {
	color: #000000;
	font-weight: 400;
	text-decoration: none;
	vertical-align: baseline;
	font-size: 14pt;
	font-family: "Times New Roman";
	font-style: normal
}

.c2 {
	color: #000000;
	font-weight: 400;
	text-decoration: none;
	vertical-align: baseline;
	font-size: 14pt;
	font-family: "Times New Roman";
	font-style: normal
}

.c5 {
	padding-top: 0pt;
	padding-bottom: 8pt;
	line-height: 1.0791666666666666;
	orphans: 2;
	widows: 2;
	text-align: left;
	height: 11pt
}

.c10 {
	padding-top: 0pt;
	padding-bottom: 8pt;
	line-height: 1.0791666666666666;
	orphans: 2;
	widows: 2;
	text-align: center
}

.c7 {
	
	padding: 70.8pt 35.4pt 70.8pt 28.4pt
        margin-left: auto;
        margin-right: auto;
}

.c0 {
	padding: 0;
	margin: 0
}

.title {
	padding-top: 24pt;
	color: #000000;
	font-weight: 700;
	font-size: 36pt;
	padding-bottom: 6pt;
	font-family: "Calibri";
	line-height: 1.0791666666666666;
	page-break-after: avoid;
	orphans: 2;
	widows: 2;
	text-align: left
}

.subtitle {
	padding-top: 18pt;
	color: #666666;
	font-size: 24pt;
	padding-bottom: 4pt;
	font-family: "Georgia";
	line-height: 1.0791666666666666;
	page-break-after: avoid;
	font-style: italic;
	orphans: 2;
	widows: 2;
	text-align: left
}

li {
	color: #000000;
	font-size: 14pt;
	font-family: "Calibri"
}

p {
	margin: 0;
	color: #000000;
	font-size: 14pt;
	font-family: "Calibri"
}

h1 {
	padding-top: 24pt;
	color: #000000;
	font-weight: 700;
	font-size: 24pt;
	padding-bottom: 6pt;
	font-family: "Calibri";
	line-height: 1.0791666666666666;
	page-break-after: avoid;
	orphans: 2;
	widows: 2;
	text-align: left
}

h2 {
	padding-top: 18pt;
	color: #000000;
	font-weight: 700;
	font-size: 18pt;
	padding-bottom: 4pt;
	font-family: "Calibri";
	line-height: 1.0791666666666666;
	page-break-after: avoid;
	orphans: 2;
	widows: 2;
	text-align: left
}

h3 {
	padding-top: 14pt;
	color: #000000;
	font-weight: 700;
	font-size: 14pt;
	padding-bottom: 4pt;
	font-family: "Calibri";
	line-height: 1.0791666666666666;
	page-break-after: avoid;
	orphans: 2;
	widows: 2;
	text-align: left
}

h4 {
	padding-top: 12pt;
	color: #000000;
	font-weight: 700;
	font-size: 12pt;
	padding-bottom: 2pt;
	font-family: "Calibri";
	line-height: 1.0791666666666666;
	page-break-after: avoid;
	orphans: 2;
	widows: 2;
	text-align: left
}

h5 {
	padding-top: 11pt;
	color: #000000;
	font-weight: 700;
	font-size: 11pt;
	padding-bottom: 2pt;
	font-family: "Calibri";
	line-height: 1.0791666666666666;
	page-break-after: avoid;
	orphans: 2;
	widows: 2;
	text-align: left
}

h6 {
	padding-top: 10pt;
	color: #000000;
	font-weight: 700;
	font-size: 10pt;
	padding-bottom: 2pt;
	font-family: "Calibri";
	line-height: 1.0791666666666666;
	page-break-after: avoid;
	orphans: 2;
	widows: 2;
	text-align: left
}

</style>';
return ($css);    
    
}
//Barna féle műszakátadás
public function muszakatatdas(){
    $html = '';
//    $html .= $this->muszakatatdas_CSS();
//    $html .=  '<br><p class="c6"><span class="">Napi m&#369;szak&aacute;tad&aacute;si jegyz&eacute;k &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&uacute;t/utca &hellip;&hellip;&hellip;&hellip;<br></span></p>
//      <br><p class="c2"><span class="c1">Bankk&aacute;rtya termin&aacute;l &bdquo;K&ouml;teg &ouml;sszes&iacute;t&#337;&rdquo; v&eacute;g&ouml;sszege: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span></p>
//      <p class="c2"><span class="c1">K&eacute;szp&eacute;nz bev&eacute;tel v&eacute;g&ouml;sszege: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..</span></p>
//      <p class="c2"><span class="c1">Sz&aacute;ml&aacute;k mind megvannak az al&aacute;bbi sorsz&aacute;mmal (-t&oacute;l, -ig.): &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span></p>
//      <p class="c2"><span class="c1">Eg&eacute;szs&eacute;gp&eacute;nzt&aacute;ri sz&aacute;ml&aacute;k &hellip;&hellip;&hellip; db. helyesen ki&aacute;ll&iacute;tva a p&eacute;nzt&aacute;r nev&eacute;re + tag neve &eacute;s azonos&iacute;t&oacute;.</span></p>
//      <p class="c2"><span class="c1">Felt&ouml;lt&ouml;tt biztos&iacute;t&oacute;i igazol&aacute;sok/ambul&aacute;ns lapok:</span></p>
//      <br />';
    $html .=  '<table style="border: solid 1px black;" class="table">
         <thead>
            <tr style="border: solid 1px black;">
               <td style="border: solid 1px black; text-align:center" colspan="1" rowspan="1">
                <b> Páciens neve:</b>
                </td>
               <td style="border: solid 1px black; text-align:center" colspan="1" rowspan="1">
                 <b> Autorizációs kód:</b>
               </td>
               <td style="border: solid 1px black; text-align:center" colspan="1" rowspan="1">
                <b> Biztosító neve:  </b>
               </td>
            </tr></thead>
             <tbody>';
            $html .=  $this->biztositoi_igazolások();
           
    $html .='</tbody>
      </table>';
//     $html .=  ' <p class="c2"><span class="c1"><br>A fenti adatok a val&oacute;s&aacute;gnak megfelelnek, ezt al&aacute;&iacute;r&aacute;sommal igazolom.</span></p>
//     <p class="c2"><span class="c1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span></p>
//      <p class="c2"><span class="c1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &Aacute;tad&oacute;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&Aacute;tvev&#337;</span></p>
//      <br><p class="c2"><span class="c2">2020. &hellip;&hellip;&hellip;&hellip; &nbsp;&hellip;&hellip;&hellip;&hellip;..</span></p>';
    
    return $html;
}

private function muszakatatdas_CSS(){ 
    $html ='';
       

    
   return $html;
}
private function biztositoi_igazolások(){
    $html = '';
    
    $sql = "SELECT * FROM napi_elszamolas where telephely = '$this->telephely' AND date = '$this->date' AND torolt_szamla = '0' AND (bevetel_tipusa_id = 'europe assistance' OR bevetel_tipusa_id = 'TELADOC'  OR bevetel_tipusa_id = 'Union-Érted') ORDER BY paciens_neve ASC ";
    
    $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $html .= '<tr style="border: solid 1px black;">
               <td style="border: solid 1px black;" colspan="1" rowspan="1">
                    '.$row["paciens_neve"].'
               </td>
               <td style="border: solid 1px black;" colspan="1" rowspan="1">
                    '.$row["note"].'
               </td>
               <td style="border: solid 1px black;" colspan="1" rowspan="1">
                    '.$row["bevetel_tipusa_id"].'
               </td>
            </tr>
            ';
            }
          } else {
             $html .= '<tr style="border: solid 1px black;">
               <td style="border: solid 1px black;" colspan="1" rowspan="1">
                   Nincs ilyen páciens
               </td>
               <td style="border: solid 1px black;" colspan="1" rowspan="1">
                   ----
               </td>
               <td style="border: solid 1px black;" colspan="1" rowspan="1">
                    ----               </td>
            </tr>';
          }
        
    return $html;    
   
    
}
        
        
}
