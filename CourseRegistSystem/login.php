<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: index.php");
    exit;
}
include("login.html");

include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nid = mysqli_real_escape_string($conn, $_POST['nid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

    // password must between 8 ~ 20
    if (strlen($pwd) < 8 || strlen($pwd) > 20) {
        error_message_alert("Password must between 8 ~ 20");
    }
    $pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);
    $db = "students_account";


    $sql = "SELECT * FROM $db WHERE nid='$nid'";
    $result = mysqli_query($conn, $sql);

    // check if user exist
    $row = mysqli_num_rows($result);
    if ($row != 1) {
        error_message_alert("No user");
    }

    $store_hash_pwd = mysqli_fetch_assoc($result)['pwd'];

    //verify password
    if (password_verify($pwd, $store_hash_pwd)) {
        $_SESSION["loggedin"] = true;

        $_SESSION["nid"] = $nid;

        header("Location: index.php");
        exit();

    } else {
        error_message_alert("wrong password");
    }
}

mysqli_close($conn);

function error_message_alert($message)
{
    $_SESSION["error_message"] = $message;
    header("Location: login.php");
    exit();
}
?>