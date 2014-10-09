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

namespace mushroom\component\util;

class Util {

    private static $allowAttributes = array(
        'file', 'http', 'string', 'upload', 'verify'    
    );

    private static $utils = array();

    public function __get($key) {
        if (!in_array(strtolower($key), self::$allowAttributes)) {
            throw new \Exception("{$key} class not exists in util component");
        }
        if (!isset(self::$utils[$key])) {
            $class = '\\mushroom\\component\\util\\'.ucfirst($key);
            self::$utils[$key] = new $class;
        }
        return self::$utils[$key];
    }
}
