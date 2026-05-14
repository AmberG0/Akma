/* ========================================
   Переключатель темы (theme-toggle.js)
   Светлая / Темная тема
   ======================================== */

function initThemeToggle() {
    const themeBtn = getElement('#theme-toggle');
    
    if (!themeBtn) {
        console.warn('Theme toggle: кнопка не найдена');
        return;
    }
    
    // Проверяем сохраненную тему в localStorage
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-theme');
        themeBtn.textContent = 'Светлая тема';
    }
    
    // Обработчик клика
    themeBtn.addEventListener('click', function() {
        document.body.classList.toggle('dark-theme');
        
        // Сохраняем выбор пользователя
        if (document.body.classList.contains('dark-theme')) {
            localStorage.setItem('theme', 'dark');
            themeBtn.textContent = 'Светлая тема';
        } else {
            localStorage.setItem('theme', 'light');
            themeBtn.textContent = 'Темная тема';
        }
    });
}
