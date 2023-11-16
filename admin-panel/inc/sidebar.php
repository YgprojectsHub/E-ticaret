<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
        <div>
          <p class="app-sidebar__user-name">Hoşgeldiniz, <?php echo $aname; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item active" href="<?php echo admin; ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Ana Sayfa</span></a></li>
        <li><a class="app-menu__item" href="<?php echo admin."/customers.php"; ?>"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Bayiler</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Kategoriler</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?php echo admin."/categories.php"; ?>"><i class="icon fa fa-circle-o"></i> Kategori Listesi</a></li>
            <li><a class="treeview-item" href="<?php echo b2b("newcategory"); ?>"><i class="icon fa fa-circle-o"></i> Yeni Kategori Ekle</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="<?php echo admin."/products.php"; ?>" data-toggle="treeview"><i class="app-menu__icon fa fa-gift"></i><span class="app-menu__label">Ürünler</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?php echo admin."/products.php"; ?>"><i class="icon fa fa-circle-o"></i> Ürün Listesi</a></li>
            <li><a class="treeview-item" href="<?php echo b2b("newproduct"); ?>"><i class="icon fa fa-circle-o"></i> Yeni Ürün Ekle</a></li>
          </ul>
        </li>
        <li><a class="app-menu__item" href="<?php echo admin."/orders.php"; ?>"><i class="app-menu__icon fa fa-shopping-cart"></i><span class="app-menu__label">Siparişler</span></a></li>
        
        <li><a class="app-menu__item" href="<?php echo admin."/cart.php"; ?>"><i class="app-menu__icon fa fa-shopping-basket"></i><span class="app-menu__label">Sepete Eklenen Ürünler</span></a></li>
        
        <li><a class="app-menu__item" href="<?php echo admin."/notifications.php"; ?>"><i class="app-menu__icon fa fa-bullhorn"></i><span class="app-menu__label">Havale Bildirimleri</span></a></li>
        
        <li><a class="app-menu__item" href="<?php echo admin."/comments.php"; ?>"><i class="app-menu__icon fa fa-comments"></i><span class="app-menu__label">Ürün Yorumları</span></a></li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">Sipariş Durum Kodları</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?php echo admin."/statuscodes.php"; ?>"><i class="icon fa fa-circle-o"></i> Durum Kodu Listesi</a></li>
            <li><a class="treeview-item" href="<?php echo b2b("newstatuscode"); ?>"><i class="icon fa fa-circle-o"></i> Yeni Durum Kodu Ekle</a></li>
          </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-bank"></i><span class="app-menu__label">Bankalar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?php echo admin."/banklist.php"; ?>"><i class="icon fa fa-circle-o"></i> Banka Listesi</a></li>
            <li><a class="treeview-item" href="<?php echo b2b("newbank"); ?>"><i class="icon fa fa-circle-o"></i> Yeni Banka Ekle</a></li>
          </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-envelope"></i><span class="app-menu__label">Mesajlar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?php echo admin."/newmessages.php"; ?>"><i class="icon fa fa-circle-o"></i> Yeni Mesajlar</a></li>
            <li><a class="treeview-item" href="<?php echo admin."/oldmessages.php"; ?>"><i class="icon fa fa-circle-o"></i> Geçmiş Mesajlar</a></li>
          </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-file"></i><span class="app-menu__label">Sayfalar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?php echo admin."/pages.php"; ?>"><i class="icon fa fa-circle-o"></i> Sayfa Listesi</a></li>
            <li><a class="treeview-item" href="<?php echo b2b("newpage"); ?>"><i class="icon fa fa-circle-o"></i> Yeni Sayfa Ekle</a></li>
          </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cogs"></i><span class="app-menu__label">Ayarlar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?php b2b("generalsettings"); ?>"><i class="icon fa fa-circle-o"></i> Genel Ayarlar</a></li>
            <li><a class="treeview-item" href="<?php b2b("logosettings"); ?>"><i class="icon fa fa-circle-o"></i> Logo Ayarları</a></li>
            <li><a class="treeview-item" href="<?php b2b("smtpsettings"); ?>"><i class="icon fa fa-circle-o"></i> SMTP Ayarları</a></li>
            <li><a class="treeview-item" href="<?php b2b("contactsettings"); ?>"><i class="icon fa fa-circle-o"></i> İletişim Ayarları</a></li>
          </ul>
        </li>
      </ul>
    </aside>