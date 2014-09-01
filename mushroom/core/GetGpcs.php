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

class GetGpcs extends Core {

    public function __construct() {
        $this->regGet();
        $this->regPost();
        $this->regCliArgs();
        $this->regServer();
    }

    private function regGet() {
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

    private function regPost() {
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

    private function regServer() {
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

    private function regCliArgs() {
        $args = new Core;
        if (MR_RT_CLI) {
            global $argv;
            $len = count($argv);
            for($i = 1; $i < $len; $i+=2) {
                $key = isset($argv[$i]) ? $argv[$i]: '';
                if (
                    empty($key) || 
                    substr($key, 0, 1) != '-' ||
                    (substr($key, 0, 2) == '--' && strlen($key) < 4) ||
                    (substr($key, 0, 1) == '-' && strlen($key) != 2)
                ) {
                    throw new Exception($argv[0].': invalid option: "'.$key.'"');
                }
                $key = trim($key, '-');
                $args->{$key} = isset($argv[$i+1]) ? $argv[$i+1]: '';
            }
        }
        Core::app()->args = $args;
    }
}
