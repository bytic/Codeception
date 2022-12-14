<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Page\AbstractTraits;

use ByTIC\Codeception\Support\Page\Components\Table;
use Codeception\Actor;

use function is_bool;

/**
 * Class TableTrait.
 */
trait TableTrait
{
    /**
     * @var Table[]
     */
    protected $tables = [];

    protected $tableLinks = [];

//    protected $tablePath = [];
//
//    protected $linkPath = [];

    /**
     * @param null $name
     *
     * @return Table
     */
    protected function addTable(string $tablePath, string $linkPath, $name = null)
    {
        $name = $this->tableName($name);
        $table = new Table($this->getTester(), $tablePath, $linkPath, $name);
        $this->tables[$name] = $table;

        return $table;
    }

    /**
     * @return void
     */
    public function checkTable($name = null)
    {
        $this->getTableOrFail($name)->check();
    }

    /**
     * @return null
     */
    public function getTablePath($name = null)
    {
        return $this->getTableOrFail($name)->getPath();
    }

    /**
     * @return null
     */
    public function getTableLinks($name = null, $reset = null)
    {
        if (is_bool($name) && null == $reset) {
            return $this->getTableOrFail(null)->getLinks($name);
        }

        return $this->getTableOrFail($name)->getLinks($reset);
    }

    /**
     * @return string
     */
    public function getFullLinkPath($name = null)
    {
        return $this->getTableOrFail($name)->getFullPath();
    }

    /**
     * @return null
     */
    public function getLinkPath($name = null)
    {
        return $this->getTableOrFail($name)->getItemsPath();
    }

    /**
     * @return void
     */
    public function clickTableFirstLink($name = null)
    {
        $links = $this->getTableOrFail($name)->getLinks();
        $link = reset($links);
        $this->getTester()->amOnUrl($link);
    }

    /**
     * @return Table|void
     */
    public function getTableOrFail($name = null)
    {
        $table = $this->getTable($name);
        if ($table) {
            return $table;
        }
        $this->getTester()->fail('table ' . $name . ' not defined for [' . static::class . ']');
    }

    /**
     * @return Table|null
     */
    public function getTable($name = null)
    {
        $name = $this->tableName($name);

        return $this->tables[$name] ?? null;
    }

    protected function tableName(string $name = null): string
    {
        return $name ?? Table::DEFAULT_NAME;
    }

    abstract protected function getTester(): Actor;
}
