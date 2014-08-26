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

namespace mushroom\core;

class Component extends Core {

    public function __construct() {
        if (isset(Core::app()->config->comp)) {
            $compCfg = Core::app()->config->comp;
            if (is_array($compCfg)) {
            	foreach($compCfg as $key => $val) {
            		Core::comp()->{$key} = self::register($val['name'], $val['config']);
            	}
            }
        }
        Core::comp()->__strictAttr(true);
    }

    public static function register($name, $config = array()) {
        try {
            $compClass = '\\mushroom\\component\\'. ucfirst($name);
            if (!class_exists($compClass)) {
            	throw new Exception('Component error:\''.$compClass.'\' class does not exist');
            }
            return new $compClass($config);
        } catch( Exception $e ) {
            $e->getExceptionMessage();
        }
    }
}
