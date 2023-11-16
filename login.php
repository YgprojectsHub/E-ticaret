
<?php 
define("security",true);
require_once 'inc/header.php';

if($_SESSION){
if(@$_SESSION['login'] == @sha1(md5(IP().$bcode))){
    go(site);
}	
}

?>
<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">

	<!-- HEADER-AREA START -->
	<?php require_once 'inc/menu.php'?>
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
							<h2>Giriş / Kayıt</h2>
						</div>
						<div class="breadcumbs pb-15">
							<ul>
								<li><a href="<?php echo site; ?>">Ana Sayfa</a></li>
								<li>Giriş / Kayıt</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- HEADING-BANNER END -->
	<!-- SHOPPING-CART-AREA START -->
	<div class="login-area  pt-80 pb-80">
		<div class="container">
				<div class="row">
					<div class="col-lg-6">
					<form action="" method="POST" onsubmit="return false;" id="bloginform">	
						<div class="customer-login text-left">
							<h4 class="title-1 title-border text-uppercase mb-30">BAYİ GİRİŞ</h4>
							<input type="text" placeholder="Bayi e-posta ya da bayi kodu" name="bec">
							<input type="password" placeholder="Bayi şifresi" name="bpass">
							<p><a href="#" class="text-gray">Şifremi unuttum</a></p>
							<button type="submit" id="loginbuton" onclick="loginbutton();" class="button-one submit-button mt-15">GİRİŞ YAP</button>
						</div>		
					</form>				
					</div>			


					<div class="col-lg-6">
					<form action="" method="POST" onsubmit="return false;" id="bregisterform">	
						<div class="customer-login text-left">
							<h4 class="title-1 title-border text-uppercase mb-30">BAYİ KAYIT</h4>
							<input type="text" placeholder="Bayi adı" name="bname">
							<input type="text" placeholder="Bayi e-posta" name="bmail">
							<input type="password" placeholder="Bayi şifresi" name="bpass">
							<input type="password" placeholder="Bayi şifresi tekrarı" name="bpass2">
							<input type="text" placeholder="Bayi telefon numarası" name="bphone">
							<input type="text" placeholder="Bayi vergi numarası" name="bvno">
							<input type="text" placeholder="Bayi vergi dairesi" name="bvd">
							<button type="submit" id="registerbuton" onclick="registerbutton();" class="button-one submit-button mt-15">KAYIT OL</button>
						</div>					
					</div>
					</form>
				</div>
		</div>
	</div>
<?php require_once 'inc/footer.php'?>