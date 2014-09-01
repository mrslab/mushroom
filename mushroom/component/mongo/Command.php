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

class Command {

    private $db = null;

    public function __construct(\MongoDB $db) {
        $this->db = $db;
    }

    public function command($command, $opts = array()) {
        return $this->db->command($command, $opts);
    }

    public function execute($code, $opts = array()) {
        return $this->db->execute($code, $opts);
    }

    public function getCollectionNames($system = false) {
        return $this->db->getCollectionNames($system);
    }

    public function listCollections($system = false) {
        $colls = $this->db->listCollections($system);
        $ncolls = array();
        foreach($colls as $col) {
            $ncolls[] = new Collection($col);
        }
        return $ncolls;
    }

    public function selectCollection($name) {
        return new Collection($this->db->selectCollection($name));
    }

    public function createCollection($name) {
        return new Collection( new \MongoCollection($this->db, $name));
    }

    public function lastError() {
        return $this->db->lastError();
    }

    public function drop() {
        return $this->db->drop();
    }
}
