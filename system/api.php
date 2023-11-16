<?php 

require_once "connect.php";

header("Content-Type:application/json; charset=utf-8");

$process = $_SERVER["REQUEST_METHOD"];
parse_str(file_get_contents("php://input"),$datas);
function res($content , $kod , $message){
    $process["content"] = $content;
    $process["kod"] = $kod;
    $process["mesaj"] = $message;
    $result = json_encode($process, JSON_UNESCAPED_UNICODE);
    echo $result;
}

if($datas["token"] != sha1(md5("yusufg"))){
    res(NULL, 903, "Yetkisiz Erişim!");
}

if($reqt == "GET"){
    $query = $db->query("SELECT * FROM bayiler WHERE id=$datas[id]", PDO::FETCH_ASSOC);
    if($query->rowCount() > 0){
        foreach($query as $row){
            $bayiler[] = array("id" => $row["id"], "bayikodu" => $row["bayikodu"], "bayiadı" => $row["bayiadı"], "bayimail" => $row["bayimail"], "bayisifre" => $row["bayisifre"],"bayidurum" => $row["bayidurum"],"bayitarih" => $row["bayitarih"]);
        }
        res($bayiler, 900, "Kayıt Listelendi!");
    }else{
        res(NULL, 902, "Kayıt Bulunamadı!");
    }
}else{
    res(NULL, 904, "Hatalı İşlem!");
}
?>