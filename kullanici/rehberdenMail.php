<?php
ob_start();
session_start();
// giris yapildigi anda oturumu baslat
// eger giriş yapılmamışsa giris ekranina yonlendir
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
require('../admin/ayarlar.php');
$connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
date_default_timezone_set('Europe/Istanbul');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);
$mail->isSMTP(); 
$mail->SMTPKeepAlive=true;                                         
$mail->SMTPAuth   = true;  
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;
$mail->Host       = 'smtp.gmail.com';                    
$mail->Username   = ''; //email                     
$mail->Password   = ''; //email password
$mail->CharSet    = 'UTF-8';
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sms/Mail </title>
		<link href="styleAnasayfa.css" rel="stylesheet" type="text/css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	</head> 
    <style>
        .renk{
            background-color:rgb(255, 168, 37);
        }
        .renk2{
            background-color:rgb(4, 202, 159);
        }
        #rehberdenmailbutonu{
            margin-left:150px;
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
            <h2>Rehberden Mail Gönder</h2>
            <?php 
                $k=$_SESSION['name']; 
                $sorgu = $connection->query("SELECT limits FROM accounts WHERE username = '$k'");
                $sonuc = $sorgu->fetch_assoc();
                $sayac=$sonuc["limits"];
            ?> 
            <form id="tum" method="post"><br>
                <h3 id="kalanbakiye">Kalan Bakiye: <?php echo $sonuc["limits"];?> Mail</h3>
                <table>
                    <tr>
                        <td>Mail Başlığı :</td>
                        <td><input type="text" name="mailbas" required></td>
                    </tr>
                    <tr>
                        <td>Mail İçeriği :</td>
                        <td><br><textarea rows="7" cols="21" name="micer" required></textarea></td>
                    </tr>    
                </table>
                <label id=rehbertabloisim> Kişiler </label> 
                <table id="personel2">
                    <tr>
                        <th style="width:20px;"><input onclick="tumusec();" type="checkbox" name="checkall1" /></th>
                        <th style="width:400px;" colspan="2">Gruplar</th>
                        <th></th>
                    </tr>
                    <?php
                        $sorgu = $connection->query("select * from ".$_SESSION['name']."Grup");
                        while ($sonuc = $sorgu->fetch_assoc()) {
                            $grupAdi=$sonuc["isim"];
                    ?>
                    <tr class="parent" id="<?php echo $sonuc['id'] ?>">
                        <td class="renk"><input type="checkbox" name="deger1[]" value="<?php echo $sonuc['isim'] ?>"></td>
                        <td class="renk" colspan="2"><?php echo $sonuc["isim"]?></td>
                        <td class="renk"><span class="btn"><image src="image/show.png"></image></span></td>
                    </tr>
                    <?php
                        $sorgu2 = $connection->query("select * from ".$_SESSION['name']."Rehber where grubu='$grupAdi'");
                        while ($sonuc2 = $sorgu2->fetch_assoc()) {
                    ?>  
                    <tr class="<?php echo "child-".$sonuc['id'] ?>">
                        <td class="renk2" style="width:20px;"></td>    
                        <td class="renk2"><?php echo $sonuc2["ad"]." ".$sonuc2["soyad"]; ?></td>
                        <td class="renk2"><?php echo $sonuc2["mail"]; ?></td>
                    </tr>
                        <?php
                        }
                    ?> 
                    <?php
                        }
                    ?>
                </table><br>
                <input type="submit" id="rehberdenmailbutonu" value="GÖNDER"/>
            </form>
            <?php
                if($_POST){
                    $mbs=$_POST['mailbas'];
                    $mice=$_POST['micer'];
                    $mail->isHTML(true);                                 
                    $mail->Subject = $mbs; //konu
                    $mail->Body    = $mice; //mail mesajı
                    if(isset($_POST["deger1"])){
                        $degerler=$_POST["deger1"];
                        $sayac2=0;
                        foreach($degerler as $ma){
                            $sorguuu = $connection->query("select * from ".$_SESSION['name']."Rehber where grubu='$ma'");
                            while ($sorguuu->fetch_assoc()) {
                                $sayac2=$sayac2+1;
                            }
                        }
                        $mail->setFrom('baumstaj@gmail.com', $mbs);
                        #$sayac2=count($degerler);
                        if($sayac>=$sayac2){
                            foreach($degerler as $maills){
                                $sorguu = $connection->query("select * from ".$_SESSION['name']."Rehber where grubu='$maills'");                            
                                while ($sonucc = $sorguu->fetch_assoc()) {
                                    $adres=$sonucc["mail"];
                                    $mail->addAddress($adres);
                                    $sayac=$sayac-1;
                                    $dat=strval(date('d.m.Y H:i:s'));
                                    $kimm=$sonucc["ad"]." ".$sonucc["soyad"];
                                    $connection->query("INSERT INTO ".$_SESSION["name"]."Rapor(tarih,kimden,kime,grup,icerik,tur) VALUES ('$dat','$k','$kimm','$maills','$mice','mail')");
                                }
                            }
                            $connection->query("UPDATE accounts SET limits=$sayac WHERE username='$k'");
                            $mail->send();
                            header('Location: rehberdenMail.php');
                        }else{
                            echo "Mail hakkınız yetersizdir<br>";
                            echo $sayac." mail hakkınız var siz ".$sayac2." kişiye mail atmak istediniz<br>";                            
                        }
                    }else{
                        echo "<br>Hiçbir kişi seçmediniz";
                    }
                }
            ?>
            
        </div>
    </body>
    <script type="text/javascript">
        checked = false;
        function tumusec (tum) {
        var checkboxlar1= document.getElementById('tum');
        if (checked == false)
            checked = true
        else
            checked = false
        for (var i =0; i < checkboxlar1.elements.length; i++)
            checkboxlar1.elements[i].checked = checked;
        }
    </script>
    <script>
        $(function() {
        $('tr.parent td span.btn')
            .on("click", function(){
            var idOfParent = $(this).parents('tr').attr('id');
            $('tr.child-'+idOfParent).toggle('slow');
        });
        
        $('tr[class^=child-]').hide().children('td');
        });
    </script> 
</html>
