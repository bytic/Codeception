<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Page\AbstractTraits;

use ByTIC\Codeception\Support\Page\Components\Table;
use Codeception\Actor;

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
     * @param string $tablePath
     * @param string $linkPath
     * @param null $name
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
     * @param $name
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
    public function getTableLinks($reset = false, $name = null)
    {
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

    public function clickTableFirstLink($name = null)
    {
        $links = $this->getTableOrFail($name)->getItemsPath();
        $link = reset($links);
        $this->getTester()->amOnUrl($link);
    }

    /**
     * @param $name
     * @return Table|void
     */
    public function getTableOrFail($name = null)
    {
        $table = $this->getTable($name);
        if ($table) {
            return $table;
        }
        $this->getTester()->fail('table ' . $name . ' not defined for [' . get_class($this) . ']');
    }

    /**
     * @param $name
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
