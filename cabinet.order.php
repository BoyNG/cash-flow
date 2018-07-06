<div class="layer-back">
    <div class="cabinet_order">
		<div class='gradientLine'></div>
		<div id="centr">Мои заказы</div>
		<div class='gradientLine'></div>
			<div class="user_inf">
				Заказать уровень
				<?php
				
				// $Level = isset($_POST['Level']) ? $_POST['Level']:"";
				$Action = isset($_POST['Action']) ? $_POST['Action']:"";
				$AcceptRequestID = isset($_POST['AcceptRequestID']) ? $_POST['AcceptRequestID']:"";
				// $ToID = isset($_POST['ToID']) ? $_POST['ToID']:"";
				$PaySys = isset($_POST['PaySys']) ? $_POST['PaySys']:"";
				$PayTransaction = isset($_POST['PayTransaction']) ? $_POST['PayTransaction']:"";
				$ProtectCode = isset($_POST['ProtectCode']) ? $_POST['ProtectCode']:"";
				
				$level=$user['Level'];
				$levelup=$level+1;
				$user_id=$user['ID'];
				
				//Если было подтверждение, то проверяем для какого ID оно было
				if ($Action=="Подтвердить") {
					$CheckRequestTo=tableRequest_GetInfo_byID($AcceptRequestID)['ToID'];
					$CheckRequestFrom=tableRequest_GetInfo_byID($AcceptRequestID)['FromID'];
					$CheckRequestFromLevel=tableRequest_GetInfo_byID($AcceptRequestID)['Level'];
					$CheckRequestFromStatus=tableRequest_GetInfo_byID($AcceptRequestID)['Status'];
					if ($user_id==$CheckRequestTo and $CheckRequestFromStatus==0) 
					{
						// Если пользователь новый, то мы так же должны отметиться как его реферер и установить рабочий статус и линию.
						if ($CheckRequestFromLevel==1)
						{
							echo " "; 
							user_info_update($CheckRequestFrom,"Line",(user_info('ID',$CheckRequestTo)['Line']+1));
							user_info_update($CheckRequestFrom,"Status",$option['Dimensions']);
							user_info_update($CheckRequestFrom,"FatherID",$CheckRequestTo);
						}
						
						// увеличиваем уровень у пользователя
						user_info_update($CheckRequestFrom,"Level",$CheckRequestFromLevel);
						// ставим статус запроса как выполненный
						tableRequest_Set_Status($AcceptRequestID);
						// echo "<BR>ID: ".$AcceptRequestID."; To: ".$CheckRequestTo."; From: ".$CheckRequestFrom."<BR>";
					}
				}
				
				
				// если все атрибуты запроса переданы то ставим нужный флаг действия
				if (isset($Action) && isset($_POST['PaySys']) && isset($_POST['PayTransaction']))
				{
					if ($Action=="Заказать") $action=1;
					if ($Action=="Удалить") $action=-2;					
					} else {
					$action="";
				}
				
				$pay=$db->getOne("SELECT Gift FROM tableLevel WHERE Level='$levelup'");
				echo $levelup," ";
				// echo "Ваш id ".$user_id,"<BR><BR>";
				
				if ($level) 
				{
					$ToID = find_request_id($user['ID']);
				} else {
					// Если у реферера статус 127, то он может ставить под себя сколько угодно пользователей
					// и тогда ставим нового пользователя под него
					$MegaStatus=user_info('ID',$user['Referer'])['Status'];
					$ToID = ($MegaStatus=='127')? $user['Referer'] : find_father_id($user['Referer'],8);
				}
				$userTo = user_info("ID","$ToID");

				echo "у пользователя:<br>";
				print_user_info($userTo['Login']);
				
				// проверяем есть ли уже актуальный запрос в базе и если да, 
				$checkRequestN=tableRequest_Get_ID_Status0($user_id, $ToID);
				if ($checkRequestN) {
				// то берём из базы все данные о нём
				$RequestInfo=tableRequest_GetInfo_byID($checkRequestN);
				$Level=$RequestInfo['Level'];
				$ToID=$RequestInfo['ToID'];
				$PaySys=$RequestInfo['PaySys'];
				$PayTransaction=$RequestInfo['PayTransaction'];
				$ProtectCode=$RequestInfo['ProtectCode'];
				if ($action==-2) {
					tableRequest_Set_Status($checkRequestN,-2);
					$checkRequestN=0;
				}
				} else {
				// если запроса в базе нет, и действие=Добавить, то добавляем запись.
				if ($action==1) {
					tableRequest_Add($user_id,$ToID,$PayTransaction,$PaySys,$ProtectCode,0);
					$checkRequestN=1;
				}
				}
				
				echo ($checkRequestN) ? "<BR><BR>Ваш запрос отправлен! Ожидайте подтверждения или удалите запрос, если он ошибочный!<BR>":"";
				
				?>
				
			<BR>
			<form class="send_order" method="post">
				<span style="vertical-align:middle;" >Платёжная система: </span>
				<input <?=($checkRequestN)?"onclick=\"return false;\"":""?> type="radio" <? echo ($PaySys=="1") ? "checked" : "";?> style="vertical-align:middle; color: #000; background: #fff;" name="PaySys" value="1" id="radio1"><label for="radio1" style="vertical-align:middle;">QIWI;  </label>
				<input <?=($checkRequestN)?"onclick=\"return false;\"":""?> type="radio" <? echo ($PaySys=="2") ? "checked" : "";?> style="vertical-align:middle; color: #000; background: #fff; " name="PaySys" value="2" id="radio2"><label for="radio2" style="vertical-align:middle;">Yandex</label><BR>
				<input <?=($checkRequestN)?"readonly=\"readonly\"":""?> value="<?=$PayTransaction?>" placeholder="ID транзакции" pattern="^[ 0-9]+$" style="color: #000; background: #fff;" name="PayTransaction" class="input" required="" maxlength="20" type="text">
				<input <?=($checkRequestN)?"readonly=\"readonly\"":""?> value="<?=$ProtectCode?>" placeholder="код протекции" pattern="^[ 0-9]+$" style="color: #000; background: #fff;" name="ProtectCode" class="input" maxlength="20" type="text">
				<input name="Action" style="color: #000; background: #fff;" class="input" value="<?=($checkRequestN) ? "Удалить": "Заказать"?>" type="submit">
				<div class="clear_both"></div>
				<div></div>
			</form>
				
				Для получения уровня, <BR>
				1) Вам нужно сделать подарок пользователю <?=$userTo['Login']?> в размере <?=$pay?> рублей, на кошелёк QIWI или Яндекс.<BR> 
				2) И затем ввести номер транзакции в поле выше. При необходимости можете использовать код протекции (пока есть только в Яндекс).<BR>
				3) Нажать заказать и ожидать подтверждения заказа.
			</div>	
	</div>
