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

class Cache {
	
	private $cache = null;
	
	private $config = array();
	
	private function getCacheObject() {
		switch($this->config['driver']) {
			case 'File':
				$this->cache = new File($this->config);
				break;
			case 'Mysql':
				$this->cache = new Mysql($this->config);
				break;
			case 'Redis':
				$this->cache = new Redis($this->config);
				break;
			case 'Memcache':
				$this->cache = new Memcache($this->config);
				break;
		}
	}

	public function __construct($config) {
		$this->config = $config;
		$this->getCacheObject();
	}
	
	public function set($key, $value, $expire = 3600) {
		$this->cache->set($key, $value, $expire);
	}

	public function get($key) {
		$this->cache->get($key);
	}
	
	public function delete($key) {
		$this->cache->delete($key);
	}
}
