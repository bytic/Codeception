<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Helper\Traits;

use Codeception\Exception\ModuleException;
use Codeception\Module;
use Codeception\Module\PhpBrowser;

use const PHP_URL_QUERY;

/**
 * Class UriTrait.
 */
trait BrowserTrait
{
    use AbstractTrait;

    /**
     * @throws ModuleException
     */
    public function loadPage($method, $url, $post)
    {
        $this->getBrowserModule()->_loadPage($method, $url, $post);
    }

    /**
     * @return Module|PhpBrowser
     *
     * @throws ModuleException
     */
    protected function getBrowserModule()
    {
        return $this->getModule('PhpBrowser');
    }

    /**
     * @return mixed
     *
     * @throws ModuleException
     */
    public function getCurrentUriParam($name)
    {
        $uri = $this->getCurrentUri();
        $query = parse_url($uri, PHP_URL_QUERY);
        parse_str($query, $params);

        return $params[$name];
    }

    /**
     * @return mixed
     *
     * @throws ModuleException
     */
    public function getCurrentUri()
    {
        return $this->getBrowserModule()->_getCurrentUri();
    }

    /**
     * @return mixed
     *
     * @throws ModuleException
     */
    public function getCurrentUrl()
    {
        return $this->getBrowserModule()->client->getHistory()->current()->getUri();
    }

    /**
     * @throws ModuleException
     */
    public function seeFullUrlEquals($expected)
    {
        $url = $this->getCurrentUrl();

        $this->assertEquals($expected, $url);
    }
}
