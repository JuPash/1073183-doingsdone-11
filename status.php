<?php
require_once './functions.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    exit;
}

$uid = $_SESSION['user_id'];
$con = getDBConnection();
$sql = "UPDATE tasks SET status = " . $_GET['status'] . " WHERE id = " . $_GET['task'];
$result = mysqli_query($con, $sql);
header("Location: /index.php");
exit;
?>
