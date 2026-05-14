/**
 * Основной JavaScript файл
 * ИП Барбарян К.А.
 * Специальность 09.02.07
 */

document.addEventListener('DOMContentLoaded', function() {
    // Инициализация темной темы
    initTheme();
    
    // Инициализация выбора города
    initCitySelector();
    
    // Инициализация слайдера (если есть на странице)
    initSlider();
});

/**
 * Переключение темной темы
 */
function initTheme() {
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;
    
    // Проверяем сохраненную тему
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        body.classList.add('dark-theme');
        if (themeToggle) {
            themeToggle.textContent = 'Светлая тема';
        }
    }
    
    // Обработчик переключения
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            body.classList.toggle('dark-theme');
            
            if (body.classList.contains('dark-theme')) {
                localStorage.setItem('theme', 'dark');
                themeToggle.textContent = 'Светлая тема';
            } else {
                localStorage.setItem('theme', 'light');
                themeToggle.textContent = 'Темная тема';
            }
        });
    }
}

/**
 * Выбор города (циклическое переключение)
 */
function initCitySelector() {
    const cityBtn = document.getElementById('city-selector');
    if (!cityBtn) return;
    
    const cities = [
        'г. Энгельс',
        'г. Саратов',
        'г. Москва',
        'г. Санкт-Петербург'
    ];
    
    let currentIndex = 0;
    
    // Устанавливаем текущий город из localStorage
    const savedCity = localStorage.getItem('city');
    if (savedCity && cities.includes(savedCity)) {
        cityBtn.textContent = savedCity;
        currentIndex = cities.indexOf(savedCity);
    }
    
    cityBtn.addEventListener('click', function() {
        currentIndex = (currentIndex + 1) % cities.length;
        const newCity = cities[currentIndex];
        cityBtn.textContent = newCity;
        localStorage.setItem('city', newCity);
        
        // Здесь можно добавить AJAX запрос для получения данных по городу
        console.log('Выбран город:', newCity);
    });
}

/**
 * Слайдер для Hero секции
 */
function initSlider() {
    const sliderContainer = document.querySelector('.hero-slider');
    if (!sliderContainer) return;
    
    const indicators = document.querySelectorAll('.indicator');
    const images = document.querySelectorAll('.slider-image');
    const descriptionText = document.getElementById('hero-description-text');
    
    if (indicators.length === 0) return;
    
    let currentSlide = 0;
    const slideInterval = 5000; // 5 секунд
    
    // Данные для слайдов (заглушки, позже будут из БД)
    const slidesData = [
        {
            title: 'Строительные работы',
            description: 'Профессиональное выполнение строительных работ любой сложности. Более 15 лет опыта.'
        },
        {
            title: 'Земляные работы',
            description: 'Копка траншей, котлованов, планировка участков специализированной техникой.'
        },
        {
            title: 'Благоустройство',
            description: 'Комплексное благоустройство территорий. Озеленение, мощение, установка ограждений.'
        },
        {
            title: 'Аренда спецтехники',
            description: 'Предоставление спецтехники с операторами. Тракторы, экскаваторы, погрузчики.'
        }
    ];
    
    function showSlide(index) {
        // Обновляем индикаторы
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('active', i === index);
        });
        
        // Обновляем изображения (если есть)
        if (images.length > 0) {
            images.forEach((img, i) => {
                img.classList.toggle('active', i === index);
            });
        }
        
        // Обновляем текст описания
        if (descriptionText && slidesData[index]) {
            descriptionText.textContent = slidesData[index].description;
            
            // Обновляем заголовок
            const titleElement = document.querySelector('.hero-description h2');
            if (titleElement) {
                titleElement.textContent = slidesData[index].title;
            }
        }
        
        currentSlide = index;
    }
    
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % slidesData.length;
        showSlide(nextIndex);
    }
    
    // Добавляем обработчики на индикаторы
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            showSlide(index);
            resetTimer();
        });
    });
    
    // Автоматическое переключение
    let timer = setInterval(nextSlide, slideInterval);
    
    function resetTimer() {
        clearInterval(timer);
        timer = setInterval(nextSlide, slideInterval);
    }
    
    // Показываем первый слайд
    showSlide(0);
}

/**
 * Добавление услуги в подбор (корзину)
 * Будет использоваться на странице каталога
 */
function addToCart(serviceId, serviceName, servicePrice) {
    // Получаем текущую корзину из localStorage
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    
    // Проверяем, есть ли уже такая услуга
    const existingItem = cart.find(item => item.id === serviceId);
    
    if (existingItem) {
        alert('Эта услуга уже добавлена в подбор');
        return false;
    }
    
    // Добавляем новую услугу
    cart.push({
        id: serviceId,
        name: serviceName,
        price: servicePrice,
        quantity: 1
    });
    
    // Сохраняем в localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    
    // Обновляем счетчик в шапке (если есть)
    updateCartCount();
    
    alert(`Услуга "${serviceName}" добавлена в подбор`);
    return true;
}

/**
 * Обновление счетчика корзины
 */
function updateCartCount() {
    const cartCountElement = document.querySelector('.cart-count');
    if (!cartCountElement) return;
    
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const totalCount = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    cartCountElement.textContent = totalCount;
    
    if (totalCount > 0) {
        cartCountElement.style.display = 'inline-block';
    } else {
        cartCountElement.style.display = 'none';
    }
}

/**
 * Очистка корзины
 */
function clearCart() {
    localStorage.removeItem('cart');
    updateCartCount();
}

/**
 * Удаление услуги из корзины
 */
function removeFromCart(serviceId) {
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    cart = cart.filter(item => item.id !== serviceId);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    
    // Перерисовываем таблицу корзины (если мы на странице корзины)
    if (typeof renderCartTable === 'function') {
        renderCartTable();
    }
}

/**
 * Отправка заявки
 * @param {Object} formData - данные формы
 * @returns {Promise}
 */
async function submitRequest(formData) {
    try {
        const response = await fetch('/photoservice/i/WebsiteBackend/submit_request.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            return { success: true, message: result.message };
        } else {
            return { success: false, message: result.message || 'Ошибка при отправке заявки' };
        }
    } catch (error) {
        console.error('Ошибка отправки заявки:', error);
        return { success: false, message: 'Ошибка соединения с сервером' };
    }
}

// Вызываем обновление счетчика при загрузке страницы
document.addEventListener('DOMContentLoaded', updateCartCount);
