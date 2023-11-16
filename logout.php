<?php 
require_once "system/function.php";

if(@$_SESSION['login'] != @sha1(md5(IP().$bcode))){
    go(site);
}

$log = $db->prepare("INSERT INTO bayilog SET logbayi=:b, logip=:i, logdesc=:d");

$log->execute([":b"  => $bcode,":i" => IP(),":d"  => "Çıkış yapıldı"]);

session_destroy();
header('Location:'.site);

?>