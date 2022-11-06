<?php
require_once __DIR__ . '/vendor/autoload.php';

$regex = new TrSearchAndReplace\Text\Replace();
/*
echo $regex->searchAndReplace("Ankara'nın Ankara ya faydası yok!", 'ankara', 'samsun').PHP_EOL;
echo $regex->searchAndReplace("Armut un iyisini ayılar yer", 'armut', 'elma').PHP_EOL;
echo $regex->searchAndReplace("tatil'e Mersin e gittim", 'mersin', 'hatay').PHP_EOL;
echo $regex->searchAndReplace("Bugün yemeği istAnbUl da yiyeceğim", 'istanbul', 'Hatay').PHP_EOL;
*/

$content = <<<TEXT
Tuttuğunu Koparacaksın Çatırdayacak parmakları Sonrada Tut ilçesine gideceksin..
TEXT;


echo $regex->searchAndReplace($content, 'Tut', 'hatay');
