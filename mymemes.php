
<?php
 require('head.php');
 require('db_connect.php');
 session_start();

 $image_up='';
 $user_id = $_SESSION['user_id'];
 $user_name =$_SESSION['user_name'];
if(!isset($user_id)){
    header('location:login.php');
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
<div class="images">
    <div class="container">
        <h1 class="img-heading">My Memes</h1>
        <div class="img-data">
            <?php
              $query= mysqli_query($conn, "select * from createdmemes where filter='$user_name'");
              $i=0;
              while($row=mysqli_fetch_assoc($query)){$i++;
                $image=$row['memes'];
                 $id=$row['id'];
               echo "<div class='img-con'> 
               <div class='contain'>
                <div class='hidden' method='post' ><a class='red' href='delete.php?id=".$row['id']."'>Delete</a></div>
               <img id='largeimg".$i."'   src=memescreated/".$row['memes']." alt='img not found'  ></div>
               
               <div style='display:flex; gap:15px;'>
               <a    onClick='swipe".$i."();' class='inactive btn-nav' >Preview</a>
               <a class='inactive btn-nav' href='download.php?file=$image '>Download</a>
               </div>
               </div>";
               echo '<script>function swipe'.$i.'() {
                var largeImage = document.getElementById(\'largeimg'.$i.'\');
                largeImage.style.display = \'block\';
                var url=largeImage.getAttribute(\'src\');
                window.open(url,\'Image\',\'width=largeImage.stylewidth,height=largeImage.style.height,resizable=1\');
             }
             </script>';}
             
            ?>
            
            
        </div>
       
            
    </div>
</div>
    
    
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
      </script>
</body>
</html>