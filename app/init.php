<?php

// Автозагрузчик
require_once (__DIR__ . '/autoloader.php');

// Настройки из внешнего файла
if (!$settings = parse_ini_file('config.ini', TRUE)) {
    throw new Exception('Unable to open ' . $file . '.');
}

$dns = sprintf(
               "mysql:host=%s; %s dbname=%s; charset=utf8mb4",
               $settings['database']['host'],
               (!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '',
               $settings['database']['dbname']
               );

$pdo = new PDO($dns, $settings['database']['username'], $settings['database']['password']);
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  

// Создание класса Table gate away
$adg = new app\AbiturientDataGateway($pdo);