<?php
echo <<<HTML
    <header>
        <section class="header-nav">
            <!-- Company logo -->
            <div class="logo">
                <a href="home.php" title="Return to Swift Home Page"><img src="/cos10026/s103606281/assign1/images/Swiftcareerlogo.png" alt="SWIFT" width="400" height="240"></a>
            </div>

            <!-- Navigation buttons -->
            <div class="top-buttons">
                    <a class="button type1 dropdown-toggle" href="home.php" title="Return to Swift Home Page">Home</a>

                <a class="button type1" href="index.php" title="About Swift">About us</a>

                <!-- Careers dropdown menu -->
                <div class="dropdown">
                    <a class="button type1 dropdown-toggle" href="jobs.php" title="Overview of Vaccant Jobs">Careers</a>
                    <div class="dropdown-content">
                        <a class="button type1" href="softwareengineer.php" title="Software Engineer Job Description ">SW Engineer</a>
                        <a class="button type1" href="sales.php" title="Sales Job Description ">Sales</a>
                    </div>
                </div>

                <!-- Apply dropdown menu -->
                <div class="dropdown">
                    <a class="button type1 dropdown-toggle" href="apply.php" title="Vaccant jobs">Apply</a>
                    <div class="dropdown-content">
                        <a class="button type1" href="IT_apply.php" title="Apply for Software Engineer Job">SW Engineer</a>
                        <a class="button type1" href="sales_apply.php" title="Apply for Sales Job">Sales</a>
                    </div>
                </div>

             <a class="button type1" href="login1.php" title="Go to Manager login Page">Manager Login</a>

                <!-- Other buttons -->
                <a class="button type1" href="about.php" title="Return to Group Details Page">Developers</a>
                    <div class="dropdown">
                    <a class="button type1 dropdown-toggle" href="enhancements.php" title="Assignment1 enhancement">htmlEnhancement</a>
                    <div class="dropdown-content">
                        <a class="button type1" href="phpenhancements.php" title="Assign2 enhancement">phpEnhancement</a>
                    </div>
                </div>
            </div>
        </section>
    </header>
</body>
HTML;
?>
