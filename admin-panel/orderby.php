<?php 

require_once "systemadmin/config.php";

if( @$_SESSION['adminlogin'] != sha1(md5(IP2().$aid))){
    header("Location:".admin."/adminlogin.php");
}

if($_POST){
    $table = strip_tags(trim($_GET['table']));

    for($i = 0; $i < count($_POST["page_id_array"]); $i++){
        $up = $db->prepare("UPDATE $table SET siralama=? WHERE id=?");
        $up->execute([$i,$_POST["page_id_array"][$i]]);
        //header("location:".$_SERVER["HTTP_REFERER"]);
    }
}

?>