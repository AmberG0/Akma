<?php
    include "header.php";
    if ($_SESSION)

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_SESSION['user_id'];

        $content_title = strip_tags($_POST['title']);
        $content_description = strip_tags($_POST['description']);
        // $content_image = $_POST['image'];

        $variant1 = strip_tags($_POST['variant1']);
        $variant2 = strip_tags($_POST['variant2']);
        $variant3 = strip_tags($_POST['variant3']);
        $variant4 = strip_tags($_POST['variant4']);
        $photoPath = "";


        $read = $pdo->prepare("SELECT `content_id` FROM `content`");
        $read->execute();
        $content_id_count = count($read->fetchAll()) + 1;

        $directory_path = ("Public/" . $content_id_count . "/");
        $directory = mkdir($directory_path);

        if (!empty($_FILES['image']['name'])) {
            $fileName  = time() . "_" . basename($_FILES['image']['name']); // уникальное имя
            $target = $directory_path . $fileName;
        
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $photoPath = $target; // сохраняем путь к файлу для БД
            }
        }
        $stmt = $pdo->prepare("INSERT INTO `content`(`user_id`, `title`, `description`, `image`, `option_1_title`, `option_1_vote`, `option_2_title`, `option_2_vote`, `option_3_title`, `option_3_vote`, `option_4_title`, `option_4_vote`) VALUES (?, ?, ?, ?, ?, 0, ?, 0, ?, 0, ?, 0)");
        $stmt->execute([$user_id, $content_title, $content_description, $photoPath, $variant1, $variant2, $variant3, $variant4]);

        header("location: ../index.php");
    }

?>
<!DOCTYPE html>
<html lang="ru">
<body>
    <div class="background">
        <div class="post_container">
            <h1 class='auth_header'>Создать новый опрос</h1>
            <br>
            <form action="post.php" method="POST" class="auth_form" enctype="multipart/form-data">
                <h2 class="post_text">Название опроса</h2>
                <input class="auth_input" placeholder="Название опроса" type="text" name="title" required='true'>
                <h2 class="post_text">Описание </h2>
                <input class="auth_input" placeholder="Описание (необязательно)" type="text" name="description">
                <h2 class="post_text">Изображение</h2>
                <input type="file" class="post_image_button" accept="image/png, image/jpeg" name="image" >
                <br>
                <input class="post_input" placeholder="Вариант 1" type="text" name="variant1" required='true'>
                <input class="post_input" placeholder="Вариант 2" type="text" name="variant2" required='true'>
                <input class="post_input" placeholder="Вариант 3" type="text" name="variant3" required='true'>
                <input class="post_input" placeholder="Вариант 4" type="text" name="variant4" required='true'>

                <button class="register_button">Опубликовать</button>
            </form>
        </div>
    </div>
    <?php include "footer.php";?>
</body>
</html>