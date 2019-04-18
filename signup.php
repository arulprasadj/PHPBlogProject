<?php
    require_once('config.php');
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $newusername = $_POST["username"];
    $newpassword = $_POST["password"];
    
    $sql = "INSERT INTO `users` (`First_name`, `Last_name`, `User_email`, `User_name`, `permission`)
    VALUES ('".$firstname."', '".$lastname."', '".$email."', '".$newusername."', '".$PERMISSION_USER."')";
    
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $sql = "INSERT INTO passwords (User_password, User_id) VALUES ('".$newpassword."', '".$last_id."')";
        if ($conn->query($sql) === TRUE) {
            $result = "You have successfully registered for this site.";
        } else {
            $result = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $result = "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
    ?>
<?php include_once 'shared/header.php'; ?>
        <h1>Registration Complete<h1>
        <p><?php echo $result; ?>
<?php include_once 'shared/footer.php'; ?>