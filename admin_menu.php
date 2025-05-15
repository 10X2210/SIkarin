<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$menuFile = 'data/menu_data.json'; 
$menuData = file_exists($menuFile) ? json_decode(file_get_contents($menuFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $category = $_POST['category'] ?? '';
    $name = $_POST['name'] ?? '';
    $image = $_POST['image'] ?? '';
    $index = $_POST['index'] ?? null;

    if ($action === 'add' && $category && $name && $image) {
        $menuData[$category][] = ["name" => $name, "image" => $image];
    } elseif ($action === 'delete' && $category !== '' && is_numeric($index)) {
        unset($menuData[$category][$index]);
        $menuData[$category] = array_values($menuData[$category]);
    } elseif ($action === 'edit' && $category !== '' && is_numeric($index)) {
        $menuData[$category][$index] = ["name" => $name, "image" => $image];
    }

    file_put_contents($menuFile, json_encode($menuData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: admin_menu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Admin เมนู</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #fff8f0;
            padding: 40px;
        }
        h1 {
            text-align: center;
            color: #5d4037;
        }
        form {
            margin-bottom: 20px;
            background: #fbe9e7;
            padding: 20px;
            border-radius: 10px;
        }
        input, select {
            padding: 10px;
            margin-right: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            background-color: #8d6e63;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid #d7ccc8;
            padding: 10px;
            text-align: center;
        }
        .edit-box {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>จัดการเมนู SHABU-MEENOI</h1>

    <form method="POST">
        <select name="category" required>
            <option value="">เลือกหมวด</option>
            <option value="เนื้อสัตว์">เนื้อสัตว์</option>
            <option value="ผัก">ผัก</option>
            <option value="ของกินเล่น">ของกินเล่น</option>
            <option value="น้ำจิ้ม">น้ำจิ้ม</option>
        </select>
        <input type="text" name="name" placeholder="ชื่อเมนู" required>
        <input type="text" name="image" placeholder="ชื่อไฟล์ภาพ เช่น shrimp.PNG" required>
        <button type="submit" name="action" value="add">➕ เพิ่มเมนู</button>
    </form>

    <?php foreach ($menuData as $category => $items): ?>
        <h3><?= htmlspecialchars($category) ?></h3>
        <table>
            <tr>
                <th>ภาพ</th>
                <th>ชื่อเมนู</th>
                <th>จัดการ</th>
            </tr>
            <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><img src="assets/food/<?= htmlspecialchars($item['image']) ?>" width="80"></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
                            <input type="hidden" name="index" value="<?= $i ?>">
                            <button type="submit" name="action" value="delete">🗑️ ลบ</button>
                        </form>

                        <div class="edit-box">
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
                                <input type="hidden" name="index" value="<?= $i ?>">
                                <input type="text" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>
                                <input type="text" name="image" value="<?= htmlspecialchars($item['image']) ?>" required>
                                <button type="submit" name="action" value="edit">✏️ แก้ไข</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>
</body>
</html>
