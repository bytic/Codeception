<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Helper\Traits;

use Codeception\Exception\ModuleException;
use Codeception\Module\Db;
use PDO;

/**
 * Class QueryTrait.
 */
trait QueryTrait
{
    use AbstractTrait;

    /**
     * @param $query
     *
     * @return mixed
     *
     * @throws ModuleException
     */
    public function fetchOneFromQuery($query)
    {
        $result = $this->runSqlQuery($query);

        return $result->fetch();
    }

    /**
     * @param $query
     *
     * @return mixed
     *
     * @throws ModuleException
     */
    public function runSqlQuery($query)
    {
        /** @var Db $dbModule */
        $dbModule = $this->getModule('Db');
        /** @var PDO $dbh */
        $dbh = $dbModule->dbh;

        return $dbh->query($query);
    }
}
