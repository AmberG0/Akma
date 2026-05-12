<?php
    include "header.php";
?>
<!DOCTYPE html>
<html lang="ru">
<body>
    <div id="content_container"></div> 

    <script>
        // Функция для загрузки карточек
        function loadContent(input = '') {
            fetch('WebsiteBackend/search.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'search_input=' + encodeURIComponent(input)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Проверяем, что приходит в ответ

                let html = '';

                const content = data.data;
                const current_page = 1; // можно заменить на динамическую переменную
                let render_amount;

                if (content.length < current_page * 10) {
                    render_amount = content.length;
                } else {
                    render_amount = current_page * 10;
                }

                for (let i = 0; i < render_amount; i++) {
                    const item = content[i];
                    const image = item.image || 'Images/logo_square.svg';
                    const title = item.title || 'Без названия';
                    const description = item.description || 'Без описания';
                    const content_id = item.content_id || item.id;

                    html += `
                    <form class='content' method='GET' action='content.php'>
                        <img class='content_image' src='${image}'>
                        <button class='content_button' name='post' value='${content_id}'>
                            <h1 class='content_header'>${title}</h1>
                            <p class='content_desc'>${description}</p>
                        </button>
                    </form>
                    `;
                }

                document.getElementById('content_container').innerHTML = html;
            })
            .catch(error => console.error('Ошибка:', error));
        }

        // Загружаем все карточки при открытии страницы
        document.addEventListener('DOMContentLoaded', function() {
            loadContent(); // вызываем без параметра — значит, ищем все записи
        });

        // Обработчик кнопки поиска
        document.getElementById('search_btn').addEventListener('click', function() {
            const input = document.getElementById('search_input').value;
            loadContent(input); // вызываем с параметром — поиск
        });
    </script> 

    <div class="footer_container">
        <?php include "footer.php";?>
    </div>
</body>
</html>