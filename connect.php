<?php
session_start();

DEFINE('DB_user', 'jackh@jackvhallmysql');
DEFINE('DB_PWD', 'Rivers360');
DEFINE('DB_host', 'jackvhallmysql.mysql.database.azure.com');
DEFINE('DB_name', 'blog_project');

$conn = new mysqli();
$conn->init();

// below contains certificate path required in azure 
$conn->ssl_set(NULL,NULL, "BaltimoreCyberTrustRoot.crt.pem", NULL, NULL);

// below is certificate path for local testing
// $conn->ssl_set(NULL,NULL, "C:/ssl/BaltimoreCyberTrustRoot.crt.pem", NULL, NULL);

$conn->real_connect(DB_host, DB_user, DB_PWD, DB_name, 3306, MYSQLI_CLIENT_SSL);

if ($conn->connect_error) {
    die ("Could not connect. ". $conn->connect_error);
}

?>