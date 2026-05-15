-- SQL для создания таблицы отзывов (Reviews)
-- Выполните этот запрос в phpMyAdmin или через консоль MySQL

CREATE TABLE Reviews (
    ID_review INT AUTO_INCREMENT PRIMARY KEY,
    Client_name VARCHAR(255) NOT NULL,
    Review_text TEXT NOT NULL,
    Rating INT NOT NULL CHECK (Rating >= 1 AND Rating <= 5),
    Date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Is_published ENUM('да', 'Нет') DEFAULT 'Нет',
    INDEX idx_published (Is_published),
    INDEX idx_date (Date_created)
);

-- Тестовые данные (опубликованные отзывы)
INSERT INTO Reviews (Client_name, Review_text, Rating, Is_published) VALUES
('Иван Петров', 'Отличная компания! Сделали ремонт в квартире быстро и качественно. Очень доволен результатом!', 5, 'да'),
('Мария Сидорова', 'Заказывала установку окон. Работа выполнена профессионально, менеджеры вежливые. Рекомендую!', 4, 'да'),
('Алексей Козлов', 'Строили дачный дом. Прораб внимательно следил за всеми этапами. Спасибо за качественный дом!', 5, 'да'),
('Елена Волкова', 'Делали стяжку пола. Всё понравилось, кроме небольших задержек по срокам. В целом хорошо.', 4, 'да');
