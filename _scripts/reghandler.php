<html>
    <head>
        <title>Registration Complete</title>
        <link rel="stylesheet" href="../_styles/styles.css">
    </head>
    <body>
    <h1>Registration Complete<h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "blog_project";
    
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $newusername = $_POST["username"];
    $newpassword = $_POST["password"];
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "INSERT INTO users (FIRST_NAME, LAST_NAME, EMAIL, USER_NAME, PASSWORD)
    VALUES ('".$firstname."', '".$lastname."', '".$email."', '".$newusername."', '".$newpassword."')";
    
    if ($conn->query($sql) === TRUE) {
        echo "You have successfully registered for this site.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
    ?>
    </body>
</html>