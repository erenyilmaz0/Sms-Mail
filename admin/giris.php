<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>İndex</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<?php
session_start(); //oturum başlattık

?>
<div class="container">
    <!-- Kullanıcı adını ekrana yazıyoruz-->
    <h1>Hoşgeldiniz</h1>

    <!-- Yeni kullanıcı ve çıkış linkleri-->
    <a href="kullaniciEkle.php" class="btn btn-primary">Yeni Kullanıcı</a>
    <a href="cikis.php" class="btn btn-danger">Çıkış</a> <br><br>

    <div class="col-md-6">
        <table class="table">
            <tr>
                <th>Kullanıcı Adı</th>
                <th>İşlem</th>
            </tr>
            <?php
            require('ayarlar.php');
            // veri tabani bağlantisi
            $connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
            
            //kullanıcılarımızı veri tabanından çekiyoruz
            $sorgu = $connection->query("select * from accounts");

            //kullanıcıları tek tek while ile alıyoruz
            while ($sonuc = $sorgu->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $sonuc["username"] ?></td>
                    <td>
                        <!-- Düzenleme ve silme linklerini id değerlerini yollayarak oluşturuyoruz-->
                        <a href="kullaniciDuzenle.php?id=<?php echo $sonuc["id"] ?>"><img src="image/duzenle.png"/></a>
                        <a href="kullaniciSil.php?username=<?php echo $sonuc["username"] ?>"><img src="image/sil.png"/></a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>