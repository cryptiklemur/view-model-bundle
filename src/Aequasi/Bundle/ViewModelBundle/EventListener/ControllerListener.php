<?php

namespace Aequasi\Bundle\ViewModelBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
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

    /**
     * @var bool
     */
    protected $isInstanceOfViewModelControllerInterface = false;

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
            $this->isInstanceOfViewModelControllerInterface = true;
        }
    }

    public function postController( GetResponseForControllerResultEvent $event )
    {
        if (!$this->isInstanceOfViewModelControllerInterface) {
            return;
        }

        if (is_array($event->getControllerResult())) {
            $this->viewModelService->set($event->getControllerResult());
        }

        if (!$event->hasResponse()) {
            $event->setResponse($this->viewModelService->render());
        }
	}
}
