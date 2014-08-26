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

class RegisterConfig extends Core {

    private $config = array();

    public function init(array $config) {
        $this->config = $config;
        $this->initConfig();
        $this->register();
    }

    public function initConfig() {
        if (!isset($this->config['base'])) {
            $this->config['base'] = array();
        }
        Core::app()->global = new Core;
        Core::app()->config = new Core;
        Core::app()->param = new Core;
        Core::app()->hook = new Core;
    }

    public function register() {
        if (is_array($this->config)) {
            foreach ($this->config as $key => $cfg) {
                $method = 'reg'.ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->{$method}($cfg);
                }
            }
            Core::app()->config->__readonlyAttr(true);
        }
    }

    public function regComp($cfg) {
        Core::app()->config->comp = $cfg;
    }

    public function regHook($cfg) {
        Core::app()->config->hook = $cfg;
    }

    public function regBase($cfg) {
        $base = Core::app()->config;
        $base->timezone = isset($cfg['timezone']) && !empty($cfg['timezone']) ? $cfg['timezone'] : 8;
        $base->charset = isset($cfg['charset']) && !empty($cfg['charset']) ? $cfg['charset'] : 'utf-8';
        $base->gzip = isset($cfg['gzip']) && !empty($cfg['gzip'])? $cfg['gzip'] : false;
        $base->mode = isset($cfg['mode']) && !empty($cfg['mode']) ? $cfg['mode'] : 1;
        $base->controller = isset($cfg['controller']) && !empty($cfg['controller']) ? $cfg['controller'] : 'index';
        $base->method = isset($cfg['method']) && !empty($cfg['method']) ? $cfg['method'] : 'index';
        $base->theme = isset($cfg['theme']) ? $cfg['theme'] : 'default';
    }

    public function regParam($cfg) {
    	if ($cfg && is_array($cfg)) {
    	    foreach($cfg as $key => $val) {
    	        Core::app()->param->{$key} = $val;
    	    }
    	}
    }
}
