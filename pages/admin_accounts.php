<?php 
require_once '../inc/functions.php';
require_admin();

// === вся обработка ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Добавление
    if ($action === 'add') {
        $fio = trim($_POST['fio'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'client';

        if (empty($fio) || empty($email) || empty($password)) {
            $alert = "Заполните все поля!";
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO users (fio, email, password, role) VALUES (?, ?, ?, ?)");
                $stmt->execute([$fio, $email, password_hash($password, PASSWORD_DEFAULT), $role]);
                $alert = "Пользователь добавлен!";
            } catch (PDOException $e) {
                $alert = "Ошибка: email уже существует!";
            }
        }
    }

    // Редактирование
    if ($action === 'edit') {
        $id = (int)$_POST['id'];
        $fio = trim($_POST['fio']);
        $role = $_POST['role'];

        if (empty($fio)) {
            $alert = "ФИО не может быть пустым!";
        } else {
            if (!empty($_POST['password'])) {
                $stmt = $pdo->prepare("UPDATE users SET fio = ?, password = ?, role = ? WHERE id = ?");
                $stmt->execute([$fio, password_hash($_POST['password'], PASSWORD_DEFAULT), $role, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET fio = ?, role = ? WHERE id = ?");
                $stmt->execute([$fio, $role, $id]);
            }
            $alert = "Данные обновлены!";
        }
    }

    // Удаление
    if ($action === 'delete') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
        $stmt->execute([$id]);
        $alert = "Пользователь удалён!";
    }

    // Редирект с сообщением — главное!
    header("Location: admin_accounts.php?alert=" . urlencode($alert));
    exit;
}

// Получаем сообщение один раз
$alert = $_GET['alert'] ?? null;
$users = $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админка — Аккаунты</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php if ($alert): ?>
        <script>
            alert("<?= addslashes($alert) ?>");
        </script>
    <?php endif; ?>

    <div id="admin_container">
        <!-- Боковое меню -->
        <aside class="admin_sidebar">
            <div class="admin_logo">
                <img src="../image/logo.png" alt="Logo">
                <h2>Админ-панель</h2>
            </div>
            <nav class="admin_menu">
                <a href="admin_accounts.php" class="menu_item active">Аккаунты</a>
                <a href="admin_products.php" class="menu_item">Товары</a>
                <a href="admin_orders.php" class="menu_item">Заказы</a>
            </nav>
            <div class="admin_logout">
                <a href="../logout.php" class="btn_logout_big">Выйти</a>
            </div>
        </aside>

        <main class="admin_main">
            <header class="admin_header">
                <h1>Аккаунты пользователей</h1>
                <button onclick="openAddAccountModal()" class="btn_add_product">Добавить +</button>
            </header>

            <div class="admin_table_wrapper">
                <table class="admin_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ФИО</th>
                            <th>Email</th>
                            <th>Роль</th>
                            <th>Дата регистрации</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= $u['id'] ?></td>
                                <td><?= escape($u['fio']) ?></td>
                                <td><?= escape($u['email']) ?></td>
                                <td><?= $u['role'] === 'admin' ? 'Админ' : 'Клиент' ?></td>
                                <td><?= date('d.m.Y', strtotime($u['created_at'])) ?></td>
                                <td>
                                    <button onclick='openEditAccountModal(<?= json_encode($u) ?>)' class="btn_edit">Изменить</button>
                                    <?php if ($u['role'] !== 'admin'): ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="btn_delete" onclick="return confirm('Удалить?')">Удалить</button>
                                        </form>
                                    <?php endif; ?>
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
    function openAddAccountModal() {
        const html = `
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <label>ФИО</label><input type="text" name="fio" required>
                <label>Email</label><input type="email" name="email" required>
                <label>Пароль</label><input type="password" name="password" required minlength="6">
                <label>Роль</label>
                <select name="role">
                    <option value="client">Клиент</option>
                    <option value="admin">Администратор</option>
                </select>
                <div class="modal_actions">
                    <button type="submit" class="btn_save">Добавить</button>
                </div>
            </form>
        `;
        openAdminModal('Добавить пользователя', html);
    }

    function openEditAccountModal(u) {
        const html = `
            <form method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="${u.id}">
                <label>ФИО</label><input type="text" name="fio" value="${escape(u.fio)}" required>
                <label>Новый пароль (оставь пустым)</label><input type="password" name="password">
                <label>Роль</label>
                <select name="role">
                    <option value="client" ${u.role === 'client' ? 'selected' : ''}>Клиент</option>
                    <option value="admin" ${u.role === 'admin' ? 'selected' : ''}>Администратор</option>
                </select>
                <div class="modal_actions">
                    <button type="submit" class="btn_save">Сохранить</button>
                </div>
            </form>
        `;
        openAdminModal('Редактировать пользователя', html);
    }

    function escape(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }
    </script>
</body>
</html>