/* ========================================
   Слайдер для Hero секции (hero-slider.js)
   Синхронизация изображения и описания
   ======================================== */

function initHeroSlider() {
    const sliderContainer = getElement('#slider-container');
    const descriptionText = getElement('#description-text');
    
    if (!sliderContainer || !descriptionText) {
        console.warn('Hero slider: элементы не найдены');
        return;
    }
    
    // Массив объектов: изображение + описание
    const sliderData = [
        {
            image: 'i/Images/slide1.jpg',
            description: 'Профессиональная фотосъемка мероприятий'
        },
        {
            image: 'i/Images/slide2.jpg',
            description: 'Портретная съемка высокого качества'
        },
        {
            image: 'i/Images/slide3.jpg',
            description: 'Предметная съемка для каталогов'
        },
        {
            image: 'i/Images/slide4.jpg',
            description: 'Свадебная фотосъемка'
        }
    ];
    
    let currentIndex = 0;
    const intervalTime = 4000; // 4 секунды
    
    // Функция обновления слайда
    function updateSlide() {
        const slide = sliderData[currentIndex];
        
        // Создаем изображение или используем заглушку
        sliderContainer.innerHTML = '';
        const img = document.createElement('img');
        img.src = slide.image;
        img.alt = slide.description;
        img.onerror = function() {
            // Если изображение не загрузилось, показываем заглушку
            sliderContainer.innerHTML = '<div class="slide-placeholder">Фото услуги ' + (currentIndex + 1) + '</div>';
        };
        sliderContainer.appendChild(img);
        
        // Обновляем описание
        descriptionText.textContent = slide.description;
        
        // Переход к следующему слайду
        currentIndex = (currentIndex + 1) % sliderData.length;
    }
    
    // Первый запуск
    updateSlide();
    
    // Автоматическая смена каждые 4 секунды
    setInterval(updateSlide, intervalTime);
}
