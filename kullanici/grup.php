<?php
session_start();
require('../admin/ayarlar.php');
$connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

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
		table {
			position:relative;
			margin-left: 30px;
			top:40px;
		}
		th {
			background: #35D380;
			color: #fff;
			font-weight: bold;
			font-size: 24px;
		}

		tr { background: #f1f1f1; }

		tr:nth-child(2n) { background:#f7f7f7; }

		th, td {
			text-align: center;
			padding: 20px;
		}

		tr { background: #ddd; }

		td {
			padding: 9px 2px;
			color: black;
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
			<h2>Gruplar</h2><br>
			<form method="post">
				<tr>
					<td>Eklenecek grup:</td>&nbsp;&nbsp;
					<td><input type="text" name="grupismi" id="grupismi" required></td>
				</tr>
				<input type="submit" name="grupbutonu" id="grupbutonu" value="KAYDET">
				<tr>
					<?php
						if($_POST){
							$grupadi=$_POST["grupismi"];
							$connection->query("INSERT INTO ".$_SESSION['name']."Grup (isim) VALUES ('$grupadi')");
							header('Location: grup.php');
						}
					?>
				</tr>
				<br>
				<table>
					<tr>
						<th style="width:350px;" witdh colspan="2">Gruplar</th>
					</tr>
					<?php
						$sorgu = $connection->query("select * from ".$_SESSION['name']."Grup");
						while ($sonuc = $sorgu->fetch_assoc()) {
					?>
					<tr>
						<td style="width:300px;"><?php echo $sonuc["isim"] ?></td>
						<td>
							<a href="grupDuzenle.php?id=<?php echo $sonuc["id"] ?>"><img src="image/duzenle2.png"/></a>
							<a href="grupSil.php?id=<?php echo $sonuc["id"] ?>"><img src="image/sil2.png"/></a>
                        </td>
					</tr>
					<?php
						}
					?>
				</table>
			</form>
		</div>
	</body>
</html>