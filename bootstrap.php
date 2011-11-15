<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/silex.phar';
require_once __DIR__ . '/vendor/simplehtmldom/simple_html_dom.php';


$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'dbname' => 'mxgl',
        'user' => 'root',
        'password' => 'root',
        'host' => 'localhost',
        
    ),
    'db.dbal.class_path' => __DIR__ . '/vendor/doctrine-dbal/lib',
    'db.common.class_path' => __DIR__ . '/vendor/doctrine-common/lib',
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/view',
    'twig.class_path' => __DIR__ . '/vendor/twig/lib',
));

echo $_ENV['dbname'];