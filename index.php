<?php include 'config.php'; ?>
<?php 
$headerArgs = Array(
    'Title' => 'Jack\'s Blog',
    'Description' => 'A PHP and MySQL Project for School',
    'Keywords' => 'HTML,CSS,JavaScript,PHP'
);
include 'shared/header.php' ?>
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
            h3 a,
            span a {
                text-decoration: none;
                color: #507255;
            }
            h3 a:hover,
            span a:hover {
                text-decoration: underline;
                color: #C3F3C0;
            }
        </style>
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
                    <div class="posts">
                        <?php
                        $sql = 'SELECT * FROM `posts` JOIN `categories` ON `posts`.`category_id`=`categories`.`category_id`';

                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<table>";
                                echo "<tr><td style='width: 70%;'><h3 id='".$row['ID']."'><a href='post.php?id=".$row['ID']."'>".$row['Title']."</a></h3></td><td style='text-align: right;'><small> Posted on: ".$row['Date']." by ".$row['Author']."</small></td></tr>";
                                echo "<tr><td colspan='2'>".$row['Content']."</td></tr>";
                                echo "<tr><td colspan='1' style='border-bottom: 0px; font-size: .9em;color: #8DB38B;'>Category: ".$row['category_name']."</td><td style='border-bottom: 0px; text-align:right;'><span><a href='post.php?id=".$row['ID']."'>View comments...</a></span></td></tr>";
                                echo "</table>";
                            }
                        } else {
                            echo "There are no posts.<br>";
                        }

                        $conn->close();
                        ?>
                    </div>
                    <?php
                } else {
                ?>
                <?php
                }
                ?>
            </div>
        </main>
    </body>
</html>
 
