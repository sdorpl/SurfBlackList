<?php 
//Uchwyt BASE_PATH i pliku z funkcjami
define('BASE_PATH', realpath(dirname(__FILE__)));
include(BASE_PATH.'/include/functions.php');

//Ustalam domenę i secret_id - aby uzyskać napisz maila: admin[at]xtrasurf.pl
$domain = 'xtrasurf.pl';
$sid = 'd9dcf7d28fc1ed695aeaaa3c7363c023';

//Pobieram listę zbanowanych stron i sprawdzam, $_GET['url'] zastąpić zmienną z formularza zawierającą URL strony.
$blacklist = CheckBlackList($domain, $sid, $_GET['url']);

//Przetwarzam wynik sprawdzania listy
if($blacklist[0] == TRUE){
	//Komunikat z info, że strona ma bana. $blacklist[0]['reason'] zawiera powód bana.
	echo 'JSON ZWRACA TRUE, STRONA MA BANA. Powód: '.$blacklist[1];
} elseif($blacklist[0] == FALSE){
	//Skrypt dodający stronę do bazy. Strana nie ma bana i może być dodana do surfa i/lub ptp.
	echo 'JSON ZWRACA FALSE, STRONA MOŻE BYĆ DODANA';
}
?>