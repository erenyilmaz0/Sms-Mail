<?php
session_start();
// veritabani bilgileri
require('../admin/ayarlar.php');
// veri tabani bağlantisi
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// veri tabani baglanamassa error mesaji
	//exit('Bağlantı Hatası: ' . mysqli_connect_error());
	echo ("<script LANGUAGE='JavaScript'>
		window.alert('Veri tabanı ile bağlantı kurmak ve ilk kullanıcıyı eklemek için önce admin panelinden kullanıcı tanımlayın.');
		window.location.href='index.html';
		</script>");
}
if ( !isset($_POST['username'], $_POST['password']) ) {
	exit('index dosyasındandan gelen username ve password alanı yok!!!');
}
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $password);
		$stmt->fetch();
		if ($_POST['password']===$password) {
			// parola kontrolu
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $id;
			header('Location: anaSayfa.php');
		} else {			
			echo ("<script LANGUAGE='JavaScript'>
			window.alert('Hatalı parola girişi!');
			window.location.href='index.html';
			</script>");
		}
	} else {
		echo ("<script LANGUAGE='JavaScript'>
		window.alert('Kayıtlı kullanıcı bulunamadı!');
		window.location.href='index.html';
		</script>");
	}
	$stmt->close();
}
?>