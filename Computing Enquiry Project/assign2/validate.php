<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="description" content="COS10026 Lab 10">
    <meta name="keywords" content="PHP, MySQL">
    <meta name="author" content="Pui Wing Ng">
</head>
<body>
<?php
session_start(); // Start the session at the very beginning

include_once('settings.php');

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);

    // Fetch user details based on the username
    $stmt = $conn->prepare("SELECT password FROM managers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if ($password == $user['password']) {
            header("location: manage.php");
            exit();
        }
    }
    
    // If login fails, and only 4 attempts to login, if wrong it will goes to sorry.php 
    $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;

    if ($_SESSION['login_attempts'] >= 4) {     //4 login attempts    
        unset($_SESSION['login_attempts']);
        header("Location: sorry.php");     //sorry.php if wrong 
        exit();
    } else {  //if type in wrong, a warning signal will appear 
        header("Location: login1.php?error=Incorrect login credentials. You have " . (4 - $_SESSION['login_attempts']) . " attempts remaining.");
        exit();
    }
}

?>
</body>
</html>