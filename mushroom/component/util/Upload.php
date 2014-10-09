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

namespace mushroom\component\util;

class Upload {

    protected $fileName;

    protected $fileExt;

    protected $fileSize;

    protected $fileKey;

    protected $fileTemp;

    protected $errorCode = 0;

    public function init($fileKey = 'fileData') {
        $this->fileKey = $fileKey;
        $this->initFileInfo();
    }

    public function initFileInfo() {
        $this->fileName = isset($_FILES[$this->fileKey]['name']) ? $_FILES[$this->fileKey]['name'] : '';
        $this->fileTemp = isset($_FILES[$this->fileKey]['tmp_name']) ? $_FILES[$this->fileKey]['tmp_name'] : '';
        $this->fileSize = isset($_FILES[$this->fileKey]['size']) ? $_FILES[$this->fileKey]['size']: '';
        $this->fileExt = !empty($this->fileName) ? pathinfo($this->fileName, \PATHINFO_EXTENSION) : '';
    }

    public function saveFile($file) {
        if(!isset($_FILES[$this->fileKey])) {
            $this->errorCode = 1;
            return false;
        }

        if (!is_uploaded_file($this->fileTemp)) {
            $this->errorCode = 3;
            return false;
        }

        if (function_exists('move_uploaded_file') && move_uploaded_file($this->fileTemp, $file)) {
            
        } elseif (rename($this->fileTemp, $file)){
            
        } elseif (copy($this->fileTemp, $file)){
            
        } else {
            $this->errorCode = 2;
            return false;
        }
    }
}
