<?php
if(empty($_SESSION['loggedin'])){ //if $_SESSION['loggedin'] doesn't exist that means user didn't login.
    ?>
    <div class="button-wrapper">                      
        <a href="registration.php" target="_blank"><button>Register</button></a>
        <a href="login.php"><button>Login</button></a>
    </div>
<?php
} else {
    ?>
    <div class="button-wrapper">
        <a href="#" target="_blank"><button>Search</button></a>
        <?php
        if ($_SESSION['user_role'] == $PERMISSION_ADMIN) {
            ?>
                <a href="users.php"><button>My Admin</button></a> 
            <?php
        }
        ?>                    
        <a href="logout.php"><button>Logout</button></a>
    </div>
<?php
}
?>
