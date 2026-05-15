<?php
session_start();
require_once '../../i/WebsiteBackend/db.php';

// Проверка авторизации
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

$role = $_SESSION['role'];
$user_fio = $_SESSION['fio'];

// Обработка действий
$action = isset($_GET['action']) ? $_GET['action'] : '';
$message = '';
$message_type = '';

// Удаление услуги
if ($action === 'delete' && $role === 'admin' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM Services WHERE ID_services = ?");
        $stmt->execute([$id]);
        $message = 'Услуга успешно удалена';
        $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Ошибка при удалении: ' . $e->getMessage();
        $message_type = 'error';
    }
}

// Обработка формы сохранения (добавление/редактирование)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $role === 'admin') {
    $service_id = isset($_POST['service_id']) && $_POST['service_id'] !== '' ? (int)$_POST['service_id'] : null;
    $name = trim($_POST['name']);
    $category = isset($_POST['category']) && $_POST['category'] !== '' ? (int)$_POST['category'] : null;
    $description = trim($_POST['description']);
    $unit = trim($_POST['unit']);
    $price = (float)$_POST['price'];
    $relevance = $_POST['relevance'];
    
    // Обработка загрузки фото
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        // Используем абсолютный путь относительно корня проекта
        $upload_dir = __DIR__ . '/../../uploads/services/';
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $file_type = $_FILES['photo']['type'];
        $file_size = $_FILES['photo']['size'];
        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_name = basename($_FILES['photo']['name']);
        
        // Проверка типа файла
        if (!in_array($file_type, $allowed_types)) {
            $message = 'Разрешены только изображения (JPEG, PNG, GIF, WebP)';
            $message_type = 'error';
        } elseif ($file_size > 5 * 1024 * 1024) { // 5MB max
            $message = 'Размер файла не должен превышать 5MB';
            $message_type = 'error';
        } else {
            // Генерация уникального имени
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_filename = 'service_' . time() . '_' . uniqid() . '.' . $extension;
            $upload_path = $upload_dir . $new_filename;
            
            // Создаем директорию если не существует
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Сохраняем относительный путь для БД
                $photo = 'uploads/services/' . $new_filename;
            } else {
                $message = 'Ошибка при загрузке файла. Проверьте права доступа к папке uploads/services/';
                $message_type = 'error';
                error_log('Не удалось переместить файл из ' . $file_tmp . ' в ' . $upload_path);
            }
        }
    } elseif ($service_id) {
        // При редактировании оставляем старое фото, если новое не загружено
        $stmt = $pdo->prepare("SELECT Photo FROM Services WHERE ID_services = ?");
        $stmt->execute([$service_id]);
        $old_service = $stmt->fetch(PDO::FETCH_ASSOC);
        $photo = $old_service['Photo'] ?? '';
    }
    
    if (empty($message) || $message_type !== 'error') {
        if (empty($name) || empty($unit) || $price < 0) {
            $message = 'Заполните обязательные поля';
            $message_type = 'error';
        } else {
            try {
                if ($service_id) {
                    // Обновление существующей услуги
                    $stmt = $pdo->prepare("UPDATE Services SET 
                        Name = ?, 
                        Category = ?, 
                        Description = ?, 
                        Unit = ?, 
                        Price = ?, 
                        Relevance = ?, 
                        Photo = ? 
                        WHERE ID_services = ?");
                    $stmt->execute([$name, $category, $description, $unit, $price, $relevance, $photo, $service_id]);
                    $message = 'Услуга успешно обновлена';
                    $message_type = 'success';
                } else {
                    // Добавление новой услуги
                    $stmt = $pdo->prepare("INSERT INTO Services (Name, Category, Description, Unit, Price, Relevance, Photo) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $category, $description, $unit, $price, $relevance, $photo]);
                    $message = 'Услуга успешно добавлена';
                    $message_type = 'success';
                }
            } catch (PDOException $e) {
                $message = 'Ошибка БД: ' . $e->getMessage();
                $message_type = 'error';
            }
        }
    }
    
    // Перезагрузка страницы для обновления списка
    header('Location: services.php?msg=' . urlencode($message) . '&type=' . $message_type);
    exit;
}

// Получение сообщения из URL
if (isset($_GET['msg'])) {
    $message = $_GET['msg'];
    $message_type = isset($_GET['type']) ? $_GET['type'] : 'success';
}

// Получение категорий
$categories = [];
try {
    $stmt = $pdo->query("SELECT ID_category, Name FROM Category ORDER BY Name");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $categories = [];
}

// Получение всех услуг
$services = [];
try {
    $stmt = $pdo->query("SELECT s.*, c.Name as category_name 
                         FROM Services s 
                         LEFT JOIN Category c ON s.Category = c.ID_category 
                         ORDER BY s.Name");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $services = [];
}

$page_title = "Управление услугами";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?> - СтройСервис</title>
    <link rel="stylesheet" href="../../i/Styles/main.css">
    <style>
        body {
            background-color: #F5F5F5;
        }
        
        .admin-layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }
        
        .admin-sidebar {
            background-color: #1A1A1A;
            color: #FFFFFF;
            padding: 20px;
        }
        
        .admin-logo {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #333;
        }
        
        .admin-logo span {
            color: #FFD700;
        }
        
        .admin-nav {
            list-style: none;
        }
        
        .admin-nav li {
            margin-bottom: 10px;
        }
        
        .admin-nav a {
            display: block;
            padding: 12px 15px;
            color: #CCCCCC;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .admin-nav a:hover,
        .admin-nav a.active {
            background-color: #FFD700;
            color: #1A1A1A;
        }
        
        .admin-nav a.logout {
            margin-top: 30px;
            background-color: #c62828;
            color: white;
            text-align: center;
        }
        
        .admin-nav a.logout:hover {
            background-color: #b71c1c;
        }
        
        .admin-content {
            padding: 30px;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #FFD700;
        }
        
        .admin-header h1 {
            color: #1A1A1A;
            font-size: 28px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-role {
            background-color: #FFD700;
            color: #1A1A1A;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .content-section {
            background-color: #FFFFFF;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 20px;
            margin-bottom: 20px;
            color: #1A1A1A;
            border-bottom: 2px solid #FFD700;
            padding-bottom: 10px;
        }
        
        .services-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .services-table th,
        .services-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #EEEEEE;
        }
        
        .services-table th {
            background-color: #F9F9F9;
            font-weight: 600;
            color: #333;
        }
        
        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            border: none;
        }
        
        .btn-primary {
            background-color: #FFD700;
            color: #1A1A1A;
        }
        
        .btn-danger {
            background-color: #c62828;
            color: white;
        }
        
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        
        .filter-bar {
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .filter-bar input,
        .filter-bar select {
            padding: 8px 12px;
            border: 1px solid #DDD;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .message {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border-left: 3px solid #28a745;
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 3px solid #dc3545;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: #FFFFFF;
            margin: 5% auto;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .close-modal {
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #999;
        }
        
        .close-modal:hover {
            color: #333;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #DDD;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .btn-submit {
            background-color: #FFD700;
            color: #1A1A1A;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .btn-submit:hover {
            background-color: #e6c200;
        }
        
        .relevance-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .relevance-yes {
            background-color: #d4edda;
            color: #155724;
        }
        
        .relevance-no {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Боковое меню -->
        <aside class="admin-sidebar">
            <div class="admin-logo">Строй<span>Сервис</span></div>
            
            <ul class="admin-nav">
                <li><a href="dashboard.php">📊 Dashboard</a></li>
                <?php if ($role === 'admin'): ?>
                    <li><a href="orders.php">📋 Заявки</a></li>
                    <li><a href="services.php" class="active">🛠️ Услуги</a></li>
                    <li><a href="categories.php">📁 Категории</a></li>
                    <li><a href="personnel.php">👥 Персонал</a></li>
                <?php else: ?>
                    <li><a href="orders.php">📋 Заявки</a></li>
                    <li><a href="services.php" class="active">🛠️ Услуги</a></li>
                    <li><a href="categories.php">📁 Категории</a></li>
                <?php endif; ?>
                <li><a href="reviews.php">⭐ Отзывы</a></li>
                <li><a href="../../index.php">🏠 На сайт</a></li>
                <li><a href="logout.php" class="logout">Выйти</a></li>
            </ul>
        </aside>
        
        <!-- Основной контент -->
        <main class="admin-content">
            <div class="admin-header">
                <h1>Управление услугами</h1>
                <div class="user-info">
                    <span><?= htmlspecialchars($user_fio) ?></span>
                    <span class="user-role"><?= $role === 'admin' ? 'Администратор' : 'Менеджер' ?></span>
                </div>
            </div>
            
            <?php if ($message): ?>
                <div class="message <?= $message_type ?>"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            
            <!-- Фильтры и кнопка добавления -->
            <div class="content-section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 class="section-title" style="margin-bottom: 0; border: none;">Все услуги (<?= count($services) ?>)</h2>
                    <?php if ($role === 'admin'): ?>
                        <button class="btn-small btn-success" onclick="openAddModal()">+ Добавить услугу</button>
                    <?php endif; ?>
                </div>
                
                <div class="filter-bar">
                    <input type="text" id="searchInput" placeholder="Поиск по названию..." onkeyup="filterTable()">
                    <select id="categoryFilter" onchange="filterTable()">
                        <option value="">Все категории</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['ID_category'] ?>"><?= htmlspecialchars($cat['Name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <?php if (empty($services)): ?>
                    <p>Услуги не найдены.</p>
                <?php else: ?>
                    <table class="services-table" id="servicesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Категория</th>
                                <th>Цена</th>
                                <th>Ед. изм.</th>
                                <th>Актуальна</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service): ?>
                                <tr data-category="<?= $service['Category'] ?>">
                                    <td>#<?= $service['ID_services'] ?></td>
                                    <td><?= htmlspecialchars($service['Name']) ?></td>
                                    <td><?= htmlspecialchars($service['category_name'] ?? 'Без категории') ?></td>
                                    <td><?= number_format($service['Price'], 2) ?> ₽</td>
                                    <td><?= htmlspecialchars($service['Unit']) ?></td>
                                    <td>
                                        <span class="relevance-badge <?= $service['Relevance'] === 'да' ? 'relevance-yes' : 'relevance-no' ?>">
                                            <?= $service['Relevance'] === 'да' ? 'Да' : 'Нет' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="../../pages/user/service_detail.php?id=<?= $service['ID_services'] ?>" class="btn-small btn-primary" target="_blank">Просмотр</a>
                                        <?php if ($role === 'admin'): ?>
                                            <button class="btn-small btn-primary" onclick="openEditModal(<?= htmlspecialchars(json_encode($service)) ?>)">Ред.</button>
                                            <button class="btn-small btn-danger" onclick="deleteService(<?= $service['ID_services'] ?>)">Удалить</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </main>
    </div>
    
    <!-- Модальное окно добавления/редактирования -->
    <div id="serviceModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Добавить услугу</h2>
            <form id="serviceForm" method="POST" action="">
                <input type="hidden" id="service_id" name="service_id" value="">
                
                <div class="form-group">
                    <label for="name">Название услуги *</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="category">Категория</label>
                    <select id="category" name="category">
                        <option value="">Без категории</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['ID_category'] ?>"><?= htmlspecialchars($cat['Name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="unit">Единица измерения *</label>
                    <input type="text" id="unit" name="unit" placeholder="например: м², шт., час" required>
                </div>
                
                <div class="form-group">
                    <label for="price">Цена (₽) *</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="relevance">Актуальна</label>
                    <select id="relevance" name="relevance">
                        <option value="да">Да</option>
                        <option value="Нет">Нет</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="photo">Фото услуги</label>
                    <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/gif,image/webp">
                    <small style="color: #666; display: block; margin-top: 5px;">Разрешенные форматы: JPEG, PNG, GIF, WebP. Макс. размер: 5MB</small>
                    <div id="photoPreview" style="margin-top: 10px;"></div>
                </div>
                
                <button type="submit" class="btn-submit">Сохранить</button>
            </form>
        </div>
    </div>
    
    <script>
        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toUpperCase();
            const categoryFilter = document.getElementById('categoryFilter').value;
            const table = document.getElementById('servicesTable');
            const tr = table.getElementsByTagName('tr');
            
            for (let i = 1; i < tr.length; i++) {
                const tdName = tr[i].getElementsByTagName('td')[1];
                const category = tr[i].getAttribute('data-category');
                
                let showRow = true;
                
                if (searchInput && tdName) {
                    const nameValue = tdName.textContent || tdName.innerText;
                    if (nameValue.toUpperCase().indexOf(searchInput) === -1) {
                        showRow = false;
                    }
                }
                
                if (categoryFilter && category !== categoryFilter) {
                    showRow = false;
                }
                
                tr[i].style.display = showRow ? '' : 'none';
            }
        }
        
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Добавить услугу';
            document.getElementById('serviceForm').reset();
            document.getElementById('service_id').value = '';
            document.getElementById('photoPreview').innerHTML = '';
            document.getElementById('serviceModal').style.display = 'block';
        }
        
        function openEditModal(service) {
            document.getElementById('modalTitle').textContent = 'Редактировать услугу';
            document.getElementById('service_id').value = service.ID_services;
            document.getElementById('name').value = service.Name;
            document.getElementById('category').value = service.Category || '';
            document.getElementById('description').value = service.Description || '';
            document.getElementById('unit').value = service.Unit;
            document.getElementById('price').value = service.Price;
            document.getElementById('relevance').value = service.Relevance;
            // Не заполняем поле photo, так как теперь это file input
            document.getElementById('photo').value = '';
            
            // Показываем текущее фото если оно есть
            const previewDiv = document.getElementById('photoPreview');
            if (service.Photo && service.Photo !== '') {
                previewDiv.innerHTML = '<div style="margin-top: 10px;"><img src="../../' + service.Photo + '" alt="Текущее фото" style="max-width: 200px; max-height: 200px; border-radius: 4px;"></div><small>Загрузите новое фото, чтобы заменить текущее</small>';
            } else {
                previewDiv.innerHTML = '';
            }
            
            document.getElementById('serviceModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('serviceModal').style.display = 'none';
        }
        
        function deleteService(id) {
            if (confirm('Вы уверены, что хотите удалить эту услугу?')) {
                window.location.href = '?action=delete&id=' + id;
            }
        }
        
        // Закрытие модального окна при клике вне его
        window.onclick = function(event) {
            const modal = document.getElementById('serviceModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
