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

namespace mushroom\component\memcache;

use \mushroom\core\Exception as Exception;

class MemcacheDriver {

    protected $memcache;

    protected $config;

    public function __construct($config) {
        try { 
            $this->config = $config;
            if(!extension_loaded('memcache')) {
                throw new Exception('memcache extension not exists');
            }
            $this->memcache = new \Memcache();
            $this->connect();
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }

    private function connect() {
        try {
            if (empty($this->config)) {
                throw new Exception('memcache config empty');
            }
            if (is_array($this->config)) {
                foreach($this->config as $config) {
                    $this->addServer($config);
                }
            } else {
                $this->addServer($this->config);
            }
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }

    private function addServer($cfg) {
        $config = explode(':', $cfg);
        $host = isset($config[0]) ? $config[0]: '';
        $port = isset($config[1]) ? $config[1]: 11211;
        $weight = isset($config[2]) ? $config[2] : 1;
        if(false === $this->memcache->addServer($host, $port, true, $weight, 1)) {
            throw new Exception('Memcached server add failed');
        }
    }

    public function add($key, $value, $expire = 0, $flag = false) {
        return $this->memcache->add($key, $value, $flag, $expire);
    }

    public function get($key) {
        return $this->memcache->get($key);
    }

    public function set($key, $value, $expire = 0, $flag = false) {
        return $this->memcache->set($key, $value, $flag, $expire);
    }

    public function replace($key, $value, $expire = 0, $flag = false) {
        return $this->memcache->replace($key, $value, $flag, $expire);
    }

    public function delete($key, $expire = 0) {
        return $this->memcache->delete($key, $expire);
    }

    public function increment($key, $value = 1) {
        return $this->memcache->increment($key, $value);
    }

    public function decrement($key, $value = 1) {
        return $this->memcache->decrement($key, $value);
    }
}
