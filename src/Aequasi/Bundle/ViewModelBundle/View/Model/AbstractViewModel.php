<?php

namespace Aequasi\Bundle\ViewModelBundle\View\Model;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
        if (array_key_exists($key, $this->data)) {
            throw new \InvalidArgumentException(
                "The key `$key` is already present in the model. Either remove the key, or replace it"
            );
        }

        return $this->replaceData($key, $value);
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

    public function render($template = null, Response $response = null)
    {
        $parameters = $this->buildView($this->data);

        if ($response === null) {
            $response = new Response();
        }
        $response->headers = new ResponseHeaderBag($this->getHeaders());

        return $this->templating->renderResponse($template === null ? $this->template : $template, $parameters, $response);
    }

    abstract public function getHeaders();

    abstract public function buildView(array $data);
}
