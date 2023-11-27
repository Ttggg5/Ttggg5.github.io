<?php

$weekday = ["一", "二", "三", "四", "五", "六", "日"];
$weekday_abbreviation = ["(一)", "(二)", "(三)", "(四)", "(五)", "(六)", "(日)"];

$course_time = ["1", "2", "3", "4", "5", "6",
                "7", "8", "9", "10", "11", "12",
                "13", "14"];

        echo "<table class='table table-bordered table-primary'>";
            echo "<thead>";
                echo "<tr>";
                echo "<td style='height: 25px;'></td>";
                for ($i = 0; $i < 5; $i++) {
                    $day = $weekday[$i];
                    echo "<td class='mr-0' style='width: 100px;'><font size='3'>" . $day . "</font></td>";
                }
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
                for ($i = 0; $i < 14; $i++) { // 1 ~ 14 course
                    echo "<tr>";
                        echo "<td class='mr-0' style='width: 100px;'><font size='3'>" . $course_time[$i] . "</font></td>";
                        for ($j = 0; $j < 5; $j++) { // weekday
                            $time = $weekday_abbreviation[$j] . $i + 1; // (一)1
                            findSql($time);
                        }
                    echo "</tr>";
                }
            echo "</tbody>";
        echo "</table>";


        function findSql ($time) {
            include("conn.php");
            $nid = $_SESSION['nid'];
            $select_course_sql = "SELECT DISTINCT *
                                    FROM selected_course sc
                                    JOIN all_course ac
                                    ON sc.course_code = ac.code AND sc.time = ac.time;
                                    ";
            
            $result = mysqli_query($conn, $select_course_sql);
            echo "<td class='mr-0'><font size='3'>";
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row["time"] == $time && $row['student_id'] == $nid) {
                        echo $row["code"] . "<br>";

                    }
                    //echo " code:  " . $row["course_code"] . "name: " . $row["name"];
                }
            }
            echo "</font></td>";
            mysqli_free_result($result);

            /*
            $gsql = "SELECT * FROM all_course WHERE time='$time';";
                    $result = mysqli_query($conn, $gsql);
                    echo "<td>";
                    if (mysqli_num_rows($result) > 0) {
                        
                        while ($row = mysqli_fetch_array($result)) {
                            if ($row['name']) {
                                echo $row['name'] . "<br>";
                            }
                            if ($row['place']) {
                                echo $row['place'] . "<br>";
                            }
                            if ($row['class']) {
                                echo $row['class'] . "<br>";
                            }
                            if ($row['course']) {
                                echo $row['course'] . "<br>";
                            }
                        }
                        
                    }
                    echo "</td>";
                    mysqli_free_result($result);*/
        }



?>