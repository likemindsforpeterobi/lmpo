<?php 
require('inc/config.php'); 
$page_title = APP_NAME;
include('header.php');
 // Need the database connection:
    require(MYSQL);
  
if($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.

 

    
    // Trim all the incoming data:
    $trimmed = array_map('trim', $_POST);
   
    
    // Check for a first name:
    if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
        $fn = mysqli_real_escape_string ($dbc, $trimmed['first_name']);
    } else {
        echo '<h4>Please enter your first name!</h4>';
    }

    // Check for a last name:
    if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
        $ln = mysqli_real_escape_string ($dbc, $trimmed['last_name']);
    } else {
        echo '<h4>Please enter your last name!</h4>';
    }
    
    // Check for an email address:
    if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
        $e = mysqli_real_escape_string ($dbc, $trimmed['email']);
    } else {
        echo '<h4>Please enter a valid email address!';
    }

    // Check for a password and match against the confirmed password:
    if ($trimmed['password1']) {
        if ($trimmed['password1'] == $trimmed['password2']) {
            $p = mysqli_real_escape_string ($dbc, $trimmed['password1']);
        } else {
            echo '<h4>Your password did not match the confirmed password!</h4>';
        }
    } else {
        echo '<h4>Please enter a valid password! <br/>Minimum of six characters is required</h4>';
    }


     // Check for a Phone Number:
    if ($trimmed['phone']){
        $tel = mysqli_real_escape_string ($dbc, $trimmed['phone']);
    }  else {
        echo '<h4>Please enter a valid phone!</h4>';
    }

    // Check for a Phone Number:
    if ($trimmed['pu_id']){
        $pu_id = mysqli_real_escape_string ($dbc, $trimmed['pu_id']);
    } else {
        $pu_id = "NULL";
    }
    
    // Check for a Phone Number:
    if ($trimmed['ward_id']){
        $ward_id = mysqli_real_escape_string ($dbc, $trimmed['ward_id']);
    }else {
        $ward_id = "NULL";
    }

     // Check for a Phone Number:
    if ($trimmed['gender']){
        $gender = mysqli_real_escape_string ($dbc, $trimmed['gender']);
    } else {
        echo '<h4>Please Choose your gender!</h4>';
    } 

    
       // Check for a Phone Number:
        if ($trimmed['support_group']){
            $support_group = mysqli_real_escape_string ($dbc, $trimmed['support_group']);
        } else {
            echo '<h4>Please Choose your support_group!</h4>';
        } 


         // Check for a Phone Number:
           if ($trimmed['state_id']){
                $state_id = mysqli_real_escape_string ($dbc, $trimmed['state_id']);
            } else {
                echo '<h4>Please Choose your state!</h4>';
            }  


         // Check for state of Origin:
           if ($trimmed['state_origin']){
                $state_origin = mysqli_real_escape_string ($dbc, $trimmed['state_origin']);
            } else {
                echo '<h4>Please Choose your state of Origin!</h4>';
            }  


         // Check for a Phone Number:
           if ($trimmed['religion']){
                $religion = mysqli_real_escape_string ($dbc, $trimmed['religion']);
            } else {
                echo '<h4>Please Select your Religion!</h4>';
            }  


     // Check for a Phone Number:
    if ($trimmed['pvc_status']){
        $pvc = mysqli_real_escape_string ($dbc, $trimmed['pvc_status']);
    } else {
        echo '<h4>Please let us know if you have PVC of not!</h4>';
    }


     // Check for a Phone Number:
    if ($trimmed['age_group']){
        $age_group = mysqli_real_escape_string ($dbc, $trimmed['age_group']);
    }  else {
        echo '<h4>Please select Age Grade!</h4>';
    }

     // Check for a Phone Number:
    if ($trimmed['lga_id']){
        $lga_id = mysqli_real_escape_string ($dbc, $trimmed['lga_id']);
    } 
      //if everything is ok register the user
    if ($fn && $ln && $e && $p && $tel && $state_id && $religion && $state_origin && $support_group && $pu_id && $ward_id && $gender && $pvc && $lga_id && $age_group ) { // If everything's OK...

        // Make sure the email address has not been used by another user:
        $q = "SELECT user_id FROM users WHERE phone='$tel'";
        $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
        
        if (mysqli_num_rows($r) == 0) { // Available.        
                    // Add the user to the database:
             $q = "INSERT INTO users (email, pass, first_name, last_name, phone, support_group, state_id, state_origin, religion_id,  pu_id, ward_id, gender, pvc_status, age_group, lga_id, created_at, updated_at) VALUES ('$e', SHA1('$p'), '$fn', '$ln', '$tel', '$support_group', '$state_id', '$state_origin', '$religion', '$pu_id', '$ward_id', '$gender', '$pvc',  '$age_group', '$lga_id', NOW(), NOW() )";
             
             $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

            if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.ss
            
                
        // Finish the page:
         echo'<section class="about-faq sec-padd">'; 
          echo '<div class="container">';
          echo '<div class="row clearfix">';
          echo '<div align ="center">';
          echo '<h3>Thank You, Registration Successful!</h3><br/><br/>';
          echo '<a align ="center" class="thm-btn yellow-bg" href="index.php"> Return Home</a>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</section>';
          include ('footer.php'); // Include the HTML footer.
           exit(); // Stop the page.

                
            } else { // If it did not run OK.
                echo '<h4 align ="center"> You could not be registered due to a system error. We apologize for any inconvenience</h4>';
         echo'<div align ="center">';
          echo '<a class="thm-btn yellow-bg" href="index.php"><br> <br>Return</a>';
          echo'</div>';
                 include ('footer.php'); // Include the HTML footer.
                exit(); // Stop the page.
            }
            
        
        } else { // The email address is not available.
            echo '<h4 align ="center">That phone number has already been registered!</h4>';
            echo'<div align ="center">';
            echo '<a class="thm-btn yellow-bg" href="index.php"><br> <br>Return</a>';
            echo'</div>';
                include ('footer.php'); // Include the HTML footer.
                exit(); // Stop the page.
                
        }
        
    } else { // If one of the data tests failed.
          echo '<h4 align="center"> ("Something went wrong, please try again");</h4>';
          echo'<div align ="center">';
          echo '<a class="thm-btn yellow-bg" href="index.php"><br> <br>Return</a>';
          echo'</div>';
         include ('footer.php'); // Include the HTML footer.
         exit(); // Stop the page.
    }

    mysqli_close($dbc);

    } //

