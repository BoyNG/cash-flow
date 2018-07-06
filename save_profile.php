<?php
session_start();

$name=$_SESSION['login'];
$realname=$_POST['realname'];
$email=$_POST['email'];
$gender=$_POST['gender'];
$city=$_POST['city'];
$qiwi=$_POST['qiwi'];
$yandex=$_POST['yandex'];
$vk=$_POST['vk'];
$ok=$_POST['ok'];
$skype=$_POST['skype'];
echo $skype;


$redirect_url = "/cabinet?logins=$name&email=$email";

header('Cache-Control: no-store, no-cache, must-revalidate'); // основное для нормальных браузеров
header('Cache-Control: post-check=0, pre-check=0', false); // тоже основное
header('Expires: Mon, 01 Jan 1990 01:00:00 GMT'); // срок жизни страницы истек в прошлом (специально для ИЕ)
header('Last-Modified: '.gmdate("D, d M Y H:i:s").' GMT'); // последнее изменение - в момент запроса (тоже специально для ИЕ)
header('Pragma: no-cache'); // для совместимости
header('HTTP/1.1 200 OK');
header('Location: http://'.$_SERVER['HTTP_HOST'].$redirect_url);
?>
