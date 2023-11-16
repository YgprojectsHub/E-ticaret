<?php require_once "inc/header.php";?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php require_once "inc/sidebar.php";?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Sayfa Listesi Listesi</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo admin; ?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item active"><a href="#">Sayfa Listesi Ürün Listesi</a></li>
        </ul>
      </div>
      <main class="row">

        <?php 

        $s = @intval(get("s"));
        $blim = @intval(get("blim"));

        if(!$s){
          $s = 1;
        }
        
        $query = $db->prepare("SELECT * FROM sayfalar ORDER BY id DESC");
        $query->execute();

        $total = $query->rowCount();
        $lim = 50;
        $show = $s * $lim - $lim;

        $query = $db->prepare("SELECT * FROM sayfalar ORDER BY id DESC LIMIT :show,:lim");
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
            <h3 class="tile-title">Sayfa Listesi Listesi (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#Kodu</th>
                    <th>Resim</th>
                    <th>Başlık</th>
                    <th>Tarih</th>
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
                    <td><img src="<?php echo $site."/uploads/".$row['kapak'];?>" height="100" width="600" alt=""></td>
                    <td><?php echo $row['baslik'];?></td>
                    <td><?php echo dt($row['tarih']);?></td>
                    <td><?php echo $row['durum'] == 1 ? "<span class='badge badge-success'>Sayfa Aktif</span>" : "<span class='badge badge-danger'>Sayfa Pasif</span>"; ?></td>
                    <td>
                      <a title="Sayfa Düzenle" href="<?php b2b("pageedit",$row['id']); ?>"><i class="fa fa-edit"></i></a>
                      <a title="Sayfa Sil" onclick="return confirm('Onaylıyor musunuz?');" href="<?php b2b("pagedelete",$row['id']); ?>"><i class="fa fa-close"></i></a>
                    </td>
                  </tr>
                <?php } ?>                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php }else{alert2("Sayfalar bulunmuyor","warning");} ?>

        <div class="">
          <ul class="pagination">
            <?php
            if($total > $lim){
              if($blim){
                pagination($s, ceil($total / $lim),'pages.php?blim='.$blim."&s=");  
              }else{
                pagination($s, ceil($total / $lim),"pages.php?s=");                
              }
            }
            ?>
          </ul>
        </div>

      </div>
    </main>
    <?php require_once "inc/footer.php";?>