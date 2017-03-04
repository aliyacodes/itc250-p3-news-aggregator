<?php
/*
simpleXML4.php - shows how to use var_dump() 
to examine simpleXML objects returned from an XML file
in v4 we loop through the Elements using getName() to identify the elements & attributes
*/
$file = 'xml/contacts.xml'; #A deep XML music file
$xml = simplexml_load_file($file);
/*
echo '<pre>';
var_dump($xml);
echo '</pre>';
die;
*/
echo 'There are ' . count($xml[0]) . ' child elements to the ' . $xml[0]->getName() . ' element!';

foreach($xml[0]->children() as $child)
{//loop all children of existing node
	echo '<br />';
	
	//show name of current element
	echo $child->getName() . ': ' . $child . ' ';
    
	//loop attributes
	foreach($child->attributes() as $attr) {
        echo $attr->getName() . '=' . $attr . ' '; 
	}   

}

?>