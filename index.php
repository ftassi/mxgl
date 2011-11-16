<?php

require_once __DIR__ . '/silex/bootstrap.php';

$app->post('/', function () use ($app) {
    $user = $app['facebook']->api('/me');
    return $app['twig']->render('index.twig', array(
        'name' => $user['name'],
    ));
});

$app->run();