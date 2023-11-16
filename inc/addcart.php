<?php 

require_once "../system/function.php";

if($_POST){

    if($arow->sitesiparisdurum == 1){

    if(@$_SESSION['login'] == @sha1(md5(IP().$bcode))){
       $qty = post("qty");
       $pcode = post("pcode");
        if(!$qty || !$pcode){
            echo "empty";
        }else{
            if($qty < 1){
                echo "qty";
            }else{
                $prows = $db->prepare("SELECT urunkodu,urunfiyat,urundurum FROM urunler WHERE urunkodu=:uk");
                $prows->execute([':uk' => $pcode]);
                $prow = $prows->fetch(PDO::FETCH_OBJ);

                if($bgift > 0){
					$price = $prow->urunfiyat - (($prow->urunfiyat * $bgift) / 100);
					
				}else{
					$price  = $prow->urunfiyat;
				}

                $totalprice = $price * $qty;
                $tax = $totalprice * ($arow->sitekdv / 100);
                $subtotal = $totalprice + $tax;

                $currentcart = $db->prepare("SELECT sepeturun,sepetadet,sepetbayi FROM sepet WHERE sepeturun=:su AND sepetbayi=:sb");
                $currentcart->execute(['su' => $pcode, 'sb' =>$bcode]);
                if($currentcart->rowCount()){
                    $currentcartrow = $currentcart->fetch(PDO::FETCH_OBJ);

                    $currentqty = $currentcartrow->sepetadet + $qty;

                    $totalprice = $price * $currentqty;

                    $tax = $totalprice * ($arow->sitekdv / 100);

                    $subtotal = $totalprice + $tax;
                    $result2 = $db->prepare("UPDATE sepet SET sepetadet=:sa , birimfiyat=:bi , toplamfiyat=:tf , kdv=:ka WHERE sepeturun=:su AND sepetbayi=:sb");
                    $result2->execute([
                    ':sa' => $currentqty,
                    ':bi' => $price,
                    ':tf' => $subtotal,
                    ':ka' => $arow->sitekdv,
                    ':su' => $pcode,
                    ':sb' => $bcode
                    ]);
    
                    if($result2->rowCount()){
                        echo "ok";
                    }else{
                        echo "error";
                    }
                }else{
                    $result = $db->prepare("INSERT INTO sepet SET sepetbayi=:sb , sepeturun=:su , sepetadet=:sa , birimfiyat=:bi , toplamfiyat=:tf , sepettarih=:st, sepetsilinme=:ss, kdv=:ka");
                    $result->execute([
                    ':sb' => $bcode,
                    ':su' => $pcode,
                    ':sa' => $qty,
                    ':bi' => $price,
                    ':tf' => $subtotal,
                    ':st' => date("Y-m-d"),
                    ':ss' => date("Y-m-d",strtotime( date("Y-m-d") . " +7 days" )),
                    ':ka' => $arow->sitekdv]);
    
                    if($result->rowCount()){
                        $log = $db->prepare("INSERT INTO bayilog SET logbayi=:b, logip=:i, logdesc=:d");
                        $log->execute([":b"  => $bcode,":i" => IP(),":d"  => $prow->urunkodu." nolu ürünü sepete ekledi"]);
                        echo "ok";
                    }else{
                        echo "error";
                    }
                }
            }
        }
    }else{
        echo "login";
    }
    }else{
        echo "error";
    }

}else{
    go(site);
}

?>