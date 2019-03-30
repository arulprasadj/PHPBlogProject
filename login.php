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
            <h1>Welcome.</h1>
        </header>
        <main>
            <div class="container">
                <form action="login.php" method="POST">
                <fieldset>
                    <table>
                            <legend>Enter Credentials</legend>
                            <tr>
                                <td><strong>Username: </strong></td>
                                <td><input type="text" name="username" placeholder="Enter username..."></td>
                            </tr>
                            <tr>
                                <td><strong>Password: </strong></td>
                                <td><input type="password" name="password" placeholder="Enter password..." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                    title="The password you entered contains illegal characters or spaces. Please try again."></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" value="Login" style="float: left; margin-right: 20px;"><p>Not a user? <a href="registration.html">Click here to Register.</a></p></td>
                            </tr>
                    </table>
                </fieldset>
                </form>
                <p style="text-align:right;"><sub>A GCU School Project by Jack Hall.</sub></p>
            </div>
            <div class="container script">
                <div class="generated">
                    <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "root";
                        $dbname = "blog_project";

                        $formusername = $_POST['username'];
                        $formpassword = $_POST['password'];

                        if ($formusername == NULL || $formpassword == NULL) {
                            echo "<p style='text-align: center;'>Please enter username and password to login.</p>";
                        } elseif ($formusername == "" || $formpassword == "") {
                            echo "<p style='text-align: center;'>Please enter username and password to login.</p>";
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
                                    echo "<p style='text-align: center';>Login Failed. Incorrect username or password. If you are not a user, <a href='registration.html'>click here to register.</a></p>";
                                    break;
                                case 1:
                                    $row = $result->fetch_assoc();
                                    echo "<p style='text-align: center;'>Login Succeeded. ";
                                    echo "Welcome to the blog, " . $row['First_name'] . ".</p>";
                                    break;
                                case 2:
                                    echo "There are multiple users registered";
                                    break;
                                default:
                                    echo "Error. Please try again.";
                            }

                            $conn->close();
                        }

                        if (isset($_COOKIE['login'])) {
                            if ($_COOKIE['login'] < 3) {
                                $attempts = $_COOKIE['login'] + 1;
                                setcookie('login',$attempts,time()+60*10);
                            } else {echo "<p style='text-align: center; color: red;'>You are banned for 10 minutes. Please try again later.";}
                        } else {setcookie('login',1,time()+60*10);}
                    ?>
                </div>
            </div>
        </main>
    </body>
</html>