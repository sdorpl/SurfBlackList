<?php
//Uchwyt BASE_PATH i pliku z funkcjami
define('BASE_PATH', realpath(dirname(__FILE__)));
include(BASE_PATH.'/functions/sbl_api.php');

//Ustalam domenę i secret_id - aby uzyskać napisz maila: admin[at]xtrasurf.pl
$domain = 'domena.pl';
$sid = 'secretid';

//Zgłaszam stronę do zbanowania. $url zastąpić zmienną z URL strony Opcjonalny parametr $reason - powód zgłoszenia strony do bana.
$blacklist = ReportToBlackList($domain, $sid, $url);

//Przetwarzam wynik sprawdzania listy
if($blacklist[0] == 'true'){
	//Strona zgłoszona do zbanowania. Komunikat, że strona zgłoszona pomyślnie, moźna wstawić banowanie we własnej bazie.
	echo $blacklist[1];
} else {
	//Wystąpił problem z systemem SurfBlackList. Podaje info o błędzie.
	echo $blacklist[1];
}
?>
