<!DOCTYPE html>
<html lang="en">
    <?php
   require('db_connect.php');
    session_start();
    $message='';
    $message1='';
    
if(isset($_POST['sub'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['em']);
    $pass = mysqli_real_escape_string($conn, ($_POST['pass']));
    $repass = mysqli_real_escape_string($conn, ($_POST['repass']));

    $user_type = 0;
    $select_users = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die('failed to check for existing user');

    if(mysqli_num_rows($select_users) > 0)
    $message = "<div class=' mb-0 alert alert-danger alert-dismissible fade show' role='alert'>
	
    <div class='box' style='color:red; background:inherit;'>
            <strong style='color:red; background:inherit;'>User</strong> already exist.</div>
      <button type='button'  style='outline:none;color:red; background:inherit;' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true' style='color:red; background:inherit;'>&times;</span>
      </button>
    </div>";
    else
    {
        if($pass != $repass){
            $message = "<div class=' mb-0 alert alert-danger alert-dismissible fade show' role='alert'>
	
            <div class='box' style='color:red; background:inherit;'>
                    <strong style='color:red; background:inherit;'>Password</strong> are not  same.</div>
              <button type='button'  style='outline:none;color:red; background:inherit;' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true' style='color:red; background:inherit;'>&times;</span>
              </button>
            </div>";
        }
        else{
            mysqli_query($conn, "INSERT INTO users (username, email, pass) VALUES ('$username', '$email','$repass')") 
            or die('failed to add user');

            $message1 = "<div class=' mb-0 alert alert-success alert-dismissible fade show' role='alert'>
	
            <div class='box' style='color:green; background:inherit;'>
                    <strong style='color:green; background:inherit;'>Successfully</strong> registered.</div>
              <button type='button'  style='outline:none;color:green; background:inherit;' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true' style='color:green; background:inherit;'>&times;</span>
              </button>
            </div>";
        }
    }

}
if(isset($_POST['sublogin'])){

   
    $email = mysqli_real_escape_string($conn, $_POST['loginem']);
    $pass = mysqli_real_escape_string($conn, ($_POST['loginpass']));

    $user_type = 0;
    $select_users = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND pass = '$pass'") or die('failed to check for existing user');

    if(mysqli_num_rows($select_users) > 0)
    {
        $row = mysqli_fetch_assoc($select_users);
        
            $_SESSION['user_name'] = $row['username'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:index.php');

        
    }
    else
    {
        $message1 = "<div class=' mb-0 alert alert-danger alert-dismissible fade show' role='alert'>
	
        <div class='box' style='color:red; background:inherit;'>
                <strong style='color:red; background:inherit;'>USERNAME or EMAIl</strong> is  wrong.</div>
          <button type='button'  style='outline:none;color:red; background:inherit;' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true' style='color:red; background:inherit;'>&times;</span>
          </button>
        </div>";
    }

}

    ?>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">

<body>
    <?php
    echo $message1;
    ?>
    <div id="cookieNotice" class="light display-right" style="display: none;">
    <div id="closeIcon" style="display: none;">
    </div>
    <div class="title-wrap">
        <h4>Cookie Consent</h4>
    </div>
    <div class="content-wrap">
        <div class="msg-wrap">
            <p>This website uses cookies or similar technologies, to enhance your browsing experience and provide personalized recommendations. By continuing to use our website, you agree to our  <a style="color:#115cfa;" href="/privacy-policy">Privacy Policy</a></p>
            <div class="btn-wrap">
                <button class="btn-primary" onclick="acceptCookieConsent();">Accept</button>
            </div>
        </div>
    </div>
</div>
<div class="login-form-main">
        <div class="container lgm">
            <div class="login-form">

                <h1> Log in</h1>
                <form method="post" action="">
    
                    <div class="login-details">
                        <label for=""> Email </label>
                        <input type="email" name="loginem" class="inputbox" placeholder="Email" required>
    
                        <label for=""> Password</label>
                        <input type="password" name="loginpass" class="inputbox" placeholder="Password" required>
                   
    
                    <button type="submitlogin" name="sublogin">SUBMIT</button>
    
                </div>
                </form>
    
            </div>
            <h1 class="circle ">OR</h1>
            <div class="signup-1">
                <h1> SIGN UP</h1>
            <form action="" method="post" >

                <div class="signup-details">
                    <label for="first name"> Username</label><br>
                    <input type="text" name="username" class="inputbox" placeholder="Usernname" required = 
                    "required"><br>

                    <label for="email"> Email </label><br>
                    <input type="email" name="em" class="inputbox" placeholder="Email" required = 
                    "required"><br>


                    <label for="password"> Password</label><br>
                    <input type="password" name="pass" class="inputbox" placeholder="password" required = 
                    "required"><br>

                    <label for="retypepassword"> Retype Password</label><br>
                    <input type="password" name="repass" class="inputbox" placeholder="password" required = 
                    "required"><br>
                <label class="termsandcond"> <input type="checkbox" class="check" name="check_box" required = 
                    "required">I agree to the Terms and
                    Conditions</label>
                <button type="submit" name="sub">SUBMIT</button>
            </div>

            </form>
            </div>
        </div>
    </div>    
    <script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="js/popper.min.js" type="text/javascript"></script>
      <script src="js/plugins.js" type="text/javascript"></script>
      <script src="js/main.js" type="text/javascript"></script>
</body>
</html>