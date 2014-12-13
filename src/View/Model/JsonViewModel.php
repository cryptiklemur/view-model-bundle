<?php

/**
 * This file is part of view-model-bundle
 *
 * (c) Aaron Scherer <aequasi@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE
 */

namespace Aequasi\Bundle\ViewModelBundle\View\Model;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class JsonViewModel extends AbstractViewModel
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function buildView(array $data)
    {
        return $data;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return [
            'Content-type' => 'application/json'
        ];
    }
}
