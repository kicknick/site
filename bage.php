<?php
	
	function getImageName($postname)
	{
		$uploaddir = './tmpimg/';
		//echo $_FILES[$postname]['name'];
		if(!$_FILES[$postname]['name'])
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			die("Выберите изображение!");
		}
		$uploadfile = $uploaddir . basename($_FILES[$postname]['name']);
		if (!move_uploaded_file($_FILES[$postname]['tmp_name'], $uploadfile)){
    		/* Создаем пустое изображение */
	        $im  = imagecreatetruecolor(150, 30);
	        $bgc = imagecolorallocate($im, 255, 255, 255);
	        $tc  = imagecolorallocate($im, 0, 0, 0);

	        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

	        /* Выводим сообщение об ошибке */
	        imagestring($im, 1, 5, 5, 'Ошибка загрузки ' . $uploadfile, $tc);

	        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			die("Ошибка загрузки фото!");
		}
		return $uploadfile;
	}

	function LoadJPEGfromPOST($imgname)
	{
	   
	    $im = @imagecreatefromjpeg($imgname);

	    /* Если не удалось */
	    if(!$im)
	    {
	        /* Создаем пустое изображение */
	        $im  = imagecreatetruecolor(150, 30);
	        $bgc = imagecolorallocate($im, 255, 255, 255);
	        $tc  = imagecolorallocate($im, 0, 0, 0);

	        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

	        /* Выводим сообщение об ошибке */
	        imagestring($im, 1, 5, 5, 'Ошибка загрузки ' . $imgname, $tc);
	    }

	    return $im;
	}


	define('FONT_NAME', 'arial.ttf');
	define('FONT_SIZE', 40);

	@$foto_x = $_POST['foto_x'];
	@$foto_y = $_POST['foto_y'];
	@$foto_width = $_POST['foto_width'];
	@$foto_height = $_POST['foto_height'];

	@$firstname = $_POST['firstname'];
	@$lastname = $_POST['lastname'];
	@$middlename = $_POST['middlename'];
	$fio = $lastname.' '.$firstname.' '.$middlename;

	$imgname = getImageName('user_pic');

	if(!$foto_x && !$foto_y && !$foto_width && !$foto_height)
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		die("Выделите область на изображении!");
	}

	$foto = LoadJPEGfromPOST($imgname);
	$bagename = './bage.jpg';
	$bage = LoadJPEGfromPOST($bagename);
	$size = getimagesize($bagename);
	$image = imagecreatetruecolor($size[0],$size[1]) // создаем изображение...
	or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки


	imagecopy ($image, $bage, 0, 0, 0, 0, $size[0],$size[1]);

	$size = getimagesize($imgname);
	$true_width = $size[0];

	$prop = $true_width / 400;

	$foto_x *= $prop;
	$foto_y *= $prop;
	$foto_width *= $prop;
	$foto_height *= $prop;

	imagefill($image, 0, 0, 0xFFFFFF);

	imagettftext(
	    $image,      // как всегда, идентификатор ресурса
	    FONT_SIZE,   	// размер шрифта
	    0,           // угол наклона шрифта
	    520,650,      // координаты (x,y), соответствующие левому нижнему
	                 // углу первого символа
	    0x000000,    // цвет шрифта
	    FONT_NAME,   // имя ttf-файла
	    $lastname
  	);
	imagettftext(
	    $image,      // как всегда, идентификатор ресурса
	    FONT_SIZE,   	// размер шрифта
	    0,           // угол наклона шрифта
	    520,700,      // координаты (x,y), соответствующие левому нижнему
	                 // углу первого символа
	    0x000000,    // цвет шрифта
	    FONT_NAME,   // имя ttf-файла
	    $firstname.' '.$middlename
  	);
	header('Content-type: image/png'); 

	imagecopyresized ($image, $foto, 105, 450, $foto_x, $foto_y, 345, 460, $foto_width, $foto_height);

	imagepng($image);

	imagedestroy($image);                // освобождаем память, выделенную для изображения
?>