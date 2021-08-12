<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

require_once 'DbConnect.inc.php';
require 'EmailreportClass.php';
require_once 'SystemlogClass.php';
//Load composer's autoloader
//require 'vendor/autoload.php';

$date = date("Y-m-d"); // adatkérés dátuma 

//$d=strtotime("2018-02-05");
//$date = date("Y-m-d", $d);


$fullreport = '<h1>Napi adatok'.date("Y-m-d h:i:sa").'</h1>';
$bmmreport = new emailreportClass($date,'BMM');
$bmmreport -> user_select_napi_all_bevetelektipusok();
$bmmreport -> user_select_kpkivet_all_table();
$bmmreport -> Visualize_All_Szamla_Table_User();
$bmmreport -> user_select_napi_all_table_v2();

$fullreport .= $bmmreport->html;

$fizioreport = new emailreportClass($date,'Fizio');
$fizioreport -> user_select_napi_all_bevetelektipusok();
$fizioreport -> user_select_kpkivet_all_table();
$fizioreport -> Visualize_All_Szamla_Table_User();
$fizioreport -> user_select_napi_all_table_v2();

$fullreport .= $fizioreport->html;

$p70report = new emailreportClass($date,'P70');
$p70report -> user_select_napi_all_bevetelektipusok();
$p70report -> user_select_kpkivet_all_table();
$p70report -> Visualize_All_Szamla_Table_User();
$p70report -> user_select_napi_all_table_v2();

$fullreport .= $p70report->html;

$p72report = new emailreportClass($date,'P72');
$p72report -> user_select_napi_all_bevetelektipusok();
$p72report -> user_select_kpkivet_all_table();
$p72report -> Visualize_All_Szamla_Table_User();
$p72report -> user_select_napi_all_table_v2();

$fullreport .=$p72report->html;

$Óboda = new emailreportClass($date,'Óbuda');
$Óboda  -> user_select_napi_all_bevetelektipusok();
$Óboda  -> user_select_kpkivet_all_table();
$Óboda  -> Visualize_All_Szamla_Table_User();
$Óboda -> user_select_napi_all_table_v2();

$fullreport .= $Óboda ->html;

//$Labcentrum = new emailreportClass($date,'Lábcentrum');
//$Labcentrum  -> user_select_napi_all_bevetelektipusok();
//$Labcentrum  -> user_select_kpkivet_all_table();
//$Labcentrum  -> Visualize_All_Szamla_Table_User();
//
//$fullreport .= $Labcentrum ->html;





$mail = new PHPMailer(true);  
//$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.ortopediabuda.hu';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'elsz@ortopediabuda.hu';                 // SMTP username
    $mail->Password = 'YAq123edcxSW';                           // SMTP password
    //$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to 587/465/25

   //Recipients
    $mail->setFrom('elsz@bmm.hu', 'BMM elsz rendszer');
    $mail->addAddress('gazdagan@gmail.com', 'Gazdag An');     // Add a recipient
	$mail->addAddress('gellertmed@gmail.com','Moravcsik Bence Balázs');               // Name is optional
	$mail->addAddress('moravcsikmiklos@gmail.com','Moravcsik Miklós');               // Name is optional
   //$mail->addReplyTo('info@example.com', 'Information');
   //$mail->addCC('cc@example.com');
   //$mail->addBCC('bcc@example.com');

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'BMM Elsz Napi Riport';
    $mail->Body    = $fullreport . '<br><a href="https://elsz.bmm.hu">Bővebb információ az elszámolórendszerben.<a>';
    $mail->AltBody = 'Elszámoló rendszer napi jelentése, sajnos a levelező kliens nem támogatja a HTML megjelenítést. :(';

    $mail->send();
    echo 'Message has been sent: ';
    //email send logolása
    $logtxt = 'Üzenet elküldve.';
               
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    $logtxt = 'Email riport hiba';
    
}

$log = new SystemlogClass('Napi email riport',$logtxt);
$log->writelog();