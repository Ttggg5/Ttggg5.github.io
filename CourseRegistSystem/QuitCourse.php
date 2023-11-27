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

$sql = "SELECT * FROM selected_course WHERE course_code='$code' && student_id='$user_nid';";
$result = mysqli_query($conn, $sql);



$sql = "DELETE FROM selected_course WHERE student_id = ? AND course_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user_nid, $code);
$stmt->execute();
$stmt->close();

$stmt = $conn->prepare("UPDATE all_course SET number_of_vacancies = number_of_vacancies + 1 WHERE code = ?;");
$stmt->bind_param("s", $code);
$stmt->execute();
$stmt->close();
header("location: MyCourse.php");
?>