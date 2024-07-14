<?php
    $host = "feenix-mariadb.swin.edu.au";
    $user = "s104226143";
    $pwd = "040304";
    $sql_db = "s104226143_db";
    $conn = new mysqli($host, $user, $pwd, $sql_db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>