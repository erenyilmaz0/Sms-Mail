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
        if($sorgu=$connection->query("delete from ".$_SESSION['name']."Rehber where id = $id")){
            header("Location:rehberListele.php");
        }else{
            echo "Hata: " . $connection->error;
        }


        //index.php sayfamıza geri dönüyoruz
        
    }
?>