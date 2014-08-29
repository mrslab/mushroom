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

namespace mushroom\component;

use \mushroom\core\Core as Core,
    \mushroom\library\Memcached as MrMemcached,
    \mushroom\library\Memcache as MrMemcache;

class Memcache extends Core {

	private $memcache = null;

	public function __construct($config) {
		$this->memcache = extension_loaded('memcached') ? new MrMemcached($config) : new MrMemcache($config);
	}

	public function get($key) {
		return $this->memcache->get($key);
	}

	public function set($key, $value, $expire = 0) {
		return $this->memcache->set($key, $value, $expire);
	}

	public function delete($key) {
		return $this->memcache->delete($key);
	}
	
	public function increment($key, $value = 1) {
		return $this->memcache->increment($key, $value);
	}
	
	public function decrement($key, $value = 1) {
		return $this->memcache->decrement($key, $value);
	}
}
