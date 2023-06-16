
<?php
require('head.php');
require('db_connect.php');
session_start();
$username='';
$password='';
$email='';

$user_id = $_SESSION['user_id'];
$user_name =$_SESSION['user_name'];
if(!isset($user_id)){
   header('location:login.php');
}

$sql="SELECT * FROM users WHERE id='$user_id'";
$query=mysqli_query($conn,$sql);
$i=0;
while ($row=mysqli_fetch_assoc($query)){$i++;
    if(isset($_POST['submit'])){
        $username=$_POST['username'];
        $password=$_POST['pass'];
        $email=$_POST['em'];
        $update_sql="update users set username='$username',pass='$password',email='$email' where id='$user_id'";
        $result=mysqli_query($conn,$update_sql);
    
    
    if($result==0){
        echo"<div class=' mb-0 alert alert-danger alert-dismissible fade show' role='alert'>
	
        <div class='box' style='color:red; background:inherit;'>
                <strong style='color:red; background:inherit;'>Error</strong> changing details.</div>
          <button type='button'  style='outline:none;color:red; background:inherit;' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true' style='color:red; background:inherit;'>&times;</span>
          </button>
        </div>";
        // header("Location: index.php");
    }else{
         header("Refresh:0");
        echo"<div class=' mb-0 alert alert-success alert-dismissible fade show' role='alert'>
	
        <div class='box' style='color:green; background:inherit;'>
                <strong style='color:green; background:inherit;'>User Details changed successfully</strong> </div>
          <button type='button'  style='outline:none;color:green; background:inherit;' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true' style='color:green; background:inherit;'>&times;</span>
          </button>
        </div>";
        
        // header("Location: index.php");
    }
}


?>
<body>
<div class="header">
  
  <div class="container main-header">
      <a href="index.php" class="logo">
          <img src="images/logo.png" alt="not found">
          <h4>Project</h4>
      </a>
      <nav class="navbar">
          <span class="menu" id="menu"><i class="fas fa-bars"></i></span>
          <ul class="menu-drp" id="menu-drp">
              <a href="index.php" class="inactive active">Home</a>
              <a href="mymemes.php" class="inactive btn-nav">My Memes</a>
              <div class="user-details">
                 <button  class="inactive " id="btn1"><?php echo $user_name  ?></button>
                 <div class="user-detail-drpdwn">
                 <a href="user_details.php" class="inactive bdr">User Details</a>
                 <a href="endsession.php" class="inactive bdr">Logout</a> 
                  </div>
              </div>
          </ul>
      </nav>
  </div>
</div>
<div class="user_details">
<form action="" method="post" >

<div class="signup-details" style="position:relative;">
    <label for="first name"> Username</label><br>
    <input type="text" name="username" class="inputbox" value="<?php echo $row['username'];  ?>"><br>

    <label for="email"> Email </label><br>
    <input type="email" name="em" class="inputbox" value="<?php echo $row['email'];  ?>"><br>


    <label for="password"> Password</label><br>
    <input type="password" name="pass" autocomplete="current-password"  id="id_password" value="<?php echo $row['pass'];  ?>">
  <i class="far fa-eye" id="togglePassword" style=" background:#212221; cursor: pointer;
    position: absolute;
    bottom: 85px;
    font-size: 12px;
    right: 12px;
    color: #8c8d8c;"></i>
   <br>


<button type="submit" name="submit">SUBMIT</button>
</div>

</form>
</div>
   
  <?php
}?> 
<script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.js"></script>
   <script src="js/popper.min.js" type="text/javascript"></script>
     <script src="js/plugins.js" type="text/javascript"></script>
     <script src="js/main.js" type="text/javascript"></script>
     <script type="text/javascript">
          (function(){
 $("#btn1").on("click", function() {
   $(".user-detail-drpdwn").fadeToggle( "fast", "linear" ).css('display', 'flex');
 }); 
})();
const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#id_password');

  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});
     </script>
</body>
</html>