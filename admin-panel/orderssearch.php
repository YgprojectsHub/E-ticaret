<?php require_once "inc/header.php";?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php require_once "inc/sidebar.php";?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Sipariş Arama Sonuç Listesi</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo admin; ?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item active"><a href="#">Sipariş Arama Sonuç Listesi</a></li>
        </ul>
      </div>
      <main class="row">
      
        <form action="<?php echo admin."/orderssearch.php";?>" class="col-md-12" method="GET">
          <div class="form-group">
            <input type="text" class="form-control" name="q" placeholder="Bayi adı ve ya sipariş kodu giriniz">
          </div>
        </form>

        <?php 

        $s = @intval(get("s"));
        $q = @get("q");

        if(!$s){
          $s = 1;
        }

        if(!$q){
          go(admin."/orders.php");
        }
        
        $query = $db->prepare("SELECT * FROM siparisler INNER JOIN durumkodlari ON durumkodlari.durumkodu = siparisler.siparisdurum WHERE siparisisim LIKE :i OR sipariskodu LIKE :k ORDER BY siparisler.id DESC");
        $query->execute([":i" => "%".$q."%", ":k" => "%".$q."%"]);

        $total = $query->rowCount();
        $lim = 50;
        $show = $s * $lim - $lim;

        $query = $db->prepare("SELECT * FROM siparisler INNER JOIN durumkodlari ON durumkodlari.durumkodu = siparisler.siparisdurum WHERE siparisisim LIKE :i OR sipariskodu LIKE :k ORDER BY siparisler.id DESC LIMIT :show,:lim");
        $query->bindValue(':show',(int) $show, PDO::PARAM_INT);
        $query->bindValue(':lim',(int) $lim, PDO::PARAM_INT);
        $query->bindValue(':i', "%".$q."%", PDO::PARAM_STR);
        $query->bindValue(':k', "%".$q."%", PDO::PARAM_STR);
        $query->execute();

        if($s > ceil($total / $lim)){
          $s = 1;
        }
        
        if($total){
        ?>
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Sipariş Arama Sonuç Listesi (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#Kodu</th>
                    <th>Bayi Adı</th>
                    <th>Telefon</th>
                    <th>Tarih</th>
                    <th>Tutar</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                foreach($query as $row){
                ?>
                  <tr>
                    <td><a href="<?php b2b("orderdetail",$row["sipariskodu"]); ?>">#<?php echo $row['sipariskodu'];?></a></td>
                    <td><?php echo $row['siparisisim'];?></td>
                    <td><?php echo $row['siparistel'];?></td>
                    <td><?php echo dt($row['siparistarih'])." | ".$row['siparissaat'];?></td>
                    <td><?php echo $row['siparistutar']." ₺";?></td>
                    <td><?php echo $row['durumbaslik'];?></td>
                    <td>
                      <a title="Siparişi görüntüle" href="<?php b2b("orderdetail",$row["sipariskodu"]); ?>"><i class="fa fa-eye"></i></a> |
                      <a title="Sipariş sil" onclick="return confirm('Onaylıyor musunuz?');" href="<?php b2b("orderdelete",$row["sipariskodu"]); ?>"><i class="fa fa-close"></i></a>
                    </td>
                  </tr>
                <?php } ?>                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php }else{alert2("Sipariş bulunmuyor","warning");} ?>

        <div class="">
          <ul class="pagination">
            <?php
            if($total > $lim){
              pagination($s, ceil($total / $lim),"orderssearch.php?q=".$q."&s=");
            }
            ?>
          </ul>
        </div>

      </div>
    </main>
    <?php require_once "inc/footer.php";?>