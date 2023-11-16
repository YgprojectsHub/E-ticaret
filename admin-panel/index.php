<?php require_once "inc/header.php";
?>
    <!-- Sidebar menu-->
<?php require_once "inc/sidebar.php"; ?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> B2b Admin Panel</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?php echo admin; ?>">Ana Sayfa</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>Bayiler</h4>
              <p><b><?php echo rowresult("bayiler"); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-shopping-cart fa-3x"></i>
            <div class="info">
              <h4>Siparişler</h4>
              <p><b><?php echo rowresult("siparisler"); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-envelope fa-3x"></i>
            <div class="info">
              <h4>Yeni Mesaj</h4>
              <p><b><?php echo rowresult("mesajlar","mesajdurum",2); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-gift fa-3x"></i>
            <div class="info">
              <h4>Ürünler</h4>
              <p><b><?php echo rowresult("urunler"); ?></b></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Son 10 Sipariş</h3>
            <?php 
            $lastorders = $db->prepare("SELECT * FROM siparisler INNER JOIN bayiler ON bayiler.bayikodu=siparisler.siparisbayi INNER JOIN durumkodlari ON durumkodlari.durumkodu = siparisler.siparisdurum ORDER BY siparisler.id DESC LIMIT 10");
            $lastorders->execute();
            if($lastorders->rowCount()){
            ?>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                <th>KOD</th>
                <th>BAYİ</th>
                <th>TUTAR</th>
                <th>DURUM</th>                  
                <th>TARİH</th>                  
                </thead>
                <tbody>
                  <?php foreach($lastorders as $lastorder){?>
                    <tr>
                      <td><a href="<?php b2b("orderdetail",$lastorder["sipariskodu"]); ?>"><?php echo $lastorder["sipariskodu"] ?></a></td>
                      <td><?php echo $lastorder["bayiadı"] ?></td>
                      <td><?php echo $lastorder["siparistutar"]." ₺" ?></td>
                      <td><?php echo $lastorder["durumbaslik"]?></td>
                      <td><?php echo dt($lastorder["siparistarih"])." | ".$lastorder["siparissaat"]?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
          </div>
          <?php }else{alert2("Hiç sipariş bulunmamaktadır","danger");}?>
        </div>

        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Son 10 Yeni Mesaj</h3>
            <?php 
            $lastmessages = $db->prepare("SELECT * FROM mesajlar WHERE mesajdurum=:d ORDER BY id DESC LIMIT 10");
            $lastmessages->execute([
              ":d" => 2
            ]);
            if($lastmessages->rowCount()){
            ?>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                <th>ID</th>
                <th>İSİM</th>
                <th>E-POSTA</th>
                <th>TARİH</th>                  
                </thead>
                <tbody>
                  <?php foreach($lastmessages as $lastmessage){?>
                    <tr>
                      <td><a href="<?php b2b("messageview",$lastmessage["id"]); ?>"><?php echo $lastmessage["id"]; ?></a></td>
                      <td><?php echo $lastmessage["mesajisim"]; ?></td>
                      <td><?php echo $lastmessage["mesajposta"]; ?></td>
                      <td><?php echo dt($lastmessage["mesajtarih"]); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
          </div>
          <?php }else{alert2("Hiç mesaj bulunmamaktadır","danger");}?>
          </div>
        </div>
        
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Son 10 Yeni Yorum</h3>
            <?php 
            $lastcomments = $db->prepare("SELECT *,urun_yorumlar.id FROM urun_yorumlar INNER JOIN urunler ON urunler.urunkodu = urun_yorumlar.yorumurun WHERE yorumdurum=:d ORDER BY urun_yorumlar.id DESC LIMIT 10");
            $lastcomments->execute([
              ":d" => 2
            ]);
            if($lastcomments->rowCount()){
            ?>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                <th>ID</th>
                <th>ÜRÜN</th>
                <th>BAYİ</th>
                <th>TARİH</th>                  
                </thead>
                <tbody>
                  <?php foreach($lastcomments as $lastcomment){?>
                    <tr>
                      <td><a href="<?php b2b("commentread",$lastcomment["id"]); ?>"><?php echo $lastcomment["id"]; ?></a></td>
                      <td><?php echo $lastcomment["urunbaslik"]; ?></td>
                      <td><?php echo $lastcomment["yorumisim"]; ?></td>
                      <td><?php echo dt($lastcomment["yorumtarih"]); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
          </div>
          <?php }else{alert2("Hiç yorum bulunmamaktadır","danger");}?>
          </div>
        </div>
      </div>
      </div>
    </main>
    <!-- Essential javascripts for application to work-->
<?php require_once "inc/footer.php"; ?>