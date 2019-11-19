<?php
if (isset($_GET['project'])){
  $project=$_GET['project'];
}
$title = 'Дела в порядке';

$con = mysqli_connect("localhost", "root", "", "work_okay");
if ($con == false) {
  print("Ошибка подключения: " . mysqli_connect_error());
  die;
}
mysqli_set_charset($con, "utf8");

$sql = "SELECT id, name FROM projects";
$result = mysqli_query($con, $sql);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
if (isset($project)) {
  $sql = "SELECT id, status, name, date_completed FROM tasks WHERE project_id=$project";
}
else {
  $sql = "SELECT id, status, name, date_completed FROM tasks";
}
$result = mysqli_query($con, $sql);
if ($result == false) {
  print("Ошибка подключения: " . mysqli_error($con));
  die;
}
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
if (empty($tasks)){
  http_response_code(404);
  print 'ошибка 404';
}

require_once './functions.php';
require_once './data.php';

// показывать или нет выполненные задачи
$showCompleteTasks = rand(0, 1);
$content = includeTemplate('main.php', ['work' => $tasks, 'categories' => $projects, 'showCompleteTasks' => $showCompleteTasks]);
include('templates/layout.php');

?>