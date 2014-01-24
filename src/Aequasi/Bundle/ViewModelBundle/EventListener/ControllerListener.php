<?php

namespace Aequasi\Bundle\ViewModelBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Aequasi\Bundle\ViewModelBundle\Service\ViewModelService;
use Aequasi\Bundle\ViewModelBundle\Controller\ViewModelControllerInterface;

/**
 * ControllerListener Class
 */
class ControllerListener
{

    /**
     * @var ViewModelService
     */
    protected $viewModelService;

    public function __construct(ViewModelService $viewModelService)
    {
        $this->viewModelService = $viewModelService;
    }

    /**
     * Checks to see if the controller is an InitializableControllerInterface.
     * If it is, it initializes it with some of the services
     *
     * @param FilterControllerEvent $event
     *
     * @return $mixed
     */
    public function preController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        // Return if its not an array
        if (!is_array($controller)) {
            return;
        }

        $controllerObject = $controller[0];

        // Make sure it can initialize
        if ($controllerObject instanceof ViewModelControllerInterface) {
            $controllerObject->setView($this->viewModelService);
        }
    }
}
