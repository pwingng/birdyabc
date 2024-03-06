<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="https://cdn.glitch.global/e3f92662-ec3a-49c7-a11f-46d27e5185a1/favicon.ico?v=1693653269634">
    <link href="/cos10026/s103606281/assign2/styles/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <title> $108000 AUD - Software Engineer Job Application Page</title>
</head>
  
<body class="btt-body">
<?php
     include 'header.inc';
     session_start();
  ?>
     <h1 class = "IT_apply_header">Software Engineer Job Application Page</h1>
  <div class ="content-container">
    <div class = "form_input">
    <p>
      <strong>Job Description</strong>
    </p>
    <p>
      <img src ="https://cdn.glitch.global/e3f92662-ec3a-49c7-a11f-46d27e5185a1/14432100661535698998-16.png?v=1696483408707" alt ="location">    Melbourne VIC
    </p>
     <p>
       <img src ="https://cdn.glitch.global/e3f92662-ec3a-49c7-a11f-46d27e5185a1/5340407521530272909-16.png?v=1696483103131" alt="building">    Developer/Programmer
    </p>
      <p>
        <img src ="https://cdn.glitch.global/e3f92662-ec3a-49c7-a11f-46d27e5185a1/15192388931558965371-16.png?v=1696483486224" alt ="workingtime">    Full time
      </p>
    <p>
      <img src ="https://cdn.glitch.global/e3f92662-ec3a-49c7-a11f-46d27e5185a1/5340407521530272909-16.png?v=1696483103131" alt ="salary">     $108000 a year
    </p>
  </div>
  <a class="fancy" href="jobs.php">
  <span class="top-key"></span>
  <span class="text">To Description page</span>
  <span class="bottom-key-1"></span>
  <span class="bottom-key-2"></span>
  </a>
  </div>
  <?php
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
              <input class="input" name="streetaddress" id="streetaddress" placeholder="Street Address" type="text" pattern="^[a-zA-Z0-9\s]{1,40}$" size="40" title = "Alphanumeric characters only " required>
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
            <input class="input" name="suburb" id="suburb" placeholder="Suburb/Town" type="text" pattern="^[A-Za-z\s]{1,40}$" size="40" title = "Alphanumeric characters only " required>
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
                <option value ="" disabled selected>Select state</option>
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
          <div class ="form_input">
            <p><strong>Essential Skills</strong></p>
            <p>
                <label class="checkbox-btn">
                  <label for="front-end">Knowledge of multiple front-end languages and libraries (e.g. HTML/ CSS, JavaScript, XML, jQuery)</label>
                  <input id="front-end" type="checkbox" name = "EssentialSkill[]" value = "Knowledge of multiple front-end languages and libraries (e.g. HTML/ CSS, JavaScript, XML, jQuery)" >
                  <span class="checkmark"></span>
                </label>       
            </p>
            <p>
               <label class="checkbox-btn">
                  <label for="back-end">Knowledge of multiple back-end languages (e.g. C#, Java, Python) and JavaScript frameworks (e.g. Angular, React, Node.js)</label>
                  <input id="back-end" type="checkbox" name = "EssentialSkill[]" value = "Knowledge of multiple back-end languages (e.g. C#, Java, Python) and JavaScript frameworks (e.g. Angular, React, Node.js)">
                  <span class="checkmark"></span>
              </label>                    
            </p>
            <p>
                <label class="checkbox-btn">
                  <label for="msoffice">Professional in using MS OFFICE tools (excel, word, powerpoint)</label>
                  <input id="msoffice" type="checkbox" name = "EssentialSkill[]" value = "Professional in using MS OFFICE tools (excel, word, powerpoint)">
                  <span class="checkmark"></span>
                </label>
            </p>
            <p>
                <label class="checkbox-btn">
                  <label for="bachelor">Bachelor degree on computer science, Engineering, or relevant field</label>
                  <input id="bachelor" type="checkbox" name = "EssentialSkill[]" value = "Bachelor degree on computer science, Engineering, or relevant field">
                  <span class="checkmark"></span>
                </label>
            </p>
          </div>
          <div class ="form_input">
            <p><strong>Preferred Skills</strong></p>
            <p>
                <label class="checkbox-btn">
                  <label for="tools">Knowledge of testing methodologies and tools.</label>
                  <input id="tools" type="checkbox" name = "PreferredSkill[]" value = "Knowledge of testing methodologies and tools.">
                  <span class="checkmark"></span>
                </label>
            </p>
            <p>
                <label class="checkbox-btn">
                  <label for="technologies">Willingness to learn new technologies and adapt.</label>
                  <input id="technologies" type="checkbox" value = "Willingness to learn new technologies and adapt." name = "PreferredSkill[]">
                  <span class="checkmark"></span>
                </label>
            </p>
            <p>
              <label class="checkbox-btn">
                <label for="apps">Awareness of building desktops or web apps.</label>
                <input id="apps" type="checkbox" name = "PreferredSkill[]" value = "Awareness of building desktops or web apps.">
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
           <div class = "textbox">
              <p>
                <label for="otherskills"><strong></strong><br>
                  <textarea class ="input" id ="otherskills" name = "otherskills" >
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
