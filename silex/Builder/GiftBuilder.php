<?php

namespace Builder;

use Document\Gift;
use Goutte\Client;

/**
 *
 * @author ftassi
 */
class GiftBuilder
{

    /**
     *
     * @var Client
     */
    protected $client;

    /**
     *
     * @param Crawler $client 
     */
    function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     *
     * @param string $url
     * @return Gift 
     */
    public function fromUrl($url)
    {
        $gift = new Gift();
        $gift->setTitle('Playstation 3');
        $gift->setUrl('http://us.playstation.com/ps3/');
        $gift->setImage('http://i.telegraph.co.uk/multimedia/archive/01551/ps3_1551882c.jpg');
        $gift->setDescription('Are you ready to play? We thought so. The PS3™ system has you covered. If you want the best games from the best franchises in high definition and stereoscopic 3D, you’ve come to the right place. But play doesn’t stop there. The PS3™ system is the only console with a built in Blu-ray™ player. Watch or stream thousands of movies in high definition directly to your system. And/but who wants to play alone? The PlayStation®Network has all the content and community support to ensure you always have someone to play with. Welcome to the PlayStation Nation. Long Live Play.™');
        $gift->setNote('LA VOGLIO!!!');
        return $gift;
    }

}

?>
