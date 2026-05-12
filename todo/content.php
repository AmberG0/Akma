<?php
    require_once("database.php");
    $content_id = $_GET['id_content'];

    $stmt = $pdo->prepare("SELECT * FROM content WHERE content_id = ?");
    $stmt->execute([$content_id]);
    $content = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_SESSION['user_id'] != NULL) {
            $vote = $_POST['vote'];
            $prep = $pdo->prepare("UPDATE `content` SET `optoin` = ? WHERE `content_id` =  ?");
            $prep->execute([$vote, $content_id]);
            echo('<script>');
            echo('alert("Измененено")');
            echo('</script>');
        } else {
            header('location: register.php');
        }
        
    }

?>
