<?php
    include "header.php";
    $content_id = $_GET['post'];

    $stmt = $pdo->prepare("SELECT * FROM content WHERE content_id = ?");
    $stmt->execute([$content_id]);
    $content = $stmt->fetch();

    $sel_content_id = 5;
    $amnt = 100;

    function generate($amnt, $sel_content_id, $pdo){
        for ($i=0; $i < $amnt; $i++) {

            $rand_vote = random_int(3, 4);

            $prep = $pdo->prepare("INSERT INTO `content_users` (`content_id`, `user_id`, `vote`) VALUES (?, ?, ?)");
            $prep->execute([$sel_content_id, $i, $rand_vote]);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // generate($amnt, $sel_content_id, $pdo);

        $check_id = $pdo->prepare("SELECT * FROM content_users WHERE user_id = ? AND content_id = ?");
        $check_id->execute([$_SESSION['user_id'], $content_id]);
        $content_user_id = $check_id->fetch();

        if ($content_user_id === false) {
            if ($_SESSION['user_id'] != NULL) {
            $vote = $_POST['vote'];
            $prep = $pdo->prepare("INSERT INTO `content_users` (`content_id`, `user_id`, `vote`) VALUES (?, ?, ?)");
            $prep->execute([$content_id, $_SESSION['user_id'],  $vote]);
            
            echo('<script>');
            echo('alert("Голос отдан")');
            echo('</script>');
            }
            else {
            header('location: register.php');
            }
        }
        else {
            if ($_SESSION['user_id'] != NULL) {
            $vote = $_POST['vote'];
            $prep = $pdo->prepare("UPDATE `content_users` SET `vote` = ? WHERE (`user_id`, `content_id`) = (?, ?)");
            $prep->execute([$vote, $_SESSION['user_id'], $content_id]);
            echo('<script>');
            echo('alert("Голос изменен")');
            echo('</script>');
            } else {
            header('location: register.php');
            }
        }
    }

$content_value = 0;

    if (isset($_SESSION['user_id'])) {
        $vote_request = $pdo->prepare("SELECT `vote` FROM `content_users` WHERE (`content_id`, `user_id`) = (?, ?)");
        $vote_request->execute([$content_id, $_SESSION['user_id']]);
        $vote_load = $vote_request->fetch();
        if ($vote_load != NULL) {
            $content_value = $vote_load['vote'];
        } 
    }

    $votes_request = $pdo->prepare("SELECT `vote` FROM `content_users` WHERE (`content_id`) = (?)");
    $votes_request->execute([$content_id]);
    $votes = $votes_request->fetchAll(PDO::FETCH_COLUMN);

    $unique_users_request = $pdo->prepare("SELECT `id` FROM `content_users` WHERE `content_id` = ?");
    $unique_users_request->execute([$content_id]);
    $unique_users = $unique_users_request->fetchAll();
    if ($unique_users !== NULL) {
        $unique_users_count = count($unique_users);
        
    } else {
        $unique_users_count = 0;
    }
    $all_votes = array_count_values($votes);
?>
<!DOCTYPE html>
<html lang="ru">
<body>
    <div class="background">
        <div class="content_page_container">
            <h1 class='auth_header'><?php echo $content['title'] ?></h1>
            <br>
            <div class="content_form">
                <div class="container_flex">
                    <img class="content_page_image" src='<?php echo $content['image'] ?>'>
                    <p class="content_page_desc"><?php echo $content['description'] ?></p>
                </div>
            </div>
            <form method="POST" class="content_page_form">
                <div class="content_vote_container">
                    <input type="radio" value="1" name="vote" class="content_vote_radio" <?php if ($content_value == 1) {echo ('checked = true');} ?>> 
                    
                    <div class="content_vote_subcontainer">
                        <p class="content_vote_text">
                            <?php echo $content['option_1_title']?>  (<? if (isset($all_votes[1]) and count($votes) > 0){echo(round($all_votes[1]/(count($votes)/100), 2)); } else {echo(0);}?>%)
                        </p> <meter class="content_vote_progress" value=<?php echo ($all_votes[1]) ?> max=<?php echo (count($votes)) ?>></meter>
                    </div>
                </div>
                <div class="content_vote_container">
                    <input type="radio" value="2" name="vote" class="content_vote_radio" <?php if ($content_value == 2) {echo ('checked = true');} ?>> 
                    <div class="content_vote_subcontainer">
                        <p class="content_vote_text">
                            <?php echo $content['option_2_title']?>  (<? if (isset($all_votes[2]) and count($votes) > 0){echo(round($all_votes[2]/(count($votes)/100), 2)); } else {echo(0);}?>%)
                        </p> <meter class="content_vote_progress" value=<?php echo ($all_votes[2]) ?> max=<?php echo (count($votes)) ?>></meter>
                    </div>
                </div>
                <div class="content_vote_container">
                    <input type="radio" value="3" name="vote" class="content_vote_radio" <?php if ($content_value == 3) {echo ('checked = true');} ?>>
                    <div class="content_vote_subcontainer">
                        <p class="content_vote_text">
                            <?php echo $content['option_3_title']?>  (<? if (isset($all_votes[3]) and count($votes) > 0){echo(round($all_votes[3]/(count($votes)/100), 2)); } else {echo(0);}?>%)
                        </p> <meter class="content_vote_progress" value=<?php echo ($all_votes[3]) ?> max=<?php echo (count($votes)) ?>></meter>
                    </div>
                </div>
                <div class="content_vote_container">
                    <input type="radio" value="4" name="vote" class="content_vote_radio" <?php if ($content_value == 4) {echo ('checked = true');} ?>> 
                    <div class="content_vote_subcontainer">
                        <p class="content_vote_text">
                            <?php echo $content['option_4_title']?>  (<? if (isset($all_votes[4]) and count($votes) > 0){echo(round($all_votes[4]/(count($votes)/100), 2)); } else {echo(0);}?>%)
                        </p> <meter class="content_vote_progress" value=<?php echo ($all_votes[4]) ?> max=<?php echo (count($votes)) ?>></meter>
                    </div>
                </div>
                <div class='container_flex_bottom'>
                    <button class="content_vote_button">Отдать голос</button>
                    <p class="content_page_user_count">👤 <?php echo $unique_users_count ?></p>
                </div>

            </form>
        </div>
    </div>
    <?php include "footer.php";?>
</body>
</html>