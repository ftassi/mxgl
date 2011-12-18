<?php

namespace Builder;

use Document\Gift;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

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
        $crawler = $this->client->request('GET', $url);

        $gift = new Gift();
        $gift->setTitle($this->extractTitle($crawler));
        $gift->setDescription($this->extractDescription($crawler));
        $gift->setUrl($url);

        $gift->setImage($this->extractImage($crawler));
        return $gift;
    }

    protected function extractTitle(Crawler $crawler)
    {
        $title = $crawler->filter('meta[property="og:title"]');
        if (count($title)) {
            $title = $title->extract(array('content'));
            return $title[0];
        }

        $title = $crawler->filter('h1');
        if (count($title)) {
            return $title->text();
        }

        return '';
    }

    protected function extractDescription(Crawler $crawler)
    {
        $description = $crawler->filter('meta[name="description"]');
        if (count($description) > 0) {
            $description = $description->extract(array('content'));
            return $description[0];
        }

        return '';
    }
    
    protected function extractImage(Crawler $crawler)
    {
        $image = $crawler->filter('meta[property="og:image"]');
        if (count($image))
        {
            $image = $image->filter(array('content'));
            return $image[0];
        }
        
        $image = $crawler->filter('img');
        if(count($image))
        {
            return $image->attr('src');
        }
        
        return '';
    }

}

?>
