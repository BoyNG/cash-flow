<?php
include('init.php');
$tableData='tableData_test';
$tableRequest='tableRequest';
$tableSettings='tableSettings';
$option=GetSettings();


// level_list(12);
// print_all_childs(9);
// echo tableRequest_Add (26,11,12341234);
// echo tableRequest_Cancel (11);
// echo tableRequest_Get_ID_Status0 (12,11);
// echo tableRequest_Set_Status(7);
// $infoID=tableRequest_GetInfo_byID(1); foreach ($infoID as $key=>$info) echo $key." - ".$info."<BR>";


function tableRequest_Set_Status($ID,$Status=1)
// Изменение статуса записи о запросе в таблице
//  
// параметр 2: ID записи в tableRequest.
// параметр 3 устанавливаемый статус.
// Статус запроса: -2 отменён создателем запроса\ -1 удалён тем к кому был запрос\ 1 подтверждён\ 0 ожидает
{
	global $db, $tableData, $tableRequest, $option;
	$sql  = "UPDATE `$tableRequest` SET Status=".$Status.", ExpireTime=NOW() WHERE ID=".$ID.""; 
	$out=$db->query($sql);
	return $out;
}



function tableRequest_GetInfo_byID($ID)
// Получение всей информации о записи по её ID 
{
	global $db, $tableData, $tableRequest, $option;
	// echo $FromID," - ",$ToID,"<BR>";
	$out = $db->getRow("SELECT * FROM `$tableRequest` WHERE `ID`='$ID'");
	return $out;
}



function tableRequest_Get_ID_Status0($FromID,$ToID='')
// Получение последнего ID со Status=0 (ожидает) и при этом не просроченного от FromID к ToID
{
	global $db, $tableData, $tableRequest, $option;
	// echo $FromID," - ",$ToID,"<BR>";
	$sqlpart = '';
	if (!empty($ToID)) {
		$sqlpart = $db->parse(" AND `ToID` = ?s", $ToID);
	}
	$out = $db->getOne("SELECT `ID` FROM `$tableRequest` WHERE ExpireTime > NOW() and `Status`=0 and `FromID`='$FromID' ?p  ORDER BY `ID` DESC LIMIT 1", $sqlpart);
	// $out = $db->getOne("SELECT `ID` FROM `$tableRequest` WHERE `Status`=0 ORDER BY `ID` DESC LIMIT 1 ");
	return $out;
}


function tableRequest_Get_All_Actual_IDs($ToID,$Status='0',$FromID='')
// Получение списка ID запросов со Status=0 (ожидает) и при этом не просроченного к ToID (дополнительный фильтр - от FromID)
{
	global $db, $tableData, $tableRequest, $option;
	// echo $ToID," - ",$FromID," - ",$Status,"<BR>";
	$sqlpart = '';
	if (!empty($FromID)) {
		$sqlpart = $db->parse(" AND `FromID` = ?s", $FromID);
	}
	$now=">";
	if ($Status=="-") {
		$Status=0;
		$now = "<";
	}
	if ($Status=="1") {
		$now = "<";
	}
	$out = $db->getAll("SELECT * FROM `$tableRequest` WHERE ExpireTime ?p NOW() and `Status`='$Status' and `ToID`='$ToID' ?p  ORDER BY `RequestTime`", $now, $sqlpart);
	// print_r($out);
	return $out;
}

function tableRequest_Add($FromID,$ToID,$PayTransaction,$PaySys=1,$ProtectCode=0,$Status=0)
// добавление записи о запросе в таблицу
// если 1 параметр '+', то 
// параметр 2: от кого запрос, пишем в (FromID), 
// параметр 3: к кому запрос, пишем в (ToID),
// параметр 4: номер транзакции в платёжной системе, пишем в (PayTransaction)
// параметр 5 (по умолчанию 1): платёжная система, пишем в  (PaySys) 1-QIWI; 2-Yandex;
// параметр 6 (по умолчанию 0): код протекции платежа (ProtectCode)
// параметр 7 (по умолчанию 0): Статус запроса, пишем в (Status)
// В поле Level должно попасть (значение из tableData.Level по ID<FromID) +1 
{
	global $db, $tableData, $tableRequest, $option;
	$Level = 1 + $db->getOne("SELECT `Level` FROM `$tableData` WHERE `ID`='".$FromID."'");
	$data = array('FromID'=>$FromID,'ToID'=>$ToID,'Level'=>$Level,'PaySys'=>$PaySys,'PayTransaction'=>$PayTransaction,'ProtectCode'=>$ProtectCode,'Status'=>$Status); 
	$sql  = "INSERT INTO `$tableRequest` SET RequestTime=NOW(), ExpireTime = (now() + INTERVAL ".$option['TransactionTTL']." HOUR),?u"; 
	$out=$db->query($sql, $data);
	return $out;
}


