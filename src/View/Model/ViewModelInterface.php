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
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
interface ViewModelInterface
{
    /**
     * @return EngineInterface
     */
    public function getTemplating();

    /**
     * @param EngineInterface $engineInterface
     *
     * @return ViewModelInterface
     */
    public function setTemplating(EngineInterface $engineInterface);

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
