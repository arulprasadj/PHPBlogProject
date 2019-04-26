<?php
require_once('config.php');
if (empty($_SESSION['loggedin'])) {
    header('location: login.php');
    exit();
}
if (!empty($_GET)) {
    $search = $_GET['search'];

    $sql = <<<SQL
    SELECT * FROM `posts`
    JOIN `categories` ON
    `posts`.`category_id`=`categories`.`category_id`
    WHERE `Title` LIKE '%{$search}%'
    OR
    `Content` LIKE '%{$search}%'
SQL;

    $results = $conn->query($sql);
}

?>


<?php
include 'shared/header.php';
?>
<main>
    <h1>Search</h1>
    <form method="GET">
        <input type="text" name="search" placeholder="Enter search term...">
        <input type="submit" value="Submit">
</form>

<div class="search-results">
<table>
    <?php
    if (!empty($_GET)) {
        ?>
        <tr><th>ID</th><th>Title</th><th>Content</th><th>Date</th><th>Author</th><th>Category</th></tr>
        <?php
        while ($row = $results->fetch_assoc()) {
            ?>
            <tr><td><?=$row['ID'] ?></td><td><a href="posts.php#<?=$row['ID'] ?>"><?=$row['Title'] ?></a></td><td><?=substr($row['Content'], 0, 100) . "..." ?></td><td><?=$row['Date'] ?></td><td><?=$row['Author'] ?></td><td><?=$row['category_name'] ?></td></tr>
            <?php
        }
    }  
    ?>
</table>
</div>
</main>
<?php
include 'shared/footer.php';
?>