function GetSettings() // загружаем все настройки в массив
{
	global $db, $tableRequest, $tableSettings;
	
	$value=$db->getAll("SELECT `OptionName`, `OptionValue` FROM `$tableSettings`");
	foreach ($value as $item)
	{
		$valueOut[($item["OptionName"])] = $item["OptionValue"];
		// echo $item["OptionName"].": ".$item["OptionValue"]."<BR>";
	}
	return $valueOut;
}


function print_all_childs($user_id,$deep='5') // распечатка потомков со всех уровней
{
	$level='';
	$list[]=$user_id;
	while ($level++<$deep) 
	{	
		echo "<div class='h3'><B>".$level."-я линия:</B></div><BR>";
		echo "<div>";
		$list=child_list($list);
		if ($list)	foreach ($list as $num=>$item)
		{ 
			$userName=user_info('ID',$item)['Login'];
			echo "<div style='float: left; text-align: left; padding: 10px 40px 30px 10px; width:33%;'>";
			echo $num.") 
			<div class='avatar-mini2' style='background: no-repeat center url(/avatars/".$userName.".jpg), url(/avatars/empty.jpg); background-size: cover ;'></div></a>
			<a href='/cabinet:profiles&user=".$userName."'>".$userName."</a>
			<div class='clear_both'></div></div>";
		}
		
		echo "</div><BR><div class='gradientLine'></div>";
	}
}



function child_list($users_id_array) // возвращает массив потомков с одного уровня. на входе массив предков
{
	global $db, $tableData;
	$output='';
	if ($users_id_array) foreach ($users_id_array as $child)
	{
		// echo "In: ".$child."<BR>";
		$line2 = $db->getCol("SELECT `ID` FROM `$tableData` WHERE `FatherID`='".$child."'");
		foreach ($line2 as $child2)
		{ 
			$output[]=$child2;
			// echo $child2."<BR>";
		}
	}
	return $output;
}


function find_request_id($user_id) // Поиск пользователя для отправки ему запроса на повышение, для обладателя уровня 1 и выше
{
	global $db, $tableData;

	$echo=func_num_args()-1; // 1 - если был 2 дополнительный аргумент
	$user=$user_id; //пользователь который запрашивает повышение уровня
	$user_level=$level=$db->getOne("SELECT `Level` FROM `$tableData` WHERE `ID`='".$user_id."'"); // получаем его текущий уровень
	$level++; // добавляем к уровню единицу
	echo ($echo) ? "User ".$user_id." с уровнем ".$user_level." запрашивает уровень ".($user_level+1)." <BR>" : '';
	while ($level-->0) // перебираем всех предков на глубину до уровня Level
	{$user = $db->getOne("SELECT `FatherID` FROM `$tableData` WHERE `ID`='".$user."'"); echo ($echo) ? $user.")<BR>" : '';}
	
	$level=$db->getOne("SELECT `Level` FROM `$tableData` WHERE `ID`='".$user."'"); // у найденного пользователя получаем уровень
    // if ($echo) echo "у User ".$user." c уровнем ".$level."<BR>"; // выводим на печать если echo=1
	$status=$db->getOne("SELECT `Status` FROM `$tableData` WHERE `ID`='".$user."'"); // у найденного пользователя получаем уровень
	echo ($echo) ? "у User ".$user." c уровнем ".$level." статус ".$status." <BR>" : '';
	if ($status<1) $level=0; // если статус < 0, то и проверяемый уровень ставим 0, для пропуска этого пользователя
	
	if ($level<=$user_level)
		{
	while (($level<=$user_level) and ($user>0)) // перебираем всех предков в глубину до уровня Level
		{
		$user = $db->getOne("SELECT `FatherID` FROM `$tableData` WHERE `ID`='".$user."'"); 
		$level=$db->getOne("SELECT `Level` FROM `$tableData` WHERE `ID`='".$user."'"); // у найденного пользователя получаем уровень
		$status=$db->getOne("SELECT `Status` FROM `$tableData` WHERE `ID`='".$user."'"); // у найденного пользователя получаем уровень
		// if ($echo) echo $user.") ".$level."-".$status."<BR>";
		echo ($echo) ? $user.") ".$level."-".$status."<BR>" : '';
		if ($status<1) $level=0;
		}
	}
	// if ($echo) echo "Запрос отправлен к User ".$user." level: ".$level."<BR>";
	echo ($echo) ? "Запрос отправлен к User ".$user." level: ".$level."<BR>" : '';
	return ($user);
}



