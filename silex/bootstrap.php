<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/silex.phar';
require_once __DIR__ . '/vendor/simplehtmldom/simple_html_dom.php';
require_once __DIR__ . '/extensions/FacebookServiceProvider/FacebookServiceProvider.php';

use Knp\Silex\ServiceProvider\DoctrineMongoDBServiceProvider;
use Doctrine\Common\Annotations\AnnotationRegistry;

$app = new Silex\Application();
$app['debug'] = true;

$app['autoloader']->registerNamespace('Document', __DIR__);
$app['autoloader']->registerNamespace('Knp', __DIR__ . '/extensions/DoctrineMongoDB/src');
$app['autoloader']->registerNamespace('TobiassjostenSilexProvider\Facebook', __DIR__ . '/extensions/FacebookServiceProvider');

$app->register(new TobiassjostenSilexProvider\Facebook\FacebookServiceProvider(), array(
    'facebook.class_file' => __DIR__ . '/vendor/facebook-php-sdk/src/facebook.php',
    'facebook.app_id' => getenv('FACEBOOK_APP_ID'),
    'facebook.secret' => getenv('FACEBOOK_SECRET'),
));

$app->register(new DoctrineMongoDBServiceProvider(), array(
    'doctrine.odm.mongodb.proxies_dir' => __DIR__ . '/cache',
    'doctrine.odm.mongodb.hydrators_dir' => __DIR__ . '/cache',
    'doctrine.odm.mongodb.connection_options' => array(
        'database' => 'mxgl',
        'host' => 'localhost',
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

AnnotationRegistry::registerFile(__DIR__ . '/vendor/doctrine-mongodb-odm/lib/Doctrine/ODM/MongoDB/Mapping/Annotations/DoctrineAnnotations.php');