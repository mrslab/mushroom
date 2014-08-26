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

class Template  extends Core {

    private $file = '';

    private $cfile = '';

    public static function initTpl($file) {
        return new self($file);
    }

    private function __construct($file) {
        $this->file = $file;
        $this->cfile = $this->getCompTplFile();       
    }

    public function template() {
        try {
            $tptime = is_file($this->file) ? filemtime($this->file) : 0;
            $cptime = is_file($this->cfile) ? filemtime($this->cfile) : 0;
            if ($tptime > $cptime) {
                if (false === ($content = file_get_contents($this->file))) {
                    throw new Exception('"'.$this->file.'" template failed to open');
                }
                $content = $this->compile($content);
                if(false === file_put_contents($this->cfile, $content)) {
                    throw new Exception('"'.$this->cfile.'" template compile file failed to write');
                }
            }
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
        return $this->cfile;
    }

    private function compile($content) {
        $content = preg_replace("/([\n\r]+)\t+/s", "\\1", $content);
        $content = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $content);
        $content = str_replace("{LF}", "<?=\"\\n\"?>", $content);
        $content = preg_replace("/\{(\\\$[a-zA-Z0-9_\-\>\[\]\'\"\$\.\x7f-\xff]+)\}/s", "<?php echo \\1?>", $content);
        $content = preg_replace("/[\n\r\t]*\{php\}/s", "<?php ", $content);
        $content = preg_replace("/[\n\r\t]*\{\/php\}/s", " ?>", $content);
        $content = preg_replace("/[\n\r\t]*\{echo\s+(.+?)\}[\n\r\t]*/s", "<?php echo \\1; ?>", $content);
        $content = preg_replace("/[\n\r\t]*\{if\s+(.+?)\}[\n\r\t]*/is", "<?php if(\\1) { ?>", $content);
        $content = preg_replace("/[\n\r\t]*\{else\}[\n\r\t]*/is", "<?php } else { ?>", $content);
        $content = preg_replace("/[\n\r\t]*\{\/if\}[\n\r\t]*/is", "<?php } ?>", $content);
        $content = preg_replace("/[\n\r\t]*\{elseif\s+(.+?)\}[\n\r\t]*/is", "<?php } elseif(\\1) { ?>", $content);
        $content = preg_replace("/[\n\r\t]*\{foreach\s+(\S+)\s+(\S+)\}[\n\r\t]*/is", "<?php if(is_array(\\1)) foreach(\\1 as \\2)     { ?>", $content);
        $content = preg_replace("/[\n\r\t]*\{foreach\s+(\S+)\s+(\S+)\s+(\S+)\}[\n\r\t]*/is", "<?php if(is_array(\\1)) foreach(\\1     as \\2 => \\3) { ?>", $content);
        $content = preg_replace("/\{\/foreach\}/i", "<?php } ?>", $content);
        $content = preg_replace("/\{([a-zA-Z\:\_]+)\((.+?)\)\}/is", "<?php echo \\1(\\2); ?>", $content);
        $content = preg_replace("/\{php\s+(.+?)\}/is", "<?php \\1; ?>", $content);
        $content = preg_replace("/[\n\r\t]*\{include\s+(.+?)\}[\n\r\t]*/s", '<?php include $this->render("\\1"); ?>', $content);
        return $content;
    }

    private function getCompTplFile() {
        try {
            $path = MR_RUNTIME_PATH . '/tpl/';
            if (!is_dir($path)) {
                if (!mkdir($path, 0755, true)) {
                    throw new Exception('failed to create directory "'.$path.'"');
                }
            }
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
        return $path. md5($this->file) .'.php';
    }
}
