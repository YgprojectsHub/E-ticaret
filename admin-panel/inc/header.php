<?php require_once "./systemadmin/function.php";

if( @$_SESSION['adminlogin'] != sha1(md5(IP().$aid)) ){
go(admin."/adminlogin.php");
}

$lastmessages = $db->prepare("SELECT * FROM mesajlar WHERE mesajdurum=:d ORDER BY id DESC LIMIT 10");
$lastmessages->execute([
  ":d" => 2
]);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>B2b - Admin Panel</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <style>
      #page_list {
        padding:16px;
        background-color: #f9f9f9;
        border: 1px dotted #ccc;
        cursor: move;
        margin-top: 12px;
      }

      #page_list li.ui-state-highlight{
        padding-top: 24px;
        background-color: #ffffcc;
        border-top: 1px dotted #ccc;
        cursor: move;
        margin-top: 12px;
      }
    </style>
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?php echo admin;?>">Admin</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!--Notification Menu-->
        
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications"><i class="fa fa-bell-o fa-lg"></i></a>

          <ul class="app-notification dropdown-menu dropdown-menu-right">
            <li class="app-notification__title">Mesajlar (<?php echo $lastmessages->rowCount(); ?>)</li>
            <div class="app-notification__content">
              <?php if($lastmessages->rowCount()){ 

                foreach($lastmessages as $lastmessage){
 
                ?>
              <li><a class="app-notification__item" href="<?php b2b("messageview", $lastmessage['id']); ?>">
                  <div>
                    <p class="app-notification__message"><?php echo $lastmessage["mesajkonu"]; ?></p>
                    <p class="app-notification__meta"><?php echo dt($lastmessage["mesajtarih"]); ?></p>
                  </div>
                </a>
              </li>
              <li>
                <?php }}else{alert2("Mesaj bulunmuyor","warning");} ?>
            </div>
            <li class="app-notification__footer"><a href="#">Tüm Yeni Mesajlar</a></li>
          </ul>

        </li>

        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i><?php echo " - ".$aname; ?></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
          <li><a class="dropdown-item" href="<?php echo site; ?>" target="_blank"><i class="fa fa-link fa-lg"></i> Siteye Git</a></li>
            <li><a class="dropdown-item" href="<?php b2b("profile"); ?>"><i class="fa fa-user fa-lg"></i> Profilim</a></li>
            <li><a class="dropdown-item" href="<?php b2b("resetpassword"); ?>"><i class="fa fa-lock fa-lg"></i> Şifremi Değiştir</a></li>
            <li><a class="dropdown-item" href="<?php b2b("logout"); ?>" onclick="return confirm('Çıkış Yapmak İstiyormusunuz?');"><i class="fa fa-sign-out fa-lg"></i> Çıkış Yap</a></li>
          </ul>
        </li>
      </ul>
    </header>