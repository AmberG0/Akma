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
<h1>КАЛЬКУЛЯТОР ШАНСОВ УСПЕХА КОСМИЧЕСКОЙ ЭКСПЕДИЦИИ</h1>

<form action="space_calculator.php" method="POST">
    <label>Имя астронавта</label>
    <input type="text" name="astronaut_name" required>

    <label>Роль на борту</label>
    <select name="role" required>
        <option value="">— Выберите роль —</option>
        <option value="pilot">Пилот</option>
        <option value="engineer">Инженер</option>
        <option value="scientist">Ученый</option>
        <option value="medic">Медик</option>
    </select>
    <?php if (isset($errors['role'])): ?>
        <div class="error"><?= htmlspecialchars($errors['role']) ?></div>
    <?php endif; ?>

    <label>Email для связи</label>
    <input type="email" name="email" required>
    <?php if (isset($errors['email'])): ?>
        <div class="error"><?= htmlspecialchars($errors['email']) ?></div>
    <?php endif; ?>

    <label>Дата старта миссии</label>
    <input type="date" name="launch_date" required>
    <?php if (isset($errors['launch_date'])): ?>
        <div class="error"><?= htmlspecialchars($errors['launch_date']) ?></div>
    <?php endif; ?>

    <label>Уровень подготовки (1–100)</label>
    <input type="number" name="training_level" min="1" max="100" required>
    <?php if (isset($errors['training_level'])): ?>
        <div class="error"><?= htmlspecialchars($errors['training_level']) ?></div>
    <?php endif; ?>

    <label>Уверенность в успехе (1–10)</label>
    <input type="range" name="confidence" min="1" max="10" required value="5">
    <span>5/10</span>

    <label>Основной навык</label>
    <div>
        <input type="radio" name="skill" value="navigation" id="nav">
        <label for="nav">Навигация</label><br>
        <input type="radio" name="skill" value="repair" id="rep">
        <label for="rep">Ремонт</label><br>
        <input type="radio" name="skill" value="research" id="res">
        <label for="res">Исследования</label>
    </div>
    <?php if (isset($errors['skill'])): ?>
        <div class="error"><?= htmlspecialchars($errors['skill']) ?></div>
    <?php endif; ?>

    <label>Снаряжение</label>
    <div>
        <input type="checkbox" name="equipment[]" value="spacesuit" id="suit">
        <label for="suit">Скафандр</label><br>
        <input type="checkbox" name="equipment[]" value="tools" id="tools">
        <label for="tools">Инструменты</label><br>
        <input type="checkbox" name="equipment[]" value="oxygen" id="oxy">
        <label for="oxygen">Кислород</label><br>
        <input type="checkbox" name="equipment[]" value="food" id="food">
        <label for="food">Пища</label>
    </div>
    <?php if (isset($errors['equipment'])): ?>
        <div class="error"><?= htmlspecialchars($errors['equipment']) ?></div>
    <?php endif; ?>

    <label>Тип миссии</label>
    <select name="mission_type" required>
        <option value="">— Выберите миссию —</option>
        <option value="lunar">Лунная</option>
        <option value="mars">Марсианская</option>
        <option value="orbital">Орбитальная</option>
    </select>
    <?php if (isset($errors['mission_type'])): ?>
        <div class="error"><?= htmlspecialchars($errors['mission_type']) ?></div>
    <?php endif; ?>

    <label>План миссии (минимум 10 слов)</label>
    <textarea name="plan" required rows="4"></textarea>
    <?php if (isset($errors['plan'])): ?>
        <div class="error"><?= htmlspecialchars($errors['plan']) ?></div>
    <?php endif; ?>

    <input type="hidden" name="mission_id" value="mission_001">

    <br><br>
    <input type="submit" value="РАССЧИТАТЬ ШАНСЫ УСПЕХА">
</form>

<?php
unset($_SESSION['errors'], $_SESSION['form_data']);
?>
</body>
</html>