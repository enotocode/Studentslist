<?php
require_once (__DIR__ . '/../app/init.php');

if (empty($_GET) || isset($_GET['notify']) && $_GET['notify'] =='registered') {
    // Подгружаем страницу сообщения
    $view = new app\View;
    $view->render('message.html');
    exit;
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
    $totalRecords = $adg->countSearchingAbiturients($curl['search']);   
} else {
    $totalRecords = $adg->getTotalRecords();
}

// Получаем cмещение и лимит для запроса записей и кол-во страниц
$recordsPerPage = 5; // Количество записей на одной странице списка студентов
$pager = new app\Pager($totalRecords, $recordsPerPage);
$totalPages = $pager->getTotalPages();
$offset = $pager->getOffset($curl['page']);
$limit = $pager->getLimit($curl['page']);  
   
// Загружаем студентов из базы
$abiturients = $adg->getAbiturients($curl['search'], $limit, $offset, $curl['sort'], $curl['order']);

// Поля для отображения
$allowedValues = array
(
    'name',
    'lastName',
    'groupNum',
    'egePoints'
);

// Подгружаем шаблон списка студентов
$view = new app\View;
$view->render('list.html', [
                            'allowedValues' => $allowedValues,
                            'abiturients' => $abiturients,
                            'totalPages' => $totalPages,                            
                            'recordsPerPage' => $recordsPerPage,
                            'curl' => $curl
                           ]);


    




