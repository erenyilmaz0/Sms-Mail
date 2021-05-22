<?php
    session_start();
    // giris yapildigi anda oturumu baslat
    require('../admin/ayarlar.php');
    $connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    // eger giriş yapılmamışsa giris ekranina yonlendir
    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.html');
        exit;
    }

    if ($_POST) {
        $adi = $_POST["rad"]; 
        $soyadi = $_POST["rsoyad"]; 
        $telefon = $_POST["rnum"]; 
        $mail = $_POST["rmail"]; 
        $grup=$_POST["grup"];
    }
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sms/Mail </title>
		<link href="styleAnasayfa.css" rel="stylesheet" type="text/css">
    </head> 
    <style>
        select{
            width: 210px;
            height: 22px;
            font-size: 14px;
            padding: 1px;
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
						<li><a href="topluKisiEkle.php">Toplu Kişi Ekle</a></li>
					</ul>
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
            <h2>Kişi Ekle</h2>
            <form method="post">
                <br>
                <table>
                    <tr>
                        <td>Ad :</td>
                        <td><input type="text" name="rad" id="rad" required></td>
                    </tr>
                    <tr>
                        <td>Soyad :</td>
                        <td><input type="text"name="rsoyad" id="rsoyad" required></td>
                    </tr>
                    <tr>
                        <td>Telefon No:</td>
                        <td><input type="text" name="rnum" id="rnum" required></td>
                    </tr>  
                    <tr>
                        <td>Mail:</td>
                        <td><input type="text" name="rmail" id="rmail" required></td>
                    </tr>  
                    <tr>
                        <td>Grubu:</td>
                        <td>
                            <select name="grup">
                                <?php
                                    $gruplar=$connection->query("select * from ".$_SESSION['name']."Grup");
                                    while ($sonuc= $gruplar->fetch_assoc()) {
                                ?>
                                <option value='<?php echo $sonuc['isim'] ?>'><?php echo $sonuc['isim']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>  
                    <tr>
                        <td></td>
                        <td><input type="submit" name="kaydet" id="kaydet" value="KAYDET"></td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                                if($_POST){
                                    $connection->query("INSERT INTO ".$_SESSION['name']."Rehber (ad, soyad, mail, telefon, grubu) VALUES ('$adi', '$soyadi','$mail','$telefon','$grup')");
                                    echo "Kişi Eklendi.";
                                }
                            ?>
                        </td>
                    </tr>
                </table> 
            </form>
        </div>
	</body>
</html>