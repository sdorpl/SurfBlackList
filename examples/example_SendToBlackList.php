<?php 
//Uchwyt BASE_PATH i pliku z funkcjami
define('BASE_PATH', realpath(dirname(__FILE__)));
include(BASE_PATH.'/include/functions.php');

//Ustalam domenę i secret_id - aby uzyskać napisz maila: admin[at]xtrasurf.pl
$domain = 'domena.pl';
$sid = 'secretid';

//Zgłaszam stronę do zbanowania. $_GET['url'] zastąpić zmienną z URL strony Opcjonalny parametr $reason - powód zgłoszenia strony do bana.
$blacklist = SendToBlackList($domain, $sid, $_GET['url'], $reason);

//Przetwarzam wynik sprawdzania listy
if($blacklist[0] == TRUE){
	//Strona zgłoszona do zbanowania. Komunikat, że strona zgłoszona pomyślnie, moźna wstawić banowanie we własnej bazie.
	echo 'JSON ZWRACA TRUE, STRONA ZOSTAŁA ZGŁOSZONA DO BANA';
} else {
	//Wystąpił problem z systemem SurfBlackList. Podaje info o błędzie.
	echo 'JSON ZWRACA FALSE, PROBLEM Z SYSTEMEM SurfBlackList';
}
?>