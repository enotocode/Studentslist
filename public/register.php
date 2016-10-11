<?php
require_once  (__DIR__ . '/../app/init.php');

// Проверяем зарегистрирован ли пользователь, если да, то получаем его id
$autorization = new app\Authorization($adg);
$autorization->authorize();
$userId = $autorization->getUserId();

// Создаем объект Абитуриент
$abiturient = new app\Abiturient();

// Проверяем была ли отправлена форма
$values = "";
$errors = FALSE;
if (!empty($_POST)) {
    $formData = array_map(
                          function ($a) {return trim($a);},
                          $_POST
                          );
    // Обновляем студента
    $abiturient->updateValues($formData);
    // Отправляем его на валидацию
    $abiturientValidator = new app\AbiturientValidator();
    $errors = $abiturientValidator->validate($abiturient);    
    // Если ошибок нет, то обновляем или сохраняем студента в базу
    // и делаем редиерект с параметром успешной регистрации        
    if ($errors->isEmpty()) {        
        if ($userId) {
            // обновляем инфу зарегистрированного студента в базе
           $adg->updateAbiturient($abiturient, $userId); 
        } else {            
            // Создаем новую регистрационную запись
            $abiturient->userPassHash = $autorization->createNewRegistry();
            // сохраняем нового студента в базу
            $adg->addAbiturient($abiturient);           
        }           
        header('Location: index.php?notify=registered');            
    }
} else {
    if ($userId) {
        // Загружаем студента вслучае удачной авторизации
        $abiturient = $adg->getAbiturient($userId);        
    }
}
// Подгружаем страницу регистрации
$view = new app\View;
$view->render('form.html', [
                            'abiturient' => $abiturient,
                            'errors' => $errors   
                           ]);
