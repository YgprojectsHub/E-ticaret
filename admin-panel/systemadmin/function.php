<?php 
require_once 'config.php'; 


function b2b($url,$id = null){
    global $adminpage;
    if($id == NULL){
        echo $adminpage."/process.php?process=".$url;
    }else{
        echo $adminpage."/process.php?process=".$url."&id=".$id;
    }
}

function alert2($message,$alert){
    echo '<div class="alert alert-'.$alert.'">'.$message.'</div>';
}

function dt($par,$status = false){
    if($status == false){
        return date('d.m.Y',strtotime($par));
    }else{
        return date('H:i',strtotime($par));
    }
}


function sef_link($str){
    $preg = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#', '.');
    $match = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp', '');
    $perma = strtolower(str_replace($preg, $match, $str));
    $perma = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $perma);
    $perma = trim(preg_replace('/\s+/', ' ', $perma));
    $perma = str_replace(' ', '-', $perma);
    return $perma;
}


function alert($message,$alert){
    echo '<div class="alert alert-'.$alert.'">'.$message.'</div>';
}


function post($par){
    return strip_tags(trim($_POST[$par]));
}

function get($par){
    return strip_tags(trim($_GET[$par]));
}

function go($url, $time = false){

    if($time == false){
        return header('Location:'.$url);
    }else{
       // return header('refresh:'.$time.':url='.$url);
        return header('refresh:'.$time.';url='.$url);
    }

}

function loc(){

    $loc =  "http://localhost".$_SERVER['REQUEST_URI'];
    return $loc;
}

function IP(){

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

function pagination($s, $ptotal, $url){
    global $adminpage ;

    $forlimit = 3;
    if($ptotal < 2){
        null;
    }else{

        if($s > 4){
            $prev  = $s - 1;
            echo '<li class="page-item"><a class="page-link"  href="'.$adminpage.'/'.$url.'1" ><i class="zmdi zmdi-long-arrow-left"></i></a></li>';
            echo '<li class="page-item ><a class="page-link"  href="'.$adminpage.'/'.$url.($s-1).'" ><</a></li>';
        }

        for($i = $s - $forlimit; $i < $s + $forlimit + 1; $i++){
            if($i > 0 && $i <= $ptotal){
                if($i == $s){
                    echo '<li class="page-item active"><a class="page-link"  href="#">'.$i.'</a></li>';
                }else{
                    echo '<li class="page-item"><a class="page-link" href="'.$adminpage.'/'.$url.$i.'" >'.$i.'</a></li>';
                }
            }
        }

        if($s <= $ptotal - 4){
            $next  = $s + 1;
            echo '<li class="page-item"><a class="page-link" href="'.$adminpage.'/'.$url.$next.'" > <i class="zmdi zmdi-long-arrow-right"></i></a></li>';
            echo '<li class="page-item"><a class="page-link" href="'.$adminpage.'/'.$url.$ptotal.'" >»</a></li>';
        }
    }

}


function rowresult($tablo, $sutun = false, $deger = false ,$iz = '='){
    global $db;
    $sql = "SELECT * FROM $tablo";
    
    if($sutun || $deger){
        
        $sql .= " WHERE $sutun $iz :$sutun";
        $query = $db->prepare($sql);
        $query->execute([":$sutun" => $deger]);
        return $query->rowCount();
        
    }else{
        
        $query = $db->prepare($sql);
        $query->execute();
        return $query->rowCount();
    }
    
}
?>