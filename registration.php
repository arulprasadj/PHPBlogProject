<?php include 'shared/header.php'; ?>
        <div class="container">
        <h1>User Registration</h1>
        <sub>Please fill out this form to create an account.</sub>
        <form action="signup.php" method="POST">
            <table>
                <tr>
                    <td><label for="firstname">First Name</label></td>
                    <td><input type="text" placeholder="Jane" name="firstname" required></td>
                    <td><label for="lastname">Last Name</label></td>
                    <td><input type="text" placeholder="Doe" name="lastname" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email Address</label></td>
                    <td colspan="3"><input type="text" placeholder="JaneDoe@myhost.com" name="email" required></td>
                </tr>
                <tr>
                    <td><label for="username">Display Name</label></td>
                    <td colspan="3"><input type="text" placeholder="janeDoe2019" name="username" required></td>
                </tr>
                <tr>
                        <td><label for="password">Password</label></td>
                        <td colspan="3"><input type="password" placeholder="" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required></td>
                </tr>
                <tr>
                        <td><input type="submit"></td>
                </tr>
            </table>
        </form>
        </div>
<?php include 'shared/footer.php'; ?>

