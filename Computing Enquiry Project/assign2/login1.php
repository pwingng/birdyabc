

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="keywords" content="PHP, MySQL">
	<link rel="stylesheet" href="/cos10026/s103606281/assign2/styles/style.css">
	<title>Login Page</title>
</head> 
<body5>
<?php
     include 'header.inc';
  ?>
    <form action="validate.php" method="post">  <!-- link with validate.php -->
        <div class="login-boxx">
            <h1>Login</h1>
 
            <div class="textboxx">
                <i class="fa fa-user" aria-hidden="true"></i>
                <input type="text" placeholder="Username"
                         name="username" value="">
            </div>
 
            <div class="textboxx">
                <i class="fa fa-lock" aria-hidden="true"></i>
                <input type="password" placeholder="Password"
                         name="password" value="">
            </div>
 
            <input class="buttonn" type="submit"
                     name="login" value="Sign In">

            <!-- Adding the new button linking to manage_registration.php -->
            <a href="manager_registration.php" class="buttonn">Manager Registration</a>
        </div>
    </form>
    <?php if (isset($_GET['error'])) : ?>     <!-- error message when anything goes wrong -->
            <div class="error-message">
                <?php echo $_GET['error']; ?>
            </div>
        <?php endif; ?>
    </div>

</body5>
</html>
