<?php

namespace ByTIC\Codeception\Helper\Traits;

/**
 * Class QueryTrait
 * @package ByTIC\Common\Tests\Helper\Traits
 */
trait AbstractTrait
{

    /**
     * @param string $name
     *
     * @return \Codeception\Module
     * @throws \Codeception\Exception\ModuleException
     */
    abstract protected function getModule($name);
}