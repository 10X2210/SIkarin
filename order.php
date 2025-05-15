<?php
session_start();

if (!isset($_SESSION['table_number'])) {
    header("Location: login.php");
    exit();
}

$tableNumber = $_SESSION['table_number'];

// รับข้อมูล POST แล้วอัปเดต session ตามนั้น
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ถ้ามีการสั่งอาหารใหม่จาก menu.php
    if (isset($_POST['items']) && is_array($_POST['items'])) {
        $_SESSION['order_items'] = array_filter($_POST['items'], function($item) {
            return isset($item['qty']) && $item['qty'] > 0;
        });
    }

    // ถ้ามีการอัปเดตจำนวน
    if (isset($_POST['update']) && isset($_POST['qty'])) {
        foreach ($_POST['qty'] as $index => $qty) {
            if ($qty > 0) {
                $_SESSION['order_items'][$index]['qty'] = $qty;
            } else {
                unset($_SESSION['order_items'][$index]);
            }
        }
    }

    // รีไดเรกไปที่ order.php แบบ GET ป้องกันการส่งข้อมูลซ้ำ
    header("Location: order.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สรุปรายการสั่ง</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            padding: 20px;
            background-color: rgb(254, 239, 223);
            position: relative;
        }

        .logo-banner {
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 12px;
        }

        .table-box {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            background-color: #ffcdd2;
            color: #333;
            border-radius: 12px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            font-size: 20px;
        }

        h2 {
            text-align: center;
            color: rgb(71, 45, 24);
            margin-top: 30px;
        }

        form {
            max-width: 700px;
            margin: 30px auto;
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
             background-color:rgb(71, 45, 24);
            color: white;
        }

        tr:nth-child(even) {
            background-color: #fceade;
        }

        input[type="number"] {
            width: 60px;
            padding: 5px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color:rgb(71, 45, 24);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background-color:rgb(71, 45, 24);
        }

        .button-group {
            text-align: center;
        }
    </style>
</head>
<body>

<img src="assets/food/banner.png" class="logo-banner" alt="โลโก้ร้าน">

<div class="table-box">
    โต๊ะ: <?= htmlspecialchars($tableNumber) ?>
</div>

<h2>สรุปรายการที่เลือก</h2>

<?php if (!empty($_SESSION['order_items'])): ?>
    <form method="POST" action="order.php">
        <table>
            <tr>
                <th>ชื่อเมนู</th>
                <th>จำนวน</th>
                <th>ลบ</th>
            </tr>
            <?php foreach ($_SESSION['order_items'] as $index => $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>
                        <input type="number" name="qty[<?= $index ?>]" min="0" value="<?= htmlspecialchars($item['qty']) ?>">
                    </td>
                    <td>
                        <input type="checkbox" name="qty[<?= $index ?>]" value="0" title="ติ๊กเพื่อลบ">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="button-group">
            <button type="submit" name="update" class="btn">อัปเดตจำนวน</button>
            <a href="checkout.php" class="btn">ไปหน้าชำระเงิน</a>
        </div>
    </form>
<?php else: ?>
    <p style="text-align:center; color:rgb(100, 54, 41);">ยังไม่มีการเลือกรายการอาหาร</p>
<?php endif; ?>

</body>
</html>
