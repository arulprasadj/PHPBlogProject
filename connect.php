<?php
session_start();

DEFINE('DB_user', 'jackh@jackvhallmysql');
DEFINE('DB_PWD', 'Rivers360');
DEFINE('DB_host', 'jackvhallmysql.mysql.database.azure.com');
DEFINE('DB_name', 'blog_project');

$conn = new mysqli();
$conn->init();
$conn->ssl_set(NULL,NULL, "/var/www/html/BaltimoreCyberTrustRoot.crt.pem", NULL, NULL);
$conn->real_connect(DB_host, DB_user, DB_PWD, DB_name, 3306, MYSQLI_CLIENT_SSL);

if ($conn->connect_error) {
    die ("Could not connect. ". $conn->connect_error);
}

?>