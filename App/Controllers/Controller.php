<?php
namespace App\Controllers;

abstract class Controller {
    protected function render($templatePath,$data) {
        ob_start();
        include $templatePath;
        $content = ob_get_clean();
        include './views/layout.phtml';
    }
}