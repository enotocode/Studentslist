<?php
// Авто-загрузчик
function myAutoload($className) {
        $fileName = '';
        $namespace = '';

        $fullFileName =  __DIR__ . '/../' . $className . ".php";

        if (file_exists($fullFileName)) {
            require $fullFileName;
        } 
    }
// Регистрируем загрузчик
spl_autoload_register('myAutoload');