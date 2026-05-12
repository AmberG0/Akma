

<div id="container_header">
    <a href="main.php"><img src="../image/logo.png" alt="Logo"></a>
    
    <h1>«ТД &nbsp; <span style="color: #007BFF">Синергия</span>  &nbsp; »</h1>
    <div class="search_h">
        <input type="text" placeholder="Поиск по каталогу...">
        <button>🔍︎</button>
    </div>
    <div class="menu_h">
    <a href="../pages/catalog.php" class="catalog_btn">Каталог</a>
    
    <!-- Корзина со счётчиком -->
    <a href="../pages/basket.php" class="basket_link">
        <img src="../image/basket.png" alt="Корзина">
        <?php if (get_cart_count() > 0): ?>
            <span class="cart_counter"><?= get_cart_count() ?></span>
        <?php endif; ?>
    </a>
    
    <!-- Иконка профиля — умная! -->
    <?php if (is_logged_in()): ?>
        <a href="../pages/lk.php" title="Личный кабинет">
            <img src="../image/person.png" alt="Личный кабинет" class="profile_icon">
        </a>
    <?php else: ?>
        <a href="../pages/login.php" title="Войти">
            <img src="../image/person.png" alt="Войти" class="profile_icon">
        </a>
    <?php endif; ?>
</div>
    
</div>
