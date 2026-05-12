<?php
session_start();

$errors = [];

$name = trim($_POST['survivor_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$stamina = (int)($_POST['stamina_level'] ?? '');
$date = $_POST['start_date'] ?? '';
$shelter = $_POST['shelter_type'] ?? '';
$resources = $_POST['resources'] ?? [];
if (!is_array($resources)) $resources = [];
$plan = trim($_POST['plan'] ?? '');
$confidence = (int)($_POST['confidence'] ?? '');
$scenario = 'survival_001';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Неверный формат email";
}

if (!is_numeric($stamina) || $stamina < 1 || $stamina > 50) {
    $errors['stamina_level'] = "Уровень выносливости должен быть от 1 до 50";
}

if (strtotime($date) < strtotime('today')) {
    $errors['start_date'] = "Дата начала не может быть в прошлом";
}

if ($shelter == '') {
    $errors['shelter_type'] = "Выберите тип укрытия";
}

if (count($resources) == 0) {
    $errors['resources'] = "Выберите хотя бы один ресурс";
}

$words = str_word_count($plan, 0, 'АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя');
if ($words < 8) {
    $errors['plan'] = "План должен содержать минимум 8 слов";
}

if (!is_numeric($confidence) || $confidence < 1 || $confidence > 10) {
    $errors['confidence'] = "Укажите уверенность от 1 до 10";
}

if (count($errors) > 0) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: survival_form.php');
    exit();
}

$base_chance = ($stamina * 3) + ($confidence * 4);

$shelter_bonus = 0;
if ($shelter == 'bunker'){
    $shelter_bonus = 15;
}
else if ($shelter == 'camp'){
    $shelter_bonus = 10;
}
else if ($shelter == 'ruins'){
    $shelter_bonus = 5;
}

$resources_bonus = count($resources) * 5;

$chance = $base_chance + $shelter_bonus + $resources_bonus;
if ($chance > 100) $chance = 100;

if ($chance > 80) {
    $advice = "Отличные шансы! Вы готовы к апокалипсису!";
} else if ($chance >= 50) {
    $advice = "Неплохие шансы. Укрепите оборону!";
} else {
    $advice = "Шансы низкие. Найдите больше ресурсов!";
}

$resources_list = '';
if (in_array('weapons', $resources)){
    $resources_list .= 'Оружие, ';
}
if (in_array('food', $resources)){
    $resources_list .= 'Еда, ';
}
if (in_array('medicine', $resources)){
    $resources_list .= 'Медикаменты, ';
}
if ($resources_list == ''){
    $resources_list = 'Нет';
}

if ($shelter == 'bunker'){
    $shelter_name = 'Бункер';
}
else if ($shelter == 'camp'){
    $shelter_name = 'Лагерь';
}
else if ($shelter == 'ruins'){
    $shelter_name = 'Руины';
}
else {$shelter_name = 'Неизвестно';}

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
    <h1>ОТЧЕТ ШАНСОВ ВЫЖИВАНИЯ В ПОСТАПОКАЛИПТИЧЕСКОМ МИРЕ</h1>
    <div class="report">
        <p><strong>Выживший:</strong> <?= htmlspecialchars($name) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
        <p><strong>Дата начала:</strong> <?= htmlspecialchars($date) ?></p>
        <p><strong>Уровень выносливости:</strong> <?= $stamina ?></p>
        <p><strong>Уверенность:</strong> <?= $confidence ?></p>
        <p><strong>Укрытие:</strong> <?= $shelter_name ?></p>
        <p><strong>Ресурсы:</strong> <?= $resources_list ?></p>
        <p><strong>Длина плана:</strong> <?= $words ?> слов</p>
        <p><strong>ID сценария:</strong> <?= $scenario ?></p>
        <p><strong>Шанс выживания:</strong> <?= $chance ?>%</p>
        <p class="recommend"><?= $advice ?></p>
        <a href="survival_form.php" style="color:#4b3f2f;">← Вернуться к форме</a>
    </div>
</body>
</html>