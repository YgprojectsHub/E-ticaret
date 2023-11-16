var url= "http://localhost/eticaretsite";

function registerbutton(){
    var data = $("#bregisterform").serialize();

    document.getElementById("registerbuton").disabled= true;

    $.ajax({
        type: "POST",
        url: url + "/inc/register.php",
        data: data,
        success: function(result){
            if($.trim(result) == "empty"){
                alert("Lütfen boş alan bırakmayınız.");
                document.getElementById("registerbuton").disabled= false;
            }else if($.trim(result) == "format"){
                alert("E-posta formatı hatalı");
                document.getElementById("registerbuton").disabled= false;
            }else if($.trim(result) == "match"){
                alert("Şifreler uyuşmadı");
                document.getElementById("registerbuton").disabled= false;
            }else if($.trim(result) == "already"){
                alert("Bu e-posta adına ait zaten bir e-posta kayıtlı");
                document.getElementById("registerbuton").disabled= false;
            }else if($.trim(result) == "error"){
                alert("Bir hata oluştu...");
                document.getElementById("registerbuton").disabled= false;
            }else if($.trim(result) == "ok"){
                alert("Üyeliğiniz başarıyla oluşturuldu, Yöneticinizin onayından sonra aktifleştirilecektir");

                window.location.href = url;
            }
        }
    })
}

function profilebutton(){
    var data = $("#profileform").serialize();

    document.getElementById("profilbuton").disabled= true;

    $.ajax({
        type: "POST",
        url: url + "/inc/profileupdate.php",
        data: data,
        success: function(result){
            if($.trim(result) == "empty"){
                alert("Lütfen boş alan bırakmayınız.");
                document.getElementById("profilbuton").disabled= false;
            }else if($.trim(result) == "format"){
                alert("E-posta formatı hatalı");
                document.getElementById("profilbuton").disabled= false;
            }else if($.trim(result) == "already"){
                alert("Bu e-posta adına ait zaten bir e-posta kayıtlı");
                document.getElementById("profilbuton").disabled= false;
            }else if($.trim(result) == "error"){
                alert("Bir hata oluştu...");
                document.getElementById("profilbuton").disabled= false;
            }else if($.trim(result) == "ok"){
                alert("Profiliniz Başarıyla Güncellendi");
                window.location.reload();
            }
        }
    })
}

function loginbutton(){
    var data = $("#bloginform").serialize();

    document.getElementById("loginbuton").disabled= true;

    $.ajax({
        type: "POST",
        url: url + "/inc/login.php",
        data: data,
        success: function(result){
            if($.trim(result) == "empty"){
                alert("Lütfen boş alan bırakmayınız.");
                document.getElementById("loginbuton").disabled= false;
            }else if($.trim(result) == "error"){
                alert("Bayi kodu, e-posta veya şifre yanlış");
                document.getElementById("loginbuton").disabled= false;
            }else if($.trim(result) == "passive"){
                alert("Üyeliğiniz pasif durumdadır");
                document.getElementById("loginbuton").disabled= false;
            }else if($.trim(result) == "ok"){
                alert("Başarıyla giriş yaptınız yönlendiriliyorsunuz");
                window.location.href = url;
            }
        }
    })
}

function passwordbutton(){
    var data = $("#passwordform").serialize();

    document.getElementById("passwordbuton").disabled= true;

    $.ajax({
        type: "POST",
        url: url + "/inc/changepassword.php",
        data: data,
        success: function(result){
            if($.trim(result) == "empty"){
                alert("Lütfen boş alan bırakmayınız.");
                document.getElementById("passwordbuton").disabled= false;
            }else if($.trim(result) == "match"){
                alert("Şifreler uyuşmadı");
                document.getElementById("passwordbuton").disabled= false;
            }else if($.trim(result) == "error"){
                alert("Bayi kodu, e-posta veya şifre yanlış");
                document.getElementById("passwordbuton").disabled= false;
            }else if($.trim(result) == "ok"){
                alert("Başarıyla şifreniz güncellendi");
                window.location.reload();
            }
        }
    })
}

function adresbuton(){
    var data = $("#addressform").serialize();

    document.getElementById("adressbuton").disabled= true;

    $.ajax({
        type: "POST",
        url: url + "/inc/adressupdate.php",
        data: data,
        success: function(result){
            if($.trim(result) == "empty"){
                alert("Lütfen boş alan bırakmayınız.");
                document.getElementById("adressbuton").disabled= false;
            }else if($.trim(result) == "error"){
                alert("Bir hata oluştu.");
                document.getElementById("adressbuton").disabled= false;
            }else if($.trim(result) == "ok"){
                alert("Başarıyla adresiniz güncellendi");
                window.location.reload();
            }
        }
    })
}

