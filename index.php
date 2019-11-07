<?php

$title = 'Дела в порядке';

function include_template($path) {
    global $categories,$work,$show_complete_tasks;
    ob_start();
    include $path;
    return ob_get_clean();
}

$title = filterXSS($title);

function filterXSS($data) {
    $data = strip_tags($data);
    $data = htmlentities($data, ENT_QUOTES, "UTF-8");
    $data = htmlspecialchars($data, ENT_QUOTES);
    return $data;
}

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$categories = ["Работа", "Учеба", "Входящие", "Домашние дела", "Авто"]; 
        
$work_source = [
    [
        'task' => 'Собеседование в IT',
        'date' => '01.12.2019',
        'category' => 'Работа',
        'finish'=>false, 
    ],
    [
        'task' => 'Выполнить тестовое задание',
        'date' => '25.12.2019',
        'category' => 'Работа',
        'finish' => false,
    ],
    [
        'task' => 'Сделать задание первого раздела',
        'date' => '21.12.2019',
        'category' => 'Учеба',
        'finish' => true,
    ],
    [
        'task' => 'Встреча с другом',
        'date' => '22.12.2019',
        'category' => 'Входящие',
        'finish' => false,
    ],
    [
        'task' => 'Купить корм для кота',
        'date' => null,
        'category' => 'Входящие',
        'finish' => false,
    ],
    [
        'task' => 'Заказать пиццу',
        'date' => null,
        'category' => 'Входящие',
        'finish' => false,
    ],
];
$work =[];
foreach ($work_source as $item_source):
    $item=[];
    foreach ($item_source as $key=>$val):
        $val = filterXSS($val);
        $item[$key] = $val;
    endforeach;
    $work[]=$item;
endforeach; 

function categoryTaskCount($category, $tasks)
{ 
    $count = 0;
    foreach ($tasks as $task) {
        if ($task ['category'] == $category) {
            $count++; 
        }
    }
    return $count;
} 
$content = include_template('templates/main.php');
include('templates/layout.php');
?>