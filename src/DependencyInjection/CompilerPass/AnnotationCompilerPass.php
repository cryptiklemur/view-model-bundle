<?php

/**
 * This file is part of app.lfgame.rs
 *
 * (c) Aaron Scherer <aequasi@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE
 */

namespace Aequasi\Bundle\ViewModelBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class AnnotationCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $serviceIds = array_keys($container->findTaggedServiceIds('aequasi.view_model'));
        $services   = [];
        foreach ($serviceIds as $service) {
            $services[$service] = new Reference($service);
        }

        $factoryIds = array_keys($container->findTaggedServiceIds('aequasi.view_model_factory'));
        $factories   = [];
        foreach ($factoryIds as $service) {
            $factories[$service] = new Reference($service);
        }

        $def = new Definition('Aequasi\Bundle\ViewModelBundle\Annotation\Driver\AnnotationDriver');
        $def
            ->addArgument(new Reference('annotation_reader'))
            ->addArgument(new Reference('templating'))
            ->addArgument(new Reference('aequasi.view_model.service.view'))
            ->addArgument($services)
            ->addArgument($factories)
            ->addTag('kernel.event_listener', ['event' => 'kernel.controller', 'method' => 'onKernelController'])
        ;

        $container->setDefinition('aequasi.view_model.annotation.driver', $def);
    }
}
 