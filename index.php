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
            $messages = array();
            $messages['form_result'] = null;
            
            if ('POST' === $request->getMethod()) {
                
                $formData = $request->get('gift');
                $giftUrl = filter_var($formData['url'], FILTER_VALIDATE_URL);
                if ($giftUrl)
                {
                    $giftDocument = $app['gift'];
                    $giftDocument->fromHtmlDom(file_get_html($giftUrl));
                    $giftDocument->setUserId($app['facebook']->getUser());
                    $app['doctrine.odm.mongodb.dm']->persist($giftDocument);
                    $app['doctrine.odm.mongodb.dm']->flush();
                    
                    $messages['form_result'] = 'Il tuo desiderio è stato aggiunto';
                }
            }
            
            $userGiftsList = $app['doctrine.odm.mongodb.dm']
                ->getRepository('Document\Gift')
                ->findBy(array('userId' => $app['facebook']->getUser()));

            return $app['twig']->render('my_gift_list.twig', array(
                    'facebook' => $app['facebook'],
                    'gifts_list' => $userGiftsList,
                    'messages'  =>  $messages
                ));
        })
    ->method('GET|POST');


$app->run();