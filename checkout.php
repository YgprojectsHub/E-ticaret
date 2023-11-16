<?php 
define("security",true); 
require_once 'inc/header.php'; 
if(@$_SESSION['login'] != @sha1(md5(IP().$bcode))){
	go(site);
}
?>
		<!-- WRAPPER START -->
		<div class="wrapper bg-dark-white";>

			<!-- HEADER-AREA START -->
			<?php require_once 'inc/menu.php'?>
			<!-- HEADER-AREA END -->
			<!-- Mobile-menu start -->
			<?php require_once 'inc/mobilemenu.php'?>
			<!-- Mobile-menu end -->
			<!-- HEADING-BANNER START -->
			<div class="heading-banner-area overlay-bg">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="heading-banner">
								<div class="heading-banner-title">
									<h2>ÖDEME EKRANI</h2>
								</div>
								<div class="breadcumbs pb-15">
									<ul>
										<li><a href="<?php echo site; ?>">Ana Sayfa</a></li>
										<li>Ödeme Ekranı</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- HEADING-BANNER END -->
			<!-- CHECKOUT-AREA START -->
			<div class="shopping-cart-area  pt-80 pb-80">
				<div class="container">	
					<div class="row">
						<div class="col-lg-12">
							<div class="shopping-cart">
								<!-- Nav tabs -->
								<ul class="cart-page-menu nav row clearfix mb-30">
									<li><a class="active" href="#check-out" data-bs-toggle="tab">ÖDEME</a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
									<!-- shopping-cart start -->
									<div class="tab-pane active" id="check-out">
										<form action="#" onsubmit="return false;" id="orderform" method="post">
											<div class="shop-cart-table check-out-wrap">
												<div class="row">
													<div class="col-md-12">
														<div class="billing-details pr-20">
															<h4 class="title-1 title-border text-uppercase mb-30">SİPARİŞ BİLGİLERİ</h4>
															<input type="text" name="name" value="<?php echo $bname;?>" placeholder="Siparişi teslim alacak bayi...">
															<input type="text" name="phone" value="<?php echo $bphone;?>" placeholder="Siparişi teslim alacak bayinin telefon numarası...">
															<textarea class="custom-textarea" name="note" placeholder="Sipariş notunuz..." ></textarea>
															<a href=""data-bs-toggle="modal"  data-bs-target="#addressmodal">[+Yeni Adres Ekle]</a>
															<select name="address" class="custom-select mb-15">
																<option value="0">Adres seçiniz</option>
																<?php 
																    $address = $db->prepare("SELECT * FROM bayi_adresler WHERE adresbayi=:ab AND adresdurum=:ad"); 
																    $address->execute([':ab' => $bcode, ':ad' => 1]);
																	if($address->rowCount()){
																	    foreach($address as $addres){
																?>
																<option value="<?php echo $addres['id']; ?>"><?php echo $addres['adresbaslik']." - ".$addres['adrestarif']; ?></option>
																<?php }} ?>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="our-order payment-details mt-60 pr-20">
															<h4 class="title-1 title-border text-uppercase mb-30">TOPLAM SİPARİŞLER</h4>
															<table>
																<thead>
																	<tr>
																		<th><strong>Ürün</strong></th>
																		<th class="text-end"><strong>Toplam</strong></th>
																	</tr>
																</thead>
																<tbody>
																	<?php 
																	
																	$prows = $db->prepare("SELECT * FROM sepet INNER JOIN urunler ON urunler.urunkodu = sepet.sepeturun WHERE sepetbayi=:uk");
																	$prows->execute([':uk' => $bcode]);

																	if($prows->rowCount()){
																		$total = 0;
																		foreach($prows as $prowdata){
																		$total += $prowdata["toplamfiyat"];
																	?>
																	<tr>
																		<td><?php echo $prowdata["urunbaslik"]." X ".$prowdata['sepetadet'];?></td>
																		<td class="text-end"><?php echo $prowdata["toplamfiyat"]." ₺"; ?></td>
																	</tr>

																	<?php } ?>
																	<tr>
																		<td>Toplam Tutar</td>
																		<td class="text-end"><?php echo $total." ₺";?></td>
																	</tr>																	
																	<?php } ?>
																</tbody>
															</table>
														</div>
													</div>
													<!-- payment-method -->
													<div class="col-md-6">
														<div class="payment-method mt-60  pl-20">
															<h4 class="title-1 title-border text-uppercase mb-30">ÖDEME YÖNTEMİ</h4>
															<div class="payment-accordion">
															<select name="payment" class="custom-select mb-15">
																<option value="0">Ödeme yöntemi seçiniz</option>
																<option value="1">Havale/EFT</option>
																<option value="1">Kredi Kartı</option>
															</select>		
															</div>															
														</div>

														<button type="submit" onclick="ordercomplete();" id="ordercomplet" class="button-one submit-button mt-20 ml-20">SİPARİŞİ TAMAMLA</button>
													</div>
												</div>
											</div>
										</form>											
									</div>
									<!-- check-out end -->
									<!-- order-complete start -->

									<!-- order-complete end -->
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- CHECKOUT-AREA END -->
			<!-- FOOTER START -->
<?php require_once 'inc/footer.php'?>

<div class="modal fade" id="addressmodal" tabindex="1000" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="modal-product">
					<div class="product-info" style="width:90%">
						<h1>Yeni Adres Ekle</h1>
						

						<div class="quick-add-to-cart">
							<form method="post" class="cart" onsubmit="return false;" id="newaddressform">
								<div >
									<input type="text" name="title" placeholder="Adres başlık">

									<input type="text" name="content" placeholder="Açık adresiniz">
								</div>
								<button onclick='newaddress()' id='newaddres' class="single_add_to_cart_button" type="submit">YENİ ADRES EKLE</button>
							</form>

						</div>
						
						
					</div><!-- .product-info -->
				</div><!-- .modal-product -->
			</div><!-- .modal-body -->
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div>