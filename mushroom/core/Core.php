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

class Core {

    private static $__core__ = null;

    private static $__comp__ = null;

    private $__attribute__ = array();

    private $__strictAttr__ = false;

    private $__readonlyAttr = false;

    protected $app = null;

    protected $component = null;

    public static function app() {
        if (self::$__core__ === null) {
            self::$__core__ = new self;
        }
        return self::$__core__;
    }
    
    public static function comp() {
        if (self::$__comp__ === null) {
            self::$__comp__ = Common::load('Component');
        }
        return self::$__comp__;
    }

    protected function initAttribute() {
        $this->app = self::app();
        $this->component = self::comp();
    }

    protected function end() {
        Hook::listen('mr_end');
        define('MR_RT_EMEMORY',   memory_get_usage());
        list($microtime, $second) = explode(' ', microtime());
        define('MR_RT_ETIME', $second + $microtime);
        exit;
    }

    public function __get($attr) {
        try {
            if (isset($this->__attribute__[$attr])) {
                return $this->__attribute__[$attr];
            } elseif ($this->__strictAttr__ == true) {
                throw new Exception('attribute \''.get_class($this).'->'.$attr.'\' not exists');
            } else {
                return '';
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function __set($attr, $value) {
        try {
            if ($this->__readonlyAttr == true) {
                throw new Exception('attribute \''.get_class($this).'->'.$attr.'\' can\'t write');
            }
            $this->__attribute__[$attr] = $value;
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function __isset($attr) {
        return isset($this->__attribute__[$attr]);
    }
    
    public function __returnAttributes() {
        return $this->__attribute__;
    }

    public function __strictAttr($status = true) {
        $this->__strictAttr__ = $status;
    }

    public function __readonlyAttr($status = false) {
        $this->__readonlyAttr = $status;
    }
}
