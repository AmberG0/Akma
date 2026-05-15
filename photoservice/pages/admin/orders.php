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

// Получаем все заявки
try {
    $stmt = $pdo->query("
        SELECT o.ID_order, o.Client, o.Num_phone, o.Mail, o.Time_the_bell, 
               o.Type_pay, o.Face_client, o.Other_inform, o.Status,
               st.Description as service_name, st.Service_list_count, st.Count_pay,
               p.Fio as manager_name, p.ID_personal as manager_id
        FROM Orders o
        JOIN Services_tab st ON o.Service_tab_ID = st.Service_tab_ID
        LEFT JOIN Personnel p ON o.Accept_order_Per_ID = p.ID_personal
        ORDER BY o.Time_the_bell DESC
    ");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    error_log('Ошибка при загрузке заявок: ' . $e->getMessage());
    $orders = [];
}

$page_title = "Управление заявками";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?> - СтройСервис</title>
    <link rel="stylesheet" href="../../i/Styles/main.css">
    <style>
        /* Стили для страницы заявок */
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

        .filter-bar {
            margin-bottom: 20px;
        }

        .filter-bar input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #DDDDDD;
            border-radius: 4px;
            font-size: 14px;
        }

        .filter-bar input:focus {
            outline: none;
            border-color: #FFD700;
            box-shadow: 0 0 0 2px rgba(255, 215, 0, 0.2);
        }

        .content-section {
            background-color: #FFFFFF;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 20px;
            margin-bottom: 20px;
            color: #1A1A1A;
            border-bottom: 2px solid #FFD700;
            padding-bottom: 10px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #FFFFFF;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .orders-table thead {
            background-color: var(--primary-dark);
            color: var(--text-light);
        }

        .orders-table th,
        .orders-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .orders-table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .orders-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        /* Выделение строк */
        .order-row-new {
            background-color: #fff3cd !important;
            border-left: 4px solid #FFD700;
            animation: pulse-new 2s infinite;
        }

        .order-row-no-manager {
            background-color: #f8d7da !important;
            border-left: 4px solid #dc3545;
        }

        .order-row-normal {
            background-color: #FFFFFF;
        }

        @keyframes pulse-new {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 215, 0, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(255, 215, 0, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 215, 0, 0);
            }
        }

        /* Бейджи статусов */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-badge-new {
            background-color: #FFD700;
            color: #1A1A1A;
        }

        .status-badge-no-manager {
            background-color: #dc3545;
            color: #FFFFFF;
        }

        .status-badge-assigned {
            background-color: #28a745;
            color: #FFFFFF;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: #FFD700;
            color: #1A1A1A;
            border: none;
        }

        .btn-primary:hover {
            background-color: #e6c200;
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
                    <li><a href="orders.php" class="active">📋 Заявки</a></li>
                    <li><a href="services.php">🛠️ Услуги</a></li>
                    <li><a href="categories.php">📁 Категории</a></li>
                    <li><a href="personnel.php">👥 Персонал</a></li>
                <?php else: ?>
                    <li><a href="orders.php" class="active">📋 Заявки</a></li>
                    <li><a href="services.php">🛠️ Услуги</a></li>
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
                <h1>Управление заявками</h1>
                <div class="user-info">
                    <span><?= htmlspecialchars($user_fio) ?></span>
                    <span class="user-role"><?= $role === 'admin' ? 'Администратор' : 'Менеджер' ?></span>
                </div>
            </div>
            
            <!-- Фильтры -->
            <div class="filter-bar">
                <input type="text" id="searchInput" placeholder="Поиск по клиенту или телефону..." onkeyup="filterTable()">
            </div>
            
            <!-- Таблица заявок -->
            <div class="content-section">
                <h2 class="section-title">Все заявки (<?= count($orders) ?>)</h2>
                
                <?php if (empty($orders)): ?>
                    <p>Заявок пока нет.</p>
                <?php else: ?>
                    <table class="orders-table" id="ordersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Клиент</th>
                                <th>Телефон</th>
                                <th>Email</th>
                                <th>Услуга</th>
                                <th>Дата/Время</th>
                                <th>Оплата</th>
                                <th>Менеджер</th>
                                <th>Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <?php
                                    // Определяем класс строки
                                    $row_class = 'order-row-normal';
                                    $status_badge = '';
                                    
                                    // Новая заявка (Status = 'новая')
                                    if (isset($order['Status']) && $order['Status'] === 'новая') {
                                        $row_class = 'order-row-new';
                                        $status_badge = '<span class="status-badge status-badge-new">Новая</span> ';
                                    }
                                    // Заявка без менеджера
                                    if (empty($order['manager_id'])) {
                                        $row_class = 'order-row-no-manager';
                                        $status_badge = '<span class="status-badge status-badge-no-manager">Без менеджера</span> ';
                                    }
                                    // Заявка с менеджером
                                    if (!empty($order['manager_id']) && (!isset($order['Status']) || $order['Status'] !== 'новая')) {
                                        $status_badge = '<span class="status-badge status-badge-assigned">В работе</span> ';
                                    }
                                ?>
                                <tr class="<?= $row_class ?>">
                                    <td>#<?= $order['ID_order'] ?></td>
                                    <td><?= htmlspecialchars($order['Client']) ?></td>
                                    <td><?= htmlspecialchars($order['Num_phone']) ?></td>
                                    <td><?= htmlspecialchars($order['Mail']) ?></td>
                                    <td><?= htmlspecialchars($order['service_name']) ?></td>
                                    <td><?= $order['Time_the_bell'] ? date('d.m.Y H:i', strtotime($order['Time_the_bell'])) : 'Не указано' ?></td>
                                    <td><?= $order['Type_pay'] === 'cash' ? 'Наличные' : 'Безнал' ?></td>
                                    <td>
                                        <?= $status_badge ?>
                                        <?= $order['manager_name'] ? htmlspecialchars($order['manager_name']) : '<em style="color: #dc3545;">Не назначен</em>' ?>
                                    </td>
                                    <td>
                                        <a href="order_view.php?id=<?= $order['ID_order'] ?>" class="btn-small btn-primary">Просмотр</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </main>
    </div>
    
    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('ordersTable');
            const tr = table.getElementsByTagName('tr');
            
            for (let i = 1; i < tr.length; i++) {
                const tdClient = tr[i].getElementsByTagName('td')[1];
                const tdPhone = tr[i].getElementsByTagName('td')[2];
                
                if (tdClient || tdPhone) {
                    const clientValue = tdClient.textContent || tdClient.innerText;
                    const phoneValue = tdPhone.textContent || tdPhone.innerText;
                    
                    if (clientValue.toUpperCase().indexOf(filter) > -1 || 
                        phoneValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</body>
</html>
