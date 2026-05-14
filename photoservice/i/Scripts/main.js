// ========================================
// ГЛАВНЫЙ JS ФАЙЛ
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    // Инициализация слайдера
    initHeroSlider();
    
    // Инициализация переключения темы
    initThemeToggle();
    
    // Инициализация выбора города
    initCitySelector();
});

// ========================================
// СЛАЙДЕР В HERO SECTION
// ========================================

function initHeroSlider() {
    const sliderData = [
        {
            title: "Профессиональные строительные услуги",
            description: "ИП Барабарян Карен Аветики предлагает полный спектр строительных работ: от ремонта квартир до возведения зданий под ключ."
        },
        {
            title: "Ремонт любой сложности",
            description: "Косметический и капитальный ремонт помещений. Работаем с 2014 года, более 500 успешных проектов."
        },
        {
            title: "Строительство под ключ",
            description: "Возведение жилых и коммерческих зданий. Полный цикл работ от фундамента до отделки."
        },
        {
            title: "Фасадные работы",
            description: "Облицовка фасадов, утепление, декоративная штукатурка. Современные материалы и технологии."
        }
    ];

    const heroDescText = document.getElementById('hero-desc-text');
    const heroDescParagraph = document.querySelector('.hero-description p');
    const indicatorsContainer = document.getElementById('slider-indicators');
    const sliderImages = document.querySelectorAll('.slider-image');
    
    let currentSlide = 0;
    let slideInterval;

    // Создаем индикаторы
    sliderData.forEach((_, index) => {
        const indicator = document.createElement('span');
        indicator.classList.add('indicator');
        if (index === 0) indicator.classList.add('active');
        indicator.dataset.slide = index;
        indicator.addEventListener('click', () => goToSlide(index));
        indicatorsContainer.appendChild(indicator);
    });

    // Функция перехода к слайду
    function goToSlide(index) {
        currentSlide = index;
        
        // Обновляем индикаторы
        document.querySelectorAll('.indicator').forEach((ind, i) => {
            ind.classList.toggle('active', i === currentSlide);
        });
        
        // Обновляем текст
        if (heroDescText) {
            heroDescText.textContent = sliderData[currentSlide].title;
        }
        if (heroDescParagraph) {
            heroDescParagraph.textContent = sliderData[currentSlide].description;
        }
        
        // Сбрасываем интервал
        resetInterval();
    }

    // Автоматическое переключение
    function startAutoSlide() {
        slideInterval = setInterval(() => {
            currentSlide = (currentSlide + 1) % sliderData.length;
            goToSlide(currentSlide);
        }, 5000);
    }

    function resetInterval() {
        clearInterval(slideInterval);
        startAutoSlide();
    }

    // Запуск
    startAutoSlide();
}

// ========================================
// ПЕРЕКЛЮЧЕНИЕ ТЕМЫ
// ========================================

function initThemeToggle() {
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;
    
    // Проверяем сохраненную тему
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        body.classList.add('dark-theme');
        if (themeToggle) themeToggle.textContent = 'Светлая тема';
    }
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            body.classList.toggle('dark-theme');
            
            const isDark = body.classList.contains('dark-theme');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            this.textContent = isDark ? 'Светлая тема' : 'Темная тема';
        });
    }
}

// ========================================
// ВЫБОР ГОРОДА
// ========================================

function initCitySelector() {
    const citySelector = document.getElementById('city-selector');
    
    if (citySelector) {
        citySelector.addEventListener('click', function() {
            const cities = ['г.Энгельс', 'г.Саратов', 'г.Москва', 'г.Санкт-Петербург'];
            const currentCity = this.textContent;
            const currentIndex = cities.indexOf(currentCity);
            const nextIndex = (currentIndex + 1) % cities.length;
            this.textContent = cities[nextIndex];
            
            // Сохраняем выбор
            localStorage.setItem('selectedCity', cities[nextIndex]);
        });
        
        // Восстанавливаем сохраненный город
        const savedCity = localStorage.getItem('selectedCity');
        if (savedCity && cities.includes(savedCity)) {
            citySelector.textContent = savedCity;
        }
    }
}

// ========================================
// ФОРМА ЗАЯВКИ
// ========================================

function openOrderForm() {
    alert('Форма заявки будет реализована в следующем модуле!\n\nЗдесь клиент сможет:\n- Выбрать услуги\n- Посмотреть ориентировочную цену\n- Отправить заявку менеджеру');
}
