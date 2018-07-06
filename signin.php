<?php
    session_start();//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
    //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
if (empty($login) or empty($password)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
    {
    exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
    }
    //если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
        $login=strtolower(str_replace('_', '', $login));
	$login = stripslashes($login);
    $login = htmlspecialchars($login);
$password = stripslashes($password);
    $password = htmlspecialchars($password);
//удаляем лишние пробелы
    $login = trim($login);
    $password = trim($password);
// подключаемся к базе
    include ("db.php");// файл db.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
 
	$result = mysqli_query($db,"SELECT * FROM tableData_test WHERE Login='$login' AND Pass='$password'"); 
	$myrow = mysqli_fetch_array($result); 
	if (empty($myrow['Login'])) 
	{ 
	$redirect_url = "/sign";
	header('HTTP/1.1 200 OK');
	header('Location: http://'.$_SERVER['HTTP_HOST'].$redirect_url);

	exit ("Извините, введённый вами login или пароль неверный."); 
	}
	else{ $_SESSION['login']=$myrow['Login']; $_SESSION['id']=$myrow['ID']; 
	$redirect_url = "/cabinet";
header('HTTP/1.1 200 OK');
header('Location: http://'.$_SERVER['HTTP_HOST'].$redirect_url);
echo "Вы успешно вошли на сайт!"; 
	}
    ?>