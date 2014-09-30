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
        if (MR_RT_CLI) {
            if (isset(Core::app()->args->develop)) {
                $this->runMrCliProcess();
            } else {
                $this->runCliProcess();
            }
        } else {
            $this->runWebProcess();
        }
    }

    private function runMrCliProcess() {
        if (empty(Core::app()->args->develop)) {
            throw new Exception('--develop option value can not empty');
        }
        $toolClass = '\\mushroom\\tool\\'.ucfirst(Core::app()->args->develop);
        if (!class_exists($toolClass)) {
            throw new Exception('mushroom tools class "'.$toolClass.'" not exists');
        }
        $toolObjs = new $toolClass;
        if (method_exists($toolObjs, 'init')) {
            call_user_func(array($toolObjs, 'init'));
        }
        $this->end();
    }

    private function runCliProcess() {
        try {
            $controller = $this->controller.'Command';
            $appClass = '\\command\\'.$controller;
            if (class_exists($appClass)) {
                $controllerClass = $appClass;
            }else {
                throw new Exception('command "'.$appClass.'" not exists');
            } 
            $modObject = new $controllerClass;
            if (!($modObject instanceof Controller)) {
                throw new Exception('controller "'.$controllerClass.'" not extend base class \mr\Controller');
            }
            $method = $this->method.'Cmd';
            if (!method_exists($modObject, $method)) {
                throw new Exception('command method "'.$controllerClass.'->'.$method.'()" not exists');
            } else {
                call_user_func(array($modObject, $method));
            }
            $this->end();
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }

    private function runWebProcess() {
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
            $modObject->initAttribute();

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
            $this->end();
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }

    private function __clone() {}
}
