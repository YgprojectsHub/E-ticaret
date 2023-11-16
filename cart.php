<?php define("security",true); require_once 'inc/header.php'?>
		<!-- WRAPPER START -->
		<div class="wrapper bg-dark-white">

			<!-- HEADER-AREA START -->
			<?php require_once 'inc/menu.php';
			
                if(@$_SESSION['login'] != @sha1(md5(IP().$bcode))){
                    go(site);
                }
			
			?>
			<!-- HEADER-AREA END -->
			<!-- Mobile-menu start -->
			<?php require_once 'inc/mobilemenu.php'?>

			<?php
			
			$shopping = $db->prepare("SELECT * FROM sepet INNER JOIN urunler ON urunler.urunkodu = sepet.sepeturun WHERE sepetbayi=:sp");
			$shopping->execute(['sp' => $bcode]);

			if(isset($_GET['productdelete'])){
			    $code =  get("code");
			    $delete = $db->prepare("DELETE FROM sepet WHERE sepeturun=:su AND sepetbayi=:sb");
			    $delete->execute(['su' => $code, 'sb' => $bcode]);
			    go($_SERVER['HTTP_REFERER']);
			}

			if(isset($_GET['qtybutton'])){
				$pcode =  get("pcode");
				$qty = get("qtybutton");

				if($pcode && $qty){
				
                $prows = $db->prepare("SELECT urunkodu,urunfiyat,urundurum FROM urunler WHERE urunkodu=:uk");
                $prows->execute([':uk' => $pcode]);
                $prow = $prows->fetch(PDO::FETCH_OBJ);

				if($bgift > 0){
					$price = $prow->urunfiyat - (($prow->urunfiyat * $bgift) / 100);
					
				}else{
					$price  = $prow->urunfiyat;
				}

				$totalprice = $price * $qty;
				$tax = $totalprice * ($arow->sitekdv / 100);
				$subtotal = $totalprice + $tax;

				$result2 = $db->prepare("UPDATE sepet SET sepetadet=:sa , birimfiyat=:bi , toplamfiyat=:tf , kdv=:ka WHERE sepeturun=:su AND sepetbayi=:sb");
                $result2->execute([
				':sa' => $qty,
				':bi' => $price,
				':tf' => $subtotal,
				':ka' => $arow->sitekdv,
				':su' => $pcode,
				':sb' => $bcode
                ]);

				go($_SERVER['HTTP_REFERER']);
			    }
			}
			
			?>
			<!-- Mobile-menu end -->
			<!-- HEADING-BANNER START -->
			<div class="heading-banner-area overlay-bg">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="heading-banner">
								<div class="heading-banner-title">
									<h2>ALIŞVERİŞ SEPETİ</h2>
								</div>
								<div class="breadcumbs pb-15">
									<ul>
										<li><a href="<?php echo site; ?>">ANA SAYFA</a></li>
										<li>ALIŞVERİŞ SEPETİ</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- HEADING-BANNER END -->
			<!-- SHOPPING-CART-AREA START -->
			<div class="shopping-cart-area  pt-80 pb-80">
				<div class="container">	
					<div class="row">
						<div class="col-lg-12">
							<div class="shopping-cart">
								<!-- Nav tabs -->
								<ul class="cart-page-menu nav row clearfix mb-30">
									<li><a class="active" href="#shopping-cart" data-bs-toggle="tab">SEPETİM (<?php echo $shopping->rowCount(); ?>)</a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
									<!-- shopping-cart start -->
									<div class="tab-pane active" id="shopping-cart">
										<?php if($shopping->rowCount()){ ?>
										<div class="shop-cart-table">
											<div class="table-content table-responsive">
												<table>
													<thead>
														<tr>
															<th class="product-thumbnail">Ürün</th>
															<th class="product-price">Fiyat</th>
															<th class="product-quantity">Adet</th>
															<th class="product-subtotal">Toplam</th>
															<th class="product-remove">İşlem</th>
														</tr>
													</thead>
													<tbody>
														<?php $totalprice = 0; foreach ($shopping as $shopcart){ 
															$ptax = $cartrow['kdv'] == 0 ? '' : ' +KDV';
														?>
														<tr>
															<td class="product-thumbnail  text-left">
																<!-- Single-product start -->
																<div class="single-product">
																	<div class="product-img">
																		<a href="<?php echo site."/product/".$shopcart['urunsef'];?>"><img width="270" height="270" src="<?php echo site."/uploads/product/".$shopcart['urunkapakresim'];?>" alt="<?php echo $shopcart['urunbaslik'];?>"/></a>
																	</div>
																	<div class="product-info">
																		<h4 class="post-title"><a class="text-light-black" href="<?php echo site."/product/".$shopcart['urunsef'];?>"><?php echo $shopcart['urunbaslik'];?></a></h4>
																		
																	</div>
																</div>
																<!-- Single-product end -->												
															</td>
															<td class="product-price"><?php echo $shopcart['birimfiyat']." ₺";?></td>
															<form action="<?php echo site.'/cart';?>" method="GET">
															<td class="product-quantity">
																<input type="number" min="1" value="<?php echo $shopcart['sepetadet'];?>" name="qtybutton" class="cart-plus-minus-box">
																<input type="hidden" name="pcode" value="<?php echo $shopcart['sepeturun'];?>">
																<button type="submit" class="btn btn-default">Güncelle</button>
															</td>
															</form>
															<td class="product-subtotal"><?php echo $shopcart['toplamfiyat']." ₺";?></td>
															<td class="product-remove">
																<a onclick="return confirm('Ürünü sepetten silmek istiyor musunuz?');" href="<?php echo site.'/cart?productdelete&code='.$cartrow['sepeturun'];?>"><i class="zmdi zmdi-close"></i></a>
															</td>
														    
														</tr>
													</tbody>
														<?php 
													$totalprice += $cartrow['toplamfiyat']; }?>
													</tbody>
												</table>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="customer-login payment-details mt-30">
													<h4 class="title-1 title-border text-uppercase">Ödeme Seçenekleri</h4>
													<table>
														<tbody>
															<tr>
																<td class="text-left">KDV</td>
																<td class="text-end"><?php echo "%".$arow->sitekdv; ?></td>
															</tr>
															<tr>
																<td class="text-left">Genel Toplam</td>
																<td class="text-end"><?php echo $totalprice." ₺"; ?></td>
															</tr>
															<tr>
																<td class="text-left"></td>
																<td class="text-end"><a class="button-one submit-button mt-20" href="<?php echo site.'/checkout' ?>">ÖDEME YAP & SİPARİŞİ TAMAMLA</a></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="customer-login mt-30">
													<h4 class="title-1 title-border text-uppercase">culculate shipping</h4>
													<div class="row">
														<div class="col-md-4">
															<input type="text" placeholder="Country">
														</div>
														<div class="col-md-4">
															<input type="text" placeholder="Region / State">
														</div>
														<div class="col-md-4">
															<input type="text" placeholder="Post code">
														</div>
													</div>
													<button type="submit" data-text="get a quote" class="button-one submit-button mt-15">get a quote</button>
												</div>											
											</div>
										</div>

										<?php }else{alert2("Sepetinizde ürün bulunmuyor","warning");} ?>		
									</div>
									<!-- shopping-cart end -->
									<!-- wishlist start -->

									<!-- order-complete end -->
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- SHOPPING-CART-AREA END -->
			<!-- FOOTER START -->
			<footer>
				<!-- Footer-area start -->
<?php require_once 'inc/footer.php'?>