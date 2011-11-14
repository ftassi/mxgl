<?php

require_once __DIR__ . '/silex.phar';
require_once __DIR__ . '/vendor/simplehtmldom/simple_html_dom.php';

use Symfony\Component\Yaml\Yaml;

$app = new Silex\Application();
$app['autoloader']->registerNamespace("Symfony\Component\Yaml", __DIR__ . "/vendor");
$app['config'] = Yaml::parse(__DIR__ . "/config/config.yml");

$app['debug'] = $app['config']['app']['debug'];

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $app['config']['db'],
    'db.dbal.class_path' => __DIR__ . '/vendor/doctrine-dbal/lib',
    'db.common.class_path' => __DIR__ . '/vendor/doctrine-common/lib',
));
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/view',
    'twig.class_path' => __DIR__ . '/vendor/twig/lib',
));
