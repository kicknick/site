<?php
	
	function LoadJPEGfromPOST($imgname)
	{
	    $uploaddir = './tmpimg/';
		$uploadfile = $uploaddir . basename($_FILES[$imgname]['name']);
		if (!move_uploaded_file($_FILES[$imgname]['tmp_name'], $uploadfile)){
    		/* Создаем пустое изображение */
	        $im  = imagecreatetruecolor(150, 30);
	        $bgc = imagecolorallocate($im, 255, 255, 255);
	        $tc  = imagecolorallocate($im, 0, 0, 0);

	        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

	        /* Выводим сообщение об ошибке */
	        imagestring($im, 1, 5, 5, 'Ошибка загрузки ' . $uploadfile, $tc);
		}
	    $im = @imagecreatefromjpeg($uploadfile);

	    /* Если не удалось */
	    if(!$im)
	    {
	        /* Создаем пустое изображение */
	        $im  = imagecreatetruecolor(150, 30);
	        $bgc = imagecolorallocate($im, 255, 255, 255);
	        $tc  = imagecolorallocate($im, 0, 0, 0);

	        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

	        /* Выводим сообщение об ошибке */
	        imagestring($im, 1, 5, 5, 'Ошибка загрузки ' . $uploadfile, $tc);
	    }

	    return $im;
	}


	define('FONT_NAME', 'arial.ttf');
	define('FONT_SIZE', 30);

	@$foto_x = $_POST['foto_x'];
	@$foto_y = $_POST['foto_y'];
	@$foto_width = $_POST['foto_width'];
	@$foto_height = $_POST['foto_height'];

	@$firstname = $_POST['firstname'];
	@$lastname = $_POST['lastname'];
	@$middlename = $_POST['middlename'];
	$fio = $lastname.' '.$firstname.' '.$middlename;


	$foto = LoadJPEGfromPOST('user_pic');
	$image = imagecreatetruecolor(1000,1000) // создаем изображение...
	or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки
	
	imagefill($image, 0, 0, 0xFFFFFF);

	imagettftext(
	    $image,      // как всегда, идентификатор ресурса
	    FONT_SIZE,   	// размер шрифта
	    0,           // угол наклона шрифта
	    100,25,      // координаты (x,y), соответствующие левому нижнему
	                 // углу первого символа
	    0x000000,    // цвет шрифта
	    FONT_NAME,   // имя ttf-файла
	    $fio
  	);
	header('Content-type: image/png'); 

	imagecopyresized ($image, $foto, 0, 0, $foto_x, $foto_y, 150, 200, $foto_width, $foto_height);

	imagepng($image);

	imagedestroy($image);                // освобождаем память, выделенную для изображения
?>