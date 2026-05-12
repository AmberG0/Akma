<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пункты выдачи — ТД Синергия</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include("../blocks/modal.php"); ?>
    <div id="main_container">
        <?php include("../blocks/header.php"); ?>

        <section id="pvz_page">
            <h1 class="page_title">Пункты выдачи заказов</h1>

            <div class="pvz_wrapper">
                <!-- Большая карта слева -->
                <div class="pvz_map">
                    <img src="../image/map_big.png" alt="Карта ПВЗ">
                </div>

                <!-- Карточки ПВЗ справа -->
                <div class="pvz_list">
                    <div class="pvz_card">
                        <img src="../image/pvz1.jpg" alt="Фото пункта выдачи">
                        <h3>Адрес, режим работы, телефон пункта выдачи, время работы</h3>
                    </div>
                    <div class="pvz_card">
                        <img src="../image/pvz2.jpg" alt="Фото пункта выдачи">
                        <h3>Адрес, режим работы, телефон пункта выдачи, время работы</h3>
                    </div>
                    <div class="pvz_card">
                        <img src="../image/pvz3.jpg" alt="Фото пункта выдачи">
                        <h3>Адрес, режим работы, телефон пункта выдачи, время работы</h3>
                    </div>
                    <div class="pvz_card">
                        <img src="../image/pvz4.jpg" alt="Фото пункта выдачи">
                        <h3>Адрес, режим работы, телефон пункта выдачи, время работы</h3>
                    </div>
                </div>
            </div>
        </section>

        <?php include("../blocks/footer.php"); ?>
    </div>
</body>
</html>