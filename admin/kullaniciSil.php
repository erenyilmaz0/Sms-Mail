<?php
    session_start(); //oturum başlattık
    //eğer mevcut oturum yoksa sayfayı yönlendiriyoruz.

    if($_GET)
    {
        require('ayarlar.php');
        // veri tabani bağlantisi
        $connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        //$id=(int)$_GET["id"]; //silinecek id yi get ile alıyoruz
        //silme sorgumuzu çalıştırıyoruz
        $username=strval($_GET["username"]);
        $connection->query("DROP TABLE ".$username."Rapor");
        $connection->query("DROP TABLE ".$username."Grup");
        if($sorgu2=$connection->query("DROP TABLE ".$username."Rehber")){
            if($sorgu=$connection->query("delete from accounts where username = '$username'")){
                header("Location:giris.php");
            }else{
                echo "Hata: " . $connection->error;
            }
        }else{
            echo "Hata: " . $connection->error;
        }

        //index.php sayfamıza geri dönüyoruz
        
    }
?>