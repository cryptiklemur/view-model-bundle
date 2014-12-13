<?php

/**
 * This file is part of view-model-bundle
 *
 * (c) Aaron Scherer <aequasi@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE
 */

namespace Aequasi\Bundle\ViewModelBundle\Annotation;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 *
 * @Annotation
 */
class ViewModelFactory
{
    /**
     * @type
     */
    private $factory;

    /**
     * @type array
     */
    private $arguments = [];

    /**
     * @param array $data
     *
     * @throws \Exception
     */
    public function __construct(array $data)
    {
        if (count(array_keys($data)) > 1) {
            throw new \Exception(
                "Your ViewModel declaration should not have named variables. ".
                "Just pass your factory service, and arguments."
            );
        }

        if (!isset($data['value'])) {
            throw new \Exception("You must specify a service id to use with the factory");
        }

        $this->parseValue($data['value']);
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return string
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param array $value
     *
     * @return void
     *
     * @throws \Exception
     */
    private function parseValue($value)
    {
        if (!is_array($value)) {
            throw new \Exception(
                "Value for ViewModelFactory should be the service id, and arguments. ".
                "ex: @ViewModelFactory(\"@serviceId\", {\"argumentOne\", \"@service\"})"
            );
        }

        if (strpos($value[0], '@') !== 0) {
            throw new \Exception("{$value[0]} is not a valid service id. It must start with a @.");
        }

        $this->factory = ltrim($value[0], '@');
        $this->arguments = $value[1];
    }
}
