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

namespace mushroom\component; 

use \mushroom\core\Core as Core;

class Log extends Core 
{
    private $log = null;

    private $config = array();

    private function getLogObject()
    {
        switch($this->config['driver']) {
            case 'file':
                $this->log = new log\LoggerFile($this->config);
                break;
            case 'redis':
                $this->log = new log\LoggerRedis($this->config);
                break;
        }
        
    }

    public function __construct($config)
    {
        $this->config = $config;
        $this->getLogObject();
    }

    public function emergency($message)
    {
        $this->log->emergency($message);
    
    }

    public function alert($message)
    {
        $this->log->alert($message);

    }

    public function notice($message)
    {
        $this->log->notice($message);
    
    }

    public function error($message)
    {
        $this->log->error($message);
    
    }

    public function warning($message) 
    {
        $this->log->warning($message);
    
    }

    public function info($message)
    {
        $this->log->info($message);
    
    }

}

