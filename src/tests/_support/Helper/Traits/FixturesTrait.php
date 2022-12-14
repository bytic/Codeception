<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Helper\Traits;

use Codeception\Util\Fixtures;
use RuntimeException;

use function is_array;

/**
 * Class QueryTrait.
 */
trait FixturesTrait
{
    use AbstractTrait;

    public function pushFixture($name, $value)
    {
        if ($this->hasFixture($name)) {
            $array = $this->getFixture($name);
            $array = is_array($array) ? $array : [$array];
        } else {
            $array = [];
        }
        $array[] = $value;
        $this->addFixture($name, $array);
    }

    /**
     * @return bool
     */
    public function hasFixture($name)
    {
        try {
            Fixtures::get($name);
        } catch (RuntimeException $exception) {
            return false;
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getFixture($name)
    {
        return Fixtures::get($name);
    }

    public function addFixture($name, $value)
    {
        Fixtures::add($name, $value);
    }
}
