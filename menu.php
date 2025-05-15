<?php
session_start();

if (!isset($_SESSION['table_number'])) {
    header("Location: login.php");
    exit();
}

$tableNumber = $_SESSION['table_number'];
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เมนู SHABU-MEENOI</title>
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
    .restaurant-name {
      font-size: 42px;
      text-align: center;
      color: #d84315;
      margin-bottom: 30px;
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
    .menu-category {
      margin-top: 30px;
    }
    .menu-category h3 {
      background-color: hsl(24, 27.20%, 33.90%);
      padding: 10px;
      border-radius: 10px;
      color: white;
    }
    .menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 20px;
      margin-top: 15px;
    }
    .menu-item {
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 10px;
      text-align: center;
      background: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .menu-item img {
      width: 100%;
      height: 120px;
      object-fit: cover;
      border-radius: 10px;
    }
    .menu-item input[type="number"] {
      width: 60px;
      margin-top: 5px;
      padding: 5px;
    }
    #summaryBtn {
      margin-top: 40px;
      padding: 15px 25px;
      font-size: 18px;
      background-color:rgb(62, 38, 14);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
  </style>
</head>
<body>

<img src="assets/food/banner.png" class="logo-banner" alt="โลโก้ร้าน">
<div class="table-box">โต๊ะ: <?php echo htmlspecialchars($tableNumber); ?></div>


<form action="order.php" method="POST" id="orderForm">
<?php
$categories = json_decode(file_get_contents('data/menu_data.json'), true) ?? [];
$index = 0;

foreach ($categories as $categoryName => $items) {
    echo "<div class='menu-category'>";
    echo "<h3>" . htmlspecialchars($categoryName) . "</h3>";
    echo "<div class='menu-grid'>";
    foreach ($items as $item) {
        $imagePath = 'assets/food/' . $item['image'];
        echo '<div class="menu-item">';
        echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($item['name']) . '">';
        echo '<div>' . htmlspecialchars($item['name']) . '</div>';
        echo '<input type="hidden" name="items[' . $index . '][name]" value="' . htmlspecialchars($item['name']) . '">';
        echo '<input type="number" name="items[' . $index . '][qty]" min="0" value="0">';
        echo '</div>';
        $index++;
    }
    echo "</div></div>";
}
?>
  <button type="submit" id="summaryBtn">สรุปรายการ</button>
</form>
</body>
</html>
