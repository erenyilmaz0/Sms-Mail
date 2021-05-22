<?php
    // giris yapildigi anda oturumu baslat
    session_start();
    require('../admin/ayarlar.php');
    // veri tabani bağlantisi
    $connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    //güncelleme yapılacak kullanıcının verilerini alıyoruz
    
    $id = (int)$_GET["id"];
    $sorgu = $connection->query("select * from ".$_SESSION['name']."Grup where id=$id");
    $sonuc = $sorgu->fetch_assoc();
    $eskigrupadi=$sonuc["isim"];
    // eger giriş yapılmamışsa giris ekranina yonlendir
    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.html');
        exit;
    }
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sms/Mail </title>
		<link href="styleAnasayfa.css" rel="stylesheet" type="text/css">
    </head> 
    <style>
        input[type=submit]{
            margin:40px;
        }
    </style>
	<body>
		<nav>
			<ul>
				<li><a href="anaSayfa.php">Ana Sayfa</a></li>
				<li><a href="#">Rehber</a>
					<ul>
                        <li><a href="grup.php">Gruplar</a></li>
						<li><a href="rehberListele.php">Rehber Listele</a></li>
						<li><a href="kisiEkle.php">Kişi Ekle</a>
						<li><a href="topluKisiEkle.php">Toplu Kişi Ekle</a></li>					</ul>
				</li>
				<li><a href="#">Sms/Mail Gönder</a>
					<ul>
                        <li><a href="hSmsGonder.php">Hızlı Sms Gönder</a></li>
						<li><a href="hMailGonder.php">Hızlı Mail Gönder</a></li>
						<li><a href="rehberdenSms.php">Rehberden Sms Gönder</a></li>
						<li><a href="rehberdenMail.php">Rehberden Mail Gönder</a></li>
					</ul>
				</li>
				<li><a href="#">Raporlar</a>
					<ul>
						<li><a href="raporMail.php">Mail Raporu</a></li>
						<li><a href="raporSms.php">Sms Raporu</a></li>
					</ul>
				</li>
				<li><a href="cikis.php">Çıkış Yap</a>
			</ul>
		</nav>
		<div class="content">			
			<h2>Grup Düzenle</h2><br>
			<form method="post">
                <br>
                <table>
                    <tr>
                        <td>Grup :</td>
                        <td><input type="text" name="grupad" id="grupad" value='<?php echo $sonuc['isim'] ?>' required ></td>
                    </tr>
                    <tr>
                        <td><a href="grup.php"><img id="grupduzen" src="image/back1.png"/></a></td>
                        <td><input type="submit" name="kaydet" value="KAYDET"></td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                                if($_POST){
                                    $yenigrupadi=$_POST["grupad"];
                                    $sorgu2 = $connection->query("select * from ".$_SESSION['name']."Rehber where grubu='$eskigrupadi'");
                                    while ($sonuc2 = $sorgu2->fetch_assoc()) {
                                        $connection->query("UPDATE ".$_SESSION['name']."Rehber SET grubu='$yenigrupadi' WHERE grubu='$eskigrupadi'");
                                    }
                                    $connection->query("UPDATE ".$_SESSION['name']."Grup SET isim='$yenigrupadi' WHERE id=$id");
                                    header("Location:grup.php");
                                }
                            ?>
                        </td>
                    </tr>
                </table> 
            </form>
		</div>
	</body>
</html>