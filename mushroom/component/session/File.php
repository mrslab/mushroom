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

namespace mushroom\component\session;

use \mushroom\core\Core as Core;

class File {

    private $path;

    private $file = null;

    public function __construct($config) {
        $this->path = isset($config['path']) ? $config['path']: MR_RUNTIME_PATH .'/session';
        $this->file = Core::comp()->util->file;
        $this->init();
    }

    public function init() {
        $this->file->mkdir($this->path);
        session_save_path($this->path);
    }
}
