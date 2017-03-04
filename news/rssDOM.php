<?php
//rss-dom.php

$html = new DOMDocument();
@$html->loadHtmlFile('http://www.nytimes.com');
$xpath = new DOMXPath( $html );
$nodelist = $xpath->query( "//link[@rel='alternate']/@href" );
echo "<pre>";
foreach ($nodelist as $n){
	echo $n->nodeValue."\n";
}
echo "</pre>";
?>
