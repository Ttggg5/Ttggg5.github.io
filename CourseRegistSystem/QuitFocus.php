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
$sql = "DELETE FROM focused_course WHERE student_id = ? AND course_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user_nid, $code);
$stmt->execute();
$stmt->close();
header("location: MyCourse.php");
?>