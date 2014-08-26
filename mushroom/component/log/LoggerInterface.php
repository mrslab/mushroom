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

interface LoggerInterface
{
    public function emergency($message, array $context = array());

    public function alert($message, array $context = array());

    public function notice($message, array $context = array());

    public function error($message, array $context = array());

    public function warning($message, array $context = array());

    public function info($message, array $context = array());

    public function log($level, $message, array $context = array());

}

