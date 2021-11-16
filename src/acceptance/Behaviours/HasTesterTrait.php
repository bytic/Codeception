<?php

namespace ByTIC\Codeception\Acceptance\Behaviours;

use Codeception\Actor;

/**
 * Trait HasTesterTrait
 * @package ByTIC\Codeception\Acceptance\Behaviours
 */
trait HasTesterTrait
{
    /**
     * @var Actor
     */
    protected Actor $tester;

    /**
     * @return Actor
     */
    protected function getTester(): Actor
    {
        return $this->tester;
    }

    /**
     * @param Actor $tester
     */
    protected function setTester(Actor $tester): void
    {
        $this->tester = $tester;
    }
}