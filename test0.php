<?php

include "db.php";

if(isset($_POST['login']) && !empty($_POST['login'])){

$username=strtolower(str_replace('_', '', mysqli_real_escape_string($con, $_POST['login'])));
$query="select * from tableData where LOWER(Login)='$username'";
$res=mysqli_query($con, $query);
$count=mysqli_num_rows($res);
/* $res2=mysql_fetch_array(mysqli_query($con, $query));
*/
$HTML='';
if($count > 0){
$HTML='Пользователь уже существует!';
$redirect_url = "/cabinet";
}else{
$HTML='Пользователь не найден!';
$redirect_url = "/sign";
}
echo $HTML;
}
header('HTTP/1.1 200 OK');
header('Location: http://'.$_SERVER['HTTP_HOST'].$redirect_url);
exit();
?>