<?php 
require_once '../inc/functions.php'; 

// Получаем все товары для поиска (если нужен поиск по FAQ)
$search_query = trim($_GET['q'] ?? '');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ — Часто задаваемые вопросы — ТД Синергия</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include("../blocks/modal.php"); ?>
    <div id="main_container">
        <?php include("../blocks/header.php"); ?>

        <section id="faq_page">
            <h1 class="page_title">Часто задаваемые вопросы</h1>
            
            <div class="faq_search">
                <input type="text" id="faqSearch" placeholder="Поиск по вопросам..." onkeyup="filterFAQ()">
            </div>
            
            <div class="faq_container">
                <!-- Доставка -->
                <div class="faq_category">
                    <h2 class="faq_category_title">📦 Доставка и оплата</h2>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Какие способы доставки вы предлагаете?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>Мы осуществляем доставку следующими способами:</p>
                            <ul>
                                <li>Транспортные компании (Деловые Линии, ПЭК, СДЭК)</li>
                                <li>Курьерская доставка по Москве и области</li>
                                <li>Самовывоз со склада в Москве</li>
                                <li>Отправка в регионы через партнёрские службы доставки</li>
                            </ul>
                            <p>Стоимость доставки рассчитывается индивидуально в зависимости от веса, габаритов и региона доставки.</p>
                        </div>
                    </div>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Сколько стоит доставка?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>Стоимость доставки зависит от нескольких факторов:</p>
                            <ul>
                                <li>Расстояние до пункта назначения</li>
                                <li>Вес и габариты груза</li>
                                <li>Выбранный способ доставки</li>
                            </ul>
                            <p>Для расчёта точной стоимости свяжитесь с нашим менеджером по телефону +7 (800) 123-45-67 или воспользуйтесь калькулятором при оформлении заказа.</p>
                        </div>
                    </div>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Какие способы оплаты доступны?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>Мы принимаем оплату следующими способами:</p>
                            <ul>
                                <li>Банковской картой на сайте (Visa, MasterCard, МИР)</li>
                                <li>Безналичный расчёт для юридических лиц</li>
                                <li>Наличными при самовывозе</li>
                                <li>Оплата при получении (для некоторых регионов)</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Можно ли оплатить заказ при получении?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>Да, оплата при получении доступна для заказов стоимостью до 50 000 рублей в следующих городах: Москва, Санкт-Петербург, Екатеринбург, Новосибирск. Для других регионов возможность оплаты при получении уточняйте у менеджера.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Товары -->
                <div class="faq_category">
                    <h2 class="faq_category_title">🔧 Товары и наличие</h2>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Вся ли продукция сертифицирована?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>Да, вся наша продукция имеет необходимые сертификаты соответствия ГОСТ и другим стандартам качества. Копии сертификатов можно запросить у менеджера или скачать в карточке товара.</p>
                        </div>
                    </div>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Как проверить наличие товара?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>Информация о наличии обновляется в реальном времени на сайте. Если товар есть в наличии, это будет указано в карточке товара. Также вы можете связаться с нами для уточнения информации по конкретным позициям.</p>
                        </div>
                    </div>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Можно ли заказать товар под заказ?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>Да, мы принимаем заказы на позиции, которых нет в наличии. Срок поставки зависит от производителя и обычно составляет от 3 до 14 рабочих дней. Предоплата для таких заказов обязательна.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Возврат -->
                <div class="faq_category">
                    <h2 class="faq_category_title">↩️ Возврат и гарантия</h2>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Как вернуть товар?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>Возврат товара возможен в течение 14 дней с момента получения при сохранении товарного вида и упаковки. Для оформления возврата:</p>
                            <ol>
                                <li>Заполните заявление на возврат в личном кабинете</li>
                                <li>Упакуйте товар в оригинальную упаковку</li>
                                <li>Передайте курьеру или отправьте транспортной компанией</li>
                            </ol>
                            <p>Деньги будут возвращены на счёт в течение 5-10 рабочих дней после получения товара.</p>
                        </div>
                    </div>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Какая гарантия на продукцию?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>Гарантийный срок зависит от типа продукции и производителя. Обычно гарантия составляет от 12 до 36 месяцев. Подробную информацию о гарантии можно найти в документации к товару или уточнить у менеджера.</p>
                        </div>
                    </div>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Что делать, если товар повреждён при доставке?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>При получении товара обязательно проверьте его целостность. Если обнаружены повреждения:</p>
                            <ul>
                                <li>Не подписывайте акт приёма без отметки о повреждениях</li>
                                <li>Сфотографируйте повреждения упаковки и товара</li>
                                <li>Свяжитесь с нами в течение 24 часов</li>
                            </ul>
                            <p>Мы организуем замену товара или вернём деньги за свой счёт.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Личный кабинет -->
                <div class="faq_category">
                    <h2 class="faq_category_title">👤 Личный кабинет и заказы</h2>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Как зарегистрироваться на сайте?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>Для регистрации нажмите на иконку профиля в шапке сайта и выберите «Регистрация». Заполните форму, указав ФИО, email и пароль. После подтверждения email вы сможете войти в личный кабинет.</p>
                        </div>
                    </div>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Как отслеживать статус заказа?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>Статус заказа отображается в личном кабинете в разделе «Мои заказы». Также вы будете получать уведомления об изменении статуса на email и по SMS (если указан телефон).</p>
                        </div>
                    </div>
                    
                    <div class="faq_item">
                        <button class="faq_question">
                            Можно ли изменить заказ после оформления?
                            <span class="faq_arrow">▼</span>
                        </button>
                        <div class="faq_answer">
                            <p>Изменения в заказ можно внести в течение 1 часа после оформления через личный кабинет. После этого свяжитесь с менеджером по телефону. Если заказ уже отправлен, изменения невозможны.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include("../blocks/footer.php"); ?>
    </div>
    
    <script>
        function filterFAQ() {
            const searchInput = document.getElementById('faqSearch').value.toLowerCase();
            const items = document.querySelectorAll('.faq-item');
            
            items.forEach(item => {
                const question = item.querySelector('.faq-question').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                
                if (question.includes(searchInput) || answer.includes(searchInput)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
        
        // Аккордеон для FAQ
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', () => {
                const answer = button.nextElementSibling;
                const arrow = button.querySelector('.faq-arrow');
                
                // Закрываем другие
                document.querySelectorAll('.faq-answer').forEach(other => {
                    if (other !== answer) {
                        other.style.maxHeight = null;
                        other.previousElementSibling.querySelector('.faq-arrow').style.transform = 'rotate(0deg)';
                    }
                });
                
                // Переключаем текущий
                if (answer.style.maxHeight) {
                    answer.style.maxHeight = null;
                    arrow.style.transform = 'rotate(0deg)';
                } else {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    arrow.style.transform = 'rotate(180deg)';
                }
            });
        });
    </script>
</body>
</html>
