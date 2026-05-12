<?php
// inc/functions.php — ПОЛНОСТЬЮ РАБОЧАЯ ВЕРСИЯ

if (!function_exists('is_logged_in')) {

    session_start();
    require_once __DIR__ . '/../config/db.php';

    // ===================== АВТОРИЗАЦИЯ =====================
    function is_logged_in() {
        return isset($_SESSION['user_id']);
    }

    function is_admin() {
        return is_logged_in() && ($_SESSION['user_role'] ?? '') === 'admin';
    }

    function require_login() {
        if (!is_logged_in()) redirect('pages/login.php');
    }

    function require_admin() {
        if (!is_admin()) redirect('pages/login.php');
    }

    function redirect($url) {
        header("Location: $url");
        exit;
    }

    // ===================== КОРЗИНА =====================
    function add_to_cart($product_id, $quantity = 1) {
        $id = (int)$product_id;
        if ($id <= 0) return false;
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $quantity;
        return true;
    }

    function update_cart_item($product_id, $quantity) {
        $id = (int)$product_id;
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id] = $quantity;
        }
    }

    function remove_from_cart($product_id) {
        unset($_SESSION['cart'][(int)$product_id]);
    }

    function clear_cart() {
        unset($_SESSION['cart']);
    }

    function get_cart_items($pdo) {
        if (empty($_SESSION['cart'])) return [];
        $ids = array_keys($_SESSION['cart']);
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $stmt = $pdo->prepare("SELECT id, name, price, image FROM products WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        $items = $stmt->fetchAll();
        foreach ($items as &$item) {
            $item['quantity'] = $_SESSION['cart'][$item['id']];
            $item['subtotal'] = $item['price'] * $item['quantity'];
        }
        return $items;
    }

    function get_cart_count() {
        return array_sum($_SESSION['cart'] ?? []);
    }

    function get_cart_total($pdo) {
        $total = 0;
        foreach (get_cart_items($pdo) as $item) {
            $total += $item['subtotal'];
        }
        return $total;
    }

    function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

  
    function current_user($pdo) {
        if (!is_logged_in()) return null;
        $stmt = $pdo->prepare("SELECT id, fio, email, phone, avatar, address, role FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }
}


//  уведомление вместо alert
function notify($message, $type = 'success') {
    $class = $type === 'error' ? 'error' : 'success';
    echo "<div class='notification $class show' onclick='this.remove()'>$message</div>";
}
?>


