<?php
session_start();
//$pwd = "456456456";
//$hashed = password_hash($pwd, PASSWORD_DEFAULT);
//var_dump($hashed);
if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
    header("location: login.php");
    exit();
}

include("conn.php");
include("GetDataFromDB.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>课表</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="./course.css">
</head>

<style>
    .tables {
        display: grid;
        grid-template-columns: 30% 70%;
    }


    /* 针对特定的表格设置类名 */
    .custom-table {
        border-collapse: collapse;
    }

    /* 为表头单元格设置样式 */
    .custom-table th {
        border: 1px solid black;
        width: 100px;
        /* 设置每个格子的宽度 */
        height: 50px;
        /* 设置每个格子的高度 */
        text-align: center;
        /* 文字居中对齐 */
    }

    /* 为数据单元格设置样式 */
    .custom-table td {
        border: 1px solid black;
        width: 100px;
        /* 设置每个格子的宽度 */
        height: 50px;
        /* 设置每个格子的高度 */
        text-align: center;
        /* 文字居中对齐 */
    }
</style>

<body>

    <?php include("navbar.php"); ?>

    <div class="tables">
        <div class="container">

            <div style="display: flex; flex-direction: row">
                <h1 style="flex: 70%">我的課表</h1>
                <h4 style="flex: auto">已選學分: <a style="color: #e0a16e"><?php echo GetCredit($conn, $_SESSION['nid']); ?></a></h4>
            </div>

            <table class="table table-bordered table-info">
                <tr>
                    <th> </th>
                    <th>一</th>
                    <th>二</th>
                    <th>三</th>
                    <th>四</th>
                    <th>五</th>
                </tr>
                <?php
                $result = GetSelectedCourseFromAllCourse($conn, $_SESSION['nid']);


                if ($result->num_rows > 0) {
                    $data = array();

                    while ($row = $result->fetch_assoc()) {
                        $time = $row["time"];

                        // 解析时间字符串，获取中文星期和阿拉伯数字节次
                        preg_match('/\((.*?)\)(\d+)/', $time, $matches);
                        $chineseWeek = $matches[1]; // 中文星期，例如 "一"、"二"
                        $arabicClass = $matches[2]; // 阿拉伯数字节次，例如 "1"、"3"

                        // 映射表：中文星期与对应的星期编号映射
                        $weekMapping = array(
                            '一' => 1,
                            '二' => 2,
                            '三' => 3,
                            '四' => 4,
                            '五' => 5
                            // 添加其他星期的映射
                        );

                        // 映射表：阿拉伯数字节次与对应的课节编号映射
                        // 例如，这里假设课节编号与阿拉伯数字节次一致，可根据实际情况修改映射关系
                        $classMapping = array(
                            '1' => 1,
                            '2' => 2,
                            '3' => 3,
                            '4' => 4,
                            '5' => 5,
                            '6' => 6,
                            '7' => 7,
                            '8' => 8,
                            '9' => 9,
                            '10' => 10,
                            '11' => 11,
                            '12' => 12,
                            '13' => 13,
                            '14' => 14
                            // 添加其他课节的映射
                        );

                        // 使用映射表将中文星期和阿拉伯数字节次转换为对应的编号
                        $week = $weekMapping[$chineseWeek];
                        $class = $classMapping[$arabicClass];

                        // 将解析后的数据存入 $data 数组
                        $data[] = array(
                            'code' => $row["code"],
                            'name' => $row["name"],
                            'week' => $week,
                            'class' => $class
                        );
                    }
                } else {
                    $data = array();
                }

                $class = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14'];

                for ($i = 0; $i < 14; $i++) {
                    echo "<tr>";
                    echo "<th class='mr-0' style='width: 100px;'>" . $class[$i] . "</th>";
                    for ($j = 1; $j < 6; $j++) { 
                        echo "<td class='mr-0' style='width: 100px;'>";
                        foreach ($data as $value) {
                            if ($value['class'] == $i + 1 && $value['week'] == $j) {
                                echo $value['code'];
                            }
                        }
                        echo "</td>";
                    
                    }
                    echo "</tr>";
                }


                ?>
            </table>
        </div>

        <div>
            <div class="container mt-4">
                <h2 style="font-weight: bold">已選課程</h2>

                <!-- 這裡放首頁的內容 -->
                <div class="container">
                    <div class="row">
                        <table id="table_id" class="display">
                            <thead>
                            <tr>
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
                            $result = GetSelectedCourseFromAllCourse($conn, $_SESSION['nid']);
                            $processedCodes = array();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $code = $row['code'];

                                    // 检查当前code值是否已经被处理过
                                    if (!in_array($code, $processedCodes)) {
                                        $processedCodes[] = $code;
                                        ?>

                                        <tr>

                                            <td>
                                                <?php echo $row['code']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['credit']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['opening_class']; ?>
                                            </td>
                                            <?php
                                            $resultTmp = GetCourseTime($conn, $row['code']);
                                            $timeStr = $resultTmp->fetch_row()[0];
                                            while ($rowTime = $resultTmp->fetch_assoc()) {
                                                $timeStr = $timeStr . ',' . str_split($rowTime['time'], 5)[1];
                                            } ?>
                                            <td>
                                                <?php echo $timeStr; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['classroom']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['initial_quota']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['number_of_vacancies']; ?>
                                            </td>
                                            <td>
                                                <?php echo GetTeacherName($conn, $row['teacher_id'])->fetch_row()[0]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['outlined']; ?>
                                            </td>

                                            <td>
                                                <button id="quitBtn" style="width: 50px"
                                                        onclick="Quit(<?php echo $row['code']; ?>, <?php echo GetCredit($conn, $_SESSION['nid']); ?>, <?php echo $row['credit']; ?>)">退選</button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="container mt-4">
                <h2 style="font-weight: bold">關注課程</h2>

                <!-- 這裡放首頁的內容 -->
                <div class="container">
                    <div class="row">
                        <table id="focusTable" class="display">
                            <thead>
                            <tr>
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
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $result = GetFoucusedCourseFromAllCourse($conn, $_SESSION['nid']);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $code = $row['code'];

                                    // 检查当前code值是否已经被处理过
                                    if (!in_array($code, $processedCodes)) {
                                        $processedCodes[] = $code;
                                        ?>

                                        <tr>
                                            <td>
                                                <?php echo $row['code']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['credit']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['opening_class']; ?>
                                            </td>
                                            <?php
                                            $resultTmp = GetCourseTime($conn, $row['code']);
                                            $timeStr = $resultTmp->fetch_row()[0];
                                            while ($rowTime = $resultTmp->fetch_assoc()) {
                                                $timeStr = $timeStr . ',' . str_split($rowTime['time'], 5)[1];
                                            } ?>
                                            <td>
                                                <?php echo $timeStr; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['classroom']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['initial_quota']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['number_of_vacancies']; ?>
                                            </td>
                                            <td>
                                                <?php echo GetTeacherName($conn, $row['teacher_id'])->fetch_row()[0]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['outlined']; ?>
                                            </td>

                                            <td>
                                                <button id="addBtn" style="width: 50px"
                                                        onclick="Add(<?php echo $row['code']; ?>, <?php echo GetCredit($conn, $_SESSION['nid']); ?>,
                                                        <?php echo $row['number_of_vacancies']; ?>, <?php echo ConfirmSelectedCourse($conn, $_SESSION['nid'], $row['code']); ?>)">加選</button>
                                            </td>

                                            <td>
                                                <button id="quitfBtn" style="width: 100px"
                                                        onclick="window.location.href = 'QuitFocus.php?code=<?php echo $row['code']; ?>'">取消關注</button>
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <script src="welcome.js"></script>
</body>


</html>