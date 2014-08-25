<?php
namespace mushroom\component\log;

use \mushroom\library\Redis;

class LoggerRedis extends LoggerAbstract
{
    protected $config;

    protected $stronge = NULL;

    public function __construct($config)
    {
        $this->config = $config;
    
    }

    protected function write($type, $message, array $context = array())
    {
        $data = "{$type} :  {$message}";

        if ($this->stronge === NULL) {
            $this->stronge = new Redis($this->config['connect']);
        }

        return $this->stronge->lpush($this->config['key'], $data);
    }
}

