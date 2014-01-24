<?php

namespace Aequasi\Bundle\ViewModelBundle\Annotation\Driver;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Aequasi\Bundle\ViewModelBundle\Annotation\ViewModel;
use Aequasi\Bundle\ViewModelBundle\Service\ViewModelService;
 

class AnnotationDriver
{
    /**
     * @var Reader
     */
    protected $reader;
    
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var ViewModelService
     */
    protected $viewModelService;
 
    public function __construct(Reader $reader, EngineInterface $templating, ViewModelService $viewModelService)
    {
        $this->reader           = $reader;
        $this->templating       = $templating;
        $this->viewModelService = $viewModelService;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
 
        if (!is_array($controller = $event->getController())) {
            return;
        }
 
        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);
 
        foreach ($this->reader->getMethodAnnotations($method) as $configuration) {
            if ($configuration instanceof ViewModel) {
                $class = $configuration->class;
                if (!class_exists($class)) {
                    $bundle = $this->getBundleName($object);
                    $oldClass = $class;
                    $class = sprintf('%s\View\Model\%s', $bundle, $class);
                    if (!class_exists($class)) {
                        throw new \InvalidArgumentException(
                            sprintf(
                                "Neither `%s`, nor `%s` are valid classes. Make sure you use the whole name of the model, or that its placed in your bundle's `View\Model\` directory",
                                $oldClass,
                                $class
                            )
                        );
                    }
                }

                $this->viewModelService->setViewModel(new $class($this->templating));
            }
        }
    }

    private function getBundleName(\ReflectionObject $controller)
    {
        return str_replace('\Controller', '', $controller->getNamespaceName());
    }
}