function newaddress(){
    var data = $("#newaddressform").serialize();

    document.getElementById("newaddres").disabled= true;

    $.ajax({
        type: "POST",
        url: url + "/inc/newaddress.php",
        data: data,
        success: function(result){
            if($.trim(result) == "empty"){
                alert("Lütfen boş alan bırakmayınız.");
                document.getElementById("newaddres").disabled= false;
            }else if($.trim(result) == "error"){
                alert("Bir hata oluştu.");
                document.getElementById("newaddres").disabled= false;
            }else if($.trim(result) == "ok"){
                alert("Başarıyla adresiniz eklendi");
                window.location.reload();
            }
        }
    })
}

function newnotification(){
    var data = $("#newnotificationform").serialize();

    document.getElementById("newnotificationn").disabled= true;

    $.ajax({
        type: "POST",
        url: url + "/inc/newnotification.php",
        data: data,
        success: function(result){
            if($.trim(result) == "empty"){
                alert("Lütfen boş alan bırakmayınız");
                document.getElementById("newnotificationn").disabled= false;
            }else if($.trim(result) == "error"){
                alert("Bir hata oluştu");
                document.getElementById("newnotificationn").disabled= false;
            }else if($.trim(result) == "number"){
                alert("Havale tutarı sayısal olmalıdır");
                document.getElementById("newnotificationn").disabled= false;
            }else if($.trim(result) == "ok"){
                alert("Havale bildiriminiz gönderildi, yönetici tarafından kontrol edildikten sonra tarafınıza bildirilecektir");
                window.location.reload();
            }
        }
    })
}

function newcomment(){
    var data = $("#commentform").serialize();

    document.getElementById("newcommentt").disabled= true;

    $.ajax({
        type: "POST",
        url: url + "/inc/newcomment.php",
        data: data,
        success: function(result){
            if($.trim(result) == "empty"){
                alert("Lütfen boş alan bırakmayınız");
                document.getElementById("newcommentt").disabled= false;
            }else if($.trim(result) == "error"){
                alert("Bir hata oluştu");
                document.getElementById("newcommentt").disabled= false;
            }else if($.trim(result) == "number"){
                alert("Yorumunuz en az 30 karakter olmalıdır");
                document.getElementById("newcommentt").disabled= false;
            }else if($.trim(result) == "ok"){
                alert("Yorumunuz gönderildi");
                window.location.reload();
            }
        }
    })
}

function sendmessage(){
    var data = $("#contactform").serialize();

    document.getElementById("sendmessages").disabled= true;

    $.ajax({
        type: "POST",
        url: url + "/inc/sendmessage.php",
        data: data,
        success: function(result){
            if($.trim(result) == "empty"){
                alert("Lütfen boş alan bırakmayınız");
                document.getElementById("sendmessages").disabled= false;
            }else if($.trim(result) == "error"){
                alert("Bir hata oluştu");
                document.getElementById("sendmessages").disabled= false;
            }else if($.trim(result) == "number"){
                alert("Mesajınız en az 15 karakter olmalıdır");
                document.getElementById("sendmessages").disabled= false;
            }else if($.trim(result) == "format"){
                alert("Bu bir eposta değil");
                document.getElementById("sendmessages").disabled= false;
            }else if($.trim(result) == "ok"){
                alert("Mesajınız gönderildi en kısa sürede dönüş yapılacaktır");
            }
        }
    })
}

function addcart(){
    var data = $("#addcartform").serialize();

    document.getElementById("addcartt").disabled= true;

    $.ajax({
        type: "POST",
        url: url + "/inc/addcart.php",
        data: data,
        success: function(result){
            if($.trim(result) == "empty"){
                alert("Ürün adeti belirtiniz");
                document.getElementById("addcartt").disabled= false;
            }else if($.trim(result) == "error"){
                alert("Bir hata oluştu");
                document.getElementById("addcartt").disabled= false;
            }else if($.trim(result) == "login"){
                alert("Sepete eklemek için lütfen giriş yapın");
                document.getElementById("addcartt").disabled= false;
            }else if($.trim(result) == "qty"){
                alert("En az 1 adet seçmelisiniz");
                document.getElementById("addcartt").disabled= false;
            }
            else if($.trim(result) == "ok"){
                alert("Ürün sepete eklendi");
                window.location.reload();
            }
        }
    })
}

function ordercomplete(){
    var data = $("#orderform").serialize();

    document.getElementById("ordercomplet").disabled= true;

    $.ajax({
        type: "POST",
        url: url + "/inc/neworder.php",
        data: data,
        success: function(result){
            if($.trim(result) == "empty"){
                alert("Boş alan bırakmayınız");
                document.getElementById("ordercomplet").disabled= false;
            }else if($.trim(result) == "error"){
                alert("Bir hata oluştu");
                document.getElementById("ordercomplet").disabled= false;
            }else if($.trim(result) == "ok"){
                alert("Sipariş oluşturuldu");
                window.location.href = url+"/order-complete";
            }
        }
    })
}