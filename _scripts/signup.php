<?php
    require_once('connect.php');
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $newusername = $_POST["username"];
    $newpassword = $_POST["password"];
    
    $sql = "INSERT INTO users (First_name, Last_name, User_email1, User_name)
    VALUES ('".$firstname."', '".$lastname."', '".$email."', '".$newusername."')";
    $sql .= "INSERT INTO passwords (User_name, User_password) VALUES ('".$newusername."', '".$newpassword."')";

    
    if ($conn->query($sql) === TRUE) {
        $result = "You have successfully registered for this site.";
    } else {
        $result = "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
    ?>
<html>
    <head>
        <title>Registration Complete</title>
        <link rel="stylesheet" href="../_styles/styles.css">
    </head>
    <body>
        <h1>Registration Complete<h1>
        <p><?php echo $result; ?>
    </body>
</html>