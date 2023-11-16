<?php echo !defined("security") ? die() : null; ?>

<div class="mobile-menu-area">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 d-block d-md-none">
				<div class="mobile-menu">
					<nav id="dropdown">
					<ul>
					<li><a href="<?php echo site; ?>">Ana Sayfa</a></li>
							<li><a href="<?php echo site; ?>">Ürünler</a></li>
							<?php if(!isset($_SESSION['login'])){?>
							<li><a href="<?php echo site; ?>/login-register">Kayıt Ol</a></li>
							<li><a href="<?php echo site; ?>/login-register">Giriş Yap</a></li>
							<?php }else{?>
								<li><a href="<?php echo site; ?>/profile?process=profile">Hesabım</a></li>
								<li><a href="<?php echo site; ?>/contact-us">Bize Ulaşın</a></li>
								<li><a onclick="return confirm('Onaylıyormusunuz ?');" href="<?php echo site; ?>/logout">Çıkış Yap</a></li>
							<?php }?>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>