<?php require_once "inc/header.php";?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php require_once "inc/sidebar.php";?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Banka Listesi</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo admin; ?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item active"><a href="#">Banka Listesi</a></li>
        </ul>
      </div>
      <main class="row">

        <?php 

        $s = @intval(get("s"));
        $blim = @intval(get("blim"));

        if(!$s){
          $s = 1;
        }
        
        $query = $db->prepare("SELECT * FROM bankalar ORDER BY bankaid DESC");
        $query->execute();

        $total = $query->rowCount();
        $lim = 50;
        $show = $s * $lim - $lim;

        $query = $db->prepare("SELECT * FROM bankalar ORDER BY bankaid DESC LIMIT :show,:lim");
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
            <h3 class="tile-title">Banka Listesi (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#Kodu</th>
                    <th>Banka</th>
                    <th>Hesap No</th>
                    <th>Şube No</th>
                    <th>IBAN</th>
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
                    <td><?php echo $row['bankaid'];?></td>
                    <td><?php echo $row['bankaadi'];?></td>
                    <td><?php echo $row['bankahesap'];?></td>
                    <td><?php echo $row['bankasube'];?></td>
                    <td><?php echo $row['bankaiban'];?></td>
                    <td><?php echo dt($row['bankatarih']);?></td>
                    <td><?php echo $row['bankadurum'] == 1 ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Pasif</span>"; ?></td>
                    <td>
                      <a title="Banka Düzenle" href="<?php b2b("bankedit",$row['bankaid']); ?>"><i class="fa fa-edit"></i></a>
                      <a title="Banka Sil" onclick="return confirm('Onaylıyor musunuz?');" href="<?php b2b("bankdelete",$row['bankaid']); ?>"><i class="fa fa-close"></i></a>
                    </td>
                  </tr>
                <?php } ?>                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php }else{alert2("Banka bulunmuyor","warning");} ?>

        <div class="">
          <ul class="pagination">
            <?php
            if($total > $lim){
              if($blim){
                pagination($s, ceil($total / $lim),'banklist.php?blim='.$blim."&s=");  
              }else{
              pagination($s, ceil($total / $lim),"banklist.php?s=");                
              }
            }
            ?>
          </ul>
        </div>

      </div>
    </main>
    <?php require_once "inc/footer.php";?>