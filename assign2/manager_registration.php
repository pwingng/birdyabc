<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="utf-8">
        <!-- Linking external stylesheets and fonts -->
        <link rel="stylesheet" href="/cos10026/s103606281/assign2/styles/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
        <!-- Favicon for the webpage -->
        <link rel="icon" type="image/x-icon" href="/cos10026/s103606281/assign1/images/favicon.ico">
        <title>Account Registration</title>
    </head>
    <body class = "btt-body">
    <?php
     include 'header.inc';
     session_start();
    ?>
     <?php
        if (isset($_SESSION['success_message'])) {
        echo "<div class='success-message'>" . $_SESSION['success_message'] . "</div>";
        // Optionally, unset the success message after displaying it to ensure it's not shown again on page refresh
        unset($_SESSION['success_message']);
        }
    ?>
        <form action="manager_database.php" method="post">
        <div class="login-boxx">
            <h1>Register Account</h1>
        <!-- Username-->
            <div class="textboxx">
                <i class="fa fa-user" aria-hidden="true"></i>
                <input type="text" placeholder="Username"
                         name="username" value="" required = "required">
            </div>
        <!--Password-->
            <div class="textboxx">
                <i class="fa fa-lock" aria-hidden="true"></i>
                <input type="password" placeholder="Password"
                         name="password" value="" pattern = "^(?=.*[A-Z])(?=.*\d).{8,}$" title = " 8 or more characters, contains at least one uppercase letter and at least one number " required = "required" >
                         <?php
                if (isset($_SESSION['errors']['jobreferenceNumber'])) {
                echo "<span class='error'>" . $_SESSION['errors']['jobreferenceNumber'] . "</span>";
                unset($_SESSION['errors']['jobreferenceNumber']);
                }
            ?>
            </div>
            <!--Register-->
            <input class="buttonn" type="submit"
                     name="login" value="Register">
                     <a href = "login1.php" class = "buttonn">Return to login page</a>
        </div>
    </form>
    
    </body>
</html>