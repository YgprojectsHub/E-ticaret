<?php define("security",true); require_once 'inc/header.php'; ?>
		<!-- WRAPPER START -->
		<div class="wrapper bg-dark-white">

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
									<h2>Bize Ulaşın</h2>
								</div>
								<div class="breadcumbs pb-15">
									<ul>
										<li><a href="<?php echo site;?>">Ana Sayfa</a></li>
										<li>Bize Ulaşın</li>
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
					<div class="contact-us customer-login bg-white">
						<div class="row">
							<div class="col-lg-4 col-md-5">
								<div class="contact-details">
									<h4 class="title-1 title-border text-uppercase mb-30">İletişim Detayları</h4>
									<ul>
										<li>
											<i class="zmdi zmdi-pin"></i>
											<span>Adres: <?php echo $arow->adres?></span>
										</li>
										<li>
											<i class="zmdi zmdi-phone"></i>
											<span>Telefon No: <?php echo $arow->tel?></span>
											<span>Fax: <?php echo $arow->fax?></span>
										</li>
										<li>
											<i class="zmdi zmdi-email"></i>
											<span>Eposta: <?php echo $arow->eposta?></span>
										</li>
									</ul>
								</div>
								<div class="send-message mt-60">
									<form id="contactform" method="POST" action="" onsubmit="return false;">
										<h4 class="title-1 title-border text-uppercase mb-30">Mesaj Gönder</h4>
										<input type="text" name="con_name" placeholder="İsminiz..." />
										<input type="text" name="con_email" placeholder="Emailiniz..." />
										<input type="text" name="con_subject" placeholder="Konu..." />
										<textarea class="custom-textarea" name="con_message" placeholder="Konu içeriği..."></textarea>
										<button class="button-one submit-button mt-20" data-text="submit message" onclick="sendmessage();" id="sendmessages" type="submit">Mesajı Gönder</button>
									</form>
								</div>
							</div>
							<div class="col-lg-8 col-md-7 mt-xs-30">
								<div class="map-area">
									<?php echo $arow->map;?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php require_once 'inc/footer.php'?>