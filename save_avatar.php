<?php
session_start();


            //иначе - загружаем изображение пользователя
            $avatars_path = 'avatars/';//папка, куда будет загружаться начальная картинка и ее сжатая копия
            if(preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name']))//проверка формата исходного изображения
                      {                 
                               $filename =    $_FILES['fupload']['name'];
                               $source =    $_FILES['fupload']['tmp_name']; 
                               $target =    $avatars_path . $filename;
                               move_uploaded_file($source,    $target);//загрузка оригинала в папку $avatars_path           
         if(preg_match('/[.](GIF)|(gif)$/',    $filename)) {
                     $im    = imagecreatefromgif($avatars_path.$filename) ; //если оригинал был в формате gif, то создаем    изображение в этом же формате. Необходимо для последующего сжатия
                     }
                     if(preg_match('/[.](PNG)|(png)$/',    $filename)) {
                     $im =    imagecreatefrompng($avatars_path.$filename) ;//если    оригинал был в формате png, то создаем изображение в этом же формате.    Необходимо для последующего сжатия
                     }
                     
                     if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/',    $filename)) {
                               $im =    imagecreatefromjpeg($avatars_path.$filename); //если оригинал был в формате jpg, то создаем изображение в этом же    формате. Необходимо для последующего сжатия
                     }           
			//СОЗДАНИЕ КВАДРАТНОГО ИЗОБРАЖЕНИЯ И ЕГО ПОСЛЕДУЮЩЕЕ СЖАТИЕ    ВЗЯТО С САЙТА www.codenet.ru           
			// Создание квадрата 
            // dest - результирующее изображение 
            // w - ширина изображения 
            // ratio - коэффициент пропорциональности           
			$w    = 220;  //    квадратная 200x200. Можно поставить и другой размер.          
			// создаём исходное изображение на основе 
            // исходного файла и определяем его размеры 
            $w_src    = imagesx($im); //вычисляем ширину
            $h_src    = imagesy($im); //вычисляем высоту изображения
                     // создаём    пустую квадратную картинку 
                     // важно именно    truecolor!, иначе будем иметь 8-битный результат 
                     $dest = imagecreatetruecolor($w,$w);           
         //    вырезаем квадратную серединку по x, если фото горизонтальное 
                     if    ($w_src>$h_src) 
                     imagecopyresampled($dest, $im, 0, 0,
                                         round((max($w_src,$h_src)-min($w_src,$h_src))/2),
                                      0, $w, $w,    min($w_src,$h_src), min($w_src,$h_src));           
         // вырезаем    квадратную верхушку по y, 
                     // если фото    вертикальное (хотя можно тоже серединку) 
                     if    ($w_src<$h_src) 
                     imagecopyresampled($dest, $im, 0, 0,    0, 0, $w, $w,
                                      min($w_src,$h_src),    min($w_src,$h_src));           
         // квадратная картинка    масштабируется без вырезок 
                     if ($w_src==$h_src) 
                     imagecopyresampled($dest,    $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src);           
$name=$_SESSION['login'];    //вычисляем время в настоящий момент.
            imagejpeg($dest,    $avatars_path.$name.".jpg");//сохраняем    изображение формата jpg в нужную папку, именем будет текущее время. Сделано,    чтобы у аватаров не было одинаковых имен.          
//почему именно jpg? Он занимает очень мало места + уничтожается    анимирование gif изображения, которое отвлекает пользователя. Не очень    приятно читать его комментарий, когда краем глаза замечаешь какое-то    движение.          
$avatar    = $avatars_path.$name.".jpg";//заносим в переменную путь до аватара. 

$delfull    = $avatars_path.$filename; 
            unlink    ($delfull);//удаляем оригинал загруженного    изображения, он нам больше не нужен. Задачей было - получить миниатюру.
            }
            else 
                     {
                                //в случае    несоответствия формата, вываливаемся
                     			$redirect_url = "/cabinet";
								header('HTTP/1.1 200 OK');
								header('Location: http://'.$_SERVER['HTTP_HOST'].$redirect_url);
                             }
            //конец процесса загрузки и присвоения переменной $avatar адреса    загруженной авы
            
			$redirect_url = "/cabinet";

header('Cache-Control: no-store, no-cache, must-revalidate'); // основное для нормальных браузеров
header('Cache-Control: post-check=0, pre-check=0', false); // тоже основное
header('Expires: Mon, 01 Jan 1990 01:00:00 GMT'); // срок жизни страницы истек в прошлом (специально для ИЕ)
header('Last-Modified: '.gmdate("D, d M Y H:i:s").' GMT'); // последнее изменение - в момент запроса (тоже специально для ИЕ)
header('Pragma: no-cache'); // для совместимости
header('HTTP/1.1 200 OK');
header('Location: http://'.$_SERVER['HTTP_HOST'].$redirect_url);
    ?>