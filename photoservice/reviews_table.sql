-- SQL запрос для создания таблицы отзывов (Reviews)
-- Выполните этот запрос в вашей базе данных construction_site

CREATE TABLE IF NOT EXISTS Reviews (
    ID_review INT AUTO_INCREMENT PRIMARY KEY,
    Client_name VARCHAR(255) NOT NULL,
    Review_text TEXT NOT NULL,
    Rating INT NOT NULL CHECK (Rating >= 1 AND Rating <= 5),
    Date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Is_published ENUM('да', 'Нет') DEFAULT 'Нет'
) ENGINE=InnoDB;

-- Индексы для оптимизации
CREATE INDEX idx_reviews_published ON Reviews(Is_published);
CREATE INDEX idx_reviews_date ON Reviews(Date_created DESC);

-- Тестовые данные (4 отзыва)
INSERT INTO Reviews (Client_name, Review_text, Rating, Is_published) VALUES
('Иван Петров', 'Отличная компания! Сделали всё качественно и в срок. Очень доволен результатом. Рекомендую всем!', 5, 'да'),
('Мария Сидорова', 'Заказывала уборку территории после строительства. Работа выполнена хорошо, но немного задержали сроки.', 4, 'да'),
('Алексей Козлов', 'Профессиональный подход к делу. Прораб всегда был на связи, рабочие вежливые. Цены адекватные.', 5, 'да'),
('Елена Новикова', 'Остались довольны сотрудничеством. Будем обращаться ещё.', 5, 'да');

-- Проверка данных
SELECT * FROM Reviews;
