<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhancements</title>
    <link rel="stylesheet" href="/cos10026/s103606281/assign2/styles/style.css">
</head>
<?php
include 'header.inc';
?>
<body>
    <h1 class="custom-header">Enhancements of assignment 2</h1>
    <table class="custom-table">
        <tr>
            <th>Enhancement</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <tr>
            <td class="custom-cell">Enhancement 1: Login Portal and Security</td>
            <td class="custom-cell">Accessing the manage.php portal requires the use of valid manager credentials. In order to enhance security measures, a username and password specific to authorized managers are mandatory for login. Additionally, the system allows for up to four login attempts, providing an added layer of security to safeguard sensitive information and control access.</td>
            <td class="custom-cell"><a href="login1.php" class="buttonn">Click to try</a></td>
        </tr>
        <tr>
            <td class="custom-cell">Enhancement 2: Registration</td>
            <td class="custom-cell">This procedure facilitates the onboarding process for new managers, allowing them to establish a unique username and password that they can use for future login sessions. It's important to note that initiating this action necessitates obtaining prior permission from the manage.php system, ensuring that access to managerial functions remains controlled and secure.</td>
            <td class="custom-cell"><a href="manager_registration.php" class="buttonn">Click to try</a></td>
        </tr>
        <tr>
            <td class="custom-cell">Enhancement 3: Search</td>
            <td class="custom-cell">This function can filter from the data base the specifific information that tha manager want. </td>
            <td class="custom-cell"><a href="manage.php" class="buttonn">Click to try</a></td>
        </tr>
    </table>

    <a href="enhancements.php" class="buttonn">Assignment 1 enhancements</a>

<?php
include 'footer.inc';
?>
</body>
</html>
