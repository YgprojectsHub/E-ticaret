<?php require_once "inc/header.php";?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php require_once "inc/sidebar.php";?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i>Sepete Eklenen Ürün Listesi</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo admin; ?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item active"><a href="#">  Sepete Eklenen Ürün Listesi</a></li>
        </ul>
      </div>
      <main class="row">

        <?php 

        $s = @intval(get("s"));
        $blim = @intval(get("blim"));

        if(!$s){
          $s = 1;
        }

        if(!$blim){
          $blim = 50;
        }
        
        $query = $db->prepare("SELECT * FROM sepet ORDER BY id DESC");
        $query->execute();

        $total = $query->rowCount();
        $lim = $blim;
        $show = $s * $lim - $lim;

        $query = $db->prepare("SELECT * FROM sepet ORDER BY id DESC LIMIT :show,:lim");
        $query->bindValue(':show',(int) $show, PDO::PARAM_INT);
        $query->bindValue(':lim',(int) $lim, PDO::PARAM_INT);
        $query->execute();

        if($s > ceil($total / $lim)){
          $s = 1;
        }
        
        if($total){
        ?>
        <?php if($query->rowCount()){ ?>
        <form action="" class="col-md-2" method="GET">
          <div class="form-group">
            <input type="text" name="blim" class="form-control" placeholder="Bayi listeleme sayısını giriniz">
          </div>
        </form>
        <?php } ?>

        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Sepet (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#Kodu</th>
                    <th>Bayi Kodu</th>
                    <th>Birim Fiyat</th>
                    <th>Adet</th>
                    <th>Toplam Fiyat</th>
                    <th>Tarih</th>
                    <th>İşlem</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                foreach($query as $row){
                ?>
                  <tr>
                    <td><?php echo $row['sepeturun'];?></td>
                    <td><?php echo $row['sepetbayi'];?></td>
                    <td><?php echo $row['birimfiyat']." ₺";?></td>
                    <td><?php echo $row['sepetadet'];?></td>
                    <td><?php echo $row['toplamfiyat']." ₺";?></td>
                    <td><?php echo dt($row['sepettarih']);?></td>
                    <td>
                      <a title="Sepetten Sil" onclick="return confirm('Onaylıyor musunuz?');" href=""><i class="fa fa-close"></i></a>
                    </td>
                  </tr>
                <?php } ?>                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php }else{alert2("Bayi siparişi bulunmuyor","warning");} ?>

        <div class="">
          <ul class="pagination">
            <?php
            if($total > $lim){
              if($blim){
                pagination($s, ceil($total / $lim),'cart.php?blim='.$blim."&s=");  
              }else{
                pagination($s, ceil($total / $lim),"cart.php?s=");                
              }
            }
            ?>
          </ul>
        </div>

      </div>
    </main>
    <?php require_once "inc/footer.php";?>