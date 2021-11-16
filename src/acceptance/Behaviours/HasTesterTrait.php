<?php

namespace ByTIC\Codeception\Acceptance;

use Codeception\Actor;

/**
 * Trait HasTesterTrait
 * @package ByTIC\Codeception\Acceptance
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
    public function getTester(): Actor
    {
        return $this->tester;
    }

    /**
     * @param Actor $tester
     */
    public function setTester(Actor $tester): void
    {
        $this->tester = $tester;
    }
}