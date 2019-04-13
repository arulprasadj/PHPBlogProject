<?php
include 'config.php';
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
        $insert = "INSERT INTO posts VALUES (NULL, '".$title."', '".$content."', '".$date."', '".$_SESSION['User_name']."')";
        if ($conn->query($insert) === TRUE) {
            $confirm = "One post inserted into the database.";
        } 
    }
}
?> 
<?php include 'shared/header.php'; ?>
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
        <div class="header">
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
            </div>
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
                            echo "<tr><td style='width: 70%;'><h3>".$row['Title']."</h3></td><td style='text-align: right;'><small> Posted on: ".$row['Date']." by ".$row['Author']."</small></td></tr>";
                            echo "<tr><td colspan='2'>".$row['Content']."</td></tr>";
                            echo "<tr><td colspan='2' style='border-bottom: 0px;'><small>Categories</small></tr>";
                            echo "</table>";
                        }
                    } else {
                        echo "There are no posts.<br>";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
<?php include 'shared/footer.php'; ?>
 
