<?php
require_once '\..\app\init.php';

// Проверяем зарегистрирован ли пользователь, если да, то получаем его id
$autorization = new app\Autorization($adg);
$userId = NULL;
if (isset($_COOKIE['userPassword']) && ($autorization->getUserId($_COOKIE['userPassword']))) {
    $userId = $autorization->getUserId($_COOKIE['userPassword']);    
} 
  
// Проверяем была ли отправлена форма
$values = "";
$errors = array();
if (!empty($_POST)) {
    // Необходимые значения формы для создания объекта Abiturient
    $abiturientValues = array(
        "name",
        "lastName",
        "gender",
        "groupNum",
        "email",
        "egePoints",
        "dateOfBirth",
        "registry"
    );
    // Выбираем из $_POST нужные параметры
    $values = array_intersect_key($_POST, array_flip($abiturientValues));
    // Проводим магический ритуал очищения значений параметров полученных из формы
    foreach ($values as $valueName=>$value) {
        $value = trim($value);
        // Каким-то образом экранируем спецсимволы
    }   
    // Создаем объект Абитуриент
    $abiturient = new app\Abiturient ($values);
    // Отправляем его на валидацию
    $abiturientValidator = new app\AbiturientValidator();
    $errors = $abiturientValidator->validate($abiturient);        
    // Проверяем наличие ошибок в массиве ошибок
    $errorsNum = false;
    foreach($errors as $es) {
        if (is_array($es)) {
            foreach($es as $e) {
                if (isset($e)) {
                    $errorsNum = TRUE;
                }
            }
        } else {
            if (isset($es)) {
                    $errorsNum = TRUE;
                }
        }            
    }        
    // Если ошибок нет, то сохраняем студента в базу и делаем редиерект с параметром успешной регистрации        
    if (!$errorsNum ) {        
        if ($userId) {
           $adg->updateStudent($abiturient, $userId); // обновляем инфу зарегистрированного студента в базе
        } else { // сохраняем нового студента в базу
            // Генерируем пароль            
            $userPassword = $autorization->generatePass();
            $abiturient->setUserPassword($userPassword);            
            $adg->addStudent($abiturient);
            // Устанавливаем куки
            setcookie ('userPassword', $userPassword, strtotime( '+10 years' ));           
        }           
        header('Location: index.php?notify=registered');            
    }
} else {
    if ($userId) {
        $values = $adg->getStudent($userId); 
    }
}
// Подгружаем страницу регистрации
require ("../templates/header.html");
require ("../templates/form.html");
