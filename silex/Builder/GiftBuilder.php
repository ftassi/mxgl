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
        $gift->setImage($this->extractDefaultImage($crawler, $this->getUrlBasePath($url)));
        $gift->setImages($this->extractImages($crawler, $this->getUrlBasePath($url)));

        return $gift;
    }

    /**
     * Parsa $url per ottenere il basePath per le immagini
     * 
     * @param string $url
     * @return string 
     */
    protected function getUrlBasePath($url)
    {
        $urlParts = parse_url($url);
        $basePath = $urlParts['scheme'] . "://" . $urlParts['host'];
        return $basePath;
    }

    /**
     *
     * @param Crawler $crawler
     * @return string
     */
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

    /**
     *
     * @param Crawler $crawler
     * @return string 
     */
    protected function extractDescription(Crawler $crawler)
    {
        $description = $crawler->filter('meta[name="description"]');
        if (count($description) > 0) {
            $description = $description->extract(array('content'));
            return $description[0];
        }

        return '';
    }

    /**
     *
     * @param Crawler $crawler
     * @param string $basePath
     * @return string
     */
    protected function extractDefaultImage(Crawler $crawler, $basePath)
    {
        $image = $crawler->filter('meta[property="og:image"]');
        if (count($image)) {
            $image = static::getAbsolutePath($image->filter(array('content')), $basePath);
            return $image[0];
        }

        $image = $crawler->filter('img');
        if (count($image)) {
            $image = static::getAbsolutePath($image->attr('src'), $basePath);
            return $image;
        }

        return '';
    }

    /**
     *
     * @param Crawler $crawler
     * @param string $basePath
     * @return array 
     */
    protected function extractImages(Crawler $crawler, $basePath)
    {
        $images = array();
        $crawler->filter('img')->each(function($node, $i) use(&$images, $basePath)
            {
                $src = GiftBuilder::getAbsolutePath($node->getAttribute('src'), $basePath);
                $images[] = $src;
            });

        return $images;
    }

    /**
     * Trasforma src immagine da relativo ad assoluto 
     * 
     * @param string $src
     * @param string $basePath
     * @return string 
     */
    public static function getAbsolutePath($src, $basePath)
    {
        if (!parse_url($src)) {
            $src = $basePath . ($src{0} == '/' ? '' : '/') . $src;
        }
        return $src;
    }

}

?>
