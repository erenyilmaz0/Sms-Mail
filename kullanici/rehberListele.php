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
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sms/Mail </title>
		<link href="styleAnasayfa.css" rel="stylesheet" type="text/css">
    </head> 
    <style>
        table{
            /*background: -webkit-linear-gradient(right, #25c481, #25b7c4);
            background: linear-gradient(to left, #25c481, #25b7c4);*/
            background-color: #25b7c4;
            width:100%;
            table-layout: fixed;
        }
        .tbl-header{
            background-color: rgba(255,255,255,0.3);
            
        }
        .tbl-content{
            height:320px;
            overflow-x:auto;
            margin-top: 0px;
            border: 1px solid rgba(255,255,255,0.3);
        }
        th{
            background-color: #2c3e50;
            padding: 20px 15px;
            text-align: center;
            font-weight: 500;
            font-size: 16px;
            color: #fff;
        }
        td{
            padding: 15px;
            text-align: center;
            vertical-align:middle;
            font-weight: 300;
            font-size: 15px;
            color: #fff;
            border-bottom: solid 1px rgba(255,255,255,0.1);
        }
        section{
            margin: 50px;
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
            <h2>Rehberiniz</h2>
            <section>
                <div class="tbl-header">
                    <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th>Adı</th>
                            <th>Soyadı</th>
                            <th>Grup</th>
                            <th>Telefon No</th>
                            <th>Mail Adresi</th>
                            <th></th>
                            <th>Düzenle/Sil</th>
                        </tr>
                    </thead>
                    </table>
                </div>
                <div class="tbl-content">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <?php
                            $sorgu = $connection->query("select * from ".$_SESSION['name']."Rehber order by grubu");
                            while ($sonuc = $sorgu->fetch_assoc()) {
                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo $sonuc["ad"] ?></td>
                                <td><?php echo $sonuc["soyad"] ?></td>
                                <td><?php echo $sonuc["grubu"] ?></td>
                                <td><?php echo $sonuc["telefon"] ?></td>
                                <td><?php echo $sonuc["mail"] ?></td>
                                <td></td>
                                <td>
                                    <a href="kisiDuzenle.php?id=<?php echo $sonuc["id"] ?>"><img src="image/duzenle2.png"/></a>
                                    <a href="kisiSil.php?id=<?php echo $sonuc["id"] ?>"><img src="image/sil2.png"/></a>
                                </td>
                            </tr>
                        </tbody>
                            <?php } ?>
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