<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta name="description"	content="COS10026 Lab 10">
	<meta name="keywords"		content="Swinburne COS10026 Lab10 PHP and MySQL Database Operations">	
	<meta name="author"			content="Pui Wing Ng">
    <link rel="stylesheet" href="/cos10026/s103606281/assign2/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">

    <!-- Website favicon -->
    <link rel="icon" type="image/x-icon" href="/cos10026/s103606281/assign1/images/favicon.ico">
    <title>Retrieving records to HTML</title>
</head>
<body>
<?php
     include 'header.inc';
  ?>
 <a href="logout.php" class="buttonn">Log out</a>

<?php 
require_once ("settings.php"); //database info

$mysqli = new mysqli($host, $user, $pwd, $sql_db);
$sql_table = "job_applications"; // Define this variable here

if ($mysqli->connect_error) {
    die("<p class='error-msg'>Database connection failure.</p>");
}

// Handle status update
if (isset($_POST["update_status"])) {
    $new_status = $_POST["new_status"];
    $eoiNumber_to_update = $_POST["eoiNumber_to_update"];
    
    $stmt = $mysqli->prepare("UPDATE $sql_table SET status = ? WHERE eoiNumber = ?");
    
    if ($stmt === false) {
        die("<p>Error preparing statement: " . $mysqli->error . "</p>");
    }

    $stmt->bind_param('ss', $new_status, $eoiNumber_to_update);

    if ($stmt->execute()) {
        echo "<p>Status updated successfully!</p>";
    } else {
        echo "<p>Error updating status: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Display data
$query = "SELECT  status, eoiNumber, job_reference, first_name, last_name, date_of_birth, gender, street_address, suburb_town, state, postcode, email, phone_number, EssentialSkill, PreferredSkill, other_skills FROM $sql_table ORDER BY eoiNumber, first_name, last_name;";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    echo "<p class='error-msg'>Something is wrong with ", $query, "</p>";
} else {
    ?>

<a href="#" class="buttonn" onclick="location.reload();">Refresh Table</a>

 <?php
 echo "<div class='outer-wrapper'></div>";
echo  "<div class='table-wrapper'></div>";
    echo "<table class='styled-table'>";
    echo "<thead>";
    echo "<tr>
            <th class='column1'>Update Status</th>
            <th>status</th>
            <th>eoiNumber</th>
            <th>job_reference</th>
            <th>first_name</th>
            <th>last_name</th>
            <th>date_of_birth</th>
            <th>gender</th>
            <th>street_address</th>
            <th>suburb_town</th>
            <th>state</th>
            <th>postcode</th>
            <th>email</th>
            <th>phone_number</th>
            <th>EssentialSkill</th>
            <th>PreferredSkill</th>
            <th>other_skills</th>
          </tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($record = mysqli_fetch_assoc($result)) {
        $activeClass = ($record["status"] == "current") ? "active-row" : "";
        echo "<tr class='$activeClass'>";

        // Status update form for each row
        echo "<td>";
        echo "<form method='post'>";
        echo "<select name='new_status'>";
        echo "<option value='new' " . ($record["status"] == "new" ? "selected" : "") . ">New</option>";
        echo "<option value='current' " . ($record["status"] == "current" ? "selected" : "") . ">Current</option>";
        echo "<option value='final' " . ($record["status"] == "final" ? "selected" : "") . ">Final</option>";
        echo "</select>";
        echo "<input type='hidden' name='eoiNumber_to_update' value='" . $record["eoiNumber"] . "'>";
        echo "<input type='submit' name='update_status' value='Update'>";
        echo "</form>";
        echo "</td>";

        echo "<td class='column1'>", $record["status"], "</td>";
        echo "<td>", $record["eoiNumber"], "</td>";
        echo "<td>", $record["job_reference"], "</td>";
        echo "<td>", $record["first_name"], "</td>";
        echo "<td>", $record["last_name"], "</td>";
        echo "<td>", $record["date_of_birth"], "</td>";
        echo "<td>", $record["gender"], "</td>";
        echo "<td>", $record["street_address"], "</td>";
        echo "<td>", $record["suburb_town"], "</td>";
        echo "<td>", $record["state"], "</td>";
        echo "<td>", $record["postcode"], "</td>";
        echo "<td>", $record["email"], "</td>";
        echo "<td>", $record["phone_number"], "</td>";
        echo "<td>", $record["EssentialSkill"], "</td>";
        echo "<td>", $record["PreferredSkill"], "</td>";
        echo "<td>", $record["other_skills"], "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    mysqli_free_result($result);    //free the memory
}
mysqli_close($mysqli);
?>


<h1 class="search-title"> Search Form</h1>
<form method="post" action="" class="search-form">
    <fieldset class="search-fieldset">
        <legend>Search Job Details</legend>
        <p class="row">
            <label for="eoiNumber">EOI </label>
            <input type="text" name="eoiNumber" id="eoiNumber" />
        </p>
        <p class="row">
            <label for="job_reference">Job Reference Number:: </label>
            <input type="text" name="job_reference" id="job_reference" />
        </p>
        <p class="row">
            <label for="first_name">First Name: </label>
            <input type="text" name="first_name" id="first_name" />
        </p>
        <p class="row">
            <label for="last_name">Last Name: </label>
            <input type="text" name="last_name" id="last_name" />
        </p>
        <p>
            <input type="submit" value="Search" />
        </p>
    </fieldset>
</form>

<?php
function sanitise_input($data) {
    $data = trim($data);                //remove spaces
    $data = stripslashes($data);       //remove backslashes in front of quotes
    $data = htmlspecialchars($data);    //convert HTML special characters to HTML code
    return $data;
}

if (isset($_POST["eoiNumber"]) || isset($_POST["job_reference"]) || isset($_POST["first_name"]) || isset($_POST["last_name"])) {


    //get information from form
    $eoiNumber = isset($_POST["eoiNumber"]) ? sanitise_input($_POST["eoiNumber"]) : '';
    $job_reference = isset($_POST["job_reference"]) ? sanitise_input($_POST["job_reference"]) : '';
    $first_name = isset($_POST["first_name"]) ? sanitise_input($_POST["first_name"]) : '';
    $last_name = isset($_POST["last_name"]) ? sanitise_input($_POST["last_name"]) : '';
    

    //condition to extract the data from the table
    $condition = "";
    if ($eoiNumber != "")        
        $condition .= "eoiNumber='$eoiNumber'";
    if ($job_reference != "") {
        if ($condition != "")
            $condition .= " and job_reference='$job_reference'";
        else
            $condition .= "job_reference='$job_reference'";
    }
    if ($first_name != "") {
        if ($condition != "")
            $condition .= " and first_name='$first_name'";
        else
            $condition .= "first_name='$first_name'";
    }
    if ($last_name != "") {
        if ($condition != "")
            $condition .= " and last_name='$last_name'";
        else
            $condition .= "last_name='$last_name'";
    }

    require_once("settings.php");    //database information
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);    //connect to database
    $sql_table = "job_applications";    //table's name
    $query = "select * from $sql_table where $condition;";        //MySQL command
    $result = mysqli_query($conn, $query);    //execute the query
    if (!$result) {        
        echo "<p class='error-msg'>Something is wrong with ", $query, "</p>";
    } else {
        echo "<table class='styled-table'>";
        echo "<thead><tr>
                    <th scope='col'>status</th>
                    <th scope='col'>eoiNumber</th>
                    <th scope='col'>job_reference</th>
                    <th scope='col'>first_name</th>
                    <th scope='col'>last_name</th>
                    <th scope='col'>date_of_birth</th>
                    <th scope='col'>gender</th>
                    <th scope='col'>street_address</th>
                    <th scope='col'>suburb_address</th>
                    <th scope='col'>state</th>
                    <th scope='col'>postcode</th>
                    <th scope='col'>email</th>
                    <th scope='col'>phone_number</th>
                    <th scope='col'>EssentialSkill</th>
                    <th scope='col'>PreferredSkill</th>
                    <th scope='col'>other_skills</th>

              </tr></thead><tbody>";
            while ($record = mysqli_fetch_assoc($result)) {
            $activeClass = ($record["status"] == "current") ? "active-row" : "";
            echo "<tr>\n";
            echo "<td>", $record["status"], "</td>";
            echo "<td>", $record["eoiNumber"], "</td>";
            echo "<td>", $record["job_reference"], "</td>";
            echo "<td>", $record["first_name"], "</td>";
            echo "<td>", $record["last_name"], "</td>";
            echo "<td>", $record["date_of_birth"], "</td>";
            echo "<td>", $record["gender"], "</td>";
            echo "<td>", $record["street_address"], "</td>";
            echo "<td>", $record["suburb_town"], "</td>";
            echo "<td>", $record["state"], "</td>";
            echo "<td>", $record["postcode"], "</td>";
            echo "<td>", $record["email"], "</td>";
            echo "<td>", $record["phone_number"], "</td>";
            echo "<td>", $record["EssentialSkill"], "</td>";
            echo "<td>", $record["PreferredSkill"], "</td>";
            echo "<td>", $record["other_skills"], "</td>";

            echo "</tr>\n";
        }
        echo "</tbody></table>";
        mysqli_free_result($result);
    }
    mysqli_close($conn);        
}
?>

<h1 class="search-title"> Delete with Job Reference Number</h1>
<form action="" method="post">
    <label for="job_reference">Enter job reference number to delete:</label>
    <input type="text" name="job_reference" id="job_reference">
    <input type="submit" name="delete_submit" value="Delete">
</form>

<?php
require_once("settings.php");    //database information
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);    //connect to database
$sql_table = "job_applications";    //table's name

if (isset($_POST['delete_submit'])) {
    $job_reference_to_delete = $_POST['job_reference'];

    $delete_query = "DELETE FROM $sql_table WHERE job_reference = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "s", $job_reference_to_delete);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "<p class='success-msg'>Record with job reference number {$job_reference_to_delete} has been deleted.</p>";
    } else {
        echo "<p class='error-msg'>No record found with job reference number {$job_reference_to_delete}. Please check the job reference number and try again.</p>";
    }
    mysqli_stmt_close($stmt);
}
?>


<?php
include 'footer.inc';
?>

</body>
</html>