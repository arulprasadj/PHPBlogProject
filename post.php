<?php include 'config.php'; ?>
<?php 
    if(!empty($_POST['search'])){

    }

    if(!empty($_POST['new-comment'])){
        $post_id = $_POST['post_id'];
        $content = $_POST['content'];
        //user name from session
        //date
        //insert
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
<?php include 'shared/showTopMenu.php'; ?>
        </header> 
        <main>
            <div class="post-context">         
                <h1><?=$post['Title']?></h1>
                <p><?=$post['Content'] ?></p>
                <div class="post-date"></div>
                <div class="post-author"></div>
                <div class="post-category"></div>
            </div>
            <div class="comments">
                <div class="comment-add-wrap">
                    <form method="POST">
                        <input type="hidden" name="form-name" value="new-comment">
                        <input type="hidden" name="post_id" value="<?=$id ?>">
                        <textarea name="content" placeholder="content"></textarea>
                        <input type="submit" value="Add comment">
                    </form>
                </div>
                <?php 
                    $sql = 'SELECT * FROM `comments`  JOIN `users` ON `comments`.`createdby`=`users`.`user_id` WHERE `post_id`='.$id;

                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                ?>
                    <div class="comment">
                        <div class="comment-text"></div>
                        <span class="comment-author"></span>
                        <span class="comment-date"></span>
                    </div>
                <?php 
                        }
                    }
                ?>
            </div>
        </main>
    </body>
</html>
 
