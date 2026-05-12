<?php
session_start();
require_once 'i/WebsiteBackend/config.php';

// Обработка формы через AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    if ($_POST['action'] === 'subscribe') {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Сохраняем в сессию для демонстрации
            if (!isset($_SESSION['subscribers'])) {
                $_SESSION['subscribers'] = [];
            }
            $_SESSION['subscribers'][] = [
                'email' => $email,
                'date' => date('Y-m-d H:i:s')
            ];
            
            echo json_encode([
                'success' => true,
                'message' => 'Вы успешно подписались!',
                'count' => count($_SESSION['subscribers'])
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Некорректный email'
            ]);
        }
        exit;
    }
    
    if ($_POST['action'] === 'get_stats') {
        $stats = [
            'visitors' => $_SESSION['visitors_count'] ?? rand(100, 500),
            'subscribers' => count($_SESSION['subscribers'] ?? []),
            'projects' => 12
        ];
        echo json_encode($stats);
        exit;
    }
}

// Увеличиваем счетчик посетителей
if (!isset($_SESSION['visitors_count'])) {
    $_SESSION['visitors_count'] = rand(100, 500);
}
$_SESSION['visitors_count']++;

$page_title = "NeonTech - Технологии Будущего";
include 'i/WebsiteBackend/header.php';
?>

<main class="main-content">
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title glitch" data-text="NeonTech">NeonTech</h1>
            <p class="hero-subtitle">Инновационные решения для цифровой эпохи</p>
            <button class="btn-primary" id="exploreBtn">Исследовать</button>
        </div>
        <div class="hero-bg"></div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <h2 class="section-title">Наши достижения</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-number" data-target="0" id="visitorsStat">0</span>
                    <span class="stat-label">Посетителей</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number" data-target="0" id="subscribersStat">0</span>
                    <span class="stat-label">Подписчиков</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number" data-target="12">0</span>
                    <span class="stat-label">Проектов</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Преимущества</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Скорость</h3>
                    <p>Молниеносная работа всех систем</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3>Безопасность</h3>
                    <p>Защита данных на высшем уровне</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎨</div>
                    <h3>Дизайн</h3>
                    <p>Современный и интуитивный интерфейс</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🚀</div>
                    <h3>Масштаб</h3>
                    <p>Готовность к любым нагрузкам</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Demo -->
    <section class="demo-section">
        <div class="container">
            <h2 class="section-title">Интерактивное Демо</h2>
            <div class="demo-container">
                <div class="demo-controls">
                    <button class="demo-btn" data-color="#13eed4">Cyan</button>
                    <button class="demo-btn" data-color="#ff006e">Pink</button>
                    <button class="demo-btn" data-color="#7b2cbf">Purple</button>
                    <button class="demo-btn" data-color="#00f5d4">Mint</button>
                </div>
                <div class="demo-display" id="demoDisplay">
                    <p>Нажмите на кнопку выше</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Subscribe Form -->
    <section class="subscribe-section">
        <div class="container">
            <h2 class="section-title">Подписаться на новости</h2>
            <form class="subscribe-form" id="subscribeForm">
                <input type="email" name="email" placeholder="Ваш email" required class="form-input">
                <button type="submit" class="btn-primary">Подписаться</button>
            </form>
            <div class="form-message" id="formMessage"></div>
        </div>
    </section>
</main>

<?php include 'i/WebsiteBackend/footer.php'; ?>
