<?php
    session_start();
    require_once("database.php");
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $submitAction = $_POST['submitAction'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $option = isset($_POST['option']);
        
        if ($option){$option = "checked";};

        if ($submitAction == "delete"){
                $content_id = $_POST['id_content'];

                $prep = $pdo->prepare("DELETE FROM `content`  WHERE `content_id` =  ?");
                $prep->execute([ $content_id]);
        } elseif ($submitAction == "save"){
            if ($_SESSION['user_id'] != NULL) {
                $content_id = $_POST['id_content'];
                
                $prep = $pdo->prepare("UPDATE `content` SET `option` = ?, `description` = ?  WHERE `content_id` =  ?");
                $prep->execute([$option, $description, $content_id]);
            } else {
                header('location: register.php');
            }
        } elseif ($submitAction == "create"){
            if ($_SESSION['user_id'] != NULL) {
                $prep = $pdo->prepare("INSERT INTO `content` (`title`, `description`) VALUE (?,?)");
                $prep->execute([$title, $description]);
            } else {
                header('location: register.php');
            }
        }

        
        
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todo</title>
</head>
<body>
    <h1>Привет юзер</h1>
    <form action="main.php" method="POST">
        <input type="text" name="title">
        <input type="text" name="description">
        <button type="submit" name="submitAction" value="create">добавить</button>
    </form>
    <div id="container">
    <script>
        // Функция для загрузки карточек
        function loadContent(input = '') {
            fetch('search.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'search_input=' + encodeURIComponent(input)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Проверяем, что приходит в ответ

                let html = '';

                const content = data.data;
                const current_page = 1; 
                let render_amount;

                if (content.length < current_page * 10) {
                    render_amount = content.length;
                } else {
                    render_amount = current_page * 10;
                }

                for (let i = 0; i < render_amount; i++) {
                    const item = content[i];
                    const title = item.title || 'Без названия';
                    const description = item.description || 'Без описания';
                    const content_id = item.content_id || item.id;
                    const option = item.option;
                    html += `
                    <form class='content' method='POST' action='main.php'>
                        <div>
                            <input name="id_content" value="${content_id}">
                            <input name="title" value="${title}">
                            <input name="description"  value="${description}">
                            <input type="checkbox" name="option" ${option}>
                        </div>
                        <button type="submit" name="submitAction" value="save">Сохранить изм ${content_id}</button>
                        <button type="submit" name="submitAction" value="delete">удалить ${content_id}</button>
                    </form>
                    `;
                }

                document.getElementById('container').innerHTML = html;
            })
            
        }


        document.addEventListener('DOMContentLoaded', function() {
            loadContent(); 
        });

        // Обработчик кнопки поиска
        document.getElementById('search_btn').addEventListener('click', function() {
            const input = document.getElementById('search_input').value;
            loadContent(input); 
        });
    </script> 

    </div>
</body>
</html>