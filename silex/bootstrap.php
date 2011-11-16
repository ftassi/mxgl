<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/silex.phar';
//require_once __DIR__ . '/silex_doctrine_mongodb_extension.phar';
require_once __DIR__ . '/vendor/simplehtmldom/simple_html_dom.php';

use Knp\Silex\ServiceProvider\DoctrineMongoDBServiceProvider;
use Doctrine\Common\Annotations\AnnotationRegistry;

$app = new Silex\Application();
$app['debug'] = true;
$app['autoloader']->registerNamespace('Document', __DIR__);
$app['autoloader']->registerNamespace('Knp', __DIR__ . '/extensions/DoctrineMongoDB/src');

$app->register(new DoctrineMongoDBServiceProvider(), array(
    'doctrine.odm.mongodb.proxies_dir'  => __DIR__ . '/cache',
    'doctrine.odm.mongodb.hydrators_dir'  => __DIR__ . '/cache',
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

AnnotationRegistry::registerFile(__DIR__.'/vendor/doctrine-mongodb-odm/lib/Doctrine/ODM/MongoDB/Mapping/Annotations/DoctrineAnnotations.php');