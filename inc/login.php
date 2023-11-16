<?php 

require_once "../system/function.php";
if(@$_SESSION['login'] == @sha1(md5(IP().$bcode))){
    go(site);
}

if($_POST){
    $bec = post('bec');
    $bpass = post('bpass');
    $crypto= sha1(md5($bpass));

    if(!$bec ||!$bpass){
        echo "empty";
    }else{
        $login = $db->prepare("SELECT * FROM bayiler WHERE (bayikodu=:k AND bayisifre=:s) OR (bayimail=:m AND bayisifre=:ss)");

        $login->execute([
            ':k' => $bec,
            ':s' => $crypto,
            ':m' => $bec,
            ':ss' => $crypto
        ]);

        if($login->rowCount()){
            $par = $login->fetch(PDO::FETCH_OBJ);
            if($par->bayidurum == 1){

                $log = $db->prepare("INSERT INTO bayilog SET logbayi=:b, logip=:i, logdesc=:d");

                $log->execute([":b"  => $par->bayikodu,":i" => IP(),":d"  => "Giriş yapıldı"]);

                $encode = sha1(md5(IP().$par->bayikodu));
                $_SESSION['login'] = $encode;
                $_SESSION['id']    = $par->id;
                $_SESSION['code']  = $par->bayikodu;

                echo 'ok';

            }else{
                echo "pasivve";
            }
        }
        else{
            echo "error";
        }
    }
}

?>