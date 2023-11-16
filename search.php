<?php 

define("security",true);

require_once "inc/header.php"; ?>
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
			#img1{
				padding: 15px;
			}
            .pro-price-2 {
                color: #c87065;
                font-size: 18px;
                font-weight: 700;
                line-height: 1;
                position: absolute;
                right: 15px;
                top: 0.1px;
            }
		</style>
		<div class="wrapper bg-dark-white">

			<!-- HEADER-AREA START -->
			<?php require_once "inc/menu.php"; ?>
			<!-- HEADER-AREA END -->
			<!-- Mobile-menu start -->
			<?php require_once "inc/mobilemenu.php"; ?>
			<!-- Mobile-menu end -->
			<!-- HEADING-BANNER START -->
			<div class="heading-banner-area overlay-bg">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="heading-banner">
								<div class="heading-banner-title">
									<h2>ÜRÜN ARAMA SONUÇLARI</h2>
								</div>
								<div class="breadcumbs pb-15">
									<ul>
										<li><a href="<?php echo site; ?>">Ana Sayfa</a></li>
										<li>ÜRÜN ARAMA SONUÇLARI</li>
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

						$s = @intval(get('s'));
						if(!$s){
							$s = 1;
						}

						$pname =  @get("q");
						$kat =    @get("kat");
						$price1 = @get("price1");
						$price2 = @get("price2");

						$sql = "SELECT * FROM urunler";
						$where = null;
						$execute=[];

						if($pname){
							$where .= " urunbaslik LIKE :baslik AND urundurum=:d AND ";
							$execute[":baslik"] = "%$pname%";
							$execute[":d"] = 1;
						}

						if($kat){
							$where .= " urunkat LIKE :kat AND urundurum=:d AND ";
							$execute[":kat"] = "%$kat%";
							$execute[":d"] = 1;
						}

						if($price1){
							$where .= " urunfiyat >= :price1 AND urundurum=:d AND ";
							$execute[":price1"] = $price1;
							$execute[":d"] = 1;
						}

						if($price2){
							$where .= " urunfiyat <= :price2 AND urundurum=:d AND ";
							$execute[":price2"] = $price2;
							$execute[":d"] = 1;
						}

						if($where != null){
							$sql .= ' WHERE ' .$where;
							$sql = rtrim($sql, ' AND ');
						}

						$query = $db->prepare($sql);
						$query->execute($execute);

						$total  = $query->rowCount();
						$lim  = 12;
						$showw = $s * $lim - $lim;

						$query2 = $db->prepare($sql." ORDER BY uruntarih DESC LIMIT $showw,$lim");
						$query2->execute($execute);

						if($s > ceil($total / $lim)){
							$s = 1;
						}
						
						?>

						<div class="col-lg-9 order-1 order-lg-2">
							<!-- Shop-Content End -->
							<div class="shop-content mt-tab-30 mb-30 mb-lg-0">
								<div class="product-option mb-30 clearfix">
									<!-- Nav tabs -->
									<p class="mb-0">Ürün Arama Listesi (<?php echo $total;?>)</p>
								</div>
								<!-- Tab panes -->
								<div class="tab-content">
									<div class="tab-pane active" id="grid-view">							
										<div class="row">
											<!-- Single-product start -->
											<?php if($query2->rowCount()){
												$price = 0;
												foreach($query2 as $row){
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
														<a href="<?php echo site."/product/".$row['urunsef']; ?>"><img height="100" id="img1" width="100" src="./uploads/product/<?php echo $row['urunkapakresim'] ;?>" alt="<?php echo $row['urunbaslik']; ?>" /></a>
													</div>
													<div class="product-info clearfix text-center">
														<div class="fix">
															<h4 class="post-title"><a href="<?php echo site."/product/".$row['urunsef']; ?>"><?php echo $row['urunbaslik']; ?></a></h4>
														</div>
														<div class="fix">
															
														</div>
														<div class="product-action clearfix">
															<a href="<?php echo site."/product/".$row['urunsef']; ?>" title="Ürün detay"><i class="zmdi zmdi-arrow-right"></i>Ürün detay</a>
														</div>
													</div>
												</div>
											</div>
											<?php } }else{
												 alert2("Kriterlere göre ürün bulunmamaktadır", "danger");
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
												pagination($s, ceil($total / $lim), 'search.php?q='.$pname.'&kat='.$kat."&fiyat1=".$price1."&fiyat2=".$price2."");
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