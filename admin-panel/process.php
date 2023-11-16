<?php require_once "inc/header.php" ?>
    <!-- Sidebar menu-->
    <?php require_once "inc/sidebar.php";?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-edit"></i> <?php echo @get("process"); ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">İşlemler</li>
          <li class="breadcrumb-item"><a href="#"><?php echo @get("process"); ?></a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">

        <?php 
        
        $process = get("process");
        if(!$process){
          go(admin);
        }

        switch($process){

          case "resetpassword":

            if($_POST){
              $pass = post("pass");
              $passrepeat = post("repeat");
              $crypto_pass = sha1(md5($pass));

              if(!$pass){
                alert2("Bilgileri Boş Bırakmayınız","danger");
              }else{
              if($pass != $passrepeat){
                alert2("Yeni şifre şifre tekrara eşit değil","danger");
              }else{
              $up = $db->prepare("UPDATE admin SET admin_sifre=:a WHERE admin_id=:id");
              $up->execute([":a" => $crypto_pass , ":id" => $aid]);
              if($up){
                alert2("Başarıyla güncellendi","success");
                go($_SERVER["HTTP_REFERER"],2);
              }else{
                alert2("Hata Oluştu","danger"); 
              } 
              }           
              }
            }

            ?>
            
            <div class="tile">
              <h3 class="tile-title">Şifre Güncelle</h3>
              <form action="" method="post">            
              <div class="tile-body">
  
                <div class="form-group">
                  <label class="control-label">Yeni Şifre</label>
                  <input class="form-control" name="pass" type="text"  placeholder="Yeni şifre">
                </div>

                <div class="form-group">
                  <label class="control-label">Şifre Tekrar</label>
                  <input class="form-control" name="repeat" type="text"  placeholder="Şifre tekrar">
                </div>

              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin;?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Panele Dön</a>
              </div>
              </div>
              </form>
            </div>

            <?php
          break;          

          case "profile":

            if($_POST){
              $kadi = post("kadi");
              $eposta = post("eposta");

              if(!$kadi || !$eposta){
                alert2("Bilgileri Boş Bırakmayınız","danger");
              }else{
              $up = $db->prepare("UPDATE admin SET admin_kadi=:a , admin_posta=:p WHERE admin_id=:id");
              $up->execute([":a" => $kadi , ":p" => $eposta , ":id" => $aid]);
              if($up){
                alert2("Başarıyla güncellendi","success");
                go($_SERVER["HTTP_REFERER"],2);
              }else{
                alert2("Hata Oluştu","danger"); 
              }            
              }


            }

            ?>
            
            <div class="tile">
              <h3 class="tile-title">Profili Güncelle</h3>
              <form action="" method="post">            
              <div class="tile-body">
  
                <div class="form-group">
                  <label class="control-label">Kullanıcı Adı</label>
                  <input class="form-control" value="<?php echo $aname; ?>" name="kadi" type="text"  placeholder="Kullanıcı Adı">
                </div>

                <div class="form-group">
                  <label class="control-label">E-posta</label>
                  <input class="form-control" value="<?php echo $amail; ?>" name="eposta" type="text"  placeholder="E-posta">
                </div>

              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin;?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Panele Dön</a>
              </div>
              </div>
              </form>
            </div>

            <?php
          break;

          case "logout":
            session_destroy();
            go(admin."/adminlogin.php");
          break;

          case "contactsettings":

            if(isset($_POST["upp"])){
              $tel = post("tel");
              $fax = post("fax");
              $eposta = post("eposta");
              $map = $_POST["map"];
              $adres = post("adres");

              if(!$tel || !$fax || !$eposta || !$map || !$adres){
                alert2("Bilgileri Doldurunuz","danger");
              }else{
                $up = $db->prepare("UPDATE ayarlar SET tel=:tel , fax=:fax , eposta=:eposta , map=:map , adres=:adres WHERE id=:id");
                $result = $up->execute([":tel" => $tel, ":fax" => $fax, ":eposta" => $eposta, ":map" => $map , ":adres" => $adres, ":id" => 1]);
                if($result){
                  alert2("İletişim Bilgileri Başarıyla Güncellendi","success");
                  go($_SERVER["HTTP_REFERER"],2);
                }else{
                  alert2("Hata Oluştu","danger");
                }
              }
            }

            ?>
            
            <div class="tile">
              <h3 class="tile-title">İletişim Ayarlarını Güncelle</h3>
              <form action="" method="post">            
              <div class="tile-body">
  
                <div class="form-group">
                  <label class="control-label">Telefon Numarası</label>
                  <input class="form-control" value="<?php echo $arow->tel; ?>" name="tel" type="text"  placeholder="Telefon numarası">
                </div>

                <div class="form-group">
                  <label class="control-label">Fax</label>
                  <input class="form-control" value="<?php echo $arow->fax; ?>" name="fax" type="text"  placeholder="Fax">
                </div>

                <div class="form-group">
                  <label class="control-label">E-posta</label>
                  <input class="form-control" value="<?php echo $arow->eposta; ?>" name="eposta" type="email"  placeholder="E-posta">
                </div>

                <div class="form-group">
                  <label class="control-label">Adres</label>
                  <input class="form-control" value="<?php echo $arow->adres; ?>" name="adres" type="text"  placeholder="Adres">
                </div>

                <div class="form-group">
                  <label class="control-label">Harita</label>
                  <textarea class="form-control" name="map" rows="8" ><?php echo $arow->map; ?></textarea>
                </div>

              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin;?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Panele Dön</a>
              </div>
              </div>
              </form>
            </div>

            <?php
          break;

          case "smtpsettings":
            
            if(isset($_POST["upp"])){
              $smtphost = post("smtphost");
              $smtpmail = post("smtpmail");
              $smtpsifre = post("smtpsifre");
              $smtpsec = post("smtpsec");
              $smtpport = post("smtpport");
              $smtpkime = post("smtpkime");
              
              if(!$smtphost || !$smtpmail || !$smtpsifre || !$smtpsec || !$smtpport || !$smtpkime){
                go(admin);
              }else{
                $up = $db->prepare("UPDATE ayarlar SET smtphost=:sh , smtpmail=:sm , smtpsifre=:ss , smtpsec=:sec , smtpport=:sport , smtpkime=:sk WHERE id=:id");
                $result = $up->execute([":sh" => $smtphost, ":sm" => $smtpmail, ":ss" => $smtpsifre , ":sec" => $smtpsec, ":sport" => $smtpport , ":sk" => $smtpkime , ":id" => 1]);

                if($result){
                  alert2("SMTP Ayarları Başarıyla Güncellendi","success");
                  go($_SERVER["HTTP_REFERER"],2);
                }else{
                  alert2("Hata Oluştu","danger");
                }
              }
            }

            ?>
            
            <div class="tile">
              <h3 class="tile-title">SMTP Ayarlarını Güncelle</h3>
              <form action="" method="post">            
              <div class="tile-body">
  
                <div class="form-group">
                  <label class="control-label">SMTP Host</label>
                  <input class="form-control" value="<?php echo $arow->smtphost; ?>" name="smtphost" type="text"  placeholder="Smtp host">
                </div>

                <div class="form-group">
                  <label class="control-label">SMTP Mail</label>
                  <input class="form-control" value="<?php echo $arow->smtpmail; ?>" name="smtpmail" type="email"  placeholder="Smtp mail">
                </div>

                <div class="form-group">
                  <label class="control-label">SMTP Şifre</label>
                  <input class="form-control" value="<?php echo $arow->smtpsifre; ?>" name="smtpsifre" type="text"  placeholder="Smtp şifre">
                </div>

                <div class="form-group">
                  <label class="control-label">SMTP Güvenlik Protokolü ( tls - ssl )</label>
                  <input class="form-control" value="<?php echo $arow->smtpsec; ?>" name="smtpsec" type="text"  placeholder="Smtp güvenlik protokolü">
                </div>

                <div class="form-group">
                  <label class="control-label">SMTP Port</label>
                  <input class="form-control" value="<?php echo $arow->smtpport; ?>" name="smtpport" type="text"  placeholder="Smtp port">
                </div>

                <div class="form-group">
                  <label class="control-label">SMTP Alıcı E-posta</label>
                  <input class="form-control" value="<?php echo $arow->smtpkime; ?>" name="smtpkime" type="text"  placeholder="Smtp alıcı e-posta">
                </div>

              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin;?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Panele Dön</a>
              </div>
              </div>
              </form>
            </div>

            <?php
          break;

          case "logosettings":
            
            if(isset($_POST["upp"])){

              $dosya =$_FILES["simage"]["name"];
              if($dosya != ""){
                if(str_ends_with($dosya,".jpg") || str_ends_with($dosya,".png")){
                    
                  move_uploaded_file($_FILES["simage"]["tmp_name"],"../uploads/logo/".$_FILES["simage"]["name"]);
                  unlink("../uploads/logo/".$arow->sitelogo);
                  $up = $db->prepare("UPDATE ayarlar SET sitelogo=:blg WHERE id=:k");
                  $up->execute([':blg' => $dosya,':k' => 1]);  
                  if($up){
                    alert2("Site logosu başarıyla güncellendi", "success");
                    go($_SERVER["HTTP_REFERER"],2);
                  }else{
                    alert2("Hata oluştu", "danger");
                  }
                }
                else{
                  alert2("Sadece png ve jpg formatı geçerlidir","danger");
                } 
              } 

            }

            ?>
            
            <div class="tile">
              <h3 class="tile-title">Logo Güncelle</h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
                <div class="form-group">
                  <label class="control-label">Site Logo</label>
                  <br>
                  <img src="<?php echo $site;?>/uploads/logo/<?php echo $arow->sitelogo; ?>" width="200" height="200" alt="<?php echo $arow->sitelogo;?>">
                  <br>
                  <input class="form-control" type="file" name="simage">
                </div>

              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin;?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
              </form>

            <?php
          break;

          case "generalsettings":

            if(isset($_POST["upp"])){
              $sname = post("sname");
              $surl = post("surl");
              $skeyw = post("skeyw");
              $sdesc = post("sdesc");
              $skdv = post("skdv");
              $sstatus = post("sstatus");
              $sorderstatus = post("sorderstatus");

              if(!$sname || !$surl || !$sorderstatus || !$sdesc || !$sstatus || !$skdv || !$skeyw) {     
              }else{
                $up = $db->prepare("UPDATE ayarlar SET sitebaslik=:sb , siteurl=:su , sitekeyw=:sk , sitedesc=:sd , sitekdv=:skk , sitesiparisdurum=:ssd , sitedurum=:sited WHERE id=:id");
                $result = $up->execute([":sb" => $sname, ":su" => $surl , ":sk" => $skeyw , ":sd" => $sdesc , ":skk" => $skdv, ":ssd" => $sorderstatus , ":sited" => $sstatus , ":id" => 1]);     

                if($result){
                  alert2("Ayarlar Güncellenmiştir","success");
                  go($_SERVER["HTTP_REFERER"],2);
                }else{
                  alert2("Hata Oluştu","danger");
                }
              }
            }
            
            ?>
            
            <div class="tile">
              <h3 class="tile-title">Genel Ayarlar</h3>
              <form action="" method="post">            
              <div class="tile-body">
  
                  <div class="form-group">
                    <label class="control-label">Site Başlık</label>
                    <input class="form-control" value="<?php echo $arow->sitebaslik; ?>" name="sname" type="text"  placeholder="Site bşlık">
                  </div>
  
                  <div class="form-group">
                    <label class="control-label">Site URL</label>
                    <input class="form-control" value="<?php echo $arow->siteurl; ?>" name="surl" type="text" placeholder="Site url">
                  </div>

                  <div class="form-group">
                    <label class="control-label">Site Anahtar Kelimeler</label>
                    <input class="form-control" value="<?php echo $arow->sitekeyw; ?>" name="skeyw" type="text" placeholder="Site keys">
                  </div>
  
                  <div class="form-group">
                    <label class="control-label">Site Açıklıama</label>
                    <input class="form-control"value="<?php echo $arow->sitedesc; ?>" name="sdesc" type="text" placeholder="Site açıklama">
                  </div>

                  <div class="form-group">
                    <label class="control-label">Site KDV</label>
                    <input class="form-control" value="<?php echo $arow->sitekdv; ?>" type="number" name="skdv" placeholder="Site kdv">
                  </div>

                  <div class="form-group">
                    <label class="control-label" >Site Durumu</label>
                    <select  class="form-control" name="sstatus">
                      <option <?php echo $arow->sitedurum == 1 ? "selected" : null ;?> value="1">Aktif</option>
                      <option <?php echo $arow->sitedurum == 2 ? "selected" : null ;?> value="2">Bakım Modu</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="control-label" >Site Sipariş Durumu</label>
                    <select  class="form-control" name="sorderstatus">
                      <option <?php echo $arow->sitesiparisdurum == 1 ? "selected" : null ;?> value="1">Aktif</option>
                      <option <?php echo $arow->sitesiparisdurum == 2 ? "selected" : null ;?> value="2">Pasif</option>
                    </select>
                  </div>

              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin;?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Panele Dön</a>
              </div>
              </div>
              </form>
            </div>

            <?php
          break;

          case "pageedit":
            $id = get('id');
            if(!$id){
            go(admin);
            }       
            
            $pages = $db->prepare("SELECT * FROM sayfalar WHERE id=:b");
            $pages->execute([':b' => $id]);
            if($pages->rowCount()){
              $pagerow = $pages->fetch(PDO::FETCH_OBJ);

              if(isset($_POST["upp"])){
                $name= post("pname");
                $seourl= post("purl");
                $status = post("pagestatus");
                if(!$id){
                  go(admin);
                }
                if(!$seourl){
                  $sef= sef_link($name);
                }else{
                $sef= $seourl;                        
                }
                $pcontent= $_POST["pcontent"];
                $dosya=$_FILES["pimage"]["name"];
                
                if(!$name || !$pcontent || !$status || !$sef){
                  alert2("Tüm Alanları Doldurunuz","danger");
                }else{

                  $already = $db->prepare("SELECT id,sef FROM sayfalar WHERE sef=:k AND id!=:id");
                  $already->execute([
                    ":k" => $sef,
                    ":id" => $id
                  ]);

                  if(!$already->rowCount()){
                  if($dosya != ""){
                    if(str_ends_with($dosya,".jpg") || str_ends_with($dosya,".png")){
                        
                      move_uploaded_file($_FILES["pimage"]["tmp_name"],"../uploads/".$_FILES["pimage"]["name"]);
                      $up = $db->prepare("UPDATE sayfalar SET baslik=:kb, sef=:s, icerik=:keyw, kapak=:de , durum=:d WHERE id=:id");
                      $up->execute([':kb' => $name,':s' => $sef,':keyw' => $pcontent,':de' => $dosya, ":d" => $status , ":id" => $id]);  
                        
                      @unlink("../uploads/".$pagerow->kapak);
                    }
                    else{
                      alert2("Sadece png ve jpg formatı geçerlidir","danger");
                    } 
                  }else{

                    move_uploaded_file($_FILES["pimage"]["tmp_name"],"../uploads/".$_FILES["pimage"]["name"]);
                    $up = $db->prepare("UPDATE sayfalar SET baslik=:kb, sef=:s, icerik=:keyw , durum=:d WHERE id=:id");
                    $up->execute([':kb' => $name,':s' => $sef,':keyw' => $pcontent, ":d" => $status , ":id" => $id]);  

                  } 
                  if($up){
                    alert2("Sayfa başarıyla güncellendi", "success");
                    go($_SERVER["HTTP_REFERER"],2);
                  }else{
                    alert2("Hata oluştu", "danger");
                  }                          
                  }
                  else{
                    alert2("Zaten Bu Sayfa Var","danger");
                  }
                }
              }
              ?>
                            
              <div class="tile">
              <h3 class="tile-title"><?php $pagerow->baslik; ?> Adlı Sayfayı Düzenle</h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
              <div class="form-group">
                <label class="control-label">Sayfa Adı</label>
                <input class="form-control" name="pname" value="<?php echo $pagerow->baslik; ?>" type="text" placeholder="Sayfa adı">
              </div>

              <div class="form-group">
                <label class="control-label">Sayfa SEO URL örn(hakkimda-bla-bla-bla)</label>
                <input class="form-control" name="purl" value="<?php echo $pagerow->sef; ?>" type="text" placeholder="Sayfa SEO url">
              </div>

              <div class="form-group">
                <label class="control-label">Sayfa Kapak Resim</label>
                <img src="../uploads/<?php echo $pagerow->kapak; ?>" width="200" height="100" alt="<?php $pagerow->baslik; ?>">
                <span style="color: #b10021">* zorunlu değil</span>
                <input class="form-control" type="file" name="pimage">
              </div>

              <div class="form-group">
                <label class="control-label">Sayfa İçerik</label>
                <textarea class="ckeditor" name="pcontent" id="" cols="30" rows="10"><?php echo $pagerow->icerik; ?></textarea>
              </div>

              <div class="form-group">
                <label class="control-label">Durum</label>
                <select name="pagestatus" class="form-control">
                  <option <?php echo $pagerow->durum == 1 ? "selected" : null;?> value="1">Aktif</option>
                  <option <?php echo $pagerow->durum != 1 ? "selected" : null;?> value="2">Pasif</option>
                </select>
              </div>

              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/pages.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
              </form>

              <?php

            }else{
              go(admin);
            }
          break;

          case "messageview":
            $id = get('id');
            if(!$id){
            go(admin);
            }       
            
            $mesagges = $db->prepare("SELECT * FROM mesajlar WHERE id=:b");
            $mesagges->execute([':b' => $id]);
            
            if($mesagges->rowCount()){
              $mesaggerow = $mesagges->fetch(PDO::FETCH_OBJ);
              $up = $db->prepare("UPDATE mesajlar SET mesajdurum=:md WHERE id=:id");
              $up->execute([":md" => 1 , ":id" => $id]);

              ?>

              <div class="tile">
              <h3 class="tile-title"><?php echo $mesaggerow->mesajisim;?> Adlı bayiden yorum </h3>         
              <div class="tile-body">
  
              <p><b>İsim : </b><?php echo $mesaggerow->mesajisim; ?></p>
              <p><b>E-posta : </b><a href="mailto:<?php echo $mesaggerow->mesajposta; ?>" target="_blank"><?php echo $mesaggerow->mesajposta; ?></a></p>
              <p><b>Konu : </b><?php echo $mesaggerow->mesajkonu; ?></p>
              <p><b>İçerik : </b><?php echo $mesaggerow->mesajicerik; ?></p>
              <p><b>Durum : </b><?php echo $mesaggerow->durum; ?></p>
              <p><b>Tarih : </b><?php echo dt($mesaggerow->mesajtarih); ?></p>
              <p><b>IP : </b><?php echo $mesaggerow->mesajip; ?></p>

              <hr>
              <?php
              
              if(isset($_POST["reply"])){
                $content = post("content");
                $eposta = post("eposta");

                if(!$content || !$eposta){
                  alert2("Boş bırakmayınız","danger");
                }else{
                  //E-posta işlemleri
                }
              }
              
              ?>
              </form>
            
              <textarea class="form-control" rows="7" name="content" placeholder="Mesaj Yanıtınız..."></textarea>
              <br>
              <input type="hidden" name="eposta" value="<?php echo $mesaggerow->mesajposta; ?>">
              <button type="submit" name="reply" class="btn btn-success">Yanıtla</button>

              </form>
              
              </div>
              <div class="tile-footer">

              <a class="btn btn-secondary" href="<?php echo @$_SERVER["HTTP_REFERER"]; ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>

              <?php

            }else{
              go(admin);
            }
            
          break;
          
          case "bankedit":
            $id = get('id');
            if(!$id){
            go(admin);
            }       
            
            $banks = $db->prepare("SELECT * FROM bankalar WHERE bankaid=:b");
            $banks->execute([':b' => $id]);  

            if(isset($_POST["upp"])){
              $bankname = post("bankname");
              $bankno = post("bankno");
              $banksube = post("banksube");
              $bankıban = post("bankaıban");
              $bankstatus = post("bankstatus");

              if(!$bankname || !$bankno || !$bankstatus || !$bankıban || !$bankstatus){
                go(admin);
              }

              $statusedit = $db->prepare("SELECT bankaiban FROM bankalar WHERE bankaiban!=:k AND bankaadi=:id");
              $statusedit->execute([":k" => $bankıban,  ":id" => $id]);
              if($statusedit->rowCount()){
                alert2("Böyle bir iban zaten kayıtlı","danger");
              }else{
                $up = $db->prepare("UPDATE bankalar SET bankaadi=:db , bankahesap=:dk , bankasube=:ds , bankaiban=:di , bankadurum=:bd WHERE bankaid=:id");
                $result = $up->execute([":db" => $bankname , ":dk" => $bankno , ":ds" => $banksube , ":di" => $bankıban , ":bd" => $bankstatus , ":id" => $id]);
                if($result){
                  alert2("Banka bilgileri başarıyla güncellenmiştir","success");
                  go($_SERVER["HTTP_REFERER"],1);
                }else{
                  alert2("Bir hata oluştu","danger");                    
                }
              }

            }
            
            if($banks->rowCount()){
              $bankrow = $banks->fetch(PDO::FETCH_OBJ);
              ?>
              
              <div class="tile">
              <h3 class="tile-title"><?php echo $bankrow->bankaadi; ?> Adlı Banka Bilgilerini Güncelle</h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
                <div class="form-group">
                  <label class="control-label">Banka Adı</label>
                  <input class="form-control" value="<?php echo $bankrow->bankaadi; ?>" name="bankname" type="text" placeholder="Banka adı">
                </div>

                <div class="form-group">
                  <label class="control-label">Hesap Numarası</label>
                  <input class="form-control" value="<?php echo $bankrow->bankahesap; ?>" name="bankno" type="text" placeholder="Hesap numarası">
                </div>

                <div class="form-group">
                  <label class="control-label">Şube</label>
                  <input class="form-control" value="<?php echo $bankrow->bankasube; ?>" name="banksube" type="text" placeholder="Banka şube">
                </div>

                <div class="form-group">
                  <label class="control-label">Banka IBAN</label>
                  <input class="form-control" value="<?php echo $bankrow->bankaiban; ?>" name="bankaıban" type="text" placeholder="Banka ıban">
                </div>

                <div class="form-group">
                  <label class="control-label">Banka Durum</label>
                  <select name="bankstatus" class="form-control">
                    <option <?php echo $bankrow->bankadurum == 1 ? "selected" : null;?> value="1">Aktif</option>
                    <option <?php echo $bankrow->bankadurum != 1 ? "selected" : null;?> value="2">Pasif</option>
                  </select>
                </div>

              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/banklist.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
                </form>

              <?php

            }else{
              go(admin);
            }
          break;

          case "statusedit":


            $status = $db->prepare("SELECT * FROM durumkodlari WHERE id=:b");
            $status->execute([':b' => $id]); 

            if($status->rowCount()){
              $statusrow = $status->fetch(PDO::FETCH_OBJ);
              if(isset($_POST["upp"])){
                $name = post("name");
                $code = post("code");
                $Nstatus = post("durum");

                if(!$name || !$code || !$Nstatus){
                  alert2("Boş bırakmayınız","danger");
                }

                $statusedit = $db->prepare("SELECT id,durumkodu FROM durumkodlari WHERE durumkodu=:k AND id!=:id");
                $statusedit->execute([":k" => $code,  ":id" => $id]);
                if($statusedit->rowCount()){
                  alert2("Böyle bir durum kodu zaten kayıtlı","danger");
                }else{
                  $up = $db->prepare("UPDATE durumkodlari SET durumbaslik=:db , durumkodu=:dk , durumdurum=:dd WHERE id=:id");
                  $result = $up->execute([":db" => $name , ":dk" => $code , ":dd" => $Nstatus , ":id" => $id]);
                  if($result){
                    alert2("Durum kodu başarıyla güncellenmişir","success");
                    go($_SERVER["HTTP_REFERER"],2);
                  }else{
                    alert2("Bir hata oluştu","danger");                    
                  }
                }
              }
              ?>
              
              <div class="tile">
              <h3 class="tile-title"> <?php echo $statusrow->durumbaslik; ?> Adlı Durum Kodunu Güncelle</h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
                <div class="form-group">
                  <label class="control-label">Durum Kodu Adı</label>
                  <input class="form-control" name="name" type="text" value="<?php echo $statusrow->durumbaslik;?>" placeholder="Durum kodu adı">
                </div>

                <div class="form-group">
                  <label class="control-label">Durum Kodu</label>
                  <input class="form-control" name="code" min="1" type="number" value="<?php echo $statusrow->durumkodu;?>" placeholder="Durum kodu">
                </div>

                <div class="form-group">
                  <label class="control-label">Durum</label>
                  <select name="durum" class="form-control">
                    <option <?php echo $statusrow->durumdurum == 1 ? "selected" : null; ?> value="1">Aktif</option>
                    <option <?php echo $statusrow->durumdurum != 1 ? "selected" : null; ?> value="2">Pasif</option>
                  </select>
                </div>

              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/statuscodes.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
                </form>
              
              <?php

            }else{
              go(admin);
            }

          break;

          case 'commentactive':
            $id = get('id');
            if(!$id){
            go(admin);
            }
            
            $query = $db->prepare("SELECT id FROM urun_yorumlar WHERE id=:b");
            $query->execute([':b' => $id]);
            if($query->rowCount()){
            $up = $db->prepare("UPDATE urun_yorumlar SET yorumdurum=:yd WHERE id=:b");
            $result = $up->execute(['yd' => 1,':b'=>$id]);
            if($result){
            alert2('Ürün yorumu onaylandı','success');
            go($_SERVER["HTTP_REFERER"],2);
            }else{
            alert2('Hata oluştu','danger');
            }
            
            }else{
            go(admin);
            }
          break;

          
          case 'commentpassive':
            $id = get('id');
            if(!$id){
            go(admin);
            }
            
            $query = $db->prepare("SELECT id FROM urun_yorumlar WHERE id=:b");
            $query->execute([':b' => $id]);
            if($query->rowCount()){
            $up = $db->prepare("UPDATE urun_yorumlar SET yorumdurum=:yd WHERE id=:b");
            $result = $up->execute(['yd' => 2,':b'=>$id]);
            if($result){
            alert2('Ürün yorumu onayı kaldırıldı','success');
            go($_SERVER["HTTP_REFERER"],2);
            }else{
            alert2('Hata oluştu','danger');
            }
            
            }else{
            go(admin);
            }
          break;

          case 'commentdelete':
            $code = get('id');
            if(!$code){
            go(admin);
            }
            
            $query = $db->prepare("SELECT id FROM urun_yorumlar WHERE id=:b");
            $query->execute([':b' => $code]);
            if($query->rowCount()){
            $delete = $db->prepare("DELETE FROM urun_yorumlar WHERE id=:b");
            $result = $delete->execute([':b'=>$code]);
            if($result){
            alert2('Ürün yorumu silindi','success');
            go(admin."/comments.php",2);
            }else{
            alert2('Hata oluştu','danger');
            }
            
            }else{
            go(admin);
            }
          break;

          case 'messagedelete':
            $code = get('id');
            if(!$code){
            go(admin);
            }
            
            $query = $db->prepare("SELECT id FROM mesajlar WHERE id=:b");
            $query->execute([':b' => $code]);
            if($query->rowCount()){
            $delete = $db->prepare("DELETE FROM mesajlar WHERE id=:b");
            $result = $delete->execute([':b'=>$code]);
            if($result){
            alert2('Yorum silindi','success');
            go($_SERVER["HTTP_REFERER"],2);
            }else{
            alert2('Hata oluştu','danger');
            }
            
            }else{
            go(admin);
            }
          break;

          case 'orderdelete':
            $id = get('id');
            if(!$id){
            echo $id;
            }
            
            $query = $db->prepare("SELECT sipariskodu FROM siparisler WHERE sipariskodu=:b");
            $query->execute([':b' => $id]);
            if($query->rowCount()){
            $delete = $db->prepare("DELETE FROM siparisler WHERE sipariskodu=:b");
            $result = $delete->execute([':b'=>$id]);
            if($result){
            alert2('Sipariş silindi','success');
            go($_SERVER["HTTP_REFERER"],2);
            }else{
            alert2('Hata oluştu','danger');
            }
            
            }else{
            go(admin);
            }
          break;

          case "commentread":
            $id = get('id');
            if(!$id){
            go(admin);
            }
            
            $query = $db->prepare("SELECT * FROM urun_yorumlar INNER JOIN urunler ON urunler.urunkodu = urun_yorumlar.yorumurun WHERE urun_yorumlar.id=:b");
            $query->execute([':b' => $id]);
            if($query->rowCount()){
              $commentrow = $query->fetch(PDO::FETCH_OBJ);
              ?>
              
              <div class="tile">
              <h3 class="tile-title"><?php echo $commentrow->urunbaslik;?> Adlı ürüne ait yorum </h3>         
              <div class="tile-body">
  
              <p><b>Ürün Kodu : </b><?php echo $commentrow->yorumurun; ?></p>
              <p><b>Ürün Adı : </b><a target="_blank" href="<?php echo $site."/product/".$commentrow->urunsef; ?>"><?php echo $commentrow->urunbaslik; ?></a>
              <p><b>Bayi Adı : </b><?php echo $commentrow->yorumisim; ?></p>
              <p><b>Tarih : </b><?php echo dt($commentrow->yorumtarih)?></p>
              <p><b>Yorum : </b><?php echo $commentrow->yorumicerik; ?></p>
              <p><b>IP : </b><?php echo $commentrow->yorumip; ?></p>
              
              </div>
              <div class="tile-footer">

              <?php if($commentrow->yorumdurum == 1){ ?>

                <a class="btn btn-danger" href="<?php b2b('commentpassive',$id); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Onayı Kaldır</a>

              <?php }else{ ?>
                <a class="btn btn-success" href="<?php b2b('commentactive',$id); ?>"><i class="fa fa-fw fa-lg fa fa-check"></i>Onayla</a>
              <?php } ?>

              <a class="btn btn-warning" href="<?php b2b('commentdelete',$id); ?>"><i class="fa fa-fw fa-lg fa fa-check"></i>Yorumu Sil</a>

              <a class="btn btn-secondary" href="<?php echo admin."/comments.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>

              <?php
            }else{
              go(admin);
            }
          break;

          case 'notificationdelete':
            $code = get('id');
            if(!$code){
            go(admin);
            }
            
            $query = $db->prepare("SELECT id FROM havalebildirim WHERE id=:b");
            $query->execute([':b' => $code]);
            if($query->rowCount()){
            $delete = $db->prepare("DELETE FROM havalebildirim WHERE id=:b");
            $result = $delete->execute([':b'=>$code]);
            if($result){
            alert('Havale bildirimi silindi','success');
            go(admin."/notifications.php",2);
            }else{
            alert('Hata oluştu','danger');
            }
            
            }else{
            go(admin);
            }
          break;

          case "notificationdetail":
            $id = get('id');
            if(!$id){
              go(admin);
            }
            
            $notification = $db->prepare("SELECT * FROM havalebildirim WHERE id=:sk");
            $notification->execute([":sk" => $id]);

            if($notification->rowCount()){
              $notificationrow = $notification->fetch(PDO::FETCH_OBJ);

              $bquery = $db->prepare("SELECT bayikodu,bayiadı FROM bayiler WHERE bayikodu=:bk");
              $bquery->execute([":bk" => $notificationrow->havalebayi]);
              $bqueryrow = $bquery->fetch(PDO::FETCH_OBJ);

              $bankquery = $db->prepare("SELECT * FROM bankalar WHERE bankaid=:bi");
              $bankquery->execute([":bi" => $notificationrow->banka]);
              $bankqueryrow = $bankquery->fetch(PDO::FETCH_OBJ);
              ?>
              
              <div class="tile">
              <h3 class="tile-title"><?php echo $notificationrow->havalebayi;?> Nolu bayiye ait havale bildirimi </h3>         
              <div class="tile-body">
  
               <p><b>Bayi Kodu : </b><?php echo $notificationrow->havalebayi; ?></p>
               <p><b>Bayi Adı : </b><?php echo $bqueryrow->bayiadı; ?></p>
               <p><b>Havale Tarih : </b><?php echo dt($notificationrow->havaletarih)." | ".$notificationrow->havalesaat; ?></p>
               <p><b>Havale Banka : </b><?php echo $bankqueryrow->bankaadi ; ?></p>
               <p><b>Havale Tutar : </b><?php echo $notificationrow->havaletutar." ₺"; ?></p>
               <p><b>Havale Not : </b><?php echo $notificationrow->havalenot == "" ? "Belirtilmemiş": $notificationrow->havalenot ; ?></p>

               <hr />
              <?php 
              
              if($_POST){
              
                  $title   = post('title');
                  $content = post('content');
                  $email   = post('email');
              
                  if(!$title || !$content || !$email){
                      alert("Boş alan bırakmayınız","danger");
                  }else{
              
                    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                      alert("Geçersiz e-posta","danger");
                    }else{
                      //mail işlemleri
                    }
                  }
              }
              
              ?>
              <form action="" method="POST">
                  <input type="text" name="title" class="form-control"placeholder="Mail başlığı" />
                  <textarea name="content" class="form-control" rows="6" placeholder="Mail İçeriği"></textarea>
                  <input type="hidden" value="<?php echo $bqueryrow->bayimail;?>" name="email" />
                  <button type="submit" class="btn btn-primary">Mail Gönder</button>
              </form>

              </div>
              <div class="tile-footer">
                <a class="btn btn-secondary" href="<?php echo admin."/notifications.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
              
              <?php
            }else{
              go(admin);
            }
          break;

          case "orderupdate":
            if($_POST){
              $code = post("code");
              $email = post("mail");
              $status = post("orderstatus");

              if(!$code || !$email || !$status){
                echo alert2("Boş alan bırakmayınız","danger");
              }else{
                $order = $db->prepare("SELECT * FROM siparisler WHERE sipariskodu=:sk");
                $order->execute([":sk" => $code]);
    
                if($order->rowCount()){
                  $up = $db->prepare("UPDATE siparisler SET siparisdurum=:d WHERE sipariskodu=:sk");
                  $result = $up->execute([":d" => $status, ":sk" => $code]);
                  if($result) {
                    alert2("Sipariş başarıyla güncellendi","success");

                    if($email == 1){
                      #Email olayı
                    }

                    go($_SERVER['HTTP_REFERER'],2);
                  }
                }else{
                  alert2("Böyle bir sipariş yok","danger");
                }
              }
            }
          break;

          case "orderdetail":
            $code = get('id');
            if(!$code){
              go(admin);
            }
            
            $order = $db->prepare("SELECT * FROM siparisler WHERE sipariskodu=:sk");
            $order->execute([":sk" => $code]);

            if($order->rowCount()){
              $orderrow = $order->fetch(PDO::FETCH_OBJ);

              $address = $db->prepare("SELECT * FROM bayi_adresler WHERE id=:id");
              $address->execute([":id" => $orderrow->siparisadres]);
              $addressrow = $address->fetch(PDO::FETCH_OBJ);
            ?>
              <div class="tile">
              <section class="invoice">
                <div class="row mb-4">
                  <div class="col-6">
                    <h2 class="page-header"><i class="fa fa-globe"></i> <?php echo $orderrow->sipariskodu; ?> Kodlu Sipariş Bilgileri</h2>
                  </div>
                  <div class="col-6">
                    <h5 class="text-right">Sipariş Tarihi: <?php echo dt($orderrow->siparistarih)." | ".$orderrow->siparissaat; ?></h5>
                  </div>
                </div>
                <div class="row invoice-info">
                  <div class="col-4">Sipariş Bilgileri
                    <address><strong><?php echo $orderrow->siparisisim; ?></strong><br>
                    <strong>Adres</strong> : <?php echo $addressrow->adrestarif ?>
                    <br> <strong>Telefon</strong> : <?php echo $orderrow->siparistel; ?></address>
                  </div>
                  <div class="col-4"><b>Sipariş No : #<?php echo $orderrow->sipariskodu; ?></b><br></div>
                </div>

                <?php 
                
                $orderproduct = $db->prepare("SELECT * FROM siparis_urunler WHERE sipkodu=:sk");
                $orderproduct->execute([":sk" => $orderrow->sipariskodu]);

                if($orderproduct->rowCount()){
                ?>

                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>ÜRÜN KODU</th>
                          <th>ÜRÜN ADI</th>
                          <th>BİRİM FİYAT</th>
                          <th>ADET</th>
                          <th>TOPLAM FİYAT</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($orderproduct as $orderpr){
                          $total = 0;
                        ?>
                        <tr>
                          <td><?php echo $orderpr["sipurun"]; ?></td>
                          <td><?php echo $orderpr["sipurunadi"]; ?></td>
                          <td><?php echo $orderpr["sipbirim"]." ₺"; ?></td>
                          <td><?php echo $orderpr["sipadet"]; ?></td>
                          <td>$<?php echo $orderpr["siptoplam"]." ₺"; ?></td>
                        </tr>
                        <?php $total += $orderpr["siptoplam"]; ?>
                        <?php } ?>
                      </tbody>
                    </table>
                    <h4>GENEL TOPLAM : <?php echo $total." ₺"; ?></h4>
                  </div>
                </div>

                <?php 

                }else{
                  go(admin);
                }

              ?>
              <div class="row d-print-none mt-2">
                <div class="col-4 text-right">
                  <form action="<?php b2b("orderupdate");?>" method="POST">
                    <select name="orderstatus" class="form-control">
                      <option value="0" readonly >Sipariş Durumu Seç</option>
                    <?php 
                    
                    $statuslist = $db->prepare("SELECT * FROM durumkodlari WHERE durumdurum=:d");
                    $statuslist->execute([":d" => 1]);
                    if($statuslist->rowCount()){
                      foreach($statuslist as $stat){
                        ?>
                        <option <?php echo $stat['durumkodu'] == $orderrow->siparisdurum ? "selected" : Null ?> value="<?php echo $stat['durumkodu']; ?>"><?php echo $stat['durumbaslik']; ?></option>; 
                        <?php
                      }
                    }
    
                    ?>                    
                  </select>
  
                  <br>

                  <select name="mail" class="form-control">
                    <option value="1">Bayi mail ile bilgilendirilsin</option>
                    <option value="2" selected>Bayi mail ile bilgilendirilmesin</option>
                  </select>
  
                  <br>
                  <input type="hidden" value="<?php echo $code;?>" name="code" />                  
                  <button type="submit" class="btn btn-primary">İşlem Yap</button>
                      
                  </form>
                </div>
              </div>
              </section>
              </div>
            <?php
            }
          break;

          case 'productskilldelete':
            $id = get('id');
            if(!$id){
                go(admin);
            }
    
            $query = $db->prepare("SELECT * FROM urun_ozellikler WHERE id=:k");
            $query->execute([':k' => $id]);
            if($query->rowCount()){
          
                $del = $db->prepare("DELETE FROM urun_ozellikler WHERE id=:k");
                $result = $del->execute([':k' => $id]);
                if($result){ 
                    go($_SERVER['HTTP_REFERER']);
                }else{
                    alert("Hata oluştu","danger");
                }
                
            }else{
                go(admin);
            }
        break;

        case "productmultiplerphoto":
          $code = get("id");
          if(!$code){
            go(admin);
          }
          
          $query = $db->prepare("SELECT urunkodu FROM urunler WHERE urunkodu=:i");
          $query->execute([":i" => $code]);
          if($query->rowCount()){
            $row = $query->fetch(PDO::FETCH_OBJ);
            if(isset($_POST["add"])){
              $dosya = $_FILES["cimage"]["name"];
              if($dosya != ""){
                if(str_ends_with($dosya,".jpg") || str_ends_with($dosya,".png")){
                    
                  move_uploaded_file($_FILES["cimage"]["tmp_name"],"../uploads/product/".$_FILES["cimage"]["name"]);
                  $up = $db->prepare("INSERT INTO urun_resimler SET resimurun =:ru , resimdosya=:rd, resimekleyen=:rek , resimdurum=:rdu");
                  $up->execute([
                    ':ru' => $code,
                    ':rd' => $dosya,
                    ':rek' => $aid,
                    ':rdu' => 1,
                  ]);  
                  if($up){
                    alert2("Resim başarıyla eklendi", "success");
                    go($_SERVER['HTTP_REFERER'],2);
                  }else{
                    alert2("Hata oluştu", "danger");
                  }
                    
                }
                else{
                  alert2("Sadece png ve jpg formatı geçerlidir","danger");
                } 
              }
              else{
                alert("Resim seçmediniz","danger");
              } 
            }
            ?>
            
            <div class="tile">
            <h3 class="tile-title">(<?php echo $row->urunkodu;?>) Adlı Ürüne Çoklu Fotoğraf Ekle </h3>
            <form action="" method="post" enctype="multipart/form-data">            
            <div class="tile-body">

              <div class="form-group">
                <label class="control-label">Ürün Resim</label> 
                <input class="form-control" type="file" name="cimage">
              </div>
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" name="add" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Ürüne resim ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/products.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
            </div>
            </div>
            </form>
            <hr>
            <?php 
            
            $photos = $db->prepare("SELECT * FROM urun_resimler WHERE resimurun=:ru");
            $photos->execute([":ru" => $code]);
            if($photos->rowCount()){
            ?>
            <h3>Bu ürüne eklenmiş fotoğraflar (<?php echo $photos->rowCount(); ?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Resim</th>
                    <th>Durum</th>
                    <th>Sırlama</th>
                    <th>İşlem</th>
                  </tr>
                </thead>
                <tbody id="page_list">
                  <?php foreach ($photos as $photo){?>
                    <tr id="<?php echo $photo["id"]; ?>">
                      <td><?php echo $photo["id"];?></td>
                      <td><img src="<?php echo site;?>/uploads/product/<?php echo $photo["resimdosya"];?>" height="150" width="150" alt=""> </td>
                      <td><?php echo $photo['resimdurum'] == 1 ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Pasif</span>"; ?></td>
                      <td><?php echo $photo["siralama"]; ?></td>
                      <td>
                      <?php if($photo['resimdurum'] == 1){ ?>
                      <a title="Resmi pasif yap" href="<?php b2b('productimagepassive',$photo['id']);?>"><i class="fa fa-lock"></i></a>
                      <?php }else{ ?>
                          <a title="Resmi aktif yap" href="<?php b2b('productimageactive',$photo['id']);?>"><i class="fa fa-check"></i></a>
                      <?php } ?>
                      <a onclick="return confirm('Onaylıyor musunuz?');" title="Resmi sil" href="<?php b2b('productimagedelete',$photo['id']);?>"><i class="fa fa-close"></i></a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <script>
              $(document).ready(function(){
              $("#page_list").sortable({
                placeholder: "ui-state-highlight",
                update: function(event, ui){
                  var page_id_array = new Array();
                  $("#page_list tr").each(function(){
                    page_id_array.push($(this).attr("id"));
                  });
      
                  $.ajax({
                    url : "<?php echo admin.'/orderby.php?table=urun_resimler'?>",
                    method : "POST",
                    data : {page_id_array:page_id_array},
                    success : function(data){
                      alert("Sıralama güncellendi");
                      window.location.reload();
                    }
                  })
                }
              })
              });
              </script>
            <?php }else{alert("Bu ürüne ait resim bulunamamaktadır","danger");} 
            
            ?>
            <?php
            
          }else{
            go(admin);
          }
        break;
        case "productimagepassive":
          $id = get("id");
          if(!$id){
            go(admin);
          }
          
          $query = $db->prepare("SELECT * FROM urun_resimler WHERE id=:i");
          $query->execute([":i" => $id]);
          
          if($query->rowCount()){
            $up = $db->prepare("UPDATE urun_resimler SET resimdurum=:rd WHERE id=:i");
            $up->execute([":rd" => 2, ":i" => $id]);
            go($_SERVER["HTTP_REFERER"]);
          }else{
            go(admin);
          } 
        break;

        case 'productdelete':
          $code = get('id');
          if(!$code){
          go(admin);
          }
          
          $query = $db->prepare("SELECT urunkodu FROM urunler WHERE urunkodu=:b");
          $query->execute([':b' => $code]);
          if($query->rowCount()){
          $delete = $db->prepare("UPDATE urunler SET urundurum=:d WHERE urunkodu=:b");
          $result = $delete->execute([':d' => 2,':b'=>$code]);
          if($result){
          alert('Ürün pasife alındı','success');
          go(admin."/products.php",2);
          }else{
          alert('Hata oluştu','danger');
          }
          
          }else{
          go(admin);
          }
          break;

        case "productimageactive":
          $id = get("id");
          if(!$id){
            go(admin);
          }
          
          $query = $db->prepare("SELECT * FROM urun_resimler WHERE id=:i");
          $query->execute([":i" => $id]);
          
          if($query->rowCount()){
            $up = $db->prepare("UPDATE urun_resimler SET resimdurum=:rd WHERE id=:i");
            $up->execute([":rd" => 1, ":i" => $id]);
            go($_SERVER["HTTP_REFERER"]);
          }else{
            go(admin);
          } 
        break;
        case "productimagedelete":
          $id = get("id");
          if(!$code){
            go(admin);
          }
          
          $query = $db->prepare("SELECT * FROM urun_resimler WHERE id=:i");
          $query->execute([":i" => $id]);
          
          if($query->rowCount()){
            $row = $query->fetch(PDO::FETCH_OBJ);
            $del = $db->prepare("DELETE FROM urun_resimler WHERE id=:k");
            $del->execute([":k" => $id]);
            if($del){
            @unlink("../uploads/product/".$row->resimdosya);
            go($_SERVER['HTTP_REFERER']);
            }else{
              alert2("Hata oluştu","danger");
            }
          }else{
            go(admin);
          }
        break;
        case 'productskill':
      
          $code = get('id');
          if(!$code){
              go(admin);
          }
  
          $query = $db->prepare("SELECT urunbaslik,urunkodu FROM urunler WHERE urunkodu=:k");
          $query->execute([':k' => $code]);
          if($query->rowCount()){
              $row = $query->fetch(PDO::FETCH_OBJ);
  
              if(isset($_POST['add'])){
  
                  $title   = post('title');
                  $content = post('content');
                  if(!$title || !$content){
                      alert2("Boş alan bırakmayınız","danger");
                  }else{
                      $add = $db->prepare("INSERT INTO urun_ozellikler SET
  
                        ozellikurun   =:u,
                        ozellikbaslik =:b,
                        ozellikicerik =:i,
                        ozellikekleyen=:ek,
                        ozellikdurum  =:du
  
                      ");
  
                      $result = $add->execute([
                        ':u'  => $code,
                        ':b'  => $title,
                        ':i'  => $content,
                        ':ek' => $aid,
                        ':du' => 1
                      ]);
  
                      if($result){
                        go($_SERVER['HTTP_REFERER']);
                      }else{
                        alert2("Hata oluştu","danger");
                      }
                  }
  
  
              }
             
              ?>
  
              <div class="tile">
              <h3 class="tile-title"><?php echo $row->urunbaslik;?> Adlı Ürüne Özellik Ekleme</h3>
              <form action="" method="POST" enctype="multipart/form-data">
              <div class="tile-body">
  
              <div class="form-group">
              <label class="control-label">Özellik Başlık</label>
              <input class="form-control" type="text" name="title" placeholder="Özellik başlığı">
              </div>
  
              <div class="form-group">
              <label class="control-label">Özellik İçerik</label>
              <textarea class="form-control" rows="5" name="content" placeholder="Özellik içeriği"></textarea>
              </div>
  
  
  
              </div>
              <div class="tile-footer">
              <button class="btn btn-primary" name="add" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Ürüne Özellik Ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin;?>/products.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
  
              </form>
  
              <hr />
              <?php 
                $skills = $db->prepare("SELECT * FROM urun_ozellikler WHERE ozellikurun=:u");
                $skills->execute([':u' => $code]);
                if($skills->rowCount()){ 
              ?>
              <h3>Ürüne ait özellikler</h3>
              <div class="table-responsive">
                  <table class="table table-hover">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>BAŞLIK</th>
                              <th>İÇERİK</th>
                              <th>DURUM</th>
                              <th>SIRALAMA</th>
                              <th>İŞLEMLER</th>
                          </tr>
                      </thead>
                      <tbody id="page_list">
                          <?php foreach($skills as $skill){ ?>
                              <tr id="<?php echo $skill['id'];?>">
                                  <td><?php echo $skill['id'];?></td>
                                  <td><?php echo $skill['ozellikbaslik'];?></td>
                                  <td><?php echo $skill['ozellikicerik'];?></td>
                                  <td><?php echo $skill['ozellikdurum'] == 1 ? '<span class="badge badge-success ">Aktif</span>' : '<span class="badge badge-danger">Pasif</span>';?></td>
                                  <td><?php echo $skill['siralama'];?></td>
                                  <td>
                                    <a onclick="return confirm('Onaylıyor musunuz?');" title="Özellik sil" href="<?php b2b('productskilldelete',$skill['id']);?>"><i class="fa fa-close"></i></a>
                                  </td>
                              </tr>
                          <?php } ?>
                      </tbody>
                  </table>
              </div>
              <script>
              $(document).ready(function(){
              $("#page_list").sortable({
                placeholder: "ui-state-highlight",
                update: function(event, ui){
                  var page_id_array = new Array();
                  $("#page_list tr").each(function(){
                    page_id_array.push($(this).attr("id"));
                  });
      
                  $.ajax({
                    url : "<?php echo admin.'/orderby.php?table=urun_ozellikler'?>",
                    method : "POST",
                    data : {page_id_array:page_id_array},
                    success : function(data){
                      alert("Sıralama güncellendi");
                      window.location.reload();
                    }
                  })
                }
              })
              });
              </script>
          </div>
  
          <?php 
            }else{
              alert2("Bu ürüne ait özellik bulunmuyor","danger");
            }
  
  
          }else{
            go(admin);
          }
    
        break;

          case "productcoverimagedelete":
            $code = get("id");
            if(!$code){
              go(admin);
            }
            
            $query = $db->prepare("SELECT urunkodu,urunbannerresim FROM urunler WHERE urunkodu=:i");
            $query->execute([":i" => $code]);
            
            if($query->rowCount()){
              $row = $query->fetch(PDO::FETCH_OBJ);
              @unlink("../uploads/".$row->urunbannerresim);
              go($_SERVER['HTTP_REFERER']);
            }else{
              go(admin);
            }
          break;

          case "productbanner":
            $code = get("id");
            if(!$code){
              go(admin);
            }
            
            $query = $db->prepare("SELECT urunkodu,urunbannerresim FROM urunler WHERE urunkodu=:i");
            $query->execute([":i" => $code]);

            if($query->rowCount()){
              $row = $query->fetch(PDO::FETCH_OBJ);

              if(isset($_POST["upp"])){
                $dosya = $_FILES["cimage"]["name"];
                if($dosya != ""){
                  if(str_ends_with($dosya,".jpg") || str_ends_with($dosya,".png")){
                      
                    move_uploaded_file($_FILES["cimage"]["tmp_name"],"../uploads/".$_FILES["cimage"]["name"]);
                    $up = $db->prepare("UPDATE urunler SET urunbannerresim=:ubr WHERE urunkodu=:uk");
                    $up->execute([
                      ':ubr' => $dosya,
                      ':uk' => $code
                    ]);  
                    if($up){
                      @unlink("../uploads/".$row->urunbannerresim);
                      alert2("Banner başarıyla güncellendi", "success");
                      go($_SERVER['HTTP_REFERER'],2);
                    }else{
                      alert2("Hata oluştu", "danger");
                    }
                      
                  }
                  else{
                    alert2("Sadece png ve jpg formatı geçerlidir","danger");
                  } 
                }
                else{
                  alert("Resim seçmediniz","danger");
                }                            
              }

              ?>
              
              <div class="tile">
              <h3 class="tile-title">(<?php echo $row->urunkodu;?>) Adlı Ürünün Bannerını Değiştir </h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
                <div class="form-group">
                  <label class="control-label">Ürün Banner Resim</label> 
                  <img src="<?php  echo site; ?>/uploads/<?php echo $row->urunbannerresim; ?>" alt="<?php echo $row->urunkodu; ?>" height="200" width="250">
                  <a href="<?php b2b("productcoverimagedelete", $row->urunkodu); ?>" onclick="return confirm('kapak resmini silmek istiyor musunuz?');">(<i class="fa fa-close"></i>)</a>
                  <input class="form-control" type="file" name="cimage">
                </div>

              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/products.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
              </form>
              
              <?php
            }else{
              go(admin);
            }
          break;

          case "productedit":
            $code = get("id");
            if(!$code){
              go(admin);
            }

            $query = $db->prepare("SELECT * FROM urunler WHERE urunkodu=:i");
            $query->execute([":i" => $code]);

            if($query->rowCount()){
              $row = $query->fetch(PDO::FETCH_OBJ);
              
              if(isset($_POST["upp"])){
                $name= post("pname");
                $seourl= post("purl");

                if(!$code){
                  go(admin);
                }
                if(!$seourl){
                    $sef= sef_link($name);
                }else{
                $sef= $seourl;                        
                }
                $pcat = post("pcat");
                $pcode = post("pcode");
                $pstoc = post("pstoc");
                $pprice = post("pprice");
                $pseok = post("pseok");
                $pseod = post("pseod");
                $pv = post("pv");
                $pcontent= $_POST["pcontent"];
                $status = post("status");

                $dosya =$_FILES["pimage"]["name"];
                
                if(!$name || !$pcontent || !$pv || !$pseod || !$pseok || !$pstoc || !$pcode || !$pcat || !$pprice){
                    alert2("Tüm Alanları Doldurunuz","danger");
                }else{

                  $already = $db->prepare("SELECT urunsef,urunkodu FROM urunler WHERE (urunsef=:us OR urunkodu=:uk) AND urunkodu !=:kk AND urunsef!=:sef");
                  $already->execute([":us" => $sef, ":uk" => $pcode, ":kk" => $pcode, ":sef" => $sef]);

                  if(!$already->rowCount()){
                  if($dosya != ""){
                    if(str_ends_with($dosya,".jpg") || str_ends_with($dosya,".png")){
                        
                      move_uploaded_file($_FILES["pimage"]["tmp_name"],"../uploads/product/".$_FILES["pimage"]["name"]);
                      $up = $db->prepare("UPDATE urunler SET urunkat=:k, urunbaslik=:b, urunsef=:s, urunicerik=:i, urunkapakresim=:kapak, urunfiyat=:f, urunstok=:us, urunkeyw=:keyw, urundesk=:descc, urunvitrin=:vi, urundurum=:uek WHERE urunkodu=:ukkk");
                      $up->execute([':k' => $pcat,':b' => $name,':s' => $sef,':i' => $pcontent,':kapak' => $dosya, ':f' => $pprice, ':us' => $pstoc, ':keyw' => $pseok, ':descc' => $pseod, ':vi' => $pv, ':uek' => $status, ":ukkk" => $pcode]);

                      @unlink("../uploads/product/".$row->urunkapakresim);
                        
                    }
                    else{
                      alert2("Sadece png ve jpg formatı geçerlidir","danger");
                    } 
                  }else{
                    $up = $db->prepare("UPDATE urunler SET urunkat=:k, urunbaslik=:b, urunsef=:s, urunicerik=:i, urunfiyat=:f, urunstok=:us, urunkeyw=:keyw, urundesk=:descc, urunvitrin=:vi, urundurum=:uek WHERE urunkodu=:ukkk");
                    $up->execute([':k' => $pcat,':b' => $name,':s' => $sef,':i' => $pcontent, ':f' => $pprice, ':us' => $pstoc, ':keyw' => $pseok, ':descc' => $pseod, ':vi' => $pv, ':uek' => $status, ":ukkk" => $pcode]);
                  }     
                  if($up){
                    alert2("Ürün başarıyla güncellendi", "success");
                    go($_SERVER["HTTP_REFERER"],2);
                  }else{
                    alert2("Hata oluştu", "danger");
                  }                   
                  }
                  else{
                    alert2("Zaten Bu Ürün Kodu ve ya Url Var","danger");
                  }
                }
              }

              ?>
              
              <div class="tile">
              <h3 class="tile-title">(<?php echo $row->urunkodu; ?>) Adlı Ürünü Güncelle</h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
                <div class="form-group">
                  <label class="control-label">Ürün Adı</label>
                  <input class="form-control" name="pname"  value="<?php echo $row->urunbaslik; ?>" type="text" placeholder="Ürün adı">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün Kodu</label>
                  <input class="form-control" name="pcode"  value="<?php echo $row->urunkodu; ?>" type="text" placeholder="Ürün kodu">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün Kapak Resim</label>
                  <span style="color:#b10021;">* zorunlu değil</span>
                  <img src="<?php echo site; ?>/uploads/product/<?php echo $row->urunkapakresim; ?>" style="border-radius:10px;" height="100" width="100" alt="">
                  <input class="form-control" type="file" name="pimage">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün Stok Adet</label>
                  <input class="form-control" type="number" value="<?php echo $row->urunstok; ?>" name="pstoc">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün İçerik</label>
                  <textarea class="ckeditor" name="pcontent" id="" cols="30" rows="10"><?php echo $row->urunicerik; ?></textarea>
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün Fiyat</label>
                  <input class="form-control" name="pprice" type="text"  value="<?php echo $row->urunfiyat; ?>" placeholder="Ürün fiyat">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün Kategorisi</label>
                  <select name="pcat" class="form-control">
                    <option value="0">Kategori Seç</option>
                    <?php 
                    $cat = $db->prepare("SELECT * FROM urun_kategoriler WHERE katdurum=:d");
                    $cat->execute([":d" => 1]);
                    if($cat->rowCount()){
                      foreach($cat as $ca){
                        ?>
                        <option <?php echo $ca['id'] == $row->urunkat ? "selected" : NULL ?> value="<?php echo $ca['id']?>"><?php echo $ca['katbaslik']; ?></option>
                        <?php
                      }
                    }else{

                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün SEO Keywords</label>
                  <input class="form-control" name="pseok"  value="<?php echo $row->urunkeyw; ?>" type="text" placeholder="Ürün anahtar kelime">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün SEO URL örn(hakkimda-bla-bla-bla)</label>
                  <input class="form-control" name="purl"  value="<?php echo $row->urunsef; ?>" type="text" placeholder="Ürün SEO url">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün SEO Açıklama</label>
                  <input class="form-control" name="pseod" type="text"  value="<?php echo $row->urundesk; ?>" placeholder="Ürün açıklama">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün Durum</label>
                  <select name="status" class="form-control">
                    <option value="0">Ürün Durumu Seçiniz</option>
                    <option value="1" <?php echo $row->urundurum == 1 ? "selected" : NULL ?>>Aktif</option>
                    <option value="2" <?php echo $row->urundurum == 2 ? "selected" : NULL ?>>Pasif</option>
                  </select>
                </div>

                <div class="form-group">
                  <label class="control-label">Vitrin Durum</label>
                  <select name="pv" class="form-control">
                    <option value="0">Vitrin Durumu Seçiniz</option>
                    <option value="1" <?php echo $row->urunvitrin == 1 ? "selected" : NULL ?>>Ürünlerde Görünsün</option>
                    <option value="2" <?php echo $row->urunvitrin == 2 ? "selected" : NULL ?>>Kategori Listesinde Görünsün</option>
                  </select>
                </div>
              
              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/pages.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
                </form>

              <?php

            }else{
              go(admin);
            }
          break;

          case "categoryedit":
            $id = get("id");
            if(!$id){
              go(admin);
            }

            $query = $db->prepare("SELECT * FROM urun_kategoriler WHERE id=:d");
            $query->execute([":d" => $id]);

            if($query->rowCount()){
              $row = $query->fetch(PDO::FETCH_OBJ);

              if(isset($_POST["upp"])){

                $name= post("name");
                $seourl= post("seourl");
                $status = post("cstatus");

                if(!$seourl){
                    $sef= sef_link($name);
                }else{
                $sef= $seourl;                        
                }

                $keyw= post("seok");
                $desc= post("seod");
                $dosya=$_FILES["cimage"]["name"];
                
                if(!$name || !$sef || !$desc || !$status){
                    alert2("Tüm Alanları Doldurunuz","danger");
                }else{

                  $already = $db->prepare("SELECT id,katsef FROM urun_kategoriler WHERE katsef=:k AND id !=:id ");
                  $already->execute([
                    ":k" => $sef,
                    ":id" => $id
                  ]);

                  if(!$already->rowCount()){
                  if($dosya != ""){
                    if(str_ends_with($dosya,".jpg") || str_ends_with($dosya,".png")){
                        
                      move_uploaded_file($_FILES["cimage"]["tmp_name"],"../uploads/product/".$_FILES["cimage"]["name"]);
                      $up = $db->prepare("UPDATE urun_kategoriler SET katbaslik=:kb,katsef=:s,katkeyw=:keyw,katdesc=:de,katresim=:re,katdurum=:ke WHERE id=:id");
                      $up->execute([
                        ':kb' => $name,
                        ':s' => $sef,
                        ':keyw' => $keyw,
                        ':de' => $desc,
                        ':re' => $dosya,
                        ":ke" => $status,
                        ":id" => $id
                      ]);  

                      @unlink("../uploads/product/".$row->katresim);

                      if($up){
                        alert2("Başarıyla kategori güncellendi","success");
                        go($_SERVER['HTTP_REFERER'],1);
                      }else{
                        alert2("Hata oluştu", "danger");
                      }
                    }
                    else{
                      alert2("Sadece png ve jpg formatı geçerlidir","danger");
                    }
                  }  
                  else{
                    $up = $db->prepare("UPDATE urun_kategoriler SET katbaslik=:kb,katsef=:s,katkeyw=:keyw,katdesc=:de,katdurum=:ke WHERE id=:id");
                    $up->execute([
                      ':kb' => $name,
                      ':s' => $sef,
                      ':keyw' => $keyw,
                      ':de' => $desc,
                      ":ke" => $status,
                      ":id" => $id
                    ]);  

                    if($up){
                      alert2("Başarıyla kategori güncellendi","success");
                      go($_SERVER['HTTP_REFERER'],1);
                    }else{
                      alert2("Hata oluştu", "danger");
                    }
                  }                          
                  }
                }
              }else{

              }

              ?> 
              
              <div class="tile">
              <h3 class="tile-title">Kategori Güncelle</h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
                  <div class="form-group">
                    <label class="control-label">Kategori Adı</label>
                    <input class="form-control" name="name" value="<?php echo $row->katbaslik ?>" type="text" placeholder="Kategori adı">
                  </div>
  
                  <div class="form-group">
                    <label class="control-label">Kategori SEO Anahtar Kelime</label>
                    <input class="form-control" name="seok"  value="<?php echo $row->katkeyw ?>" type="text" placeholder="Kategori SEO anahtar kelime">
                  </div>

                  <div class="form-group">
                    <label class="control-label">Kategori SEO URL örn(canavar-oyun-bilgisiyarlari)</label>
                    <input class="form-control" name="seourl" value="<?php echo $row->katsef ?>" type="text" placeholder="Kategori SEO url">
                  </div>
  
                  <div class="form-group">
                    <label class="control-label">Kategori SEO Açıklama</label>
                    <input class="form-control" name="seod" value="<?php echo $row->katdesc ?>" type="text" placeholder="Kategori SEO açıklama">
                  </div>
  
                  <div class="form-group">
                    <label class="control-label">Kategori Resim</label>
                    <img src="<?php echo $site;?>/uploads/product/<?php echo $row->katresim; ?>" width="200" height="200" alt="<?php echo $row->katresim;?>">
                    <span style="color:#b10021">* zorunlu değil</span>
                    <input class="form-control" type="file" name="cimage">
                  </div>

                  <div class="form-group">
                    <label class="control-label">Kategori Durum</label>
                    <select name="cstatus" class="form-control">
                      <option value="1" <?php echo $row->katdurum == 1 ? "selected" : NULL ?>>Aktif</option>
                      <option value="2" <?php echo $row->katdurum == 2 ? "selected" : NULL ?>>Pasif</option>
                    </select>
                  </div>
              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kayıt Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/categories.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
              </form>
              
              <?php
            }else{
              go(admin);
            }
          break;

          case 'customerlog':

            $s = @intval(get('s'));
            if(!$s){
                $s= 1;
            }
        
            $code = get('id');
            if(!$code){
            go(admin);
            }
        
            $bquery = $db->prepare("SELECT * FROM bayiler WHERE bayikodu=:k");
            $bquery->execute([':k' => $code]);
            if($bquery->rowCount()){
                $row = $bquery->fetch(PDO::FETCH_OBJ);
            }
            
            $query = $db->prepare("SELECT * FROM bayilog WHERE logbayi=:k");
            $query->execute([':k' => $code]);
        
            $total = $query->rowCount();
            $lim   = 10;
            $show  = $s * $lim - $lim;
        
         
        
            $query = $db->prepare("SELECT * FROM bayilog WHERE logbayi=:k ORDER BY logtarih DESC LIMIT :show,:lim");
            $query->bindValue(':show',(int) $show,PDO::PARAM_INT);
            $query->bindValue(':lim',(int) $lim,PDO::PARAM_INT);
            $query->bindValue(':k',$code,PDO::PARAM_STR);
            $query->execute();
        
            if($s > ceil($total / $lim)){
                $s = 1;
              }
        
            if($query->rowCount()){
        
        
            ?>
    
            <div class="tile">
            <h3 class="tile-title">Bayi log listesi (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>#ID</th>
                        <th>Bayi</th>
                        <th>Açıklama</th>
                        <th>Tarih</th>
                        <th>IP</th>
                      </tr>
                    </thead>
                    <tbody>
    
                      <?php foreach($query as $pow){ ?>
                        
                      <tr> 
                        <td><?php echo $pow['id'];?></td>
                        <td><?php echo $row->bayiadı;?></td>
                        <td><?php echo $pow['logdesc'];?></td>
                        <td><?php echo dt($pow['logtarih']);?></td>
                        <td><?php echo $pow['logip'];?></td>
                      </tr>
    
                      <?php } ?>
    
                    </tbody>
              </table>
            </div>

            <div>
              <ul class="pagination">
                <?php 
                  if($total > $lim){
                    pagination($s, ceil($total/$lim),'process.php?process=customerlog&id='.$code.'&s=');
                  }
                ?>	
              </ul>
            </div>
            </div>
            <?php

            }else{
                alert("Bayiye ait log kaydı bulunmamaktadır","danger");
            }
          break;

          case 'customeradressdelete':
            $code = get('id');
            if(!$code){
            go(admin);
            }
            
            $query = $db->prepare("SELECT id FROM bayi_adresler WHERE id=:b");
            $query->execute([':b' => $code]);
            if($query->rowCount()){
            $delete = $db->prepare("UPDATE bayi_adresler SET adresdurum=:d WHERE id=:b");
            $result = $delete->execute([':d' => 2,':b'=>$code]);
            if($result){
            alert('Bayi adresi pasife alındı','success');
            go($_SERVER['HTTP_REFERER'],2);
            }else{
            alert('Hata oluştu','danger');
            }
            
            }else{
            go(admin);
            }
          break;

          case 'customeradressactive':
            $code = get('id');
            if(!$code){
            go(admin);
            }
            
            $query = $db->prepare("SELECT id FROM bayi_adresler WHERE id=:b");
            $query->execute([':b' => $code]);
            if($query->rowCount()){
            $delete = $db->prepare("UPDATE bayi_adresler SET adresdurum=:d WHERE id=:b");
            $result = $delete->execute([':d' => 1,':b'=>$code]);
            if($result){
            alert('Bayi adresi aktife alındı','success');
            go($_SERVER['HTTP_REFERER'],2);
            }else{
            alert('Hata oluştu','danger');
            }
            
            }else{
            go(admin);
            }
          break;

          case 'customeradress':

            $s    = @intval(get('s'));
            if(!$s){
                $s= 1;
            }
        
            $code = get('id');
            if(!$code){
            go(admin);
            }
        
            $bquery = $db->prepare("SELECT * FROM bayiler WHERE bayikodu=:k");
            $bquery->execute([':k' => $code]);
            if($bquery->rowCount()){
                $row = $bquery->fetch(PDO::FETCH_OBJ);
            }
            
            $query = $db->prepare("SELECT * FROM bayi_adresler WHERE adresbayi=:k");
            $query->execute([':k' => $code]);
        
            $total = $query->rowCount();
            $lim   = 10;
            $show  = $s * $lim - $lim;
        
          
        
            $query = $db->prepare("SELECT * FROM bayi_adresler WHERE adresbayi=:k ORDER BY adrestarih DESC LIMIT :show,:lim");
            $query->bindValue(':show',(int) $show,PDO::PARAM_INT);
            $query->bindValue(':lim',(int) $lim,PDO::PARAM_INT);
            $query->bindValue(':k',$code,PDO::PARAM_STR);
            $query->execute();
        
            if($s > ceil($total / $lim)){
                $s = 1;
              }
        
            if($query->rowCount()){
        
        
            ?>
    
            <div class="tile">
            <h3 class="tile-title">Bayi Adres Listesi (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>#ID</th>
                        <th>Adres Bayi</th>
                        <th>Adres Başlık</th>
                        <th>Adres Tarif</th>
                        <th>Adres Durum</th>
                        <th>İşlem</th>
                      </tr>
                    </thead>
                    <tbody>
    
                      <?php foreach($query as $pow){ ?>
                        
                      <tr> 
                        <td><?php echo $pow['id'];?></td>
                        <td><?php echo $row->bayiadı;?></td>
                        <td><?php echo $pow['adresbaslik'];?></td>
                        <td><?php echo $pow['adrestarif'];?></td>
                        <td><?php echo $pow['adresdurum'] == 1 ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Pasif</span>"; ?></td>
                        <td><a href="<?php b2b("customeradressactive",$pow['id']); ?>"><i class="fa fa-check"></i></a> | <a href="<?php b2b("customeradressdelete",$pow['id']); ?>"><i class="fa fa-close"></i></a></td>
                      </tr>
    
                      <?php } ?>
    
                    </tbody>
              </table>
            </div>
            <div>
              <ul class="pagination">
                <?php 
                  if($total > $lim){
                    pagination($s, ceil($total/$lim),'process.php?process=customerlog&id='.$code.'&s=');
                  }
                ?>	
              </ul>
            </div>
            </div>
            <?php
            }else{
                alert("Bayiye ait adres kaydı bulunmamaktadır","danger");
            }
          break;

          case "customerlogo":

            $code = get("id");

            if(!$code){
              go(admin);
            }
  
            $query = $db->prepare("SELECT * FROM bayiler WHERE bayikodu=:bk");
            $query->execute([":bk" => $code]);

            if($query->rowCount()){
              $row = $query->fetch(PDO::FETCH_OBJ);

              if(isset($_POST["upp"])){
                $dosya =$_FILES["blogo"]["name"];
                if($dosya != ""){
                  if(str_ends_with($dosya,".jpg") || str_ends_with($dosya,".png")){
                      
                    move_uploaded_file($_FILES["blogo"]["tmp_name"],"../uploads/customer/".$_FILES["blogo"]["name"]);
                    unlink("../uploads/customer/".$row->bayilogo);
                    $up = $db->prepare("UPDATE bayiler SET bayilogo=:blg WHERE bayikodu=:k");
                    $up->execute([':blg' => $dosya,':k' => $code]);  
                    if($up){
                      alert2("Bayi logosu başarıyla güncellendi", "success");
                      go($_SERVER["HTTP_REFERER"],2);
                    }else{
                      alert2("Hata oluştu", "danger");
                    }
                  }
                  else{
                    alert2("Sadece png ve jpg formatı geçerlidir","danger");
                  } 
                } 
              }
              ?>
            
              <div class="tile">
              <h3 class="tile-title"> <?php echo $row->bayiadı;?> Adlı Bayi Logosunu Güncelle</h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
              <div class="form-group">
                <label class="control-label">Bayi Logo</label>
                <img src="<?php echo site.'/uploads/customer/'.$row->bayilogo; ?>" width="250" height="250" alt="<?php echo $row->bayikodu; ?>">
              </div>

              <div class="form-group">
                <input type="file" name="blogo">                
              </div>

              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kayıt Et</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/customers.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
              </form>

              <?php
            }

          break;

          case "customeredit":

           $code = get("id");
           if(!$code){
             go(admin);
           }
 
           $query = $db->prepare("SELECT * FROM bayiler WHERE bayikodu=:bk");
           $query->execute([":bk" => $code]);
 
           if($query->rowCount()){
             $row = $query->fetch(PDO::FETCH_OBJ);
 
             if(isset($_POST["upp"])){
               $bname = post("bname");
               $bmail = post("bmail");
               $bpass = sha1(md5(post("bpass")));
               $bgift = post("bgift");
               $bphone = post("bphone");
               $bfax = post("bfax");
               $bvdno = post("bvdno");
               $bvd = post("bvd");
               $bsite = post("bsite");
               $bstatus = post("bstatus");
 
               if(!$bname || !$bmail || !$bvdno || !$bvd){
                 alert2("Lütfen Bayi isim, e-posta, vergi daire numarası ve vergi dairesini boş bırakmayınız","danger");
               }else{
                 if(!filter_var($bmail,FILTER_VALIDATE_EMAIL)){
                   alert2("Hatalı e-posta girdiniz", "danger");
                 }else{
                   $already = $db->prepare("SELECT bayimail,bayikodu FROM bayiler WHERE bayimail=:bm AND bayikodu !=:k");
                   $already->execute([":bm" => $bmail, ":k" => $code]);
 
                   if($already->rowCount()){
                     alert2("Bu e-posta adresi sistemde kayıtlı","danger");
                   }else{
                     if($_POST["bpass"] == ""){
                       $up = $db->prepare("UPDATE bayiler SET bayiadı=:ba , bayimail=:be , bayiindirim=:bi , bayitelefon=:bt , bayifax=:bf , bayivergino=:bvg , bayivergidairesi=:bdd , bayisite=:bs, bayidurum=:bd WHERE bayikodu=:k");
                       $up->execute([":ba" => $bname , ":be" => $bmail , ":bi" => $bgift , ":bt" => $bphone , ":bf" => $bfax , ":bvg" => $bvdno,  ":bdd" => $bvd , ":bs" => $bsite , ":bd" => $bstatus , ":k" => $code]);
                     }else{
                       $up = $db->prepare("UPDATE bayiler SET bayiadı=:ba , bayimail=:be , bayiindirim=:bi , bayitelefon=:bt , bayifax=:bf , bayivergino=:bvg , bayivergidairesi=:bdd , bayisite=:bs, bayidurum=:bd , bayisifre=:bsifre WHERE bayikodu=:k");
                       $up->execute([":ba" => $bname , ":be" => $bmail , ":bi" => $bgift , ":bt" => $bphone , ":bf" => $bfax , ":bvg" => $bvdno,  ":bdd" => $bvd , ":bs" => $bsite , ":bd" => $bstatus , ":bsifre" => $bpass, ":k" => $code]);
                     }
                     if($up){
                       alert2("Bayi Bilgileri Başarıyla Güncellendi","success");
                       go($_SERVER['HTTP_REFERER'],1);
                     }else{
                       alert2("Bir Hata Oluştu","danger");
                     }
                   }
                 }
               }
             }
 
             ?>
             
             <div class="tile">
               <h3 class="tile-title"> <?php echo $row->bayiadı;?> Adlı Bayi Bilgilerini Güncelle</h3>
               <form action="" method="post" enctype="multipart/form-data">            
               <div class="tile-body">
   
               <div class="form-group">
                 <label class="control-label">Bayi Adı</label>
                 <input class="form-control" name="bname" type="text" placeholder="Bayi adı" value="<?php echo $row->bayiadı;?>">
               </div>
 
               <div class="form-group">
                 <label class="control-label">Bayi E-posta</label>
                 <input class="form-control" name="bmail" type="text" placeholder="Bayi e-posta" value="<?php echo $row->bayimail; ?>">
               </div>
 
               <div class="form-group">
                 <label class="control-label">Bayi Şifresi</label>
                 <span style="color:red; font-size:12px;">* zorunlu değil</span>
                 <input class="form-control" name="bpass" type="password" placeholder="Bayi şifre">
               </div>
 
               <div class="form-group">
                 <label class="control-label">Bayi İndirim Oranı (%)</label>
                 <input class="form-control" name="bgift" type="text" placeholder="Bayi indirim oranı" value="<?php echo $row->bayiindirim;?>">
               </div>
 
               <div class="form-group">
                 <label class="control-label">Bayi Telefon</label>
                 <input class="form-control" name="bphone" type="text" placeholder="Bayi telefon" value="<?php echo $row->bayitelefon;?>">
               </div>
 
               <div class="form-group">
                 <label class="control-label">Bayi Fax</label>
                 <input class="form-control" name="bfax" type="text" placeholder="Bayi fax" value="<?php echo $row->bayifax;?>">
               </div>
 
               <div class="form-group">
                 <label class="control-label">Bayi Vergi Numarası</label>
                 <input class="form-control" name="bvdno" type="text" placeholder="Bayi vergi numarası" value="<?php echo $row->bayivergino;?>">
               </div>
 
               <div class="form-group">
                 <label class="control-label">Bayi Vergi Dairesi</label>
                 <input class="form-control" name="bvd" type="text" placeholder="Bayi vergi dairesi" value="<?php echo $row->bayivergidairesi;?>">
               </div>
 
               <div class="form-group">
                 <label class="control-label">Bayi Web Site</label>
                 <input class="form-control" name="bsite" type="text" placeholder="Bayi web site" value="<?php echo $row->bayisite;?>">
               </div>
 
               <div class="form-group">
                 <label class="control-label">Bayi Hesap Durum</label>
                 <select name="bstatus" class="form-control">
                   <option value="1" <?php echo $row->bayidurum==1 ? "selected" : null; ?>>Aktif</option>
                   <option value="2" <?php echo $row->bayidurum==2 ? "selected" : null; ?>>Pasif</option>
                 </select>
               </div>
 
               </div>
               <div class="tile-footer">
                 <button class="btn btn-primary" name="upp" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kayıt Et</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/customers.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
               </div>
               </div>
                </form>
             
             <?php
           }
           else{
             go(admin);
           }

          break;

          case "newproduct":

            if(isset($_POST["add"])){
                $name= post("pname");
                $seourl= post("purl");

                if(!$code){
                  go(admin);
                }
                if(!$seourl){
                    $sef= sef_link($name);
                }else{
                $sef= $seourl;                        
                }
                $pcat = post("pcat");
                $pcode = post("pcode");
                $pstoc = post("pstoc");
                $pprice = post("pprice");
                $pseok = post("pseok");
                $pseod = post("pseod");
                $pv = post("pv");
                $pcontent= $_POST["pcontent"];

                $dosya =$_FILES["pimage"]["name"];
                
                if(!$name || !$pcontent || !$pv || !$pseod || !$pseok || !$pstoc || !$pcode || !$pcat || !$pprice || !$dosya){
                    alert2("Tüm Alanları Doldurunuz","danger");
                }else{

                  $already = $db->prepare("SELECT urunsef,urunkodu FROM urunler WHERE urunsef=:us OR urunkodu=:uk");
                  $already->execute([":us" => $sef, ":uk" => $pcode]);

                  if(!$already->rowCount()){
                  if($dosya != ""){
                    if(str_ends_with($dosya,".jpg") || str_ends_with($dosya,".png")){
                        
                      move_uploaded_file($_FILES["pimage"]["tmp_name"],"../uploads/product/".$_FILES["pimage"]["name"]);
                      move_uploaded_file($_FILES["bimage"]["tmp_name"],"../uploads/".$_FILES["bimage"]["name"]);
                      $up = $db->prepare("INSERT INTO urunler SET urunkat=:k, urunbaslik=:b, urunsef=:s, urunicerik=:i, urunkapakresim=:kapak, urunfiyat=:f, urunkodu=:ukr, urunstok=:us, urunkeyw=:keyw, urundesk=:descc, urunvitrin=:vi, urunekleyen=:uek");
                      $up->execute([':k' => $pcat,':b' => $name,':s' => $sef,':i' => $pcontent,':kapak' => $dosya, ':f' => $pprice, ':ukr' => $pcode, ':us' => $pstoc, ':keyw' => $pseok, ':descc' => $pseod, ':vi' => $pv, ':uek' => $aid]);  
                      if($up){
                        alert2("Ürün başarıyla eklendi", "success");
                        go(admin."/products.php",2);
                      }else{
                        alert2("Hata oluştu", "danger");
                      }
                        
                    }
                    else{
                      alert2("Sadece png ve jpg formatı geçerlidir","danger");
                    } 
                  }                            
                  }
                  else{
                    alert2("Zaten Bu Ürün Kodu ve ya Url Var","danger");
                  }
                }
            }

            ?>
              
              <div class="tile">
              <h3 class="tile-title">Yeni Ürün Ekle</h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
                <div class="form-group">
                  <label class="control-label">Ürün Adı</label>
                  <input class="form-control" name="pname" type="text" placeholder="Ürün adı">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün Kapak Resim</label>
                  <input class="form-control" type="file" name="pimage">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün Stok Adet</label>
                  <input class="form-control" type="number" name="pstoc">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün İçerik</label>
                  <textarea class="ckeditor" name="pcontent" id="" cols="30" rows="10"></textarea>
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün Fiyat</label>
                  <input class="form-control" name="pprice" type="text" placeholder="Ürün fiyat">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün Kategorisi</label>
                  <select name="pcat" class="form-control">
                    <option value="0">Kategori Seç</option>
                    <?php 
                    $cat = $db->prepare("SELECT * FROM urun_kategoriler WHERE katdurum=:d");
                    $cat->execute([":d" => 1]);
                    if($cat->rowCount()){
                      foreach($cat as $ca){
                        echo '<option value="'.$ca['id'].'">'.$ca['katbaslik'].'</option>';
                      }
                    }else{

                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün SEO Keywords</label>
                  <input class="form-control" name="pseok" type="text" placeholder="Ürün anahtar kelime">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün SEO URL örn(hakkimda-bla-bla-bla)</label>
                  <input class="form-control" name="purl" type="text" placeholder="Ürün SEO url">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün SEO Açıklama</label>
                  <input class="form-control" name="pseod" type="text" placeholder="Ürün açıklama">
                </div>

                <div class="form-group">
                  <label class="control-label">Ürün Kodu</label>
                  <input class="form-control" name="pcode" type="text" placeholder="Ürün Kodu">
                </div>

                <div class="form-group">
                  <label class="control-label">Vitrin Durum</label>
                  <select name="pv" class="form-control">
                    <option value="0">Vitrin Durumu Seçiniz</option>
                    <option value="1">Ürünlerde Görünsün</option>
                    <option value="2">Kategori Listesinde Görünsün</option>
                  </select>
                </div>
              
              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="add" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kayıt Et</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/pages.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
                </form>
          <?php
          break;

          case "newpage":
            if(isset($_POST["add"])){
                $name= post("pname");
                $seourl= post("purl");
                if(!$code){
                  go(admin);
                }
                if(!$seourl){
                    $sef= sef_link($name);
                }else{
                $sef= $seourl;                        
                }
                $pcontent= $_POST["pcontent"];
                $dosya=$_FILES["pimage"]["name"];
                
                if(!$name || !$pcontent || !$dosya){
                    alert2("Tüm Alanları Doldurunuz","danger");
                }else{

                  $already = $db->prepare("SELECT sef FROM sayfalar WHERE sef=:k");
                  $already->execute([
                      ":k" => $sef
                  ]);

                  if(!$already->rowCount()){
                  if($dosya != ""){
                    if(str_ends_with($dosya,".jpg") || str_ends_with($dosya,".png")){
                        
                      move_uploaded_file($_FILES["pimage"]["tmp_name"],"../uploads/".$_FILES["pimage"]["name"]);
                      $up = $db->prepare("INSERT INTO sayfalar SET baslik=:kb, sef=:s, icerik=:keyw, kapak=:de, ekleyen=:ke");
                      $up->execute([':kb' => $name,':s' => $sef,':keyw' => $pcontent,':de' => $dosya,':ke' => $aid
                      ]);  
                      if($up){
                        alert2("Sayfa başarıyla eklendi", "success");
                        go(admin."/pages.php",2);
                      }else{
                        alert2("Hata oluştu", "danger");
                      }
                        
                    }
                    else{
                      alert2("Sadece png ve jpg formatı geçerlidir","danger");
                    } 
                  }                            
                  }
                  else{
                    alert2("Zaten Bu Sayfa Var","danger");
                  }
                }
            }

            ?>
              
              <div class="tile">
              <h3 class="tile-title">Yeni Sayfa Ekle</h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
                  <div class="form-group">
                    <label class="control-label">Sayfa Adı</label>
                    <input class="form-control" name="pname" type="text" placeholder="Sayfa adı">
                  </div>

                  <div class="form-group">
                    <label class="control-label">Sayfa SEO URL örn(hakkimda-bla-bla-bla)</label>
                    <input class="form-control" name="purl" type="text" placeholder="Sayfa SEO url">
                  </div>
  
                  <div class="form-group">
                    <label class="control-label">Sayfa Kapak Resim</label>
                    <input class="form-control" type="file" name="pimage">
                  </div>

                  <div class="form-group">
                    <label class="control-label">Sayfa İçerik</label>
                    <textarea class="ckeditor" name="pcontent" id="" cols="30" rows="10"></textarea>
                  </div>
              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="add" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kayıt Et</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/pages.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
                </form>
          <?php
          break;

          case "newbank":

            if(isset($_POST["add"])){
              $bankname = post("bankname");
              $bankno = post("bankno");
              $banksube = post("banksube");
              $bankaıban = post("bankaıban");

              if(!$code){
                go(admin);
              }

              if(!$bankname || !$bankno || !$banksube || !$bankaıban){
                alert2("Lütfen Boş Alan Bırakmayınız.","danger");
              }else{
                $already3 = $db->prepare("SELECT bankaiban FROM bankalar WHERE bankaiban=:d");
                $already3->execute([
                  ":d" => $bankaıban
                ]);

                if($already3->rowCount()){
                  alert2("Zaten Bu IBAN a Sahip Banka Var","danger");
                }else{
                  $addbank = $db->prepare("INSERT INTO bankalar SET bankaadi=:baa, bankahesap=:dkaa, bankasube=:bs, bankaiban=:bin, bankaekleyen=:be");
                  $addbank->execute([":baa" => $bankname, ":dkaa" => $bankno, ":bs" => $banksube, ":bin" => $bankaıban, ":be" => $aid]);
                  
                  if($addbank->rowCount()){
                    alert2("Başarıyla Banka Eklendi","success");
                    go(admin."/banklist.php",2);
                  }else{
                    alert2("Bir Hata Oluştu","danger");
                  }
                }
              }
            }

            ?> 
            
            <div class="tile">
              <h3 class="tile-title">Yeni Banka Ekle</h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
                <div class="form-group">
                  <label class="control-label">Banka Adı</label>
                  <input class="form-control" name="bankname" type="text" placeholder="Banka adı">
                </div>

                <div class="form-group">
                  <label class="control-label">Hesap Numarası</label>
                  <input class="form-control" name="bankno" type="text" placeholder="Hesap numarası">
                </div>

                <div class="form-group">
                  <label class="control-label">Şube</label>
                  <input class="form-control" name="banksube" type="text" placeholder="Banka şube">
                </div>

                <div class="form-group">
                  <label class="control-label">Banka IBAN</label>
                  <input class="form-control" name="bankaıban" type="text" placeholder="Banka ıban">
                </div>

              <div class="tile-footer">
                <button class="btn btn-primary" name="add" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kayıt Et</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/banklist.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
                </form>
            
            <?php
          break;

          case "newstatuscode":

            if(isset($_POST["add"])){
              $name = post("name");
              $code = post("code");

              if(!$code){
                go(admin);
              }

              if(!$name || !$code){
                alert2("Lütfen Boş Alan Bırakmayınız.","danger");
              }else{
                $already2 = $db->prepare("SELECT durumkodu FROM durumkodlari WHERE durumkodu=:d");
                $already2->execute([
                  ":d" => $code
                ]);

                if($already2->rowCount()){
                  alert2("Zaten Bu Duruma Ait Kod Var","danger");
                }else{
                  $add = $db->prepare("INSERT INTO durumkodlari SET durumbaslik=:b, durumkodu=:dk, durumekleyen=:ekk");
                  $add->execute([":b" => $name, ":dk" => $code, ":ekk" => $aid]);
                  if($add->rowCount()){
                    alert2("Başarıyla Durum Kodu Eklendi","success");
                    go(admin."/statuscodes.php",2);
                  }else{
                    alert2("Bir Hata Oluştu","danger");
                  }
                }
              }
            }

            ?> 
            
            <div class="tile">
              <h3 class="tile-title">Yeni Durum Kodu Ekle</h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
                <div class="form-group">
                  <label class="control-label">Durum Kodu Adı</label>
                  <input class="form-control" name="name" type="text" placeholder="Durum kodu adı">
                </div>

                <div class="form-group">
                  <label class="control-label">Durum Kodu</label>
                  <input class="form-control" name="code" min="1" type="number" placeholder="Durum kodu">
                </div>

              <div class="tile-footer">
                <button class="btn btn-primary" name="add" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kayıt Et</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/statuscodes.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
                </form>
            
            <?php
          break;

          case 'categorydelete':
            $id = get('id');
            if(!$id){
            go(admin);
            }
            
            ##silinmeyen kategoriyi buluyoruz
            $dquery = $db->prepare("SELECT id,silinmeyen_kat FROM urun_kategoriler WHERE silinmeyen_kat=:si");
            $dquery->execute([':si' => 1]);
            $queryrow = $dquery->fetch(PDO::FETCH_OBJ);
            
            ##silinmeyen kategoriyi buluyoruz sonu
            
            $query = $db->prepare("SELECT * FROM urun_kategoriler WHERE id=:b");
            $query->execute([':b' => $id]);
            if($query->rowCount()){
            $row  = $query->fetch(PDO::FETCH_OBJ);
            if($row->silinmeyen_kat == 1){
            alert('Bu kategori silinmez olarak ayarlanmıştır','danger');
            }else{
            
            $up = $db->prepare("UPDATE urunler SET urunkat=:k WHERE urunkat=:kk");
            $up->execute([':k' => $queryrow->id,':kk'=>$id]);
            if($up){
            
            $delete = $db->prepare('DELETE FROM urun_kategoriler WHERE id=:id');
            $result = $delete->execute([':id' => $id]);
            if($result){
                alert("Kategori silindi ve içerikleri silinmez kategoriye aktarıldı","success");
                @unlink("../uploads/".$row->katresim);
                go(admin."/categories.php",2);
            }else{
                alert("Hata oluştu","danger");
            }
            
            }
            
            }
            
            }else{
            go(admin);
            }
          break;

          case "newcategory": 

            if(isset($_POST["add"])){
                $name= post("name");
                $seourl= post("seourl");

                if(!$seourl){
                    $sef= sef_link($name);
                }else{
                $sef= sef_link($seourl);                        
                }
                $keyw= post("seok");
                $desc= post("seod");
                $dosya=$_FILES["cimage"]["name"];
                
                if(!$name || !$sef || !$desc || !$dosya){
                    alert2("Tüm Alanları Doldurunuz","danger");
                }else{

                  $already = $db->prepare("SELECT katsef FROM urun_kategoriler WHERE katsef=:k");
                  $already->execute([
                      ":k" => $sef
                  ]);

                  if(!$already->rowCount()){
                  if($dosya != ""){
                    if(str_ends_with($dosya,".jpg") || str_ends_with($dosya,".png")){
                        
                      move_uploaded_file($_FILES["cimage"]["tmp_name"],"../uploads/product/".$_FILES["cimage"]["name"]);
                      $up = $db->prepare("INSERT INTO urun_kategoriler SET katbaslik=:kb,katsef=:s,katkeyw=:keyw,katdesc=:de,katresim=:re,katekleyen=:ke");
                      $up->execute([
                        ':kb' => $name,
                        ':s' => $sef,
                        ':keyw' => $keyw,
                        ':de' => $desc,
                        ':re' => $dosya,
                        ":ke" => $aid
                      ]);  
                      if($up){
                        alert2("Kategori başarıyla eklendi", "success");
                        go(admin."/categories.php",2);
                      }else{
                        alert2("Hata oluştu", "danger");
                      }
                        
                    }
                    else{
                      alert2("Sadece png ve jpg formatı geçerlidir","danger");
                    } 
                  }                            
                  }
                  else{
                    alert2("Zaten Bu Kategori Var","danger");
                  }
                }
            }

            ?>
              
              <div class="tile">
              <h3 class="tile-title">Yeni Kategori Ekle</h3>
              <form action="" method="post" enctype="multipart/form-data">            
              <div class="tile-body">
  
                  <div class="form-group">
                    <label class="control-label">Kategori Adı</label>
                    <input class="form-control" name="name" type="text" placeholder="Kategori adı">
                  </div>
  
                  <div class="form-group">
                    <label class="control-label">Kategori SEO Anahtar Kelime</label>
                    <input class="form-control" name="seok" type="text" placeholder="Kategori SEO anahtar kelime">
                  </div>

                  <div class="form-group">
                    <label class="control-label">Kategori SEO URL örn(canavar-oyun-bilgisiyarlari)</label>
                    <input class="form-control" name="seourl" type="text" placeholder="Kategori SEO url">
                  </div>
  
                  <div class="form-group">
                    <label class="control-label">Kategori SEO Açıklama</label>
                    <input class="form-control" name="seod" type="text" placeholder="Kategori SEO açıklama">
                  </div>
  
                  <div class="form-group">
                    <label class="control-label">Kategori Resim</label>
                    <input class="form-control" type="file" name="cimage">
                  </div>
              </div>
              <div class="tile-footer">
                <button class="btn btn-primary" name="add" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kayıt Et</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo admin."/categories.php";?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Listeye Dön</a>
              </div>
              </div>
                </form>
          <?php
        
          break;    
                
        }
        
        ?>
        </div>
        <div class="clearix"></div>
      </div>
    </main>
    <?php require_once "inc/footer.php";?>