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

    private $comps = array();

    public function __get($comp) {
        try {
            if (isset($this->comps[$comp])) {
                return $this->comps[$comp];
            }
            if (!isset(Core::app()->config->comp[$comp])) {
                throw new Exception('component config \''.$comp.'\' not exists');
            }
            $config = Core::app()->config->comp[$comp];
            if (!isset($config['name']) || !isset($config['config'])) {
                throw new Exception('component config \''.$comp.'\' error');
            }
            $this->comps[$comp] = self::register($config['name'], $config['config']);
            return $this->comps[$comp];
        } catch ( Exception $e ) {
            $e->getMessage();
        }
    }

    public static function register($name, $config = array()) {
        try {
            $compClass = '\\mushroom\\component\\'.$name.'\\'. ucfirst($name);
            if (!class_exists($compClass)) {
            	throw new Exception('Component error:\''.$compClass.'\' class does not exist');
            }
            return new $compClass($config);
        } catch( Exception $e ) {
            $e->getExceptionMessage();
        }
    }
}
