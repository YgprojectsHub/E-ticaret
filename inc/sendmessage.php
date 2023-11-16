<?php

require_once "../system/function.php";

if($_POST){
    $name = $_POST['con_name'];
    $email = $_POST['con_email'];
    $subject = $_POST['con_subject'];
    $message = $_POST['con_message'];
    
    if(isset($_SESSION['login'])){
        $bcode = $bcode;
    }else{
        $bcode = "Belirtilmemiş";        
    }

    if(!$name || !$email || !$subject || !$message){
        echo "empty";
    }else{
        
        if(strlen($message) < 15){
            echo 'number';
        }
        else{
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                echo 'format';
            }else{
                $newmesg = $db->prepare("INSERT INTO mesajlar SET mesajisim=:mi , mesajposta=:mp , mesajkonu=:mk , mesajicerik=:mic , mesajip=:mip");
                $newmesg->execute([
                    ':mi' => $name,
                    ':mp' => $email,
                    ':mk' => $subject,
                    ':mic' => $message,
                    ':mip' => IP()
                ]);
                if($newmesg->rowCount()){

                    //sendEmail($name, $email, $subject, $message);

                    require_once 'class.phpmailer.php';
                    require_once 'class.smtp.php';
    
                    $mail = new PHPMailer();
                    $mail->Host       = $arow->smtphost;
                    $mail->Port       = $arow->smtpport;
                    $mail->SMTPSecure = $arow->smtpsec;
                    $mail->Username   = $arow->smtpmail;
                    $mail->Password   = $arow->smtpsifre;
                    $mail->SMTPAuth   = true;
                    $mail->IsSMTP();
                    $mail->AddAddress($arow->smtpkime);
    
                    $mail->From       = $arow->smtpmail;
                    $mail->FromName   = "Yavuz Selim | B2B İletişim";
                    $mail->CharSet    = 'UTF-8';
                    $mail->Subject    = $subject;
                    $mailcontent      = "
                    <p><b>Adı:</b>".$name."</p>
                    <p><b>E-posta:</b>".$email."</p>
                    <p><b>Konu:</b>".$subject."</p>
                    <p><b>Mesaj:</b>".$message."</p>
                    <p><b>ip:</b>".IP()."</p>
                    ";
    
                    $mail->MsgHTML($mailcontent);
                    $mail->Send();

                    $log = $db->prepare("INSERT INTO bayilog SET logbayi=:b, logip=:i, logdesc=:d");
                    $log->execute([":b"  => $bcode,":i" => IP(),":d"  => "Yeni mesaj gönderdi"]);
                    echo 'ok';
                }else{
                    echo 'error';
                }
            }
        }
    }
}
?>