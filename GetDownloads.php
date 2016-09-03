<?php

function getDownloads($url, $type)
{
	$html = file_get_contents($url);

	$dom = new DOMDocument;
	libxml_use_internal_errors(true);
	$dom->loadHtml($html);
	libxml_use_internal_errors(false);

	$links = $dom->getElementsByTagName('a');

	$ziplinks = array();

	foreach ($links as $link)
	{
		$linkstr = $link->getAttribute('href');
		
		if(strpos($linkstr, $type) !== false)
		{
			$prevlink = $linkstr;
			if($linkstr[0] !== '/')
			{
				$linkstr = '/'.$linkstr;
			}
			array_push($ziplinks, "https://github.com".$link->getAttribute('href'));
		}
	}
	foreach($ziplinks as $link)
	{
		$file = fopen($link, 'r');
		$arr2 = explode("/", $link);
		foreach($arr2 as $value) $filename = $value;
		$n = count($arr);
		if($filename == "")
		{
			$filename = $arr[$n-2];
		}
		file_put_contents('./files/'.$filename, $file);
	}
}

getDownloads('https://github.com/AuroraWright/arm9loaderhax/releases/latest', '.7z');
getDownloads('https://github.com/d0k3/Decrypt9WIP/releases/latest', '.zip');
getDownloads('https://github.com/d0k3/Hourglass9/releases/latest', '.zip');
getDownloads('https://github.com/AuroraWright/Luma3DS/releases/latest', '.7z');
getDownloads('https://github.com/AuroraWright/SafeA9LHInstaller/releases/latest', '.7z');
getDownloads('https://github.com/yellows8/hblauncher_loader/releases/latest', '.zip');
getDownloads('https://github.com/Hamcha/lumaupdate/releases/latest', '.cia');
getDownloads('https://github.com/Cruel/DspDump/releases/latest', '.3dsx');
getDownloads('https://github.com/Steveice10/FBI/releases/latest', '.zip');


?>