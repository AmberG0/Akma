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
include 'includes/admin_header.php';
?>

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

<?php include 'includes/admin_footer.php'; ?>