?>


<!--End rev slider wrapper--> 
<section class="testimonials-section sec-padd" id="survey">
    <div class="container">
        <div class=" center">
            <h2 style="Color:#008753;">Voters Mobilization Form</h2>
            <h2 style="Color:white;" ></h2>
        </div> 

           <!--Login Form-->
                <div class="styled-form register-form" style= "margin-top: 20px;">
                    <form method="post" action="">

                <div class="col-lg-6 col-md-6 ">
                        <div class="form-group">
                        <label for="fname">First Name</label>
                            <span class="adon-icon"><span class="fa fa-user"></span></span>
                        <input id="fname" placeholder="First Name" type="text" class="form-control" name="first_name"  required >
                               
                        </div>

                        <div class="form-group">
                        <label for="lname">Last Name</label>
                            <span class="adon-icon"><span class="fa fa-user"></span></span>
                        <input id="lname" placeholder="Last Name" type="text" class="form-control" name="last_name"  required >     
                        </div>
                        

                        <div class="form-group">
                        <label for="email">Email Address</label>
                            <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                            <input id="email" type="email" placeholder="Email Address" class="form-control" name="email"   required>
                        </div>

                        <div class="form-group">
                        <label for="phone">Phone Number</label>
                            <span class="adon-icon"><span class="fa fa-phone"></span></span>
                            <input id="phone" placeholder="Phone" type="text" class="form-control" name="phone" required>
                        </div>



                         <div class="form-group">
                <label for="age">Age</label>
                            <span class="adon-icon"><span class="fa fa-flag-alt"></span></span>
                            <select id="age" name="age_group" class="form-control">
                                <option value="0">Choose Your Age Grade</option> 
                                <option value="1">18-24</option>                            
                                <option value="2">25-30</option>
                                <option value="3">31-35</option>
                                <option value="4">36-40</option>
                                <option value="5">41-45</option>
                                <option value="6">46-50</option>
                                <option value="7">51-55</option>
                                <option value="8">56-60</option>
                                <option value="9">61-65</option>
                                <option value="10">66-70</option>
                                <option value="11">70+</option>
                            </select>
                        </div>


                        <div class="form-group">
                <label for="state"> State Of Origin</label>
                            <span class="adon-icon"><span class="fa fa-flag-alt"></span></span>
                    <select name="state_origin" class="form-control" id="state_origin">
                    <option value="">Select State</option>
                    <?php
                    $q = "SELECT state_id, state_name FROM states ORDER BY state_id ASC";
                    $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
                    while($row = mysqli_fetch_array($r)) {
                    ?>
                    <option value="<?php echo $row['state_id'];?>"><?php echo $row["state_name"];?></option>
                    <?php
                    }
                    ?>                           
                    </select>
               </div>  


                       
                         <div class="form-group">
                <label for="religion"> Religion</label>
                            <span class="adon-icon"><span class="fa fa-flag-alt"></span></span>
                            <select id="religion" name="religion" class="form-control">
                                <option value="">Select Religion</option> 
                                 <?php
                    $q = "SELECT religion_id, religion_name FROM religion ORDER BY religion_id ASC";
                    $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
                    while($row = mysqli_fetch_array($r)) {
                    ?>
                    <option value="<?php echo $row['religion_id'];?>"><?php echo $row["religion_name"];?></option>
                    <?php
                    }
                    ?>   
                                
                            </select>
                </div>
                        
                                

                        
    </div><!-- End first column -->

    <div class="col-lg-6  col-md-6 ">               

         <div class="form-group">
                <label for="state">Voting State</label>
                            <span class="adon-icon"><span class="fa fa-flag-alt"></span></span>
                    <select name="state_id" class="form-control" id="state-dropdown">
                    <option value="">Select State</option>
                    <?php
                    $q = "SELECT state_id, state_name FROM states ORDER BY state_id ASC";
                    $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
                    while($row = mysqli_fetch_array($r)) {
                    ?>
                    <option value="<?php echo $row['state_id'];?>"><?php echo $row["state_name"];?></option>
                    <?php
                    }
                    ?>                           
                    </select>
               </div>  


               <div class="form-group">
                <label for="lga">Voting LGA</label>
                    <select name="lga_id" class="form-control" id="lga-dropdown">                                              
                    </select>
               </div>
                             
                <div class="form-group">
                    <label for="ward">Voting Ward</label>
                    <select class="form-control" id="ward-dropdown" name = "ward_id">
                    </select>                     
               </div>

               <div class="form-group">
                    <label for="pu">Voting Polling Unit</label>
                    <select class="form-control" id="pu-dropdown" name ="pu_id">
                    </select>                     
               </div>            


               
                
                <div class="form-group">
                <label for="support_group">Select Sub-group To Serve In</label>
                            <span class="adon-icon"><span class="fa fa-flag-alt"></span></span>
                            <select id="support_group" name="support_group" class="form-control">
                                <option value="0">Select Sub-group</option> 
                                <?php
                    $q = "SELECT support_group_id, support_group_name FROM support_group  ORDER BY support_group_id ASC";
                    $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
                    while($row = mysqli_fetch_array($r)) {
                    ?>
                    <option value="<?php echo $row['support_group_id'];?>"><?php echo $row["support_group_name"];?></option>
                    <?php
                    }
                    ?>  
                            </select>
                        </div>

                        <div class="form-group">
                            <label for ="gender">Gender</label>
                            
                            <div class="radio">
                            <label for="male"><input type="radio" id="male" name="gender" value="1">Male</label>
                             </div>

                             <div class="radio">
                             <label for="female"><input type="radio" id="female" name="gender" value="2">  Female</label>                           
                            </div>
                      
                        </div>

                        <div class="form-group">
                            <label for ="pvc">Do You Have PVC?</label>
                            
                            <div class="radio">
                            <label for="yes"><input type="radio" id="yes" name="pvc_status" value="1">Yes</label>
                            </div>

                           <div class="radio"> 
                           <label for="no"><input type="radio" id="no" name="pvc_status" value="2">No</label>
                           </div>

                     </div>


        </div> <!-- End second form column --><br><br>

        

            <div class="col-lg-10 col-md-10">
                    <div class="col-lg-8 col-md-8">
                        <div class="form-group">
                             <!--<span class="adon-icon"><span class="fa fa-unlock-alt"></span></span>-->
                            <input id="password"  value="Obi4BetterNigeria" type="hidden" class="form-control" name="password1" required>
                        </div>


                        
                            <div class="form-group">
                            <!--<span class="adon-icon"><span class="fa fa-unlock-alt"></span></span>-->
                            <input id="password_confirm" value="Obi4BetterNigeria" type="hidden" class="form-control" name="password2" required>
                        </div>
                    </div>

                        
                    <div class="col-lg-12 col-md-12">
                              <div class="form-group pull-left">
                                <button type="submit" class="thm-btn thm-tran-bg btn-block">Submit</button>
                           </div>
                    </div>
                           
        </div>
                        
                    </form> </div>
             
        
    </div>   
</section>





<?php
 mysqli_close($dbc);

require('footer.php'); 
?>