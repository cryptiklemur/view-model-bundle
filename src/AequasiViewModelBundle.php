<?php

/**
 * This file is part of view-model-bundle
 *
 * (c) Aaron Scherer <aequasi@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE
 */

namespace Aequasi\Bundle\ViewModelBundle;

use Aequasi\Bundle\ViewModelBundle\DependencyInjection\CompilerPass\AnnotationCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class AequasiViewModelBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AnnotationCompilerPass());
    }
}
