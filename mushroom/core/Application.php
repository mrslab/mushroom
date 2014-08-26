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

class Application extends Core {

    private $controller = '';

    private $method = '';
    
    public static function run($router) {
        return new self($router);
    }

    private function __construct($router) {
        $this->initRouter($router);
        $this->runProcess();
    }

    private function initRouter($router) {
        $this->controller = $router->mod;
        $this->method = $router->act;
    }

    private function runProcess() {
        try {
            $controller = $this->controller.'Controller';
            $appClass = '\\controller\\'.$controller;
            if (class_exists($appClass)) {
                $controllerClass = $appClass;
            }else {
                throw new Exception('controller "'.$appClass.'" not exists');
            } 
            Hook::listen('mr_before_controller');
            $modObject = new $controllerClass;
            if (!($modObject instanceof Controller)) {
                throw new Exception('controller "'.$controllerClass.'" not extend base class \mr\Controller');
            }
            if (method_exists($modObject, 'init')) {
                call_user_func(array($modObject, 'init'));
            }
            $method = $this->method.'Method';
            if (!method_exists($modObject, $method)) {
                if (method_exists($modObject, 'empty')) {
                    call_user_func(array($modObject, 'empty'));
                } else {
                    throw new Exception('controller method "'.$controllerClass.'->'.$method.'()" not exists');
                }
            } else {
                call_user_func(array($modObject, $method));
            }
            Hook::listen('mr_after_controller');
            Core::app()->end();
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }

    private function __clone() {}
}
