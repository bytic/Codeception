<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Helper\Traits;

use Codeception\Util\Fixtures;
use RuntimeException;

/**
 * Class QueryTrait.
 */
trait FixturesTrait
{
    use AbstractTrait;

    /**
     * @param $name
     * @param $value
     */
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
     * @param $name
     *
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
     * @param $name
     *
     * @return mixed
     */
    public function getFixture($name)
    {
        return Fixtures::get($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function addFixture($name, $value)
    {
        Fixtures::add($name, $value);
    }
}
