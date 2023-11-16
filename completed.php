<?php  define("security",true); require_once 'inc/header.php'?>
	<!-- WRAPPER START -->
	<div class="wrapper bg-dark-white">

		<!-- HEADER-AREA START -->
		<?php require_once 'inc/menu.php';?>
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
								<h2>TEŞEKKÜRLER</h2>
							</div>
							<div class="breadcumbs pb-15">
								<ul>
									<li><a href="<?php echo $site; ?>">ANA SAYFA</a></li>
									<li>TEŞEKKÜRLER</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- HEADING-BANNER END -->
		<!-- contact-us-AREA START -->
		<div class="contact-us-area  pt-80 pb-80">
			<div class="container">	
				<div class="thankyour-area bg-white mb-30">
					<div class="row">
						<div class="col-md-12">
							<div class="thankyou">
								<h2 class="text-center mb-0">Siparişiniz için teşekkürler sipariş listesine dönmek için <a href="<?php echo $site;?>/profile?process=order">tıklayınız.</a></h2>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php require_once 'inc/footer.php'?>