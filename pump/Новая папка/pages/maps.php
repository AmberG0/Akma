<?require_once '../inc/functions.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\style\normalize.css">
    <link rel="stylesheet" href="..\style\style.css">
    <title>TD Sinergia</title>
</head>
<body>
    <div id="main_container">
        <!-- Шапка -->
        <?include("..\blocks/header.php")?>
        <!-- Содержание -->
        <div id="catalog_content">
            <div id="maps_block">
                <script id="maps" type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A2fe3a4364d092446adfdff310c5afac4bf068b4babe2be355db2171440b532c1&amp;width=643&amp;height=615&amp;lang=ru_RU&amp;scroll=true&amp;border-radius: 38px"></script>
            </div>
            <div id="menu_card_point">
                <div class="card_point">
                    <img src="" alt="">
                    <p>Адрес, режим работы, телефон горячей линии, телефон пункта выдачи, время работы</p>
                </div>
                <div class="card_point">
                    <img src="" alt="">
                    <p>Адрес, режим работы, телефон горячей линии, телефон пункта выдачи, время работы</p>
                </div>
                <div class="card_point">
                    <img src="" alt="">
                    <p>Адрес, режим работы, телефон горячей линии, телефон пункта выдачи, время работы</p>
                </div>
                <div class="card_point">
                    <img src="" alt="">
                    <p>Адрес, режим работы, телефон горячей линии, телефон пункта выдачи, время работы</p>
                </div>
            </div>
        </div>    
        <!-- Подвал -->
        <?include("..\blocks/footer.php")?>
    </div>
</body>

</html>