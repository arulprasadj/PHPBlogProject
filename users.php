<?php include_once 'shared/header.php'; ?>
<?php
include 'config.php';
if(empty($_SESSION['loggedin'])){ //if $_SESSION['loggedin'] doesn't exist that means user didn't login. Therefore redirect them to login page
    header('location: login.php');
    exit();
}
if($_SESSION['user_role'] !== $PERMISSION_ADMIN){ //if $_SESSION['user_role'] does not indicate $PERMISSION_ADMIN, redirect.
    header('location: posts.php');
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
    $user_id = $_POST['User_id'];
    $First_name = $_POST['First_name'];
    $Last_name = $_POST['Last_name'];
    $User_email = $_POST['User_email'];
    $User_name = $_POST['User_name'];
    $User_password = $_POST['User_password'];
    $user_role = $_POST['user_role'];
    if($formType == 'add'){
        $sql = "INSERT INTO `users` (`User_name`,`First_name`,`Last_name`,`User_email`,`user_role`) VALUES ('".$User_name."',
        '".$First_name."','".$Last_name."','".$User_email."','".$user_role."')";
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            $sql = "INSERT INTO `passwords` (`User_password`, `User_id`) VALUES ('".$User_password."', '".$last_id."')";
            $conn->query($sql);
            header('location: users.php');
        }
    }else if($formType == 'edit'){
        $sql = "UPDATE `users` SET `User_name`='".$User_name."',`First_name`='".$First_name."',`Last_name`='".$Last_name."',
        `User_email`='".$User_email."',`user_role`='".$user_role."' WHERE `User_id`=".$user_id;
        if($conn->query($sql) === TRUE) {
            $sql = "UPDATE `passwords` SET `User_password`='".$User_password."' WHERE `User_id`=".$user_id;
        }
        header('location: users.php');
    }else if($formType == 'delete'){
        $sql = "DELETE FROM `users` WHERE `User_id`=".$user_id;
        $conn->query($sql);
        header('location: users.php');
    }
}


if(empty($action)){
    //List
?>
<h1>User Management</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
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
            <td><?= $PERMISSION_TYPES[$row['user_role']] ?></td>
            <td><a href="users.php?action=edit&id=<?= $row['User_id'] ?>" class="button">Edit</a></td>
            <td><a href="users.php?action=delete&id=<?= $row['User_id'] ?>" class="button">Delete</a></td>
        </tr>
<?php
    }
?>
    </table>
    <br><br>
    <a href='users.php?action=add'><button>Add a User</button></a><br>
<?php 
}else if($action == 'add'){
?>
    <h1>Add User</h1>
    <form method="POST">
        <input type="hidden" name="form-type" value="add">
        <label for="First_name">First Name</label>
        <input type="text" placeholder="Jane" name="First_name" required>
        <label for="Last_name">Last Name</label>
        <input type="text" placeholder="Doe" name="Last_name" required>
        <label for="User_email">Email Address</label>
        <input type="text" placeholder="JaneDoe@myhost.com" name="User_email" required>
        <label for="User_name">Display Name</label>
        <input type="text" name="User_name" placeholder="jdoe99" required>
        <label for="User_password">Password</label>
        <input type="password" placeholder="" name="User_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
        <label>Role</label>
        <select name="user_role" required>
            <option selected disabled></option>
            <?php 
                foreach($PERMISSION_TYPES as $index => $name){
                    echo('<option value="'.$index.'">'.$name.'</option>');
                }
            ?>
        </select>

        <input type="submit" value="Add"><a href="users.php" class="button">Cancel</a>
    </form>
<?php
}else if($action == 'edit'){
    $sql = 'SELECT * FROM `users` JOIN `passwords` ON `users`.`User_id`=`passwords`.`User_id` WHERE `users`.`User_id`='.$id;
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    ?>
    <h1>Edit User</h1>
    <form method="POST">
        <input type="hidden" name="form-type" value="edit">
        <input type="hidden" name="User_id" value="<?=$row['User_id'] ?>">
        <label for="First_name">First Name</label>
        <input type="text" name="First_name" placeholder="Username" value="<?=$row['First_name'] ?>" required>
        <label for="Last_name">Last Name</label>
        <input type="text" placeholder="Doe" name="Last_name" value="<?=$row['Last_name'] ?>" required>
        <input type="text" placeholder="JaneDoe@myhost.com" name="User_email" value="<?=$row['User_email'] ?>" required>
        <input type="text" name="User_name" placeholder="jdoe99" value="<?=$row['User_name'] ?>" required>
        <input type="password" name="User_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" 
                            value="<?=$row['User_password'] ?>" required><br>
        <label>Role</label>
        <select name="user_role">
            <?php 
                foreach($PERMISSION_TYPES as $index => $name){
                    $selected = '';
                    if($index == $row['user_role']){  // did not with with strict equality? ===
                        $selected = 'selected';
                    }
                    echo('<option value="'.$index.'" '.$selected.'>'.$name.'</option>');
                }
            ?>
        </select>
        <input type="submit" value="Update"><a href="users.php" class="button">Cancel</a>
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
        <p>Are you sure you want to delete this user?</p>
        <input type="submit" value="Delete"><a href="users.php" class="button">Cancel</a>
    </form>
    <?php
}
?>
<?php include_once 'shared/footer.php'; ?>