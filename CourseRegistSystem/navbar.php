<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand">選課系統</a>
    <a class="navbar-brand" href="index.php">首頁</a>
    <a class="navbar-brand" href="MyCourse.php">我的課表</a>

    <!-- 左邊的連結 -->
    <div class="collapse navbar-collapse" id="navbarNav">

        <!-- 右邊的登出按鈕和使用者 NID -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="navbar-text mr-3">
                    <?php
                    $user_nid = $_SESSION["nid"];
                    echo "Welcome, $user_nid";
                    ?>
                </span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">登出</a>
            </li>
        </ul>
    </div>
</nav>