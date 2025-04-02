<?php
$autoload = function (string $classname) {
    $array=explode("\\",$classname);
    if (isset($array[0]) && isset($array[1])) {

        $path= "../$array[0]/$array[1].php";
        if (file_exists($path)) {
            require_once $path;
            return true;
        }

        return false;
    }

};

spl_autoload_register($autoload);

$app = new \Core\App();
$app->run();
