<?php

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
	$blacklist = json_decode(file_get_contents('https://api.surfblacklist.tk/?r=check&domain='.$domain.'&sid='.$sid.'&url='.$u), true);

	//Przetwarzam wynik sprawdzania listy
	if($blacklist[0]['result'] == 'TRUE')
	{
		//Komunikat z info, że strona ma bana. $blacklist[0]['reason'] zawiera powód bana.
		$result = 'true';
		$reason = $blacklist[0]['reason'];
		return array($result, $reason);
	}
	elseif($blacklist[0]['result'] == 'UNBANNED')
	{
		//Skrypt dodający stronę do bazy. Strana nie ma bana i może być dodana do surfa i/lub ptp.
		$result = 'unbanned';
		$reason = '';
		return array($result, $reason);
	}
	elseif($blacklist[0]['result'] == 'FALSE')
	{
		//Skrypt dodający stronę do bazy. Strana nie ma bana i może być dodana do surfa i/lub ptp.
		$result = 'false';
		$reason = '';
		return array($result, $reason);
	}
}

function SendToBlackList($domain, $sid, $url, $reason = null)
{
	$u = ParseURL($url);
	
	$blacklist = json_decode(file_get_contents('https://api.surfblacklist.tk/?r=send&domain='.$domain.'&sid='.$sid.'&url='.$u.'&reason='.$reason), true);
	
	//Przetwarzam wynik sprawdzania listy
	if($blacklist[0]['result'] == 'TRUE')
	{
		//Komunikat z info, że strona ma bana. $blacklist[0]['reason'] zawiera powód bana.
		$result = 'true';
		$reason = $blacklist[0]['reason'];
		return array($result, $reason);
	} 
	elseif($blacklist[0]['result'] == 'FALSE')
	{
		//Skrypt dodający stronę do bazy. Strana nie ma bana i może być dodana do surfa i/lub ptp.
		$result = 'false';
		$reason = $blacklist[0]['reason'];
		return array($result, $reason);
	}
}

?>