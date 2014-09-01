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

class MemcachedDriver {

    protected $memcached;

    protected $config;

    public function __construct($config) {
        try { 
            $this->config = $config;
            if(!extension_loaded('memcached')) {
                throw new Exception('memcached extension not exists');
            }
            $this->memcached = new \Memcached();
            $this->connect();
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }

    private function connect() {
        try {
            if (empty($this->config)) {
                throw new Exception('memcached config empty');
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
        if(false === $this->memcached->addServer($host, $port, $weight)) {
            throw new Exception('Memcached server add failed');
        }
    }

    public function __call($name,$arguments) {
        try {
            if (method_exists($this->memcached, $name)) {
                return call_user_func_array(array($this->memcached, $name), $arguments);
            } else {
                throw new Exception('Call to undefined method Memcached::'.$name.'()');
            }
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }
}
