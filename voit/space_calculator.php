<?php
session_start();

$errors = [];

$name = trim($_POST['astronaut_name'] ?? '');
$role = $_POST['role'] ?? '';
$email = trim($_POST['email'] ?? '');
$date = $_POST['launch_date'] ?? '';
$training = (int)($_POST['training_level'] ?? 0);
$confidence = (int)($_POST['confidence'] ?? 0);
$skill = $_POST['skill'] ?? '';
$equipment = $_POST['equipment'] ?? [];
// if (!is_array($equipment)){
//     $equipment = [];
// }
$mission_type = $_POST['mission_type'] ?? '';
$plan = trim($_POST['plan'] ?? '');
$mission_id = 'mission_001';

if ($role == '') {
    $errors['role'] = "Выберите роль";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Неверный формат email";
}

if (strtotime($date) < strtotime('today')) {
    $errors['launch_date'] = "Дата старта не может быть в прошлом";
}

if ($training < 1 || $training > 100) {
    $errors['training_level'] = "Уровень подготовки от 1 до 100";
}

if ($skill == '') {
    $errors['skill'] = "Выберите основной навык";
}

if (count($equipment) < 2) {
    $errors['equipment'] = "Выберите минимум 2 элемента снаряжения";
}

if ($mission_type == '') {
    $errors['mission_type'] = "Выберите тип миссии";
}

$words = str_word_count($plan, 0, 'АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя');
if ($words < 10) {
    $errors['plan'] = "План должен содержать минимум 10 слов";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: space_form.php');
    exit();
}

$base = ($training * 2) + ($confidence * 5);

$mission_bonus = 0;
if ($mission_type == 'lunar') $mission_bonus = 10;
else if ($mission_type == 'mars') $mission_bonus = 20;
else if ($mission_type == 'orbital') $mission_bonus = 5;

$equipment_bonus = count($equipment) * 8;

$chance = $base + $mission_bonus + $equipment_bonus;
if ($chance > 100) $chance = 100;

if ($chance > 80) {
    $advice = "Отличные шансы! Запускайтесь смело!";
} else if ($chance >= 50) {
    $advice = "Хорошие шансы. Проверьте все системы!";
} else {
    $advice = "Шансы низкие. Усильте подготовку!";
}

$role_name = '';
if ($role == 'pilot') {$role_name = 'Пилот';}
else if ($role == 'engineer') {$role_name = 'Инженер';}
else if ($role == 'scientist') {$role_name = 'Ученый';}
else if ($role == 'medic') {$role_name = 'Медик';}

$skill_name = '';
if ($skill == 'navigation') {$skill_name = 'Навигация';}
else if ($skill == 'repair') {$skill_name = 'Ремонт';}
else if ($skill == 'research') {$skill_name = 'Исследования';}

$equipment_list = '';
if (in_array('spacesuit', $equipment)) {$equipment_list .= 'Скафандр, ';}
if (in_array('tools', $equipment)) {$equipment_list .= 'Инструменты, ';}
if (in_array('oxygen', $equipment)) {$equipment_list .= 'Кислород, ';}
if (in_array('food', $equipment)) {$equipment_list .= 'Пища, ';}
$equipment_list = rtrim($equipment_list, ', ');
if ($equipment_list == '') {$equipment_list = 'Нет';}

$mission_name = '';
if ($mission_type == 'lunar') {$mission_name = 'Лунная';}
else if ($mission_type == 'mars') {$mission_name = 'Марсианская';}
else if ($mission_type == 'orbital') {$mission_name = 'Орбитальная';}
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
    <h1>ОТЧЕТ О ПОДГОТОВКЕ К ЭКСПЕДИЦИИ</h1>
    <div class="report">
        <p><strong>Астронавт:</strong> <?= htmlspecialchars($name) ?> (<?= $role_name ?>)</p>
        <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
        <p><strong>Дата старта:</strong> <?= htmlspecialchars($date) ?></p>
        <p><strong>Уровень подготовки:</strong> <?= $training ?></p>
        <p><strong>Уверенность:</strong> <?= $confidence ?>/10</p>
        <p><strong>Навыки:</strong> <?= $skill_name ?></p>
        <p><strong>Снаряжение:</strong> <?= $equipment_list ?></p>
        <p><strong>Тип миссии:</strong> <?= $mission_name ?></p>
        <p><strong>Длина плана:</strong> <?= $words ?> слов</p>
        <p><strong>ID миссии:</strong> <?= $mission_id ?></p>
        <p><strong>Шанс успеха:</strong> <?= $chance ?>%</strong></p>
        <p class="recommend"><?= $advice ?></p>
        <a href="space_form.php">← Новая миссия</a>
    </div>
</body>
</html>