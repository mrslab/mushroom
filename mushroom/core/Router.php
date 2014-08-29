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

class Router extends Core {

    var $mod = '';

    var $act = '';

    public function __construct() {
        $this->getRouter();
    }

    public function getRouter() {
        try {
            switch ($this->getMode()) {
                case MR_MODE_QUERY:
                    $this->getQueryString();
                    break;
                case MR_MODE_SEGMENT:
                    $this->getQuerySegment();
                    break;
                case MR_MODE_CLI:
                    $this->getCliArgs();
                    break;
                default:
                    throw new Exception('URL route mode error');
            }
        } catch ( Exception $e) {
            $e->getExceptionMessage();
        }
        $this->verifyModeByDef();
    }

    public function verifyModeByDef() {
        if (empty($this->mod)) {
            $this->mod = Core::app()->config->controller;
        }
        if (empty($this->act)) {
            $this->act = Core::app()->config->method;
        }
        Core::app()->global->mod = $this->mod;
        Core::app()->global->act = $this->act;
        $this->getQueryStringController($this->mod);
    }

    public function getMode() {
        return MR_RT_CLI ? MR_MODE_CLI: Core::app()->config->mode;
    }

    public function getQueryString() {
        $this->mod = Core::app()->get->m;
        $this->act = Core::app()->get->a;
    }

    public function getQuerySegment() {
        $pathInfo = Core::app()->server->path_info;
        $path = explode('/', trim($pathInfo, '/'));
        $path = array_filter($path);
        $this->mod = !empty($path) ? array_shift($path) : '';
        $this->act = !empty($path) ? array_shift($path) : '';
        $paramKey = 1;
        Core::app()->get->__readonlyAttr(false);
        foreach ($path as $val) {
            $key = "param".$paramKey;
            Core::app()->get->{$key} = $val;
            $paramKey++;
        }
        Core::app()->get->__readonlyAttr(true);
    }

    private function getCliArgs() {
        $this->mod = Core::app()->args->m;
        $this->act = Core::app()->args->a;
    }

    private function getQueryStringController($mod) {
        $mod = explode('/', $mod);
        array_filter($mod);
        $last = !empty($mod) ? array_pop($mod): '';
        array_push($mod, ucfirst($last));
        $this->mod = implode('\\', $mod);
    }
}
