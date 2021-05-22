<?php
    session_start();
    require('ayarlar.php');
    $connect = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $number = count($_POST["name"]);
    $txtKadi = $_POST["txtKadi"]; //Kullanıcı adını değişkene atadık
    $limit = $_POST["kota"];
    $txtParola = $_POST["txtParola"]; //Parolayı değişkene atadık
    $txtParolaTekrar = $_POST["txtParolaTekrar"]; //Parolayı değişkene atadık
    $state=true;
    $durum=true;
    if ($txtParola != $txtParolaTekrar){
        echo"Parolalar uyuşmuyor";
    }else{
        $sorgu2 = $connect -> query("select * from accounts");
        while ($sonuc2 = $sorgu2->fetch_assoc()) {
            if($sonuc2["username"]==$txtKadi){
                $durum=false;
                break;
            }
        }
        if($durum){
            if($number >= 1)
            {
                for($i=0; $i<$number; $i++)
                {
                    if(($_POST["name"][$i] != '')){
                        // $sql = "INSERT INTO liste(isim) VALUES('".mysqli_real_escape_string($connect, $_POST["name"][$i])."')";
                        // mysqli_query($connect, $sql);
                        $state=true;
                    }
                    else{
                        $state=false;
                        break;
                    }
                }
                if(!empty($txtKadi) and !empty($txtParola) and !empty($txtParolaTekrar) and !empty($limit) and $state==true){
                    $sql="INSERT INTO accounts(username,password,limits) VALUES('$txtKadi','$txtParola',$limit)";
                    mysqli_query($connect, $sql);
                    $connect->query("CREATE TABLE IF NOT EXISTS ".$txtKadi."Rehber(id INT(6) AUTO_INCREMENT PRIMARY KEY,ad varchar(50) NOT NULL,soyad varchar(50),mail varchar(50),telefon varchar(50),grubu varchar(50))");
                    $connect->query("CREATE TABLE IF NOT EXISTS ".$txtKadi."Rapor(id INT(6) AUTO_INCREMENT PRIMARY KEY,tarih varchar(50),kimden varchar(50),kime varchar(50),grup varchar(50),icerik varchar(1000),tur varchar(50))");    
                    $connect -> query("CREATE TABLE IF NOT EXISTS ".$txtKadi."Grup(id INT(6) AUTO_INCREMENT PRIMARY KEY,isim varchar(50))");
                    for($i=0; $i<$number; $i++){
                        $sql = "INSERT INTO ".$txtKadi."Grup(isim) VALUES('".mysqli_real_escape_string($connect, $_POST["name"][$i])."')";
                        mysqli_query($connect, $sql);
                    }
                    echo"Kullanıcı eklenmiştir";
                }else{
                    echo"Tüm alanları doldurunuz";
                }
            }
            else
            {
                echo "Grup ismi giriniz";
            }
        }
        else{
            echo"Böyle bir kullanıcı zaten var";
        }
    }
?>