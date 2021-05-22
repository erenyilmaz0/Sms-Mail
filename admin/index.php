<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet"/>
        <title>Admin Girişi</title>
        <style>
            .kutu {
                margin-top: 40px
            }
        </style>
</head>
    <body>
        <form id="form1" method="post">
            <div class="row align-content-center justify-content-center ">
                <div class="col-md-3 kutu">
                    <h3 class="text-center">Admin Giriş Ekranı</h3>
                    <table class="table">
                        <tr>
                            <td>
                                <input type="text" name="txtKadi" class="form-control" placeholder="Kullanıcı adı"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" name="txtParola" class="form-control" placeholder="Parola"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <input type="submit" class="btn btn-primary btn-block" value="Giriş"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center font-weight-bold">
                                <a href="../kullanici/">Kullanıcı Paneli</a>
                            </td>
                        </tr>
                        <td>
                            <?php
                                if ($_POST) {
                                    require('ayarlar.php');
                                    $txtKadi = $_POST["txtKadi"]; 
                                    $txtParola = $_POST["txtParola"]; 
                                    if (($txtKadi===$adminUsername) and ($txtParola===$adminPassword)) {
                                        
                                        $conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS);
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        } 
                                        $conn->query("CREATE DATABASE IF NOT EXISTS ".$DATABASE_NAME);
                                        $conn2=mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
                                        $conn2->query("CREATE TABLE IF NOT EXISTS accounts(id INT(6) AUTO_INCREMENT PRIMARY KEY,username varchar(50) NOT NULL,password varchar(50) NOT NULL,limits int(6) NOT NULL)");
                                        header("Location:giris.php"); 
                                    } else {
                                        echo "<div class='text-center'>Kullanıcı adı veya parola yanlış!</div>";
                                    }
                                }
                            ?>
                        </td>
                    </table>
                </div>
            </div>
        </form>
    </body>
</html>