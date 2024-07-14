<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="https://cdn.glitch.global/e3f92662-ec3a-49c7-a11f-46d27e5185a1/favicon.ico?v=1693653269634">
    <link href="/cos10026/s103606281/assign2/styles/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <title> 100K IT Sales Job Application Page</title>
</head>
<body class="btt-body">
    <!-- Header of the page -->
<?php
     include 'header.inc';
  ?>
      <h1 class = "IT_apply_header">IT Sales Job Application Page </h1>
  <div class ="content-container">
    <div class = "form_input">
      <p>
      <strong>Job Description</strong>
    </p>
     <p>
      <img src ="https://cdn.glitch.global/e3f92662-ec3a-49c7-a11f-46d27e5185a1/14432100661535698998-16.png?v=1696483408707" alt ="location">    Melbourne VIC
    </p>
     <p>
       <img src ="https://cdn.glitch.global/e3f92662-ec3a-49c7-a11f-46d27e5185a1/5340407521530272909-16.png?v=1696483103131" alt="building">    Sales
    </p>
      <p>
        <img src ="https://cdn.glitch.global/e3f92662-ec3a-49c7-a11f-46d27e5185a1/15192388931558965371-16.png?v=1696483486224" alt ="time">    Full time
      </p>
    <p>
      <img src ="https://cdn.glitch.global/e3f92662-ec3a-49c7-a11f-46d27e5185a1/5340407521530272909-16.png?v=1696483103131" alt ="salary">     $72000 a year
    </p>
  </div>
   <a class="fancy" href="joblist.html">
        <span class="top-key"></span>
        <span class="text">To Description Page</span>
        <span class="bottom-key-1"></span>
        <span class="bottom-key-2"></span>
    </a>
  </div>
    
  <?php
  session_start();
  if (isset($_SESSION['success_message'])) {
    echo "<div class='success-message'>" . $_SESSION['success_message'] . "</div>";
    // Optionally, unset the success message after displaying it to ensure it's not shown again on page refresh
    unset($_SESSION['success_message']);
  }
?>
    <form id="application-form" method="post" action="IT_processEOI.php" novalidate ="novalidate">
        <div class ="form_input">
            <p>
                <label for="jobreferenceNumber"><strong>Job Reference Number</strong></label>
            </p>
            <input class="input" name="jobreferenceNumber" id="jobreferenceNumber" placeholder="Job Reference Number" type="text" pattern="^[a-zA-Z0-9]{5}$" size="20" title = " 5 characters and alphanumeric characters only " required="required">
            <?php
                if (isset($_SESSION['errors']['jobreferenceNumber'])) {
                echo "<span class='error'>" . $_SESSION['errors']['jobreferenceNumber'] . "</span>";
                unset($_SESSION['errors']['jobreferenceNumber']);
                }
            ?>
        </div>
        <br>
        <!-- Personal details -->
        <fieldset>
            <legend><h2>Personal Details</h2></legend>
            <!-- First Name -->
      <div class = "form-container">
          <div class ="form_input">
            <p>
              <label for="firstname"><strong>First Name</strong></label>
            </p>
            <p>
              <input class="input" name="firstname" id="firstname" placeholder="First Name" type="text" pattern="^[A-Za-z\s]{1,20}$" size="40" title = "Only letters, no space" required="required">
            </p>
            <?php
                if (isset($_SESSION['errors']['firstname'])) {
                echo "<span class='error'>" . $_SESSION['errors']['firstname'] . "</span>";
                unset($_SESSION['errors']['firstname']);
                }
            ?>
          </div>
        <!-- Last Name -->
        <div class ="form_input_r">
          <p>
              <label for="lastname"><strong>Last Name</strong></label>
          </p>
          <p>
              <input class="input" name="lastname" id="lastname" placeholder="Last Name" type="text" pattern="^[A-Za-z\s]{1,20}$" size="40" title = "Only letters, no space" required="required">
          </p>
          <!--Error message-->
          <?php
              if (isset($_SESSION['errors']['lastname'])) {
              echo "<span class='error'>" . $_SESSION['errors']['lastname'] . "</span>";
              unset($_SESSION['errors']['lastname']);
              }
          ?>
        </div>
        <div class ="form_input_r">
          <p>
            <label for ="dob"><strong>Date of Birth</strong></label>
          </p>
          <p>
            <input class ="input" name ="dob" id ="dob" type ="text" pattern = "/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19[0-9]{2}|2000)$/" placeholder="dd/mm/yyyy"  size ="40" required="required">
          </p>
          <!--Error message-->
          <?php
              if (isset($_SESSION['errors']['dob'])) {
              echo "<span class='error'>" . $_SESSION['errors']['dob'] . "</span>";
              unset($_SESSION['errors']['dob']);
              }
          ?>
        </div>
      </div>
        <!-- Gender -->
     <div class = "form-container">
          <fieldset class="form_input">
          <legend><strong>Gender</strong></legend>
    <p>
        <input type="radio" name="gender" value="Male" id="male" checked="checked">
        <label for="male">Male</label>
    </p>
    <p>
        <input type="radio" name="gender" value="Female" id="female">
        <label for="female">Female</label>
    </p>
    <p>
        <input type="radio" name="gender" value="Prefer not to say" id="no-say">
        <label for="no-say">Prefer not to say</label>
    </p>
