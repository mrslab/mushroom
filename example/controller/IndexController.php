<?php

namespace controller;

use \mushroom\core\Core as Core;

class IndexController extends \mr\Controller {

    public function indexMethod() {
        $hello = \mr\Model::model('Hello')->hello();
        echo $hello;
    }
}
