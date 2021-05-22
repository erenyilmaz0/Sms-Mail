<?php
// giris yapildigi anda oturumu baslat
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
		<!--<meta charset="utf-8">-->
		<title>Sms/Mail </title>
		<link href="styleAnasayfa.css" rel="stylesheet" type="text/css">
	</head> 
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
            <h2>Toplu Kişi Ekle</h2><br>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data"> 
                <input type="file" id="file" name="file"> <br><br>
                <input type="submit" id="toplukisieklebuton" value="Yükle"> <br><br>
            </form>
            <?php
                if ($_FILES) {
					if ($_FILES['file']['name'] != "") {
						$uzantilar = array(
							'text/csv',
							'text/plain',
							'application/vnd.ms-excel',
							'text/tsv'
						);
						if (in_array($_FILES['file']['type'], $uzantilar)){
							$fileName = $_FILES['file']['tmp_name'];
							$file = fopen($fileName,"r") or exit("Dosya açılamıyor!");
							echo "<span>Eklenen kişiler</span><br>";
							while(!feof($file)) {
								$satir=fgets($file);
								$satir=mb_convert_encoding($satir,"UTF-8","ISO-8859-9");
								$harfler = array("Ã¶","Ã§","Å","Ä±","Ä","Ã¼","Ä","Ã","Å","Ä°","Ã","Ã");
								foreach ($harfler as $h) {
									$pos = strrpos($satir, $h);
									if($pos){
										$satir=utf8_decode($satir);
									}
								}
								$sonuc=(explode(';',$satir));
								if(empty($sonuc[0]) or empty($sonuc[1]) or empty($sonuc[2]) or empty($sonuc[3]) or empty($sonuc[4])){
									continue;
								}
								$son=rtrim($sonuc[4]);
								$connection->query("INSERT INTO ".$_SESSION['name']."Rehber (ad, soyad, mail, telefon, grubu) VALUES ('$sonuc[0]', '$sonuc[1]','$sonuc[2]','$sonuc[3]','$son')");   
								echo $sonuc[0]." ".$sonuc[1]." ".$sonuc[2]." ".$sonuc[3]." ".$son."<br>";
							}
							fclose($file);
						}else{
							echo "<span>Lütfen uzantısı .txt veya .csv dosyası ekleyin</span>";
						}
						
					}else {
						if (isset($_FILES) && $_FILES['file']['type'] == '')
							echo "<span>Lütfen dosyayı seçin</span>";
					}
				}	
            ?>
		</div>
	</body>
</html>