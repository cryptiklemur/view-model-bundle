<?php

namespace Aequasi\Bundle\ViewModelBundle\View\Model;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use \Symfony\Component\HttpFoundation\Response;

interface ViewModelInterface
{
    public function __construct(EngineInterface $templating);

    public function setData(array $data);

    public function getData($key = null);

    public function addData($key, $value);
    
    public function replaceData($key, $value);

    public function removeData($key);

    public function setTemplate($template);

    public function getTemplate();

    public function render($template = '', Response $response = null);

    protected function buildView();
}
