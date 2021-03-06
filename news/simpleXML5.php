<?php
/*
Demonstrates how to parse an XML file with SimpleXML
v5 loads an XML file to see the depth shown by the recursive 
function named simpleXMLRecursive(), which resides in php-xml_inc.php
*/
include 'include/php-xml_inc.php'; #simpleXMLRecursive() function resides here
$file = 'xml/contacts.xml'; #a sample XML file
$xml = simplexml_load_file($file);

/*
echo '<pre>';
var_dump($xml);
echo '</pre>';
die;
*/

simpleXMLRecursive($xml);
?>