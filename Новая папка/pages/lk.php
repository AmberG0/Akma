<?php 
require_once '../inc/functions.php';
require_login();

$user = current_user($pdo);

// 
if (isset($_POST['save_profile'])) {
    $fio = trim($_POST['fio'] ?? $user['fio']);
    $phone = trim($_POST['phone'] ?? $user['phone']);
    $address = trim($_POST['address'] ?? $user['address']);
    $avatar = $user['avatar'];
    $user['avatar'];
    // === ЗАГРУЗКА АВАТАРКИ ===
    if (!empty($_FILES['avatar']['name']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "../uploads"; 
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Удаляем  аватарки пользователя
        $old_files = glob("$upload_dir/avatar_user_{$_SESSION['user_id']}*");
        foreach ($old_files as $file) {
            if (file_exists($file)) unlink($file);
        }

        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($ext, $allowed)) {
            $avatar = "avatar_user_{$_SESSION['user_id']}.$ext";
            $target = "$upload_dir/$avatar";
            move_uploaded_file($_FILES['avatar']['tmp_name'], $target);
        }
    }

    // Сохраняем в БД
    $stmt = $pdo->prepare("UPDATE users SET fio = ?, phone = ?, address = ?, avatar = ? WHERE id = ?");
    $stmt->execute([$fio, $phone, $address, $avatar, $_SESSION['user_id']]);

    $_SESSION['user_name'] = $fio;
    $_SESSION['user_avatar'] = $avatar;

    $user = current_user($pdo);
    $success = "Профиль обновлён!";
}

// Заказы
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет — ТД Синергия</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include("../blocks/modal.php"); ?>

    <div id="main_container">
        <?php include("../blocks/header.php"); ?>

        <section id="lk_page">
            <div class="lk_container">
                <div class="lk_profile">
                    <div class="lk_avatar">
                        <?php if (isset($user['avatar']) && file_exists("../uploads/pipe.png")){ ?>
                            <img src="../uploads/<?= $user['avatar'] ?>" alt="Аватар">
                        <?php }
                        else{ ?>
                            <img src="../image/person.png" alt="Аватар">
                        <?php } ?>
                    </div>

                    <div class="avatar_buttons">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="save_profile" value="1">
                            <label class="btn_upload">
                                Загрузить фото
                                <input type="file" name="avatar" accept="image/*" onchange="this.form.submit()" style="display:none;">
                            </label>
                        </form>
                    </div>

                    <h2><?= escape($user['fio']) ?></h2>
                    <p><?= escape($user['phone'] ?? 'Телефон не указан') ?></p>

                    <button class="btn_logout" onclick="location.href='logout.php'">
                        Выйти из аккаунта
                    </button>
                </div>

                <div class="lk_main">
                    <h1>Личный кабинет</h1>

                    <?php if (isset($success)): ?>
                        <div style="background:#d4edda;color:#155724;padding:15px;border-radius:12px;margin:20px 0;">
                            <?= $success ?>
                        </div>
                    <?php endif; ?>

                    <div class="lk_edit_form">
                        <h3>Редактировать данные</h3>
                        <form method="POST">
                            <input type="hidden" name="save_profile" value="1">
                            <div class="form_row">
                                <input type="text" name="fio" value="<?= escape($user['fio']) ?>" placeholder="Ваше ФИО"required>
                                <input type="email" value="<?= escape($user['email']) ?>" placeholder="Ваше почта" disabled>
                            </div>
                            <div class="form_row">
                                <input type="tel" name="phone" value="<?= escape($user['phone'] ?? '') ?>" placeholder="Ваш телефон">
                                <input type="text" list="address" name="address" value="<?= escape($user['address'] ?? '') ?>" placeholder="Ваш адрес доставки">
                                <datalist id="address">
                                    <option>Москва, Тверская 7 (ПВЗ СДЭК)</option>
                                    <option>Москва, Арбат 12 (ПВЗ Boxberry)</option>
                                </datalist>
                            </div>
                            <button type="submit" class="btn_save">Сохранить изменения</button>
                        </form>
                    </div>

                    <div class="lk_orders">
                        <h3>Мои заказы</h3>
                        <?php if (empty($orders)): ?>
                            <p style="text-align:center;color:#666;padding:40px;">У вас пока нет заказов</p>
                        <?php else: ?>
                            <table class="orders_table">
                                <thead>
                                    <tr><th>№</th><th>Дата</th><th>Сумма</th><th>Статус</th><th></th></tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $o): ?>
                                        <tr>
                                            <td>#<?= $o['id'] ?></td>
                                            <td><?= date('d.m.Y H:i', strtotime($o['created_at'])) ?></td>
                                            <td><?= number_format($o['total'], 0, '', ' ') ?> ₽</td>
                                            <td><span class="status <?= $o['status'] ?>"><? echo $o['status']?></span></td>
                                            <td><a href="#" class="btn_details">Подробнее</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <?php include("../blocks/footer.php"); ?>
    </div>
</body>
</html>