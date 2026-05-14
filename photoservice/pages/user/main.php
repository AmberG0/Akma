<?php
/**
 * Главная страница сайта
 * ИП Барбарян Карен Аветикович
 */

$pageTitle = 'СтройУслуги - Главная | ИП Барбарян К.А.';

include '../includes/header.php';
?>

<!-- Hero секция -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-slider">
                <!-- Заглушка для изображения (позже будут реальные фото) -->
                <div class="slider-placeholder">
                    <svg width="100" height="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 16L8.586 11.414C8.96106 11.0391 9.46967 10.8284 10 10.8284C10.5303 10.8284 11.0389 11.0391 11.414 11.414L16 16M14 14L15.586 12.414C15.9611 12.0391 16.4697 11.8284 17 11.8284C17.5303 11.8284 18.0389 12.0391 18.414 12.414L20 14M14 8H14.01M6 20H18C19.1046 20 20 19.1046 20 18V6C20 4.89543 19.1046 4 18 4H6C4.89543 4 4 4.89543 4 6V18C4 19.1046 4.89543 20 6 20Z" stroke="#FFD700" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="slider-indicators">
                    <span class="indicator active" data-slide="0"></span>
                    <span class="indicator" data-slide="1"></span>
                    <span class="indicator" data-slide="2"></span>
                    <span class="indicator" data-slide="3"></span>
                </div>
            </div>
            <div class="hero-description">
                <h2>Строительные работы</h2>
                <p id="hero-description-text">Профессиональное выполнение строительных работ любой сложности. Более 15 лет опыта.</p>
                <button class="cta-button" onclick="location.href='/pages/user/services.php'">Смотреть услуги</button>
            </div>
        </div>
    </div>
</section>

<!-- О компании -->
<section class="about" id="about">
    <div class="container">
        <h2>О компании</h2>
        <div class="about-content">
            <p><strong>ИП Барбарян Карен Аветикович</strong> — надежный партнер в сфере строительных услуг с 2007 года.</p>
            <p>Мы специализируемся на выполнении широкого спектра строительных работ: от земляных работ до комплексного благоустройства территорий. Наша команда состоит из квалифицированных специалистов, использующих современную технику и передовые технологии.</p>
            <p><strong>Наш адрес:</strong> 413124, Саратовская обл., г. Энгельс, пр-д 1-й Студенческий, д. 2а</p>
            <p><strong>Телефон:</strong> +7 845 352-82-92</p>
            <p><strong>Режим работы:</strong> Пн–Пт, 8:30–17:00</p>
        </div>
    </div>
</section>

<?php
include '../includes/footer.php';
?>
