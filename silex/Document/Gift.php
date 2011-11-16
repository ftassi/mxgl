<?php

namespace Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

/**
 * Description of Gift
 *
 * @author ftassi
 * @Document(db="mxgl", collection="gifts")
 */
class Gift
{
    /**
     *
     * @Id(strategy="AUTO")
     */
    private $id;
    
    /**
     *
     * @var string
     * @Field(type="string")
     */
    private $title;
    
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }


    
}

?>