</div>
<div class="layer-back">
    <div class="cabinet_order">
                <div></div><BR><BR>
        <div class='gradientLine'></div>
            <div data-refs="" class='referal'>
				Новые заказы
				<?php
				$RequestIDs=tableRequest_Get_All_Actual_IDs($user_id);
				echo count($RequestIDs)."<div class='gradientLine'></div><BR><BR>";
				
				foreach ($RequestIDs as $RegN=>$RequestID)
				{
				echo "<div class='layer-back' style='border: 2px solid #ffd073;'>";
				echo "<div style='text-align: center'><div style='float:left; text-align:center; padding: 10px 40px 30px 10px;'>";
					$userRequestID=$RequestID['FromID'];
					$userRequest=user_info("ID",$RequestID['FromID']);

					// echo $userRequest."<br>";
					$gift=$db->getOne("SELECT Gift FROM tableLevel WHERE Level='".$RequestID['Level']."'");
					
				echo "".($RegN+1).") Ожидаемый подарок ".$gift." рублей ";
				echo " за уровень ".$RequestID['Level']."<BR>";
				echo ($RequestID['PaySys']==1) ? "На QIWI" : "На Yandex";
				echo ($RequestID['ProtectCode']) ? ", с кодом протекции: ".$RequestID['ProtectCode'] : "";
				echo ". Транзакция №: ".$RequestID['PayTransaction']."<BR>";
				echo "</div><div style='float:left'><form class='send_order2' method='post'><input name='AcceptRequestID' value='".$RequestID['ID']."' type='hidden'><input name='Action' style='color: #000; background: #fff;' class='input' value='Подтвердить' type='submit'></form>Истекает ".$RequestID['ExpireTime']." (МСК)</div></div>";
				echo "<BR><div class='gradientLine'></div><BR>";
				print_user_info($userRequest['Login']);
				
				
				echo "</div>";
				}
				?>
			</div>
	</div>
