<div class="layer-back" style="background-color: #f0f0f0; 
    background-image: linear-gradient(-45deg, transparent 50%, #dfdfd0 50%);">

	 <?php
		if(!empty($_SESSION['login'])) 
		{
			
			$login=$_SESSION['login'];
			$user = user_info("Login","$login");
			$RefererID = $user['Referer'];
			$user2 = user_info("ID","$RefererID");
			
			include "cabinet.menu.php";
			include "cabinet.top.php";
			
			$cabpage = "main";
			if (isset($_GET['cabpage']))
				{
				    $cabpage = $_GET['cabpage'];  
				}
			// обновляем время последней активности пользователя
			user_info_update_time($user['ID']);
			// собираем подстаницу кабинета
			include "cabinet.".$cabpage.".php";
		} else { echo "Вы не вошли в систему!<br>Пожалуйста авторизуйтесь!";
		} 
	?> 

</div>