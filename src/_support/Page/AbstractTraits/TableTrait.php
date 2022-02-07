<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Page\AbstractTraits;

use Codeception\Actor;

/**
 * Class TableTrait.
 */
trait TableTrait
{
    protected $tableLinks = null;

    protected $tablePath = null;

    protected $linkPath = null;

    /**
     * @param $tablePath
     * @param $linkPath
     * @return void
     */
    protected function addTable($tablePath, $linkPath)
    {
        $this->tablePath = $tablePath;
        $this->linkPath = $linkPath;
    }

    public function checkTable()
    {
        $this->getTester()->seeElement(['css' => $this->getTablePath()]);

        $links = $this->getTableLinks();
        $this->getTester()->assertGreaterThanOrEqual(1, count($links), 'Check at least 1 table item defined');
    }

    abstract protected function getTester(): Actor;

    /**
     * @return null
     */
    public function getTablePath()
    {
        if (!$this->tablePath) {
            $this->getTester()->fail('table path must be set for ['.get_class($this).']');
        }

        return $this->tablePath;
    }

    /**
     * @return null
     */
    public function getTableLinks($reset = false)
    {
        if ($reset || null === $this->tableLinks) {
            $this->initTableLinks();
        }

        return $this->tableLinks;
    }

    public function initTableLinks()
    {
        $this->tableLinks = $this->getTester()->grabMultiple($this->getFullLinkPath(), 'href');
    }

    /**
     * @return string
     */
    public function getFullLinkPath()
    {
        return $this->getTablePath().' '.$this->getLinkPath();
    }

    /**
     * @return null
     */
    public function getLinkPath()
    {
        if (!$this->linkPath) {
            $this->getTester()->fail('links path must be set for ['.get_class($this).']');
        }

        return $this->linkPath;
    }

    public function clickTableFirstLink()
    {
        $links = $this->getTableLinks();
        $link = reset($links);
        $this->getTester()->amOnUrl($link);
    }
}
