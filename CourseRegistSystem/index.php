<?php
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
        header("Location: login.php");
        exit;
    }
    include("conn.php");
    include("GetDataFromDB.php");
    //include("index.html");
    //$pwd = "789789789";
    //$hashed = password_hash($pwd, PASSWORD_DEFAULT);
    //var_dump($hashed);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>逢甲大學選課首頁</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

    <?php

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $user_nid = $_SESSION["nid"];
    } else {
        $user_nid = "";
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">選課系統</a>
      
        <!-- 左邊的連結 -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">首頁</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="MyCourse.php">我的課程</a>
                </li>
            </ul>
            
            <!-- 右邊的登出按鈕和使用者 NID -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="navbar-text mr-3">
                        <?php echo "Welcome, $user_nid"; ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">登出</a>
                </li>
            </ul>
        </div>
    </nav>
    


<!-- 內容區域 -->
<div class="container-fluid">
    
    <!-- 這裡放首頁的內容 -->

        <div class="row py-4">
            <!-- For  -->

            <div class="col-md-3">
                <?php include("curriculum.php") ?>
            </div>

            <div class="col-md-9">
                <div class="container p-0 m-0" style="width: 100%; max-width: 100%;">
                <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th style='height: 15px;'></th>
                                <th>課程代碼</th>
                                <th>課程名稱</th>
                                <th>學分</th>
                                <th>開課班級</th>
                                <th>課程時間</th>
                                <th>授課教室</th>
                                <th>課程最大人數</th>
                                <th>剩餘餘額</th>
                                <th>授課老師</th>
                                <th>大綱</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $all_course_list_sql = "SELECT DISTINCT code FROM all_course";
                            $result = mysqli_query($conn, $all_course_list_sql);
                            
                            $cnt = 0;
                            
                            while ($codes = mysqli_fetch_row($result)) {
                                $all_course_codes[$cnt] = $codes[0];
                                $cnt++;
                            }
                            $codeCount = 0;
                            while ($cnt > 0) {
                                $result = GetCourse($conn, 'all_course', $all_course_codes[$codeCount]);
                                if ($result) {
                                    $row = $result->fetch_assoc(); ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if (GetFocusedCourse($conn, $user_nid, $row['code'])) { ?>
                                                <a style="color: #587e31">已關注</a><?php
                                            }
                                            else { ?>
                                                <button id="focusBtn" style="width: 50px"
                                                        onclick="Focus(<?php echo $row['code']; ?>)">關注</button><?php
                                            }
                                            ?>
                                        </td>

                                        <td style='width: 9%;'>
                                            <?php echo $row['code']; ?>
                                        </td>
                                        <td style='width: 9%;'>
                                            <?php echo $row['name']; ?>
                                        </td>
                                        <td style='width: 4%;'>
                                            <?php echo $row['credit']; ?>
                                        </td>
                                        <td style='width: 9%;'> 
                                            <?php echo $row['opening_class']; ?>
                                        </td>
                                        <?php
                                        $resultTmp = GetCourseTime($conn, $all_course_codes[$codeCount]);
                                        $timeStr = $resultTmp->fetch_row()[0];
                                        while ($rowTime = $resultTmp->fetch_assoc()) {
                                            $timeStr = $timeStr . ',' . str_split($rowTime['time'], 5)[1];
                                        } ?>
                                        <td style='width: 9%;'>
                                            <?php echo $timeStr; ?>
                                        </td>
                                        <td style='width: 9%;'>
                                            <?php echo $row['classroom']; ?>
                                        </td>
                                        <td style='width: 9%;'>
                                            <?php echo $row['initial_quota']; ?>
                                        </td>
                                        <td style='width: 4%;'>
                                            <?php echo $row['number_of_vacancies']; ?>
                                        </td>
                                        <td style='width: 9%;'>
                                            <?php echo GetTeacherName($conn, $row['teacher_id'])->fetch_row()[0]; ?>
                                        </td>
                                        <td style='width: 29%;'> 
                                            <?php echo $row['outlined']; ?>
                                        </td>

                                        <td>
                                            <button id="addBtn" style="width: 50px"
                                                onclick="Add(<?php echo $row['code']; ?>, <?php echo GetCredit($conn, $_SESSION['nid']); ?>, 
                                                <?php echo $row['number_of_vacancies']; ?>, <?php echo ConfirmSelectedCourse($conn, $_SESSION['nid'], $row['code']); ?>)">加選</button>
                                        </td>

                                    </tr>
                                    <?php
                                } else
                                    break;

                                $cnt--;
                                $codeCount++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>

</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script src="welcome.js"></script>

</body>
</html>
