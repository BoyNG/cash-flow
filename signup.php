<?php
 session_start();
	//заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
    if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } 
    //заносим введенный пользователем пароль в переменную $pass, если он пустой, то уничтожаем переменную
    if (isset($_POST['password'])) { $pass=$_POST['password']; if ($pass =='') { unset($pass);} }
    //заносим введенный номер в переменную $qiwi, если он пустой, то уничтожаем переменную
    if (isset($_POST['qiwi'])) { $qiwi=$_POST['qiwi']; if ($qiwi =='') { unset($qiwi);} }
	//заносим введенный email в переменную $email, если он пустой, то уничтожаем переменную
    if (isset($_POST['email'])) { $email=$_POST['email']; }
	//заносим введенный referer в переменную $referer, если он пустой, то переменную
	if (isset($_POST['referer'])) { $referer=$_POST['referer']; if ($referer =='') { $referer='admin';} }
	//если пользователь не ввел логин или пароль или номер, то выдаем ошибку и останавливаем скрипт	
	if (empty($login) or empty($pass) or empty($qiwi)) 
    {
    exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
    }
    //если логин и пароль введены, то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести

 //удаляем лишние подчёркивания и пробелы 
    $login=strtolower(str_replace('_', '', $login));
	$login = stripslashes($login);
    $login = htmlspecialchars($login);
    $pass = stripslashes($pass);
    $pass = htmlspecialchars($pass);
 //удаляем лишние пробелы 
    $login = trim($login);
    $pass = trim($pass);
 // подключаемся к базе
    include ("db.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
 // проверка реферера на существование 
 $refresult = mysqli_query($db, "SELECT id FROM tableData_test WHERE Login='$referer'");
 $refmyrow = mysqli_fetch_array($refresult);
 // ложим в переменную id реферера
 $refnum=$refmyrow['id'];
 if (empty($refmyrow['id'])) {
 $refnum=11;
 }
// echo $login."<BR>";    
// echo $pass."<BR>"; 
// echo $qiwi."<BR>";
// echo $email."<BR>";   
// echo $refnum."-".$referer."<br>"; 
 // проверка на существование пользователя с таким же логином
    $result = mysqli_query($db, "SELECT id FROM tableData_test WHERE Login='$login'");
    $myrow = mysqli_fetch_array($result);
    if (!empty($myrow['id'])) {
    exit ("Извините, введённый вами логин уже зарегистрирован. Введите другой логин.");
    }
 // если такого нет, то сохраняем данные
    $result2 = mysqli_query ($db, "INSERT INTO tableData_test (Login,Pass,Email,Referer,QiwiNum,RegDate,Gender) VALUES('$login','$pass','$email','$refnum','$qiwi',CURRENT_TIMESTAMP(),0)");
    // Проверяем, есть ли ошибки
    if ($result2=='TRUE')
    {	
	$result3 = mysqli_query ($db, "UPDATE tableData_test SET RefRegCount=RefRegCount+1 WHERE ID = '$refnum'"); // добавляем рефереру счётчик регистраций рефералов
	echo "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт. <a href='/sign'>Войти на сайт</a>";
	$_SESSION['login']=$login; 
	$redirect_url = "/cabinet";
	header('HTTP/1.1 200 OK');
	header('Location: http://'.$_SERVER['HTTP_HOST'].$redirect_url);

    }
 else {
    echo "Ошибка! Вы не зарегистрированы.";
    }
    ?>