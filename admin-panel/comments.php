<?php require_once "inc/header.php";?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php require_once "inc/sidebar.php";?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Yorum Listesi</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo admin; ?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item active"><a href="#">Yorum Ürün Listesi</a></li>
        </ul>
      </div>
      <main class="row">

        <form action="<?php echo admin."/commentssearch.php"; ?>" class="col-md-12" method="GET">
          <div class="form-group">
            <input type="text" class="form-control" name="q" placeholder="Bayi adı ve ürün adını giriniz">
          </div>
        </form>

        <form action="" class="col-md-2" method="GET">
          <div class="form-group">
            <input type="text" name="blim" class="form-control" placeholder="Bayi listeleme sayısını giriniz">
          </div>
        </form>

        <?php 

        $s = @intval(get("s"));
        $blim = @intval(get("blim"));

        if(!$s){
          $s = 1;
        }

        if(!$blim){
          $blim = 50;
        }
        
        $query = $db->prepare("SELECT *,urun_yorumlar.id FROM urun_yorumlar 

        INNER JOIN urunler ON urunler.urunkodu = urun_yorumlar.yorumurun

        ORDER BY urun_yorumlar.yorumurun DESC");
        $query->execute();

        $total = $query->rowCount();
        $lim = $blim;
        $show = $s * $lim - $lim;

        $query = $db->prepare("SELECT *,urun_yorumlar.id FROM urun_yorumlar     

        INNER JOIN urunler ON urunler.urunkodu = urun_yorumlar.yorumurun

        ORDER BY urun_yorumlar.yorumurun DESC LIMIT :show,:lim");
        
        $query->bindValue(':show',(int) $show, PDO::PARAM_INT);
        $query->bindValue(':lim',(int) $lim, PDO::PARAM_INT);
        $query->execute();

        if($s > ceil($total / $lim)){
          $s = 1;
        }
        
        if($total){
        ?>
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Yorum Listesi (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#ID</th>
                    <th>Ürün</th>
                    <th>Bayi</th>
                    <th>Tarih</th>
                    <th>IP</th>
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
                    <td><?php echo $row['urunbaslik'];?></td>
                    <td><?php echo $row['yorumisim'];?></td>
                    <td><?php echo dt($row['yorumtarih']);?></td>
                    <td><?php echo $row['yorumip'];?></td>
                    <td><?php echo $row['yorumdurum'] == 1 ? "<span class='badge badge-success'>Onaylı</span>" : "<span class='badge badge-danger'>Onay Bekliyor</span>"; ?></td>
                    <td>
                      <a href="<?php b2b("commentread",$row['id']); ?>"><i class="fa fa-eye"></i></a> | 
                      <a title="Yorumu Sil" onclick="return confirm('Onaylıyor musunuz?');" href="<?php b2b("commentdelete",$row['id']); ?>"><i class="fa fa-close"></i></a>
                    </td>
                  </tr>
                <?php } ?>                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php }else{alert2("Yorum bulunmuyor","warning");} ?>

        <div class="">
          <ul class="pagination">
            <?php
            if($total > $lim){
              if($blim){
                pagination($s, ceil($total / $lim),'comments.php?blim='.$blim."&s=");  
              }else{
                pagination($s, ceil($total / $lim),"comments.php?s=");                
              }
            }
            ?>
          </ul>
        </div>

      </div>
    </main>
    <?php require_once "inc/footer.php";?>