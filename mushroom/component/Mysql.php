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

namespace mushroom\component;

use \mushroom\core\Core as Core;

class Mysql extends mysql\Connect {
	
    public function __construct($cfg) {
        $config = array(
            'dsn' => isset($cfg['dsn']) ? $cfg['dsn']: '',
            'user' => isset($cfg['user']) ? $cfg['user']: '',
            'pass' => isset($cfg['pass']) ? $cfg['pass']: '',
            'timeout' => isset($cfg['timeout']) ? $cfg['timeout']: '',
            'tablepre' => isset($cfg['tablepre']) ? $cfg['tablepre']: '',
        );
		parent::__construct($config['dsn'], $config['user'], $config['pass'], $config['timeout'], $config['tablepre']);
	}
	
}
