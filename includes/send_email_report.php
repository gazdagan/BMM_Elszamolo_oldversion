<?php

/* 
 *Napi Jelentés Elküldése eMailként
 */

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

require_once 'DbConnect.inc.php';
require_once 'NapiIrasosJelentesClass.php';
require_once 'SystemlogClass.php';

$fullreport ="";

$jelentes = new NapiIrasosJelentesClass();
$jelentes->date = date ("Y-m-d");
$jelentes->telephely ="BMM";
$jelentes->SelectNapiJelentes();
$fullreport .= '<hr><h1>'.$jelentes->telephely.'</h1>';
$fullreport .= $jelentes->NapiJelentesRiport();

$jelentes->telephely ="Fizio";
$jelentes->SelectNapiJelentes();
$fullreport .= '<hr><h1>'.$jelentes->telephely.'</h1>';
$fullreport .= $jelentes->NapiJelentesRiport();

$jelentes->telephely ="P70";
$jelentes->SelectNapiJelentes();
$fullreport .= '<hr><h1>'.$jelentes->telephely.'</h1>';
$fullreport .= $jelentes->NapiJelentesRiport();

$jelentes->telephely ="P72";
$jelentes->SelectNapiJelentes();
$fullreport .= '<hr><h1>'.$jelentes->telephely.'</h1>';
$fullreport .= $jelentes->NapiJelentesRiport();

$jelentes->telephely ="Óbuda";
$jelentes->SelectNapiJelentes();
$fullreport .= '<hr><h1>'.$jelentes->telephely.'</h1>';
$fullreport .= $jelentes->NapiJelentesRiport();

$jelentes->telephely ="Lábcentrum";
$jelentes->SelectNapiJelentes();
$fullreport .= '<hr><h1>'.$jelentes->telephely.'</h1>';
$fullreport .= $jelentes->NapiJelentesRiport();



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
    $mail->addAddress('gazdagan@gmail.com', 'Gazdag Andras');     // Add a recipient
    $mail->addAddress('gellertmed@gmail.com','Moravcsik Bence Balázs');   
    $mail->addAddress('info@bmm.hu','Gál Barna');  // Name is optional
   //$mail->addAddress('moravcsikmiklos@gmail.com','Moravcsik Miklós');               // Name is optional
   //$mail->addReplyTo('info@example.com', 'Information');
   //$mail->addCC('cc@example.com');
   //$mail->addBCC('bcc@example.com');

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'BMM Elsz Napi Irásos Riport';
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

$log = new SystemlogClass('Napi email Irásos riport',$logtxt);
$log->writelog();