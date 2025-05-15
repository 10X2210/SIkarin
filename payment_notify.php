<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableNumber = $_POST['table_number'] ?? '';
    $totalAmount = $_POST['total'] ?? 0;

    // ล้าง session รายการอาหาร
    unset($_SESSION['order_items']);
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แจ้งชำระเงินเรียบร้อย</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: rgb(254, 239, 223);
            text-align: center;
            padding: 50px;
        }

        .message {
            background-color: #d0f0c0;
            padding: 30px;
            border-radius: 12px;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .message h2 {
            color: rgb(0, 0, 0);
            margin-top: 20px;
        }

        .btn {
            margin-top: 20px;
            padding: 12px 24px;
            font-size: 18px;
            background-color: rgb(71, 45, 24);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: rgb(103, 74, 51);
        }

        img.slip-preview {
            margin-top: 20px;
            max-width: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgb(71, 45, 24);
        }

        .logo {
            width: 250px;
            height: auto;
            margin: 0 auto 20px;
            display: block;
        }

        /* Overlay สำหรับป็อปอัปและกำลังโหลด */
        .popup-overlay, .loading-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .popup-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .popup-image {
            width: 250px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .loading-box {
            background-color: #fff;
            padding: 25px 40px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            font-size: 20px;
        }
    </style>
</head>
<body>

<div class="message">
    <img src="assets/food/proc.PNG" alt="โลโก้ร้านหมีน้อยชาบู" class="logo">

    <h2>แจ้งชำระเงินเรียบร้อยแล้ว</h2>
    <p>โต๊ะหมายเลข: <strong><?= htmlspecialchars($tableNumber) ?></strong></p>
    <p>ยอดเงินที่ต้องชำระ: <strong><?= htmlspecialchars($totalAmount) ?> บาท</strong></p>

    <?php
    if (isset($_FILES['slip']) && $_FILES['slip']['error'] === 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = basename($_FILES["slip"]["name"]);
        $file_name = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_name);
        $target_file = $target_dir . time() . "_" . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png'];

    }
    ?>

    <form action="login.php" method="get">
        <button type="submit" class="btn">กลับหน้าแรก</button>
    </form>
</div>

<!-- Overlay: กำลังโหลด -->
<div id="loading" class="loading-overlay">
    <div class="loading-box">
        <p>กรุณารอสักครู่<br>ระบบกำลังเตรียมอาหารของคุณ...  🍲</p>
    </div>
</div>

<!-- Overlay: ป็อปอัป -->
<div id="popup" class="popup-overlay">
    <div class="popup-box">
        <img src="assets/food/fini.PNG" alt="ขอบคุณ" class="popup-image">
        <p>ขอบคุณที่ใช้บริการหมีน้อยชาบู <br>🐻</p>
        <button onclick="closePopup()" class="btn">ปิด</button>
    </div>
</div>

<script>
    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }

    window.onload = () => {
        // ดีเลย์ 3 วินาที ก่อนแสดง loading
        setTimeout(() => {
            document.getElementById("loading").style.display = "flex";

            // หลังจากแสดง loading แล้ว 10 วินาที ค่อยโชว์ popup
            setTimeout(() => {
                document.getElementById("loading").style.display = "none";
                document.getElementById("popup").style.display = "flex";
            }, 10000); // 10 วินาทีสำหรับ loading
        }, 3000); // 7 วินาทีก่อนแสดง loading
    }
</script>

</body>
</html>
