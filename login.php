<?php
    // session_start() is included in connect.php
    include('config.php');

    if(!empty($_POST['login-button'])){ // checking to see if login-button is set...
        $errors = array(); // declaring array
        $formusername=trim($_POST['username']);
        $formpassword=trim($_POST['password']);
        
        if (!$formusername || !$formpassword) {
            if(!$formusername){
                $errors[] = 'Please enter username to login.'; //Append to the end of the array
            }
            if(!$formpassword){
                $errors[] = 'Please enter password to login.';
            }
        } else {
            $sql = <<<SQL
                SELECT users.User_name, First_name, user_role
                FROM `users`, `passwords`
                WHERE users.User_id = passwords.User_id 
                AND ?=users.User_name
                AND ?=passwords.User_password
SQL;
            // setup and execute prepared statement
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $formusername, $formpassword);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($User_name, $First_name, $user_role);

            switch ($stmt->num_rows) {
                case 0:
                    if (isset($_COOKIE['login'])) {
                        if ($_COOKIE['login'] < 3) {
                            $attempts = $_COOKIE['login'] + 1;
                            setcookie('login',$attempts,time()+60*10);
                            $errors[] = 'Login Failed. Incorrect username or password. If you are not a user, <a href="registration.html">click here to register.</a>';
                        } else {
                            $errors[] ='You are banned for 10 minutes. Please try again later.';
                        }
                    } else {
                        setcookie('login',1,time()+60*10);
                    }
                    break;
                case 1:
                        $row = $stmt->fetch(); // may not need this
                        $_SESSION['loggedin'] = true;
                        $_SESSION['User_name'] = $User_name;
                        $_SESSION['user_role'] = $user_role;
                        header('location: posts.php'); // I learned to use header so that I could direct user to posts.php without using form action.
                        exit();
                    break;
                case 2:
                    $errors[] =  "There are multiple users registered";
                    break;
                default:
                    $errors[] =  "Error. Please try again.";
            }
            $stmt->free_result();
            $conn->close();                            
        } 
    }

?>
<?php include_once 'shared/header.php'; ?>
        <div class="header">
            <h1>Welcome.</h1>
        </div>
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
                                <td><input type="submit" name="login-button" value="Login" style="float: left; margin-right: 20px;"><p>Not a user? <a href="registration.php">Click here to Register.</a></p></td>
                            </tr>
                    </table>
                </fieldset>
                </form>
                <p style="text-align:right;"><sub>A GCU School Project by Jack Hall.</sub></p>
            </div>
            <div class="container script">
                <div class="generated">
                   <?php 
                        if(count($errors)>0){ // check if array contains elements
                            foreach($errors as $error){ // echo out elements
                                echo("<p style='text-align: center;color:red;'>".$error."</p><br>");
                            }
                        }
                   ?>
                </div>
            </div>
<?php include_once 'shared/footer.php'; ?>