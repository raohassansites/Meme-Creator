
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
<?php
if (isset($_POST["upload"])) {
    // Get Image Dimension
   
    $image_up = $_FILES["file-input"]["name"];
    $fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    
    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );
    
    // Get image file extension
    $file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);
    
    // Validate file input to check if is not empty
    if (! file_exists($_FILES["file-input"]["tmp_name"])) {
        $response = array(
            "type" => "error",
            "message" => "Choose image file to upload."
        );
    }    // Validate file input to check if is with valid extension
    else if (! in_array($file_extension, $allowed_image_extension)) {
        $response = array(
            "type" => "error",
            "message" => "Upload valiid images. Only PNG and JPEG are allowed."
        );
        echo $result;
    }    // Validate image file size
    else if (($_FILES["file-input"]["size"] > 2000000)) {
        $response = array(
            "type" => "error",
            "message" => "Image size exceeds 2MB"
        );
    }    // Validate image file dimension
    else if ($width > "540" || $height > "300") {
        $response = array(
            "type" => "error",
            "message" => "Image dimension should be within 540X300"
        );
    } else {
        $target = "upload/" . basename($_FILES["file-input"]["name"]);
        if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {
            $response = array(
                "type" => "success",
                "message" => "Image uploaded successfully."
            );
            $sql = "INSERT INTO uploads (username , image_up) VALUES ('$user_name' , '$image_up')";
 
            //     // Execute query
           mysqli_query($conn, $sql);
        } else {
            $response = array(
                "type" => "error",
                "message" => "Problem in uploading image files."
            );
        }
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
<div class="images">
    <div class="container">
        <h1 class="img-heading">Meme Templates</h1>
        <div class="img-data">
            <?php
              $query= mysqli_query($conn, "select * from images");
              $i=0;
              while($row=mysqli_fetch_assoc($query)){$i++;
              
               echo " <a href='editor.php?id=".$row['id']."'><img id='' src=".$row['url']." alt='img not found'  ></a>  ";}

            ?>
            
            
        </div>
        <form id="frm-image-upload" action="index.php" class="img-upload" name='img'
        method="post" enctype="multipart/form-data">
        <div class="form-row" style='    display: flex;
    gap: 40px;
    align-items: center;'>
            <div class="img-heading" style='    margin-bottom: 0px;'>Choose Image file:</div>
            <div>
                <input type="file" required class="file-input" name="file-input">
            </div>
        </div>

        <div class="button-row">
            <input class="btn-nav inactive" type="submit" id="btn-submit" name="upload"
                value="Upload">
        </div>
    </form>
    <?php if(!empty($response)) { ?>
    <div class="response <?php echo $response["type"]; ?>"><?php echo $response["message"]; ?></div>
    <?php }?>
        <h1 class="img-heading">My Uploads</h1>
        <div class="img-data">
            <?php
              $queri= mysqli_query($conn, "select * from uploads where username='$user_name'");
              $i=0;
              while($row=mysqli_fetch_assoc($queri)){$i++;
              
               echo " <a href='editor.php?id=".$row['id']."'><img src=upload/".$row['image_up']." alt='img not found'> </a> ";}

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