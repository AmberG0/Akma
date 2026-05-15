-- Исправленный SQL-запрос для добавления поля Status в таблицу Orders
-- Убрано IF NOT EXISTS (не поддерживается для ALTER TABLE ADD COLUMN в некоторых версиях MySQL)

ALTER TABLE Orders 
ADD COLUMN Status ENUM('новая', 'в работе', 'выполнена', 'отменена') DEFAULT 'новая' AFTER Other_inform;

-- Обновление существующих заявок (если есть)
UPDATE Orders SET Status = 'новая' WHERE Status IS NULL OR Status = '';
