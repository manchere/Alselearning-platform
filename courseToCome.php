<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location:index.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT FIRSTNAME, LASTNAME, EMAIL, PASSWORD FROM STUDENT_DETAILS WHERE EMAIL = ?";
        
        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if email exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($fname, $lname, $email, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){

                            // Password is correct, so start a new session
                           // session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["email"] = $email; 
                            $_SESSION["firstname"] = $fname;                           
                           
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else{
                $email_err =  "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $con->close();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>AL'S LEARNING CENTRE</title>
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME CSS -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet" />
     <!-- FLEXSLIDER CSS -->
<link href="assets/css/flexslider.css" rel="stylesheet" />
    <!-- CUSTOM STYLE CSS -->
    <link href="assets/css/style.css" rel="stylesheet" />    
  <!-- Google	Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css' />
</head>
<body >
   
 <div class="navbar navbar-inverse navbar-fixed-top " id="menu">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img class="logo-custom" src="assets/img/al_logo.png" alt=""  /></a>
            </div>
            <div class="navbar-collapse collapse move-me">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#home">HOME</a></li>
                    <li><a href="#features-sec">ABOUT</a></li>
                    <li><a href="#faculty-sec">GALLERY</a></li>
                    <li><a href="#course-sec">COURSES</a></li>
                    <li><a href="registration.php">REGISTER</a></li>
                    <li><a href="#login-sec"><?php if(isset($_SESSION["firstname"])){echo 'LOGOUT';}else{echo 'LOGIN'; } ?></a></li>
                    <li><a href="#" color="green"><?php if(isset($_SESSION["firstname"])){echo $_SESSION["firstname"];} ?></a></li>
                </ul>
            </div>
           <i class="fas fa-person"></i>
        </div>
    </div>
      <!--NAVBAR SECTION END-->
       <div class="home-sec" id="home" >
           <div class="overlay">
 <div class="container">
           <div class="row text-center " >
           
               <div class="col-lg-12  col-md-12 col-sm-12">
               
                <div class="flexslider set-flexi" id="main-section" >
                    <ul class="slides move-me">
                        <!-- Slider 01 -->
                        <li>
                              <h3>Delivering Quality Education</h3>
                           <h1>THE UNIQUE METHOD</h1>
                            <a  href="#features-sec" class="btn btn-info btn-lg" >
                                GET AWESOME 
                            </a>
                             <a  href="#features-sec" class="btn btn-success btn-lg" >
                                FEATURE LIST
                            </a>
                        </li>
                        <!-- End Slider 01 -->
                        
                        <!-- Slider 02 -->
                        <li>
                            <h3>Delivering Quality Education</h3>
                           <h1>UNMATCHED APPROACH</h1>
                             <a  href="#features-sec" class="btn btn-primary btn-lg" >
                               GET AWESOME 
                            </a>
                             <a  href="#features-sec" class="btn btn-danger btn-lg" >
                                FEATURE LIST
                            </a>
                        </li>
                        <!-- End Slider 02 -->
                        
                        <!-- Slider 03 -->
                        <li>
                            <h3>Delivering Quality Education</h3>
                           <h1>QUALIFIED TRAINERS</h1>
                             <a  href="#features-sec" class="btn btn-default btn-lg" >
                                GET AWESOME 
                            </a>
                             <a  href="#features-sec" class="btn btn-info btn-lg" >
                                FEATURE LIST
                            </a>
                        </li>
                        <!-- End Slider 03 -->
                    </ul>
                </div>
                   
            </div>
                
               </div>
                </div>
           </div>
           
       </div>
       <!--HOME SECTION END-->   
    <div  class="tag-line" >
         <div class="container">
           <div class="row  text-center" >
           
               <div class="col-lg-12  col-md-12 col-sm-12">
               
        <h2 data-scroll-reveal="enter from the bottom after 0.1s" ><i class="fa fa-circle-o-notch"></i> WELCOME TO THE AL'S LEARNING MEDIA <i class="fa fa-circle-o-notch"></i> </h2>
                   </div>
               </div>
             </div>
        
    </div>
    <!--HOME SECTION TAG LINE END-->   
         <div id="features-sec" class="container set-pad" >
             <div class="row text-center">
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                     <h1 data-scroll-reveal="enter from the bottom after 0.2s"  class="header-line">BACKGROUND INFO </h1>
                     <p data-scroll-reveal="enter from the bottom after 0.3s" >
                      The motivation for setting up an e-learning centre is to provide an avenue for learning to be an interactive process where tutors deliver education using smart digital technology deployed via the internet and for Ghanaian students to be active participants in the classroom and receiving the kind of education comparable to their peers worldwide.
					  
					    </div>

             </div>
		<div id="features-sec" class="container set-pad" >
             <div class="row text-center">
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                     <h1 data-scroll-reveal="enter from the bottom after 0.2s"  class="header-line"> WHAT DO WE DO </h1>
                     <p data-scroll-reveal="enter from the bottom after 0.3s" >			  
					 
Al’s E-learning Centre (AEC) is a knowledge acquisition environment where training is provided the individual using cutting edge technologies. The Centre comprises “The Knowledge Hub,” and “The Testing Hub.”

                         
                 </div>

             </div>
             <!--/.HEADER LINE END-->


           <div class="row" >
           
               
                 <div class="col-lg-4  col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.4s">
                     <div class="about-div">
                     <i class="fa fa-paper-plane-o fa-4x icon-round-border" ></i>
                   <h3 >TESTING HUB</h3>
                 <hr />
                       <hr />
                   <p >
                      


Clients should have the ability to test the knowledge gained and acquire the requisite certificate from reputable examining bodies the world over. The AEC set up includes an international exam centre, we are certified by international online exam bodies like Pearson VUE etc. We believe in providing the best and most comfortable sound proof environment to undertake any exam.

                       
                   </p>
               <a href="#" class="btn btn-info btn-set"  >ASK THE EXPERT</a>
                </div>
                   </div>
                   <div class="col-lg-4  col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.5s">
                     <div class="about-div">
                     <i class="fa fa-bolt fa-4x icon-round-border" ></i>
                   <h3 >ONLINE LEARNING </h3>
                 <hr />
                       <hr />
                   <p >
                       AEC seeks to provide adequate training to our clients in the most convenient way. Clients will have access to both live and recorded tuition 24 hours a day 7 days a week thus learning at their own pace and leisure. This is designed taking into consideration the concerns of stay at home mothers, workers who find it nearly impossible to secure periods of leave to study etc
                   </p>
               <a href="#" class="btn btn-info btn-set"  >ASK THE EXPERT</a>
                </div>
                   </div>
                 <div class="col-lg-4  col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.6s">
                     <div class="about-div">
                     <i class="fa fa-magic fa-4x icon-round-border" ></i>
                   <h3 > KNOWLEDGE HUB</h3>
                 <hr />
                       <hr />
                   <p >
                     
The learning philosophy is threefold Knowledge, Practice, Test. 
The Knowledge Hub is equipped with a state of the art modern digital smart board to aid effective teaching and impartation of knowledge. The reason behind this set up is to make available to users of our hub the best possible technologies to acquire knowledge eliminating the drudgery associated with traditional teaching methods. Instructors and students alike find the learning environment interactive and a fun place. 

                        
                       
                   </p>
               <a href="#" class="btn btn-info btn-set"  >ASK THE EXPERT</a>
                </div>
                   </div>
                 
                 
               </div>
             </div>
   <!-- FEATURES SECTION END-->
    <div id="faculty-sec" >
    <div class="container set-pad">
             <div class="row text-center">
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                     <h1 data-scroll-reveal="enter from the bottom after 0.1s" class="header-line">OUR FACULTY </h1>
                     <p data-scroll-reveal="enter from the bottom after 0.3s">
                      To give prospective students the option of studying online which gives them the convenience and flexibility to learn at their own pace and at a time to suit them, at the same time provide that extra bit of motivation and accountability that one gets from face-to-face tuition as well as all the support and guidance they need to succeed.



                         </p>
                 </div>

             </div>
             <!--/.HEADER LINE END-->

           <div class="row" >
           
               
                 <div class="col-lg-4  col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.4s">
                     <div class="faculty-div">
                     <img src="assets/img/faculty/11.jpg"  class="img-rounded" />
                   <h3 >TRAINER</h3>
                 <hr />
                         <h4>ICAG <br /> Department</h4>
                   <p >
                      Register with now!!!!!!
                       
                   </p>
                </div>
                   </div>
                 <div class="col-lg-4  col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.5s">
                     <div class="faculty-div">
                     <img src="assets/img/faculty/12.jpg"  class="img-rounded" />
                   <h3 >TRAINER</h3>
                 <hr />
                         <h4>CIMA<br /> Department</h4>
                   <p >
                       Register with us now!!!! 
                       
                   </p>
                </div>
                   </div>
               <div class="col-lg-4  col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.6s">
                     <div class="faculty-div">
                     <img src="assets/img/faculty/13.jpg" class="img-rounded" />
                   <h3 >TRAINER</h3>
                 <hr />
                         <h4>ACCA<br /> Department</h4>
                   <p >
                       Register with us now!!
                       
                   </p>
                </div>
                   </div>
                 
               </div>
             </div>
        </div>
    <!-- FACULTY SECTION END-->
      <div id="course-sec" class="container set-pad">
             <div class="row text-center">
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                     <h1 data-scroll-reveal="enter from the bottom after 0.1s" class="header-line">OUR COURSES </h1>
                     <p data-scroll-reveal="enter from the bottom after 0.3s">
                      register with us now!!
                         </p>
                 </div>

             </div>
             <!--/.HEADER LINE END-->


           <div class="row set-row-pad" >
           <div class="col-lg-6 col-md-6 col-sm-6 " data-scroll-reveal="enter from the bottom after 0.4s" >
                 <img src="assets/img/boss.jpg" class="img-thumbnail" />
           </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                   <div class="panel-group" id="accordion">
                        <div class="panel panel-default" data-scroll-reveal="enter from the bottom after 0.5s">
                            <div class="panel-heading" >
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="collapsed">
                                  ACCA
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse" style="height: 0px;">
                                <div class="panel-body">
                                    <p>Register with Al's E-Learning center now and enjoy countless opportunities</p>
                                </div>
                            </div>
                        </div>
						
                        <div class="panel panel-default" data-scroll-reveal="enter from the bottom after 0.7s">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="collapsed">
                                       CIMA 
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse" style="height: 0px;">
                                <div class="panel-body">
                                    <p>
                                       Register with Al's E-Learning center now and enjoy countless opportunities
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" data-scroll-reveal="enter from the bottom after 0.9s">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" class="collapsed">
                                        ICAG 
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse"  style="height: 0px;">
                                <div class="panel-body">
                                    <p>
                                       Register with Al's E-Learning center now and enjoy countless opportunities
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                   
           </div>
		    
               </div>
             </div>
			 
      <!-- COURSES SECTION END-->
    <div id="login-sec">
           <div class="overlay">
 <div class="container set-pad">
      <div class="row text-center">
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                     <h1 data-scroll-reveal="enter from the bottom after 0.1s" class="header-line" >WELCOME TO AL'S LEARNING CENTRE </h1>
                     <p data-scroll-reveal="enter from the bottom after 0.3s">
                      <?php  ?>
                      
               
                         </p>
                 </div>

             </div>
             <!--/.HEADER LINE END-->
           <div class="row set-row-pad"  data-scroll-reveal="enter from the bottom after 0.5s" >
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                    <form action ="" method="post">
                        <div class="form-group">
                            <input type="text" name="email" class="form-control "  required="required" placeholder="Email" />
                            <span class="help-block"><?php echo $email_err; ?></p></span>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="password" required="required"  placeholder="Password" />
                            <span class="help-block"><?php echo $password_err; ?></p></span>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block btn-lg">LOGIN</button>
                        </div>

                    </form>
                </div>   
               </div>
                </div>
          </div> 
       </div>
     <div class="container">
             <div class="row set-row-pad"  >
    <div class="col-lg-4 col-md-4 col-sm-4   col-lg-offset-1 col-md-offset-1 col-sm-offset-1 " data-scroll-reveal="enter from the bottom after 0.4s">
                    <h2 ><strong>Our Location </strong></h2>
        <hr />
                    <div>
                        <h4>Tema, Ghana</h4>
                        <h4><strong>Call:</strong></h4>0322 002 516
		<hr />
						 <h4><strong>Mobile Money Numbers:</strong></h4>MTN Mobile Money<h4><strong>024 133 3401</h4></strong> VODACash <h4><strong>050 854 1999</strong></h4>
		<hr />
                        <h4><strong>Email:</strong></h4>info@alselearningcentre.com elsie.delanyoh@alselearningcentre.com albert.adubofour@alselearningcentre.com
                    </div>


                </div>
                 <div class="col-lg-4 col-md-4 col-sm-4   col-lg-offset-1 col-md-offset-1 col-sm-offset-1" data-scroll-reveal="enter from the bottom after 0.4s">

                    <h2 ><strong>Social Conectivity </strong></h2>
        <hr />
                    <div >
					<!---AL'S SOCIAL MEDIA HANDLES-->
                        <a href="#">  <img src="assets/img/Social/facebook.png" alt="" /> </a>
                     <a href="#"> <img src="assets/img/Social/google-plus.png" alt="" /></a>
                     <a href="#"> <img src="assets/img/Social/twitter.png" alt="" /></a>
                    </div>
                    </div>


                </div>
                 </div>
     <!-- CONTACT SECTION END-->
    <div id="footer">
          &copy 2019 alselearningcentre.com | All Rights Reserved |  <a href="www.alselearningcentre.com" style="color: #fff" target="_blank">Design by : CreativenergyCrew</a>
    </div>
     <!-- FOOTER SECTION END-->
   
    <!--  Jquery Core Script -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!--  Core Bootstrap Script -->
    <script src="assets/js/bootstrap.js"></script>
    <!--  Flexslider Scripts --> 
         <script src="assets/js/jquery.flexslider.js"></script>
     <!--  Scrolling Reveal Script -->
    <script src="assets/js/scrollReveal.js"></script>
    <!--  Scroll Scripts --> 
    <script src="assets/js/jquery.easing.min.js"></script>
    <!--  Custom Scripts --> 
         <script src="assets/js/custom.js"></script>
</body>
</html>
