<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet"/>
        <style>
            .kutu {
                margin-top: 40px
            }
        </style>
    </head>
    <body>
        <?php
            session_start(); //oturum başlattık
            require('ayarlar.php');
            // veri tabani bağlantisi
            $connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

            //güncelleme yapılacak kullanıcının verilerini alıyoruz
            $id = (int)$_GET["id"];
            $sorgu = $connection->query("select * from accounts where id=$id");
            $sonuc = $sorgu->fetch_assoc();
            $eskiad=$sonuc["username"];
        ?>
        <!-- Formumuzu oluşturuyoruz-->
        <form id="form1" method="post">
            <div class="row align-content-center justify-content-center ">
                <div class="col-md-3 kutu">
                    <h3 class="text-center">Kullanıcı düzenle</h3>
                    <table class="table">
                        <tr>
                            <td>
                                <!-- Kullanıcı adını value ya ekliyoruz-->
                                <input type="text" name="txtKadi" class="form-control" placeholder="Kullanıcı adı" value='<?php echo $sonuc['username'] ?>'/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="kota" class="form-control" placeholder="SMS/Mail Kotası" value='<?php echo $sonuc['limits'] ?>'/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" name="txtParola" class="form-control" placeholder="Parola" value='<?php echo $sonuc['password'] ?>'/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" name="txtParolaTekrar" class="form-control" placeholder="Parola Tekrar" value='<?php echo $sonuc['password'] ?>'/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                //Post varsa yani submit yapılmışsa veri tabanından kontrolü yapıyoruz.
                                if ($_POST) {

                                    //Giriş formu doldurulmuşsa kontrol ediyoruz
                                    $txtKadi = $_POST["txtKadi"]; //Kullanıcı adını değişkene atadık
                                    $limit=$_POST["kota"];
                                    $txtParola = $_POST["txtParola"]; 
                                    $txtParolaTekrar = $_POST["txtParolaTekrar"]; 

                                    //Verilerin düzgün girilip girilmediğini kontrol ediyoruz
                                    if ($txtParola == $txtParolaTekrar && $txtParola != '' && $txtKadi != '') {
                                        if ($sorgu2 = $connection->query("UPDATE accounts SET username='$txtKadi', password='$txtParola',limits=$limit WHERE  id=$id")) {
                                            $connection->query("RENAME TABLE `".$eskiad."Rehber` TO `".$txtKadi."Rehber`");
                                            $connection->query("RENAME TABLE `".$eskiad."Grup` TO `".$txtKadi."Grup`");
                                            $connection->query("RENAME TABLE `".$eskiad."Rapor` TO `".$txtKadi."Rapor`");
                                            header("location:giris.php"); //güncelleme başarılı ise sayfayı yönlendiriyoruz
                                        } else {
                                            echo 'bir hata oldu tekrar deneyin';
                                        }
                                    } else {
                                        //eğer kullanıcı adı ve parola boş ve paralolar uyuşmuyorsa
                                        //hata mesajı verdiriyoruz
                                        echo "Alanları düzgün doldurunuz";
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <input type="submit" class="btn btn-primary btn-block" ID="btnGiris" value="Kaydet"/>
                            </td>
                        </tr>
                        <tr>
                        <td class="text-center">
                            <a href="giris.php" class="btn btn-danger">Geri Dön</a>
                        </td>
                    </tr>
                    </table>
                </div>
            </div>
        </form>
    </body>
</html>