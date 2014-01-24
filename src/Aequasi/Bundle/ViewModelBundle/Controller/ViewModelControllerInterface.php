<?php

namespace Aequasi\Bundle\ViewModelBundle\Controller;

use Aequasi\Bundle\ViewModelBundle\Service\ViewModelService;

interface ViewModelControllerInterface
{
    /**
     * @param ViewModelService $service
     *
     * @return ViewModelControllerInterface
     */
    public function setView(ViewModelService $service);

    /**
     * @return ViewModelService
     */
    public function getView();
}
