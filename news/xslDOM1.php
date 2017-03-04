<?php
/*
xsl1.php - a demo file that performs a server side XSL transformation
*/

$xslDoc = new DOMDocument();
$xslDoc->load("xml/collection.xsl");

$xmlDoc = new DOMDocument();
$xmlDoc->load("xml/collection.xml");

$proc = new XSLTProcessor();
$proc->importStylesheet($xslDoc);
echo $proc->transformToXML($xmlDoc);

?>