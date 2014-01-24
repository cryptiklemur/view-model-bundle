<?php

namespace Aequasi\Bundle\ViewModelBundle\Service;

use Aequasi\Bundle\ViewModelBundle\View\Model\ViewModel;
use Aequasi\Bundle\ViewModelBundle\View\Model\ViewModelInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;


class ViewModelService
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var ViewModelInterface
     */
    private $viewModel;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
        $this->viewModel = new ViewModel($templating);
    }

    public function getViewModel()
    {
        return $this->viewModel;
    }

    public function setViewModel(ViewModelInterface $viewModel)
    {
        $data = $this->get();
        
        $this->viewModel = $viewModel;
        if (!empty($data)) {
            $this->set($data);
        }

        return $this;
    }

    public function set(array $data)
    {
        return $this->viewModel->setData($data);
    }

    public function get($key = null)
    {
        return $this->viewModel->getData($key);
    }

    public function setTemplate($template)
    {
        return $this->viewModel->setTemplate($template);
    }

    public function getTemplate()
    {
        return $this->viewModel->getTemplate();
    }
    
    public function add($key, $value)
    {
        return $this->viewModel->addData($key, $value);
    }

    public function replace($key, $value)
    {
        return $this->viewModel->replaceData($key, $value);
    }

    public function render($template = null, Response $response = null)
    {
        return $this->viewModel->render($template, $response);
    }
}
