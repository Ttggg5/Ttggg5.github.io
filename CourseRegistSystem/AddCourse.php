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

//check if same time have class
$sql = "SELECT * FROM all_course WHERE code='$code'";
$result = mysqli_query($conn, $sql); // get 876 Mon 3 4
$class_cnt = 0;
$cnt = 0;
while ($rows = mysqli_fetch_assoc($result)) {
    $time_list[$class_cnt] = $rows['time'];
    $class_cnt++;
}

while ($class_cnt > 0) {
    $sql = "SELECT * FROM selected_course WHERE time='$time_list[$cnt]' AND student_id='$user_nid';";
    $result = mysqli_query($conn, $sql);
    $same = mysqli_fetch_row($result);
    if ($same > 0) {
        message_alert("該時段已有課程");
        header("Location: MyCourse.php");
        exit();
    }
    $class_cnt--;
    $cnt++;
}

for ($i = 0; $i < $cnt; $i++) {
    $stmt = "INSERT INTO selected_course (id, time, course_code, student_id) VALUES ('', '$time_list[$i]', '$code', '$user_nid');";
    $result = mysqli_query($conn, $stmt);
}

$stmt = $conn->prepare("UPDATE all_course SET number_of_vacancies = number_of_vacancies - 1 WHERE code = ?;");
$stmt->bind_param("s", $code);
$stmt->execute();
$stmt->close();

function message_alert($msg) {
    echo "<scrpit type='text/javascript'>alert('$msg');</script>";
}

header("location: MyCourse.php");
exit();
?>