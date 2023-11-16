<?php require_once "inc/header.php";?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php require_once "inc/sidebar.php";?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Ürün Listesi</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo admin; ?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item active"><a href="#">Ürün Listesi</a></li>
        </ul>
      </div>
      <main class="row">
      
        <form action="<?php echo admin."/productssearch.php"; ?>" class="col-md-12" method="GET">
          <div class="form-group">
            <input type="text" class="form-control" name="q" placeholder="Ürün adı ve ya ürün kodu giriniz">
          </div>
        </form>

        <?php 

        $s = @intval(get("s"));
        $q = @get("q");

        if(!$s){
          $s = 1;
        }

        if(!$q){
          go(admin."/products.php");
        }
        
        $query = $db->prepare("SELECT * FROM urunler INNER JOIN urun_kategoriler ON urun_kategoriler.id = urunler.urunkat  WHERE urunbaslik LIKE :b OR urunkodu LIKE :k ORDER BY urunler.id DESC");
        $query->execute([":b" => "%".$q."%" , ":k" => "%".$q."%"]);

        $total = $query->rowCount();
        $lim = 50;
        $show = $s * $lim - $lim;

        $query = $db->prepare("SELECT * FROM urunler INNER JOIN urun_kategoriler ON urun_kategoriler.id = urunler.urunkat WHERE urunbaslik LIKE :b OR urunkodu LIKE :k ORDER BY urunler.id DESC LIMIT :show,:lim");
        $query->bindValue(':show',(int) $show, PDO::PARAM_INT);
        $query->bindValue(':lim',(int) $lim, PDO::PARAM_INT);
        $query->bindValue(':b', "%".$q."%", PDO::PARAM_STR);
        $query->bindValue(':k', "%".$q."%", PDO::PARAM_STR);
        $query->execute();

        if($s > ceil($total / $lim)){
          $s = 1;
        }
        
        if($total){
        ?>
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Ürünler (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#Kodu</th>
                    <th>Resim</th>
                    <th>Başlık</th>
                    <th>Kategori</th>
                    <th>Fiyat</th>
                    <th>Stok</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                foreach($query as $row){
                ?>
                  <tr>
                    <td><?php echo $row['urunkodu'];?></td>
                    <td> <img src="<?php echo $site."/uploads/product/".$row['urunkapakresim'];?>" width="100" height="100"></td>
                    <td><?php echo $row['urunbaslik'];?></td>
                    <td><?php echo $row['katbaslik'];?></td>
                    <td><?php echo $row['urunfiyat']." ₺";?></td>
                    <td><?php echo $row['urunstok'];?></td>
                    <td><?php echo $row['urundurum'] == 1 ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Pasif</span>"; ?></td>
                    <td>
                      <a title="Düzenle" href="<?php b2b("productedit",$row["urunkodu"]); ?>"><i class="fa fa-edit"></i></a> | 
                      <a title="Banner Resmi" href="<?php b2b("productbanner",$row["urunkodu"]); ?>"><i class="fa fa-photo"></i></a> | 
                      <a title="Ürün Çoklu Fotoğraf Resmi" href="<?php b2b("productmultiplerphoto",$row["urunkodu"]); ?>"><i class="fa fa-photo"></i></a> | 
                      <a title="Ürün Özellikler" href="<?php b2b("productskill",$row["urunkodu"]); ?>"><i class="fa fa-list"></i></a> | 
                      <a title="Sil" href=""><i class="fa fa-close"></i></a>
                    </td>
                  </tr>
                <?php } ?>                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php }else{alert2("Ürün bulunmuyor","warning");} ?>

        <div class="">
          <ul class="pagination">
            <?php
            if($total > $lim){
              pagination($s, ceil($total / $lim),"productssearch.php?q=".$q."&s=");
            }
            ?>
          </ul>
        </div>

      </div>
    </main>
    <?php require_once "inc/footer.php";?>