function find_father_id($ref_user_id, $level)// Поиск пользователя для отправки ему запроса на повышение, для обладателя уровня 0, т.е. для новичка
// $ref_user_id - id юзера начиная с кого ищем куда подставить реферала - "Вы" на картинке
// $level - уровень глубины до которой проверять
// возвращает id юзера куда подставить реферала. который нужно указать в качестве parent_id у регистрируемого
{
	
	// если уровень превышен - возвращаем неудачу
	if ($level == 0) return -1;
	global $db, $tableData;
	$status_need = 0;
	$childs = $db->getAll("SELECT * FROM `$tableData` WHERE `FatherID`='".$ref_user_id."'");
	// проверяем если меньше 3х потомков - то ставим текущего юзера
	/* echo $ref_user_id."<BR>"; */
	if (count($childs) < 3 && user_in_work($ref_user_id))  return $ref_user_id;
	
	// иначе перебираем детей и пытаемся подставить детям
	$res_id = -1;

	foreach($childs as $child)
	{
		// if ($child['Status'] == 0) // тут можно добавить условия - && $child['level'] =....
		if ($child['Status'] >= $status_need && $child['Level'] >=1)
		{
			$childs2 = $db->getAll("SELECT * FROM `$tableData` WHERE `FatherID`='".$child['ID']."'");
			if (count($childs2) < 3) 
			{
			return $child['ID'];
			}
		}
	}

	// 
	foreach($childs as $child)
	{
		// проверяем что ребенок удовлетворяет условиям
		if ($child['Status'] >= $status_need && $child['Level'] >=1)
		{
			// пытаемся подставить под потомка
			$res_id = find_father_id($child['ID'], $level-1);
			// если получилось - то прекращаем перебор потомков
			if ($res_id != -1) break;
		}
	}
	return $res_id;
}


function list_work_users($var) // генерирует список активных пользователей до определённого ID
{
	$i=1;
	$c=0;
	while ($i<=$var) {
	if (user_in_work($i)==!NULL) {$c=$c+1; echo $i."<BR>";}
	$i++;
	}
	echo "______<BR>".$c;
}



function user_in_work($user_id) // Возвращает 1 если  пользователь активный (Уровень и статус > 0)
{
	global $db, $tableData;
	return $db->getOne("SELECT * FROM `$tableData` WHERE `ID`='$user_id' AND `Level`>=1 AND `Status`>=1") ==!NULL;
}

function user_info_update($user_id,$param,$value) // Обновляет информацию по пользователю
{
	global $db, $tableData;
	// $echo=func_num_args()-2; // 1 - если был 3 дополнительный аргумент
	$info = $db->query("UPDATE `$tableData` SET `$param`='$value' WHERE `ID`='$user_id'");
	// if ($echo) foreach ($info as $key=>$inf) echo $key." - ".$inf."<BR>";
	return $info;
}

function user_info_update_time($user_id) // Обновляет информацию по активности пользователя
{
	global $db, $tableData;
	// $echo=func_num_args()-2; // 1 - если был 3 дополнительный аргумент
	$info = $db->query("UPDATE `$tableData` SET LastLogin=NOW() WHERE `ID`='$user_id'");
	// if ($echo) foreach ($info as $key=>$inf) echo $key." - ".$inf."<BR>";
	return $info;
}

function user_info($param,$value) // Возвращает всю информацию по пользователю производя поиск по полю и значению
{
	global $db, $tableData;
	$echo=func_num_args()-2; // 1 - если был 2 дополнительный аргумент
	$info = $db->getRow("SELECT * FROM `$tableData` WHERE `$param`='$value'");
	if ($echo) foreach ($info as $key=>$inf) echo $key." - ".$inf."<BR>";
	return $info;
}

function print_user_info($user) // Выводит на экран всю информацию по пользователю
{
	global $db, $tableData;
	$echo=func_num_args()-1; // 1 - если был 2 дополнительный аргумент
	if ($echo) {
		$param="Login";
		$info = $db->getRow("SELECT * FROM `$tableData` WHERE `$param`='$user'");
		foreach ($info as $key=>$inf) echo $key." - ".$inf."<BR>";
	}

	$array = user_info("Login","$user");
	

	echo "<div class='avatar' style=\"background-image: url('/avatars/".$array['Login'].".jpg'),url('/avatars/empty.jpg');\"></div>";
	echo "Логин : <a target='_blank' href='/cabinet:profiles&user=".$array['Login']."'>".$array['Login']."</a> <br>"; 
	echo "Настоящее имя: ".$array['RealName']." <br>"; 
	echo "Дата регистрации: ".$array['RegDate']." <br>";
	echo "Дата активности: ".$array['LastLogin']." <br>";
	echo "Уровень: ".$array['Level']." <br>";
	switch ($array['Gender']){
	case "0" : $gender = "Не указан";  break;
	case "1" : $gender = "Мужской";  break;
	case "2" : $gender = "Женский";  break;
	}
	echo "Пол: ".$gender."  <br>";
	echo ($array['City']) ? "Город: ".$array['City']." <br>" : "";
	// echo "E-mail: ".$array['Email']." <br>";
	echo "QIWI: ".$array['QiwiNum']." <br>";
	echo "YandexMoney: ".$array['YandexMoney']." <br>";
	$vk=$array['Vk'];
	$ok=$array['Ok'];
	$skype=$array['Skype'];
	echo "VK: <a target='_blank' href='http://vk.com/$vk'>".$vk."</a> <br>";
	echo "Odnoklassniki: <a target='_blank' href='http://ok.ru/$ok'>".$ok."</a> <br>";
	echo "Skype: <a target='_blank' href='skype:$skype'>".$skype."</a> <br>";	
	return;

}

?>

