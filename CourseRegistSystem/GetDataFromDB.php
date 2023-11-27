<?php
function GetCourse($conn, $tableName, $courseCode)
{
    $sql = "SELECT * FROM $tableName WHERE code='$courseCode'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
    return null;
}

function GetFocusedCourse($conn, $studentId, $courseCode)
{
    $sql = "SELECT * FROM focused_course WHERE course_code='$courseCode' AND student_id='$studentId'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
    return null;
}

function GetCourseTime($conn, $courseCode)
{
    $sql = "SELECT time FROM all_course WHERE code='$courseCode'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
    return null;
}

function GetTeacherName($conn, $id)
{
    $sql = "SELECT name FROM teacher_information WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }
    return null;
}
function GetSelectedCourseFromAllCourse($conn, $id)
{
    $sql = "SELECT * FROM selected_course WHERE student_id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                'course_code' => $row["course_code"]
            );
        }
    }

    if ($result->num_rows > 0) {
        $sql = "SELECT * FROM all_course WHERE code = '" . $data[0]['course_code'] . "'";
        for ($i = 1; $i < count($data); $i++) {
            $sql .= " OR code = '" . $data[$i]['course_code'] . "'";
        }
        $result = $conn->query($sql);
    }

    return $result;
}

function GetFoucusedCourseFromAllCourse($conn, $id)
{
    $sql = "SELECT * FROM focused_course WHERE student_id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                'course_code' => $row["course_code"]
            );
        }
    }

    if ($result->num_rows > 0) {
        $sql = "SELECT * FROM all_course WHERE code = '" . $data[0]['course_code'] . "'";
        for ($i = 1; $i < count($data); $i++) {
            $sql .= " OR code = '" . $data[$i]['course_code'] . "'";
        }
        $result = $conn->query($sql);
    }

    return $result;
}

function GetCredit($conn, $id)
{
    $result = GetSelectedCourseFromAllCourse($conn, $id);
    $credit = 0;
    $processedCodes = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $code = $row['code'];
            if (!in_array($code, $processedCodes)) {
                $processedCodes[] = $code;
                $credit += intval($row['credit']);
            }
        }
    }
    return $credit;
}

function ConfirmSelectedCourse($conn, $id, $code)
{
    $sql = "SELECT * FROM selected_course WHERE student_id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['course_code'] == $code) {
                return true;
            }
        }
    }
    return false;
}

?>