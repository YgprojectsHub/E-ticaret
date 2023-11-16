<?php require_once "inc/header.php";?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php require_once "inc/sidebar.php";?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Geçmiş Mesaj Listesi</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo admin; ?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item active"><a href="#">Geçmiş Mesaj Listesi</a></li>
        </ul>
      </div>
      <main class="row">

        <form action="<?php echo admin."/messagessearch.php"; ?>" class="col-md-12" method="GET">
          <div class="form-group">
            <input type="text" class="form-control" name="q" placeholder="Kişi adı ve ya e-posta giriniz">
          </div>
        </form>

        <form action="" class="col-md-2" method="GET">
          <div class="form-group">
            <input type="text" name="blim" class="form-control" placeholder="Listeleme sayısını giriniz">
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
        
        $query = $db->prepare("SELECT * FROM mesajlar WHERE mesajdurum=:d ORDER BY id DESC");
        $query->execute([":d" => 1]);

        $total = $query->rowCount();
        $lim = $blim;
        $show = $s * $lim - $lim;

        $query = $db->prepare("SELECT * FROM mesajlar WHERE mesajdurum=:d ORDER BY id DESC LIMIT :show,:lim");
        $query->bindValue(':show',(int) $show, PDO::PARAM_INT);
        $query->bindValue(':lim',(int) $lim, PDO::PARAM_INT);
        $query->bindValue(':d',(int) 1, PDO::PARAM_INT);
        $query->execute();

        if($s > ceil($total / $lim)){
          $s = 1;
        }
        
        if($total){
        ?>
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Geçmiş Mesaj Listesi (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#ID</th>
                    <th>İsim</th>
                    <th>E-posta</th>
                    <th>Konu</th>
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
                    <td><?php echo $row['mesajisim'];?></td>
                    <td><?php echo $row['mesajposta'];?></td>
                    <td><?php echo $row['mesajkonu'];?></td>
                    <td><?php echo dt($row['mesajtarih']);?></td>
                    <td><span class='badge badge-success'>Okundu</span></td>
                    <td>
                      <a title="Mesajı Görüntüle" href="<?php b2b("messageview", $row['id']); ?>"><i class="fa fa-eye"></i></a>
                      <a title="Mesaj Sil" onclick="return confirm('Onaylıyor musunuz?');" href="<?php b2b("messagedelete", $row['id']); ?>"><i class="fa fa-close"></i></a>
                    </td>
                  </tr>
                <?php } ?>                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php }else{alert2("Geçmiş mesajlar bulunmuyor","warning");} ?>

        <div class="">
          <ul class="pagination">
            <?php
            if($total > $lim){
              if($blim){
                pagination($s, ceil($total / $lim),'oldmessages.php?blim='.$blim."&s=");  
              }else{
                pagination($s, ceil($total / $lim),"oldmessages.php?s=");                
              }
            }
            ?>
          </ul>
        </div>

      </div>
    </main>
    <?php require_once "inc/footer.php";?>