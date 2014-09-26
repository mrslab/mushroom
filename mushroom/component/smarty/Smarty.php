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

namespace mushroom\component\smarty;

class Smarty {

    private $version = '3.1.19';

    private $config = array();

    private $smarty = null;

    public function __construct($config = array()) {
        $this->config = $config;
    }

    public function init() {
        require_once dirname(__FILE__).'/libs/Smarty.class.php';
        $this->smarty = new \Smarty;
        $allowCfg = array(
            'debugging', 'debug_tpl', 'debugging_ctrl', 'global_assign', 'undefined', 'autoload_filters', 'compile_check', 
            'force_compile', 'caching', 'cache_lifetime', 'cache_handler_func', 'cache_modified_check', 'config_overwrite', 
            'config_booleanize', 'config_read_hidden', 'config_fix_newlines', 'default_template_handler_func',
            'php_handling', 'security', 'secure_dir', 'security_settings', 'trusted_dir', 'left_delimiter', 'right_delimiter',
            'compiler_class', 'request_vars_order', 'request_use_auto_globals', 'compile_id', 'use_sub_dirs', 'default_modifiers',
            'default_resource_type'
        );
        foreach($allowCfg as $cfg) {
            if (isset($this->config[$cfg])) {
                $this->smarty->{$cfg} = $this->config[$cfg];
            }
        }
        $this->smarty->template_dir = isset($this->config['template_dir']) ? $this->config['template_dir'] : MR_VIEW_PATH;
        $this->smarty->compile_dir = isset($this->config['compile_dir']) ? $this->config['compile_dir'] : MR_RUNTIME_PATH.'/smarty_tpl/';
        $this->smarty->cache_dir = isset($this->config['cache_dir']) ? $this->config['cache_dir'] : MR_RUNTIME_PATH.'/smarty_cache/';
    }

    public function template($tpl, $vars = array()) {
        if (!is_array($vars)) {
            throw new \Exception("template assign value ". var_export($vars, true) ." must be array");
        }
        foreach($vars as $key => $val) {
            $this->smarty->assign($key, $val);
        }
        $this->smarty->display($tpl);
    }

    public function smarty() {
        return $this->smarty;
    }

    public function version() {
        return $this->version;
    }
}
