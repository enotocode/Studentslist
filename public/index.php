<?php
require_once '/../app/init.php';

// Если адресная строка пуста
if (empty($_GET)) {
    // Подгружаем страницу изменения данных
    header('Location: register.php');      
}   

if (isset($_GET['notify']) && $_GET['notify'] =='registered') {
    // Подгружаем страницу сообщения
    require("../templates/message.html");
}

// Строка запроса, собираем параметры в массив
if (isset($_GET['search'])) {
    $curl['search'] = $_GET['search'];
} else {
    $curl['search'] = NULL;
}
if (isset($_GET['sort'])) {
    $curl['sort'] = $_GET['sort'];   
} else {
    $curl['sort'] = NULL;
}
if (isset($_GET['page']) && (intval($_GET['page']))) {
    $curl['page'] = intval($_GET['page']);
} else {
    $curl['page'] = NULL;
}
if (isset($_GET['order'])) {
    $curl['order'] = $_GET['order'];
} else {
    $curl['order'] = NULL;
}

// Получаем инфу про кол-во записей из базы
if (isset($curl['search'])) {
    $totalRecords = $adg->countSearchingStudents($curl['search']);   
} else {
    $totalRecords = $adg->getTotalRecords();
}

// Получаем cмещение и лимит для запроса записей и кол-во страниц
$pager = new app\Pager($totalRecords, $recordsPerPage);
$totalPages = $pager->getTotalPages();
$offset = $pager->getOffset($curl['page']);
$limit = $pager->getLimit($curl['page']);  
   
// Запрашиваем список студентов
$studentsValues = $adg->getStudents($curl['search'], $limit, $offset, $curl['sort'], $curl['order']);

// Подгружаем шаблон со списком студентов
require("../templates/header.html");
require("../templates/list.html");


    




