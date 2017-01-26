<?php 
//Uchwyt BASE_PATH i pliku z funkcjami
define('BASE_PATH', realpath(dirname(__FILE__)));
include(BASE_PATH.'/include/functions.php');

//Ustalam domenę i secret_id - aby uzyskać napisz maila: admin[at]xtrasurf.pl
$domain = 'domena.pl';
$sid = 'secretid';

//Pobieram listę zbanowanych stron i sprawdzam, $url zastąpić zmienną z formularza zawierającą URL strony.
$blacklist = CheckBlackList($domain, $sid, $url);

//Przetwarzam wynik sprawdzania listy
if($blacklist[0] == 'true'){
	//Komunikat z info, że strona ma bana. $blacklist[0]['reason'] zawiera powód bana.
	echo 'JSON ZWRACA TRUE, STRONA MA BANA. Powód: '.$blacklist[1];
} elseif($blacklist[0] == 'unbanned'){
	//Skrypt usuwający bana danej stronie - funkcja opcjonalna, najlepiej zastosować w CRON.
	echo 'JSON ZWRACA UNBANNED, STRONA ZOSTAŁA ODBANOWANA';
} elseif($blacklist[0] == 'false'){
	//Skrypt dodający stronę do bazy. Strana nie ma bana i może być dodana do surfa i/lub ptp.
	echo 'JSON ZWRACA FALSE, STRONA MOŻE BYĆ DODANA';
}
?>