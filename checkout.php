<?php
session_start();

if (!isset($_SESSION['table_number'])) {
    header("Location: login.php");
    exit();
}

$tableNumber = $_SESSION['table_number'];
$orderItems = $_SESSION['order_items'] ?? [];

$priceList = [
    "อกไก่" => 20,
    "สันคอหมูสไลด์" => 30,
    "สามชั้นหมูสไลด์" => 35,
    "กุ้ง" => 40,
    "หมึก" => 30,
    "ปลาดอลลี่" => 30,
    "แครอท" => 10,
    "เห็ด" => 15,
    "ข้าวโพด" => 10,
    "กะหล่ำปลีฝอย" => 10,
    "ผักกาด" => 10,
    "ผักกวางตุ้ง" => 10,
    "ชีส" => 25,
    "มาม่า" => 10,
    "ไข่ไก่สด" => 8,
    "ปูอัด" => 15,
    "วุ้นเส้น" => 10,
    "ลูกชิ้นหมู" => 15,
    "น้ำจิ้มซีฟู๊ด" => 5,
    "น้ำจิ้มสุกี้" => 5
];

$total = 0;
foreach ($orderItems as $item) {
    $name = $item['name'];
    $qty = $item['qty'];
    $price = $priceList[$name] ?? 0;
    $total += $qty * $price;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ชำระเงิน SHABU-MEENOI</title>
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
            background-color: #bfa98c;
            color: #333;
            border-radius: 12px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgb(71, 45, 24);
            font-size: 20px;
        }
        h2 {
            text-align: center;
            color:rgb(71, 45, 24);
            margin-top: 30px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgb(71, 45, 24);
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
        .total {
            font-size: 24px;
            text-align: center;
            margin-top: 30px;
            color: rgb(71, 45, 24);
        }
        .qr-section {
            text-align: center;
            margin-top: 40px;
        }
        .qr-section img {
            width: 220px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgb(71, 45, 24);
        }
        .account-info {
            font-size: 18px;
            margin-top: 10px;
        }
        .pay-btn {
            display: block;
            margin: 30px auto;
            padding: 15px 25px;
            font-size: 18px;
            background-color: rgb(71, 45, 24);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .pay-btn:hover {
            background-color: rgb(71, 45, 24);
        }
    </style>
</head>
<body>

<img src="assets/food/banner.png" class="logo-banner" alt="โลโก้ร้าน">

<div class="table-box">
    โต๊ะ: <?php echo htmlspecialchars($tableNumber); ?>
</div>

<h2>สรุปยอดชำระเงิน</h2>

<?php if (!empty($orderItems)): ?>
    <table>
        <tr>
            <th>เมนู</th>
            <th>จำนวน</th>
            <th>ราคาต่อหน่วย (บาท)</th>
            <th>ราคารวม (บาท)</th>
        </tr>
        <?php foreach ($orderItems as $item): 
            $name = $item['name'];
            $qty = $item['qty'];
            $price = $priceList[$name] ?? 0;
            $subtotal = $qty * $price;
        ?>
            <tr>
                <td><?php echo htmlspecialchars($name); ?></td>
                <td><?php echo $qty; ?></td>
                <td><?php echo $price; ?></td>
                <td><?php echo $subtotal; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="total">ยอดรวมทั้งหมด: <strong><?php echo $total; ?> บาท</strong></div>

    <div class="qr-section">
        <h3>โปรดชำระเงินผ่าน QR Code</h3>
        <img src="assets/S__36405253.jpg" alt="QR Code Payment">
        <div class="account-info">
            บัญชี: นายชาบู มีน้อย <br>
            ธนาคารกรุงไทย 123-4-56789-0
        </div>
    </div>

<?php else: ?>
    <p style="text-align:center; color:#8d4a20;">ไม่มีรายการอาหาร กรุณากลับไปเลือกเมนู</p>
<?php endif; ?>
<form action="payment_notify.php" method="POST">
    <input type="hidden" name="table_number" value="<?php echo $tableNumber; ?>">
    <input type="hidden" name="total" value="<?php echo $total; ?>">
    <button type="submit" class="pay-btn">แจ้งชำระเงิน</button>
</form>

</body>
</html>
