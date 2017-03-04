<?php
/*
simpleXML8.php - Demonstrates an XPath() call 
data returned is an array of elements, not a complete
XML file. Therefore we use a foreach on the array returned.
*/
include 'include/php-xml_inc.php'; #simpleXMLRecursive() function resides here
$file = 'xml/catalog.xml';
$xml = simplexml_load_file($file);

//uses xPath to filter the catalog to only zeppelin albums
$zep = $xml->xPath('/catalog/cd[artist="Led Zeppelin"]');
/*
echo '<pre>';
var_dump($zep);
echo '</pre>';
die;
*/

foreach($zep as $album)
{
	echo $album->title . ', ' . $album->year . '<br />';	
}





?>