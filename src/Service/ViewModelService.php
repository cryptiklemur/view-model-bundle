<?php

namespace Aequasi\Bundle\ViewModelBundle\Service;

use Aequasi\Bundle\ViewModelBundle\View\Model\ViewModel;
use Aequasi\Bundle\ViewModelBundle\View\Model\ViewModelInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class ViewModelService
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var ViewModelInterface|null
     */
    private $viewModel;

    /**
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
        $this->viewModel = new ViewModel($templating);
    }

    /**
     * @return ViewModel|ViewModelInterface|null
     */
    public function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @param ViewModelInterface $viewModel
     *
     * @return $this
     */
    public function setViewModel(ViewModelInterface $viewModel)
    {
        $data = $this->get();
        
        $this->viewModel = $viewModel;
        if (!empty($data)) {
            $this->set($data);
        }

        return $this;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function set(array $data)
    {
        return $this->viewModel->setData($data);
    }

    /**
     * @param null $key
     *
     * @return array
     */
    public function get($key = null)
    {
        return $this->viewModel->getData($key);
    }

    /**
     * @param $template
     *
     * @return $this
     */
    public function setTemplate($template)
    {
        return $this->viewModel->setTemplate($template);
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->viewModel->getTemplate();
    }

    /**
     * @param $key
     * @param $value
     *
     * @return \Aequasi\Bundle\ViewModelBundle\View\Model\AbstractViewModel
     */
    public function add($key, $value)
    {
        return $this->viewModel->addData($key, $value);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function replace($key, $value)
    {
        return $this->viewModel->replaceData($key, $value);
    }

    /**
     * @param null     $template
     * @param Response $response
     *
     * @return mixed
     */
    public function render($template = null, Response $response = null)
    {
        return $this->viewModel->render($template, $response);
    }
}
