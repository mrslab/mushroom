<?php
/**
 * Mushroom
 * 
 * An open source php application framework for PHP 5.3.0 or newer
 *
 * @author    lidong <Mushroom Dev Team>
 * @copyright Copyright (C) 2014 http://mushroom.dreamans.com All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0.txt
 * @link      http://mushroom.dreamans.com
 */

namespace mushroom\component\log;

use \mushroom\library\Redis;

class LoggerRedis extends LoggerAbstract
{
    protected $config;

    protected $stronge = NULL;

    public function __construct($config)
    {
        $this->config = $config;
    
    }

    protected function write($type, $message, array $context = array())
    {
        $data = "{$type} :  {$message}";

        if ($this->stronge === NULL) {
            $this->stronge = new Redis($this->config['connect']);
        }

        return $this->stronge->lpush($this->config['key'], $data);
    }
}

