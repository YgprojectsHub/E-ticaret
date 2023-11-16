<?php 

session_start();
ob_start();
date_default_timezone_set('Europe/Istanbul');


try{

    $db = new PDO("mysql:host=localhost;dbname=b2b;charset=utf8;","root","");
    $db->query("SET CHARACTER SET utf8");
    $db->query("SET NAMES utf8");

}catch(PDOException $e){
    print_r($e->getMessage());
    die();
}


$query = $db->prepare("SELECT * FROM ayarlar LIMIT :lim");
$query->bindValue(':lim',(int) 1,PDO::PARAM_INT);
$query->execute();
if($query->rowCount()){

    $arow       = $query->fetch(PDO::FETCH_OBJ);
    $site       = $arow->siteurl;
    $adminpage  = $arow->siteurl."/admin-panel";    
    
    #sabitler
    define('site',$site);
    define('admin',$adminpage);
    #sabitler
}

function IP2(){

    if(getenv("HTTP_CLIENT_IP")){
        $ip = getenv("HTTP_CLIENT_IP");
    }elseif(getenv("HTTP_X_FORWARDED_FOR")){
        $ip = getenv("HTTP_X_FORWARDED_FOR");
        if (strstr($ip, ',')) {
            $tmp = explode (',', $ip);
            $ip = trim($tmp[0]);
        }
    }else{
        $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
}

##giriş kontrolleri

if( @$_SESSION['adminlogin'] == @sha1(md5(IP2().$_SESSION['adminid'])) ){


$logincontrol = $db->prepare("SELECT * FROM admin WHERE admin_id=:id");
$logincontrol->execute([':id' => @$_SESSION['adminid']]);
if($logincontrol->rowCount()){

    $par   = $logincontrol->fetch(PDO::FETCH_OBJ);  

    if($par->admin_durum == 1){

        $aid     = $par->admin_id;
        $aname   = $par->admin_kadi;
        $amail   = $par->admin_posta;
        $astat   = $par->admin_durum;

    }else{
        @session_destroy();
    }

}else{
    @session_destroy();
}


}

?>