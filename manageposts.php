<?php include_once 'shared/header.php'; ?>
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
</style>
<?php
include 'config.php';
if(empty($_SESSION['loggedin'])){ //if $_SESSION['loggedin'] doesn't exist that means user didn't login. Therefore redirect them to login page
    header('location: login.php');
    exit();
}

$action = '';
if(!empty($_GET['action'])){
    $action = $_GET['action'];
}

$id = '';
if(!empty($_GET['id'])){
    $id = $_GET['id'];
}

//Process forms
if(!empty($_POST)){
    $formType = $_POST['form-type'];
    $postid = $_POST['id'];
    $title = $_POST['Title'];
    $content = $_POST['Content'];
    $created_by = $_SESSION['User_name'];
    $created_date = date("Y-m-d H:i:s");
    if($formType == 'edit'){
        $category_id = $_POST['category'];
        $sql = "UPDATE `posts` SET `Title`='".$title."',`Author`='".$created_by."',`Content`='".$content."',`category_id`='".$category_id."' WHERE `ID`=".$postid;
        $conn->query($sql);
        header('location: manageposts.php');
    }else if($formType == 'delete'){
        $sql = "DELETE FROM `posts` WHERE `id`=".$postid;
        $conn->query($sql);
        header('location: manageposts.php');
    }
}

if(empty($action)){
    //List
?>
<h1>My Posts</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Date</th>
            <th>Author</th>
            <th>Category</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
<?php
    $sql = 'SELECT * FROM `posts` JOIN `categories` ON `posts`.`category_id`=`categories`.`category_id`';
    $res = $conn->query($sql);
    while($row = $res->fetch_assoc()){
?>
        <tr style="text-align: center;">
            <td><?= $row['ID'] ?></td>
            <td><?= $row['Title'] ?></td>
            <td><?= substr($row['Content'], 0, 100) . "..." ?></td>
            <td><?= $row['Date'] ?></td>
            <td><?= $row['Author'] ?></td>
            <td><?= $row['category_name'] ?></td>
            <td><a href="manageposts.php?action=edit&id=<?= $row['ID'] ?>" class="button">Edit</a></td>
            <td><a href="manageposts.php?action=delete&id=<?= $row['ID'] ?>" class="button">Delete</a></td>
        </tr>

<?php
    }
}else if($action == 'edit'){
    $sql = 'SELECT * FROM `posts` WHERE `ID`='.$id;
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    ?>
    <form method="POST">
        <input type="hidden" name="form-type" value="edit">
        <input type="hidden" name="id" value="<?=$row['ID'] ?>">
        <label><strong>Title</strong></label><br><input type="text" name="Title" placeholder="Title" value="<?=$row['Title'] ?>"><br>
        <label><strong>Content</strong></label><br><textarea name="Content" rows="10" cols="60"><?=$row['Content'] ?></textarea><br>
        <label><strong>Category</strong></label><br>
        <select name="category">
            <?php
                $sql = 'SELECT * FROM `categories` WHERE `active_flag`="y"';
                $res = $conn->query($sql);
                while($cat = $res->fetch_assoc()){
                    if ($row['category_id'] == $cat['category_id']) {
                        echo "<option value=".$cat['category_id']." selected>".$cat['category_name']."</option>";
                    } else{
                        echo "<option value=".$cat['category_id'].">".$cat['category_name']."</option>";
                    }
                }
            ?>
        </select><br><br>

        <input type="submit" value="Update">
    </form>
<?php
}else if($action == 'delete'){
    $sql = 'SELECT * FROM `posts` WHERE `ID`='.$id;
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    ?>
    <form method="POST">
        <input type="hidden" name="form-type" value="delete"><br>
        <input type="hidden" name="id" value="<?=$row['ID'] ?>">
        <p>Are you sure you want to delete this post?</p>
        <input type="submit" value="Delete">
    </form>
    <?php
}
?>
</table><br><br>
<?php
if(empty($_GET)){
    echo "<a href='posts.php'><button>Add a New Post</button></a><br>";
}
?>
<?php include_once 'shared/footer.php'; ?>