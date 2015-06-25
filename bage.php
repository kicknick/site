<?php
	
	function transliterate($input){
		$gost = array(
		   "Є"=>"YE","І"=>"I","Ѓ"=>"G","і"=>"i","№"=>"-","є"=>"ye","ѓ"=>"g",
		   "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
		   "Е"=>"E","Ё"=>"YO","Ж"=>"ZH",
		   "З"=>"Z","И"=>"I","Й"=>"J","К"=>"K","Л"=>"L",
		   "М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R",
		   "С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"X",
		   "Ц"=>"C","Ч"=>"CH","Ш"=>"SH","Щ"=>"SHH","Ъ"=>"'",
		   "Ы"=>"Y","Ь"=>"","Э"=>"E","Ю"=>"YU","Я"=>"YA",
		   "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
		   "е"=>"e","ё"=>"yo","ж"=>"zh",
		   "з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
		   "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
		   "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"x",
		   "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
		   "ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
		   " "=>"_","—"=>"_",","=>"_","!"=>"_","@"=>"_",
		   "#"=>"-","$"=>"","%"=>"","^"=>"","&"=>"","*"=>"",
		   "("=>"",")"=>"","+"=>"","="=>"",";"=>"",":"=>"",
		   "'"=>"","\""=>"","~"=>"","`"=>"","?"=>"","/"=>"",
		   "\\"=>"","["=>"","]"=>"","{"=>"","}"=>"","|"=>""
  		);

		return strtr($input, $gost);
	}

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


	define("event1", "test");
	define("event2", "test");
	

	@$foto_x = $_POST['foto_x'];
	@$foto_y = $_POST['foto_y'];
	@$foto_width = $_POST['foto_width'];
	@$foto_height = $_POST['foto_height'];

	@$firstname = $_POST['firstname'];
	@$lastname = $_POST['lastname'];
	@$middlename = $_POST['middlename'];
	@$event = $_POST['event'];

	$fio = transliterate($lastname.'_'.$firstname.'_'.$middlename);

	$imgname = getImageName('user_pic');

	if(!$foto_x && !$foto_y && !$foto_width && !$foto_height)
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		die("Выделите область на изображении!");
	}

	$foto = LoadJPEGfromPOST($imgname);

	//if($event != event1)
	//{
		$bagename = './bage.jpg';
		define('FONT_NAME', 'REGATA_NORMAL.ttf');
		if( (strlen($lastname)>20) || (strlen($firstname)>20) || (strlen($middlename)>20) )
			$FONT_SIZE = 45;
		else
			$FONT_SIZE = 55;
		define('X_FACE', 62);
		define('Y_FACE', 232);
		define('W_FACE', 250);
		define('H_FACE', 250);
		define('X_TEXT_1', 350);
		define('Y_TEXT_1', 300);
		define('X_TEXT_2', 350);
		define('Y_TEXT_2', 370);
		define('X_TEXT_3', 350);
		define('Y_TEXT_3', 440);
		define('TEXT_COLOR', 0x222222);
	//}
	
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
	    $FONT_SIZE,   	// размер шрифта
	    0,           // угол наклона шрифта
	    X_TEXT_1,Y_TEXT_1,      // координаты (x,y), соответствующие левому нижнему
	                 // углу первого символа
	    TEXT_COLOR,    // цвет шрифта
	    FONT_NAME,   // имя ttf-файла
	    $lastname//
  	);

	imagettftext(
	    $image,      // как всегда, идентификатор ресурса
	    $FONT_SIZE,   	// размер шрифта
	    0,           // угол наклона шрифта
	    X_TEXT_2,Y_TEXT_2,      // координаты (x,y), соответствующие левому нижнему
	                 // углу первого символа
	    TEXT_COLOR,    // цвет шрифта
	    FONT_NAME,   // имя ttf-файла
	    $firstname//
  	);

  	imagettftext(
	    $image,      // как всегда, идентификатор ресурса
	    $FONT_SIZE,   	// размер шрифта
	    0,           // угол наклона шрифта
	    X_TEXT_3,Y_TEXT_3,      // координаты (x,y), соответствующие левому нижнему
	                 // углу первого символа
	    TEXT_COLOR,    // цвет шрифта
	    FONT_NAME,   // имя ttf-файла
	    $middlename//
  	);


	header('Content-type: image/jpeg'); 

	

	imagecopyresized ($image, $foto, X_FACE, Y_FACE, $foto_x, $foto_y, W_FACE, H_FACE, $foto_width, $foto_height);

	imagejpeg($image, './photos/'.$fio.'.jpg');
	imagejpeg($image);

	imagedestroy($image);                // освобождаем память, выделенную для изображения
?>