<!-- Верхняя тонкая панель -->
<div class="top-bar">
    <div class="top-bar-left">
        <a href="#" class="top-link">О нас</a>
        <span class="separator">|</span>
        <a href="#" class="top-link">Наша политика</a>
        <span class="separator">|</span>
        <a href="#" class="top-link">Информация для заказчиков</a>
        <span class="separator">|</span>
        <button id="theme-toggle" class="top-link theme-btn">Темная тема</button>
    </div>
    <div class="top-bar-right">
        <span class="city-selector">г.Энгельс</span>
    </div>
</div>

<!-- Основная навигационная панель -->
<header class="main-header">
    <div class="header-container">
        <div class="admin-btn-wrapper">
            <?php if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['admin', 'manager'])): ?>
                <a href="../admin/dashboard.php" class="admin-btn">Админ кнопка</a>
            <?php endif; ?>
        </div>
        
        <a href="main.php" class="logo">Лого</a>
        
        <a href="#" class="nav-link catalog-link">Каталог</a>
        
        <span class="brand-text">Наш дивиз</span>
        
        <a href="#" class="btn btn-primary request-btn">Оставить заявку</a>
    </div>
</header>
