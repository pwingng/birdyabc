<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset = "utf-8">
        <!-- Linking external stylesheets and fonts -->
        <link rel="stylesheet" href="/cos10026/s103606281/assign1/styles/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
        <!-- Favicon for the webpage -->
        <link rel="icon" type="image/x-icon" href="/cos10026/s103606281/assign1/images/favicon.ico">
        <title>Account registration</title>
    </head>
    <body>
        <?php 
    $errors = [];
    session_start();
        //Open connection
        require_once("settings.php");
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
        $sql_table = "managers";

        //Redirect
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: manager_registration.php'); 
            exit;
        }

        // Sanitise function
        function sanitise_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //Username
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
        }

        //Password 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $_POST["password"];
            $pattern = '/^(?=.*[A-Z])(?=.*\d).{8,}$/';
        }

        if (!preg_match($password,$pattern)) {
            $_SESSION['errors']['password'] = "Invalid password.";
        }

        $username = sanitise_input($username) ;
        $password = sanitise_input($password);

        if (count($errors) == 0) {

            //Insert information to table
            $query = "INSERT INTO $sql_table (username, password ) VALUES ('$username', '$password')";
    
            //Execute query
            $result = mysqli_query($conn, $query);
    
    
            //Succesful message
            $_SESSION['success_message'] = "Thank you for registering account ! ";
            // Redirect back to the form
            header("Location: manager_registration.php");
            exit;
    
            // Close database
            mysqli_close($conn);
    
            } else {
                $_SESSION['errors'] = $errors;
        
                // Redirect back to the form
                header("Location: manager_registration.php");
                exit;
            }

        ?>
    </body>
</html>