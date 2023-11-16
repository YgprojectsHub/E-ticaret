<?php

require_once "../system/function.php";

if(@$_SESSION['login'] != @sha1(md5(IP().$bcode))){
    go(site);
}

if($_POST){
    $cmsg = $_POST['cmsg'];
    $productcode = $_POST['productcode'];

    if(!$cmsg || !$productcode){
        echo "empty";
    }else{
        
        if(strlen($cmsg) < 30){
            echo 'number';
        }
        else{
            $result = $db->prepare("INSERT INTO urun_yorumlar SET
            yorumbayi =:b,
            yorumurun =:t,
            yorumisim =:s,
            yorumicerik =:tt,
            yorumdurum =:n,
            yorumip =:bk
            ");
            $result->execute([
                ':b' => $bcode,
                ':t' => $productcode,
                ':s' => $bname,
                ':tt' => $cmsg,
                ':n' => 1,
                ':bk' => IP()
            ]);

            if($result->rowCount()){

                $log = $db->prepare("INSERT INTO bayilog SET logbayi=:b, logip=:i, logdesc=:d");
                $log->execute([":b"  => $bcode,":i" => IP(),":d"  => $productcode." nolu ürüne yorum yaptı"]);

                echo 'ok';
            }else{
                echo 'error';
            }
        }
    }
}
?>