DoctrineMongoDBExtension
========================

``` bash

    wget --no-check-certificate https://github.com/bobthecow/SilexExtensions/raw/master/silex_doctrine_mongodb_extension.phar

```

usage: 

``` php

    <?php

    require_once __DIR__.'/silex.phar';
    require_once __DIR__.'/silex_doctrine_mongodb_extension.phar';

    use Silex\Extension\DoctrineMongoDBExtension;
    use Doctrine\Common\Annotations\AnnotationRegistry;

    $app = new Silex\Application;
    
    $app['autoloader']->registerNamespace('Document', __DIR__);
    
    $app->register(new DoctrineMongoDBExtension, array(
        'doctrine.odm.mongodb.connection_options' => array(
            'database' => 'bananas',
            'host'     => 'localhost',
        ),
        'doctrine.odm.mongodb.documents' => array(
             array('type' => 'annotation', 'path' => __DIR__.'/Document', 'namespace' => 'Document'),
        ),
        'doctrine.common.class_path'      => __DIR__.'/vendor/doctrine-common/lib',
        'doctrine.mongodb.class_path'     => __DIR__.'/vendor/doctrine-mongodb/lib',
        'doctrine.odm.mongodb.class_path' => __DIR__.'/vendor/doctrine-mongodb-odm/lib',
    ));
    
AnnotationRegistry::registerFile(__DIR__.'/../vendor/doctrine-mongodb-odm/lib/Doctrine/ODM/MongoDB/Mapping/Annotations/DoctrineAnnotations.php');


```
