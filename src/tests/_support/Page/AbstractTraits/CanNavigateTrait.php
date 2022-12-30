<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Page\AbstractTraits;

trait CanNavigateTrait
{
    public static ?string $url = null;

    // incl_Abstractude url of current page
    public static ?string $basePath = null;

    /**
     * @param string|null $url
     */
    public static function setUrl(?string $url): void
    {
        self::$url = $url;
    }

    /**
     * @param string|null $basePath
     */
    public static function setBasePath(?string $basePath): void
    {
        self::$basePath = $basePath;
    }

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');.
     *
     * @return string
     */
    public static function route($param)
    {
        return static::$url . $param;
    }

    public static function getUrl(): string
    {
        return static::$basePath . static::$url;
    }

    public function addURLQueryParams($name, $value)
    {
        $urlParts = parse_url(static::$url);
        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $params);
        } else {
            $params = [];
        }
        $params[$name] = $value;
        static::$url = $urlParts['path'] . '?' . http_build_query($params);
    }
}
