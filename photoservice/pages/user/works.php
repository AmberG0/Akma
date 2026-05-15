<?php
session_start();
require_once '../../i/WebsiteBackend/db.php';

// Получение опубликованных отзывов
$reviews = [];
try {
    // Случайная выборка отзывов при каждом заходе
    $stmt = $pdo->query("SELECT * FROM Reviews WHERE Is_published = 'да' ORDER BY RAND()");
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log('Ошибка при загрузке отзывов: ' . $e->getMessage());
}

$page_title = "Наши работы";
include 'includes/header.php';
?>

<!-- Hero секция -->
<section class="works-hero">
    <div class="container">
        <h1>Наши работы и отзывы</h1>
        <p>Посмотрите примеры выполненных проектов и узнайте, что говорят наши клиенты</p>
    </div>
</section>

<!-- Секция с отзывами -->
<section class="works-section">
    <h2 class="section-title">Отзывы клиентов</h2>
    
    <?php if (empty($reviews)): ?>
        <div class="no-reviews">
            <p>Пока нет опубликованных отзывов. Будьте первым!</p>
        </div>
    <?php else: ?>
        <div class="reviews-grid">
            <?php foreach ($reviews as $review): ?>
                <div class="review-card">
                    <div class="review-header">
                        <span class="review-author"><?= htmlspecialchars($review['Client_name']) ?></span>
                        <span class="review-date"><?= date('d.m.Y', strtotime($review['Date_created'])) ?></span>
                    </div>
                    <div class="review-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?= $i <= $review['Rating'] ? '★' : '☆' ?>
                        <?php endfor; ?>
                    </div>
                    <p class="review-text"><?= nl2br(htmlspecialchars($review['Review_text'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Форма добавления отзыва -->
<section class="review-form-section">
    <h2 class="section-title">Оставить отзыв</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="container">
            <div class="alert alert-success">
                ✓ Спасибо! Ваш отзыв отправлен на модерацию и будет опубликован после проверки.
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="container">
            <div class="alert alert-error">
                ✗ При отправке отзыва произошла ошибка. Попробуйте позже.
            </div>
        </div>
    <?php endif; ?>
    
    <form class="review-form" method="POST" action="submit_review.php">
        <div class="form-group">
            <label for="client_name">Ваше имя *</label>
            <input type="text" id="client_name" name="client_name" required placeholder="Иван Иванов">
        </div>
        
        <div class="form-group">
            <label for="rating">Оценка *</label>
            <div class="rating-input" id="ratingInput">
                <span data-value="1">★</span>
                <span data-value="2">★</span>
                <span data-value="3">★</span>
                <span data-value="4">★</span>
                <span data-value="5">★</span>
            </div>
            <input type="hidden" id="rating" name="rating" value="5" required>
        </div>
        
        <div class="form-group">
            <label for="review_text">Текст отзыва *</label>
            <textarea id="review_text" name="review_text" required placeholder="Расскажите о вашем опыте работы с нами..."></textarea>
        </div>
        
        <button type="submit" class="btn-submit">Отправить отзыв</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>

<script>
    // Интерактивный рейтинг
    const ratingSpans = document.querySelectorAll('.rating-input span');
    const ratingInput = document.getElementById('rating');
    
    ratingSpans.forEach(span => {
        span.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            ratingInput.value = value;
            
            ratingSpans.forEach((s, index) => {
                if (index < value) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
    });
    
    // Инициализация рейтинга
    ratingSpans.forEach(s => s.classList.add('active'));
</script>
