<?php
//curl_scrapeDOM.php
//original source: http://merchantos.com/makebeta/php/scraping-links-with-php

//hide identity of current machine
$userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
//$target_url = "http://seattlecentral.edu";
$target_url = "http://google.com";

$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
curl_setopt($ch, CURLOPT_URL,$target_url);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$html = curl_exec($ch);
if (!$html) {
	echo "<br />cURL error number:" .curl_errno($ch);
	echo "<br />cURL error:" . curl_error($ch);
	exit;
}

$dom = new DOMDocument();
$dom->loadHTML($html);

var_dump($dom);
die;



$xpath = new DOMXPath($dom);
$hrefs = $xpath->evaluate("//title");

for ($i = 0; $i < $hrefs->length; $i++) {
	$href = $hrefs->item($i);
	$url = $href->getAttribute('href');
	//storeLink($url,$target_url); #currently unused function to store to db
	echo $url . "<br />";
}


function storeLink($url,$gathered_from) {
	$query = "INSERT INTO links (url, gathered_from) VALUES ('$url', '$gathered_from')";
	mysql_query($query) or die('Error, insert query failed');
}

/*
sql

CREATE TABLE `links` (
`url` TEXT NOT NULL ,
`gathered_from` TEXT NOT NULL ,
`time_stamp` TIMESTAMP NOT NULL
);



*/

?>