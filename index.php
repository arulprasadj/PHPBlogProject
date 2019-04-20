<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>My Blog Page</title>
        <meta charset="UTF-8">
        <meta name="description" content="A blog/cms project for class.">
        <meta name="keywords" content="HTML,CSS,PHP, MySQL">
        <meta name="author" content="Jack Vincent">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="_styles/styles.css">
    </head>
    <body>
        <header>
            <div class="title">                      
                <h2>My Blog Page</h2>
            </div>
            <?php include 'shared/showTopMenu.php'; ?>
        </header> 
        <main>
            <p>by GCU Student Jack Hall</p>
            <div class="container nav">                     
 

            </div>
            <div class="container main">
                <?php
                if (!empty($_SESSION['loggedin'])) {
                    ?>
                    <p>Currently logged in as: <?=$_SESSION['User_name'] ?></p>
                    <?php
                } else {
                ?>
                <p>This is going to be a productive and helpful learning project.</p>
                <?php
                }
                ?>
            </div>
        </main>
    </body>
</html>
 
