<?php
/*
simpleXML2.php - shows how to use var_dump() 
to examine simpleXML objects returned from an XML file
in v2 we try to loop through the Elements and return FirstLast
*/
$file = 'xml/contacts.xml'; #A deep XML music file
$xml = simplexml_load_file($file);
/*
echo '<pre>';
var_dump($xml);
echo '</pre>';
die;
*/

foreach($xml[0] as $contact)
{
	echo $contact->FirstLast . '<br />';	
	
}

?>