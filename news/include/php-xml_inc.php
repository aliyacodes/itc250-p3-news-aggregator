<?php
/*
php-xml_inc.php - a collection of PHP XML related functions
Updated 5/28/2013


*/

/*
	simpleXMLRecursive(), A recursive PHP function for parsing SimpleXML elements
	Adapted By Bill Newman, originally from Dequan Chen (dequanchen2007@gmail.com) 
	and Narith Kun (NKun08@winona.edu), WSU 2010
	
	$file = 'xml/catalog.xml';
	$xml = simplexml_load_file($file);
	simpleXMLRecursive($xml);	
*/

function simpleXMLRecursive($xmlObj,$depth=0){
	
	if(count($xmlObj->children())> 0){
		foreach($xmlObj->children() as $child)
		{//loop all children of existing node
			echo '<br />';
			
			//str_repeat() shows an error for each level of depth
			echo str_repeat('->',$depth) . $child->getName() . ': ' . $child . ' ';
		    
			//loop attributes
			foreach($child->attributes() as $attr) {
		        echo str_repeat('',$depth) . $attr->getName() . '=' . $attr . ' '; 
			}   
	     	//loop again at $depth+1
			simpleXMLRecursive($child,$depth+1);    
		}
	}
	
	
}
?>