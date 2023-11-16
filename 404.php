<?php 
define('security',true);
require_once 'inc/header.php'; ?>
		<!-- WRAPPER START -->
		<div class="wrapper bg-dark-white">

			<!-- HEADER-AREA START -->
			<?php require_once 'inc/menu.php'; ?>

			<!-- HEADER-AREA END -->
			<!-- Mobile-menu start -->
			<?php require_once 'inc/mobilemenu.php'; ?>

			<!-- Mobile-menu end -->
			<!-- HEADING-BANNER START -->
			<div class="heading-banner-area overlay-bg">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="heading-banner">
								<div class="heading-banner-title">
									<h2>404</h2>
								</div>
								<div class="breadcumbs pb-15">
									<ul>
										<li><a href="<?php echo site; ?>">Home</a></li>
										<li>404</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- HEADING-BANNER END -->
			<!-- 404-AREA START -->
			<div class="area-404 pt-80 pb-80">
				<div class="container">	
					<div class="row">
						<div class="col-lg-12">
							<div class="error-content text-center">
								<img src="img/bg/error.png" alt="" />
								<h4 class="text-light-black mt-60">Ooops.... Error 404</h4>
								<h5 class="text-light-black">Sorry, But the page you are looking for does't exist</h5>
								<div class="error-form mt-30 mb-30">
									<form action="#">
										<input type="text" placeholder="Search here..."/>
										<button type="submit"><i class="zmdi zmdi-search"></i></button>
									</form>
								</div>
								<p class="text-uppercase">Or</p>
								<a class="button-one submit-btn-4 go-to-home bg-white text-uppercase text-light-black" href="<?php echo site;?>" data-text="go to home page" >go to home page</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 404-AREA END -->		
<?php require_once 'inc/footer.php'; ?>
