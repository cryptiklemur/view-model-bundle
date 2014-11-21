<?php

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
