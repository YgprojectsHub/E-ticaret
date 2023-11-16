<?php

require_once "../system/function.php";

if(@$_SESSION['login'] != @sha1(md5(IP().$bcode))){
    go(site);
}

if($_POST){
    $name = post("name");
    $phone = post("phone");
    $note = post("note");
    $address = post("address");
    $payment = post("payment");
    $code = uniqid();

    if($name || $phone || $note || $address || $payment){

        $carttotal = $db->prepare("SELECT SUM(toplamfiyat) as toplam FROM sepet WHERE sepetbayi=:b");
        $carttotal->execute([':b' => $bcode]);
        $carttotalrow = $carttotal->fetch(PDO::FETCH_OBJ); 


        $result = $db->prepare("INSERT INTO siparisler SET
            siparisbayi     =:b,
            siparisisim     =:i,
            siparistel      =:t,
            siparistarih    =:ta,
            siparissaat     =:sa,
            siparisnot      =:note,
            siparistutar    =:sip,
            siparisodeme    =:od,
            sipariskodu     =:code,
            siparisadres    =:ad
        ");

        $result->execute([
            ':b'    => $bcode,
            ':i'    => $name,
            ':t'    => $phone,
            ':ta'   => date('Y-m-d'),
            ':sa'   => date('H:i'),
            ':note' => $note,
            ':sip'  => $carttotalrow->toplam,
            ':od'   => $payment,
            ':code' => $code,
            ':ad'   => $address
        ]);

        if($result->rowCount()){


            $cart = $db->prepare("SELECT * FROM sepet 
            INNER JOIN urunler ON urunler.urunkodu = sepet.sepeturun
            WHERE sepetbayi=:b");
            $cart->execute([':b' => $bcode]);
            if($cart->rowCount()){
                foreach($cart as $ca){

                    $orderproducts = $db->prepare("INSERT INTO siparis_urunler SET

                        sipkodu    =:s,
                        sipurun    =:u,
                        sipbirim   =:b,
                        sipadet    =:a,
                        siptoplam  =:t,
                        sipurunadi =:ua
                    
                    ");

                    $orderproducts->execute([
                        ':s'   => $code,
                        ':u'   => $ca['sepeturun'],
                        ':b'   => $ca['birimfiyat'],
                        ':a'   => $ca['sepetadet'],
                        ':t'   => $ca['toplamfiyat'],
                        ':ua'  => $ca['urunbaslik']
                    ]);
                }
            }

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

            $mail->addAddress($arow->smtpkime);

            $mail->From = $arow->smtpmail;
            $mail->FromName = "Yusuf Güngörür | b2b | Yeni Sipariş Bildirimi";
            $mail->CharSet = "UTF-8";
            $mail->Subject = "Yeni Sipariş";
            $mailcontent = "
            <p><b>Bayi Kodu:</b>".$bcode."</p>
            <p><b>Sipariş Kodu:</b>".$code."</p>
            <p><b>Tutar:</b>".$carttotalrow->toplam."</p>
            <p><b>Tarih:</b>".date('Y-m-d')."</p>
            <p><b>Saat:</b>".date('H:i')."</p>
            <p><b>IP:</b>".IP()."</p>
            ";

            $mail->MsgHTML($mailcontent);
            $mail->Send();

            $log = $db->prepare("INSERT INTO bayilog SET logbayi=:b, logip=:i, logdesc=:d");
            $log->execute([":b"  => $bcode,":i" => IP(),":d"  => $code." nolu ürünü sipariş etti"]);

            $deletecart = $db->prepare("DELETE FROM sepet WHERE sepetbayi=:b");
            $deletecart->execute([':b' => $bcode]);
            echo 'ok';


        }else{
            echo 'error';
            //print_r($result->errorInfo());
        }
    }else{
        echo "empty";
    }
}
?>