<?php
//index.php

$file = 'xml/contacts.xml';

$xml = simplexml_load_file($file);

//echo '<pre>';
//var_dump($xml);
//echo '</pre>';

foreach($xml[0] as $contact)
{
    echo '<p>' . $contact->FirstLast . '</p>';
    echo '<p>' . $contact->attributes()->Date . '</p>';
}