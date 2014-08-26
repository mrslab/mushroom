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

abstract class ActiveRecord extends Core implements IFActiveRecord {

    protected $_db_ = null;

    protected $_table_ = '';

    protected $_pk_ = 'id';

    public function __construct() {
        $this->_db_ = $this->dbConnect();
        $this->_table_ = $this->_db_->tablepr.$this->tableName();
        $this->_pk_ = $this->tablePrimary();
    }

    public function count($condition = '', $prepare = array()) {
        $build = SqlBuild::build()->clearAttribute()
                                  ->table($this->_table_)
                                  ->fields('COUNT('.$this->_pk_.')')
                                  ->condition($condition);
        $binds = $build->getBinds();
        $sql = $build->buildSelectSql();
        return $this->_db_
                    ->prepare($sql)
                    ->bindValues($prepare)
                    ->execute()
                    ->fetchColumn();
    }

    public function find($condition = '', $prepare = array(), $fields = array()) {
        $build = SqlBuild::build()->table($this->_table_)
                                  ->fields($fields)
                                  ->condition($condition)
                                  ->limit(0, 1);
        $sql = $build->buildSelectSql();
        return $this->_db_
                    ->prepare($sql)
                    ->bindValues($prepare)
                    ->execute()
                    ->fetch();
    }

    public function findByPk($id, $fields = array()) {
        $prepare = array(':'.$this->_pk_ => $id);
        return $this->find('`'.$this->_pk_.'` = :'.$this->_pk_, $fields , $prepare);
    }

    public function findAll($condition = '', $prepare = array(), $limit = '0, 10', $order = '', $fields = array()) {
        $limitArr = explode(',', $limit);
        $limitArr = array_filter($limitArr);
        $limit = !empty($limitArr) ? array_pop($limitArr) : 10;
        $begin = !empty($limitArr) ? array_pop($limitArr) : 0;
        $build = SqlBuild::build()->table($this->_table_)
                                  ->fields($fields)
                                  ->condition($condition)
                                  ->order($order)
                                  ->limit($begin, $limit);
        $sql = $build->buildSelectSql();
        $result = $this->_db_
                       ->prepare($sql)
                       ->bindValues($prepare)
                       ->execute()
                       ->fetchAll();
        return $result;
    }

    public function save($data) {
        $build = SqlBuild::build()->table($this->_table_)
                                  ->data($data);
        $binds = $build->getBinds();
        $sql = $build->buildInsertSql();
        $this->_db_
             ->prepare($sql)
             ->bindValues($binds)
             ->execute();
        return $this->_db_->lastInsertId();
    }

    public function delete($condition, $prepare = array()) {
        $build = SqlBuild::build()->table($this->_table_)
                                  ->condition($condition);
        $sql = $build->buildDeleteSql();
        return $this->_db_
                    ->prepare($sql)
                    ->bindValues($prepare)
                    ->execute()
                    ->rowCount();
    }

    public function deleteByPk($id) {
        $condition = $this->_pk_.' = :'.$this->_pk_;
        $prepare = array(':'.$this->_pk_ => $id);
        return $this->delete($condition, $prepare);
    }

    public function deleteByAttr($field, $value) {
        $condition = $field.' = :'.$field;
        $prepare = array(':'.$field => $value);
        return $this->delete($condition, $prepare);
    }

    public function update($data, $condition, $prepare = array()) {
        $build = SqlBuild::build()->table($this->_table_)
                                  ->data($data)
                                  ->condition($condition)
                                  ->binds($prepare);
        $binds = $build->getBinds();
        $sql = $build->buildUpdateSql();
        return $this->_db_
                    ->prepare($sql)
                    ->bindValues($binds)
                    ->execute()
                    ->rowCount();
    }

    public function updateByPk($data, $id) {
        $condition = "`{$this->_pk_}` = :{$this->_pk_}";
        $prepare = array(":{$this->_pk_}" => $id);
        return $this->update($data, $condition, $prepare);
    }

    public function tablePrimary() {
        return $this->_pk_;
    }
}
