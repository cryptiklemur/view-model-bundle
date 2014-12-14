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

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
abstract class AbstractViewModel implements ViewModelInterface
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @type RequestStack
     */
    protected $requestStack;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $template;

    /**
     * @param RequestStack    $requestStack
     * @param EngineInterface $templating
     */
    public function __construct(RequestStack $requestStack, EngineInterface $templating)
    {
        $this->setRequestStack($requestStack);
        $this->setTemplating($templating);
    }

    /**
     * @return RequestStack
     */
    public function getRequestStack()
    {
        return $this->requestStack;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return AbstractViewModel
     */
    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

        return $this;
    }

    /**
     * @return EngineInterface
     */
    public function getTemplating()
    {
        return $this->templating;
    }

    /**
     * @param EngineInterface $templating
     *
     * @return AbstractViewModel
     */
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;

        return $this;
    }

    /**
     * @param null $key
     *
     * @return array
     */
    public function getData($key = null)
    {
        return $key === null ? $this->data : $this->data[$key];
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return AbstractViewModel
     */
    public function addData($key, $value)
    {
        if (array_key_exists($key, $this->data)) {
            throw new \InvalidArgumentException(
                "The key `$key` is already present in the model. Either remove the key, or replace it"
            );
        }

        return $this->replaceData($key, $value);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function replaceData($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @param $key
     *
     * @return $this
     */
    public function removeData($key)
    {
        unset($this->data[$key]);

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param $template
     *
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @param null     $template
     * @param Response $response
     *
     * @return mixed
     */
    public function render($template = null, Response $response = null)
    {
        $parameters        = $this->buildView($this->data);
        $response          = $response === null ? new Response() : $response;
        $response->headers = new ResponseHeaderBag($this->getHeaders());
        $template          = $template === null ? $this->getTemplate() : $template;

        return $this->templating->renderResponse($template, $parameters, $response);
    }

    /**
     * @return mixed
     */
    abstract public function getHeaders();

    /**
     * @param array $data
     *
     * @return mixed
     */
    abstract public function buildView(array $data);
}
