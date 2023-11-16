<?php require_once "inc/header.php";?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php require_once "inc/sidebar.php";?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Kategori Arama Sonuçları</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo admin; ?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item active"><a href="#">Kategori Arama Sonuçları</a></li>
        </ul>
      </div>
      <main class="row">
      
      <form action="<?php echo admin; ?>/categoriessearch.php" class="col-md-12" method="GET">
          <div class="form-group">
            <input type="text" class="form-control" name="q" placeholder="Kategori giriniz">
          </div>
        </form>

        <?php 

        $s = @intval(get("s"));
        $q = @get("q");

        if(!$s){
          $s = 1;
        }

        if(!$q){
          go(admin."/categories.php");
        }
        
        $query = $db->prepare("SELECT * FROM urun_kategoriler WHERE katbaslik LIKE :b ORDER BY id DESC");
        $query->execute([":b" => '%'.$q.'%']);

        $total = $query->rowCount();
        $lim = 50;
        $show = $s * $lim - $lim;

        $query = $db->prepare("SELECT * FROM urun_kategoriler WHERE katbaslik LIKE :b ORDER BY id DESC LIMIT :show,:lim");
        $query->bindValue(':show',(int) $show, PDO::PARAM_INT);
        $query->bindValue(':lim',(int) $lim, PDO::PARAM_INT);
        $query->bindValue(':b', '%'.$q.'%', PDO::PARAM_STR);
        $query->execute();

        if($s > ceil($total / $lim)){
          $s = 1;
        }
        
        if($total){
        ?>
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Kategori Arama Sonuçları (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#ID</th>
                    <th>#Resim</th>
                    <th>Başlık</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                foreach($query as $row){
                ?>
                  <tr>
                    <td><?php echo $row['id'];?></td>
                    <td> <img src="<?php echo $site."/uploads/product/".$row['katresim'];?>" width="100" height="100"></td>
                    <td><?php echo $row['katbaslik'];?></td>
                    <td><?php echo $row['katdurum'] == 1 ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Pasif</span>"; ?></td>
                    <td>
                      <a title="Düzenle" href="<?php b2b("categoryedit", $row["id"]); ?>"><i class="fa fa-edit"></i></a> | 
                      <a title="Sil" onclick="return confirm('Bu kategorilerdeki tüm ürünler, silinme olarak işaretlenecektir onaylıyormusunuz?');" href="<?php b2b("categorydelete", $row["id"]); ?>"><i class="fa fa-close"></i></a>
                    </td>
                  </tr>
                <?php } ?>                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php }else{alert2("Kategori bulunmuyor","warning");} ?>

        <div class="">
          <ul class="pagination">
            <?php
            if($total > $lim){
              pagination($s, ceil($total / $lim),"categoriessearch.php?q=".$q."&s=");
            }
            ?>
          </ul>
        </div>

      </div>
    </main>
    <?php require_once "inc/footer.php";?>