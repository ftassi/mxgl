<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/silex.phar';
require_once __DIR__ . '/extension/MongoExtension/MongoExtension.php';
require_once __DIR__ . '/vendor/simplehtmldom/simple_html_dom.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new MongoExtension(), array(
    'mongo.options' => array(
        'dbname' => 'madieru',
        'server' => 'localhost',
    ),
    'mongo.common.class_path' => __DIR__ . '/vendor/doctrineCommon/lib',
    'mongo.mongodb.class_path' => __DIR__ . '/vendor/doctrineMongoDB/lib',
    'mongo.mongodbodm.class_path' => __DIR__ . '/vendor/doctrineMongoDBODM/lib',
    'mongo.common.proxy_dir' => __DIR__ . '/cache',
    'mongo.common.hydrator_dir' => __DIR__ . '/cache',
    'mongo.common.documents_dir' => __DIR__ . '/lib',
));


// if you want to autoload your documents, use the autoloader service:
$app['autoloader']->registerNamespace('Document', __DIR__);

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/view',
    'twig.class_path' => __DIR__ . '/vendor/twig/lib',
));