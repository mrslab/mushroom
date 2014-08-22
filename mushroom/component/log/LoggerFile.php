<?php
namespace mushroom\component\log;

use \mushroom\library\File;

class LoggerFile extends LoggerAbstract
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    
    }

    public function log($type, $message, array())
    {
        $data = "{$type} :  {$message}";
        return File::write($this->config['path'], $data);
    }
}

