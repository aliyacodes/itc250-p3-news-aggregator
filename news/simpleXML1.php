<?php
/*
simpleXML1.php - shows how to use var_dump() 
to examine simpleXML objects returned from an XML file
*/
$file = 'xml/contacts.xml'; #A deep XML music file
$xml = simplexml_load_file($file);

echo '<pre>';
var_dump($xml);
echo '</pre>';
die;
?>