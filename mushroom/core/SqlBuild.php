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

class SqlBuild extends Core {

    private $table = '';

    private $condition = '1';

    private $fields = '';

    private $order = '';

    private $limit = '';

    private $group = '';

    private $replace = false;

    private $binds = array();

    private $data = array();

    public static function build() {
        return new self;
    }

    public function buildUpdateSql() {
        $sql  = "UPDATE";
        $sql .= $this->getTable();
        $sql .= " SET";
        $dots = '';
        foreach ($this->data as $key => $val) {
            $sql .= $dots." `{$key}` = :_data_{$key}";
            $dots = ',';
        }
        $sql .= $this->getCondition();
        return $sql;
    }

    public function buildDeleteSql() {
        $sql  = "DELETE FROM";
        $sql .= $this->getTable();
        $sql .= $this->getCondition();
        return $sql;
    }

    public function buildInsertSql() {
        $sql  = $this->replace ? 'REPLACE INTO': 'INSERT INTO';
        $sql .= $this->getTable();
        $fields = $values = array();
        foreach ($this->data as $key => $val) {
            $fields[] = "`{$key}`";
            $values[] = ":_data_{$key}";
        }
        $sql .= " (".implode(',', $fields).") VALUES(".implode(',', $values).")";
        return $sql;
    }

    public function buildSelectSql() {
        $sql  = "SELECT";
        $sql .= $this->getFields();
        $sql .= " FROM";
        $sql .= $this->getTable();
        $sql .= $this->getCondition();
        $sql .= $this->getGroup();
        $sql .= $this->getOrder();
        $sql .= $this->getLimit();
        return $sql;
    }

    public function data($data) {
        foreach ($data as $field => $value) {
            $this->data[$field] = $value;
            $this->bind('_data_'.$field, $value);
        }
        return $this;
    }

    public function replace($replace = true) {
        $this->replace = $replace;
        return $this;
    }

    public function clearAttribute() {
        $this->condition = '1';       
        $this->table = '';
        $this->fields = '';
        $this->order = '';
        $this->limit = '';
        $this->group = '';
        $this->binds = array();
        $this->data = array();
        $this->replace = false;
        return $this;
    }

    public function table($table) {
        $this->table = '`'.$table.'`';
        return $this;
    }
    
    public function condition($condition, $prepare = array(), $together = 'AND') {
        if ($condition) { 
            $this->condition .= " {$together} {$condition}";
            $this->binds($prepare);
        }
        return $this;
    }

    public function compare($field, $value, $together = 'AND') {
        $this->condition .= " {$together} `{$field}` = :{$field}";
        $this->bind($field, $value);
        return $this;
    }

    public function fields($field) {
        if (is_array($field) && !empty($field)) {
            $this->fields .= (!empty($this->fields) ? ',': '').'`'.implode('`,`', $field).'`';
        } elseif (is_string($field)) {
            $this->fields .= (!empty($this->fields) ? ',': ''). $field;
        }
        return $this;
    }

    public function limit($begin = 0, $limit = 10) {
        $this->limit = "LIMIT {$begin},{$limit}";
        return $this;
    }

    public function group($group) {
        if (is_array($group)) {
            $this->group = "GROUP BY `".implode('`,`', $group)."`";
        } else {
            $this->group = "GROUP BY `{$group}`";
        }
        return $this;
    }
    
    public function order($order) {
        $orderSql = 'ORDER BY ';
        if (!empty($order)) {
            if (!is_array($order)) {
                $orderSql .= $order;
            } else {
                $dot = '';
                foreach ($order as $key => $ord) {
                    $orderSql .= ($key % 2 == 0) ? "{$dot}`{$ord}` ": strtoupper($ord);
                    $dot = ',';
                }
            }
            $this->order = $orderSql;
        }
        return $this;
    }

    public function bind($key, $val) {
        $key = ':'.$key;
        $bind = array($key => $val);
        $this->binds = array_merge($bind, $this->binds);
        return $this;
    }

    public function binds($bind = array()) {
        $this->binds = array_merge($bind, $this->binds);   
        return $this;
    }

    public function getCondition() {
        return ' WHERE '.$this->condition;   
    }

    public function getFields() {
        if (empty($this->fields)) {
            return ' *';
        }
        return ' '.$this->fields;
    }

    public function getLimit() {
        return ' '.$this->limit;
    }

    public function getGroup() {
        return ' '.$this->group;
    }

    public function getOrder() {
        if (empty($this->order)) {
            return '';
        }
        return  ' '.$this->order;
    }

    public function getBinds() {
        return $this->binds;
    }

    public function getTable() {
        return ' '.$this->table;
    }
}
