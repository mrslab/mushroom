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

class Output extends Core {

    public function __construct() {
        self::initOutput();
    }

    public static function initOutput() {
        if(Core::app()->config->gzip && function_exists('ob_gzhandler') && strpos(Core::app()->server->http_accept_encodings, 'gzip') !== false) {
            Core::app()->global->gzip = true;
        }
        if(Core::app()->global->gzip == true) {
            ob_start('ob_gzhandler');
        } else {
            ob_start();
        }
        Core::app()->global->gzipOpened = true;
        ob_implicit_flush(0);
        header('Cache-control: private');
        header('X-Powered-By: Mushroom');
        header('Server: Mushroom');
        header('Content-Type: text/html; charset='. Core::app()->config->charset);
    }

    public static function echoOut() {
        $content = ob_get_contents();
        ob_end_clean();
        Core::app()->global->gzip ? ob_start('ob_gzhandler') : ob_start();
        $content = Hook::listen('mr_output', $content);
        return $content;
    }
}
