<!DOCTYPE html>
<html>
    <head>
        <title>Login Result</title>
        <meta charset="UTF-8">
        <meta name="description" content="A PHP/MySQL Project for School">
        <meta name="keywords" content="HTML,CSS,PHP">
        <meta name="author" content="Jack Vincent">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="_styles/styles.css">
    </head>
    <body>
        <header>
            <h1>Blog Site.</h1>
        </header>
        <main>
            <div class="container">
                <p>
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "root";
                    $dbname = "blog_project";

                    $formusername = $_POST['username'];
                    $formpassword = $_POST['password'];

                    if ($formusername == NULL || $formpassword == NULL) {
                        echo "Please enter username and password to login.";
                    } elseif ($formusername == "" || $formpassword == "") {
                        echo "Please enter username and password to login.";
                    } else {
                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            } 
                            
                        $sql = <<<SQL
                            SELECT *
                            FROM `users`, `passwords`
                            WHERE users.User_id = passwords.User_id 
                            AND "{$formusername}" = users.User_name
                            AND "{$formpassword}" = passwords.User_password
SQL;

                        $result = $conn->query($sql);

                        switch ($result->num_rows) {
                            case 0:
                                echo "Login Failed. Incorrect username or password.<br><p><a href='login.html'>Go back</a> to try again or <a href='registration.html'>click here to register.</a></p>";
                                break;
                            case 1:
                                $row = $result->fetch_assoc();
                                echo "Login Succeeded. ";
                                echo "Welcome, " . $row['First_name'] . ", to  the blog.";
                                break;
                            case 2:
                                echo "There are multiple users registered";
                                break;
                            default:
                                echo "Error. Please try again.";
                        }

                        $conn->close();
                    }

                    ?>
                </p>
            </div>
        </main>
    </body>
</html>