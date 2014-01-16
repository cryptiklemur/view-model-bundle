<?php

namespace Aequasi\Bundle\ViewModelBundle\View\Model;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use \Symfony\Component\HttpFoundation\Response;

abstract class AbstractViewModel implements ViewModelInterface
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var array
     */
    protected $data = array();


    /**
     * @var string
     */
    protected $template;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function getData($key = null)
    {
        return $key === null ? $this->data : $this->data[$key];
    }

    public function addData($key, $value)
    {
        if (array_key_exists($this->data, $key)) {
            throw new \InvalidArgumentException(
                "The key `$key` is already present in the model. Either remove the key, or replace it"
            );
        }

        return $this->setData($key, $value);
    }

    public function replaceData($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function removeData($key)
    {
        unset($this->data[$key]);

        return $this;
    }

    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function render($template, Response $response = null)
    {
        $parameters = $this->buildView();

        return $this->templating->renderResponse($template, $parameters, $response);
    }

    abstract protected function buildView();
}
