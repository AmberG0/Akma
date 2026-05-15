-- ============================================
-- SQL запрос для создания таблицы Reviews
-- для системы отзывов сайта "Строй сервис"
-- ============================================

-- Создание таблицы отзывов
CREATE TABLE IF NOT EXISTS Reviews (
    ID_review INT AUTO_INCREMENT PRIMARY KEY,
    Client_name VARCHAR(255) NOT NULL,
    Review_text TEXT NOT NULL,
    Rating INT NOT NULL CHECK (Rating >= 1 AND Rating <= 5),
    Date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Is_published ENUM('да', 'Нет') DEFAULT 'Нет'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Добавление тестовых отзывов (опционально)
INSERT INTO Reviews (Client_name, Review_text, Rating, Is_published) VALUES
('Иванов Петр Сергеевич', 'Заказывал строительство забора на дачном участке. Работа выполнена качественно и в срок. Бригада работала профессионально, мусор за собой убрали. Рекомендую!', 5, 'да'),
('Смирнова Елена Владимировна', 'Обращалась по поводу укладки тротуарной плитки. Результатом довольна, плитка лежит ровно, выглядит красиво. Единственное - немного затянули сроки, но в целом хорошо.', 4, 'да'),
('Козлов Дмитрий Александрович', 'Заказывал земляные работы трактором. Все сделали быстро и аккуратно. Цена адекватная. Буду обращаться еще.', 5, 'да'),
('Морозова Ольга Игоревна', 'Осталась не очень довольна работой. Сделали нормально, но отношение персонала оставляло желать лучшего. Долго не могли согласовать время начала работ.', 3, 'нет');

-- Индекс для быстрого поиска опубликованных отзывов
CREATE INDEX idx_reviews_published ON Reviews(Is_published);
CREATE INDEX idx_reviews_date ON Reviews(Date_created DESC);

-- Комментарии к таблице
ALTER TABLE Reviews COMMENT 'Таблица отзывов клиентов о выполненных работах';
ALTER TABLE Reviews MODIFY COLUMN Client_name VARCHAR(255) COMMENT 'Имя клиента, оставившего отзыв';
ALTER TABLE Reviews MODIFY COLUMN Review_text TEXT COMMENT 'Текст отзыва';
ALTER TABLE Reviews MODIFY COLUMN Rating INT COMMENT 'Оценка от 1 до 5 звезд';
ALTER TABLE Reviews MODIFY COLUMN Date_created TIMESTAMP COMMENT 'Дата и время создания отзыва';
ALTER TABLE Reviews MODIFY COLUMN Is_published ENUM('да', 'Нет') COMMENT 'Статус публикации отзыва (да/Нет)';
