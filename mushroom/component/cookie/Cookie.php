<?php
/**
 * Mushroom
 * 
 * An open source php application framework for PHP 5.3.0 or newer
 *
 * @author    mengfk <Mushroom Dev Team>
 * @copyright Copyright (C) 2014 <MrsLab Team> All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0.txt
 * @link      https://github.com/mrslab/mushroom
 */

namespace mushroom\component\cookie;

use \mushroom\core\Core as Core;

class Cookie {

    var $path;

    var $domain;

    var $secure;

    var $httponly;

    public function __construct($config) {
        $this->path = isset($config['path']) ? $config['path']: '/';
        $this->domain = isset($config['domain']) ? $config['domain']: '';
        $this->secure = isset($config['secure']) ? $config['secure']: false;
        $this->httponly = isset($config['httponly']) ? $config['httponly']: false;
    }

    public function set($key, $val, $expire = 0) {
        $expire = $expire ? MR_RT_TIMESTAMP + $expire : $expire;
        return setcookie($key, $val, $expire , $this->path, $this->domain, $this->secure, $this->httponly);
    }

    public function get($key) {
        return Core::app()->cookie->{$key};
    }

    public function delete($key) {
        return $this->set($key, null, 0);
    }
}
