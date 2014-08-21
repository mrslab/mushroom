<?php

/**
 * Mushroom
 * 
 * An open source php application framework for PHP 5.3.0 or newer
 *
 * @author    mengfk <Mushroom Dev Team>
 * @copyright Copyright (C) 2014 http://mushroom.dreamans.com All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0.txt
 * @link      http://mushroom.dreamans.com
 */

namespace mushroom\library;

use \mushroom\core\Core as Core,
    \mushroom\core\Exception as Exception;

class Redis extends Core {

    protected $redis;

    protected $config;

    public function __construct($config) {
        try { 
            $this->config = $config;
            if(!extension_loaded('redis')) {
                throw new Exception('redis extension not exists');
            }
            $this->redis = new \Redis();
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }

    private function connect() {
        try {
            if (empty($this->config)) {
                throw new Exception('redis config empty');
            }
            $config = explode(":", $this->config);
            $host = isset($config[0]) ? $config[0]: '';
            $port = isset($config[1]) ? $config[1]: 6379;
            $timeout = isset($config[2]) ? $config[2]: 1;
            $auth = isset($config[3]) ? $config[3]: '';
            $db = isset($config[4]) ? $config[4]: '';
            if (false === $this->redis->connect($host, $port, $timeout)) {
                throw new Exception('redis server connect failed');
            }
            if (!empty($auth)) {
                $this->redis->auth($auth);
            }
            if (isset($db)) {
                $this->redis->select($db);
            }
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }

    public function __call($name,$arguments) {
        try {
            if (method_exists($this->redis, $name)) {
                $this->connect();
                return call_user_func_array(array($this->redis, $name), $arguments);
            } else {
                throw new Exception('Call to undefined method Redis::'.$name.'()');
            }
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }
}
