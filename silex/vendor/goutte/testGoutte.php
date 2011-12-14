<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/goutte.phar';

use Goutte\Client;

$client = new Client();
$crawler = $client->request('GET', 'http://us.playstation.com/ps3/');
$images = $crawler->filter('h1');
foreach ($images as $image)
{
    /*@var $image \DOMElement */
    echo $image->nodeValue . '<br />';
//    echo $image->getAttribute('src')  . "<br />";
}