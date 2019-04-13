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
    $category_name = $_POST['category_name'];
    $active_flag = $_POST['active_flag'];
    $created_by = $_SESSION['User_name'];
    $created_date = date("Y-m-d H:i:s");
    if($formType == 'add'){
        $sql = "INSERT INTO `CATEGORIES` (`category_name`,`created_date`,`created_by`,`active_flag`) VALUES ('".$category_name."','".$created_date."','".$created_by."','".$active_flag."')";
        mysqli_query($conn,$sql);
        header('location: categories.php');
    }else if($formType == 'edit'){
        $category_id = $_POST['category_id'];
        $sql = "UPDATE `CATEGORIES` SET `category_name`='".$category_name."',`created_by`='".$created_by."',`active_flag`='".$active_flag."' WHERE `category_id`=".$category_id;
        mysqli_query($conn,$sql);
        header('location: categories.php');
    }
}

if(empty($action)){
    //List
?>
<a href="categories.php?action=add">Add</a><br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created Date</th>
            <th>Author</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
<?php
    $sql = 'SELECT * FROM `categories` ';
    $res = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_object($res)){
?>
        <tr>
            <td><?= $row->category_id ?></td>
            <td><?= $row->category_name ?></td>
            <td><?= $row->created_date ?></td>
            <td><?= $row->created_by ?></td>
            <td><?= ($row->active_flag == 'y')? 'Active' : 'Not Active' ?></td>
            <td><a href="categories.php?action=edit&id=<?= $row->category_id ?>">Edit</a></td>
            <td><a href="categories.php?action=delete&id=<?= $row->category_id ?>">Delete</a></td>
        </tr>
<?php
    }
}else if($action == 'add'){
?>
    <form method="POST">
        <input type="hidden" name="form-type" value="add">
        <input type="text" name="category_name" placeholder="Name"><br><br>
        
        <select name="active_flag">
            <option value="y">Active</option>
            <option value="n">Not Active</option>
        </select><br><br>

        <input type="submit" value="Add">
    </form>
<?php
}else if($action == 'edit'){
    $sql = 'SELECT * FROM `categories` WHERE `category_id`='.$id;
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_object($res);
    ?>
    <form method="POST">
        <input type="hidden" name="form-type" value="edit">
        <input type="hidden" name="category_id" value="<?=$row->category_id ?>">
        <input type="text" name="category_name" placeholder="Name" value="<?=$row->category_name ?>"><br><br>
        
        <select name="active_flag">
            <option value="y" <?=($row->active_flag =='y')? 'selected': '' ?> >Active</option>
            <option value="n" <?=($row->active_flag =='n')? 'selected': '' ?>>Not Active</option>
        </select><br><br>

        <input type="submit" value="Update">
    </form>
<?php
}else if($action == 'delete'){
    //Del
    echo 'delete';
}