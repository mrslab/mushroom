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

namespace mushroom\component\mongo;

use \mushroom\core\Core as Core,
    \mushroom\core\Exception as Exception;

class Connect extends Core {

    private $mongo = null;

    private $server = '';

    private $opts = array();

    //$server mongodb://[username:password@]host1[:port1][,host2[:port2:],...]/db
    public function __construct($server, $opts = array()) {
        $this->server = $server;
        $this->opts = $opts;
    }

    public function connect() {
        if ($this->mongo == null) {
            try {
        	    if (!extension_loaded('mongo')) {
                    throw new Exception('MongoDB error: mongo extension not exists');
                }
                try {
                    if (!empty($this->opts)) {
                        $this->mongo = new \MongoClient($this->server, $this->opts);
                    } else {
                        $this->mongo = new \MongoClient($this->server);
                    }
                } catch(\MongoConnectionException $e) {
                    throw new Exception( $e->getMessage() );
                }
            } catch ( Exception $e ) {
                $e->getExceptionMessage();
            }
        }
        return $this;
    }

    public function selectDb($db) {
        return new Command($this->mongo->selectDB($db));
    }

    public function selectCollection($db, $collection) {
        return new Collection($this->mongo->selectCollection($db, $collection));
    }
}
