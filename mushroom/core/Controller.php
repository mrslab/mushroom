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

class Controller extends Core {

    private $render = null;

    public function __construct() {
        $this->render = new View;
    }

    public function render($tpl) {
        $this->render->display($tpl);
    }

    public function output($tpl) {
        return $this->render->display($tpl, true);
    }

    public function assign($key, $value) {
        $this->render->assign($key, $value);
    }
}
