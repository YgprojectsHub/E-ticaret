<?php require_once "inc/header.php";?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php require_once "inc/sidebar.php";?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Havale Bildirimleri Arama Sonuçları</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo admin; ?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item active"><a href="#">Havale Bildirimleri Arama Sonuçları</a></li>
        </ul>
      </div>
      <main class="row">

        <form action="<?php echo admin."/notificationssearch.php"; ?>" class="col-md-12" method="GET">
          <div class="form-group">
            <input type="text" class="form-control" name="q" placeholder="Bayi kodu giriniz">
          </div>
        </form>

        <?php 

        $s = @intval(get("s"));
        $q = @get("q");

        if(!$s){
          $s = 1;
        }

        if(!$q){
          go(admin."/notifications.php");
        }
        
        $query = $db->prepare("SELECT *,havalebildirim.id FROM havalebildirim 

        INNER JOIN bayiler ON bayiler.bayikodu = havalebildirim.havalebayi
        INNER JOIN bankalar ON bankalar.bankaid = havalebildirim.banka

        WHERE havalebayi LIKE :b

        ORDER BY havalebildirim.id DESC");
        $query->execute([":b" => '%'.$q.'%']);

        $total = $query->rowCount();
        $lim = 50;
        $show = $s * $lim - $lim;

        $query = $db->prepare("SELECT *,havalebildirim.id FROM havalebildirim     

        INNER JOIN bayiler ON bayiler.bayikodu = havalebildirim.havalebayi
        INNER JOIN bankalar ON bankalar.bankaid = havalebildirim.banka

        WHERE havalebayi LIKE :b

        ORDER BY havalebildirim.id DESC LIMIT :show,:lim");
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
            <h3 class="tile-title">Havale Bildirimleri Arama Sonuçları (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#ID</th>
                    <th>Bayi Adı</th>
                    <th>Tarih</th>
                    <th>Tutar</th>
                    <th>Açıklama</th>
                    <th>Banka</th>
                    <th>İşlem</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                foreach($query as $row){
                ?>
                  <tr>
                    <td><?php echo $row['id'];?></td>
                    <td><?php echo $row['bayiadı'];?></td>
                    <td><?php echo dt($row['havaletarih'])." | ".$row['havalesaat'];?></td>
                    <td><?php echo $row['havaletutar']." ₺";?></td>
                    <td><?php echo $row['havalenot'];?></td>
                    <td><?php echo $row['bankaadi'];?></td>
                    <td>
                      <a href="<?php b2b("notificationdetail",$row["id"]); ?>"><i class="fa fa-eye"></i></a> | 
                      <a title="Sepetten Sil" onclick="return confirm('Onaylıyor musunuz?');" href="<?php b2b("notificationdelete",$row["id"]); ?>"><i class="fa fa-close"></i></a>
                    </td>
                  </tr>
                <?php } ?>                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php }else{alert2("Havale Bildirimi bulunmuyor","warning");} ?>

        <div class="">
          <ul class="pagination">
            <?php
            if($total > $lim){
              pagination($s, ceil($total / $lim),"notificationssearch.php?q=".$q."&s=");
            }
            ?>
          </ul>
        </div>

      </div>
    </main>
    <?php require_once "inc/footer.php";?>