</div>
<div class="layer-back">
    <div class="cabinet_order">
		<div></div>
		<div class='gradientLine'></div>
            <div data-refs="" class='referal'>
				Просроченные заказы
				<?php
				$RequestIDs=tableRequest_Get_All_Actual_IDs($user_id,'-');
				echo count($RequestIDs)."<div class='gradientLine'></div><BR><BR>";
				
				foreach ($RequestIDs as $RegN=>$RequestID)
				{
				echo "<div class='layer-back' style='border: 2px solid #ffd073;'>";
				echo "<div style='text-align: center'><div style='float:left; text-align:center; padding: 10px 40px 30px 10px;'>";
					$userRequestID=$RequestID['FromID'];
					$userRequest=user_info("ID",$RequestID['FromID']);

					// echo $userRequest."<br>";
					$gift=$db->getOne("SELECT Gift FROM tableLevel WHERE Level='".$RequestID['Level']."'");
					
				echo "".($RegN+1).") Ожидался подарок ".$gift." рублей ";
				echo " за уровень ".$RequestID['Level']."<BR>";
				echo ($RequestID['PaySys']==1) ? "На QIWI" : "На Yandex";
				echo ($RequestID['ProtectCode']) ? ", с кодом протекции: ".$RequestID['ProtectCode'] : "";
				echo ". Транзакция №: ".$RequestID['PayTransaction']."<BR>";
				echo "</div><div style='float:left'><BR>Запрос просрочен ".$RequestID['ExpireTime']." (МСК)</div></div>";
				echo "<BR><div class='gradientLine'></div><BR>";
				print_user_info($userRequest['Login']);
				
				
				echo "</div>";
				}
				?>
			</div>
	</div>
</div>
<div class="layer-back">
    <div class="cabinet_order">
		<div></div>
		<div class='gradientLine'></div>
            <div data-refs="" class='referal'>
				Подтвержденные заказы
				<?php
				$RequestIDs=tableRequest_Get_All_Actual_IDs($user_id,'1');
				echo count($RequestIDs)."<div class='gradientLine'></div><BR><BR>";
				
				foreach ($RequestIDs as $RegN=>$RequestID)
				{
				echo "<div class='layer-back' style='border: 2px solid #ffd073;'>";
				echo "<div style='text-align: center'><div style='float:left; text-align:center; padding: 10px 40px 30px 10px;'>";
					$userRequestID=$RequestID['FromID'];
					$userRequest=user_info("ID",$RequestID['FromID']);

					// echo $userRequest."<br>";
					$gift=$db->getOne("SELECT Gift FROM tableLevel WHERE Level='".$RequestID['Level']."'");
					
				echo "".($RegN+1).") Полученный подарок ".$gift." рублей ";
				echo " за уровень ".$RequestID['Level']."<BR>";
				echo ($RequestID['PaySys']==1) ? "На QIWI" : "На Yandex";
				echo ($RequestID['ProtectCode']) ? ", с кодом протекции: ".$RequestID['ProtectCode'] : "";
				echo ". Транзакция №: ".$RequestID['PayTransaction']."<BR>";
				echo "</div><div style='float:left'><BR>Уровень подтверждён ".$RequestID['ExpireTime']." (МСК)</div></div>";
				echo "<BR><div class='gradientLine'></div><BR>";
				print_user_info($userRequest['Login']);
				
				
				echo "</div>";
				}
				?>
			</div>
	</div>
</div>