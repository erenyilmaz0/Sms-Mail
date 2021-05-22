<?php
session_start();
// giris yapildigi anda oturumu baslat
// eger giriş yapılmamışsa giris ekranina yonlendir
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
require('../admin/ayarlar.php');
// veri tabani bağlantisi
$connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sms/Mail </title>
		<link href="styleAnasayfa.css" rel="stylesheet" type="text/css">
	</head> 
	<style>
		.tbl-content{
            height:400px;
            overflow-x:auto;
            margin-top: 0px;
		}
		::-webkit-scrollbar {
            width: 6px;
        } 
        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
        } 
        ::-webkit-scrollbar-thumb {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
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
			<h2>Mail Raporları</h2>
			<br>
			<h4>Atılan Mail Sayısı:
				<?php 
					$count=0;
					$sayc=$connection->query("SELECT * FROM ".$_SESSION['name']."Rapor where tur='mail'"); 
					while($sayc->fetch_assoc()){
						$count=$count+1;
					}
					echo $count;
				?>
			</h4><br>
			<section>
				<div class="tbl-header">
					<table id="raportablo">
						<thead>
							<tr>
								<th><div style="width:95px;">Tarih</div></th>
								<th><div style="width:75px;">Saat</div></th>
								<th><div style="width:90px;">Kimden</div></th>
								<th><div style="width:110px;">Kime</div></th>
								<th><div style="width:100px;">Grubu</div></th>
								<th><div style="width:290px;">Mail İçeriği</div></th>
								<th><div style="width:35px;">Tür</div></th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="tbl-content">
					<table id="raportablo" border="1">
						<?php            
							$sorgu = $connection->query("select * from ".$_SESSION['name']."Rapor where tur='mail'");

							while ($sonuc = $sorgu->fetch_assoc()) {
						?>
						<tbody>
							<tr>
									<?php 
										$zaman=explode(' ',$sonuc["tarih"]); 
									?>
									<td><div style="word-wrap: break-word;width:95px;"><?php echo $zaman[0] ?></div></td>
									<td><div style="word-wrap: break-word;width:75px;"><?php echo $zaman[1] ?></div></td>
									<td><div style="word-wrap: break-word;width:90px;"><?php echo $sonuc["kimden"] ?></div></td>
									<td><div style="word-wrap: break-word;width:110px;"><?php echo $sonuc["kime"] ?></div></td>
									<td><div style="word-wrap: break-word;width:100px;"><?php echo $sonuc["grup"] ?></div></td>
									<td><div style="word-wrap: break-word;width:290px;"><?php echo $sonuc["icerik"] ?></div></td>
									<td><div style="word-wrap: break-word;width:35px;"><?php echo $sonuc["tur"] ?></div></td>
							</tr>
						</tbody>
						<?php
							}
						?>
					</table>
				</div>				
			</section>
		</div>
	</body>
	<script>
         $(window).on("load resize ", function() {
            var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
            $('.tbl-header').css({'padding-right':scrollWidth});
        }).resize();
    </script>
</html>