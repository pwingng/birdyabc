<!DOCTYPE html>
<html lang ="en">
    <head>
        <meta charset ="utf-8">
    <!-- Linking external CSS and fonts -->
    <link rel="stylesheet" href="/cos10026/s103606281/assign2/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/cos10026/s103606281/assign1/images/favicon.ico">
        <title>Application form summary</title>
    </head>
    <body>
        <?php
        $errors = [];
        session_start();

        $jobreferenceNumber = $firstname = $lastname = $dob = $gender = $streetaddress = $suburb = $state = $postcode = $email = $phoneNumber = $skills = $EssentialSkill = $PreferredSkill = $otherskills = "";

        //Open connection
        require_once("settings.php");
        $conn = mysqli_connect($host, $user, $pwd, $sql_db);
        //Checks whether connection is successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql_table ="job_applications" ;

        //Redirect
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: IT_apply.php'); 
            exit;
        }

        // Sanitise function
        function sanitise_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

       

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(!empty($_POST["jobreferenceNumber"])) {
                $jobreferenceNumber =$_POST["jobreferenceNumber"];
                $pattern ='/^(?=.*[a-zA-Z])(?=.*\d).{5}$/';
      
            if (preg_match($pattern,$jobreferenceNumber)) {
                $jobreferenceNumber =$_POST["jobreferenceNumber"];
            } else {
                $errors['jobreferenceNumber'] = "Invalid job reference number.";
                $_SESSION['errors'] = $errors;
            }
            } else {
                $errors['jobreferenceNumber'] = "Job reference number is required.";
                $_SESSION['errors'] = $errors;
            }
        }

        //First name
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(!empty($_POST["firstname"])) {
                $firstname = $_POST["firstname"];
                $pattern = '/^[A-Za-z\s]{1,20}$/';
        
            if (preg_match($pattern, $firstname)) {
                $firstname = $_POST["firstname"];
            } else {
                $errors['firstname'] = "Invalid first name.";
                $_SESSION['errors'] = $errors;
               
            }
            } else {
                $errors['firstname'] = "First name is required.";
            }
                $_SESSION['errors'] = $errors;
        }

        //Last name
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST["lastname"])) {
                $lastname =$_POST["lastname"];
            $pattern = '/^[A-Za-z\s]{1,20}$/';

            if (preg_match($pattern, $lastname)) {
                $lastname =$_POST["lastname"];
            } else {
                $errors['lastname'] = "Invalid last name.";
                $_SESSION['errors'] = $errors;
              
            }
            } else {
                $errors['lastname'] = "Last name is required.";
                $_SESSION['errors'] = $errors;
            }
        }
        
        // Date of birth
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if 'dob' input is set and not empty
            if (!empty($_POST["dob"])) {
                $dob = $_POST["dob"];
                $pattern = '/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19[0-9]{2}|2000)$/';
                if (preg_match($pattern, $dob)) {
                    // If the pattern matches, proceed
                    $dob = $_POST["dob"];
                } else {
                    // If the pattern does not match, set an error
                    $errors['dob'] = "Invalid date of birth.";
                    $_SESSION['errors'] = $errors;
                }
            } else {
                // If 'dob' input is empty, set an error
                $errors['dob'] = "Date of birth is required.";
                $_SESSION['errors'] = $errors;
            }
        }
        

        //Gender
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $gender = $_POST["gender"];
        }
        else {
            $gender = "Unknown gender";
        }

        //Street address
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(!empty($_POST["streetaddress"])) {
                $streetaddress = $_POST["streetaddress"];
            $pattern = '/^[a-zA-Z0-9\s]{1,40}$/';
            if (preg_match($pattern,$streetaddress)) {
                $streetaddress = $_POST["streetaddress"];
            } else {
                $errors['streetaddress'] = "Invalid street address.";
                $_SESSION['errors'] = $errors;
            }
            } else {
                $errors['streetaddress'] = "Street address is required.";
                $_SESSION['errors'] = $errors;
            }
        }
        
        //Suburb
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(!empty($_POST["suburb"])) {
                $suburb = $_POST["suburb"];
            $pattern = '/^[A-Za-z\s]{1,40}$/';
            if (preg_match($pattern, $suburb)) {
                $suburb = $_POST["suburb"];
            } else {
                $errors['suburb'] = "Invalid suburb.";
                $_SESSION['errors'] = $errors;
            }
            } else {
                $errors['suburb'] = "Suburb is required.";
                $_SESSION['errors'] = $errors;
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (!empty($_POST['state']) && !empty($_POST['postcode'])) {
                $state = $_POST['state'];
            $postcode = $_POST['postcode'];

            if ($state == 'ACT') {
                $pattern = '/^(020[0-9]|021[0-9]|022[0-9]|023[0-9]|024[0-9]|025[0-9]|026[0-9]|027[0-9]|028[0-9]|029[0-9]|260[0-9]|261[0-9])$/';

            if (preg_match($pattern, $postcode)) {
                $postcode = $_POST['postcode'];
            } else {
                $errors['postcode'] = "Invalid postcode.";
                $_SESSION['errors'] = $errors;
                
            }
        }
            if ($state == 'VIC') {
                $pattern = '/^(3[0-9]{3}|8[0-9]{3})$/';

                if(preg_match($pattern,$postcode)) {
                    $postcode = $_POST['postcode'];
                }
                else {
                    $errors['postcode'] = "Invalid postcode.";
                    $_SESSION['errors'] = $errors;
                    
                }
            }
            if ($state == 'NSW') {
                $pattern ='/^(1[0-9]{3}|2[6-8][19-99]|29[21-99])$/';

                if(preg_match($pattern,$postcode)) {
                    $postcode = $_POST['postcode'];
                } else {
                    $errors['postcode'] = "Invalid postcode.";
                    $_SESSION['errors'] = $errors;
                    
                }
            }

            if ($state =='QLD') {
                $pattern ='/^(4\d{3}|9\d{3})$/';

                if(preg_match($pattern,$postcode)) {
                    $postcode = $_POST['postcode'];
                } else {
                    $errors['postcode'] = "Invalid postcode.";
                    $_SESSION['errors'] = $errors;
                    
                }
            }

            if($state =='NT') {
                $pattern = '/^(08[0-9]{2}|09[0-9]{2})$/';

                if(preg_match($pattern,$postcode)) {
                    $postcode = $_POST['postcode'];
                } else{
                    $errors['postcode'] = "Invalid postcode.";
                    $_SESSION['errors'] = $errors;
                    
                }
            }

            if ($state =='WA') {
                $pattern = '/^6([0-7][00-97]|[89][00-99])$/';

                if (preg_match($pattern,$postcode)){
                    $postcode = $_POST['postcode'];
                }else{
                    $errors['postcode'] = "Invalid postcode.";
                    $_SESSION['errors'] = $errors;
                    
                }
            }

            if($state =='SA') {
                $pattern = '/^5[0-9]{3}$/';

                if (preg_match($pattern,$postcode)) {
                    $postcode = $_POST['postcode'];
                } else {
                    $errors['postcode'] = "Invalid postcode.";
                    $_SESSION['errors'] = $errors;
                   
                }
            }

            if ($state =='TAS') {
                $pattern = '/^(700[0-9]|7[0-7][0-9]{2}|78[0-9]{2}|79[0-9]{2})$/';

                if(preg_match($pattern,$postcode)) {
                    $postcode = $_POST['postcode'];
                } else {
                    $errors['postcode'] = "Invalid postcode.";
                    $_SESSION['errors'] = $errors;
                    
                }
            }
            } else {
                // State or postcode is empty, set an error for each one that is empty
                if (empty($_POST['state'])) {
                    $errors['state'] = "State is required.";
                    $_SESSION['errors'] = $errors;
                }
                if (empty($_POST['postcode'])) {
                    $errors['postcode'] = "Postcode is required.";
                    $_SESSION['errors'] = $errors;
                }
            }
        }

        //Email
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(!empty($_POST["email"])) {
                $email =$_POST["email"];
            $pattern ='/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            if (preg_match($pattern,$email)) {
                $email =$_POST["email"];
            }
            else {
                $errors['email'] = "Invalid email.";
                $_SESSION['errors'] = $errors;
            }
            } else {
                $errors['email'] = "Email is required.";
                $_SESSION['errors'] = $errors;
            }
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(!empty($_POST["phoneNumber"])) {
                $phoneNumber = $_POST["phoneNumber"];
            $pattern = '/^\d{8,12}$/';
            if(preg_match($pattern,$phoneNumber)) {
                $phoneNumber = $_POST["phoneNumber"];
            } else {
                $errors['phoneNumber'] = "Invalid phone number.";
                $_SESSION['errors'] = $errors;
            }
            } else {
                $errors['phoneNumber'] = "Phone number is required.";
                $_SESSION['errors'] = $errors;
            } 
        }
        
        if (isset($_POST["EssentialSkill"])) {
            $EssentialSkillArray = $_POST["EssentialSkill"];
            // Sanitize each input
            $EssentialSkillArray = array_map('sanitise_input', $EssentialSkillArray);
            // Convert the array to a comma-separated string
            $essentialSkillsString = "&bull; " . implode("<br>&bull; ", $EssentialSkillArray);
        } else {
            $essentialSkillsString = ""; // No essential skills selected
        }

        // Preferred Skills
        if (isset($_POST["PreferredSkill"])) {
            $PreferredSkillArray = $_POST["PreferredSkill"];
            // Sanitize each input
            $PreferredSkillArray = array_map('sanitise_input', $PreferredSkillArray);
            // Convert the array to a comma-separated string
            $preferredSkillString = "&bull; " . implode("<br>&bull; ", $PreferredSkillArray);
        } else {
            $preferredSkillString = ""; // No preferred skills selected
        }

            // Check if the 'otherskills_checkbox' is checked
            if (isset($_POST['otherskills_checkbox'])) {
                // Trim the input from 'otherskills' text box
                $trimmed_otherskills = trim($_POST['otherskills']);
                // Check if the trimmed value is empty
                if (empty($trimmed_otherskills)) {
                    // Set an error message if the variable is empty
                    $errors['otherskills'] = "Please enter details for other skills.";
                    $_SESSION['errors'] = $errors;
                } else {
                    // If 'otherskills' is not empty, assign the trimmed value
                    // Sanitization is done later, as you requested
                    $otherskills = $trimmed_otherskills;
                }
            }
        

        // Sanitise special characters
        $job_reference = sanitise_input($jobreferenceNumber);
        $first_name = sanitise_input($firstname);
        $last_name = sanitise_input($lastname);
        $date_of_birth = sanitise_input($dob);
        $gender = sanitise_input($gender);
        $street_address = sanitise_input($streetaddress);
        $suburb_town = sanitise_input($suburb);
        $state = sanitise_input($state);
        $postcode = sanitise_input($postcode);
        $email = sanitise_input($email);
        $phone_number = sanitise_input($phoneNumber);
        $other_skills = sanitise_input($otherskills);

        // Check for any errors
        if (count($errors) == 0 ) {
        
            //Insert information to table
        $query = "INSERT INTO $sql_table ( job_reference, first_name, last_name, date_of_birth, gender, street_address, suburb_town, state, postcode, email, phone_number, EssentialSkill, PreferredSkill, other_skills) VALUES ('$job_reference', '$first_name', '$last_name', '$date_of_birth', '$gender', '$street_address', '$suburb_town', '$state','$postcode', '$email', '$phone_number', '$essentialSkillsString', '$preferredSkillString', '$other_skills')";

        //Execute query
        $result = mysqli_query($conn, $query);

        // Get the last inserted ID
        $last_id = mysqli_insert_id($conn);
        // Checks whether query is executed successfully
        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        //Succesful message
        $_SESSION['success_message'] = "Thank you for applying in Swift ! Your EOI number is $last_id";
        // Redirect back to the form
        header("Location: IT_apply.php");
        exit;

        // Close database
        mysqli_close($conn);
        } else {
            // Store errors and form input in session
        $_SESSION['errors'] = $errors;
        $_SESSION['form_input'] = $_POST;

        // Redirect back to the form
        header("Location: IT_apply.php"); // Adjust if necessary to your form's URL
        exit();
        }

        ?>
    </body>
</html>