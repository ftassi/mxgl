<?php

require_once __DIR__ . '/silex/bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->match('/', function () use ($app)
        {
            if ($app['facebook']->getUser() > 0) {
                return $app->redirect('/add-gift');
            }

            return $app['twig']->render('welcome.twig', array(
                    'facebook' => $app['facebook'],
                ));
        })
    ->method('GET|POST');

$app->match('/add-gift', function(Request $request) use($app)
        {
            $userGiftsList = $app['doctrine.odm.mongodb.dm']
                ->getRepository('Document\Gift')
                ->findBy(array('userId' => $app['facebook']->getUser()));

            return $app['twig']->render('my_gift_list.twig', array(
                    'facebook' => $app['facebook'],
                    'gifts_list' => $userGiftsList,
                ));
        })
    ->method('GET|POST');


$app->run();