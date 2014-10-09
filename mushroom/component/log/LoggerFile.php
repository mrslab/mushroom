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

use 
    \mushroom\core\Component as Component,
    \mushroom\core\Core as Core;

class LoggerFile extends LoggerAbstract
{
    private $config;

    private $file = null;

    public function __construct($config)
    {
        $this->config = $config;
        $this->file = Core::comp()->util->file;
    }

    protected function write($type, $message, array $context = array())
    {
        $data = "{$type} :  {$message}";
        return $this->file->write($this->config['path'], $data, true);
    }
}

