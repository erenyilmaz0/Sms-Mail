<?php
session_start();
session_destroy();
//login ekranına yönlendir
header('Location: index.html');
?>