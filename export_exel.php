<?php

/* 
 *Pénztárgép zárás ecpot to exel
 */
include ( "./includes/DbConnect.inc.php");
require_once './includes/HaziPenztarClass.php';

$output = '';
if(isset($_POST["pg_elsz"]))
{
  $pg_elszamolas = new HaziPenztarClass();
  $output .= '<!DOCTYPE html>
        <html>
            <head>
            <meta charset="UTF-8">
                <title>title</title>
            <style type="text/css">
                .ritz .waffle .s10,.ritz .waffle .s9{border-left:none;padding:0 3px}.ritz .waffle .s1,.ritz .waffle .s10,.ritz .waffle .s3,.ritz .waffle .s9{border-bottom:1px SOLID #000;background-color:#fff;text-align:center;font-size:10pt}.ritz .waffle a{color:inherit}.ritz .waffle .s1,.ritz .waffle .s10,.ritz .waffle .s2,.ritz .waffle .s3,.ritz .waffle .s5,.ritz .waffle .s9{color:#000;font-family:Arial;vertical-align:bottom;white-space:nowrap;direction:ltr}.ritz .waffle .s1{padding:0 3px}.ritz .waffle .s9{border-right:none}.ritz .waffle .s3{border-right:1px SOLID #000;padding:0}.ritz .waffle input[type=number]{width:100%;height:100%;text-align:right;border:0}.ritz .waffle input[type=text]{width:100%;height:100%;text-align:center;border:0}.ritz .waffle .s2,.ritz .waffle .s4,.ritz .waffle .s5{border-right:1px SOLID #000;background-color:#fff;font-size:10pt}.ritz .waffle .s5{border-bottom:2px SOLID #000;text-align:center;padding:0 3px}.ritz .waffle .s2{text-align:center;padding:0}.ritz .waffle .s4{text-align:right;color:#000;font-family:Arial;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0 3px}.ritz .waffle .s7,.ritz .waffle .s8{background-color:#fff;text-align:center;color:#000;font-family:Arial;vertical-align:bottom;white-space:nowrap;direction:ltr}.ritz .waffle .s8{border-right:none;font-size:10pt;padding:0 3px}.ritz .waffle .s11,.ritz .waffle .s7{border-right:2px SOLID #000;font-size:10pt}.ritz .waffle .s7{border-bottom:2px SOLID #000;padding:0}.ritz .waffle .s0,.ritz .waffle .s11,.ritz .waffle .s6{background-color:#fff;text-align:center;color:#000;font-family:Arial;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:0 3px}.ritz .waffle .s11{border-bottom:1px SOLID #000}.ritz .waffle .s0{font-size:10pt}.ritz .waffle .s6{border-right:1px SOLID #000;font-size:9pt}
            </style>
        </head>
        <body>
  
                        ';
  
          
          
          $output .= $pg_elszamolas -> Napi_pg_elszamolas_table();;
  
  $output .= '</body></html>';
  
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=bmm_pg_elszamolas.xls');
  
  echo $output;
}