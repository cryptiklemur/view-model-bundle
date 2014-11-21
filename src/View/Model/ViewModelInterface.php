<?php

namespace Aequasi\Bundle\ViewModelBundle\View\Model;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use \Symfony\Component\HttpFoundation\Response;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
interface ViewModelInterface
{
    /**
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function setData(array $data);

    /**
     * @param null $key
     *
     * @return mixed
     */
    public function getData($key = null);

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function addData($key, $value);

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function replaceData($key, $value);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function removeData($key);

    /**
     * @param $template
     *
     * @return mixed
     */
    public function setTemplate($template);

    /**
     * @return mixed
     */
    public function getTemplate();

    /**
     * @param null     $template
     * @param Response $response
     *
     * @return mixed
     */
    public function render($template = null, Response $response = null);

    /**
     * @return mixed
     */
    public function getHeaders();

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function buildView(array $data);
}
