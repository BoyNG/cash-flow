<!-- (c) hacsoft, 2005 -->
<html>
<head>
	<title>title</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="index,follow" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>

<?php
if (isset($submit))
{
  $headers  = "From: $fromname <$from>\n";
  $headers .= "MIME-Version: 1.0\n";
  $headers .= "Content-Type: text/$type; charset=\"windows-1251\"";
  mail ($to, $subj, $message, $headers);
  echo ("<br><br><h3 align=center>Сообщение для $to отправлено</h3>\n");
  echo ("<script language='javascript'>\n");
  echo ("setTimeout('document.location=\"post.php/?to=$to&fromname=$fromname&from=$from&subj=$subj\"',3000);\n");
  echo ("</script>\n");
}else
{
?>

<form action=post.php method=post>
<h3>Заполните нужные поля</h3>
<input type=hidden value="ok" name=submit>
<table border=0><tr>
<?php
$t_to = isset($to)?$to:"";
echo ("<td>Кому:</td><td><input type=text name=to size=30 value='$t_to'></td>\n");
echo ("</tr><tr>\n");
$t_fromname = isset($fromname)?$fromname:"";
echo ("<td>От кого:</td><td><input type=text name=fromname size=30 value='$t_fromname'></td>\n");
echo ("</tr><tr>\n");
$t_from = isset($from)?$from:"";
echo ("<td>От e-mail:</td><td><input type=text name=from size=30 value='$t_from'><td>\n");
echo ("</tr><tr>\n");
$t_subj = isset($subj)?$subj:"";
echo ("<td>Тема:</td><td><input type=text name=subj size=30 value='$t_subj'></td>\n");
?>
</tr></table>
Сообщение:<br>
<textarea cols=80 rows=20 name=message></textarea><br>
<input type=radio name=type value=html checked=1> html <input type=radio name=type value=plain> plain<br>
<input type=submit value="Отправить">
</form>

<?php
}
?>

</body>
</html>


<?php 




// $a="1&2фыв123.ru";
// $a= filter_var($a,FILTER_SANITIZE_EMAIL);
// echo "<BR>".$a;

	?>