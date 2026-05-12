<?php 
require_once '../inc/functions.php';
require_admin();

// === ОБРАБОТКА ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // ДОБАВЛЕНИЕ
    if ($action === 'add') {
        $name = trim($_POST['name']);
        $price = (float)$_POST['price'];
        $quantity = (int)$_POST['quantity'];
        $du = $_POST['du'] ?? '';
        $material = $_POST['material'] ?? '';

        $image = '';
        if (!empty($_FILES['photo']['name'])) {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $image = 'prod_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], "../uploads/$image");
        }

        $stmt = $pdo->prepare("INSERT INTO products (name, price, image, quantity, du, material) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $price, $image, $quantity, $du, $material]);

        header("Location: admin_products.php?msg=Товар+добавлен!");
        exit;
    }

    // РЕДАКТИРОВАНИЕ
    if ($action === 'edit') {
        $id = (int)$_POST['id'];
        $name = trim($_POST['name']);
        $price = (float)$_POST['price'];
        $quantity = (int)$_POST['quantity'];
        $du = $_POST['du'] ?? '';
        $material = $_POST['material'] ?? '';
        $old_image = $_POST['old_image'] ?? '';

        $image = $old_image;
        if (!empty($_FILES['photo']['name'])) {
            if ($old_image && file_exists("../uploads/$old_image")) {
                unlink("../uploads/$old_image");
            }
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $image = 'prod_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], "../uploads/$image");
        }

        $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, image=?, quantity=?, du=?, material=? WHERE id=?");
        $stmt->execute([$name, $price, $image, $quantity, $du, $material, $id]);

        header("Location: admin_products.php?msg=Товар+обновлён!");
        exit;
    }

    // УДАЛЕНИЕ
    if ($action === 'delete') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $image = $stmt->fetchColumn();
        if ($image && file_exists("../uploads/$image")) unlink("../uploads/$image");

        $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
        header("Location: admin_products.php?msg=Товар+удалён!");
        exit;
    }
}

// Сообщение и список товаров
$msg = $_GET['msg'] ?? '';
$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админка — Товары</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php if ($msg): ?>
        <script>alert("<?= addslashes($msg) ?>")</script>
    <?php endif; ?>

    <div id="admin_container">
        <aside class="admin_sidebar">
            <div class="admin_logo">
                <img src="../image/logo.png" alt="Logo">
                <h2>Админ-панель</h2>
            </div>
            <nav class="admin_menu">
                <a href="admin_accounts.php" class="menu_item">Аккаунты</a>
                <a href="admin_products.php" class="menu_item active">Товары</a>
                <a href="admin_orders.php" class="menu_item">Заказы</a>
            </nav>
            <div class="admin_logout">
                <a href="../logout.php" class="btn_logout_big">Выйти</a>
            </div>
        </aside>

        <main class="admin_main">
            <header class="admin_header">
                <h1>Товары</h1>
                <button onclick="openAddProductModal()" class="btn_add_product">Добавить +</button>
            </header>

            <div class="admin_table_wrapper">
                <table class="admin_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Фото</th>
                            <th>Название</th>
                            <th>Цена</th>
                            <th>Кол-во</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td>
                                    <?php if ($p['image']): ?>
                                        <img src="../uploads/<?= $p['image'] ?>" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                                    <?php endif; ?>
                                </td>
                                <td><?= escape($p['name']) ?></td>
                                <td><?= number_format($p['price'], 0, '', ' ') ?> ₽</td>
                                <td><?= $p['quantity'] ?></td>
                                <td>
                                    <button onclick='openEditProductModal(<?= json_encode($p) ?>)' class="btn_edit">Изменить</button>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="btn_delete" onclick="return confirm('Удалить?')">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php include("../blocks/admin_modal.php"); ?>
    <script src="../js/admin_modal.js"></script>

    <script>
    function openAddProductModal() {
        const html = `
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <label>Название</label><input type="text" name="name" required>
                <label>Цена</label><input type="number" step="0.01" name="price" required>
                <label>Количество</label><input type="number" name="quantity" min="0" value="1">
                <label>Ду</label><input type="text" name="du">
                <label>Материал</label><input type="text" name="material">
                <label>Фото</label><input type="file" name="photo" accept="image/*">
                <div class="modal_actions">
                    <button type="submit" class="btn_save">Добавить</button>
                </div>
            </form>
        `;
        openAdminModal('Добавить товар', html);
    }

    function openEditProductModal(p) {
        const html = `
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="${p.id}">
                <input type="hidden" name="old_image" value="${p.image || ''}">
                <label>Название</label><input type="text" name="name" value="${escape(p.name)}" required>
                <label>Цена</label><input type="number" step="0.01" name="price" value="${p.price}" required>
                <label>Количество</label><input type="number" name="quantity" value="${p.quantity}" min="0">
                <label>Ду</label><input type="text" name="du" value="${p.du || ''}">
                <label>Материал</label><input type="text" name="material" value="${p.material || ''}">
                <label>Новое фото (оставь пустым)</label><input type="file" name="photo" accept="image/*">
                <div class="modal_actions">
                    <button type="submit" class="btn_save">Сохранить</button>
                </div>
            </form>
        `;
        openAdminModal('Редактировать товар', html);
    }

    function escape(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }
    </script>
</body>
</html>