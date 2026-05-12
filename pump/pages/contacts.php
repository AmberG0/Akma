<?php 
require_once '../inc/functions.php'; 

$error = '';
$success = '';

if ($_POST) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if ($name && $email && $message) {
        // Здесь можно добавить отправку на почту или сохранение в БД
        // Для примера просто показываем уведомление
        $success = "Ваше сообщение отправлено! Мы свяжемся с вами в ближайшее время.";
        
        // Очистка полей после отправки
        $_POST = array();
    } else {
        $error = "Заполните обязательные поля (Имя, Email, Сообщение)";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты — ТД Синергия</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include("../blocks/modal.php"); ?>
    <div id="main_container">
        <?php include("../blocks/header.php"); ?>

        <section id="contacts_page">
            <h1 class="page_title">Контакты</h1>
            
            <div class="contacts_wrapper">
                <!-- Контактная информация -->
                <div class="contacts_info">
                    <div class="contact_card">
                        <img src="../image/person.png" alt="Телефон">
                        <h3>Телефон</h3>
                        <p><a href="tel:+78001234567">+7 (800) 123-45-67</a></p>
                        <p class="contact_note">Бесплатно по России</p>
                    </div>
                    
                    <div class="contact_card">
                        <img src="../image/tags.png" alt="Email">
                        <h3>Email</h3>
                        <p><a href="mailto:info@sinergia.ru">info@sinergia.ru</a></p>
                        <p class="contact_note">Отвечаем в течение 24 часов</p>
                    </div>
                    
                    <div class="contact_card">
                        <img src="../image/truck.png" alt="Адрес">
                        <h3>Адрес офиса</h3>
                        <p>г. Москва, ул. Тверская, д. 7, офис 305</p>
                        <p class="contact_note">Пн-Пт: 9:00 - 18:00</p>
                    </div>
                    
                    <div class="contact_card">
                        <img src="../image/shield.png" alt="Реквизиты">
                        <h3>Реквизиты</h3>
                        <p>ИНН: 7701234567</p>
                        <p class="contact_note">ООО «ТД Синергия»</p>
                    </div>
                </div>
                
                <!-- Форма обратной связи -->
                <div class="contact_form_block">
                    <h2>Напишите нам</h2>
                    <p class="form_subtitle">Заполните форму и мы свяжемся с вами</p>
                    
                    <?php if ($success): ?>
                        <div class="notification success"><?= escape($success) ?></div>
                    <?php endif; ?>
                    
                    <?php if ($error): ?>
                        <div class="notification error"><?= escape($error) ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" class="contact_form">
                        <div class="form_row">
                            <input type="text" name="name" value="<?= escape($_POST['name'] ?? '') ?>" placeholder="Ваше имя *" required>
                            <input type="email" name="email" value="<?= escape($_POST['email'] ?? '') ?>" placeholder="Ваш Email *" required>
                        </div>
                        <div class="form_row">
                            <input type="tel" name="phone" value="<?= escape($_POST['phone'] ?? '') ?>" placeholder="Ваш телефон">
                            <input type="text" name="subject" value="<?= escape($_POST['subject'] ?? '') ?>" placeholder="Тема сообщения">
                        </div>
                        <textarea name="message" rows="5" placeholder="Ваше сообщение *" required><?= escape($_POST['message'] ?? '') ?></textarea>
                        <button type="submit" class="btn_send">Отправить сообщение</button>
                    </form>
                </div>
            </div>
            
            <!-- Карта -->
            <div class="map_section">
                <h2>Мы на карте</h2>
                <div class="map_container">
                    <iframe src="https://yandex.ru/map-widget/v1/?ll=37.617635%2C55.755814&z=12" width="100%" height="450" frameborder="0" allowfullscreen="true"></iframe>
                </div>
            </div>
        </section>

        <?php include("../blocks/footer.php"); ?>
    </div>
</body>
</html>
