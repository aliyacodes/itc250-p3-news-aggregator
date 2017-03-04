<?php
$xml = new XMLReader();
$xml->open('xml/data.xml');
 
while( $xml->read()) {
  if('product' === $xml->name ) {
		printf('<hr>%3$s ist ein %1$s und hat eine Steuer von %2$d<br>', $xml->name, $xml->getAttribute('tax'), $xml->getAttribute('name') );
		$xml->next();
	}
}