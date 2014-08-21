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

class GetGpcs extends Core {

    public function __construct() {
        $this->regGet();
        $this->regPost();
        $this->regCookie();
        $this->regServer();
    }

    public function regGet() {
        $get = new Core;
        if (isset($_GET)) {
            foreach ($_GET as $key => $val) {
                $get->{$key} = $val;
            }
        }
        unset($_GET);
        $get->__readonlyAttr(true);
        Core::app()->get = $get;
    }

    public static function regPost() {
        $post = new Core;
        if (isset($_POST)) {
            foreach ($_POST as $key => $val) {
                $post->{$key} = $val;
            }
        }
        unset($_POST);
        $post->__readonlyAttr(true);
        Core::app()->post = $post;
    }

    public static function regCookie() {
        $cookie = new Core;
        if (isset($_COOKIE)) {
            foreach ($_COOKIE as $key => $val) {
                $cookie->{$key} = $val;
            }
        }
        unset($_COOKIE);
        Core::app()->cookie = $cookie;
    }

    public static function regServer() {
        $server = new Core;
        if (isset($_SERVER)) {
            foreach ($_SERVER as $key => $val) {
                $key = strtolower($key);
                $server->{$key} = $val;
            }
        }
        unset($_SERVER);
        $server->__readonlyAttr(true);
        Core::app()->server = $server;
    }
}
