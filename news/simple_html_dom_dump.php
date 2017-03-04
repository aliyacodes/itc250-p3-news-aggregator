<?php
//simple_html_dom_dump.php

//http://simplehtmldom.sourceforge.net/
include 'include/simple_html_dom.php';


// Dump contents (without tags) from HTML
//echo file_get_html('http://www.seattlecentral.edu/')->plaintext;

// Create DOM from URL or file
$html = file_get_html('http://www.seattlecentral.edu/');

// Find all images 
foreach($html->find('img') as $element) 
       echo $element->src . '<br />';

// Find all links 
foreach($html->find('a') as $element) 
       echo $element->href . '<br />';



?> 