<?php define("security",true); require_once "inc/header.php"; ?>
		<!-- WRAPPER START -->
		<style>
            .product-action a {
                color: #666666;
                float: left;
                font-size: 16px;
                height: 40px;
                line-height: 40px;
                position: relative;
				background: #faf9f7;
				width: 100%;
            }
			
            .pro-price-2 {
                color: #c87065;
                font-size: 18px;
                font-weight: 700;
                line-height: 1;
                position: absolute;
                right: 15px;
                top: 0.1px;
				background: rgba(202, 207, 204, 0.9);
				padding: 3px;
				border-radius: 4px;
            }
		</style>
		<div class="wrapper bg-dark-white">

			<!-- HEADER-AREA START -->
			<?php require_once "inc/menu.php";?>
			<!-- HEADER-AREA END -->
			<!-- Mobile-menu start -->
			<?php require_once "inc/mobilemenu.php"; ?>
			<?php 

            $catsef = get('catsef');
			if(!$catsef){
				go(site);
			}

			$catresult= $db->prepare("SELECT id,katbaslik,katsef,katdurum,katresim FROM urun_kategoriler WHERE katsef=:se AND katdurum=:d");
			$catresult->execute([':se' => $catsef, 'd' => 1]);
			if($catresult->rowCount()){
				$catrow = $catresult->fetch(PDO::FETCH_OBJ);
			}
			
			$s = @intval(get('s'));
			if(!$s){
				$s = 1;
			}
			
			$plist = $db->prepare("SELECT * FROM urunler WHERE urundurum=:ud AND urunkat=:ut ORDER BY uruntarih DESC");
			$plist->execute([':ud' => 1,':ut' => $catrow->id]);

			$total = $plist->rowCount();
			$lim = 9;
			$show = $s * $lim - $lim;
			
			?>
			<!-- Mobile-menu end -->
			<!-- HEADING-BANNER START -->
			<div class="heading-banner-area overlay-bg" style='background: rgba(0, 0, 0, 0) url(<?php echo site;?>/uploads/<?php echo $catrow->katresim;?>) no-repeat scroll center center / cover;'>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="heading-banner">
								<div class="heading-banner-title">
									<h2><?php echo $catrow->katbaslik; ?></h2>
								</div>
								<div class="breadcumbs pb-15">
									<ul>
										<li><a href="<?php echo site; ?>">Ana Sayfa</a></li>
										<li><a href="#">Kategori</a></li>
										<li><?php echo $catrow->katbaslik; ?></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- HEADING-BANNER END -->
			<!-- PRODUCT-AREA START -->
			<div class="product-area pt-80 pb-80 product-style-2">
				<div class="container">
					<div class="row">
						
					<?php require_once "inc/sidebar.php";?>
						
						<?php 

						

						$plist = $db->prepare("SELECT * FROM urunler WHERE urundurum=:ud AND urunkat=:ut ORDER BY uruntarih DESC LIMIT :show,:lim");
						$plist->bindValue(':ud',(int) 1,PDO::PARAM_INT);
						$plist->bindValue(':ut',(int) $catrow->id,PDO::PARAM_INT);
						$plist->bindValue(':show',(int) $show,PDO::PARAM_INT);
						$plist->bindValue(':lim',(int) $lim,PDO::PARAM_INT);
						$plist->execute();

						if($s > ceil($total / $lim)){
							$s = 1;
						}
						
						?>

						<div class="col-lg-9 order-1 order-lg-2">
							<!-- Shop-Content End -->
							<div class="shop-content mt-tab-30 mb-30 mb-lg-0">
								<div class="product-option mb-30 clearfix">
									<!-- Nav tabs -->
									<p class="mb-0"><?php echo $catrow->katbaslik;?> Ürünler (<?php echo $total;?>)</p>
								</div>
								<!-- Tab panes -->
								<div class="tab-content">
									<div class="tab-pane active" id="grid-view">							
										<div class="row">
											<!-- Single-product start -->
											<?php if($plist->rowCount()){
												$price = 0;
												foreach($plist as $row){
												if(@$bgift > 0){
													$price = $row["urunfiyat"] - (($row["urunfiyat"] * $bgift) / 100);
												}else{
													$price  = $row["urunfiyat"];
												}
											?>
											<div class="col-lg-4 col-md-6">
												<div class="single-product">
													<div class="product-img">
														
														<span class="pro-price-2"><?php echo $price."₺"; ?></span>
														<a href="<?php echo site."/product/".$row['urunsef']; ?>"><img height="100" id="img1" width="100" src="<?php echo $site;?>/uploads/product/<?php echo $row['urunkapakresim'];?>" alt="<?php echo $row['urunbaslik']; ?>" /></a>
													</div>
													<div class="product-info clearfix text-center">
														<div class="fix">
															<h4 class="post-title"><a href="<?php echo site."/product/".$row['urunsef']; ?>"><?php echo $row['urunbaslik']; ?></a></h4>
														</div>
														<div class="fix">
															
														</div>
														<div class="product-action clearfix">
															<a href="<?php echo site."/product/".$row['urunsef'];?>" style="width:100%;" title="Ürün detay"><i class="zmdi zmdi-arrow-right"></i>Ürün detay</a>
														</div>
													</div>
												</div>
											</div>
											<?php } }else{
												 alert2("Ürün bulunmamaktadır", "danger");
												} ?>
										</div>
									</div>
								</div>
								<!-- Pagination start -->
								<div class="shop-pagination text-center">
									<div class="pagination">
										<ul>
											<?php 
											
											if($total > $lim){
												pagination($s, ceil($total / $lim), 'category/'.$catsef.'/s/');
											}
											
											?>
										</ul>
									</div>
								</div>
								<!-- Pagination end -->
							</div>
							<!-- Shop-Content End -->
						</div>
					</div>
				</div>
			</div>
			<!-- PRODUCT-AREA END -->
			<!-- FOOTER START
<?php require_once 'inc/footer.php';?>