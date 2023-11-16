<?php

require_once "../system/function.php";

if(@$_SESSION['login'] != @sha1(md5(IP().$bcode))){
    go(site);
}

if($_POST){
    $title = post('title');
    $content = post('content');
    $status  = post('status');
    $adressid = post('adressid');

    if(!$title || !$content || !$status || !$adressid){
        echo "empty";
    }else{
        
        $result = $db->prepare("UPDATE bayi_adresler SET
            adresbaslik=:s,
            adrestarif=:t,
            adresdurum=:d WHERE adresbayi=:kod AND id=:id
        ");
        $result->execute([
            ':s' => $title,
            ':t' => $content,
            ':d' => $status,
            ':kod' => $bcode,
            ':id' => $adressid
        ]);

        if($result){

            $log = $db->prepare("INSERT INTO bayilog SET logbayi=:b, logip=:i, logdesc=:d");
            $log->execute([":b"  => $bcode,":i" => IP(),":d"  => "Adres güncelledi"]);

            echo "ok";
        }else{
            echo "error";
        }

        }
    }
?>