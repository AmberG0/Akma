/* ========================================
   Главный JavaScript файл (main.js)
   ======================================== */

document.addEventListener('DOMContentLoaded', function() {
    console.log('PhotoService - Главная страница загружена');
    
    // Инициализация всех модулей
    initThemeToggle();
    initHeroSlider();
});

// Функция для безопасного получения элемента
function getElement(selector) {
    const element = document.querySelector(selector);
    if (!element) {
        console.warn(`Элемент не найден: ${selector}`);
    }
    return element;
}
