<?php
// Константы
const ASC = 'ASC';
const DESC = 'DESC';
const GENDER_MALE = "GENDER_MALE";
const GENDER_FEMALE = "GENDER_FEMALE";
const REGISTRY_LOCAL = "REGISTRY_LOCAL";
const REGISTRY_NOT_LOCAL = "REGISTRY_NOT_LOCAL";

// Автозагрузчик
require_once '/../public/autoloader.php';

// Количество записей на одной странице списка студентов
$recordsPerPage = 5;

// Настройки из внешнего файла
if (!$settings = parse_ini_file('config.ini', TRUE)) {
    throw new exception('Unable to open ' . $file . '.');
} 
$dns = $settings['database']['driver'] .
':host=' . $settings['database']['host'] .
((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
';dbname=' . $settings['database']['dbname'] . ';charset=' . $settings['database']['charset'];

$pdo = new PDO($dns, $settings['database']['username']);
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  

// Создание класса Table gate away
$adg = new app\AbiturientDataGateway($pdo);