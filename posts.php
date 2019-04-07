<?php
include 'connect.php';
if(empty($_SESSION['loggedin'])){ //if $_SESSION['loggedin'] doesn't exist that means user didn't login. Therefore redirect them to login page
    header('location: login.php');
    exit();
}
if (isset($_POST['title'])) {
    $title=trim($_POST["title"]);
    $content=$_POST["content"];
    $date = date("Y-m-d");
    
    // currently not sanitizing user input. Not good. Will refactor this.
    if (!$title == NULL || !$content == NULL) {
        $insert = "INSERT INTO posts VALUES (NULL, '".$title."', '".$content."', '".$date."')";
        if ($conn->query($insert) === TRUE) {
            $confirm = "One post inserted into the database.";
        } 
    }
}
?> 
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="description" content="A blog/cms project for class.">
        <meta name="keywords" content="HTML,CSS,PHP, MySQL">
        <meta name="author" content="Jack Vincent">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="stylesheet" href="_styles/normalize.css"> --> 
        <!-- Browser styles were messing up my spacing so I normalized, but then fixed without it. Either way, I left it in just in case I need it in the future. -->
        <link rel="stylesheet" href="_styles/styles.css">
        <style> 
            textarea {
                width: 100%;
                padding: 15px;
                margin: 5px 0px 22px 0px;
                display: inline-block;
                border: none;
                background: #f1f1f1;
                resize: none;
            }
            td {
                border-bottom: 1px solid black;
            }
            table {
                width: 100%;
                margin-top: 70px;
            }
        </style>
    </head>
    <body>
        <header>
            <div class="title" style="margin-bottom: 20px;">                     
                <h2>My Blog Posts</h2>
                <label>by GCU Student Jack Hall</label>
            </div>
            <div style="text-align: right;"><p>Logged in as
                 <?php
                 if (isset($_SESSION['User_name'])) {
                    echo $_SESSION['User_name'];
                 } else {
                    echo "NULL";
                 }
                  ?>
                </p></div>
        </header>
        <main>
            <div class="container main">
                <form action="posts.php" method="POST">
                    <input type="text" name="title" placeholder="Enter a title..."><br>
                    <textarea name="content" rows="10" cols="60" placeholder="Enter your post here..."></textarea><br>
                    <input type="submit" value="Post"><small style='text-align: right; color: green;'><?php echo $confirm; ?></small><br>
                </form>
                <div class="posts">
                    <?php
                    $sql = <<<SQL
                    SELECT *
                    FROM posts
                    ORDER BY ID desc
SQL;

                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<table>";
                            echo "<tr><td style='width: 70%;'><h3>".$row['Title']."</h3></td><td style='text-align: right;'><small> Posted on: ".$row['Date']."</small></td></tr>";
                            echo "<tr><td colspan='2'>".$row['Content']."</td></tr>";
                            echo "</table>";
                        }
                    } else {
                        echo "There are no posts.<br>";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
        </main>
    </body>
</html>
 
