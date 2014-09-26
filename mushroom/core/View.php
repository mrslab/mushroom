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

class View extends Core {

    private $vars = array();

    public function assign($key, $value) {
        $this->vars[$key] = $value;
    }

    public function display($tpl, $return = false) {
        Hook::listen('mr_view', $tpl);
        Core::app()->template->template($tpl, $this->vars);
        $content = Common::load('Output')->echoOut();
        if ($return === true) {
            return $content;
        }
        echo $content;
    }
}
