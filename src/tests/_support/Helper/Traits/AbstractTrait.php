<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Helper\Traits;

use Codeception\Exception\ModuleException;
use Codeception\Module;

/**
 * Class QueryTrait.
 */
trait AbstractTrait
{
    /**
     * @return Module
     *
     * @throws ModuleException
     */
    abstract protected function getModule(string $name);
}
