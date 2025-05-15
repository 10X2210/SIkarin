<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$adminPassword = "meenoi123"; //  รหัสผ่านของร้าน

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_login = isset($_POST['admin_login']);
    $admin_pass = $_POST['admin_password'] ?? '';

    if ($admin_login) {
        if ($admin_pass === $adminPassword) {
            $_SESSION['is_admin'] = true;
            header("Location: admin_menu.php");
            exit();
        } else {
            $error = "รหัสผ่านไม่ถูกต้อง";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบร้าน - หมีน้อยชาบู</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: rgb(254, 239, 223);
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-box {
            background-color: #fff7f0;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            border: 2px solid rgb(194, 132, 110);
            width: 100%;
            max-width: 400px;
        }

        .logo {
            width: 200px;
            height: auto;
            margin-bottom: 20px;
        }

        h2 {
            color: #6d4c41;
            margin-bottom: 20px;
        }

        input[type="password"] {
            font-family: 'Kanit', sans-serif;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 8px;
            border: 2px solid #bcaaa4;
            outline: none;
            width: 100%;
            box-sizing: border-box;
            background-color: #fffaf7;
            margin-bottom: 15px;
        }

        .btn {
            margin-top: 10px;
            padding: 12px 24px;
            font-size: 18px;
            background-color: rgb(99, 66, 34);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background-color: rgb(103, 74, 51);
        }

        .error {
            margin-top: 15px;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="login-box">
    <img src="assets/food/logo.PNG" alt="โลโก้ร้านหมีน้อยชาบู" class="logo">

    <h2>ร้านค้า - ล็อกอิน</h2>
    <form method="post">
        <input type="hidden" name="admin_login" value="1">
        <input type="password" name="admin_password" placeholder="รหัสผ่านร้านค้า" required>
        <button type="submit" class="btn">เข้าสู่ระบบร้าน</button>
    </form>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</div>

</body>
</html>
