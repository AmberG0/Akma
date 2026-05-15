-- Простая версия базы данных для сайта "Строй сервис"
-- Создано для учебной версии проекта

-- Таблица категорий услуг
CREATE TABLE Category (
    ID_category INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Description TEXT
);

-- Таблица услуг
CREATE TABLE Services (
    ID_services INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Description TEXT,
    Unit VARCHAR(50),
    Price FLOAT,
    Category INT,
    Relevance ENUM('да', 'Нет') DEFAULT 'да',
    Photo VARCHAR(255)
);

-- Таблица персонала
CREATE TABLE Personnel (
    ID_personal INT AUTO_INCREMENT PRIMARY KEY,
    Login VARCHAR(100) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Fio VARCHAR(255),
    Role ENUM('admin', 'manager') NOT NULL,
    Num_phone VARCHAR(20),
    Mail VARCHAR(255)
);

-- Таблица списка услуг в заявке
CREATE TABLE Services_tab (
    Service_tab_ID INT AUTO_INCREMENT PRIMARY KEY,
    Description TEXT,
    Data_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    Data_start DATETIME,
    Service_list_ID INT,
    Service_list_count TEXT,
    Count_pay FLOAT
);

-- Таблица заявок
CREATE TABLE Orders (
    ID_order INT AUTO_INCREMENT PRIMARY KEY,
    Client VARCHAR(255) NOT NULL,
    Num_phone VARCHAR(20),
    Mail VARCHAR(255),
    Service_tab_ID INT,
    Time_the_bell DATETIME,
    Type_pay ENUM('cash', 'bank') DEFAULT 'cash',
    Face_client VARCHAR(100),
    Accept_order_Per_ID INT,
    Other_inform TEXT,
    Status ENUM('новая', 'в работе', 'завершена', 'отменена') DEFAULT 'новая'
);

-- Таблица отзывов
CREATE TABLE Reviews (
    ID_review INT AUTO_INCREMENT PRIMARY KEY,
    Client_name VARCHAR(255) NOT NULL,
    Review_text TEXT NOT NULL,
    Rating INT NOT NULL,
    Date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Is_published ENUM('да', 'Нет') DEFAULT 'Нет'
);

-- Тестовые данные

-- Категории
INSERT INTO Category (Name, Description) VALUES
('Земляные работы', 'Услуги спецтехники'),
('Строительство', 'Строительные услуги'),
('Благоустройство', 'Работы по благоустройству');

-- Услуги
INSERT INTO Services (Name, Description, Unit, Price, Category, Relevance) VALUES
('Копка траншеи', 'Рытье траншей под коммуникации', 'м.пог.', 500, 1, 'да'),
('Планировка участка', 'Выравнивание территории трактором', 'сотка', 3000, 1, 'да'),
('Укладка плитки', 'Укладка тротуарной плитки', 'кв.м', 800, 3, 'да');

-- Персонал
INSERT INTO Personnel (Login, Password, Fio, Role, Num_phone, Mail) VALUES
('admin', 'password', 'Администратор Системы', 'admin', '+7 845 352-82-92', 'admin@stroyservice.ru'),
('manager', 'password', 'Менеджер Иванов', 'manager', '+7 845 352-82-93', 'manager@stroyservice.ru');

-- Отзывы
INSERT INTO Reviews (Client_name, Review_text, Rating, Is_published) VALUES
('Иванов Петр', 'Отличная работа! Рекомендую.', 5, 'да'),
('Смирнова Елена', 'Хорошо, но были небольшие задержки.', 4, 'да');
