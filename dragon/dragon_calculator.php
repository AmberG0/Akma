<?php
session_start();

$errors = [];

$name = trim($_POST['knight_name'] ?? '');
$class = $_POST['knight_class'] ?? '';
$email = trim($_POST['email'] ?? '');
$date = $_POST['battle_date'] ?? '';
$strength = (int)($_POST['strength_level'] ?? 0);
$confidence = (int)($_POST['confidence'] ?? 0);
$skill = $_POST['skill'] ?? '';
$equipment = $_POST['equipment'] ?? [];
// if (!is_array($equipment)) $equipment = [];
$dragon = $_POST['dragon_type'] ?? '';
$plan = trim($_POST['plan'] ?? '');
$battle_id = 'battle_001';

if ($class == '') {
    $errors['knight_class'] = "Выберите класс";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Неверный формат email";
}

if (strtotime($date) < time()) {
    $errors['battle_date'] = "Дата битвы не может быть в прошлом";
}

if ($strength < 1 || $strength > 100) {
    $errors['strength_level'] = "Уровень силы от 1 до 100";
}

if ($skill == '') {
    $errors['skill'] = "Выберите основной навык";
}

if (count($equipment) < 2) {
    $errors['equipment'] = "Выберите минимум 2 предмета экипировки";
}

if ($dragon == '') {
    $errors['dragon_type'] = "Выберите тип дракона";
}

$words = str_word_count($plan, 0, 'АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя');
if ($words < 10) {
    $errors['plan'] = "План должен содержать минимум 10 слов";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: dragon_form.php');
    exit();
}

$base = ($strength * 2) + ($confidence * 5);

$dragon_difficulty = 0;
if ($dragon == 'fire') $dragon_difficulty = 20;
else if ($dragon == 'ice') $dragon_difficulty = 15;
else if ($dragon == 'poison') $dragon_difficulty = 25;

$equipment_bonus = count($equipment) * 10;

$chance = 100 - $dragon_difficulty + $base + $equipment_bonus;
if ($chance > 100) $chance = 100;
if ($chance < 0) $chance = 0;

if ($chance > 80) {
    $advice = "Отличные шансы! Атакуйте смело!";
} else if ($chance >= 50) {
    $advice = "Хорошие шансы. Будьте осторожны!";
} else {
    $advice = "Шансы низкие. Подготовьтесь лучше!";
}

$class_name = '';
if ($class == 'warrior') {$class_name = 'Воин';}
else if ($class == 'paladin') {$class_name = 'Паладин';}
else if ($class == 'mage') {$class_name = 'Маг';}
else if ($class == 'archer') {$class_name = 'Лучник';}

$skill_name = '';
if ($skill == 'sword') {$skill_name = 'Мастерство меча';}
else if ($skill == 'magic') {$skill_name = 'Магия';}
else if ($skill == 'stealth') {$skill_name = 'Скрытность';}

$equipment_list = '';
if (in_array('sword', $equipment)) {$equipment_list .= 'Меч, ';}
if (in_array('shield', $equipment)) {$equipment_list .= 'Щит, ';}
if (in_array('armor', $equipment)) {$equipment_list .= 'Доспех, ';}
if (in_array('potion', $equipment)) {$equipment_list .= 'Зелье, ';}
$equipment_list = rtrim($equipment_list, ', ');
if ($equipment_list == '') {$equipment_list = 'Нет';}

$dragon_name = '';
if ($dragon == 'fire') {$dragon_name = 'Огненный';}
else if ($dragon == 'ice') {$dragon_name = 'Ледяной';}
else if ($dragon == 'poison') {$dragon_name = 'Ядовитый';}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отчет о подготовке к выживанию</title>
    <link rel="stylesheet" href="style/form.css">
</head>
<body>
    <h1>ОТЧЕТ О ПОДГОТОВКЕ К БИТВЕ С ДРАКОНОМ</h1>
    <div class="report">
    <p><strong>Рыцарь:</strong> <?= htmlspecialchars($name) ?> (<?= $class_name ?>)</p>
        <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
        <p><strong>Дата битвы:</strong> <?= htmlspecialchars($date) ?></p>
        <p><strong>Уровень силы:</strong> <?= $strength ?></p>
        <p><strong>Уверенность:</strong> <?= $confidence ?>/10</p>
        <p><strong>Навык:</strong> <?= $skill_name ?></p>
        <p><strong>Экипировка:</strong> <?= $equipment_list ?></p>
        <p><strong>Тип дракона:</strong> <?= $dragon_name ?></p>
        <p><strong>Длина плана:</strong> <?= $words ?> слов</p>
        <p><strong>ID битвы:</strong> <?= $battle_id ?></p>
        <p><strong>Шанс победы:</strong><?= $chance ?>%</strong></p>
        <p class="recommend"><?= $advice ?></p>
        <a href="dragon_form.php" style="color:#4b3f2f;">← Вернуться к форме</a>
    </div>
</body>
</html>