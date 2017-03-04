<?php
/*
DOMXMLRecursive.php - Demonstrates how to parse an XML file with PHP's DOM
v6 loads a much larger file to see the depth shown by the recursive 
function named DOMXMLRecursive(), which resides in php-xml_inc.php
*/

$file = 'xml/beethoven.xml'; #a sample XML file
$xmlDoc = new DOMDocument();
$xmlDoc->load($file);

echo $xmlDoc->saveXML();
echo "<br /><br />Alternative - Method 2: <br /><br />";
$x = $xmlDoc->documentElement;
echo $x->nodeName.": ";
foreach ($x->attributes as $attr){
           echo $attr->nodeName.' = "' . $attr->nodeValue . '"';
} 

DOMXMLRecursive($x);

function DOMXMLRecursive($xmlObj,$depth=0) {   
	foreach ($xmlObj->childNodes as $child) {     
		if ($child->nodeType==1 ){
			echo '<br/>';
			echo '-' . str_repeat('->',$depth) . $child->nodeName . ':  ';        
			foreach ($child->attributes as $attr){
				echo str_repeat('',$depth) . $attr->nodeName . ' = "' . $attr->nodeValue . '" ';
			}
			echo '(' . $child->textContent . ')';
			DOMXMLRecursive($child,$depth+1);
		}
	
	}
}
?> 