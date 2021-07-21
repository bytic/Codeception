<?php

namespace ByTIC\Codeception\Helper\Traits;

use Codeception\Module\PhpBrowser;
use Exception;

/**
 * Class HandlePhpSessionsTrait
 * @package ByTIC\Common\Tests\Helper\Traits
 *
 * @method getBrowserModule()
 */
trait HandlePhpSessionsTrait
{
    use AbstractTrait;

    public function getSessionData(): array
    {
        $cookie = $this->getBrowserModule()->grabCookie('PHPSESSID'); // according to php.ini: session.name
        $sessionFile = file_get_contents(ini_get('session.save_path') . '/sess_' . $cookie);
        return self::unserialize_php($sessionFile);
    }

    /**
     * @param $session_data
     * @return array
     * @throws Exception
     */
    private static function unserialize_php($session_data): array
    {
        $return_data = [];
        $offset = 0;
        while ($offset < strlen($session_data)) {
            if (!strstr(substr($session_data, $offset), "|")) {
                throw new Exception("invalid data, remaining: " . substr($session_data, $offset));
            }
            $pos = strpos($session_data, "|", $offset);
            $num = $pos - $offset;
            $varname = substr($session_data, $offset, $num);
            $offset += $num + 1;
            $data = unserialize(substr($session_data, $offset));
            $return_data[$varname] = $data;
            $offset += strlen(serialize($data));
        }
        return $return_data;
    }
}
