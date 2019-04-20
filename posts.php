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
    $category=trim($_POST['category_id']);
    
    // currently not sanitizing user input. Not good. Will refactor this.
    if (!$title == NULL || !$content == NULL) {
        $insert = "INSERT INTO posts VALUES (NULL, '".$title."', '".$content."', '".$date."', '".$_SESSION['User_name']."', '".$category."')";
        if ($conn->query($insert) === TRUE) {
            $confirm = "One post inserted into the database.";
        }  else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?> 
<?php include_once 'shared/header.php'; ?>
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
                </p><p><a href="categories.php">Manage Categories</a> | <a href="manageposts.php">Manage Posts</a> | 
                <?=($_SESSION['user_role'] == $PERMISSION_ADMIN) ? '<a href="users.php">Manage Users</a>' : '' ?>
                | <a href="logout.php">Logout</a></p></div>
            </div>
            <div class="container main">
                <form action="posts.php" method="POST">
                    <input type="text" name="title" placeholder="Enter a title..."><br>
                    <textarea name="content" rows="10" cols="60" placeholder="Enter your post here..."></textarea><br>
                    <select name="category_id" style="width: 25%;" >
                        <option value="" disabled selected>Select Category</option>
                        <?php 
                            $sql = 'SELECT * FROM `categories` WHERE `active_flag`="y"';
                            $res = $conn->query($sql);
                            while($row = $res->fetch_assoc()){
                                echo "<option value=".$row['category_id'].">".$row['category_name']."</option>";
                            }
                        ?>
                    </select><br>
                    <input type="submit" value="Post"><small style='text-align: right; color: green; clear: both;'><?php echo $confirm; ?></small><br>
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
                            $sql = "SELECT `category_name` from `categories` WHERE '".$row['category_id']."'=`category_id`";
                            $res = $conn->query($sql);
                            $cat = $res->fetch_assoc();
                            echo "<table>";
                            echo "<tr><td style='width: 70%;'><h3>".$row['Title']."</h3></td><td style='text-align: right;'><small> Posted on: ".$row['Date']." by ".$row['Author']."</small></td></tr>";
                            echo "<tr><td colspan='2'>".$row['Content']."</td></tr>";
                            echo "<tr><td colspan='2' style='border-bottom: 0px; font-size: .9em;color: #8DB38B;'>Category: ".$cat['category_name']."</tr>";
                            echo "</table>";
                        }
                    } else {
                        echo "There are no posts.<br>";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
<?php include_once 'shared/footer.php'; ?>
 
