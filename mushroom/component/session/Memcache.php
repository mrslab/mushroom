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

namespace mushroom\component\session;

use \mushroom\core\Component as Component;

class Memcache {

    var $memcache;

    var $config;

    var $pre = '#mr#sess#';

    public function __construct($config) {
        $this->config = $config;
    }

    public function open($path, $name) {
        $this->memcache = Component::register('Memcache', $this->config);
    }

    public function read($sid) {
        $key = $this->pre.md5($sid);
        return $this->memcache->get($key);
    }

    public function write($sid, $value) {
        $key = $this->pre.md5($sid);
        $expire = ini_get('session.gc_maxlifetime');
        $expire = $expire ? $expire : 1440;
        return $this->memcache->set($key, $value, $expire);
    }

    public function destroy($sid) {
        $key = $this->pre.md5($sid);
        return $this->memcache->delete($key);
    }

    public function gc($life) {
        return true;
    }

    public function close() {
        $this->memcache = null;
    }
}
