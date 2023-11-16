<?php

require_once "../system/function.php";

if(@$_SESSION['login'] != @sha1(md5(IP().$bcode))){
    go(site);
}

if($_POST){
    $hbank = $_POST['hbank'];
    $hdate = $_POST['hdate'];
    $hhours = $_POST['hhours'];
    $hprice = $_POST['hprice'];
    $hdesc = $_POST['hdesc'];

    if(!$hbank || !$hdate || !$hhours || !$hprice || !$hdesc){
        echo "empty";
    }else{
        
        if(!is_numeric($hprice)){
            echo 'number';
        }
        else{
            $result = $db->prepare("INSERT INTO havalebildirim SET
            havalebayi =:b,
            havaletarih =:t,
            havalesaat =:s,
            havaletutar =:tt,
            havalenot =:n,
            banka =:bk,
            havaleip =:i
            ");
            $result->execute([
                ':b' => $bcode,
                ':t' => $hdate,
                ':s' => $hhours,
                ':tt' => $hprice,
                ':n' => $hdesc,
                ':bk' => $hbank,
                ':i'=> IP()
            ]);

            if($result->rowCount()){

                require_once "class.phpmailer.php";
                require_once "class.smtp.php";

                $mail = new PHPMailer();

                $mail->Host = $arow->smtphost;
                $mail->Port = $arow->smtpport;
                $mail->SMTPSecure = $arow->smtpsec;
                $mail->Username = $arow->smtpmail;
                $mail->Password = $arow->smtpsifre;
                $mail->SMTPAuth = true;
                $mail->IsSMTP();

                $mail->AddAddress($arow->smtpkime);

                $mail->From = $arow->smtpmail;
                $mail->FromName = "Yusuf Güngörür | b2b | Havale Bildirim";
                $mail->CharSet = "UTF-8";
                $mail->Subject = "Havale Bildirimi";
                $mailcontent = "
                <p><b>Bayi Kodu:</b>".$bcode."</p>
                <p><b>Tarih:</b>".$hdate."</p>
                <p><b>Saat:</b>".$hhours."</p>
                <p><b>Tutar:</b>".$hprice."</p>
                <p><b>Not:</b>".$hdesc."</p>
                <p><b>IP:</b>".IP()."</p>
                ";

                $mail->MsgHTML($mailcontent);
                $mail->Send();

                $log = $db->prepare("INSERT INTO bayilog SET logbayi=:b, logip=:i, logdesc=:d");
                $log->execute([":b"  => $bcode,":i" => IP(),":d"  => "Yeni havale bildirimi yaptı"]);

                echo 'ok';
            }else{
                echo 'error';
            }
        }
    }
}
?>