
<?php require_once 'systemadmin/function.php';?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>B2b - Admin Panel</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>B2b - Admin Panel</h1>
      </div>
      <?php 
      
      if(isset($_POST["adminlogin"])){
        $email = post("email");
        $password = post("pass");
        $crpto = sha1(md5($password));

        if(!$email || !$password){
          alert2("Lütfen boş alan bırakmayınız.","danger");
        }
        else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
          alert2("E-posta formatı hatalı", "danger");
        }else{
          $alogin = $db->prepare("SELECT * FROM admin WHERE admin_posta=:ap AND admin_sifre=:s");
          $alogin->execute([
            ":ap" => $email,
            "s" => $crpto
          ]);
          if($alogin->rowCount()){
            $adminrow = $alogin->fetch(PDO::FETCH_OBJ);

            if($adminrow->admin_durum == 1){

              $_SESSION["adminlogin"] = sha1(md5(IP().$adminrow->admin_id));

              $_SESSION["adminid"] = $adminrow->admin_id;
              alert2("Yönetici girişiniz başarılı yönlendiriliyorsunuz","success");
              go(admin,2);

              $logadd = $db->prepare("INSERT INTO adminlog SET 
              alogadminid=:id,
              alogdesc=:descc
              ");

              $logadd->execute([
                ":id" => $adminrow->admin_id,
                ":descc" => "Yönetici giriş yaptı."
              ]);
            }else{
              alert2("Yöneticiliğiniz açığa alınmıştır","danger");
            }
          }else{
            alert2("Bu hesap bilgilerine ait yönetici hesabı bulunamadı","danger");
          }
        }     
        }
      }

      ?>
      <div class="login-box">
        <form class="login-form" action="" method="POST">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>YÖNETİCİ GİRİŞİ</h3>
          <div class="form-group">
            <label class="control-label">E-posta</label>
            <input name="email" class="form-control" type="text" placeholder="E-posta" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">Şifre</label>
            <input name="pass" class="form-control" type="password" placeholder="Şifre">
          </div>
          <div class="form-group btn-container">
            <button type="submit" name="adminlogin" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>GİRİŞ YAP</button>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
  </body>
</html>