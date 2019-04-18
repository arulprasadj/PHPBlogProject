<?php include_once 'shared/header.php'; ?>
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
        $sql = "INSERT INTO `users` (`category_name`,`created_date`,`created_by`,`active_flag`) VALUES ('".$category_name."','".$created_date."','".$created_by."','".$active_flag."')";
        $conn->query($sql);
        header('location: users.php');
    }else if($formType == 'edit'){
        $category_id = $_POST['category_id'];
        $sql = "UPDATE `users` SET `category_name`='".$category_name."',`created_by`='".$created_by."',`active_flag`='".$active_flag."' WHERE `category_id`=".$category_id;
        $conn->query($sql);
        header('location: users.php');
    }else if($formType == 'delete'){
        $category_id = $_POST['category_id'];
        $sql = "DELETE FROM `users` WHERE `category_id`=".$category_id;
        $conn->query($sql);
        header('location: users.php');
    }
}

if(empty($action)){
    //List
?>
<h1>Categories</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Permission</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
<?php
    $sql = 'SELECT * FROM `users` ';
    $res = $conn->query($sql);
    while($row = $res->fetch_assoc()){
?>
        <tr style="text-align: center;">
            <td><?= $row['User_id'] ?></td>
            <td><?= $row['User_name'] ?></td>
            <td><?= $row['First_name'] ?></td>
            <td><?= $row['Last_name'] ?></td>
            <td><?= $row['User_email'] ?></td>
            <td><?= $PERMISSION_TYPES[$row['permission']] ?></td>
            <td><a href="users.php?action=edit&id=<?= $row['User_id'] ?>" class="button">Edit</a></td>
            <td><a href="users.php?action=delete&id=<?= $row['User_id'] ?>" class="button">Delete</a></td>
        </tr>
<?php
    }
?>
    </table>
    <br><br>
    <a href='users.php?action=add'><button>Add a New Category</button></a><br>
<?php 
}else if($action == 'add'){
?>
    <form method="POST">
        <input type="hidden" name="form-type" value="add">
        <input type="text" name="User_name" placeholder="Username"><br><br>
        
        <label>Permission</label>
        <select name="permission">
            <?php 
                foreach($PERMISSION_TYPES as $index => $name){
                    echo('<option value="'.$index.'">'.$name.'</option>');
                }
            ?>
        </select>

        <input type="submit" value="Add">
    </form>
<?php
}else if($action == 'edit'){
    $sql = 'SELECT * FROM `users` WHERE `User_id`='.$id;
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    ?>
    <form method="POST">
        <input type="hidden" name="form-type" value="edit">
        <input type="hidden" name="User_id" value="<?=$row['User_id'] ?>">
        <input type="text" name="User_name" placeholder="Username"><br><br>
        
        <label>Permission</label>
        <select name="permission">
            <?php 
                foreach($PERMISSION_TYPES as $index => $name){
                    $selected = '';
                    if($index === $row['permission']){
                        $selected = 'selected';
                    }
                    echo('<option value="'.$index.'" '.$selected.'>'.$name.'</option>');
                }
            ?>
        </select>

        <input type="submit" value="Update">
    </form>
<?php
}else if($action == 'delete'){
    $sql = 'SELECT * FROM `users` WHERE `User_id`='.$id;
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    ?>
    <form method="POST">
        <input type="hidden" name="form-type" value="delete"><br>
        <input type="hidden" name="User_id" value="<?=$row['User_id'] ?>">
        <p>Are you sure you want to delete this category?</p>
        <input type="submit" value="Delete">
    </form>
    <?php
}
?>
<?php include_once 'shared/footer.php'; ?>