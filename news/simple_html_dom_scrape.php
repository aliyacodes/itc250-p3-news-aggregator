<?php
//simple_html_dom_scrape.php
/*
In which we use the simple_html_dom PHP object to 
use JavaScript API style methods (mootools/jQuery)
to extract the 'news' area of the seattle central website

*/

//Website: http://sourceforge.net/projects/simplehtmldom/
include 'include/simple_html_dom.php';

$html = file_get_html('http://seattlecentral.edu/');

foreach($html->find('div#tab_content_1') as $div) {
	$links = $div->getElementsByTagName('a');
}

foreach($links as $link)
{
	echo "url: " . $link->getAttribute('href') . '<br />';
	echo "link text: " . $link->plaintext . '<br />';	
	
}

//grabs all of xml/html and delivers it div with id of #tab_content_1
//both versions below work
//echo $html->find('div#tab_content_1',0)->xmltext;
//echo $html->find('div#tab_content_1',0)->innertext;


?>