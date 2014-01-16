<?php

namespace Aequasi\Bundle\ViewModelBundle\View\Model;

class ViewModel extends AbstractViewModel 
{
    protected function buildView()
    {
        return $this->data;
    }
}
