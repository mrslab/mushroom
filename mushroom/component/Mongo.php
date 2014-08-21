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

class Mongo extends mongo\Connect {
	
    public function __construct($cfg) {
        $server = isset($cfg['server']) ? $cfg['server']: '';
        $opts = array();
        isset($cfg['connect']) && $opts['connect'] = $cfg['connect'];
        isset($cfg['db']) && $opts['db'] = $cfg['db'];
        isset($cfg['password']) && $opts['password'] = $cfg['password'];
        isset($cfg['readPreference']) && $opts['readPreference'] = $cfg['readPreference'];
        isset($cfg['readPreferenceTags']) && $opts['readPreferenceTags'] = $cfg['readPreferenceTags'];
        isset($cfg['replicaSet']) && $opts['replicaSet'] = $cfg['replicaSet'];
        isset($cfg['connectTimeoutMS']) && $opts['connectTimeoutMS'] = $cfg['connectTimeoutMS'];
        isset($cfg['socketTimeoutMS']) && $opts['socketTimeoutMS'] = $cfg['socketTimeoutMS'];
        isset($cfg['username']) && $opts['username'] = $cfg['username'];
        isset($cfg['w']) && $opts['w'] = $cfg['w'];
        isset($cfg['wTimeout']) && $opts['wTimeout'] = $cfg['wTimeout'];
        
        parent::__construct($server, $opts);
	}
	
}
