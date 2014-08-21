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

namespace mushroom\core;

/**
 * hook point
 * output
 */

class Hook extends Core {

    static $eventLists = array();

    public function __construct() {
        if (is_array(Core::app()->config->hook)) {
            foreach(Core::app()->config->hook as $hook) {
                self::register($hook[0], $hook[1]);
            }
        }
    }

    public static function register($tag, $event) {
        if (!isset(self::$eventLists[$tag])) {
            self::$eventLists[$tag] = array();
        }
        self::$eventLists[$tag][] = $event;
    }

    public static function listen($tag = '', $param = '') {
        if (isset(self::$eventLists[$tag]) && is_array(self::$eventLists[$tag])) {
            foreach(self::$eventLists[$tag] as $event) {
                try {
                    if (!isset($event[1])) continue;
                    
                    if (!method_exists($event[0], $event[1])) {
                        throw new Exception('Hook Event "'.$event[0].'::'.$event[1].'" in tag "'.$tag.'" not exists');
                    }
                    $eventParam = isset($event[2]) && is_array($event[2]) ? $event[2] : array();
                    array_unshift($eventParam, $param);
                    $param = call_user_func_array(array($event[0], $event[1]), $eventParam);
                } catch ( Exception $e) {
                    $e->getExceptionMessage();
                }
            }
        }
        return $param;
    }
}
