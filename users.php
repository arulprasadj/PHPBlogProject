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
    $user_id = $_POST['User_id'];
    $First_name = $_POST['First_name'];
    $Last_name = $_POST['Last_name'];
    $email = $_POST['User_email'];
    $User_name = $_POST['User_name'];
    $User_password = $_POST['User_password'];
    $created_by = $_SESSION['User_name'];
    $created_date = date("Y-m-d H:i:s");
    if($formType == 'add'){
        $sql = "INSERT INTO `users` (`User_name`,`First_name`,`Last_name`,`User_email`) VALUES ('".$User_name."','".$created_date."','".$created_by."','".$active_flag."')";
        $conn->query($sql);
        header('location: users.php');
    }else if($formType == 'edit'){
        $sql = "UPDATE `users` SET `category_name`='".$category_name."',`created_by`='".$created_by."',`active_flag`='".$active_flag."' WHERE `User_id`=".$user_id;
        $conn->query($sql);
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
        <label for="First_name">First Name</label><br>
        <input type="text" placeholder="Jane" name="First_name" required><br>
        <label for="Last_name">Last Name</label><br>
        <input type="text" placeholder="Doe" name="Last_name" required><br>
        <label for="User_email">Email Address</label><br>
        <input type="text" placeholder="JaneDoe@myhost.com" name="User_email" required><br>
        <label for="User_name">Display Name</label><br>
        <input type="text" name="User_name" placeholder="jdoe99" required><br>
        <label for="password">Password</label><br>
        <input type="password" placeholder="" name="User_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required><br>

        
        <label>Permission</label>
        <select name="permission" required>
            <option selected disabled></option>
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
        <p>Are you sure you want to delete this user?</p>
        <input type="submit" value="Delete">
    </form>
    <?php
}
?>
<?php include_once 'shared/footer.php'; ?>