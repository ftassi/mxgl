<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/silex.phar';
require_once __DIR__ . '/vendor/goutte/goutte.phar';
require_once __DIR__ . '/vendor/simplehtmldom/simple_html_dom.php';
require_once __DIR__ . '/extensions/FacebookServiceProvider/FacebookServiceProvider.php';

use Knp\Silex\ServiceProvider\DoctrineMongoDBServiceProvider;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Document\Gift;
use Goutte\Client;
use Builder\GiftBuilder;

$app = new Silex\Application();
$app['debug'] = true;

$app['autoloader']->registerNamespace('Document', __DIR__);
$app['autoloader']->registerNamespace('Builder', __DIR__);
$app['autoloader']->registerNamespace('Knp', __DIR__ . '/extensions/DoctrineMongoDB/src');
$app['autoloader']->registerNamespace('TobiassjostenSilexProvider\Facebook', __DIR__ . '/extensions/FacebookServiceProvider');

//Registro SessionServiceProvider e inizializzo la sessione prima che lo faccio
//l'sdk di Facebook (altrimenti SessionServiceProvider genera un notice.)
$app->register(new Silex\Provider\SessionServiceProvider());
$app['session']->start();

$app['config'] = array(
    'google_api_key' => getenv('GOOGLE_API_KEY'),
    'facebook_app_id' => getenv('FACEBOOK_APP_ID'),
    'facebook_secret' => getenv('FACEBOOK_SECRET'),
    'mongodb_host' => getenv('MONGOLAB_URI'),
);

$app->register(new TobiassjostenSilexProvider\Facebook\FacebookServiceProvider(), array(
    'facebook.class_file' => __DIR__ . '/vendor/facebook-php-sdk/src/facebook.php',
    'facebook.app_id' => $app['config']['facebook_app_id'],
    'facebook.secret' => $app['config']['facebook_secret'],
));

$app->register(new DoctrineMongoDBServiceProvider(), array(
    'doctrine.odm.mongodb.metadata_cache' => 'ArrayCache',  //@see DoctrineMongoDBServiceProvider line 88: viene caricato sempre ArrayCache se != da apc
    'doctrine.odm.mongodb.proxies_dir' => __DIR__ . '/cache',
    'doctrine.odm.mongodb.hydrators_dir' => __DIR__ . '/cache',
    'doctrine.odm.mongodb.connection_options' => array(
        'database' => 'heroku_app1783973',
        'host' => $app['config']['mongodb_host'],
    ),
    'doctrine.odm.mongodb.documents' => array(
        array('type' => 'annotation', 'path' => __DIR__ . '/Document', 'namespace' => 'Document'),
    ),
    'doctrine.common.class_path' => __DIR__ . '/vendor/doctrine-common/lib',
    'doctrine.mongodb.class_path' => __DIR__ . '/vendor/doctrine-mongodb/lib',
    'doctrine.odm.mongodb.class_path' => __DIR__ . '/vendor/doctrine-mongodb-odm/lib',
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/view',
    'twig.class_path' => __DIR__ . '/vendor/twig/lib',
));

$app['giftComposer'] = function()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'http://www.google.it');
        return new GiftBuilder($crawler);
    };

AnnotationRegistry::registerFile(__DIR__ . '/vendor/doctrine-mongodb-odm/lib/Doctrine/ODM/MongoDB/Mapping/Annotations/DoctrineAnnotations.php');