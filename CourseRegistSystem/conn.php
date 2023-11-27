<?php
    
    $db_server = "10.22.186.225";
    $db_user = "root";
    $db_pass = "";
    $db_name = "course_registration_system";

    $conn = null;
    try {
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    }
    catch(mysqli_sql_exception $ex) {
        echo"Can not Connected";
    }
    
?>
