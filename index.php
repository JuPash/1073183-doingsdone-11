<?php

$title = 'Дела в порядке';

require_once './functions.php';
require_once './data.php';

// показывать или нет выполненные задачи
$showCompleteTasks = rand(0, 1);
$content = includeTemplate('main.php', ['work' => $work, 'categories' => $categories, 'showCompleteTasks' => $showCompleteTasks]);
include('templates/layout.php');

$con = mysqli_connect("localhost", "root", "", "work_okay");
if ($con == false) {
  print("Ошибка подключения: " . mysqli_connect_error());
  die;
}
mysqli_set_charset($con, "utf8");

$sql = "SELECT id, name FROM projects";
$result = mysqli_query($con, $sql);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
  foreach ($projects as $row) {
  print("Проект: ". $row['name'].'<br>');
  }

$sql = "SELECT id, name, date_completed FROM tasks";
$result = mysqli_query($con, $sql);
if ($result == false) {
  print("Ошибка подключения: " . mysqli_error($con));
  die;
}
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
  foreach ($tasks as $row) {
  print("Задачи: " . $row['name'].'<br>');
  }
?>