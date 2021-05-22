<?php
    //eğer mevcut oturum yoksa sayfayı yönlendiriyoruz.
    session_start();
    if($_GET)
    {
        require('../admin/ayarlar.php');
        // veri tabani bağlantisi
        $connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        $id=(int)$_GET["id"]; //silinecek id yi get ile alıyoruz
        //silme sorgumuzu çalıştırıyoruz
        //$username=strval($_GET["username"]);
        $sorgu=$connection->query("select isim from ".$_SESSION['name']."Grup where id = $id");
        $sonuc = $sorgu->fetch_assoc();
        $silinecekGrupAdi=$sonuc["isim"];
        if($sorgu=$connection->query("delete from ".$_SESSION['name']."Grup where id = $id")){
            $sorgu2 = $connection->query("select * from ".$_SESSION['name']."Rehber where grubu='$silinecekGrupAdi'");
            while ($sonuc2 = $sorgu2->fetch_assoc()) {
                $connection->query("UPDATE ".$_SESSION['name']."Rehber SET grubu=' ' WHERE grubu='$silinecekGrupAdi'");
            }
            header("Location:grup.php");
        }else{
            echo "Hata: " . $connection->error;
        }        
    }
?>