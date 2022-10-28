<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Support\Page\Components;

use Codeception\Actor;

/**
 *
 */
class Table
{
    public const DEFAULT_NAME = '__main';

    protected Actor $tester;
    protected $name;

    protected $path;
    protected $itemsPath;

    protected $links = null;

    protected $minItems = 1;

    /**
     * @param $name
     * @param $path
     * @param $itemsPath
     */
    public function __construct(Actor $tester, string $path, string $itemsPath, $name = null)
    {
        $this->tester = $tester;
        $this->path = $path;
        $this->itemsPath = $itemsPath;
        $this->name = $name ?? static::DEFAULT_NAME;
    }

    public function check()
    {
        $this->checkExists();
        $this->checkItems();
    }

    public function checkExists()
    {
        $this->tester->seeElement(['css' => $this->getPath()]);
    }

    public function checkItems()
    {
        $links = $this->getLinks();
        $this->tester->assertGreaterThanOrEqual(
            $this->minItems,
            count($links),
            'Check at least ' . $this->minItems . ' table item defined'
        );
    }

    /**
     * @param bool $reset
     * @return array
     */
    public function getLinks(?bool $reset = false)
    {
        if ($reset || $this->links == null) {
            $this->links = $this->tester->grabMultiple($this->getFullPath(), 'href');
        }
        return $this->links;
    }

    public function getFullPath(): string
    {
        return $this->getPath() . ' ' . $this->getItemsPath();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getItemsPath()
    {
        return $this->itemsPath;
    }
}
