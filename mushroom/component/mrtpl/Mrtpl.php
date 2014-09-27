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

class Mrtpl  extends Compile {

    public function __construct($config = array()) {
        $this->path  = isset($config['path']) ? $config['path']: MR_VIEW_PATH;
        $this->cpath = isset($config['cpath']) ? $config['cpath']: MR_RUNTIME_PATH.'/tpl_cache/';
    }

    public function template($tpl, $vars = array()) {
        $cfile = $this->getCompTplFile($tpl);
        $sfile = $this->getTplFile($tpl);
        try {
            $tptime = is_file($sfile) ? filemtime($sfile) : 0;
            $cptime = is_file($cfile) ? filemtime($cfile) : 0;
            if ($tptime > $cptime) {
                if (false === ($content = file_get_contents($sfile))) {
                    throw new Exception('"'.$sfile.'" template failed to open');
                }
                $content = $this->compile($content);
                if(false === file_put_contents($cfile, $content)) {
                    throw new Exception('"'.$cfile.'" template compile file failed to write');
                }
            }
        } catch (Exception $e) {
            $e->getExceptionMessage();
        }
        $this->buildContent($cfile, $vars);
    }
}
