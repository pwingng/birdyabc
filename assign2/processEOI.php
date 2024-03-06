<!DOCTYPE html>
<html lang ="en">
    <head>
        <meta charset ="utf-8">
        <link rel="icon" type="image/x-icon" href="https://cdn.glitch.global/e3f92662-ec3a-49c7-a11f-46d27e5185a1/favicon.ico?v=1693653269634">
        <link href="/cos10026/s103606281/assign2/styles/style.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
        <title>Application form summary</title>
    </head>
    <body>
        <?php

        $jobreferenceNumber = $firstname = $lastname = $dob = $gender = $streetaddress = $suburb = $state = $postcode = $email = $phoneNumber = $otherskills = "";

        //Open connection
        require_once("settings.php");
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
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

        // Generate EOI number function
        function generateEOINumber($prefix) {
            // Generate a random 7-digit number
            $randomNumber = mt_rand(1000000, 9999999);
        
            // Calculate a checksum digit
            $checksum = 0;
            $digits = str_split($randomNumber);
            foreach ($digits as $digit) {
                $checksum += $digit;
            }
            $checksum = $checksum % 10;
        
            // Combine the prefix, random number, and checksum to create the EOINumber
            $eoiNumber = $prefix . $randomNumber . $checksum;
        
            return $eoiNumber;
        }
        
        echo"<p>Thank you for applying Swift</p>
            <p>This is your information : </p>";

        // Call the EOi number function
        $eoiNumber = generateEOINumber('EOI');

        echo"Your EOI number is $eoiNumber.</p>";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $jobreferenceNumber =$_POST["jobreferenceNumber"];
            $pattern ='/^[a-zA-Z0-9]{5}$/';
      
            if (preg_match($pattern,$jobreferenceNumber)) {
                echo "<p>The job reference number is $jobreferenceNumber</p>";
            } else {
                echo "<p>Invalid job reference number</p>";
            }
        }

        //First name
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $firstname = $_POST["firstname"];
            $pattern = '/^[A-Za-z\s]{1,20}$/';
        
            if (preg_match($pattern, $firstname)) {
                echo "<p>Your first name is $firstname.</p>";
            } else {
                echo "<p>Invalid firstname.</p>";
                $firstname = null; 
            }
        }

        //Last name
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $lastname =$_POST["lastname"];
            $pattern = '/^[A-Za-z\s]{1,20}$/';

            if (preg_match($pattern, $lastname)) {
                echo "<p>Your last name is $lastname.</p>";
            } else {
                echo "<p>Invalid lastname.</p>";
                $lastname = null;
            }
        }
        
        // Date of birth
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dob = $_POST["dob"];
            $pattern = '/^(1[5-9]|[2-7]\d|80)\/(0[1-9]|1[0-2])\/(19\d\d|20[01][0-9]|202[0-3])$/';
            if (preg_match($pattern,$dob)) {
                echo "<p>Your date of birth is $dob.</p>";
            } else {
                echo "<p>Invalid date of birth.</p>";
                $dob = null;
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
            $streetaddress = $_POST["streetaddress"];
            $pattern = '/^[a-zA-Z0-9\s]{1,40}$/';
            if (preg_match($pattern,$streetaddress)) {
                echo "<p>Your street address is $streetaddress</p>.";
            } else {
                echo "<p> Invalid street address.</p>";
                $streetaddress = null;
            }
        }
        
        //Suburb
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $suburb = $_POST["suburb"];
            $pattern = '/^[A-Za-z]{1,40}$/';
            if (preg_match($pattern, $suburb)) {
                echo "<p>Your suburb is $suburb";
            } else {
                echo"<p>Invalid suburb</p>";
                $suburb = null;
            }
        }

        //State and postcode
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $state = $_POST['state'];
            $postcode = $_POST['postcode'];

            if ($state == 'ACT') {
                $pattern = '/^(020[0-9]|021[0-9]|022[0-9]|023[0-9]|024[0-9]|025[0-9]|026[0-9]|027[0-9]|028[0-9]|029[0-9]|260[0-9]|261[0-9])$/';

            if (preg_match($pattern, $postcode)) {
                echo "<p>Your ACT postcode is $postcode.</p>";
            } else {
            echo "<p>Invalid ACT postcode.</p>";
            }
        }
            if ($state == 'VIC') {
                $pattern = '/^(3[0-9]{3}|8[0-9]{3})$/';

                if(preg_match($pattern,$postcode)) {
                    echo" <p>Your VIC postcode is $$postcode.</p>";
                }
                else {
                    echo"<p>Invalid VIC postcode.</p>";
                }
            }
            if ($state == 'NSW') {
                $pattern ='/^(1[0-9]{3}|2[6-8][19-99]|29[21-99])$/';

                if(preg_match($pattern,$postcode)) {
                    echo"<p>Your NSW postcode is $postcode.</p>";
                } else {
                    echo "<p>Invalid NSW postcode</p>";
                }
            }

            if ($state =='QLD') {
                $pattern ='/^(4\d{3}|9\d{3})$/';

                if(preg_match($pattern,$postcode)) {
                    echo"<p>Your QLD postcode is $postcode.</p>";
                } else {
                    echo"<p>Invalid QLD postcode</p>";
                }
            }

            if($state =='NT') {
                $pattern = '/^(08[0-9]{2}|09[0-9]{2})$/';

                if(preg_match($pattern,$postcode)) {
                    echo"<p>Your NT postcode is $postcode.</p>";
                } else{
                    echo"<p>Invalid NT postcode</p>";
                }
            }

            if ($state =='WA') {
                $pattern = '/^6([0-7][00-97]|[89][00-99])$/';

                if (preg_match($pattern,$postcode)){
                    echo"<p>Your WA postcode is $postcode.</p>";
                }else{
                    echo"<p>Invalid WA postcode</p>";
                }
            }

            if($state =='SA') {
                $pattern = '/^5[0-9]{3}$/';

                if (preg_match($pattern,$postcode)) {
                    echo "<p>Your SA postcode is $postcode.</p>";
                } else {
                    echo "<p>Invalid SA postcode</p>";
                }
            }

            if ($state =='TAS') {
                $pattern = '/^(700[0-9]|7[0-7][0-9]{2}|78[0-9]{2}|79[0-9]{2})$/';

                if(preg_match($pattern,$postcode)) {
                    echo"<p>Your TAS postcode is $postcode.</p>";
                }
            }
        } 

        //Email
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email =$_POST["email"];
            $pattern ='/^(?i)[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            if (preg_match($pattern,$email)) {
                echo"<p>Your email is $email</p>";
            }
            else {
                echo"<p>Invalid email</p>";
                $email = null;
            }
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $phoneNumber = $_POST["phoneNumber"];
            $pattern = '/^[0-9\s]{8,12}$/';
        }
        else {
            echo "<p>Please enter in the right format.</p>";
            $phoneNumber = null;
        }
        
        if (isset($_POST['submit'])) {  // Check if form is submitted
            if (isset($_POST['other'])) {  // Check if checkbox is selected
                $otherskills = trim($_POST['otherskills']);  // Get and trim the textbox value
        
                if (empty($otherskills)) {  // Check if textbox is empty
                    echo "<p>Please fill out the other skills textbox.</p>";
            } else 
            echo"<p>Your other skills are $otherskills</p>.";
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

        //Insert information to table
        $query = "INSERT INTO $sql_table (job_reference, first_name, last_name, date_of_birth, gender, street_address, suburb_town, state, postcode, email, phone_number, other_skills) VALUES ('$job_reference', '$first_name', '$last_name', '$date_of_birth', '$gender', '$street_address', '$suburb_town', '$state','$postcode', '$email', '$phone_number','$other_skills')";


        //Execute query
        $result = mysqli_query($conn, $query);
        
        // Close database
        mysqli_close($conn);
        ?>
    </body>
</html>