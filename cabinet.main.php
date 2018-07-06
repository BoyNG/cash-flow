<div class="layer-back">
	<div class="avatar" style="background: url('/avatars/<?php echo $_SESSION['login'].".jpg?qwe=".time(); ?>'),url('/avatars/empty.jpg');"></div>
	<div class="avatar_send">
		<form action="save_avatar.php" method="post" enctype="multipart/form-data">
		<label>Выберите аватар формата jpg, gif или png:<br></label>
		<input type="FILE" size="1" name="fupload">
		<BR>
		<input type="submit" name="submit" value="Загрузить аватар">
		</form>	
	</div>
	<div class="user_inf">
		<form action="save_profile.php" method="post">
			<?php
				$refname=$user2['Login'];
				// switch ($user['Gender']){
				// case "0" : $gender = "Не указан"; break;
				// case "1" : $gender = "Мужской"; break;
				// case "2" : $gender = "Женский"; break;
				// }
				$vk=$user['Vk'];
				$ok=$user['Ok'];
				$skype=$user['Skype'];
				$disabled=$user['Editable']?"":"disabled";
			?>
				Логин: <?=$_SESSION['login']?><br>
				Настоящее имя: <input value='<?=$user['RealName']?>' placeholder='Введите ваше имя' style='color: #000; height: 24px; border-radius: 4px; border: 1px solid #b1b3b8; font-size: 14px; padding-left: 5px; width: 247px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;' name='realname' class='input' required='' maxlength='20' type='text'><br>
				Дата регистрации: <?=$user['RegDate']?><br>
				Ваш реферер: <a href='/cabinet:profiles&user=<?=$refname?>'><?=$refname?></a><br>
				Уровень: <a href='/cabinet:order'><?=$user['Level']?></a><br>
				Пол: <select name="gender">
				<option <?=$user['Gender']=='0' ? "selected" : ''?> value="0">Не указан</option>
				<option <?=$user['Gender']=='1' ? "selected" : ''?> value="1">Мужской</option>
				<option <?=$user['Gender']=='2' ? "selected" : ''?> value="2">Женский</option>
				</select><br>
				Город: <input value='<?=$user['City']?>' style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 311px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;' name='city' class='input' maxlength='20' type='text'><br>
				E-mail: <input value='<?=$user['Email']?>' type='email' style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 311px; box-shadow: inset 2px 2px 2px 0 #707070; margin-left: 0px; background: #fff;' name='email' class='input' maxlength='20' required='' ><br>
				QIWI: <input value='<?=$user['QiwiNum']?>' type='phone' style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 319px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;' name='qiwi' class='input' maxlength='20' required='' ><br>
				YandexMoney: <input value='<?=$user['YandexMoney']?>' type='text' style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 262px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;' name='yandex' class='input' maxlength='20'><br>
				<a target='_blank' href='http://vk.com/<?=$vk?>'>VK: </a><input value='<?=$vk?>' type='text' style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 92px;  padding-right:9px; width: 333px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;' name='vk' class='input' maxlength='20'><span style='margin-left:-327px; color:#000;'>http://vk.com/</span><br>
				<a target='_blank' href='http://ok.ru/profile/<?=$ok?>'>Odnoklassniki: </a><input value='<?=$ok?>' type='text' style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 125px;  padding-right:9px; width: 257px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;' name='ok' class='input' maxlength='20'><span style='margin-left:-251px; color:#000;'>http://ok.ru/profile/</span><br>
				<a target='_blank' href='skype:<?=$skype?>'>Skype: </a><input value='<?=$skype?>' type='text' style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 310px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;' name='skype' class='input' maxlength='20'><br>
				Реферальная ссылка: <?=($user['Level']<1)? '<del>':''?><a title="Активна если уровень > 0 и посещаете сайт каждый день">http://<?=$_SERVER['SERVER_NAME']?>/REF:<?=$_SESSION['login']?></a><?=($user['Level']<1)? '</del>':''?><br>
				Переходов по вашей ссылке: <?=$user['RefCount']?><br>
				<a href='http://<?=$_SERVER['SERVER_NAME']?>/cabinet:ref'>Регистраций по вашей ссылке: <?=$user['RefRegCount']?></a><br>
				<input type="submit" name="submit" value="Сохранить изменения">

		<hr>
		Данные пайщика:<BR>

			<div class="form-body">
				<div class="form-group">
					<label class="control-label ">Паспорт</label><BR>

						<input placeholder="5203" <?=$disabled?> class="input" name="form[pasport_series]" value="" required="required" type="text" style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 110px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;' maxlength='4'>
						<span class="help-block">
						серия </span>
						<input placeholder="445566" <?=$disabled?> class="input" name="form[pasport_number]" value="" type="text" style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 110px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;' maxlength='6'>
						<span class="help-block">
						номер </span>
						<input placeholder="555003" <?=$disabled?> class="input" name="form[subdivision_code]" value="" type="text" style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 110px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;' maxlength='6'>
						<span class="help-block">
						код подразделения </span>

					<label class="control-label ">Кем и когда выдан документ</label><BR>
						<input placeholder="УВД ОАО г.Омска" <?=$disabled?> class="input" name="form[pasport_issued]" value="" required="required" type="text" style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 310px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;'>
						<span class="help-block">
						Кем выдан паспорт </span>
						<input <?=$disabled?> class="input" placeholder="01.02.2003" name="form[pasport_date]" value="" required="required" type="text" style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 110px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;'>
						<span class="help-block">
						дата выдачи</span>

					<label class="control-label ">Дата и место рождения</label><BR>
						<input placeholder="г. Омск" <?=$disabled?> class="input" name="form[born_place]" value="" required="required" type="text" style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 310px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;'>
						<span class="help-block">
						место рождения </span>
						<input <?=$disabled?> class="input" placeholder="12.02.1982" name="form[born_date]" value="" required="required" type="text" maxlength='10' style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 110px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;'>
						<span class="help-block">
						дата рождения </span>

					<label class="control-label ">Адрес регистрации</label><BR>
						<input class="input" <?=$disabled?> placeholder="644001" name="form[reg_postcode]" value="" required="required" type="text" maxlength='6' style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 110px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;'>
						<span class="help-block">
						индекс </span>
						<input class="input" <?=$disabled?> placeholder="г. Омск, ул. Куйбышева, 43, кв.527" name="form[reg_address]" value="" required="required" type="text" style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 310px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;'>
						<span class="help-block">
						адрес</span>

					<label class="control-label ">Адрес проживания</label><BR>
						<input class="input" <?=$disabled?> placeholder="644058" name="form[fact_postcode]" value="" type="text" maxlength='6' style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 110px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;'>
						<span class="help-block">
						индекс </span>
						<input class="input" <?=$disabled?> placeholder="г. Омск, ул. Куйбышева, 43, кв.12" name="form[fact_address]" value="" type="text" style='color: #000; height: 24px; border: 1px solid #b1b3b8; border-radius: 4px; font-size: 14px; padding-left: 5px; width: 310px; box-shadow: inset 2px 2px 2px 0 #707070; background: #fff;'>
						<span class="help-block">
						адрес</span>

				</div>
				<!--<div class="form-group">
					<label class="control-label ">Страна</label>
					<div class="col-md-4">
						<select onchange="change_country()" class="input" name="form[id_country]">
							<option>Россия</option>
						</select>
					</div>
					 

					<label class="control-label col-md-1">Регион</label>
					<div class="col-md-4">
						<select class="input" <?=$disabled?> name="form[region_code]">
							<option></option>
							<option>Алтайский край</option>
							<option>Амурская область</option>
							<option>Архангельская область</option>
							<option>Астраханская область</option>
							<option>Белгородская область</option>
							<option>Брянская область</option>
							<option>Владимирская область</option>
							<option>Волгоградская область</option>
							<option>Вологодская область</option>
							<option>Воронежская область</option>
							<option>Еврейская АО</option>
							<option>Забайкальский край</option>
							<option>Ивановская область</option>
							<option>Иркутская область</option>
							<option>Калининградская область</option>
							<option>Калужская область</option>
							<option>Камчатский Край</option>
							<option>Карачаево-Черкесия</option>
							<option>Кемеровская область</option>
							<option>Кировская область</option>
							<option>Костромская область</option>
							<option>Краснодарский край</option>
							<option>Красноярский край</option>
							<option>Курганская область</option>
							<option>Курская область</option>
							<option>Липецкая область</option>
							<option>Магаданская область</option>
							<option>Московская область</option>
							<option>Мурманская область</option>
							<option>Ненецкий АО</option>
							<option>Нижегородская область</option>
							<option>Новгородская область</option>
							<option>Новосибирская область</option>
							<option>Омская область</option>
							<option>Оренбургская область</option>
							<option>Орловская область</option>
							<option>Пензенская область</option>
							<option>Пермская область</option>
							<option>Приморский край</option>
							<option>Псковская область</option>
							<option>Республика Адыгея</option>
							<option>Республика Алтай</option>
							<option>Республика Башкортостан</option>
							<option>Республика Бурятия</option>
							<option>Республика Дагестан</option>
							<option>Республика Ингушетия</option>
							<option>Республика Кабардино-Балкария</option>
							<option>Республика Калмыкия</option>
							<option>Республика Карелия</option>
							<option>Республика Коми</option>
							<option>Республика Марий Эл</option>
							<option>Республика Мордовия</option>
							<option>Республика Саха (Якутия)</option>
							<option>Республика Северная Осетия</option>
							<option>Республика Татарстан</option>
							<option>Республика Тыва</option>
							<option>Республика Хакасия</option>
							<option>Ростовская область</option>
							<option>Рязанская область</option>
							<option>Самарская область</option>
							<option>Ленинградская область</option>
							<option>Саратовская область</option>
							<option>Сахалинская область</option>
							<option>Свердловская область</option>
							<option>Севастополь</option>
							<option>Смоленская область</option>
							<option>Ставропольский край</option>
							<option>Тамбовская область</option>
							<option>Тверская область</option>
							<option>Томская область</option>
							<option>Тульская область</option>
							<option>Тюменская область</option>
							<option>Удмуртская Республика</option>
							<option>Ульяновская область</option>
							<option>Хабаровский край</option>
							<option>Ханты-Мансийский АО</option>
							<option>Челябинская область</option>
							<option>Чеченская Республика</option>
							<option>Чувашская Республика</option>
							<option>Чукотский АО</option>
							<option>Ямало-Ненецкий АО</option>
							<option>Ярославская область</option>
						</select>
					</div>	
				</div>-->
				</div>
				<input type="submit" name="submit" value="Сохранить изменения">
			</form>
         	<!-- 
			<a class='refs_cabinet'>Доход: </a>
			<a class='refs_cabinet'>Команда: </a>
	 	     -->
	</div> 
</div>