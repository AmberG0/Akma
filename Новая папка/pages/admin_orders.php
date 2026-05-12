<?php 
require_once '../inc/functions.php';
require_admin();

// === СМЕНА СТАТУСА ===
if ($_POST['action'] ?? '' === 'change_status') {
    $id = (int)$_POST['order_id'];
    $status = $_POST['status'];
    echo $status;
    // $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    // $stmt->execute([$status, $id]);

    // header("Location: admin_orders.php?msg=Статус+обновлён!");
    exit;
}

// Все заказы с именем клиента
$orders = $pdo->query("
    SELECT o.*, u.fio 
    FROM orders o 
    LEFT JOIN users u ON o.user_id = u.id 
    ORDER BY o.created_at DESC
")->fetchAll();

$msg = $_GET['msg'] ?? '';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админка — Заказы</title>
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
                <a href="admin_products.php" class="menu_item">Товары</a>
                <a href="admin_orders.php" class="menu_item active">Заказы</a>
            </nav>
            <div class="admin_logout">
                <a href="../logout.php" class="btn_logout_big">Выйти</a>
            </div>
        </aside>

        <main class="admin_main">
            <header class="admin_header">
                <h1>Заказы</h1>
            </header>

            <div class="admin_table_wrapper">
                <table class="admin_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Дата</th>
                            <th>Клиент</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $o): ?>
                            <tr>
                                <td>#<?= $o['id'] ?></td>
                                <td><?= date('d.m.Y H:i', strtotime($o['created_at'])) ?></td>
                                <td><?= escape($o['fio'] ?? 'Гость') ?></td>
                                <td><?= number_format($o['total'], 0, '', ' ') ?> ₽</td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                        <input type="hidden" name="action" value="change_status">
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="'Новый'" <?= $o['status']=='Новый'?'selected':'' ?>>Новый</option>
                                            <option value="processing" <?= $o['status']=='processing'?'selected':'' ?>>В обработке</option>
                                            <option value="shipped" <?= $o['status']=='shipped'?'selected':'' ?>>Отправлен</option>
                                            <option value="delivered" <?= $o['status']=='delivered'?'selected':'' ?>>Доставлен</option>
                                            <option value="cancelled" <?= $o['status']=='cancelled'?'selected':'' ?>>Отменён</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <button onclick='openOrderDetails(<?= $o['id'] ?>)' class="btn_details">Подробнее</button>
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
    function openOrderDetails(orderId) {
        location.href = `order_details.php?id=${orderId}`;
    }
    </script>
</body>
</html>