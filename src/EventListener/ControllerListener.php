<?php

namespace Aequasi\Bundle\ViewModelBundle\EventListener;

use Aequasi\Bundle\ViewModelBundle\Controller\ViewModelControllerInterface;
use Aequasi\Bundle\ViewModelBundle\Service\ViewModelService;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

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
     * @param ViewModelService $viewModelService
     */
    public function __construct(ViewModelService $viewModelService)
    {
        $this->viewModelService = $viewModelService;
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     */
    public function postController(GetResponseForControllerResultEvent $event)
    {
        if (!$this->viewModelService->getViewModel() === null) {
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
