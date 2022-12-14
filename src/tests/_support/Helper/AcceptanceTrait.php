<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Helper;

/**
 * Class AcceptanceTrait.
 */
trait AcceptanceTrait
{
    use Traits\BrowserTrait;
    use Traits\FixturesTrait;
    use Traits\QueryTrait;
}
