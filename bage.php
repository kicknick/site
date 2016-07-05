<?php

function transliterate($input)
{
    $gost = array(
        "Є" => "YE", "І" => "I", "Ѓ" => "G", "і" => "i", "№" => "-", "є" => "ye", "ѓ" => "g",
        "А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D",
        "Е" => "E", "Ё" => "YO", "Ж" => "ZH",
        "З" => "Z", "И" => "I", "Й" => "J", "К" => "K", "Л" => "L",
        "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
        "С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "X",
        "Ц" => "C", "Ч" => "CH", "Ш" => "SH", "Щ" => "SHH", "Ъ" => "'",
        "Ы" => "Y", "Ь" => "", "Э" => "E", "Ю" => "YU", "Я" => "YA",
        "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d",
        "е" => "e", "ё" => "yo", "ж" => "zh",
        "з" => "z", "и" => "i", "й" => "j", "к" => "k", "л" => "l",
        "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
        "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "x",
        "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "shh", "ъ" => "",
        "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
        " " => "_", "—" => "_", "," => "_", "!" => "_", "@" => "_",
        "#" => "-", "$" => "", "%" => "", "^" => "", "&" => "", "*" => "",
        "(" => "", ")" => "", "+" => "", "=" => "", ";" => "", ":" => "",
        "'" => "", "\"" => "", "~" => "", "`" => "", "?" => "", "/" => "",
        "\\" => "", "[" => "", "]" => "", "{" => "", "}" => "", "|" => ""
    );

    return strtr($input, $gost);
}

function getImageName($postname)
{
    $uploaddir = './tmpimg/';
    //echo $_FILES[$postname]['name'];
    if (!$_FILES[$postname]['name']) {
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        return 0;
    }
    $uploadfile = $uploaddir . basename($_FILES[$postname]['name']);
    if (!move_uploaded_file($_FILES[$postname]['tmp_name'], $uploadfile)) {
        /* Создаем пустое изображение */
        $im = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

        /* Выводим сообщение об ошибке */
        imagestring($im, 1, 5, 5, 'Ошибка загрузки ' . $uploadfile, $tc);

        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        die("Ошибка загрузки фото!");
    }
    return $uploadfile;
}

function LoadJPEG($imgname)
{

    $im = @imagecreatefromjpeg($imgname);

    /* Если не удалось */
    if (!$im) {
        /* Создаем пустое изображение */
        $im = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

        /* Выводим сообщение об ошибке */
        imagestring($im, 1, 5, 5, 'Ошибка загрузки ' . $imgname, $tc);
    }

    return $im;
}

function LoadPNG($imgname)
{

    $im = @imagecreatefrompng($imgname);

    /* Если не удалось */
    if (!$im) {
        /* Создаем пустое изображение */
        $im = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

        /* Выводим сообщение об ошибке */
        imagestring($im, 1, 5, 5, 'Ошибка загрузки ' . $imgname, $tc);
    }

    return $im;
}

function getCenterX($textPosition, $fieldX, $fieldWidth){
    $textWidth = $textPosition[2] - $textPosition[0];
    return $fieldX + ($fieldWidth - $textWidth) / 2;
}

include ("/Controller/Squad.php");

$emptyimgname = "externals/images/emptybage.jpg";

$foto_x = $_POST['foto_x'];
$foto_y = $_POST['foto_y'];
$foto_width = $_POST['foto_width'];
$foto_height = $_POST['foto_height'];

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$middlename = $_POST['middlename'];
$event = $_POST['event'];

$squad = getSquad($_POST['squad']);
$firstcurator = $squad['firstcurator'];
$secondcurator = $squad['secondcurator'];

$fio = transliterate($lastname . '_' . $firstname . '_' . $middlename);

$foto;
$imgname = getImageName('user_pic');
if(!$imgname){
    $imgname = $emptyimgname;
    $foto = LoadJPEG($imgname);
    $emptysize = getimagesize($imgname);
    $foto_x = 0;
    $foto_y = 0;
    $foto_width = $emptysize[0]-115;
    $foto_height = $emptysize[1]-115;
} else{
    $foto = LoadJPEG($imgname);
    if (!$foto_x && !$foto_y && !$foto_width && !$foto_height) {
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        die("Выделите область на изображении!");
    }
}





$bageFrontName = './externals/images/bage.png';
$bageBackName = './externals/images/bageback.jpg';
define('FONT_NAME', 'arial.ttf');

$LFM_FONT_SIZE = 45;
$CUR_FONT_SIZE = 30;


define('X_FACE', 165);
define('Y_FACE', 292);
define('W_FACE', 360);
define('H_FACE', 360);

define('X_TEXT_1', 50);
define('Y_TEXT_1', 820);
define('X_TEXT_2', 50);
define('Y_TEXT_2', 890);
define('X_TEXT_3', 50);
define('Y_TEXT_3', 955);

define('X_CURATOR_1', 700);
define('Y_CURATOR_1', 470);
define('X_CURATOR_2', 700);
define('Y_CURATOR_2', 380);

define('TEXT_COLOR', 0x585858);

//}

$bageFront = LoadPNG($bageFrontName);
$bageBack = LoadJPEG($bageBackName);
$size = getimagesize($bageFrontName);
$image = imagecreatetruecolor(2 * $size[0], $size[1]) // создаем изображение...
or die('Cannot create image');     // ...или прерываем работу скрипта в случае ошибки


