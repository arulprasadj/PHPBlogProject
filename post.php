<?php include 'config.php'; ?>
<?php 
    if(!empty($_POST['search'])){

    }

    if(!empty($_POST)){
        $formtype = $_POST['form-type'];
        $post_id = $_POST['post_id'];
        $content = $_POST['content'];
        $createdby = $_SESSION['user_id'];
        $date = date("Y-m-d H:i:s");
        if($formtype == "comment"){
            $sql = "INSERT INTO `comments` (`post_id`,`content`,`created`,`createdby`,`modified`,`modifiedby`,`deleted`) VALUES ('".$post_id."', '".$content."', '".$date."', '".$createdby."', '".$date."', '".$createdby."', 'n')";
            if ($conn->query($sql) === TRUE) {
                $confirm = 'Comment successfully added to post.';
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    if (!empty($_GET['rating'])) {
        $rating = $_GET['rating'];
        $sql = <<<SQL
        INSERT INTO `ratings` (`post_id`,`user_id`,`rating`)
        VALUES ('{$_GET['id']}','{$_SESSION['user_id']}', '{$_GET['rating']}')
SQL;
        if ($conn->query($sql) === TRUE) {
            $confirm = 'Rating saved.';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }else{
        echo 'Error';
        exit();
    }
    $sql = "SELECT * FROM `posts` JOIN `categories` ON `posts`.`category_id`=`categories`.`category_id` WHERE `id`=".$id;
    $res = $conn->query($sql);
    $post = $res->fetch_assoc();
?>

<?php 
$headerArgs = Array(
    'Title' => (!empty($post['Title'])) ? 'Post: '.$post['Title'] : 'Post',
    'Description' => 'View blog post',
    'Keywords' => 'HTML,CSS,JavaScript,PHP'
);
include 'shared/header.php'; ?>
        <style> 
            textarea {
                width: 100%;
                padding: 15px;
                margin: 5px 0px 22px 0px;
                display: inline-block;
                border: none;
                background: #f1f1f1;
                resize: none;
            }
            td {
                border-bottom: 1px solid black;
            }
            table {
                width: 100%;
                margin-top: 70px;
            }
        </style>
<div><?php include 'shared/showTopMenu.php'; ?><div>
        </header> 
        <main>
            <div class="post-context" style="border-botton: 1px solid black;">         
                <h1 style="display: inline;"><?=$post['Title']?></h1><span style="text-size: .9em;"> by <?=$post['Author'] ?> on <?=$post['Date'] ?></span>
                <hr>
                <p><?=$post['Content'] ?></p>
                <hr>
                <div class="rating" style="float:right;">
                <?php
                $sql = "SELECT * FROM `ratings` JOIN `posts` ON `posts`.`ID`=`ratings`.`post_id` JOIN `users` ON `ratings`.`user_id`=`users`.`User_id` WHERE `users`.`User_id`='".$_SESSION['user_id']."' AND `posts`.`ID`='".$id."'";
                $result = $conn->query($sql);
                echo $conn->error;
                if ($result->num_rows > 0) {
                    $averageRating = 'SELECT AVG(`rating`) AS rating FROM `posts` JOIN `ratings` ON `posts`.`ID`=`ratings`.`post_id` WHERE `posts`.`ID`='.$id;
                    $ratingResult = $conn->query($averageRating);
                    $ratingArray = $ratingResult->fetch_assoc();
                    $rating = (!empty($ratingArray['rating'])) ? $ratingArray['rating'] : '5';
                    for ($i=1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            ?>
                            <i class='fa fa-star' style='color: green;'></i>
                            <?php
                        } else {
                            ?>
                            <i class='fa fa-star' style='color: #C3F3C0;'></i>
                            <?php
                        }
                    }
                } else {
                    for ($i=1; $i <= 5; $i++) {
                        ?>
                        <a href="post.php?id=<?=$id ?>&rating=<?=$i ?>" style="text-decoration: none;"><i class='fa fa-star' style='color: green;'></i></a>
                        <?php
                    }
                }
                ?>
                </div>
            </div>
            <div class="comments">
                <div class="comment-add-wrap">
                    <form method="POST">
                        <input type="hidden" name="form-type" value="comment">
                        <input type="hidden" name="post_id" value="<?=$id ?>">
                        <textarea name="content" placeholder="Add comment..."></textarea>
                        <span style="color: green;"><?=(isset($confirm)) ? $confirm : '' ?></span><input style="float: right; clear: both;" type="submit" value="Submit Comment">
                    </form>
                </div>
                <?php 
                    $sql = 'SELECT * FROM `comments`  JOIN `users` ON `comments`.`createdby`=`users`.`user_id` WHERE `post_id`='.$id;

                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                ?>
                    <div class="comment">
                        <table style="margin-bottom: 20px;">
                            <tr>
                                <td style="border-bottom:1px solid black;"><?=$row['User_name'] ?> on <?=$row['created'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><?=$row['content'] ?></td>
                            </tr>
                        </table>
                    </div>
                <?php 
                        }
                    }
                ?>
            </div>
        </main>
    </body>
</html>
 
