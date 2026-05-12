<?
session_start();
include("../logiс/bd.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION["user_id"];
    $course = $_POST["course"];
    $date = $_POST["date"];
    $pay = $_POST["pay"];

    $stmt = $pdo->prepare("INSERT INTO Orders (ID_user, Course, Date, State, Paymate) VALUES (?,?,?,?,?)");
    $stmt->execute([$user_id,  $course, $date, 'Новая', $pay]);
    $order = $stmt->fetch();

    header('location: main.php');
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание заявки</title>
</head>
<body>
    <form method="POST" action="Create_order.php">
        <p>Курс</p>
        <input type="text" name="course">
        <p>Дата</p>
        <input type="text" name="date">
        <p>Способ оплаты</p>
        <input type="radio" name="pay" value="cash">
        <p>Наличка</p>
        <input type="radio" name="pay" value="transfer">
        <p>Перевод</p>
        <button type="submit">Создать</button>
    </form>
</body>
</html>