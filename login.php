<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table_number = $_POST['table_number'] ?? '';

    if (!empty($table_number)) {
        $_SESSION['table_number'] = $table_number;
        $_SESSION['is_admin'] = false;
        header("Location: menu.php");
        exit();
    } else {
        $error = "กรุณากรอกเลขโต๊ะ";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ - หมีน้อยชาบู</title>
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
            position: relative;
        }

        .login-box {
            background-color: #fff7f0;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            border: 2px solid #a1887f;
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

        input[type="number"] {
            font-family: 'Kanit', sans-serif;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 8px;
            border: 2px solid #bcaaa4;
            outline: none;
            width: 100%;
            box-sizing: border-box;
            background-color: #fffaf7;
        }

        .btn {
            margin-top: 20px;
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
.admin-button {
    position: absolute;
    top: 10px;        /* จาก bottom → top */
    right: 10px;
    font-size: 12px;
    background-color: #a1887f;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 6px 12px;
    cursor: pointer;
    opacity: 0.8;
    z-index: 999;     /* ให้แน่ใจว่าอยู่ด้านหน้า */
}

.admin-button:hover {
    opacity: 1;
}

    </style>
</head>
<body>

<div class="login-box">
    <img src="assets/food/logo.PNG" alt="โลโก้ร้านหมีน้อยชาบู" class="logo">
    <h2>กรุณากรอกเลขโต๊ะ</h2>

    <form method="post">
        <input type="number" name="table_number" placeholder="ระบุหมายเลขโต๊ะ" required>
        <button type="submit" class="btn">เข้าสู่ระบบ</button>
    </form>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</div>

<!-- ปุ่มเข้าสู่ระบบร้านค้า -->
<a href="admin_login.php" class="admin-button">เข้าสู่ระบบร้านค้า</a>

</body>
</html>
