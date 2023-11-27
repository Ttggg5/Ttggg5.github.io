$(document).ready(function () {
    $('#table_id').DataTable();
});

$(document).ready(function () {
    $('#focusTable').DataTable();
});

function Focus(code) {
    window.location.href = "FocusCourse.php?code=" + code;
}

function Add(code, credit, rest, choose) {
    if (choose) {
        alert("已选修！")
        return;
    } else if (credit >= 25) {
        alert("學分已满！")
        return;
    } else if (rest <= 0) {
        alert("人数已满！")
        return;
    } else {
        window.location.href = "AddCourse.php?code=" + code;
    }
}

function Quit(code, total_credit, credit) {
    if (total_credit - credit < 9) {
        alert("低於最低學分!")
        return;
    } else {
        window.location.href = "QuitCourse.php?code=" + code;
        alert("已退修！")
    }
}

function QuitFocus(code) {
    window.location.href = "QuitFocus.php?code=" + code;
}