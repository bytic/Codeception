<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Helper;

/**
 * Class AcceptanceTrait.
 */
trait AcceptanceTrait
{
    use Traits\QueryTrait;
    use Traits\FixturesTrait;
    use Traits\BrowserTrait;
}
