<?php

namespace Aequasi\Bundle\ViewModelBundle\Annotation\Driver;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use SomeNamespace\SomeBundle\Annotations;
use SomeNamespace\SomeBundle\Security\Permission;
 

class AnnotationDriver
{
    /**
     * @var Reader
     */
    private $reader;
 
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
 
        if (!is_array($controller = $event->getController())) {
            return;
        }
 
        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);
 
        foreach ($this->reader->getMethodAnnotations($method) as $configuration) {
            var_dump($configuration);
        }
    }
}
