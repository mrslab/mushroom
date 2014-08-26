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

use \mushroom\core\Core as Core,
    \mushroom\core\Component as Component;

class Mysql extends Core {

    protected $mysql;

    protected $table;

    protected $config;

    public function __construct($config) {
        $this->config = $config;
        $pre = isset($config['tablepre']) ? $config['tablepre']: ''; 
        $this->table = $pre.(isset($config['table']) && !empty($config['table']) ? $config['table'] : 'session'); 
    }

    public function open($path, $name) {
        $this->mysql = Component::register('Mysql', $this->config);
    }

    public function read($sid) {
        $key = md5($sid);
        $sql = "SELECT `sid`,`value`,`expire` FROM `{$this->table}` WHERE `sid` = :sid LIMIT 1";
        $data = $this->mysql->prepare($sql)
                            ->bindValue(':sid', $key)
                            ->execute()
                            ->fetch();
        return isset($data['value']) ? $data['value'] : null;
    }

    public function write($sid, $value) {
        $key = md5($sid);
        if (null === $this->read($sid)) {
            $sql = "INSERT INTO `{$this->table}`(`sid`,`value`,`expire`) VALUES(:sid, :value, :expire)";
            $prepare = array(
                ':sid' => $key,
                ':value' => $value,
                ':expire' => MR_RT_TIMESTAMP,
            );
        } else {
            $sql = "UPDATE `{$this->table}` SET `expire` = :expire, `value` = :value WHERE sid = :sid";
            $prepare = array(
                ':expire' => MR_RT_TIMESTAMP,
                ':value' => $value,
                ':sid' => $key,
            );
        }
        return $this->mysql->prepare($sql)->bindValues($prepare)->execute()->rowCount();
    }

    public function destroy($sid) {
        $key = md5($sid);
        $sql = "DELETE FROM `{$this->table}` WHERE sid = :sid";
        return $this->mysql->prepare($sql)->bindValue(':sid', $key)->execute()->rowCount();
    }

    public function gc($life) {
        $sql = "DELETE FROM `{$this->table}` WHERE expire + :expire < ".MR_RT_TIMESTAMP;
        return $this->mysql->prepare($sql)->bindValue(':expire', $life)->execute()->rowCount();
    }

    public function close() {
        $this->mysql = null;
    }
}
