<?php

/**
 * This file is part of app.lfgame.rs
 *
 * (c) Aaron Scherer <aequasi@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE
 */

namespace Aequasi\Bundle\ViewModelBundle\Factory;

use Aequasi\Bundle\ViewModelBundle\View\Model\ViewModelInterface;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
interface ViewModelFactoryInterface
{
    /**
     * @param array $arguments
     *
     * @return ViewModelInterface
     */
    public function create(array $arguments);
}
 