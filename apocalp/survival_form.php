<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    unset($_SESSION['errors'], $_SESSION['form_data']);
}

$errors = $_SESSION['errors'] ?? [];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/form.css">
    <title>Калькулятор</title>
</head>
<body>
    <h1>КАЛЬКУЛЯТОР ШАНСОВ ВЫЖИВАНИЯ В ПОСТАПОКАЛИПТИЧЕСКОМ МИРЕ</h1>

    <form action="survival_calculator.php" method="POST">
        <label>Имя выжившего</label>
        <input type="text" name="survivor_name" required>

        <label>Email для связи</label>
        <input type="email" name="email" required>
        <?php if (isset($errors['email'])): ?>
            <div class="error"><?= htmlspecialchars($errors['email']) ?></div>
        <?php endif; ?>

        <label>Уровень выносливости (1–50)</label>
        <input type="number" name="stamina_level" min="1" max="50" required>
        <?php if (isset($errors['stamina_level'])): ?>
            <div class="error"><?= htmlspecialchars($errors['stamina_level']) ?></div>
        <?php endif; ?>

        <label>Дата начала выживания</label>
        <input type="date" name="start_date" required>
        <?php if (isset($errors['start_date'])): ?>
            <div class="error"><?= htmlspecialchars($errors['start_date']) ?></div>
        <?php endif; ?>

        <label>Тип укрытия</label>
        <select name="shelter_type" required>
            <option value="">— Выберите укрытие —</option>
            <option value="bunker">Бункер</option>
            <option value="camp">Лагерь</option>
            <option value="ruins">Руины</option>
        </select>
        <?php if (isset($errors['shelter_type'])): ?>
            <div class="error"><?= htmlspecialchars($errors['shelter_type']) ?></div>
        <?php endif; ?>

        <label>Ресурсы</label>
        <div id="resurse">
            <div class="resurse_select">
                <input type="checkbox" name="resources[]" id="weapons" value="weapons">
                <label for="weapons">Оружие</label>
            </div>
            <div class="resurse_select">
                <input type="checkbox" name="resources[]" id="food" value="food">
                <label for="food">Еда</label>
            </div>
            <div class="resurse_select">
                <input type="checkbox" name="resources[]" id="medicine" value="medicine">
                <label for="medicine">Медикаменты</label>
            </div>
        </div>
        <?php if (isset($errors['resources'])): ?>
            <div class="error"><?= htmlspecialchars($errors['resources']) ?></div>
        <?php endif; ?>

        <label>План выживания (минимум 8 слов)</label>
        <textarea name="plan" required rows="4"></textarea>
        <?php if (isset($errors['plan'])): ?>
            <div class="error"><?= htmlspecialchars($errors['plan']) ?></div>
        <?php endif; ?>

        <label>Уверенность в выживании (1–10)</label>
        <input type="range" name="confidence" min="1" max="10" required value="5">
        <span>5/10</span>

        <input type="hidden" name="scenario_id" value="survival_001">

        <br><br>
        <input type="submit" value="ВЫПОЛНИТЬ ПОДСЧЕТ">
    </form>

    <?php
    unset($_SESSION['errors'], $_SESSION['form_data']);
    ?>
</body>
</html>