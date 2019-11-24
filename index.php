<?php
require_once './functions.php';

if (isset($_GET['project'])) {
  //получение параметра из гет запроса + защита от пользовательского ввода
  $project = filter_input(INPUT_GET, 'project', FILTER_SANITIZE_NUMBER_INT);
}
$title = 'Дела в порядке';
  //подключение к базе данных
$con = getDBConnection();
  //запрос в таблицу projects
$projects = getProjectsFromDB($con);
if (isset($project)) {
  //если в GET запросе задан активный проект
  $sql = "SELECT id, status, name, date_completed FROM tasks WHERE project_id=$project";
}
  //если активный проект не задан
else {
  $sql = "SELECT id, status, name, date_completed FROM tasks";
}
 //выполняем запрос на подключение задач
$result = mysqli_query($con, $sql);
if ($result == false) {
  print("Ошибка подключения: " . mysqli_error($con));
  die;
}
  //преобразовываем результат в массив
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
  //если нет задач выводим 404
if (empty($tasks)){
  http_response_code(404);
  print 'ошибка 404';
}

// показывать или нет выполненные задачи
$showCompleteTasks = rand(0, 1);
$content = includeTemplate('main.php', ['work' => $tasks, 'categories' => $projects, 'showCompleteTasks' => $showCompleteTasks]);
print includeTemplate('layout.php', ['categories' => $projects, 'content' => $content]);

?>