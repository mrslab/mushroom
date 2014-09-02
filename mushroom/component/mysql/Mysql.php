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

namespace mushroom\component\mysql;

class Mysql extends Connect {
	
    public function __construct($cfg) {
        $dsn = 'mysql:';
        $dsn .= isset($cfg['hostname']) ? 'host='.$cfg['hostname'] : '';
        $dsn .= isset($cfg['dbname']) ? ';dbname='.$cfg['dbname'] : '';
        $dsn .= isset($cfg['charset']) ? ';charset='.$cfg['charset'] : '';
        $config = array(
            'dsn' => $dsn,
            'user' => isset($cfg['username']) ? $cfg['username']: '',
            'pass' => isset($cfg['password']) ? $cfg['password']: '',
            'timeout' => isset($cfg['timeout']) ? $cfg['timeout']: '',
            'tablepre' => isset($cfg['tablepre']) ? $cfg['tablepre']: '',
        );
		parent::__construct($config['dsn'], $config['user'], $config['pass'], $config['timeout'], $config['tablepre']);
	}
	
}
