<?php

function CheckBlackList($url, $domain, $sid)
{
	$urlParsed = parse_url($url);

	if(empty($urlParsed["query"])) 
	{
		if(empty($urlParsed["scheme"])) 
		{
			$u = $urlParsed['path'];
		} 
		else 
		{
			$u = $urlParsed['host'].$urlParsed['path'];
		}
	} 
	else 
	{
		if(empty($urlParsed["scheme"])) 
		{
			$u = $urlParsed['path'].'/?'.$urlParsed['query'];
		} 
		else 
		{
			$u = $urlParsed['host'].$urlParsed['path'].'/?'.$urlParsed['query'];
		}
	}
	
	$blacklist = json_decode(file_get_contents('https://sdor.pl/json/json.php?r=check&domain='.$domain.'&sid='.$sid.'&url='.$u), true);

	//Przetwarzam wynik sprawdzania listy
	if($blacklist[0]['result'] == 'TRUE')
	{
		//Komunikat z info, że strona ma bana. $blacklist[0]['reason'] zawiera powód bana.
		$result = true;
		$reason = $blacklist[0]['reason'];
		return array($result, $reason);
	} 
	elseif($blacklist[0]['result'] == 'FALSE')
	{
		//Skrypt dodający stronę do bazy. Strana nie ma bana i może być dodana do surfa i/lub ptp.
		$result = false;
		$reason = '';
		return array($result, $reason);
	}
}

function SendToBlackList($url, $reason = "nie podano", $domain, $sid)
{
	$urlParsed = parse_url($url);

	if(empty($urlParsed["query"])) 
	{
		if(empty($urlParsed["scheme"])) 
		{
			$u = $urlParsed['path'];
		} 
		else 
		{
			$u = $urlParsed['host'].$urlParsed['path'];
		}
	} 
	else 
	{
		if(empty($urlParsed["scheme"])) 
		{
			$u = $urlParsed['path'].'/?'.$urlParsed['query'];
		} 
		else 
		{
			$u = $urlParsed['host'].$urlParsed['path'].'/?'.$urlParsed['query'];
		}
	}
	
	$blacklist = json_encode(file_get_contents('https://sdor.pl/json/json.php?r=send&domain='.$domain.'&sid='.$sid.'&url='.$u.'&reason='.$reason), true);

	//Przetwarzam wynik sprawdzania listy
	if($blacklist[0]['result'] == 'TRUE')
	{
		//Komunikat z info, że strona ma bana. $blacklist[0]['reason'] zawiera powód bana.
		$result = true;
		$reason = $blacklist[0]['reason'];
		return array($result, $reason);
	} 
	elseif($blacklist[0]['result'] == 'FALSE')
	{
		//Skrypt dodający stronę do bazy. Strana nie ma bana i może być dodana do surfa i/lub ptp.
		$result = false;
		$reason = '';
		return array($result, $reason);
	}
}
?>