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

namespace mushroom\component\mrtpl;

class Compile {

    protected $cpath = '';

    protected $path = '';

    protected function compile($content) {
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
        $content = preg_replace("/[\n\r\t]*\{include\s+(.+?)\s+(.+?)\}[\n\r\t]*/s", '<?php $this->template("\\1", \\2); ?>', $content);
        $content = preg_replace("/[\n\r\t]*\{include\s+(.+?)\}[\n\r\t]*/s", '<?php $this->template("\\1"); ?>', $content);
        return $content;
    }

    protected function getCompTplFile($file) {
        try {
            if (!is_dir($this->cpath)) {
                if (!mkdir($this->cpath, 0755, true)) {
                    throw new \Exception('failed to create directory "'.$this->cpath.'"');
                }
            }
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
        return $this->cpath. MR_RT_DS .md5($file) .'.php';
    }

    protected function getTplFile($tpl) {
        try {
            $file = $this->path. MR_RT_DS .$tpl;
            if (!is_file($file)) {
                throw new \Exception('template file "'.$file.'" not exists');
            }
            return $file;
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
    }

    protected function buildContent($file, $vars = array()) {
        if (!is_array($vars)) {
            throw new \Exception("template assign value ". var_export($vars, true) ." must be array");
        }
        extract($vars, \EXTR_OVERWRITE);
        $v = var_export($vars, true);
        include $file;
    }
}
