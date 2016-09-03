<?php
/*files needed:

-Decrypt9 - done
-Hourglass9 - done
-arm9loaderhax - done
-Luma3ds - done
-safearm9installer - done
-universalinjectgenerator - is a zip
-hblauncher loader - done
-Luma3ds updater - done
-DSP dump - done
-FBI - done



*/
function getDownloads($url, $type)
{
	$html = file_get_contents($url);

	$dom = new DOMDocument;
	$dom->loadHtml($html);

	$links = $dom->getElementsByTagName('a');

	$ziplinks = array();

	foreach ($links as $link)
	{
		if(strpos($link->getAttribute('href'), $type) !== false)
		{
			array_push($ziplinks, "https://github.com/".$link->getAttribute('href'));
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