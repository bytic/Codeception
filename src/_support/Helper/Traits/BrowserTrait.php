<?php

namespace ByTIC\Codeception\Helper\Traits;

use Codeception\Module\PhpBrowser;

/**
 * Class UriTrait
 * @package ByTIC\Common\Tests\Helper\Traits
 */
trait BrowserTrait
{
    use AbstractTrait;

    /**
     * @param $method
     * @param $url
     * @param $post
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function loadPage($method, $url, $post)
    {
        return $this->getBrowserModule()->_loadPage($method, $url, $post);
    }

    /**
     * @return \Codeception\Module|PhpBrowser
     * @throws \Codeception\Exception\ModuleException
     */
    protected function getBrowserModule()
    {
        return $this->getModule('PhpBrowser');
    }


    /**
     * @param $name
     *
     * @return mixed
     * @throws \Codeception\Exception\ModuleException
     */
    public function getCurrentUriParam($name)
    {
        $uri   = $this->getCurrentUri();
        $query = parse_url($uri, PHP_URL_QUERY);
        parse_str($query, $params);

        return $params[$name];
    }

    /**
     * @return mixed
     * @throws \Codeception\Exception\ModuleException
     */
    public function getCurrentUri()
    {
        return $this->getBrowserModule()->_getCurrentUri();
    }


    /**
     * @return mixed
     * @throws \Codeception\Exception\ModuleException
     */
    public function getCurrentUrl()
    {
        return $this->getBrowserModule()->client->getHistory()->current()->getUri();
    }


    /**
     * @param $expected
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function seeFullUrlEquals($expected)
    {
        $url = $this->getCurrentUrl();

        $this->assertEquals($expected, $url);
    }
}
