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
    protected $instance = NULL;

    static public function create($config)
    {
        if ($this->instance === NULL) {
            $this->instance = new log\LoggerFile($config);
        
        }
        return $this->instance;
    }

    public function __clone()
    {
        trigger_error('Log class can\'t clone');
    }
}

