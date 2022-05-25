<?php
    include_once 'database.php';
    session_start();

    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    $sql = "SELECT * FROM member WHERE username = '$Username' AND password = '$Password'";
    $result = mysqli_query($conn,$sql);


    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $_SESSION['Username'] = $row['username'];
        $_SESSION['Status'] = $row['status'];

        if($_SESSION['Status'] == 'Admin') {
            echo '<script>alert("เข้าสู่ระบบสำเร็จ");location.href="admin.php";</script>';
        }
        if($_SESSION['Status'] == 'User') {
            echo '<script>alert("เข้าสู่ระบบสำเร็จ");location.href="index.php";</script>';
        }
        else {
            echo "Error";
        }
    }
    else {
        echo '<script>alert("เข้าสู่ระบบผิดพลาด");location.href="index.php";</script>';
    }
?>