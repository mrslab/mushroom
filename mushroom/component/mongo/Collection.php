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

class Collection {

    private $collection = null;

    public function __construct(\MongoCollection $collection) {
        $this->collection = $collection;
    }

    public function count($query = array(), $limit = 0, $skip = 0) {
        return $this->collection->count($query, $limit, $skip);
    }

    public function createIndex($keys, $opts = array()) {
        return $this->collection->createIndex($keys, $opts);
    }

    public function deleteIndex($keys) {
        return $this->collection->deleteIndex($keys);
    }

    public function deleteIndexes() {
        return $this->collection->deleteIndexes();
    }

    public function distinct($key, $query = array()) {
        return $this->collection->distinct($key, $query);
    }

    public function find($query = array(), $fields = array()) {
        return Cursor($this->collection->find($query, $fields));
    }

    public function findAndModify($query, $update = array(), $fields = array(), $options = array()) {
        return $this->collection->findAndModify($query, $update, $fields, $options);
    }

    public function findOne($query = array(), $fields = array(), $options = array() ) {
        return $this->collection->findOne($query, $fields, $options);
    }

    public function getIndexInfo() {
        return $this->collection->getIndexInfo();
    }

    public function getName() {
        return $this->collection->getName();
    }

    public function setSlaveOkay($status = true) {
        return $this->collection->setSlaveOkay($status);
    }

    public function getSlaveOkay() {
        return $this->collection->getSlaveOkay();
    }

    public function drop() {
        return $this->collection->drop();
    }

    public function getReadPreference() {
        return $this->collection->getReadPreference();
    }

    public function getWriteConcern() {
        return $this->collection->getWriteConcern();
    }

    public function group($keys, $initial, $reduce) {
        return $this->collection->group($keys, $initial, $reduce);
    }
    
    public function insert($a, $opts = array()) {
        return $this->collection->insert($a, $opts);
    }

    public function parallelCollectionScan($num) {
        return $this->collection->parallelCollectionScan($num);
    }

    public function remove($criteria = array(), $opts = array()) {
        return $this->collection->remove($criteria, $opts);
    }
}
