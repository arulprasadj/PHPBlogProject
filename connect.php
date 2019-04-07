<?php
session_start();

DEFINE('DB_user', 'root');
DEFINE('DB_PWD', 'root');
DEFINE('DB_host', 'localhost');
DEFINE('DB_name', 'blog_project');

$conn = new mysqli(DB_host, DB_user, DB_PWD, DB_name);

if ($conn->connect_error) {
    die ("Could not connect. ". $conn->connect_error);
}

?>