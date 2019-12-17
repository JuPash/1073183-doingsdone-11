<?php
session_start();
require_once './functions.php';

if (!isset($_SESSION['user_id'])) {
  print includeTemplate('guest.php', []);
  exit;
}

if (isset($_GET['project'])) {
  //получение параметра из гет запроса + защита от пользовательского ввода
  $project = filter_input(INPUT_GET, 'project', FILTER_SANITIZE_NUMBER_INT);
}
$title = 'Дела в порядке';
$uid = $_SESSION['user_id'];
  //подключение к базе данных
$con = getDBConnection();
  //запрос в таблицу projects
$projects = getProjectsFromDB($con, $uid);
  //запрос в таблицу users
$user_info = getUserInfoFromDB($con, $uid);
if (isset($project)) {
  //если в GET запросе задан активный проект
  $sql = "SELECT id, status, name, date_completed, file_path FROM tasks WHERE project_id=$project and user_id=$uid";
}
  //если активный проект не задан
else {
  $sql = "SELECT id, status, name, date_completed, file_path FROM tasks WHERE user_id=$uid";
}
 //выполняем запрос на подключение задач
$result = mysqli_query($con, $sql);
if ($result == false) {
  print("Ошибка подключения: " . mysqli_error($con));
  die;
}
  //преобразовываем результат в массив
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

// показывать или нет выполненные задачи
$showCompleteTasks = $_GET['show_completed'] ?? 0;
$content = includeTemplate('main.php', ['work' => $tasks, 'categories' => $projects, 'showCompleteTasks' => $showCompleteTasks]);
print includeTemplate('layout.php', ['categories' => $projects, 'content' => $content, 'title' => $title,
  'user_info' => $user_info]);

?>