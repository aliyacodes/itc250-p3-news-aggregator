<?php
/*
xsl2.php - a demo file that performs a server side XSL transformation
v2 loads a file from a remote server
*/

$xslDoc = new DOMDocument();
$xslDoc->load("http://www.billnsara.com/cis217/examples/cd5.xsl");

$xmlDoc = new DOMDocument();
$xmlDoc->load("http://www.billnsara.com/cis217/examples/cd1.xml");

$proc = new XSLTProcessor();
$proc->importStylesheet($xslDoc);
echo $proc->transformToXML($xmlDoc);

?>