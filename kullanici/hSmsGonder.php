<?php
ob_start();
// giris yapildigi anda oturumu baslat
session_start();
// eger giriş yapılmamışsa giris ekranina yonlendir
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
require('../admin/ayarlar.php');
$connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
date_default_timezone_set('Europe/Istanbul');
require_once ('sms.class.php');
$sms = new smsGonder;
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sms/Mail </title>
		<link href="styleAnasayfa.css" rel="stylesheet" type="text/css">
	</head> 
	<style>
		#hsg{
			margin-left:160px;
		}
		.tbl-header{
			height:100px;
			width:500px;
			overflow-x:auto;
			position:absolute;
			margin-left:550px;
            top: 320px;
		}
		.tbl-content{
			height:250px;
			width:500px;
			overflow-x:auto;
			position:absolute;
			margin-left:550px;
			top: 364px;
			
		}
		.tbl-content td{
			background-color:#26aa5d;
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
            <h2>Hızlı Sms Gönder</h2>
			<?php 
                $k=$_SESSION['name']; 
                $sorgu = $connection->query("SELECT limits FROM accounts WHERE username = '$k'");
                $sonuc = $sorgu->fetch_assoc();
                $sayac=$sonuc["limits"];
            ?> 
            <h3 id="kalanbakiye"><br>Kalan Bakiye: <?php echo $sonuc["limits"];?> Mesaj</h3>
			<form id="tumuu" method="post"><br>
                <table>
                    <tr>
                        <td>Mesaj Başlığı :</td>
                        <td><input type="text" name="mbas1" id="mbas1" required></td>
                    </tr>
                    <tr>
                        <td>Mesajınız :</td>
                        <td><br><textarea rows="7" cols="21" name="mmes1" id="mmes1" required></textarea></td>
                    </tr>    
					<tr>
                        <td>Alıcılar :</td>
                        <td><br><textarea rows="4" cols="21" name="malici" id="malici" placeholder="Numaralar , ile ayrılmalıdır"></textarea></td>
                    </tr>  
				</table><br>
				<label id=rehbertabloisim>Rehberden eklemek istediğiniz kişi var mı?</label> 
				<section>
					<div class="tbl-header">
						<table id="personel">
							<thead>
								<tr>
									<th style="width:20px;"><input onclick="tumm();" type="checkbox" name="checkall" /></th>
									<th style="width:230px;">Adı Soyadı</th>
									<th style="width:250px;">Telefon No</th>
								</tr>
							</thead>
						</table>
					</div>
					<div class="tbl-content">
						<table id="personel">
							<?php            
								$sorgu = $connection->query("select * from ".$_SESSION['name']."Rehber");
								while ($sonuc = $sorgu->fetch_assoc()) {
							?>
							<tbody>
								<tr>
									<td style="width:20px;"><input type="checkbox" name="deger3[]" value="<?php echo $sonuc['telefon'] ?>"></td>
									<td style="width:230px;"><?php echo $sonuc["ad"]." ".$sonuc["soyad"] ?></td>
									<td style="width:232px;"><?php echo $sonuc["telefon"] ?></td>
								</tr>
							</tbody>
							<?php
								}
							?>
						</table>
					</div>				
				</section>

				<input id="hsg" type="submit" value="GÖNDER">
				<?php
					if($_POST){
						$sayac2=0;
						$dizi=array();
						$baslik=$_POST["mbas1"];
						$mesaj=$_POST["mmes1"];
						$aliciler=$_POST["malici"];
						$reslt=(explode(',',$aliciler));
						foreach ($reslt as $r){
							if(empty($r)){
								continue;
							}
							array_push($dizi,$r);
							$sayac2=$sayac2+1;
						}
						if(isset($_POST["deger3"])){
							$degerler=$_POST["deger3"];
							foreach($degerler as $yeni){
								array_push($dizi,$yeni);
								$sayac2=$sayac2+1;
							} 
						}
						if($sayac>=$sayac2){
							if($sayac2>0){
								echo "tamam = ".$sayac2."<br>";
								foreach ($dizi as $d){
									$sms->sendSms($d, $mesaj,$baslik);
									$sayac=$sayac-1;
									$dat=strval(date('d.m.Y H:i:s'));
									$connection->query("INSERT INTO ".$_SESSION["name"]."Rapor(tarih,kimden,kime,grup,icerik,tur) VALUES ('$dat','$k','$d','---','$mesaj','sms')");
								}
								$connection->query("UPDATE accounts SET limits=$sayac WHERE username='$k'");
								header('Location: hSmsGonder.php');
							}else{
								echo "<br>Hiçbir kişi seçmediniz<br>";
							}
						}
							
						else{
							echo "<br>Sms hakkınız yetersizdir<br>";
                            echo $sayac." sms hakkınız var siz ".$sayac2." kişiye sms atmak istediniz<br>";
						}
					}
					
				?>
			</form>
		</div>
	</body>
	<script type="text/javascript">
        checked = false;
        function tumm (tumuu) {
        var checkboxlar3= document.getElementById('tumuu');
        if (checked == false)
            checked = true
        else
            checked = false
        for (var i =0; i < checkboxlar3.elements.length; i++)
            checkboxlar3.elements[i].checked = checked;
        }
	</script>
	<script>
         $(window).on("load resize ", function() {
            var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
            $('.tbl-header').css({'padding-right':scrollWidth});
        }).resize();
    </script>
</html>