
<?php

include('pdflayer.class.php');

function convert($url, &$urlsconverted)
{
	$actuallink=$url;
	if($actuallink[0] != 'h')
	{
		$actuallink='https://github.com'.$actuallink;
	}
	
	$arr = explode("/", $url);
	$n = count($arr);
	
	foreach($arr as $value) $filename = $value;
	if($filename == "")
	{
		$filename = $arr[$n-2];
	}
	$filename = $filename.'.pdf';
	
	array_push($urlsconverted, $url);
	
	if(file_exists('./files/'.$filename))
	{
		echo 'Already done '.$filename.' so not converting now. Remember to comment out this bit if you want it to overwrite existing files with their latest version.<br>';
		return;
	}
	$key = 'put your key from pdflayer here'
	
	$file = fopen('http://api.pdflayer.com/api/convert?access_key='.$key.'&document_url='.$actuallink, 'r');

	file_put_contents('./files/'.$filename, $file);
}

function findLinks($url, &$urlsconverted)
{
	$actuallink=$url;
	if($actuallink[0] != 'h')
	{
		$actuallink='https://github.com'.$actuallink;
	}
	$html = file_get_contents($actuallink);
	$dom = new DOMDocument;
	libxml_use_internal_errors(true);
	$dom->loadHtml($html);
	libxml_use_internal_errors(false);

	$links = $dom->getElementsByTagName('a');
	$links_to_return = array();

	foreach ($links as $link)
	{
		$arr = explode(".", $link->getAttribute('href'));
		foreach($arr as $value) $zip = $value;
		
		if($zip == 'zip')
		{
			$download=$link->getAttribute('href');
			if($download[0] != 'h')
			{
				$download='https://github.com'.$download;
			}
			$file = fopen($download, 'r');
			$arr2 = explode("/", $link->getAttribute('href'));
			foreach($arr2 as $value) $filename = $value;
			$n = count($arr);
			if($filename == "")
			{
				$filename = $arr[$n-2];
			}
			file_put_contents('./files/'.$filename, $file);
		}
		
		$linkstring = $link->getAttribute('href');
		$inguide = (strpos($linkstring, '/Plailect/Guide/wiki') !== FALSE);
		$alreadyconverted = in_array($linkstring, $urlsconverted);
		$inhistory = (strpos($linkstring, '_history') !== FALSE);
		$oldguide = (strpos($linkstring, 'RedNAND') !== FALSE);	
		
		if($inguide && !$alreadyconverted && !$inhistory && !$oldguide)
		{
			$alink = $link->getAttribute('href');
			$links_to_return[$alink] = $alink;
		}
	}
	return $links_to_return;
}

function recursiveConvert($baseurl, &$urlsconverted)
{
	echo '<br>'.$baseurl.'<br>';
	echo print_r($urlsconverted).'<br>';
	if(!in_array($baseurl, $urlsconverted))
	{
		convert($baseurl, $urlsconverted);
		$newlinks = array();
		$newlinks = findLinks($baseurl, $urlsconverted);
		
		if($newlinks != null)
		{
			foreach($newlinks as $link)
			{
				recursiveConvert($link, $urlsconverted);
			}
		}
	}
}

global $urlsconverted;
$urlsconverted = array();
recursiveConvert('https://github.com/Plailect/Guide/wiki/', $urlsconverted);



?>