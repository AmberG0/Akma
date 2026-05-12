/**
 * NeonTech - Основной JavaScript файл
 * Vanilla JS с fetch API для работы с PHP бэкендом
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Инициализация всех модулей
    initMobileMenu();
    initSmoothScroll();
    initStatsCounter();
    initDemoSection();
    initSubscribeForm();
    initExploreButton();
    
    // Загрузка статистики при загрузке страницы
    loadStats();
});

/**
 * Мобильное меню
 */
function initMobileMenu() {
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const nav = document.querySelector('.nav');
    
    if (!mobileBtn || !nav) return;
    
    mobileBtn.addEventListener('click', function() {
        nav.classList.toggle('active');
        
        // Анимация кнопок
        const spans = mobileBtn.querySelectorAll('span');
        if (nav.classList.contains('active')) {
            spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
            spans[1].style.opacity = '0';
            spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
        } else {
            spans[0].style.transform = 'none';
            spans[1].style.opacity = '1';
            spans[2].style.transform = 'none';
        }
    });
}

/**
 * Плавный скролл по якорным ссылкам
 */
function initSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                // Закрываем мобильное меню при клике
                document.querySelector('.nav')?.classList.remove('active');
            }
        });
    });
}

/**
 * Анимация счетчиков статистики
 */
function initStatsCounter() {
    const statNumbers = document.querySelectorAll('.stat-number[data-target]');
    
    const animateCounter = (element) => {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                element.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target.toLocaleString();
            }
        };
        
        updateCounter();
    };
    
    // Intersection Observer для анимации при скролле
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    statNumbers.forEach(stat => observer.observe(stat));
}

/**
 * Интерактивное демо - смена цвета
 */
function initDemoSection() {
    const demoBtns = document.querySelectorAll('.demo-btn');
    const demoDisplay = document.getElementById('demoDisplay');
    
    if (!demoDisplay) return;
    
    demoBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const color = this.getAttribute('data-color');
            const colorName = this.textContent;
            
            // Меняем стили дисплея
            demoDisplay.style.borderColor = color;
            demoDisplay.style.boxShadow = `0 0 30px ${color}40`;
            demoDisplay.innerHTML = `
                <p style="color: ${color}; font-size: 24px; font-weight: 600;">
                    Выбран цвет: ${colorName}
                </p>
                <p style="margin-top: 10px; color: var(--text-secondary);">
                    HEX: ${color}
                </p>
            `;
            
            // Анимация кнопок
            demoBtns.forEach(b => b.style.background = 'transparent');
            demoBtns.forEach(b => b.style.color = 'var(--text-primary)');
            this.style.background = color;
            this.style.color = '#0a0a0f';
        });
    });
}

/**
 * Форма подписки с AJAX отправкой
 */
function initSubscribeForm() {
    const form = document.getElementById('subscribeForm');
    const messageDiv = document.getElementById('formMessage');
    
    if (!form || !messageDiv) return;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const emailInput = form.querySelector('input[name="email"]');
        const email = emailInput.value.trim();
        const submitBtn = form.querySelector('button[type="submit"]');
        
        if (!email) {
            showMessage('Введите email', 'error');
            return;
        }
        
        // Блокируем кнопку
        submitBtn.disabled = true;
        submitBtn.textContent = 'Отправка...';
        
        try {
            const formData = new FormData();
            formData.append('action', 'subscribe');
            formData.append('email', email);
            
            const response = await fetch('index.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                showMessage(data.message, 'success');
                emailInput.value = '';
                
                // Обновляем статистику
                updateSubscribersCount(data.count);
            } else {
                showMessage(data.message, 'error');
            }
        } catch (error) {
            console.error('Ошибка:', error);
            showMessage('Произошла ошибка. Попробуйте позже.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Подписаться';
        }
        
        function showMessage(text, type) {
            messageDiv.textContent = text;
            messageDiv.className = `form-message ${type}`;
            
            setTimeout(() => {
                messageDiv.className = 'form-message';
            }, 5000);
        }
    });
}

/**
 * Обновление счетчика подписчиков
 */
function updateSubscribersCount(count) {
    const subscribersStat = document.getElementById('subscribersStat');
    if (subscribersStat) {
        subscribersStat.setAttribute('data-target', count);
        subscribersStat.textContent = count.toLocaleString();
    }
}

/**
 * Загрузка статистики с сервера
 */
async function loadStats() {
    try {
        const formData = new FormData();
        formData.append('action', 'get_stats');
        
        const response = await fetch('index.php', {
            method: 'POST',
            body: formData
        });
        
        const stats = await response.json();
        
        // Обновляем счетчики
        const visitorsStat = document.getElementById('visitorsStat');
        const subscribersStat = document.getElementById('subscribersStat');
        
        if (visitorsStat && stats.visitors) {
            visitorsStat.setAttribute('data-target', stats.visitors);
        }
        
        if (subscribersStat && stats.subscribers !== undefined) {
            subscribersStat.setAttribute('data-target', stats.subscribers);
        }
        
    } catch (error) {
        console.error('Ошибка загрузки статистики:', error);
    }
}

/**
 * Кнопка "Исследовать"
 */
function initExploreButton() {
    const exploreBtn = document.getElementById('exploreBtn');
    
    if (!exploreBtn) return;
    
    exploreBtn.addEventListener('click', function() {
        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            const headerOffset = 80;
            const elementPosition = statsSection.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
            
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    });
}

/**
 * Утилита для debounce
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Параллакс эффект для hero секции
 */
window.addEventListener('scroll', debounce(function() {
    const hero = document.querySelector('.hero');
    const scrolled = window.pageYOffset;
    
    if (hero && scrolled < window.innerHeight) {
        const heroContent = hero.querySelector('.hero-content');
        if (heroContent) {
            heroContent.style.transform = `translateY(${scrolled * 0.3}px)`;
            heroContent.style.opacity = 1 - (scrolled / window.innerHeight);
        }
    }
}, 10));
