<?php

session_start();
unset($_SESSION['username']);
unset($_SESSION['isLogin']);
header('Location:index.php');
?>
