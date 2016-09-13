<?php
// Авто-загрузчик
function myAutoload($className) {
        $fileName = '';
        $namespace = '';

        $fullFileName = "..\\" . $className . ".php";

        if (file_exists($fullFileName)) {
            require $fullFileName;
        } else {
            echo 'Class "'. $fullFileName .'" does not exist.';
        }
 
    }
// Регистрируем загрузчик
spl_autoload_register('myAutoload');