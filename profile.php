<?php define("security",true); require_once "inc/header.php"; 

if(@$_SESSION['login'] != @sha1(md5(IP().$bcode))){
    go(site);
}

?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<style>
.pagination {
background: transparent!important;
display: flex;
padding: 20px!important;
}
.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #c8a165;
    border-color: #c8a165;
}
select {
  background: #f6f6f6 none repeat scroll 0 0;
  border: medium none;
  box-shadow: none;
  color: #999;
  height: 40px;
  margin-bottom: 15px;
  padding: 0 20px;
  transition: all 0.5s ease 0s;
  width: 100%;
  outline: none;
}
textarea {
  background: #f6f6f6 none repeat scroll 0 0;
  border: medium none;
  box-shadow: none;
  color: #999;
  height: 40px;
  margin-bottom: 15px;
  padding: 0 20px;
  transition: all 0.5s ease 0s;
  width: 100%;
  outline: none;
}
input[type="date"] {
  background: #f6f6f6 none repeat scroll 0 0;
  border: medium none;
  box-shadow: none;
  color: #999;
  height: 40px;
  margin-bottom: 15px;
  padding: 0 20px;
  transition: all 0.5s ease 0s;
  width: 100%;
  outline: none;
}
input[type="file"] {
  background: #f6f6f6 none repeat scroll 0 0;
  border: medium none;
  box-shadow: none;
  color: #999;
  height: 40px;
  margin-bottom: 15px;
  padding: 0 20px;
  transition: all 0.5s ease 0s;
  width: 100%;
  outline: none;
}
</style>
		<!-- WRAPPER START -->
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
									<h2>Bayi Profil</h2>
								</div>
								<div class="breadcumbs pb-15">
									<ul>
										<li><a href="#">Ana sayfa</a></li>
										<li>Bayi Profil</li>
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
						<div class="col-lg-3 order-2 order-lg-1">
							<!-- Widget-Search start -->

							<!-- Widget-search end -->
							<!-- Widget-Categories start -->
							<aside class="widget widget-categories  mb-30">
								<div class="widget-title">
									<h4>Menü</h4>
								</div>
								<div id="cat-treeview"  class="widget-info product-cat boxscrol2">
									<ul>
										<li><a href="<?php echo site."/profile?process=profile"; ?>"><span>Profil Bilgileri</span></a></li>
										<li><a href="<?php echo site."/profile?process=changepass"; ?>"><span>Şifremi Değiştir</span></a></li>
										<li><a href="<?php echo site."/profile?process=logo"; ?>"><span>Logo Düzenle</span></a></li>
										<li><a href="<?php echo site."/profile?process=order"; ?>"><span>Siparişlerim</span></a></li>        
										<li><a href="<?php echo site."/profile?process=adress"; ?>"><span>Adreslerim</span></a></li>
										<li><a href="<?php echo site."/profile?process=notification"; ?>"><span>Havale Bildirimlerim</span></a></li>
										<li><a href="<?php echo site."/cart"; ?>"><span>Sepetim</span></a></li>  
										<li><a href="<?php echo site."/logout"; ?>"><span>Çıkış Yap</span></a></li>                                        
									</ul>
								</div>
							</aside>
							<!-- Widget-categories end -->
							<!-- Shop-Filter start -->
							<!-- Widget-banner end -->
						</div>
						<div class="col-lg-9 order-1 order-lg-2">
							<?php 
							
							$process = get('process');
							if(!$process){
								go(site.'/profile?process=profile');
							}
							switch($process){

								case 'logo';
								    if(isset($_POST['logoupdate'])){
										$dosya=$_FILES["logoimage"]["name"];
										if($dosya != ""){
											if(str_ends_with($dosya,".jpg") || str_ends_with($dosya,".png")){
												
												move_uploaded_file($_FILES["logoimage"]["tmp_name"],"uploads/customer/".$_FILES["logoimage"]["name"]);
												$up = $db->prepare("UPDATE bayiler SET bayilogo=:lg WHERE bayikodu=:bk");
												$up->execute([
													':lg' => $dosya,
													':bk' => $bcode
												]);  
												if($up){
													alert2("Profil fotoğrafınız başarıyla yüklendi", "success");
													go(site."/profile?process=logo",2);
												}
												
											}
											else{
												echo alert2("Sadece png ve jpg formatı geçerlidir","danger");
												go(site."/profile?process=logo",3);
											}      
										}
										else{
											echo alert2("Lütfen dosya seçiniz","danger");
											go(site."/profile?process=logo",3);
										}
									}
								    ?>
									<form action="" enctype="multipart/form-data" method="POST">	
                                        <div class="customer-login text-left">
                                        <h4 class="title-1 title-border text-uppercase mb-30">LOGO GÜNCELLE</h4>
										<img src="<?php echo site."/uploads/customer/".$blogo;?>" width="100" height="100" alt="<?php echo $bcode;?>" >
                                        <input type="file" placeholder="Bayi logo" name="logoimage">               
                                        <button type="submit" name="logoupdate" class="button-one submit-button mt-15">LOGO GÜNCELLE</button>
                                        </div>		
                                        </form>
									<?php
								break;

								case 'newnotification';
								?> 
								<form action="" method="POST" onsubmit="return false;" id="newnotificationform">	
								<div class="customer-login text-left">
								<h4 class="title-1 title-border text-uppercase mb-30">YENİ HAVALE BİLDİRİMİ EKLE</h4>
								
								<select name="hbank">
								<option value="0" redonly>Havale yaptığınız bankayı seçiniz</option>
									<?php 
								        $banks = $db->prepare("SELECT * FROM bankalar WHERE bankadurum=:d");
										$banks->execute([':d' => 1]);
										if($banks->rowCount()){
											foreach($banks as $bank){
												echo '<option value="'.$bank['bankaid'].'">'.$bank['bankaadi'].'</option>';
											}
										}
									?>
								</select>
								<input type="date" placeholder="Havale tarih" name="hdate">
								<input type="text" placeholder="Havale saati" name="hhours">
								<input type="text" placeholder="Havale tutarı" name="hprice">
								<textarea name="hdesc" placeholder="Havale açıklaması"></textarea>
								
								<button type="submit" id="newnotificationn" onclick="newnotification();" class="button-one submit-button mt-15">HAVALE BİLDİRİMİ YAP</button>
								</div>		
								</form>
							
							    <?php
								break;

								case 'notification':
												
									$address = $db->prepare("SELECT * FROM havalebildirim INNER JOIN bankalar ON bankalar.bankaid=havalebildirim.banka WHERE havalebayi=:b");
									$address->execute([':b' => $bcode]);
									?>
									<div class="shop-content mt-tab-30 mb-30 mb-lg-0">
									<div class="product-option mb-30 clearfix">
										<ul class="nav d-block shop-tab">
											<li>Havale Bildirimlerim (<?php echo $address->rowCount();?>)</li>
											<li><a href="<?php echo site;?>/profile.php?process=newnotification">[Bildirim Ekle]</a></li>
										</ul>
									</div>
									<div class="login-area">
									<div class="container">
									<div class="row">
									<div class="table-responsive">
										<?php 
										if($address->rowCount()){
	
										
										?>
										<table class="table table-hover" id="b2btable">
											<thead>
												<tr>
												<th>ID</th>
												<th>TARİH</th>
												<th>TUTAR</th>
												<th>BANKA</th>
												<th>NOT</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($address as $addres){ ?>
													<tr>
													<td><a href="#" title="Adres Düzenle">#<?php  echo $addres["id"];?></a></td>
													<td><?php  echo dt($addres["havaletarih"])." | ".$addres['havalesaat'];?></td>
													<td><?php  echo $addres["havaletutar"];?> ₺</td>
													<td><?php  echo $addres["bankaadi"];?></td>
													<td><?php  echo $addres["havalenot"];?></td>
													</tr>
												<?php }?>
											</tbody>
										</table>
										<?php }else{
											alert2("Bildirim bulunmuyor","danger");
										}?>
									</div>
									</div>
									</div>
									</div>									
									</div>
										<?php
								break;	

								case 'order':
												
								$orders = $db->prepare("SELECT * FROM siparisler INNER JOIN durumkodlari ON durumkodlari.durumkodu = siparisler.siparisdurum WHERE siparisbayi=:b");
								$orders->execute([':b' => $bcode]);
								?>
                                <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
								<div class="product-option mb-30 clearfix">
									<ul class="nav d-block shop-tab">
										<li>Siparişlerim (<?php echo $orders->rowCount();?>)</li>
									</ul>
								</div>
                                <div class="login-area">
                                <div class="container">
                                <div class="row">
                                <div class="table-responsive">
									<?php 
									if($orders->rowCount()){

									
									?>
									<table class="table table-hover" id="b2btable">
										<thead>
											<tr>
											<th>KOD</th>
											<th>DURUM</th>
											<th>TUTAR</th>
											<th>ÖDEME TÜRÜ</th>
											<th>TARİH</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($orders as $order){ ?>
												<tr>
												<td><a href="<?php echo site."/profile?process=orderdetail&id=".$order['sipariskodu']; ?>" title="Sipariş Detayı"><?php  echo $order["sipariskodu"];?></a></td>
												<td><?php  echo $order["durumbaslik"];?></td>
												<td><?php  echo $order["siparistutar"];?> ₺</td>
												<td><?php  echo $order["siparisodeme"] == 1 ? 'Havale' : 'Kredi Kartı';?></td>
												<td><?php  echo dt($order["siparistarih"])."|".$order['siparissaat']?></td>
												</tr>
											<?php }?>
										</tbody>
									</table>
									<?php }else{
										alert2("Siparişiniz bulunmuyor","danger");
									}?>
								</div>
                                </div>
                                </div>
                                </div>									
								</div>
									<?php
								break;	

								case 'orderdetail':

								$code = get('id');

								if(!$code) {
									go(site);
								}
												
								$orders = $db->prepare("SELECT * FROM siparis_urunler INNER JOIN siparisler ON siparisler.sipariskodu = siparis_urunler.sipkodu WHERE siparisbayi=:b AND sipariskodu=:code");
								$orders->execute([':b' => $bcode, ':code' => $code]);
								?>
								<div class="shop-content mt-tab-30 mb-30 mb-lg-0">
								<div class="product-option mb-30 clearfix">
									<ul class="nav d-block shop-tab">
										<li><?php echo $code." nolu siparişin detayları (".$orders->rowCount().")"; ?></li>
										<li><a href="<?php echo $site."/profile?process=order"; ?>"> Listeye dön</a></li>
									</ul>
								</div>
								<div class="login-area">
								<div class="container">
								<div class="row">
								<div class="table-responsive">
									<?php 
									if($orders->rowCount()){

									
									?>
									<table class="table table-hover" id="b2btable">
										<thead>
											<tr>
											<th>ÜRÜN KODU</th>
											<th>ÜRÜN FİYAT</th>
											<th>ÜRÜN ADET</th>
											<th>TOPLAM FİYAT</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($orders as $order){ ?>
												<tr>
												<td><?php  echo $order["sipurunadi"];?></td>
												<td><?php  echo $order["sipbirim"];?> ₺</td>
												<td><?php  echo $order["sipadet"];?></td>
												<td><?php  echo $order["siptoplam"]." ₺"?></td>
												</tr>
											<?php }?>
										</tbody>
									</table>
									<?php }else{
										alert2("Siparişinize ait bulunmuyor","danger");
									}?>
								</div>
								</div>
								</div>
								</div>									
								</div>
									<?php
								break;

								case 'adressdelete';
								    $id = get('id');
									if(!$id){
										go(site);
									}
									else{
										$address = $db->prepare("SELECT * FROM bayi_adresler WHERE adresbayi=:b AND id=:id");
										$address->execute([':b' => $bcode, ':id' => $id]);

										if($query->rowCount()){
											$delete = $db->prepare("UPDATE bayi_adresler SET adresdurum=:d WHERE adresbayi=:b AND id=:id");
											$delete->execute([':d' => 2,':b' => $bcode, ':id' => $id]);
											if($delete){
												alert2("Adresiniz pasife alındı", "success");
												go($_SERVER['HTTP_REFERER'],2);
											}else{
												alert2("Hata oluştu","danger");
											}
										}else{
											go(site);
										}
									}
								break;

								case 'newaddress';
								    ?> 

                                        <form action="" method="POST" onsubmit="return false;" id="newaddressform">	
                                        <div class="customer-login text-left">
                                        <h4 class="title-1 title-border text-uppercase mb-30">YENİ ADRES EKLE</h4>
                                        <input type="text" placeholder="Adres başlık" name="title">
                                        <input type="text" placeholder="Açık adres" name="content">
                                        
                                        <button type="submit" id="newaddres" onclick="newaddress();" class="button-one submit-button mt-15">ADRES EKLE</button>
                                        </div>		
                                        </form>
									
									<?php
								break;

								case 'adressedit';
								    $id = get('id');
									if(!$id){
										go(site);
									}
									else{
										$address = $db->prepare("SELECT * FROM bayi_adresler WHERE adresbayi=:b AND id=:id");
										$address->execute([':b' => $bcode, ':id' => $id]);

										if($address->rowCount()){
											$row = $address->fetch(PDO::FETCH_OBJ);
											?>
                                                <form action="" method="POST" onsubmit="return false;" id="addressform">	
                                                <div class="customer-login text-left">
                                                <h4 class="title-1 title-border text-uppercase mb-30"><?php $row->adresbaslik;?> | ADRESİNİ DÜZENLE</h4>
                                                <input type="text" value= "<?php echo $row->adresbaslik;?>" placeholder="Adres başlık" name="title">
                                                <input type="text" value= "<?php echo $row->adrestarif;?>" placeholder="Açık adres" name="content">
                                                
												<select name="status">
													<option value="1" <?php echo $row->adresdurum == 1 ? 'selected' : null; ?>>Aktif</option>
													<option value="2" <?php echo $row->adresdurum == 2 ? 'selected' : null; ?>>Pasif</option>
												</select>

												<input type="hidden" value="<?php echo $row-> id;?>" name="adressid" />
												
												<button type="submit" id="adressbuton" onclick="adresbuton();" class="button-one submit-button mt-15">ADRES GÜNCELLE</button>
                                                </div>		
                                                </form>
											<?php
										}else{
											go(site);
										}
									}
								break;

								case 'adress':
												
								$address = $db->prepare("SELECT * FROM bayi_adresler WHERE adresbayi=:b");
								$address->execute([':b' => $bcode]);
								?>
								<div class="shop-content mt-tab-30 mb-30 mb-lg-0">
								<div class="product-option mb-30 clearfix">
									<ul class="nav d-block shop-tab">
										<li>Adreslerim (<?php echo $address->rowCount();?>)</li>
										<li><a href="<?php echo site;?>/profile?process=newaddress">[Adres Ekle]</a></li>
									</ul>
								</div>
								<div class="login-area">
								<div class="container">
								<div class="row">
								<div class="table-responsive">
									<?php 
									if($address->rowCount()){

									
									?>
									<table class="table table-hover" id="b2btable">
										<thead>
											<tr>
											<th>ID</th>
											<th>BAŞLIK</th>
											<th>AÇIK ADRES</th>
											<th>DURUM</th>
											<th>İŞLEM</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($address as $addres){ ?>

												<tr>
												<td><?php  echo $addres["id"];?></td>
												<td><?php  echo $addres["adresbaslik"];?></td>
												<td><?php  echo $addres["adrestarif"];?></td>
												<td><?php  echo $addres["adresdurum"] == 1 ? 'Aktif' : 'Pasif';?></td>
												<td>
													<a href="<?php echo site;?>/profile?process=adressedit&id=<?php echo $addres["id"];?>" title="Adres Düzenle"><i style="font-size: 20px;" class="zmdi zmdi-edit"></i></a>
													|
													<a href="<?php echo site;?>/profile?process=adressdelete&id=<?php echo $addres["id"];?>" title="Adres Sil"><i style="font-size: 20px;" class="zmdi zmdi-close"></i></a>
												</td>	
												</tr>

											<?php }?>
										</tbody>
									</table>
									<?php }else{
										alert2("Adres bulunmuyor","danger");
									}?>
								</div>
								</div>
								</div>
								</div>									
								</div>
									<?php
								break;	

								case 'profile':
								?>
								<div class="shop-content mt-tab-30 mb-30 mb-lg-0">
								<div class="product-option mb-30 clearfix">
									<ul class="nav d-block shop-tab">
										<li>Profil Bilgileri</li>
									</ul>
								</div>
                                <div class="login-area">
                                <div class="container">
                                <div class="row">

                                <form action="" method="POST" onsubmit="return false;" id="profileform">	
                                <div class="customer-login">

								<label for="">Bayi Kodu:</label>
                                <input type="text" disable value="<?php echo $bcode; ?>"name="bec">

								<label for="">Bayi Adı:</label>
                                <input type="text" value="<?php echo $bname; ?>"name="bname" placeholder="Bayi Adı">

								<label for="">Bayi Mail:</label>
                                <input type="text" value="<?php echo $bmail; ?>"name="bmail" placeholder="Bayi Maili">

								<label for="">Bayi Telefon:</label>
                                <input type="text" value="<?php echo $bphone; ?>"name="bphone" placeholder="Bayi Telefon Numarası">

								<label for="">Bayi Fax:</label>
                                <input type="text" value="<?php echo $bfax; ?>"name="bfax" placeholder="Bayi Fax">

								<label for="">Bayi Vergi Numarası:</label>
                                <input type="text" value="<?php echo $bvno; ?>"name="bvno" placeholder="Bayi Vergi Numarası">

								<label for="">Bayi Vergi Dairesi:</label>
                                <input type="text" value="<?php echo $bvd; ?>"name="bvd" placeholder="Bayi Vergi Dairesi">

								<label for="">Bayi Site Adresi:</label>
                                <input type="text" value="<?php echo $bweb; ?>"name="bsite" placeholder="Bayi Site Adresi">

                                <button type="submit" onclick="profilebutton();" id="profilbuton" class="button-one submit-button mt-15">PROFİLİMİ GÜNCELLE</button>
                                </div>		
                                </form>		
                                
                                </div>
                                </div>
                                </div>									
								</div>
								
								
								<?php
								break;

								case 'changepass':
									?>
									<div class="shop-content mt-tab-30 mb-30 mb-lg-0">
									<div class="product-option mb-30 clearfix">
										<ul class="nav d-block shop-tab">
											<li>Şifemi Değiştir</li>
										</ul>
									</div>
									<div class="login-area">
									<div class="container">
									<div class="row">
	
									<form action="" method="POST" onsubmit="return false;" id="passwordform">	
									<div class="customer-login">
	
									<label for="">Yeni şifreniz:</label>
									<input type="password" name="password" placeholder="Yeni şifrenizi giriniz">
	
									<label for="">Yeni şifre tekrar:</label>
									<input type="password" name="password2" placeholder="Yeni şifrenizi tekrar giriniz">
	
									<button type="submit" onclick="passwordbutton();" id="passwordbuton" class="button-one submit-button mt-15">PROFİLİMİ GÜNCELLE</button>
									</div>		
									</form>		
									
									</div>
									</div>
									</div>									
									</div>
									
									
									<?php
									break;
							}
							
							?>
						</div>
							</div>
							<!-- Shop-Content End -->
						</div>
					</div>
				</div>
			</div>
			<!-- PRODUCT-AREA END -->
			<!-- FOOTER START -->
<?php require_once 'inc/footer.php';?>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
	$(document).ready(function () {
    $('#b2btable').DataTable();
});
</script>