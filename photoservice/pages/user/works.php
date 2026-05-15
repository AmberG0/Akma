<?php
session_start();
require_once '../../i/WebsiteBackend/db.php';

// Получение опубликованных отзывов
$reviews = [];
try {
    $stmt = $pdo->query("SELECT * FROM Reviews WHERE Is_published = 'да' ORDER BY Date_created DESC");
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log('Ошибка при загрузке отзывов: ' . $e->getMessage());
}

$page_title = "Наши работы";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?> - СтройСервис</title>
    <link rel="stylesheet" href="../../i/Styles/main.css">
    <style>
        .works-hero {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            padding: 60px 0;
            text-align: center;
        }
        
        .works-hero h1 {
            font-size: 42px;
            margin-bottom: 15px;
            color: #1A1A1A;
        }
        
        .works-hero p {
            font-size: 18px;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .works-section {
            padding: 60px 0;
            background-color: #FFFFFF;
        }
        
        .section-title {
            text-align: center;
            font-size: 32px;
            margin-bottom: 40px;
            color: #1A1A1A;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background-color: #FFD700;
            margin: 15px auto 0;
        }
        
        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .review-card {
            background: #F5F5F5;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .review-card:hover {
            transform: translateY(-5px);
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .review-author {
            font-weight: bold;
            font-size: 18px;
            color: #1A1A1A;
        }
        
        .review-date {
            color: #999;
            font-size: 14px;
        }
        
        .review-rating {
            color: #FFD700;
            font-size: 20px;
            margin-bottom: 15px;
        }
        
        .review-text {
            color: #333;
            line-height: 1.6;
            font-size: 15px;
        }
        
        .review-form-section {
            background-color: #F9F9F9;
            padding: 60px 0;
        }
        
        .review-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #1A1A1A;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #DDD;
            border-radius: 5px;
            font-size: 15px;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .rating-input {
            display: flex;
            gap: 10px;
            font-size: 30px;
        }
        
        .rating-input span {
            cursor: pointer;
            color: #DDD;
            transition: color 0.3s;
        }
        
        .rating-input span.active,
        .rating-input span:hover {
            color: #FFD700;
        }
        
        .btn-submit {
            background-color: #FFD700;
            color: #1A1A1A;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        
        .btn-submit:hover {
            background-color: #FFC700;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .no-reviews {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
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
                    Спасибо! Ваш отзыв отправлен на модерацию и будет опубликован после проверки.
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="container">
                <div class="alert alert-error">
                    При отправке отзыва произошла ошибка. Попробуйте позже.
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
</body>
</html>
