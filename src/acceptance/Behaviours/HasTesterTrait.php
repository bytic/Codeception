<?php

namespace ByTIC\Codeception\Acceptance\Behaviours;

use Codeception\Actor;

/**
 * Trait HasTesterTrait.
 */
trait HasTesterTrait
{
    protected Actor $tester;

    protected function getTester(): Actor
    {
        return $this->tester;
    }

    protected function setTester(Actor $tester): void
    {
        $this->tester = $tester;
    }
}
