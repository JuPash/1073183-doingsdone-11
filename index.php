<?php
session_start();
require_once './functions.php';

$title = 'Дела в порядке';

if (!isset($_SESSION['user_id'])) {
    print includeTemplate('guest.php', ['title' => $title]);
    exit;
}

if (isset($_GET['project'])) {
    //получение параметра из гет запроса + защита от пользовательского ввода
    $project = filter_input(INPUT_GET, 'project', FILTER_SANITIZE_NUMBER_INT);
}
else {
    $project = NULL;
}

$filter = $_GET['filter'] ?? '';
$uid = $_SESSION['user_id'];
//подключение к базе данных
$con = getDBConnection();
//запрос в таблицу projects
$projects = getProjectsFromDB($con, $uid);
//запрос в таблицу users
$user_info = getUserInfoFromDB($con, $uid);

$search = trim(filterXSS($_GET['search'] ?? ''));

$tasks = getTasksFromDB($con, $search, $filter, $project, $uid);

//показывать или нет выполненные задачи
$showCompleteTasks = $_GET['show_completed'] ?? 0;
$content = includeTemplate('main.php', ['work' => $tasks, 'categories' => $projects, 'showCompleteTasks' => $showCompleteTasks, 'filter' => $filter]);
print includeTemplate('layout.php', ['categories' => $projects, 'content' => $content, 'title' => $title,
    'user_info' => $user_info]);

?>
