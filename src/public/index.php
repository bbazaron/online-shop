<?php
$autoload = function (string $classname) {

    $path = str_replace("\\", "/", $classname);
    $path = './../'. $path. '.php';
    if (file_exists($path)) {
        require_once $path;
        return true;
    }

    return false;
};

spl_autoload_register($autoload);

$app = new \Core\App();
$app->run();
