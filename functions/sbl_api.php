<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Przetwarzam URL */
function ParseURL($url)
{
	$urlParsed = parse_url($url);

	if(empty($urlParsed["query"])) 
	{
		if(empty($urlParsed["scheme"])) 
		{
			return  $urlParsed['path'];
		} 
		else 
		{
			if(empty($urlParsed['path']))
			{
				$urlParsed['path']='';
			}
			return  $urlParsed['host'].$urlParsed['path'];
		}
	} 
	else 
	{
		if(empty($urlParsed["scheme"])) 
		{
			return  $urlParsed['path'].'/?'.$urlParsed['query'];
		} 
		else 
		{
			return  $urlParsed['host'].$urlParsed['path'].'/?'.$urlParsed['query'];
		}
	}	
}

function CheckBlackList($domain, $sid, $url)
{
	$u = ParseURL($url);
	$blacklist = json_decode(file_get_contents('https://api.surfblacklist.tk/?r=checkbl&domain='.$domain.'&sid='.$sid.'&url='.$u), true);

	//Przetwarzam wynik sprawdzania listy
	if($blacklist[0]['result'] == 'TRUE')
	{
		//Komunikat z info, że strona ma bana. $reason zawiera powód bana.
		$result = 'true';
		$respond = $blacklist[0]['respond'];
		$reason = $blacklist[0]['reason'];
		return array($result, $respond, $reason);
	}
	elseif($blacklist[0]['result'] == 'UNBANNED')
	{
		//Komunikat z info, że strona została oznaczona w systemie jako odbanowana.
		$result = 'unbanned';
		$respond = $blacklist[0]['respond'];
		return array($result, $respond);
	}
	elseif($blacklist[0]['result'] == 'FALSE')
	{
		//Skrypt dodający stronę do bazy. Strana nie ma bana i może być dodana do surfa i/lub ptp.
		$result = 'false';
		$respond = $blacklist[0]['respond'];
		return array($result, $respond);
	}
}

function SendToBlackList($domain, $sid, $url, $reason = null)
{
	$u = ParseURL($url);

	if ($reason = null)
	{
		$reason = ' ';
	}
	
	$blacklist = json_decode(file_get_contents('https://api.surfblacklist.tk/?r=sendtobl&domain='.$domain.'&sid='.$sid.'&url='.$u.'&reason='.$reason), true);
	
	//Przetwarzam wynik zapytania
	if($blacklist[0]['result'] == 'TRUE')
	{
		//Komunikat z info, że strona została zbanowana.
		$result = 'true';
		$respond = $blacklist[0]['respond'];
		return array($result, $respond);
	} 
	elseif($blacklist[0]['result'] == 'FALSE')
	{
		//Komunikat z info, że strona ma już bana.
		$result = 'false';
		$respond = $blacklist[0]['respond'];
		return array($result, $respond);
	}
}

function ReportToBlackList($domain, $sid, $url, $reason = null)
{
	$u = ParseURL($url);
	
	if ($reason = null)
	{
		$reason = ' ';
	}
	
	$blacklist = json_decode(file_get_contents('https://api.surfblacklist.tk/?r=reptobl&domain='.$domain.'&sid='.$sid.'&url='.$u.'&reason='.$reason), true);
	
	//Przetwarzam wynik zapytania
	if($blacklist[0]['result'] == 'TRUE')
	{
		//Komunikat z info, że strona została zgłoszona do sprawdzenia.
		$result = 'true';
		$respond = $blacklist[0]['respond'];
		return array($result, $respond);
	} 
	elseif($blacklist[0]['result'] == 'FALSE')
	{
		//Komunikat z info, że strona nie może być zgłoszona - została zgłoszona lub już jest zbanowana.
		$result = 'false';
		$respond = $blacklist[0]['respond'];
		return array($result, $respond);
	}
}

?>