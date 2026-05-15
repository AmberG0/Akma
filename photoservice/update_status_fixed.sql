-- Исправленный SQL запрос для добавления столбца Status в таблицу Orders
-- Сначала проверяем существует ли столбец, если нет - добавляем

ALTER TABLE Orders 
ADD COLUMN Status ENUM('новая', 'в работе', 'выполнена', 'отменена') DEFAULT 'новая' AFTER Other_inform;

-- Обновляем существующие записи на 'новая'
UPDATE Orders SET Status = 'новая' WHERE Status IS NULL OR Status = '';
