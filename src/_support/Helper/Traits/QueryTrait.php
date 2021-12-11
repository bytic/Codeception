<?php

namespace ByTIC\Codeception\Helper\Traits;

use Codeception\Module\Db;

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
     * @throws \Codeception\Exception\ModuleException
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
     * @throws \Codeception\Exception\ModuleException
     */
    public function runSqlQuery($query)
    {
        /** @var Db $dbModule */
        $dbModule = $this->getModule('Db');
        /** @var \PDO $dbh */
        $dbh = $dbModule->dbh;

        return $dbh->query($query);
    }
}
