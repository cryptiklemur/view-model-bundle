<?php

/**
 * This file is part of view-model-bundle
 *
 * (c) Aaron Scherer <aequasi@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE
 */

namespace Aequasi\Bundle\ViewModelBundle\Annotation\Driver;

use Aequasi\Bundle\ViewModelBundle\Annotation\ViewModel;
use Aequasi\Bundle\ViewModelBundle\Annotation\ViewModelFactory;
use Aequasi\Bundle\ViewModelBundle\Factory\ViewModelFactoryInterface;
use Aequasi\Bundle\ViewModelBundle\Service\ViewModelService;
use Aequasi\Bundle\ViewModelBundle\View\Model\ViewModelInterface;
use Doctrine\Common\Annotations\Reader;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class AnnotationDriver
{

    /**
     * @var ContainerInterface
     */
    protected $container;

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

    /**
     * @type array
     */
    private $services;

    /**
     * @type array
     */
    private $factories;

    /**
     * @param Reader           $reader
     * @param EngineInterface  $templating
     * @param ViewModelService $viewModelService
     * @param array            $services
     * @param array            $factories
     */
    public function __construct(
        Reader $reader,
        EngineInterface $templating,
        ViewModelService $viewModelService,
        array $services,
        array $factories
    ) {
        $this->reader           = $reader;
        $this->templating       = $templating;
        $this->viewModelService = $viewModelService;
        $this->services         = $services;
        $this->factories        = $factories;
    }

    /**
     * @param FilterControllerEvent $event
     *
     * @throws \Exception
     */
    public function onKernelController(FilterControllerEvent $event)
    {

        if (!is_array($controller = $event->getController())) {
            return;
        }

        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);

        foreach ($this->reader->getMethodAnnotations($method) as $configuration) {
            if ($configuration instanceof ViewModel) {
                if ($configuration->hasClass()) {
                    $class     = $configuration->getClass();
                    $viewModel = new $class($this->templating);
                } elseif ($configuration->hasService()) {
                    $viewModel = $this->getService($configuration->getService());
                } else {
                    throw new \Exception("Invalid View Model configuration.");
                }

                if (!$viewModel instanceof ViewModelInterface) {
                    throw new \Exception(
                        "View model passed does not implement ".
                        "Aequasi\\Bundle\\ViewModelBundle\\View\\Model\\ViewModelInterface"
                    );
                }

                $this->viewModelService->setViewModel($viewModel);
            }
            if ($configuration instanceof ViewModelFactory) {
                $factory = $this->getFactory($configuration->getFactory());

                if (!$factory instanceof ViewModelFactoryInterface) {
                    throw new \Exception(
                        "View model passed does not implement ".
                        "Aequasi\\Bundle\\ViewModelBundle\\View\\Model\\ViewModelInterface"
                    );
                }

                $viewModel = $factory->create($configuration->getArguments());
                if (!$viewModel instanceof ViewModelInterface) {
                    throw new \Exception(
                        "View model passed does not implement ".
                        "Aequasi\\Bundle\\ViewModelBundle\\View\\Model\\ViewModelInterface"
                    );
                }

                $this->viewModelService->setViewModel($viewModel);
            }
        }
    }

    /**
     * @param string $id
     *
     * @throws \Exception
     *
     * @return ViewModelInterface
     */
    private function getService($id)
    {
        if (!array_key_exists($id, $this->services)) {
            throw new \Exception("$id is not a valid View Model. Make sure it is tagged with aequasi.view_model.");
        }

        return $this->services[$id];
    }

    /**
     * @param string $id
     *
     * @throws \Exception
     *
     * @return ViewModelInterface
     */
    private function getFactory($id)
    {
        if (!array_key_exists($id, $this->factories)) {
            throw new \Exception(
                "$id is not a valid View Model Factory. Make sure it is tagged with aequasi.view_model_factory."
            );
        }

        return $this->factories[$id];
    }
}
