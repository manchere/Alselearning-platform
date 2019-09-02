<?php 
require_once('config.php');
session_start();

$failure = $fname = $lname = $email = $pass = $cpass = "";
$fnameErr = $lnameErr = $emailErr = $passErr = $cpassErr = "";


if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(empty(trim($_POST["firstname"])))
    {
        $fnameErr = "Please enter a firstname";
    }
    else
    {
        $fname = trim($_POST["firstname"]);
    }

    if(empty(trim($_POST["lastname"])))
    {
        $lnameErr = "Please enter a lastname";
    }
    else
    {
        $lname = trim($_POST["lastname"]);
    }

    if(empty(trim($_POST["email"])))
    {
        $emailErr = "Please enter an email address";
    }
    else
    {
        $sql = "SELECT EMAIL FROM STUDENT_DETAILS WHERE EMAIL= ?";

        if($stmt = $con->prepare($sql))
        {
            $stmt->bind_param("s",$param_email);
            $param_email = trim($_POST["email"]);

            if($stmt->execute())
            {
                $stmt->store_result();

                if($stmt->num_rows == 1)
                {
                    $emailErr = "This email address has already been used to register.";
                }
                else
                {
                    $email = trim($_POST["email"]);
                }
            }
            else
            {
                echo 'Sorry went wrong,please try again later';
            }
        }
        
        $stmt->close();
    }

    if(empty(trim($_POST["password"])))
    {
        $passErr = "Please enter a password";
    }
    elseif(strlen(trim($_POST["password"]))<6)
    {
        $passErr = "Password must have at least 6 characters";
    }
    else
    {
        $pass = trim($_POST["password"]);
    }

if(empty(trim($_POST["cpassword"])))
{
    $cpassErr = "Please enter confirm password";
}
else
{
    $cpass = trim($_POST["cpassword"]);

    if(empty($passErr) && ($pass != $cpass))
    {
        $cpassErr = "Passwords do not match";
    }
}

if(empty($fnameErr) && empty($lnameErr) && empty($emailErr) && empty($passErr) && empty($cpassErr))
{
    
    // Escape user inputs for security
$first_name = $con->real_escape_string($fname);
$last_name = $con->real_escape_string($lname);
$emailA = $con->real_escape_string($email);
$passW= $con->real_escape_string($pass);
$passW = password_hash($passW, PASSWORD_DEFAULT);
 
// Attempt insert query execution
$sql = "INSERT INTO STUDENT_DETAILS(Firstname, Lastname, Email,Password) VALUES ('$first_name', '$last_name', '$email','$passW')";

if($con->query($sql) === true)
{
    header("location:successfulRegis.php");
          
} else{
    $failure = "ERROR: Registration failed. " . $con->error;
}
 
// Close conn
        $con->close(); 
}

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
<div class="login-sec">
           <div class="overlay">
 <div class="container set-pad">
      <div class="row text-center">
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                     <h1 data-scroll-reveal="enter from the bottom after 0.1s" class="header-line" data-scroll-reveal-id="20" data-scroll-reveal-initialized="true" data-scroll-reveal-complete="true">REGISTER NOW</h1>
                     <p data-scroll-reveal="enter from the bottom after 0.3s" data-scroll-reveal-id="21" data-scroll-reveal-initialized="true" data-scroll-reveal-complete="true">
                      <?php echo $failure ?>
                    </p>
                 </div>

             </div>
             <!--/.HEADER LINE END-->
           <div class="row set-row-pad" data-scroll-reveal="enter from the bottom after 0.5s" data-scroll-reveal-id="22" data-scroll-reveal-initialized="true" data-scroll-reveal-complete="true">
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                    <form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method= "post">
                        <div class="form-group">
                            <input type="text" name = "firstname" class="form-control " value="<?php echo $fname; ?>" placeholder="Firstname">
                            <span class="help-block"><?php echo $fnameErr; ?></p></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="lastname" class="form-control " value="<?php echo $lname; ?>" placeholder="Lastname">
                            <span class="help-block"><?php echo $lnameErr; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" class="form-control " value="<?php echo $email; ?>" placeholder="Email">
                            <span class="help-block"><?php echo $emailErr; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control " value="<?php echo $pass; ?>" placeholder="Password">
                            <span class="help-block"><?php echo $passErr; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="password" name="cpassword" class="form-control <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>"
                             value="<?php echo $cpass; ?>" placeholder="Confirm Password">
                             <span class="help-block"><?php echo $cpassErr; ?></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" name ="register" class="btn btn-info btn-block btn-lg">REGISTER</button>
                        </div>
                        <div class="form-group">
                            <a href="index.php" name ="return" class="btn btn-info btn-block btn-lg">RETURN TO HOMEPAGE</a>
                        </div>

                    </form>
                </div>
               </div>
                </div>
          </div> 
       </div>
</html>