<?php
	// function win2uni($s)
	// {
	// 	$s = convert_cyr_string($s,'w','i'); 
	// 	for ($result='', $i=0; $i<strlen($s); $i++) {
	// 		$charcode = ord($s[$i]);
	// 		$result .= ($charcode>175)?"&#".(1040+($charcode-176)).";":$s[$i];
	// 	}
	// 	return $result;
	// }


	define('FONT_NAME', 'arial.ttf');
	define('FONT_SIZE', 20);


	//@$firstname = $_POST['firstname'];
	//@$lastname = $_POST['lastname'];
	//@$middlename = $_POST['middlename'];

	@$firstname = $_GET['firstname'];
	@$lastname = $_GET['lastname'];
	@$middlename = $_GET['middlename'];

	//$firstname = "Sasha";
	//$lastname = "Penko";
	//$middlename = "Valer";

	$fio = $lastname.' '.$firstname.' '.$middlename;
	//$fio = win2uni($fio);


	$image = imagecreatetruecolor(800,600) // создаем изображение...
	or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки

	imagefill($image, 0, 0, 0xFFFFFF);

	//$coord = imagettfbbox(
    //	20,  // размер шрифта
	//	0,          // угол наклона шрифта (0 = не наклоняем)
	//	FONT_NAME,  // имя шрифта, а если точнее, ttf-файла
	//	$fio       // собственно, текст
    //);

	imagettftext(
	    $image,      // как всегда, идентификатор ресурса
	    FONT_SIZE,   	// размер шрифта
	    0,           // угол наклона шрифта
	    0,25,      // координаты (x,y), соответствующие левому нижнему
	                 // углу первого символа
	    0x000000,    // цвет шрифта
	    FONT_NAME,   // имя ttf-файла
	    $fio
  	);

  	// imagettftext(
	  //   $image,      // как всегда, идентификатор ресурса
	  //   FONT_SIZE,   	// размер шрифта
	  //   0,           // угол наклона шрифта
	  //   0,100,      // координаты (x,y), соответствующие левому нижнему
	  //                // углу первого символа
	  //   0x000000,    // цвет шрифта
	  //   FONT_NAME,   // имя ttf-файла
	  //   "Лолец"
  	// );

	header('Content-type: image/png'); 
	// ...И, наконец, выведем сгенерированную картинку в формате PNG:
	imagepng($image);

	imagedestroy($image);                // освобождаем память, выделенную для изображения
?>