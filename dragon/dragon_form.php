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
    <h1>КАЛЬКУЛЯТОР ШАНСОВ ПОБЕДЫ НАД ДРАКОНОМ</h1>

    <form action="dragon_calculator.php" method="POST">
        <label>Имя рыцаря</label>
        <input type="text" name="knight_name" required>

        <label>Класс рыцаря</label>
        <select name="knight_class" required>
            <option value="">— Выберите класс —</option>
            <option value="warrior">Воин</option>
            <option value="paladin">Паладин</option>
            <option value="mage">Маг</option>
            <option value="archer">Лучник</option>
        </select>
        <?php if (isset($errors['knight_class'])): ?>
            <div class="error"><?= htmlspecialchars($errors['knight_class']) ?></div>
        <?php endif; ?>

        <label>Email для связи</label>
        <input type="email" name="email" required>
        <?php if (isset($errors['email'])): ?>
            <div class="error"><?= htmlspecialchars($errors['email']) ?></div>
        <?php endif; ?>

        <label>Дата битвы</label>
        <input type="date" name="battle_date" required>
        <?php if (isset($errors['battle_date'])): ?>
            <div class="error"><?= htmlspecialchars($errors['battle_date']) ?></div>
        <?php endif; ?>

        <label>Уровень силы (1–100)</label>
        <input type="number" name="strength_level" min="1" max="100" required>
        <?php if (isset($errors['strength_level'])): ?>
            <div class="error"><?= htmlspecialchars($errors['strength_level']) ?></div>
        <?php endif; ?>

        <label>Уверенность в победе (1–10)</label>
        <input type="range" name="confidence" min="1" max="10" required value="5">
        <span>5/10</span>

        <label>Основной навык</label>
        <div>
            <input type="radio" name="skill" value="sword" id="sword">
            <label for="sword">Мастерство меча</label><br>
            <input type="radio" name="skill" value="magic" id="magic">
            <label for="magic">Магия</label><br>
            <input type="radio" name="skill" value="stealth" id="stealth">
            <label for="stealth">Скрытность</label>
        </div>
        <?php if (isset($errors['skill'])): ?>
            <div class="error"><?= htmlspecialchars($errors['skill']) ?></div>
        <?php endif; ?>

        <label>Экипировка</label>
        <div>
            <input type="checkbox" name="equipment[]" value="sword" id="sw">
            <label for="sw">Меч</label><br>
            <input type="checkbox" name="equipment[]" value="shield" id="sh">
            <label for="sh">Щит</label><br>
            <input type="checkbox" name="equipment[]" value="armor" id="ar">
            <label for="ar">Доспех</label><br>
            <input type="checkbox" name="equipment[]" value="potion" id="po">
            <label for="po">Зелье</label>
        </div>
        <?php if (isset($errors['equipment'])): ?>
            <div class="error"><?= htmlspecialchars($errors['equipment']) ?></div>
        <?php endif; ?>

        <label>Тип дракона</label>
        <select name="dragon_type" required>
            <option value="">— Выберите дракона —</option>
            <option value="fire">Огненный</option>
            <option value="ice">Ледяной</option>
            <option value="poison">Ядовитый</option>
        </select>
        <?php if (isset($errors['dragon_type'])): ?>
            <div class="error"><?= htmlspecialchars($errors['dragon_type']) ?></div>
        <?php endif; ?>

        <label>План битвы (минимум 10 слов)</label>
        <textarea name="plan" required rows="4"></textarea>
        <?php if (isset($errors['plan'])): ?>
            <div class="error"><?= htmlspecialchars($errors['plan']) ?></div>
        <?php endif; ?>

        <input type="hidden" name="battle_id" value="battle_001">

        <br><br>
        <input type="submit" value="РАССЧИТАТЬ ШАНСЫ ПОБЕДЫ">
    </form>

    <?php
    unset($_SESSION['errors'], $_SESSION['form_data']);
    ?>
</body>
</html>