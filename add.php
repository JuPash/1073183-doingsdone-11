<?php
require_once './functions.php';
$con = getDBConnection();
$projects = getProjectsFromDB($con);

$content = includeTemplate('form.php', []);
print includeTemplate('layout.php', ['categories' => $projects, 'content' => $content]);

?>