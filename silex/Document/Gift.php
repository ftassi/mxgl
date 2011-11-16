<?php

namespace Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

/**
 * Description of Gift
 *
 * @author ftassi
 * @Document(collection="gifts")
 */
class Gift
{
    /**
     *
     * @Id(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     * @Field(type="string")
     */
    private $title;
    
    /**
     * @var string
     * @Field(type="string")
     */
    private $image;
    
    /**
     * @var string
     * @Field(type="string")
     */
    private $description;
    
    /**
     * @var string
     * @Field(type="string")
     */
    private $note;
    
    /**
     * @var string
     * @Field(type="string")
     */
    private $userId;
    
    /**
     * @var string
     * @Field(type="int")
     */
    private $listId;
    
    /**
     *
     * @return string Url assoluta dell'immagine
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     *
     * @param string $image URL assoluta dell'immagine
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @param string $description 
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     *
     * @param string $note 
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     *
     * @param integer string
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     *
     * @return integer
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     *
     * @param integer $listId 
     */
    public function setListId($listId)
    {
        $this->listId = $listId;
    }

    /**
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     * @param string $title 
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     *
     * @param \simple_html_dom $htmlDom 
     * @todo implementazione
     */
    public function fromHtmlDom(\simple_html_dom $htmlDom)
    {
        
    }
    
}

?>
