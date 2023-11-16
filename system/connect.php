<?php

try{

    $db = new PDO("mysql:host=localhost;dbname=b2b;charset=utf8", "root", "");

}
catch(PDOException $e){
    print_r($e->getMessage());
}

?>