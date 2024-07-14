<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metadata of the document -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Computing Inquiring project Swift Outsourcing Company">
    <meta name="keywords" content="HTML, CSS">
    <meta name="author" content="Pui Wing Ng">

    <title>Swift Careers Home page</title>

    <!-- Linking external CSS and fonts -->
    <link rel="stylesheet" href="/cos10026/s103606281/assign2/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/cos10026/s103606281/assign1/images/favicon.ico">
</head>
<body class="btt-body">
  <?php
     include 'header.inc';
  ?>

    <!-- Parallax section with call to action buttons -->

    <section class="home-parallax">
        <a href="jobs.php">
            <div class="button-35">
                VACCANT POSITIONS
            </div>
        </a>
        <br>
        <a href="apply.php">
            <div class="button-35-apply-button">
                APPLICATION FORM
            </div>
        </a>
    </section>

    <!-- Main content area -->
    <section class="home-scrolling-content">
        <!-- Job secured section -->
        <h1 class="pulse-text">Job Secured</h1>
        <br>
        <!-- Company tagline -->
        <h2>Outsource with Confidence, Outperform with Swift.</h2>
        <br>
        <br>
        <br>
        <!-- Brief about the company -->
        <h3>
            SWIFT is a network of connected, young and passionate software engineers.<br>
            Our vision is to become a symbol of software outsourcing development.
        </h3>

        <!-- Learn More link -->
        <a href="index.php" class="learn-more">
            <span class="circle" aria-hidden="true">
                <span class="icon arrow"></span>
            </span>
            <br>
            <span class="button-text">
                Learn More
            </span>
        </a>
     
    </section>

   
<!-- Footer -->
<?php
     include 'footer.inc';
  ?>

<a id="btt-back-to-top" href="#">👆🏼</a>
</body>
</html>
