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

namespace mushroom\component\cache;

use \mushroom\core\Component as Component;

class Memcache implements IFCache {

    var $memcache;

    public function __construct($config) {
        $this->memcache = Component::register('memcache', $config);
    }

    public function get($key) {
        return $this->memcache->get($key);
    }

    public function set($key, $value, $expire = 3600) {
        return $this->memcache->set($key, $value, $expire);
    
    }

    public function delete($key) {
        return $this->memcache->delete($key);
    }
}
