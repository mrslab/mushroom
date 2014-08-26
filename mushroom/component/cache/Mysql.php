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

/**
 * CREATE TABLE IF NOT EXISTS `pre_cache` (
 *     `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 *     `key` varchar(32) NOT NULL,
 *     `value` text NOT NULL,
 *     `expire` int(11) unsigned NOT NULL DEFAULT '0',
 *     PRIMARY KEY (`id`),
 *     KEY `idx_cache` (`key`,`expire`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
 *
 */

namespace mushroom\component\cache;

use \mushroom\core\Core as Core,
    \mushroom\core\SqlBuild as SqlBuild,
    \mushroom\core\Component as Component;

class Mysql extends Core implements IFCache {

    var $mysql;

    var $table;

    public function __construct($config) {
        $this->mysql = Component::register('Mysql', $config);
        $pre = isset($config['tablepre']) ? $config['tablepre']: ''; 
        $this->table = $pre.isset($config['table']) && !empty($config['table']) ? $config['table'] : 'cache'; 
    }

    public function get($key) {
        $key = md5($key);
        $build = SqlBuild::build()->table($this->table)
                                  ->fields(array('`key`', '`value`', '`expire`'))
                                  ->condition('`key` = :key AND `expire` > :now')
                                  ->limit('1');
        $sql = $build->buildSelectSql();
        if (
            $data = $this->mysql
                         ->prepare($sql)
                         ->bindValues(array(':key' => $key, ':now' => MR_RT_TIMESTAMP))
                         ->execute()
                         ->fetch()
        ) {
            return $data;
        }
        return false;
    }

    public function set($key, $value, $expire = 3600) {
        $key = md5($key);
        $data = array(
            'key' => $key,
            'value' => $value,
            'expire' => MR_RT_TIMESTAMP + $expire,
        );
        $build = SqlBuild::build()->table($this->table)
                                  ->fields('id')
                                  ->data($data)
                                  ->condition('`key` = :key')
                                  ->limit(1);
        $sql = $build->buildSelectSql();
        if ($checkHasData = $this->mysql
                             ->prepare($sql)
                             ->bindValues(array(':key' => $key))
                             ->execute()
                             ->fetch()
        ) {
            $build->bind('key', $key);
            $sql = $build->buildUpdateSql();
        } else {
            $sql = $build->buildInsertSql();
        }
        $binds = $build->getBinds();
        if ( true == $this->mysql->prepare($sql)->bindValues($binds)->execute()) {
            return true;
        }
        return false;
    }

    public function delete($key) {
        $key = md5($key);
        $build = SqlBuild::build()->table($this->table)
                                  ->condition('`key` = :key')
                                  ->bind('key', $key)
                                  ->data(array('expire' => 0));
        $binds = $build->getBinds();
        $sql = $build->buildUpdateSql();
        if ($this->mysql->prepare($sql)->bindValues($binds)->execute()->rowCount()) {
            return true;
        }
        return false;
    }
}
