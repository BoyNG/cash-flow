 <?php
	$ref = "";
	if (isset($_GET['ref']))
	{
		$ref = $_GET['ref'];
		// чистим реферала от лишних знаков
		$ref = stripslashes($ref);
		//$ref = htmlspecialchars($ref);
		$vowels = array("_", " ", "*", "!", "@", "#", "%", "&", "-", "+", "<", ">", "?", ":", ";", "(", ")", "{", "}", "~");
		$ref = strtolower(str_replace($vowels, '', $ref));
		// include_once("db.php");
		// $result = mysqli_query($db,"SELECT ID, RefCount FROM tableData_test WHERE Login='$ref'"); 
		// $array = mysqli_fetch_array($result); 
		// $array = $db->getRow("SELECT ID, RefCount FROM `$tableData` WHERE `Login`='$ref'");
		$array = user_info('Login',$ref);
		//Если реферал реальный и статус в работе, то увеличиваем счётчик рефссылки
			if (!empty(user_in_work($array['ID']))) 
			{
				echo $array['ID']."-".$array['RefCount'];
				user_info_update($array['ID'],'RefCount',($array['RefCount']+1));
				// $info = $db->query("UPDATE `$tableData` SET RefCount=RefCount+1 WHERE `Login`='$ref'");
			} 
			else 
			{
				$ref="admin";
			}
	}
?> 
			
<div class="sign-center">  <header>
  <sig2>Нет аккаунта?</sig2>
  <a class="sig2" href="#" id="form-switch">Регистрация!</a>
</header>

<!-- float icons use with class in input -->
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
    <div class="email-icon"></div>
    <div class="qiwi-icon"></div>
<!-- end -->

	<form class="form-sign" action="signin.php" method="POST">
  <div class="front-sign-in">
&nbsp&nbsp&nbsp&nbsp
<?php
	if(empty($_SESSION['login'])) 
	{ 
	Echo "Пожалуйста ведите действующий логин и пароль.";
	} else { echo "Вы уже вошли как <B>".$_SESSION['login']."</B>. Можете перелогиниться либо <a href='signout.php'>выйти.</a>"; }
?>
 <input class="signin-submit" name="go" type="submit" value="ВОЙТИ">
    <input class="input username" type="text" id="texten" name="login" maxlength="16" required="" title="Из английских букв и/или цифр. От 5 до 16 символов." pattern="[A-Za-z0-9_-]{4,16}" placeholder="Логин" autofocus>
	<input class="input password" type="password" name="password" required="" pattern="[A-Za-z0-9]{5,16}" maxlength="16" title="Из английских букв и/или цифр. От 5 до 16 символов." placeholder="Пароль">
   
  </div>
  </form>
  <form class="form-sign" action="signup.php" method="POST">
  <div class="back-sign-up">
<input class="signup-submit" name="go" type="submit" value="Регистрация">
&nbsp&nbsp<span class="check"  ></span><BR>
    <input class="input username" id="texten2" type="text" name="login" required="" maxlength="16" title="Из английских букв и/или цифр. От 4 до 16 символов." pattern="[A-Za-z0-9_-]{4,16}" placeholder="Логин (от 4 символов)" >
	<span class="form_hint">Из английских букв и/или цифр. От 4 до 16 символов.</span>
	<input class="input password" type="password" name="password" required="" pattern="[A-Za-z0-9]{5,16}" maxlength="16"  title="Из английских букв и/или цифр. От 5 до 16 символов." placeholder="Пароль (от 5 символов)">
    <span class="form_hint">Из английских букв и/или цифр. От 5 до 16 символов.</span>
	<input class="input email" type="email" name="email" maxlength="250" pattern="^[A-Za-z0-9@._-]+$"  title="Правильно укажите свой E-Mail! Используется для связи и восстановления пароля!" placeholder="Электронная почта">
	<span class="form_hint">Правильно укажите свой E-Mail! Используется для связи и восстановления пароля!</span>
    <input class="input qiwi" id="phone" type="text" name="qiwi" required="" pattern="\+[0-9]\s\([0-9]{3}\)\s[0-9]{3}-[0-9]{2}-[0-9]{2}" title="Номер Вашего QIWI кошелька в формате +7(913)123-12-34" placeholder="QIWI кошелёк">
    <span class="form_hint">Номер Вашего QIWI кошелька в формате +7(913)123-12-34.</span>
	<input type="text" value="<?echo $ref;?>" name="referer" readonly="readonly" pattern="[A-Za-z0-9]{5,16}" maxlength="16" title="Кто вас пригласил">
	 &nbsp &nbspС <a href="rule" target="_blank">правилами сайта</a> согласен:
	<input checked="checked" name="agree" required="" type="checkbox"><BR>

  </div>
  </form>
<div>  
  
  <!-- load jquery for other scripts -->  

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<!-- switch off local js <script src="js/jquery.js"></script>
   end -->

  <!-- masked input jss -->
    <script type="text/javascript">jQuery(function($){ $("#phone").mask("?+9 (999) 999-99-99"); });</script>
    <script type="text/javascript">jQuery(function($){ $("#texten").mask("?****************");});</script>
    <script type="text/javascript">jQuery(function($){ $("#texten2").mask("?****************");});</script>
    <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
<!-- end -->



<!-- float icons js -->  
  <script src="js/floaticons.js"></script>
<!-- end -->
<!-- DB usercheck -->  
  <script src="js/usercheck.js"></script>
<!-- end -->
  
  <script src="js/index.js"></script>
