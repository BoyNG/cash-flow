<?php

include "db.php";

if(isset($_POST['login']) && !empty($_POST['login'])) {

$username=strtolower(str_replace('_', '', mysqli_real_escape_string($db, $_POST['login'])));
$query="select * from tableData_test where LOWER(Login)='$username'";
$res=mysqli_query($db, $query);
$count=mysqli_num_rows($res);
$res2=mysqli_fetch_array(mysqli_query($db, $query));
$HTML='';
// проверка на занятость или на длину логина меньше 4
if($count > 0 || strlen($username) < 4){
$HTML='Пользователь уже существует!';
$redirect_url = "/cabinet";
header('HTTP/1.1 200 OK');
header('Location: http://'.$_SERVER['HTTP_HOST'].$redirect_url);

}else{
$HTML='';
$redirect_url = "/sign";
}
echo $HTML;
}

// header('HTTP/1.1 200 OK');
// header('Location: http://'.$_SERVER['HTTP_HOST'].$redirect_url);
// exit();
?>