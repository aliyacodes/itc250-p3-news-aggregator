<?php
/*
simpleXML7.php - Demonstrates an XPath() call 
data returned is only a fraction of an XML file, so we'll use 
var_dump() to view the contents
*/
include 'include/php-xml_inc.php'; #simpleXMLRecursive() function resides here
$file = 'xml/catalog.xml';
$xml = simplexml_load_file($file);

//uses xPath to filter the catalog to only zeppelin albums
$zep = $xml->xPath('/catalog/cd[artist="Led Zeppelin"]');

echo '<pre>';
var_dump($zep);
echo '</pre>';
die;


?>