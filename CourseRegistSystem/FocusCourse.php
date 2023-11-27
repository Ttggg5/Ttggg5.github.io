<?php
session_start();
if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
    header("location: login.php");
    exit();
}

include("conn.php");
include("GetDataFromDB.php");

$code = $_GET['code'];
$user_nid = $_SESSION["nid"];

$stmt = $conn->prepare("INSERT INTO focused_course (course_code, student_id) VALUES (?, ?)");
$stmt->bind_param("ss", $code, $user_nid);
$stmt->execute();
$stmt->close();
header("location: index.php");
?>