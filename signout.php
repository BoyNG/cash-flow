<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['password']);
$redirect_url = "/sign";
header('HTTP/1.1 200 OK');
header('Location: http://'.$_SERVER['HTTP_HOST'].$redirect_url);
?>