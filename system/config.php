<?php 

session_start();
ob_start("compress");
date_default_timezone_set('Europe/Istanbul');

try{

    $db = new PDO("mysql:host=localhost;dbname=b2b;charset=utf8", "root", "");

}
catch(PDOException $e){
    print_r($e->getMessage());
}

$query = $db->prepare("SELECT * FROM ayarlar LIMIT :lim");
$query->bindValue(":lim",(int) 1,PDO::PARAM_INT);
$query->execute();
if($query->rowCount()){
    $arow = $query->fetch(PDO::FETCH_OBJ);
    $site = $arow->siteurl;
    $sitebaslik = $arow->sitebaslik;
    $sitekeyw = $arow->sitekeyw;
    $sitedesc = $arow->sitedesc;
    $sitelogo = $arow->sitelogo;
    define('site',$site);
    define('baslik',$arow -> sitebaslik);
}

if($_SESSION){
$logincontrol = $db->prepare('SELECT * FROM bayiler WHERE id=:id AND bayikodu=:k');
$logincontrol->execute([
    ':id' => @$_SESSION['id'],
    ':k' => @$_SESSION['code']
]);
if($logincontrol->rowCount()){
    $par = $logincontrol->fetch(PDO::FETCH_OBJ);

    if($par->bayidurum == 1){
    $bid = $par->id;
    $blogo = $par->bayilogo;
    $bcode = $par->bayikodu;
    $bmail = $par->bayimail;
    $bname = $par->bayiadı;
    $bgift = $par->bayiindirim;
    $bphone = $par->bayitelefon;
    $bfax = $par->bayifax;
    $bvno = $par->bayivergino;
    $bvd = $par->bayivergidairesi;
    $bweb = $par->bayisite;
    $bstatus = $par->bayidurum;
    }
}else{
    @session_destroy();
}
}



?>