<?
    session_start();
    include("../logiс/bd.php");
    if (!($_SESSION['role'])){
        header('location: login.php');
    };

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $num_order = $_POST['num_ord'];
    $state = $_POST['State'];

    $stmt = $pdo->prepare("UPDATE Orders SET State = ? WHERE ID = ?");
    $stmt->execute([$state, $num_order]);
    $orders = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Главная странциа</title>
</head>
<body>
    <?include('../block/head.php');
    // var_dump($_SESSION)?>
    <div id="content">
        <table>
            <thead>
                <tr>
                    <th scope="col">Номер</th>
                    <th scope="col">Заказчик</th>
                    <th scope="col">Курс</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Статус</th>
                    <th scope="col">способ оплаты</th>
                    <th scope="col">изменение</th>
                </tr>
            </thead>
            <tbody>
                <?
                    $user_id = $_SESSION['user_id'];
                    // $stmt = $pdo->prepare("SELECT * FROM Orders ");
                    $stmt = $pdo->prepare("SELECT * FROM Users INNER JOIN Orders ON Users.ID = Orders.ID_user");
                    $stmt->execute();
                    $orders = $stmt->fetchAll();
                    for ($i = 0; $i < count($orders); $i++){
                        echo('
                            <tbody>
                                <tr>
                                    <form action="admin.php" method="POST">
                                        <th>'.$orders[$i]['ID'].'</th>
                                        <th>'.$orders[$i]['Name'].'</th>
                                        <th>'.$orders[$i]['Course'].'</th>
                                        <th>'.$orders[$i]['Date'].'</th>

                                        <th>

                                            <select name="State">
                                                <option value="Новая" '.(($orders[$i]['State'] == "Новая") ? "Selected" : ' ').'>Новая</option>
                                                <option value="В работе" '.(($orders[$i]['State'] == "В работе") ? "Selected" : ' ').'>В работе</option>
                                                <option value="Выполнено" '.(($orders[$i]['State'] == "Выполнено") ? "Selected" : ' ').'>Выполнено</option>
                                            </select>
                                            
                                        </th>
                                        <th>'.$orders[$i]['Paymate'].'</th>
                                        <th>
                                            
                                                <button type="submit" name="num_ord" value="'.$orders[$i]['ID'].'">изменить</button>
                                            
                                        </th>
                                    </form>
                                </tr>
                            </tbody>
                        ');

                    }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>