$sizeFoto = getimagesize($imgname);
$true_width = $sizeFoto[0];
$prop = $true_width / 400;
$foto_x *= $prop;
$foto_y *= $prop;
$foto_width *= $prop;
$foto_height *= $prop;
imagecopyresized($image, $foto, X_FACE, Y_FACE, $foto_x, $foto_y, W_FACE, H_FACE, $foto_width, $foto_height);

imagefill($image, 0, 0, 0xFFFFFF);


/*
 * Костыли для text-align:center;
 */
$lastnameTXT = imagettftext(
    $image,      // как всегда, идентификатор ресурса
    $LFM_FONT_SIZE,    // размер шрифта
    0,           // угол наклона шрифта
    X_TEXT_1, Y_TEXT_1,      // координаты (x,y), соответствующие левому нижнему
    // углу первого символа
    TEXT_COLOR,    // цвет шрифта
    FONT_NAME,   // имя ttf-файла
    $lastname//
);
$firstnameTXT = imagettftext(
    $image,      // как всегда, идентификатор ресурса
    $LFM_FONT_SIZE,    // размер шрифта
    0,           // угол наклона шрифта
    X_TEXT_2, Y_TEXT_2,      // координаты (x,y), соответствующие левому нижнему
    // углу первого символа
    TEXT_COLOR,    // цвет шрифта
    FONT_NAME,   // имя ttf-файла
    $firstname//
);
$middlenameTXT = imagettftext(
    $image,      // как всегда, идентификатор ресурса
    $LFM_FONT_SIZE,    // размер шрифта
    0,           // угол наклона шрифта
    X_TEXT_3, Y_TEXT_3,      // координаты (x,y), соответствующие левому нижнему
    // углу первого символа
    TEXT_COLOR,    // цвет шрифта
    FONT_NAME,   // имя ttf-файла
    $middlename//
);
$firstcuratorTXT = imagettftext(
    $image,      // как всегда, идентификатор ресурса
    $CUR_FONT_SIZE,    // размер шрифта
    0,           // угол наклона шрифта
    X_CURATOR_1, Y_CURATOR_1,      // координаты (x,y), соответствующие левому нижнему
    // углу первого символа
    TEXT_COLOR,    // цвет шрифта
    FONT_NAME,   // имя ttf-файла
    $firstcurator//
);
$secondcuratorTXT = imagettftext(
    $image,      // как всегда, идентификатор ресурса
    $CUR_FONT_SIZE,    // размер шрифта
    0,           // угол наклона шрифта
    X_CURATOR_2, Y_CURATOR_2,      // координаты (x,y), соответствующие левому нижнему
    // углу первого символа
    TEXT_COLOR,    // цвет шрифта
    FONT_NAME,   // имя ttf-файла
    $secondcurator//
);

imagecopy($image, $bageFront, 0, 0, 0, 0, $size[0], $size[1]);
imagecopy($image, $bageBack, $size[0], 0, 0, 0, $size[0], $size[1]);

imagettftext(
    $image,      // как всегда, идентификатор ресурса
    $LFM_FONT_SIZE,    // размер шрифта
    0,           // угол наклона шрифта
    getCenterX($lastnameTXT, 0, 700), Y_TEXT_1,      // координаты (x,y), соответствующие левому нижнему
    // углу первого символа
    TEXT_COLOR,    // цвет шрифта
    FONT_NAME,   // имя ttf-файла
    $lastname//
);
imagettftext(
    $image,      // как всегда, идентификатор ресурса
    $LFM_FONT_SIZE,    // размер шрифта
    0,           // угол наклона шрифта
    getCenterX($firstnameTXT, 0, 700), Y_TEXT_2,      // координаты (x,y), соответствующие левому нижнему
    // углу первого символа
    TEXT_COLOR,    // цвет шрифта
    FONT_NAME,   // имя ttf-файла
    $firstname//
);
imagettftext(
    $image,      // как всегда, идентификатор ресурса
    $LFM_FONT_SIZE,    // размер шрифта
    0,           // угол наклона шрифта
    getCenterX($middlenameTXT, 0, 700), Y_TEXT_3,      // координаты (x,y), соответствующие левому нижнему
    // углу первого символа
    TEXT_COLOR,    // цвет шрифта
    FONT_NAME,   // имя ttf-файла
    $middlename//
);
imagettftext(
    $image,      // как всегда, идентификатор ресурса
    $CUR_FONT_SIZE,    // размер шрифта
    0,           // угол наклона шрифта
    getCenterX($firstcuratorTXT, 700, 700), Y_CURATOR_1,      // координаты (x,y), соответствующие левому нижнему
    // углу первого символа
    TEXT_COLOR,    // цвет шрифта
    FONT_NAME,   // имя ttf-файла
    $firstcurator//
);
imagettftext(
    $image,      // как всегда, идентификатор ресурса
    $CUR_FONT_SIZE,    // размер шрифта
    0,           // угол наклона шрифта
    getCenterX($secondcuratorTXT, 700, 700), Y_CURATOR_2,      // координаты (x,y), соответствующие левому нижнему
    // углу первого символа
    TEXT_COLOR,    // цвет шрифта
    FONT_NAME,   // имя ttf-файла
    $secondcurator//
);

//header('Content-type: image/jpeg');


imagejpeg($image, './photos/' . $fio . '.jpeg');
echo '<img src="' . './photos/' . $fio . '.jpeg' . '" style="width:1400px; height:979px">';


imagedestroy($image);                // освобождаем память, выделенную для изображения

?>