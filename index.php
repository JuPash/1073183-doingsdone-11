<?php

$title = 'Дела в порядке';

require_once './functions.php';
require_once './data.php';

// показывать или нет выполненные задачи
$showCompleteTasks = rand(0, 1);
$content = includeTemplate('main.php', ['work' => $work, 'categories' => $categories, 'showCompleteTasks' => $showCompleteTasks]);
include('templates/layout.php');
?>