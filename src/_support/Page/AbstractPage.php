<?php

namespace ByTIC\Codeception\Page;

/**
 * Class AbstractPage
 * @package ByTIC\Codeception\Page
 */
abstract class AbstractPage
{
    public static $URL = null;

    // incl_Abstractude url of current page
    public static $basePath = '';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     *
     * @param $param
     * @return string
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    /**
     * @var \KM42\Register\Tests\AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;

        $this->init();
    }

    protected function init()
    {
    }

    /**
     * @return \KM42\Register\Tests\AcceptanceTester;
     */
    protected function getTester()
    {
        return $this->acceptanceTester;
    }

    public function haveErrorMessage()
    {
        $this->getTester()->see('', 'div.alert-danger');
    }

    public static function getURL()
    {
        return static::$basePath.static::$URL;
    }


    public function loadPage()
    {
        $this->getTester()->amOnPage(self::getURL());
    }

    /**
     * @return $this
     */
    public function checkOnURL()
    {
        $I = $this->getTester();

        $pageURI = self::getURL();
        $browserURI = $I->getCurrentUri();
        $I->comment(" compare page [".$pageURI."][".$browserURI."]");
        if (strlen($pageURI) == strlen($browserURI)) {
            $I->seeCurrentUrlEquals($pageURI);
        } else {
            $I->seeCurrentUrlMatches('~'.preg_quote($pageURI).'~');
        }

        return $this;
    }

    public function checkElements()
    {
    }

    public function testPage()
    {
        $this->loadPage();
        $this->checkPage();
    }

    public function checkPage()
    {
        $this->checkOnURL();
        $this->checkElements();
    }

    /**
     * @param $name
     * @param $value
     */
    public function addURLQueryParams($name, $value)
    {
        $urlParts = parse_url(static::$URL);
        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $params);
        } else {
            $params = [];
        }
        $params[$name] = $value;
        static::$URL = $urlParts['path'].'?'.http_build_query($params);
    }
}