</fieldset>
    </div>
      <div class = "form-container">
        <!-- Street Address -->
          <div class ="form_input">
            <p>
              <label for="streetaddress"><strong>Street Address</strong></label>
            </p>
            <p>
              <input class="input" name="streetaddress" id="streetaddress" placeholder="Street Address" type="text" pattern="^[a-zA-Z0-9\s]{1,40}$" size="40" title = "Alphanumeric characters only " required="required">
            </p>
            <!--Error message--> 
            <?php
                if (isset($_SESSION['errors']['streetaddress'])) {
                  echo "<span class='error'>" . $_SESSION['errors']['streetaddress'] . "</span>";
                  unset($_SESSION['errors']['streetaddress']);
                }
            ?>
          </div>
        <!-- Suburb -->
        <div class ="form_input_r" >
          <p>
            <label for="suburb"><strong>Suburb/Town</strong></label>
          </p>
          <p>
            <input class="input" name="suburb" id="suburb" placeholder="Suburb/Town" type="text" pattern="^[A-Za-z\s]{1,40}$" size="40" title = "Alphanumeric characters only " required="required">
          </p>
          <!--Error message--> 
          <?php
                if (isset($_SESSION['errors']['suburb'])) {
                  echo "<span class='error'>" . $_SESSION['errors']['suburb'] . "</span>";
                  unset($_SESSION['errors']['suburb']);
                }
            ?>
        </div>
        <!-- State -->
        <div class ="form_input_r">
          <p>
            <label for="state"><strong>State</strong></label>
          </p>
          <p>
            <select name="state" id="state" required="required">
                <option value ="">Select state</option>
                <option value="VIC">VIC</option>
                <option value="NSW">NSW</option>
                <option value="QLD">QLD</option>
                <option value="NT">NT</option>
                <option value="WA">WA</option>
                <option value="SA">SA</option>
                <option value="TAS">TAS</option>
                <option value="ACT">ACT</option>
            </select>
          </p>
        </div>
      </div>
      <div class ="form-container">
        <div class ="form_input">
          <p>
            <label for ="postcode"><strong>Postcode</strong></label>
          </p>
          <p>
            <input class="input" name="postcode" id="postcode" placeholder="Postcode" type="text" pattern="^\d{4}$" size="20" title = " 4 numbers only " required="required">
        </p>
        <!--Error message--> 
        <?php
                if (isset($_SESSION['errors']['postcode'])) {
                  echo "<span class='error'>" . $_SESSION['errors']['postcode'] . "</span>";
                  unset($_SESSION['errors']['postcode']);
                }
            ?>
        </div>
        <!-- Email -->
        <div class ="form_input">
           <p>
              <label for="email"><strong>Email</strong></label>
          </p>
        <p>
            <input class="input" name="email" id="email" placeholder="name@domain.com" type="text" pattern ="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" size="20" title = "Match the validate format" required="required">
        </p>
        <!--Error message--> 
        <?php
                if (isset($_SESSION['errors']['email'])) {
                  echo "<span class='error'>" . $_SESSION['errors']['email'] . "</span>";
                  unset($_SESSION['errors']['email']);
                }
            ?>
        </div>
        <!-- Phone Number -->
        <div class ="form_input">
        <p>
            <label for="phoneNumber"><strong>Phone Number</strong></label>
        </p>
        <p>
            <input class="input" name="phoneNumber" id="phoneNumber" placeholder="Phone Number" type="text" pattern="^\d{8,12}$" size="20" title = " Numbers and from 8 to 12 digits only" required="required">
        </p>
        <!--Error message--> 
        <?php
                if (isset($_SESSION['errors']['phoneNumber'])) {
                  echo "<span class='error'>" . $_SESSION['errors']['phoneNumber'] . "</span>";
                  unset($_SESSION['errors']['phoneNumber']);
                }
            ?>
      </div>
      </div>
          <div class ="form_input">
        <p>
          <label for ="workingrights"><strong>What are your working rights in Australia? If on a visa please specify visa subclass and expiry date.</strong></label>
        </p>
        <p>
          <input class="input" name="workingrights" id ="workingrights" type = "text" size ="20" required ="required">
        </p>
        
        </div>
        <div class ="form_input">
          <p>
            <label for ="holiday"><strong>Do you have any holidays booked in the next 12 months?</strong></label>
          </p>
          <p>
            <input class ="input" name="holiday" id ="holiday" type ="text" size ="20" required ="required">
          </p>
          </div>
          <div class ="form_input">
            <p>
              <label for ="weekendwork"><strong>Are you able to work a rotating roster, including weekends and public holidays?</strong></label>
            </p>
            <p>
              <input class ="input" name ="weekendwork" id="weekendwork" type ="text" size = "20" required ="required">
            </p>
          </div>
        </fieldset>
        <!-- Skill list -->
        <fieldset>
            <legend><h2>Skills</h2></legend>
          <div class = "form_input">
            <p><strong>Essential Skills</strong></p>
            <p>
                <label class="checkbox-btn">
                  <label for="experience">Having at least 2 years of experience in Sales IT. </label>
                  <input id="experience" type="checkbox" name = "EssentialSkill[]" value = "Having at least 2 years of experience in Sales IT.">
                  <span class="checkmark"></span>
                </label>
            </p>
            <p>
                <label class="checkbox-btn">
                  <label for="creative">Creative thinking and a high sense of ownership. </label>
                  <input id="creative" type="checkbox" name = "EssentialSkill[]" value = "Creative thinking and a high sense of ownership.">
                  <span class="checkmark"></span>
                </label>
            </p>
            <p>
                <label class="checkbox-btn">
                  <label for="english">Good communication skill in English. </label>
                  <input id="english" type="checkbox" name = "EssentialSkill[]" value = "Good communication skill in English.">
                  <span class="checkmark"></span>
                </label> 
            </p>
          </div>
          <div class = "form_input">
            <p><strong>Preferred Skills</strong></p>
            <p>
                <label class="checkbox-btn">
                  <label for="projects">Having participated in previous projects.</label>
                  <input id="projects" type="checkbox" name = "PreferredSkill[]" value = "Having participated in previous projects.">
                  <span class="checkmark"></span>
                </label> 
            </p>
            <p>
                <label class="checkbox-btn">
                  <label for="enthusiastic">Be enthusiastic, hardworking, responsible for work and can deal with pressure.</label>
                  <input id="enthusiastic" type="checkbox" name = "PreferredSkill[]" value = "Be enthusiastic, hardworking, responsible for work and can deal with pressure.">
                  <span class="checkmark"></span>
                </label> 
            </p>
            <p>
                <label class="checkbox-btn">
                  <label for="spirit"> High learning spirit.</label>
                  <input id="spirit" type="checkbox" name = "PreferredSkill[]" value = "High learning spirit.">
                  <span class="checkmark"></span>
                </label>
            </p>
            <p>
              <label class="checkbox-btn">
                <label for="otherskills_checkbox">Other skills</label>
                <input id="otherskills_checkbox" type="checkbox" name = "otherskills_checkbox">
                <span class="checkmark"></span>
              </label>
            </p>
            <div class ="textbox">
              <p>
                <label for="otherskills"><strong>Other Skills</strong><br>
                  <textarea class ="input" id ="otherskills" name = "otherskills" rows = "8" cols="500" >
                  </textarea>
                </label>
              </p>
              <?php 
              if (isset($_SESSION['errors']['otherskills'])) {
                echo '<p class="error">' . $_SESSION['errors']['otherskills'] . '</p>';
            }
              ?>
            </div>
          </div>
      </fieldset>
        <br>
      <div class ="button-container">
        <button class ="apply-button" type="submit">Submit</button>
        <button class ="apply-button" type="reset">Reset application form</button>
      </div>
    </form>
    <br>
    <!-- Footer -->
    <?php
     include 'footer.inc';
  ?>
    



  <a id="btt-back-to-top" href="#">👆🏼</a>
</body>
</html>
