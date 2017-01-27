<?php
//Uchwyt BASE_PATH i pliku z funkcjami
define('BASE_PATH', realpath(dirname(__FILE__)));
include(BASE_PATH.'/functions/sbl_api.php');

//Ustalam domenę i secret_id - aby uzyskać napisz maila: admin[at]xtrasurf.pl
$domain = 'domena.pl';
$sid = 'secretid';

//Pobieram listę zbanowanych stron i sprawdzam, $url zastąpić zmienną z formularza zawierającą URL strony.
$blacklist = CheckBlackList($domain, $sid, $_GET['url']);

//Przetwarzam wynik sprawdzania listy
if($blacklist[0] == 'true'){
	//Komunikat z info, że strona ma bana. $blacklist[2] zawiera powód bana.
	echo $blacklist[1];
	if($blacklist[2] != '') {
		echo 'Powód: '.$blacklist[2];
	}
} elseif($blacklist[0] == 'unbanned'){
	//Skrypt dodający stronę do bazy. Strana nie ma bana i może być dodana do surfa i/lub ptp.
	echo $blacklist[1];
} elseif($blacklist[0] == 'false'){
	//Skrypt dodający stronę do bazy. Strana nie ma bana i może być dodana do surfa i/lub ptp.
	echo $blacklist[1];
}
?>
