<?php require_once "inc/header.php";?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php require_once "inc/sidebar.php";?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Bayi Listesi</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo admin; ?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item active"><a href="#">Bayi Listesi</a></li>
        </ul>
      </div>
      <main class="row">
      
        <form action="<?php echo admin; ?>/customersearch.php" class="col-md-12" method="GET">
          <div class="form-group">
            <input type="text" class="form-control" name="q" placeholder="Bayi adı ve ya bayi kodu giriniz">
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
        
        $query = $db->prepare("SELECT * FROM bayiler ORDER BY id DESC");
        $query->execute();

        $total = $query->rowCount();
        $lim = $blim;
        $show = $s * $lim - $lim;

        $query = $db->prepare("SELECT * FROM bayiler ORDER BY id DESC LIMIT :show,:lim");
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
            <h3 class="tile-title">Bayiler (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#Kodu</th>
                    <th>Adı</th>
                    <th>Mail</th>
                    <th>Telefon</th>
                    <th>İndirim</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                foreach($query as $row){
                ?>
                  <tr>
                    <td><?php echo $row['bayikodu'];?></td>
                    <td><?php echo $row['bayiadı'];?></td>
                    <td><?php echo $row['bayimail'];?></td>
                    <td><?php echo $row['bayitelefon'];?></td>
                    <td>%<?php echo $row['bayiindirim'];?></td>
                    <td><?php echo $row['bayidurum'] == 1 ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Pasif</span>"; ?></td>
                    <td>
                      <a title="Düzenle" href="<?php b2b("customeredit",$row["bayikodu"]); ?>"><i class="fa fa-edit"></i></a> | 
                      <a title="Logo" href="<?php b2b("customerlogo",$row["bayikodu"]); ?>"><i class="fa fa-edit"></i></a> | 
                      <a title="Log" href="<?php b2b("customerlog",$row["bayikodu"]); ?>"><i class="fa fa-edit"></i></a> | 
                      <a title="Adres" href="<?php b2b("customeradress",$row["bayikodu"]); ?>"><i class="fa fa-edit"></i></a> | 
                      <a title="Sil" href="<?php b2b("customerdelete",$row["bayikodu"]) ?>" onclick="return confirm('Onaylıyor musunuz?');"><i class="fa fa-close"></i></a>
                    </td>
                  </tr>
                <?php } ?>                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php }else{alert2("Bayi kayıtı bulunmuyor","warning");} ?>

        <div class="">
          <ul class="pagination">
            <?php
            if($total > $lim){
              if($blim){
                pagination($s, ceil($total / $lim),'customers.php?blim='.$blim."&s=");  
              }else{
              pagination($s, ceil($total / $lim),"customers.php?s=");                
              }
            }
            ?>
          </ul>
        </div>

      </div>
    </main>
    <?php require_once "inc/footer.php";?>