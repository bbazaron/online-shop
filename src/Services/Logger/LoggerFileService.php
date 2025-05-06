<?php

namespace Services\Logger;

class LoggerFileService implements LoggerInterface
{
    public function error(\Throwable $exception){
        $dataFile = '../Storage/Log/errors.txt';
        $counterFile = '../Storage/Log/counter.txt'; // счетчик с цифрой

        $counter = file_exists($counterFile) ? (int)file_get_contents($counterFile) : 0; // счетчик из файла

        if (is_writable($dataFile)) {
            file_put_contents($dataFile, 'Record #'.($counter+1)."\n", FILE_APPEND );
            file_put_contents($dataFile, 'Message: '.$exception->getMessage()."\n", FILE_APPEND );
            file_put_contents($dataFile, 'File: '.$exception->getFile()."\n", FILE_APPEND );
            file_put_contents($dataFile, 'Line: '.$exception->getLine()."\n", FILE_APPEND );
            file_put_contents($dataFile, 'Date: '.date('Y-m-d H:i:s')."\n"."\n", FILE_APPEND );

            file_put_contents($counterFile, $counter + 1);
            require_once'../Views/500.php';
            exit;
        } else {
            echo 'Файл недоступен для записи';
        }
    }
}