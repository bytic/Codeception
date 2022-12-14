<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Page;

use Codeception\Actor;

use function strlen;

/**
 * Class AbstractPage.
 */
abstract class AbstractPage
{
    use AbstractTraits\CanNavigateTrait;

    /**
     * @var Actor;
     */
    protected Actor $acceptanceTester;

    public function __construct(Actor $I)
    {
        $this->acceptanceTester = $I;

        $this->init();
    }

    protected function init()
    {
    }

    /**
     * @return Actor;
     */
    protected function getTester(): Actor
    {
        return $this->acceptanceTester;
    }

    public function haveErrorMessage()
    {
        $this->getTester()->see('', 'div.alert-danger');
    }

    public function loadPage()
    {
        $this->getTester()->amOnPage(self::getUrl());
    }

    /**
     * @return $this
     */
    public function checkOnURL()
    {
        $tester = $this->getTester();

        $pageURI = self::getUrl();
        $browserURI = $tester->getCurrentUri();
        $tester->comment(' compare page [' . $pageURI . '][' . $browserURI . ']');

        if (strlen($pageURI) == strlen($browserURI)) {
            $tester->seeCurrentUrlEquals($pageURI);
        } else {
            $tester->seeCurrentUrlMatches('~' . preg_quote($pageURI) . '~');
        }

        return $this;
    }

    public function checkElements()
    {
    }

    public function loadAndTestPage()
    {
        $this->loadPage();
        $this->checkPage();
    }

    /**
     * @deprecated Use loadAndTestPage instead
     */
    public function testPage()
    {
        $this->loadAndTestPage();
    }

    public function checkPage()
    {
        $this->checkOnURL();
        $this->checkElements();
    }
}
