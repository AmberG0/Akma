<?
    session_start();
    include("../logiс/bd.php");
    if (!isset($_SESSION['user_id'])){
        header('location: login.php');
    };


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
    var_dump($_SESSION)?>
    <div id="content">
        <table>
            <thead>
                <tr>
                    <th scope="col">Название услуги</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Статус</th>
                </tr>
            </thead>
            <tbody>
                <?
                    $user_id = $_SESSION['user_id'];
                    $stmt = $pdo->prepare("SELECT * FROM Orders WHERE ID_user = ?");
                    $stmt->execute([$user_id]);
                    $orders = $stmt->fetchAll();
                    for ($i = 0; $i < count($orders); $i++){
                        echo('
                            <tbody>
                                <tr>
                                    <th>'.$orders[$i]['Course'].'</th>
                                    <th>'.$orders[$i]['Date'].'</th>
                                    <th>'.$orders[$i]['State'].'</th>
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